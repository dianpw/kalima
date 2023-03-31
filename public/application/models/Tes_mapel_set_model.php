<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Class ini digunakan untuk menyimpan detail soal yang akan digunakan
 */
class Tes_mapel_set_model extends CI_Model{
	public $table = 'tes_mapel_set';
	
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
        $this->db->select('COUNT('.$kolom.') AS hasil')
                 ->where($kolom, $isi)
                 ->from($this->table);
        return $this->db->get();
    }

    function count_by_test_mapel($id_tes, $mapel){
        $this->db->select('COUNT(*) AS hasil')
                 ->where('id_tes="'.$id_tes.'" AND id_mapel="'.$mapel.'"')
                 ->from($this->table);
        return $this->db->get();
    }
	
	function get_by_kolom($kolom, $isi){
        $this->db->select('id_tes_mapel_set, id_tes, id_mapel, tipe, difficulty, jumlah, jawaban, acak_jawaban, acak_soal')
                 ->where($kolom, $isi)
                 ->from($this->table);
        return $this->db->get();
    }
	
	function get_by_kolom_limit($kolom, $isi, $limit){
        $this->db->where($kolom, $isi)
                 ->from($this->table)
				 ->limit($limit);
        return $this->db->get();
    }
	
	function get_datatable($start, $rows, $id_tes){
		$this->db->where('(id_tes="'.$id_tes.'")')
                 ->from($this->table)
				 ->order_by('id_tes_mapel_set', 'ASC')
                 ->limit($rows, $start);
        return $this->db->get();
	}
    
    function get_datatable_count($id_tes){
		$this->db->select('COUNT(*) AS hasil')
                 ->where('(id_tes="'.$id_tes.'")')
                 ->from($this->table);
        return $this->db->get();
	}
}