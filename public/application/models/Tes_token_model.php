<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tes_token_model extends CI_Model{
	public $table = 'token';
	
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

    function delete_by_user_date($id_user){
        $this->db->where('DATE(date_created)<DATE(NOW()) AND id_user="'.$id_user.'"')
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

    function count_by_isi($isi){
        $this->db->select('COUNT(*) AS hasil')
                 ->where('token="'.$isi.'" AND DATE(date_created)=DATE(NOW())')
                 ->from($this->table);
        return $this->db->get();
    }
	
	function get_by_kolom($kolom, $isi){
        $this->db->select('id_token,token,id_user,date_created,aktif')
                 ->where($kolom, $isi)
                 ->from($this->table);
        return $this->db->get();
    }

    /**
     * Mendapatkan token berdasarkan token dan tanggal hari ini
     */
    function get_by_token_now_limit($token, $limit){
        $this->db->select('id_token,token,id_user,date_created,aktif,id_tes')
                 ->where('(token="'.$token.'" AND DATE(date_created)=DATE(NOW()))')
                 ->from($this->table)
				 ->limit($limit);
        return $this->db->get();
    }

    // Mendapatkan jumlah token berdasarkan lifetime token yang sudah di generate
    function count_by_token_lifetime($token, $lifetime){
        $this->db->select('COUNT(*) AS hasil')
                 ->where('token="'.$token.'" AND date_created>TIMESTAMPADD(MINUTE,-'.$lifetime.',NOW())')
                 ->from($this->table);
        return $this->db->get();
    }
	
	function get_by_kolom_limit($kolom, $isi, $limit){
        $this->db->select('id_token,token,id_user,date_created,aktif,id_tes')
                 ->where($kolom, $isi)
                 ->from($this->table)
				 ->limit($limit);
        return $this->db->get();
    }

    function get_by_user_now($id_user){
        $sql = 'SELECT GROUP_CONCAT("\'",token,"\'") AS token FROM token WHERE id_user="'.$id_user.'" AND DATE(date_created)=DATE(NOW()) ORDER BY id_token ASC';

        return $this->db->query($sql);
    }
	
	function get_datatable($start, $rows, $kolom, $isi, $username){
		$this->db->where('('.$kolom.' LIKE "%'.$isi.'%" AND username="'.$username.'")')
                 ->from($this->table)
				 ->join('user', 'token.id_user = user.id_user')
				 ->order_by('token.id_token', 'DESC')
                 ->limit($rows, $start);
        return $this->db->get();
	}
    
    function get_datatable_count($kolom, $isi, $username){
		$this->db->select('COUNT(*) AS hasil')
                 ->where('('.$kolom.' LIKE "%'.$isi.'%" AND username="'.$username.'")')
                 ->from($this->table)
				 ->join('user', 'token.id_user = user.id_user');
        return $this->db->get();
	}
}