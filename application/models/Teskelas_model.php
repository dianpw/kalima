<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* UJIAN ONLINE
* Dian Purwanto
* dianpw6901@gmail.com

*/
class Teskelas_model extends CI_Model{
	public $table = 'tes_grup';
	
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

    function count_by_tes_and_group($tes, $group){
        $this->db->select('COUNT(*) AS hasil')
                 ->where('(tstkls_tes_id="'.$tes.'" AND tstkls_kelas_id="'.$group.'" )')
                 ->from($this->table);
        return $this->db->get();
    }
	
	function get_by_kolom($kolom, $isi){
        $this->db->where($kolom, $isi)
                 ->from($this->table);
        return $this->db->get();
    }
	
	function get_by_tes_id($id_tes){
        $this->db->where('tstkls_tes_id', $id_tes)
				 ->join('kelas', 'tes_grup.tstkls_kelas_id = kelas.id_kelas')
                 ->from($this->table);
        return $this->db->get();
    }
	
	function get_by_kolom_limit($kolom, $isi, $limit){
        $this->db->where($kolom, $isi)
                 ->from($this->table)
				 ->limit($limit);
        return $this->db->get();
    }

    function get_by_tanggal($tglawal, $tglakhir){
        $this->db->where('(DATE(begin_time)>="'.$tglawal.'" AND DATE(begin_time)<="'.$tglakhir.'")')
                 ->join('tes', 'tes_grup.tstkls_tes_id = tes.id_tes')
                 ->order_by('begin_time ASC, tes.nama ASC')
                 ->from($this->table);
        return $this->db->get();
    }
	
	function get_by_tanggal_and_grup($tglawal, $tglakhir, $id_kelas){
        $this->db->where('(DATE(begin_time)>="'.$tglawal.'" AND DATE(begin_time)<="'.$tglakhir.'" AND tstkls_kelas_id="'.$id_kelas.'")')
                 ->join('tes', 'tes_grup.tstkls_tes_id = tes.id_tes')
                 ->order_by('begin_time ASC, tes.nama ASC')
                 ->from($this->table);
        return $this->db->get();
    }
	
	function get_datatable($start, $rows, $id_kelas){
		$this->db->where('(tstkls_kelas_id="'.$id_kelas.'" AND begin_time<=NOW() AND end_time>=NOW())')
                 ->from($this->table)
                 ->join('tes', 'tes_grup.tstkls_tes_id = tes.id_tes')
                 ->order_by('begin_time ASC, tes.nama ASC')
                 ->limit($rows, $start);
        return $this->db->get();
	}
    
    function get_datatable_count($id_kelas){
		$this->db->select('COUNT(*) AS hasil')
                 ->where('(tstkls_kelas_id="'.$id_kelas.'" AND begin_time<=NOW() AND end_time>=NOW())')
                 ->join('tes', 'tes_grup.tstkls_tes_id = tes.id_tes')
                 ->from($this->table);
        return $this->db->get();
	}
}