<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tes_soal_model extends CI_Model{
	public $table = 'tes_soal';
	
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

    function count_by_tesuser_dijawab($id_tes_siswa){
        $this->db->select('COUNT(*) AS hasil')
                 ->where('id_tes_siswa="'.$id_tes_siswa.'" AND change_time!=""')
                 ->from($this->table);
        return $this->db->get();
    }

    function count_by_tesuser_blum_dijawab($id_tes_siswa){
        $this->db->select('COUNT(*) AS hasil')
                 ->where('id_tes_siswa="'.$id_tes_siswa.'" AND change_time IS NUlL')
                 ->from($this->table);
        return $this->db->get();
    }
	
	function get_by_kolom($kolom, $isi){
        $this->db->where($kolom, $isi)
                 ->from($this->table);
        return $this->db->get();
    }

    function get_by_testuser($id_tes_siswa){
        $this->db->where('id_tes_siswa="'.$id_tes_siswa.'"')
                 ->join('soal', 'tes_soal.id_soal = soal.id_soal')
                 ->from($this->table)
                 ->order_by('order', 'ASC');
        return $this->db->get();
    }
	
	function get_by_testuser_order_soal($id_tes_siswa){
        $this->db->where('id_tes_siswa="'.$id_tes_siswa.'"')
                 ->join('soal', 'tes_soal.id_soal = soal.id_soal')
                 ->from($this->table)
                 ->order_by('id_soal', 'ASC');
        return $this->db->get();
    }

    function get_by_testuser_select($id_tes_siswa, $mapel, $select){
        $this->db->select($select)
                 ->where('id_tes_siswa="'.$id_tes_siswa.'" AND id_mapel="'.$mapel.'"')
                 ->join('soal', 'tes_soal.id_soal = soal.id_soal')
                 ->from($this->table)
                 ->order_by('order', 'ASC');
        return $this->db->get();
    }

    function get_by_testuser_limit($id_tes_siswa, $limit){
        $this->db->where('tes_soal.id_tes_siswa="'.$id_tes_siswa.'"')
                 ->join('soal', 'tes_soal.id_soal = soal.id_soal')
                 ->from($this->table)
                 ->order_by('order', 'ASC')
                 ->limit($limit);
        return $this->db->get();
    }

    function get_by_tessoal_limit($id_tes_soal, $limit){
        $this->db->select('id_tes_soal,id_tes_siswa,user_ip,tes_soal.id_soal,jawaban_text,nilai,ragu,date_created,display_time,change_time,reaction_time,order,num_answers,comment,id_mapel,detail,tipe,kunci,difficulty,aktif,audio,soal.audio_play,timer,inline_answers,auto_next')
                 ->where('id_tes_soal="'.$id_tes_soal.'"')
                 ->join('soal', 'tes_soal.id_soal = soal.id_soal')
                 ->from($this->table)
                 ->limit($limit);
        return $this->db->get();
    }
	
	function get_by_kolom_limit($kolom, $isi, $limit){
        $this->db->where($kolom, $isi)
                 ->from($this->table)
				 ->limit($limit);
        return $this->db->get();
    }

    function get_nilai($id){
        $sql = 'SELECT SUM(nilai) AS hasil, COUNT(CASE  WHEN nilai=0 THEN 1 END) AS jawaban_salah, COUNT(*) AS total_soal FROM tes_soal WHERE id_tes_siswa="'.$id.'"';
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
	function get_datatable($start, $rows, $kolom, $isi, $id_tes_siswa){
		$this->db->where('('.$kolom.' LIKE "%'.$isi.'%" AND id_tes_siswa="'.$id_tes_siswa.'")')
                 ->from($this->table)
                 ->join('soal', 'tes_soal.id_soal = soal.id_soal')
				 ->order_by('order', 'ASC')
                 ->limit($rows, $start);
        return $this->db->get();
	}
    
    function get_datatable_count($kolom, $isi, $id_tes_siswa){
		$this->db->select('COUNT(*) AS hasil')
                 ->where('('.$kolom.' LIKE "%'.$isi.'%" AND id_tes_siswa="'.$id_tes_siswa.'")')
                 ->join('soal', 'tes_soal.id_soal = soal.id_soal')
                 ->from($this->table);
        return $this->db->get();
	}
}