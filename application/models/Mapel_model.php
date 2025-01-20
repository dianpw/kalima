<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* UJIAN ONLINE
* Dian Purwanto
* dianpw6901@gmail.com

*/
class Mapel_model extends CI_Model{
	public $table = 'mapel';
	
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

    function count_by_mapel_modul($mapel, $modul){
        $this->db->select('COUNT(*) AS hasil')
                 ->where('(id_mapel="'.$modul.'" AND nama="'.$mapel.'")')
                 ->from($this->table);
        return $this->db->get();
    }
	
	function get_by_kolom($kolom, $isi){
        $this->db->where($kolom, $isi)
                 ->from($this->table);
        return $this->db->get();
    }

    function get_by_kolom_join_modul($kolom, $isi){
        $this->db->select('mapel.*, modul.*, mapel.nama AS mapel_nama, modul.nama AS modul_nama')
                 ->join('modul', 'mapel.id_modul = modul.id_modul')
                 ->from($this->table)
                 ->where($kolom, $isi);
        return $this->db->get();
    }

    function get_all(){
        $this->db->from($this->table)
                 ->order_by('id_mapel', 'ASC');
        return $this->db->get();
    }
	
	function get_by_kolom_limit($kolom, $isi, $limit){
        $this->db->where($kolom, $isi)
                 ->from($this->table)
				 ->limit($limit);
        return $this->db->get();
    }
	
	function get_datatable($start, $rows, $kolom, $isi, $modul){
		$this->db->where($kolom.' LIKE "%'.$isi.'%" AND id_modul ="'.$modul.'"')
                 ->from($this->table)
				 ->order_by($kolom, 'ASC')
                 ->limit($rows, $start);
        return $this->db->get();
	}
    
    function get_datatable_count($kolom, $isi, $modul){
		$this->db->select('COUNT(*) AS hasil')
                 ->where($kolom.' LIKE "%'.$isi.'%" AND id_modul ="'.$modul.'"')
                 ->from($this->table);
        return $this->db->get();
	}
}