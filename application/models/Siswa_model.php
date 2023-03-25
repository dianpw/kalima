<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* UJIAN ONLINE
* Dian Purwanto
* dianpw6901@gmail.com

*/
class Siswa_model extends CI_Model{
	public $table = 'siswa';
	
	function __construct(){
        parent::__construct();
    }
	
    function save($data){
        $this->db->insert($this->table, $data);
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
	
	function get_by_kolom($kolom, $isi){
        $this->db->select('id_siswa,id_kelas,nis,password,nama,user_detail,date_created')
                 ->where($kolom, $isi)
                 ->from($this->table);
        return $this->db->get();
    }
	
	function get_by_kolom_limit($kolom, $isi, $limit){
        $this->db->select('id_siswa,id_kelas,nis,password,nama,user_detail,date_created')
                 ->where($kolom, $isi)
                 ->from($this->table)
				 ->limit($limit);
        return $this->db->get();
    }

    function count_by_username_password($username, $password){
        $this->db->select('COUNT(*) AS hasil')
                 ->where('(nis="'.$username.'" AND password="'.$password.'")')
                 ->from($this->table);
        return $this->db->get()->row()->hasil;  
    }

    function get_by_username($username){
        $this->db->join('kelas', 'siswa.id_kelas = kelas.id_kelas')
                 ->where('nis',$username)
                 ->limit(1);
        $query = $this->db->get($this->table);
        return ($query->num_rows() > 0) ? $query->row() : FALSE;
    }
	
	function get_datatable($start, $rows, $kolom, $isi, $kelas){
        $query = '';
        if($kelas!='semua'){
            $query = 'AND id_kelas="'.$kelas.'"';
        }
		$this->db->where('('.$kolom.' LIKE "%'.$isi.'%" '.$query.')')
                 ->from($this->table)
				 ->order_by($kolom, 'ASC')
                 ->limit($rows, $start);
        return $this->db->get();
	}
    
    function get_datatable_count($kolom, $isi, $kelas){
        $query = '';
        if($kelas!='semua'){
            $query = 'AND id_kelas="'.$kelas.'"';
        }
		$this->db->select('COUNT(*) AS hasil')
                 ->where('('.$kolom.' LIKE "%'.$isi.'%" '.$query.')')
                 ->from($this->table);
        return $this->db->get();
	}
	
	/**
	* export data user yang belum mengerjakan
	*/
	function get_by_tes_group_urut_tanggal($id_tes, $id_kelas, $urutkan, $tanggal, $keterangan){
        $sql = 'tes_begin_time>="'.$tanggal[0].'" AND tes_end_time<="'.$tanggal[1].'" AND id_tes_siswa IS NULL';
		
        if($id_tes!='semua'){
            $sql = $sql.' AND id_tes="'.$id_tes.'"';
        }
        if($id_kelas!='semua'){
            $sql = $sql.' AND id_kelas="'.$id_kelas.'"';
        }
        $order = '';
        if($urutkan=='nama'){
            $order = 'nama ASC';
        }else if($urutkan=='waktu'){
            $order = 'tes_begin_time DESC';
        }else{
            $order = 'id_tes ASC';
        }
		
		if(!empty($keterangan)){
			$sql = $sql.' AND user_detail LIKE "%'.$keterangan.'%"';
		}
				 
		$this->db->select('tes.*,kelas.kelas, tes.*, siswa.*, "0" AS nilai, "Belum mengerjakan" AS tesuser_creation_time')
                 ->where('( '.$sql.' )')
                 ->from($this->table)
                 ->join('kelas', 'siswa.id_kelas = kelas.id_kelas')
				 ->join('tes_grup', 'tes_grup.tstkls_kelas_id = kelas.id_kelas')
                 ->join('tes', 'tes_grup.tstkls_tes_id = tes.id_tes')
				 ->join('tes_siswa', '(tes_siswa.id_tes = tes.id_tes) AND (tes_siswa.id_siswa = siswa.id_siswa)', 'left')
				 ->order_by($order);
        return $this->db->get();
    }
	
	/**
	* datatable untuk hasil tes yang belum mengerjakan
	*
	*/
	function get_datatable_hasiltes($start, $rows, $id_tes, $id_kelas, $urutkan, $tanggal, $keterangan, $search){
        $sql = 'tes_begin_time>="'.$tanggal[0].'" AND tes_end_time<="'.$tanggal[1].'" AND id_tes_siswa IS NULL AND nama LIKE "%'.$search.'%"';
		
        if($id_tes!='semua'){
            $sql = $sql.' AND id_tes="'.$id_tes.'"';
        }
        if($id_kelas!='semua'){
            $sql = $sql.' AND id_kelas="'.$id_kelas.'"';
        }
        $order = '';
        if($urutkan=='nama'){
            $order = 'nama ASC';
        }else if($urutkan=='waktu'){
            $order = 'tes_begin_time DESC';
        }else{
            $order = 'id_tes ASC';
        }
		
		if(!empty($keterangan)){
			$sql = $sql.' AND user_detail LIKE "%'.$keterangan.'%"';
		}

		$this->db->select('tes.*,kelas.kelas, tes.*, siswa.*, "0" AS nilai')
                 ->where('( '.$sql.' )')
                 ->from($this->table)
                 ->join('kelas', 'siswa.id_kelas = kelas.id_kelas')
				 ->join('tes_grup', 'tes_grup.tstkls_kelas_id = kelas.id_kelas')
                 ->join('tes', 'tes_grup.tstkls_tes_id = tes.id_tes')
				 ->join('tes_siswa', '(tes_siswa.id_tes = tes.id_tes) AND (tes_siswa.id_siswa = siswa.id_siswa)', 'left')
				 ->order_by($order)
                 ->limit($rows, $start);
        return $this->db->get();
	}
    
    function get_datatable_hasiltes_count($id_tes, $id_kelas, $urutkan, $tanggal, $keterangan, $search){
        $sql = '(tes_begin_time>="'.$tanggal[0].'" AND tes_end_time<="'.$tanggal[1].'") AND id_tes_siswa IS NULL AND nama LIKE "%'.$search.'%"';
		
        if($id_tes!='semua'){
            $sql = $sql.' AND id_tes="'.$id_tes.'"';
        }
        if($id_kelas!='semua'){
            $sql = $sql.' AND id_kelas="'.$id_kelas.'"';
        }
		
		if(!empty($keterangan)){
			$sql = $sql.' AND user_detail LIKE "%'.$keterangan.'%"';
		}

		$this->db->select('COUNT(*) AS hasil')
                 ->where('( '.$sql.' )')
                 ->join('kelas', 'siswa.id_kelas = kelas.id_kelas')
				 ->join('tes_grup', 'tes_grup.tstkls_kelas_id = kelas.id_kelas')
                 ->join('tes', 'tes_grup.tstkls_tes_id = tes.id_tes')
				 ->join('tes_siswa', '(tes_siswa.id_tes = tes.id_tes) AND (tes_siswa.id_siswa = siswa.id_siswa)', 'left')
                 ->from($this->table);
        return $this->db->get();
	}
}