<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tes_soal_jawaban_model extends CI_Model{
	public $table = 'tes_soal_jawaban';
	
	function __construct(){
        parent::__construct();
    }
	
    function save($data){
        $this->db->insert($this->table, $data);
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

    function update_by_tessoal_answer($id_tes_soal, $id_jawaban, $data){
        $this->db->where('id_tes_soal="'.$id_tes_soal.'" AND id_jawaban="'.$id_jawaban.'"')
                 ->update($this->table, $data);
    }

    function update_by_tessoal_answer_salah($id_tes_soal, $id_jawaban, $data){
        $this->db->where('id_tes_soal="'.$id_tes_soal.'" AND id_jawaban!="'.$id_jawaban.'"')
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
	
	function get_by_kolom_limit($kolom, $isi, $limit){
        $this->db->where($kolom, $isi)
                 ->from($this->table)
				 ->limit($limit);
        return $this->db->get();
    }

    function get_by_tessoal($id_tes_soal){
        $this->db->where('id_tes_soal="'.$id_tes_soal.'"')
                 ->from($this->table)
                 ->join('jawaban', 'tes_soal_jawaban.id_jawaban = jawaban.id_jawaban')
                 ->order_by('order', 'ASC');
        return $this->db->get();
    }

    function get_by_tessoal_answer($id_tes_soal, $id_jawaban){
        $this->db->where('id_tes_soal="'.$id_tes_soal.'" AND id_jawaban="'.$id_jawaban.'"')
                 ->from($this->table)
                 ->join('jawaban', 'tes_soal_jawaban.id_jawaban = jawaban.id_jawaban')
                 ->limit(1);
        return $this->db->get();
    }
	
	function get_datatable($start, $rows, $kolom, $isi){
		$this->db->where('('.$kolom.' LIKE "%'.$isi.'%")')
                 ->from($this->table)
				 ->order_by($kolom, 'ASC')
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