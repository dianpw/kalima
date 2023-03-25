<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tes_model extends CI_Model{
	public $table = 'tes';
	
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
    
    function count_by_kolom($kolom, $isi){
        $this->db->select('COUNT(*) AS hasil')
                 ->where($kolom, $isi)
                 ->from($this->table);
        return $this->db->get();
    }
	
	function get_by_kolom($kolom, $isi){
        $this->db->where($kolom, $isi)
                 ->from($this->table);
        return $this->db->get();
    }

    function get_by_tanggal($tglawal, $tglakhir){
        $this->db->where('(DATE(begin_time)>="'.$tglawal.'" AND DATE(begin_time)<="'.$tglakhir.'")')
                 ->from($this->table);
        return $this->db->get();
    }
	
	function get_by_now(){
        $this->db->where('(DATE(begin_time)<=DATE(NOW()) AND DATE(end_time)>=DATE(NOW()))')
                 ->from($this->table)
				 ->order_by('id_tes', 'ASC');
        return $this->db->get();
    }
	
	function get_by_kolom_limit($kolom, $isi, $limit){
        $this->db->select('id_tes,nama,detail,begin_time,end_time,duration_time,ip_range,results_to_users, score_right, score_wrong, score_unanswered, max_score, token')
                 ->where($kolom, $isi)
                 ->from($this->table)
				 ->limit($limit);
        return $this->db->get();
    }
	
	function get_datatable($start, $rows, $kolom, $isi){
		$this->db->where('('.$kolom.' LIKE "%'.$isi.'%")')
                 ->from($this->table)
				 ->order_by('id_tes', 'DESC')
                 ->limit($rows, $start);
        return $this->db->get();
	}
    
    function get_datatable_count($kolom, $isi){
		$this->db->select('COUNT(*) AS hasil')
                 ->where('('.$kolom.' LIKE "%'.$isi.'%")')
                 ->from($this->table);
        return $this->db->get();
	}
}