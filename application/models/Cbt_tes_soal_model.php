<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cbt_tes_soal_model extends CI_Model{
	public $table = 'cbt_tes_soal';
	
	function __construct(){
        parent::__construct();
    }
	
    function save($data){
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    function save_batch($data){
        //$this->db->query($sql);
        $this->db->insert_batch($this->table, $data);
    }
    
    function delete($kolom, $isi){
        $this->db->where($kolom, $isi)
                 ->delete($this->table);
    }
    
    function update($kolom, $isi, $data){
        $this->db->where($kolom, $isi)
                 ->update($this->table, $data);
    }
    
    function count_by_kolom($kolom, $isi){
        $this->db->select('COUNT(*) AS hasil')
                 ->where($kolom, $isi)
                 ->from($this->table);
        return $this->db->get();
    }

    function count_by_tesuser_dijawab($tesuser_id){
        $this->db->select('COUNT(*) AS hasil')
                 ->where('tessoal_tesuser_id="'.$tesuser_id.'" AND tessoal_change_time!=""')
                 ->from($this->table);
        return $this->db->get();
    }

    function count_by_tesuser_blum_dijawab($tesuser_id){
        $this->db->select('COUNT(*) AS hasil')
                 ->where('tessoal_tesuser_id="'.$tesuser_id.'" AND tessoal_change_time IS NUlL')
                 ->from($this->table);
        return $this->db->get();
    }
	
	function get_by_kolom($kolom, $isi){
        $this->db->where($kolom, $isi)
                 ->from($this->table);
        return $this->db->get();
    }

    function get_by_testuser($tesuser_id){
        $this->db->where('tessoal_tesuser_id="'.$tesuser_id.'"')
                 ->join('cbt_soal', 'cbt_tes_soal.tessoal_soal_id = cbt_soal.soal_id')
                 ->from($this->table)
                 ->order_by('tessoal_order', 'ASC');
        return $this->db->get();
    }
	
	function get_by_testuser_order_soal($tesuser_id){
        $this->db->where('tessoal_tesuser_id="'.$tesuser_id.'"')
                 ->join('cbt_soal', 'cbt_tes_soal.tessoal_soal_id = cbt_soal.soal_id')
                 ->from($this->table)
                 ->order_by('soal_id', 'ASC');
        return $this->db->get();
    }

    function get_by_testuser_select($tesuser_id, $topik, $select){
        $this->db->select($select)
                 ->where('tessoal_tesuser_id="'.$tesuser_id.'" AND soal_topik_id="'.$topik.'"')
                 ->join('cbt_soal', 'cbt_tes_soal.tessoal_soal_id = cbt_soal.soal_id')
                 ->from($this->table)
                 ->order_by('tessoal_order', 'ASC');
        return $this->db->get();
    }

    function get_by_testuser_limit($tesuser_id, $limit){
        $this->db->where('tessoal_tesuser_id="'.$tesuser_id.'"')
                 ->join('cbt_soal', 'cbt_tes_soal.tessoal_soal_id = cbt_soal.soal_id')
                 ->from($this->table)
                 ->order_by('tessoal_order', 'ASC')
                 ->limit($limit);
        return $this->db->get();
    }

    function get_by_tessoal_limit($tessoal_id, $limit){

        $this->db->select('tessoal_id,tessoal_tesuser_id,tessoal_user_ip,tessoal_soal_id,tessoal_jawaban_text,tessoal_nilai,tessoal_ragu,tessoal_creation_time,tessoal_display_time,tessoal_change_time,tessoal_reaction_time,tessoal_order,tessoal_num_answers,tessoal_comment,tessoal_audio_play,soal_id,soal_topik_id,soal_detail,soal_tipe,soal_kunci,soal_difficulty,soal_aktif,soal_audio,soal_audio_play,soal_timer,soal_inline_answers,soal_auto_next')
                 ->where('tessoal_id="'.$tessoal_id.'"')
                 ->join('cbt_soal', 'cbt_tes_soal.tessoal_soal_id = cbt_soal.soal_id')
                 ->from($this->table)
                 ->order_by('soal_tipe', 'ASC')
                 ->limit($limit);
        return $this->db->get();
    }
	
	function get_by_kolom_limit($kolom, $isi, $limit){
        $this->db->where($kolom, $isi)
                 ->from($this->table)
				 ->limit($limit);
        return $this->db->get();
    }

    function get_nilai($tessoal_id){
        //$sql = 'SELECT SUM(tessoal_nilai) AS hasil, COUNT(CASE  WHEN tessoal_nilai=0 THEN 1 END) AS jawaban_salah, COUNT(*) AS total_soal FROM cbt_tes_soal WHERE tessoal_tesuser_id="'.$tessoal_id.'"';

        //$sql = 'SELECT ROUND(((SUM(IF(cbt_soal.soal_tipe=1,tessoal_nilai,0))/COUNT(CASE WHEN cbt_soal.soal_tipe=1 THEN soal_topik_id END)*0.6)+(SUM(IF(cbt_soal.soal_tipe=2,tessoal_nilai,0))/(COUNT(CASE WHEN cbt_soal.soal_tipe=2 THEN soal_topik_id END)+COUNT(CASE WHEN cbt_soal.soal_tipe=3 THEN soal_topik_id END))+SUM(IF(cbt_soal.soal_tipe=3,tessoal_nilai,0))/(COUNT(CASE WHEN cbt_soal.soal_tipe=2 THEN soal_topik_id END)+COUNT(CASE WHEN cbt_soal.soal_tipe=3 THEN soal_topik_id END))*0.4))*100,0) AS hasil, COUNT(CASE WHEN tessoal_nilai=0 THEN 1 END) AS jawaban_salah, COUNT(*) AS total_soal FROM cbt_tes_soal INNER JOIN cbt_soal ON cbt_tes_soal.tessoal_soal_id=cbt_soal.soal_id WHERE tessoal_tesuser_id="'.$tessoal_id.'"';

        $total_soal = $this->db->query('SELECT COUNT(*) AS total_soal FROM cbt_tes_soal WHERE tessoal_tesuser_id="'.$tessoal_id.'"')->row()->total_soal;
        
        $pilgan = $this->db->query('SELECT COUNT(CASE WHEN cbt_soal.soal_tipe=1 THEN soal_topik_id END) AS pilgan FROM cbt_tes_soal JOIN cbt_soal ON cbt_tes_soal.tessoal_soal_id=cbt_soal.soal_id WHERE tessoal_tesuser_id="'.$tessoal_id.'"')->row()->pilgan;

        $not_pilgan = $this->db->query('SELECT COUNT(CASE WHEN cbt_soal.soal_tipe!=1 THEN soal_topik_id END) AS not_pilgan FROM cbt_tes_soal JOIN cbt_soal ON cbt_tes_soal.tessoal_soal_id=cbt_soal.soal_id WHERE tessoal_tesuser_id="'.$tessoal_id.'"')->row()->not_pilgan;

        if($total_soal == $pilgan){
            //jika soal terdiri hanya pilihan ganda bobot nilai 100%
            $sql = 'SELECT round(SUM(IF(cbt_soal.soal_tipe=1,tessoal_nilai,0))/'.$total_soal.',2)*100 as hasil, COUNT(CASE WHEN tessoal_nilai=0 THEN 1 END) AS jawaban_salah, COUNT(*) AS total_soal FROM cbt_tes_soal JOIN cbt_soal ON cbt_tes_soal.tessoal_soal_id=cbt_soal.soal_id WHERE tessoal_tesuser_id="'.$tessoal_id.'"';

        }elseif($total_soal == $not_pilgan){
            //jika soal terdiri bukan pilihan ganda bobot nilai 100%
            $sql = 'SELECT round(SUM(IF(cbt_soal.soal_tipe!=1,tessoal_nilai,0))/'.$total_soal.',2)*100 as hasil, COUNT(CASE WHEN tessoal_nilai=0 THEN 1 END) AS jawaban_salah, COUNT(*) AS total_soal FROM cbt_tes_soal JOIN cbt_soal ON cbt_tes_soal.tessoal_soal_id=cbt_soal.soal_id WHERE tessoal_tesuser_id="'.$tessoal_id.'"';
        }else{
            //jika soal terdiri dari pilihan ganda dan esay maka bobot nilai pilgan adalah 60% dan esay 40%
            $sql = 'SELECT round(((SUM(IF(cbt_soal.soal_tipe=1,tessoal_nilai,0))/'.$pilgan.'*0.6) + (SUM(IF(cbt_soal.soal_tipe!=1,tessoal_nilai,0))/'.$not_pilgan.'*0.4))*100,0) as hasil, COUNT(CASE WHEN tessoal_nilai=0 THEN 1 END) AS jawaban_salah, COUNT(*) AS total_soal FROM cbt_tes_soal JOIN cbt_soal ON cbt_tes_soal.tessoal_soal_id=cbt_soal.soal_id WHERE tessoal_tesuser_id="'.$tessoal_id.'"';
        }
        return $this->db->query($sql);
    }
	
    /**
     * Datatable untuk hasil tes detail setiap user
     *
     * @param      <type>  $start  The start
     * @param      <type>  $rows   The rows
     * @param      string  $kolom  The kolom
     * @param      string  $isi    The isi
     *
     * @return     <type>  The datatable.
     */
	function get_datatable($start, $rows, $kolom, $isi, $tesuser_id){
		$this->db->where('('.$kolom.' LIKE "%'.$isi.'%" AND tessoal_tesuser_id="'.$tesuser_id.'")')
                 ->from($this->table)
                 ->join('cbt_soal', 'cbt_tes_soal.tessoal_soal_id = cbt_soal.soal_id')
				 ->order_by('tessoal_order', 'ASC')
                 ->limit($rows, $start);
        return $this->db->get();
	}
    
    function get_datatable_count($kolom, $isi, $tesuser_id){
		$this->db->select('COUNT(*) AS hasil')
                 ->where('('.$kolom.' LIKE "%'.$isi.'%" AND tessoal_tesuser_id="'.$tesuser_id.'")')
                 ->join('cbt_soal', 'cbt_tes_soal.tessoal_soal_id = cbt_soal.soal_id')
                 ->from($this->table);
        return $this->db->get();
	}
}