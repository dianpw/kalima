<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* KALIMA TEST
* Dian Purwanto
* dianpw6901@gmail.com
* 2023.1.31
*/
class Cbt_topik_model extends CI_Model{
	public $table = 'cbt_topik';
	
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

    function count_all(){
        $this->db->select('COUNT(*) AS hasil')
                 ->from($this->table);
        return $this->db->get();
    }
    
    function count_by_kolom($kolom, $isi){
        $this->db->select('COUNT(*) AS hasil')
                 ->where($kolom, $isi)
                 ->from($this->table);
        return $this->db->get();
    }

    function count_by_topik_modul($topik, $modul){
        $this->db->select('COUNT(*) AS hasil')
                 ->where('(topik_modul_id='.$modul.' AND topik_nama="'.$topik.'")')
                 ->from($this->table);
        return $this->db->get();
    }
	
	function get_by_kolom($kolom, $isi){
        $this->db->where($kolom, $isi)
                 ->from($this->table);
        return $this->db->get();
    }

    function get_by_kolom_join_modul($kolom, $isi){
        $this->db->select('cbt_topik.*, cbt_modul.*')
                 ->join('cbt_modul', 'cbt_topik.topik_modul_id = cbt_modul.modul_id')
                 ->from($this->table)
                 ->where($kolom, $isi);
        return $this->db->get();
    }

    function get_all(){
        $this->db->from($this->table)
                 ->order_by('topik_id', 'ASC');
        return $this->db->get();
    }
	
	function get_by_kolom_limit($kolom, $isi, $limit){
        $this->db->where($kolom, $isi)
                 ->from($this->table)
				 ->limit($limit);
        return $this->db->get();
    }
	
	function get_datatable($start, $rows, $kolom, $isi, $modul){        
		$id = $this->users_model->get_login_info($this->session->userdata('cbt_user_id'))->opsi1;
		if($id!=null){
            $data= explode(",",$id);
            $whr='';
            $i=0;
            $x=count($data);
            if($data==""){
            }else{
                foreach($data as $mapel) {
                    $whr .=' topik_id LIKE "'.$mapel.'"';
                    if($i==($x-1)){ 
                    }else{
                        $whr .=' OR ';                
                    }
                    $i++;
                }
            }

        	$sql = '('.$kolom.' LIKE "%'.$isi.'%" AND topik_modul_id="'.$modul.'" AND '.$whr.')';

		}else{
        	$sql = '('.$kolom.' LIKE "%'.$isi.'%" AND topik_modul_id='.$modul.')';
		}

		$this->db->where($sql)
                 ->from($this->table)
				 ->order_by($kolom, 'ASC')
                 ->limit($rows, $start);
        return $this->db->get();
	}
    
    function get_datatable_count($kolom, $isi, $modul){        
		$id = $this->users_model->get_login_info($this->session->userdata('cbt_user_id'))->opsi1;
		if($id!=null){
            $data= explode(",",$id);
            $whr='';
            $i=0;
            $x=count($data);
            if($data==""){
            }else{
                foreach($data as $mapel) {
                    $whr .=' topik_id LIKE "'.$mapel.'"';
                    if($i==($x-1)){ 
                    }else{
                        $whr .=' OR ';                
                    }
                    $i++;
                }
            }

        	$sql = '('.$kolom.' LIKE "%'.$isi.'%" AND topik_modul_id="'.$modul.'" AND '.$whr.')';

		}else{
        	$sql = '('.$kolom.' LIKE "%'.$isi.'%" AND topik_modul_id='.$modul.')';
		}
		$this->db->select('COUNT(*) AS hasil')
                 ->where($sql)
                 ->from($this->table);
        return $this->db->get();
	}
}