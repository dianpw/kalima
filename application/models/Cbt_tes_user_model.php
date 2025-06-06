<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* KALIMA TEST
* Dian Purwanto
* dianpw6901@gmail.com
* 2023.1.31
*/
class Cbt_tes_user_model extends CI_Model{
	public $table = 'cbt_tes_user';
	
	function __construct(){
        parent::__construct();
    }
	
    function save($data){
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    
    function delete($kolom, $isi){
        $this->db->where($kolom, $isi)
                 ->delete($this->table);
    }
    
    function update($kolom, $isi, $data){
        $this->db->where($kolom, $isi)
                 ->update($this->table, $data);
    }

    function update_menit($tesuser_id, $waktu){
        $sql = 'UPDATE cbt_tes_user SET tesuser_creation_time=TIMESTAMPADD(MINUTE, '.$waktu.', tesuser_creation_time) WHERE tesuser_id="'.$tesuser_id.'"';
        $this->db->query($sql);
    }
    
    function count_by_kolom($kolom, $isi){
        $this->db->select('COUNT(*) AS hasil')
                 ->where($kolom, $isi)
                 ->from($this->table);
        return $this->db->get();
    }

    /**
     * menghitung testuser yang masih aktif dengan status==1 dan waktu masih belum habis
     *
     * @param      string  $tesuser_id  The tesuser identifier
     *
     * @return     <type>  Number of by status waktu.
     */
    function count_by_status_waktu($tesuser_id){
        $this->db->select('COUNT(tesuser_id) AS hasil')
                 ->where('(tesuser_id="'.$tesuser_id.'" AND tesuser_status="1" AND TIMESTAMPADD(MINUTE, tes_duration_time, tesuser_creation_time)>NOW())')
                 ->from($this->table)
                 ->join('cbt_tes', 'cbt_tes_user.tesuser_tes_id = cbt_tes.tes_id');
        return $this->db->get();
    }

    /**
     * menghitung testuser yang masih aktif dengan status==1 dan waktu masih belum habis
     * berdasarkan waktu yang php, bukan waktu mysql
     * revisi 2018-11-15
     * @param      string  $tesuser_id  The tesuser identifier
     *
     * @return     <type>  Number of by status waktu.
     */
    function count_by_status_waktuuser($tesuser_id, $waktuuser){
        $this->db->select('COUNT(tesuser_id) AS hasil')
                 ->where('(tesuser_id="'.$tesuser_id.'" AND tesuser_status="1" AND TIMESTAMPADD(MINUTE, tes_duration_time, tesuser_creation_time)>"'.$waktuuser.'")')
                 ->from($this->table)
                 ->join('cbt_tes', 'cbt_tes_user.tesuser_tes_id = cbt_tes.tes_id');
        return $this->db->get();
    }

    function get_by_user_status($user_id){
        $this->db->where('tesuser_user_id="'.$user_id.'" AND tesuser_status!=4')
                 ->from($this->table)
                 ->join('cbt_tes', 'cbt_tes_user.tesuser_tes_id = cbt_tes.tes_id');
        return $this->db->get();
    }

    function get_by_user_tes_limit($user_id, $tes_id){
        $this->db->where('tesuser_user_id="'.$user_id.'" AND tesuser_tes_id="'.$tes_id.'" AND tesuser_status=1')
                 ->from($this->table)
                 ->join('cbt_tes', 'cbt_tes_user.tesuser_tes_id = cbt_tes.tes_id')
                 ->limit(1);
        return $this->db->get();
    }

    function count_by_user_tes($user_id, $tes_id){
        $this->db->select('COUNT(*) AS hasil')
                 ->where('tesuser_user_id="'.$user_id.'" AND tesuser_tes_id="'.$tes_id.'"')
                 ->from($this->table);
        return $this->db->get();
    }

    function count_by_user_tes_selesai($user_id, $tes_id){
        $this->db->select('COUNT(*) AS hasil')
                 ->where('tesuser_user_id="'.$user_id.'" AND tesuser_tes_id="'.$tes_id.'" AND tesuser_status=4')
                 ->from($this->table);
        return $this->db->get();
    }
	
    function get_by_user_tes($user_id, $tes_id){
        $this->db->where('tesuser_user_id="'.$user_id.'" AND tesuser_tes_id="'.$tes_id.'"')
                 ->from($this->table)
                 ->limit(1);
        return $this->db->get();
    }

	function get_by_kolom($kolom, $isi){
        $this->db->where($kolom, $isi)
                 ->from($this->table);
        return $this->db->get();
    }

    function get_by_group(){
        //SELECT cbt_topik.topik_nama, cbt_tes_user.*, cbt_tes.*, cbt_tes_topik_set.* FROM cbt_tes_user JOIN cbt_tes ON cbt_tes.tes_id=cbt_tes_user.tesuser_tes_id JOIN cbt_tes_topik_set ON cbt_tes_topik_set.tset_tes_id=cbt_tes_user.tesuser_tes_id JOIN cbt_topik ON cbt_topik.topik_id=cbt_tes_topik_set.tset_topik_id WHERE tset_topik_id IN (48,54,39,51) GROUP BY tesuser_tes_id ORDER BY tes_id DESC;
        $ids = array();
        $ids = $this->db->select('user.opsi1')->from('user')->where('username', $this->session->userdata('cbt_user_id'));
        $ids = $this->db->get()->row_array();

        if($ids['opsi1']==''){
            $this->db->select('cbt_topik.topik_nama, cbt_tes_user.*, cbt_tes.*, cbt_tes_topik_set.*')
                 ->join('cbt_tes', 'cbt_tes_user.tesuser_tes_id = cbt_tes.tes_id')
                 ->join('cbt_tes_topik_set', 'cbt_tes_topik_set.tset_tes_id=cbt_tes_user.tesuser_tes_id')
                 ->join('cbt_topik', 'cbt_topik.topik_id=cbt_tes_topik_set.tset_topik_id')
                 ->order_by('tes_id', 'DESC')
                 ->group_by('tesuser_tes_id')
                 ->from($this->table);
        }else{
            $this->db->select('cbt_topik.topik_nama, cbt_tes_user.*, cbt_tes.*, cbt_tes_topik_set.*');
            $this->db->from($this->table);
            $this->db->join('cbt_tes', 'cbt_tes.tes_id = cbt_tes_user.tesuser_tes_id');
            $this->db->join('cbt_tes_topik_set', 'cbt_tes_topik_set.tset_tes_id = cbt_tes_user.tesuser_tes_id');
            $this->db->join('cbt_topik', 'cbt_topik.topik_id = cbt_tes_topik_set.tset_topik_id');
            $this->db->where('cbt_tes_topik_set.tset_topik_id IN('.$ids['opsi1'].')');
            $this->db->group_by('tesuser_tes_id');
            $this->db->order_by('tes_id', 'DESC');
        }
        
        
        return $this->db->get();
    }
	
	function get_by_kolom_limit($kolom, $isi, $limit){
        $this->db->where($kolom, $isi)
                 ->from($this->table)
				 ->limit($limit);
        return $this->db->get();
    }

    function get_by_tes_group_urut_tanggal($tes_id, $grup_id, $urutkan, $tanggal, $keterangan){
        $sql = 'tesuser_creation_time>="'.$tanggal[0].'" AND tesuser_creation_time<="'.$tanggal[1].'"';
		
        if($tes_id!='semua'){
            $sql = $sql.' AND tes_id="'.$tes_id.'"';
        }
        if($grup_id!='semua'){
            $sql = $sql.' AND user_grup_id="'.$grup_id.'"';
        }
        $order = '';
        if($urutkan=='tertinggi'){
            $order = 'nilai DESC';
        }else if($urutkan=='terendah'){
            $order = 'nilai ASC';
        }else if($urutkan=='nama'){
            $order = 'user_firstname ASC';
        }else if($urutkan=='waktu'){
            $order = 'tesuser_creation_time DESC';
        }else{
            $order = 'tesuser_tes_id ASC';
        }
		
		if(!empty($keterangan)){
			$sql = $sql.' AND user_detail LIKE "%'.$keterangan.'%"';
		}

        $this->db->select('cbt_tes_user.*, cbt_tes.*, cbt_user.*, cbt_user_grup.grup_nama, SUM(`cbt_tes_soal`.`tessoal_nilai`) AS nilai ')
                 ->where('( '.$sql.' )')
                 ->from($this->table)
                 ->join('cbt_user', 'cbt_tes_user.tesuser_user_id = cbt_user.user_id', 'right')
                 ->join('cbt_user_grup', 'cbt_user.user_grup_id = cbt_user_grup.grup_id')
                 ->join('cbt_tes', 'cbt_tes_user.tesuser_tes_id = cbt_tes.tes_id', 'left')
                 ->join('cbt_tes_soal', 'cbt_tes_soal.tessoal_tesuser_id = cbt_tes_user.tesuser_id', 'left')
                 ->group_by('cbt_tes_user.tesuser_id')
                 ->order_by($order);
        return $this->db->get();
    }
	
	function get_by_tes_group($tes_id, $grup_id){
        $sql = 'tesuser_tes_id="'.$tes_id.'" AND user_grup_id="'.$grup_id.'"';

        $this->db->select('cbt_tes_user.*, cbt_tes.tes_nama, cbt_user.*, cbt_user_grup.grup_nama')
                 ->where('( '.$sql.' )')
                 ->from($this->table)
                 ->join('cbt_user', 'cbt_tes_user.tesuser_user_id = cbt_user.user_id')
                 ->join('cbt_user_grup', 'cbt_user.user_grup_id = cbt_user_grup.grup_id')
                 ->join('cbt_tes', 'cbt_tes_user.tesuser_tes_id = cbt_tes.tes_id')
                 ->order_by('cbt_user.user_firstname', 'ASC');
        return $this->db->get();
    }

    function get_nilai_by_tes_user($tes_id, $user_id){
        $this->db->select('SUM(`cbt_tes_soal`.`tessoal_nilai`) AS nilai')
                 ->where('(tesuser_tes_id="'.$tes_id.'" AND tesuser_user_id="'.$user_id.'")')
                 ->from($this->table)
                 ->join('cbt_tes_soal', 'cbt_tes_soal.tessoal_tesuser_id = cbt_tes_user.tesuser_id');
        return $this->db->get();
    }
	
	/**
	* datatable untuk hasil tes yang sudah mengerjakan
	*
	*/
	function get_datatable($start, $rows, $tes_id, $grup_id, $urutkan, $tanggal, $keterangan, $search){
        //SELECT SUM(IF(cbt_soal.soal_tipe=1,tessoal_nilai,0)) AS hasil1, SUM(IF(cbt_soal.soal_tipe=2,tessoal_nilai,0)) AS hasil2, SUM(IF(cbt_soal.soal_tipe=3,tessoal_nilai,0)) AS hasil3, COUNT(CASE WHEN tessoal_nilai=0 THEN 1 END) AS jawaban_salah, COUNT(*) AS total_soal FROM cbt_tes_soal INNER JOIN cbt_soal ON cbt_tes_soal.tessoal_soal_id=cbt_soal.soal_id WHERE tessoal_tesuser_id=
        $sql = 'tesuser_creation_time>="'.$tanggal[0].'" AND tesuser_creation_time<="'.$tanggal[1].'" AND user_firstname LIKE "%'.$search.'%"';
		
        if($tes_id!='semua'){
            $sql = $sql.' AND tesuser_tes_id="'.$tes_id.'"';
        }
        if($grup_id!='semua'){
            $sql = $sql.' AND user_grup_id="'.$grup_id.'"';
        }
        $order = '';
        if($urutkan=='kelas'){
            $order = 'cbt_user_grup.grup_nama ASC';
        }else if($urutkan=='nama'){
            $order = 'user_firstname ASC';
        }else if($urutkan=='waktu'){
            $order = 'tesuser_creation_time DESC';
        }else{
            $order = 'tesuser_tes_id ASC';
        }
		
		if(!empty($keterangan)){
			$sql = $sql.' AND user_detail LIKE "%'.$keterangan.'%"';
		}
		//$this->db->select('cbt_tes_user.*,cbt_user_grup.grup_nama, cbt_tes.*, cbt_user.*, SUM(`cbt_tes_soal`.`tessoal_nilai`) AS nilai ')
		$this->db->select('cbt_tes_user.*,cbt_user_grup.grup_nama, cbt_tes.*, cbt_user.*')
                 ->where('( '.$sql.' )')
                 ->from($this->table)
                 ->join('cbt_user', 'cbt_tes_user.tesuser_user_id = cbt_user.user_id')
                 ->join('cbt_user_grup', 'cbt_user.user_grup_id = cbt_user_grup.grup_id')
                 ->join('cbt_tes', 'cbt_tes_user.tesuser_tes_id = cbt_tes.tes_id')
                 ->join('cbt_tes_soal', 'cbt_tes_soal.tessoal_tesuser_id = cbt_tes_user.tesuser_id')
                 ->join('cbt_soal', 'cbt_tes_soal.tessoal_soal_id = cbt_soal.soal_id')
                 ->group_by('cbt_tes_user.tesuser_id')
				 ->order_by($order)
                 ->limit($rows, $start);
        return $this->db->get();
	}
    
    function get_datatable_count($tes_id, $grup_id, $urutkan, $tanggal, $keterangan, $search){
        $sql = 'tesuser_creation_time>="'.$tanggal[0].'" AND tesuser_creation_time<="'.$tanggal[1].'" AND user_firstname LIKE "%'.$search.'%"';
		
        if($tes_id!='semua'){
            $sql = $sql.' AND tesuser_tes_id="'.$tes_id.'"';
        }
        if($grup_id!='semua'){
            $sql = $sql.' AND user_grup_id="'.$grup_id.'"';
        }
		
		if(!empty($keterangan)){
			$sql = $sql.' AND user_detail LIKE "%'.$keterangan.'%"';
		}

		$this->db->select('COUNT(*) AS hasil')
                 ->where('( '.$sql.' )')
                 ->join('cbt_user', 'cbt_tes_user.tesuser_user_id = cbt_user.user_id', 'right')
                 ->from($this->table);
        return $this->db->get();
	}

    /**
     * Question Type
     * 1 = ganda
     * 2 = essay
     *
     * @param      <type>  $start   The start
     * @param      <type>  $rows    The rows
     * @param      string  $tes_id  The tes identifier
     * @param      string  $order   The order
     *
     * @return     <type>  The datatable evaluasi.
     */
    function get_datatable_evaluasi($start, $rows, $tes_id, $urutkan, $kelas){
        $sql = '';
        if(!empty($tes_id)){
            $sql = ' AND tesuser_tes_id="'.$tes_id.'"';
        
        }
        if(!empty($kelas)){
            if($kelas=='semua'){

            }else{
                $sql = $sql.' AND cbt_user_grup.grup_id="'.$kelas.'"';
            }
            
        }

        $order = '';
        if($urutkan=='soal'){
            $order = 'tessoal_soal_id ASC';
        }else{
            $order = 'tesuser_id ASC';
        }
        // SELECT cbt_tes_soal.tessoal_id, cbt_tes_user.tesuser_user_id, cbt_user.user_firstname, cbt_user_grup.grup_nama, cbt_user_grup.grup_id, cbt_tes_soal.tessoal_jawaban_text, cbt_tes.*, cbt_soal.* 
        // FROM cbt_tes_user 
        // JOIN cbt_tes ON cbt_tes_user.tesuser_tes_id = cbt_tes.tes_id 
        // JOIN cbt_user ON cbt_user.user_id=cbt_tes_user.tesuser_user_id 
        // JOIN cbt_user_grup ON cbt_user_grup.grup_id=cbt_user.user_grup_id 
        // JOIN cbt_tes_soal ON cbt_tes_soal.tessoal_tesuser_id = cbt_tes_user.tesuser_id 
        // JOIN cbt_soal ON cbt_tes_soal.tessoal_soal_id = cbt_soal.soal_id 
        // WHERE (cbt_soal.soal_tipe="2" AND cbt_tes_user.tesuser_tes_id="15" AND cbt_user_grup.grup_id='117');

        $this->db->select(' cbt_tes_soal.tessoal_id, cbt_tes_user.tesuser_user_id, cbt_user.user_firstname, cbt_user_grup.grup_nama, cbt_user_grup.grup_id, cbt_tes_soal.tessoal_jawaban_text, cbt_tes.*, cbt_soal.*')
                 ->where('(soal_tipe="2" AND tessoal_jawaban_text IS NOT NULL AND tessoal_comment IS NULL '.$sql.' )')
                 ->from($this->table)
                 ->join('cbt_tes', 'cbt_tes_user.tesuser_tes_id = cbt_tes.tes_id')
                 ->join('cbt_user', 'cbt_user.user_id=cbt_tes_user.tesuser_user_id')
                 ->join('cbt_user_grup', 'cbt_user_grup.grup_id=cbt_user.user_grup_id')
                 ->join('cbt_tes_soal', 'cbt_tes_soal.tessoal_tesuser_id = cbt_tes_user.tesuser_id')
                 ->join('cbt_soal', 'cbt_tes_soal.tessoal_soal_id = cbt_soal.soal_id')
                 ->order_by($order)
                 ->limit($rows, $start);
        return $this->db->get();
        
    }
    
    function get_datatable_evaluasi_count($tes, $urutkan, $kelas){
        
		
        $sql = '';
        if(!empty($tes)){
            $sql = ' AND cbt_tes_user.tesuser_tes_id="'.$tes.'"';
        }
        if(!empty($kelas)){
            if($kelas=='semua'){

            }else{
                $sql = $sql.' AND cbt_user_grup.grup_id="'.$kelas.'"';
            }
            
        }
        
        $order = '';
        if($urutkan=='soal'){
            $order = 'tessoal_soal_id ASC';
        }else{
            $order = 'tesuser_id ASC';
        }
        
        $this->db->select('COUNT(cbt_tes_soal.tessoal_jawaban_text) AS hasil')
                ->where('(soal_tipe="2" AND tessoal_jawaban_text IS NOT NULL AND tessoal_comment IS NULL '.$sql.' )')
                ->from($this->table)
                ->join('cbt_tes', 'cbt_tes_user.tesuser_tes_id = cbt_tes.tes_id')
                ->join('cbt_user', 'cbt_user.user_id=cbt_tes_user.tesuser_user_id')
                ->join('cbt_user_grup', 'cbt_user_grup.grup_id=cbt_user.user_grup_id')
                ->join('cbt_tes_soal', 'cbt_tes_soal.tessoal_tesuser_id = cbt_tes_user.tesuser_id')
                ->join('cbt_soal', 'cbt_tes_soal.tessoal_soal_id = cbt_soal.soal_id')
                ->order_by($order);
        return $this->db->get();


    }

    /**
     * Datatable untuk hasil tes operator
     *
     * @param      <type>  $start  The start
     * @param      <type>  $rows   The rows
     * @param      <type>  $token  The token
     *
     * @return     <type>  The datatable.
     */
    function get_datatable_operator($start, $rows, $token){
        //$this->db->select('cbt_tes_user.*,cbt_user_grup.grup_nama, cbt_tes.*, cbt_user.*, SUM(`cbt_tes_soal`.`tessoal_nilai`) AS nilai ')
        $this->db->select('cbt_tes_user.*,cbt_user_grup.grup_nama, cbt_tes.*, cbt_user.*, ROUND(((SUM(IF(cbt_soal.soal_tipe=1,tessoal_nilai,0))/COUNT(CASE WHEN cbt_soal.soal_tipe=1 THEN soal_topik_id END)*0.6)+(SUM(IF(cbt_soal.soal_tipe=2,tessoal_nilai,0))/(COUNT(CASE WHEN cbt_soal.soal_tipe=2 THEN soal_topik_id END)+COUNT(CASE WHEN cbt_soal.soal_tipe=3 THEN soal_topik_id END))+SUM(IF(cbt_soal.soal_tipe=3,tessoal_nilai,0))/(COUNT(CASE WHEN cbt_soal.soal_tipe=2 THEN soal_topik_id END)+COUNT(CASE WHEN cbt_soal.soal_tipe=3 THEN soal_topik_id END))*0.4))*100,0) AS nilai ')
                 ->where('(tesuser_token IN ('.$token.'))')
                 ->from($this->table)
                 ->join('cbt_user', 'cbt_tes_user.tesuser_user_id = cbt_user.user_id')
                 ->join('cbt_user_grup', 'cbt_user.user_grup_id = cbt_user_grup.grup_id')
                 ->join('cbt_tes', 'cbt_tes_user.tesuser_tes_id = cbt_tes.tes_id')
                 ->join('cbt_tes_soal', 'cbt_tes_soal.tessoal_tesuser_id = cbt_tes_user.tesuser_id')
                 ->join('cbt_soal', 'cbt_tes_soal.tessoal_soal_id = cbt_soal.soal_id')
                 ->group_by('cbt_tes_user.tesuser_id')
                 ->order_by('tesuser_creation_time DESC')
                 ->limit($rows, $start);
        return $this->db->get();
    }
    
    function get_datatable_operator_count($token){
        $this->db->select('COUNT(*) AS hasil')
                 ->where('(tesuser_token IN ('.$token.'))')
                 ->from($this->table);
        return $this->db->get();
    }
}