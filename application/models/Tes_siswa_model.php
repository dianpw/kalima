<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* UJIAN ONLINE
* Dian Purwanto
* dianpw6901@gmail.com

*/
class Tes_siswa_model extends CI_Model{
	public $table = 'tes_siswa';
	
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

    function update_menit($id_tes_siswa, $waktu){
        $sql = 'UPDATE tes_siswa SET date_created=TIMESTAMPADD(MINUTE, '.$waktu.', date_created) WHERE id_tes_siswa="'.$id_tes_siswa.'"'; $this->db->query($sql);
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
     * @param      string  $id_tes_siswa  The tesuser identifier
     *
     * @return     <type>  Number of by status waktu.
     */
    function count_by_status_waktu($id_tes_siswa){
        $this->db->select('COUNT(id_tes_siswa) AS hasil')
                 ->where('(id_tes_siswa="'.$id_tes_siswa.'" AND status="1" AND TIMESTAMPADD(MINUTE, duration_time, date_created)>NOW())')
                 ->from($this->table)
                 ->join('tes', 'tes_siswa.id_tes = tes.id_tes');
        return $this->db->get();
    }

    /**
     * menghitung testuser yang masih aktif dengan status==1 dan waktu masih belum habis
     * berdasarkan waktu yang php, bukan waktu mysql
     * revisi 2018-11-15
     * @param      string  $id_tes_siswa  The tesuser identifier
     *
     * @return     <type>  Number of by status waktu.
     */
    function count_by_status_waktuuser($id_tes_siswa, $waktuuser){
        $this->db->select('COUNT(id_tes_siswa) AS hasil')
                 ->where('(id_tes_siswa="'.$id_tes_siswa.'" AND status="1" AND TIMESTAMPADD(MINUTE, duration_time, date_created)>"'.$waktuuser.'")')
                 ->from($this->table)
                 ->join('tes', 'tes_siswa.id_tes = tes.id_tes');
        return $this->db->get();
    }

    function get_by_user_status($id_siswa){
        $this->db->where('id_siswa="'.$id_siswa.'" AND status!=4')
                 ->from($this->table)
                 ->join('tes', 'tes_siswa.id_tes = tes.id_tes');
        return $this->db->get();
    }

    function get_by_user_tes_limit($id_siswa, $id_tes){
        $this->db->where('id_siswa="'.$id_siswa.'" AND id_tes="'.$id_tes.'" AND status=1')
                 ->from($this->table)
                 ->join('tes', 'tes_siswa.id_tes = tes.id_tes')
                 ->limit(1);
        return $this->db->get();
    }

    function count_by_user_tes($id_siswa, $id_tes){
        $this->db->select('COUNT(*) AS hasil')
                 ->where('id_siswa="'.$id_siswa.'" AND id_tes="'.$id_tes.'"')
                 ->from($this->table);
        return $this->db->get();
    }

    function count_by_user_tes_selesai($id_siswa, $id_tes){
        $this->db->select('COUNT(*) AS hasil')
                 ->where('id_siswa="'.$id_siswa.'" AND id_tes="'.$id_tes.'" AND status=4')
                 ->from($this->table);
        return $this->db->get();
    }
	
    function get_by_user_tes($id_siswa, $id_tes){
        $this->db->where('id_siswa="'.$id_siswa.'" AND id_tes="'.$id_tes.'"')
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
        $this->db->from($this->table)
                 ->join('tes', 'tes_siswa.id_tes = tes.id_tes')
                 ->order_by('tes.id_tes', 'DESC')
                 ->group_by('tes.id_tes');
        return $this->db->get();
    }
	
	function get_by_kolom_limit($kolom, $isi, $limit){
        $this->db->where($kolom, $isi)
                 ->from($this->table)
				 ->limit($limit);
        return $this->db->get();
    }

    function get_by_tes_group_urut_tanggal($id_tes, $id_kelas, $urutkan, $tanggal, $keterangan){
        $sql = 'date_created >="'.$tanggal[0].'" AND date_created <="'.$tanggal[1].'"';
		
        if($id_tes!='semua'){
            $sql = $sql.' AND id_tes="'.$id_tes.'"';
        }
        if($id_kelas!='semua'){
            $sql = $sql.' AND id_kelas="'.$id_kelas.'"';
        }
        $order = '';
        if($urutkan=='tertinggi'){
            $order = 'nilai DESC';
        }else if($urutkan=='terendah'){
            $order = 'nilai ASC';
        }else if($urutkan=='nama'){
            $order = 'nama ASC';
        }else if($urutkan=='waktu'){
            $order = 'date_created DESC';
        }else{
            $order = 'id_tes ASC';
        }
		
		if(!empty($keterangan)){
			$sql = $sql.' AND user_detail LIKE "%'.$keterangan.'%"';
		}

        $this->db->select('tes_siswa.*, tes.*, siswa.*, kelas.kelas, SUM(`tes_soal`.`nilai`) AS nilai ')
                 ->where('( '.$sql.' )')
                 ->from($this->table)
                 ->join('siswa', 'tes_siswa.id_siswa = siswa.id_siswa', 'right')
                 ->join('kelas', 'siswa.id_kelas = kelas.id_kelas')
                 ->join('tes', 'tes_siswa.id_tes = tes.id_tes', 'left')
                 ->join('tes_soal', 'tes_soal.id_tes_siswa = tes_siswa.id_tes_siswa', 'left')
                 ->group_by('tes_siswa.id_tes_siswa')
                 ->order_by($order);
        return $this->db->get();
    }
	
	function get_by_tes_group($id_tes, $id_kelas){
        $sql = 'id_tes="'.$id_tes.'" AND id_kelas="'.$id_kelas.'"';

        $this->db->select('tes_siswa.*, tes.tes_nama, siswa.*, kelas.kelas')
                 ->where('( '.$sql.' )')
                 ->from($this->table)
                 ->join('siswa', 'tes_siswa.id_siswa = siswa.id_siswa')
                 ->join('kelas', 'siswa.id_kelas = kelas.id_kelas')
                 ->join('tes', 'tes_siswa.id_tes = tes.id_tes')
                 ->order_by('siswa.nama', 'ASC');
        return $this->db->get();
    }

    function get_nilai_by_tes_user($id_tes, $id_siswa){
        $this->db->select('SUM(`tes_soal`.`nilai`) AS nilai')
                 ->where('(id_tes="'.$id_tes.'" AND id_siswa="'.$id_siswa.'")')
                 ->from($this->table)
                 ->join('tes_soal', 'tes_soal.id_tes_siswa = tes_siswa.id_tes_siswa');
        return $this->db->get();
    }
	
	/**
	* datatable untuk hasil tes yang sudah mengerjakan
	*
	*/
	function get_datatable($start, $rows, $id_tes, $id_kelas, $urutkan, $tanggal, $keterangan, $search){
        $sql = 'date_created>="'.$tanggal[0].'" AND date_created<="'.$tanggal[1].'" AND nama LIKE "%'.$search.'%"';
		
        if($id_tes!='semua'){
            $sql = $sql.' AND id_tes="'.$id_tes.'"';
        }
        if($id_kelas!='semua'){
            $sql = $sql.' AND id_kelas="'.$id_kelas.'"';
        }
        $order = '';
        if($urutkan=='tertinggi'){
            $order = 'nilai DESC';
        }else if($urutkan=='terendah'){
            $order = 'nilai ASC';
        }else if($urutkan=='nama'){
            $order = 'nama ASC';
        }else if($urutkan=='waktu'){
            $order = 'date_created DESC';
        }else{
            $order = 'id_tes ASC';
        }
		
		if(!empty($keterangan)){
			$sql = $sql.' AND user_detail LIKE "%'.$keterangan.'%"';
		}

		$this->db->select('tes_siswa.*,kelas.kelas, tes.*, siswa.*, SUM(`tes_soal`.`nilai`) AS nilai ')
                 ->where('( '.$sql.' )')
                 ->from($this->table)
                 ->join('siswa', 'tes_siswa.id_siswa = siswa.id_siswa')
                 ->join('kelas', 'siswa.id_kelas = kelas.id_kelas')
                 ->join('tes', 'tes_siswa.id_tes = tes.id_tes')
                 ->join('tes_soal', 'tes_soal.id_tes_siswa = tes_siswa.id_tes_siswa')
                 ->group_by('tes_siswa.id_tes_siswa')
				 ->order_by($order)
                 ->limit($rows, $start);
        return $this->db->get();
	}
    
    function get_datatable_count($id_tes, $id_kelas, $urutkan, $tanggal, $keterangan, $search){
        $sql = 'date_created>="'.$tanggal[0].'" AND date_created<="'.$tanggal[1].'" AND nama LIKE "%'.$search.'%"';
		
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
                 ->join('siswa', 'tes_siswa.id_siswa = siswa.id_siswa', 'right')
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
     * @param      string  $id_tes  The tes identifier
     * @param      string  $order   The order
     *
     * @return     <type>  The datatable evaluasi.
     */
    function get_datatable_evaluasi($start, $rows, $id_tes, $urutkan){
        $sql = '';
        if(!empty($id_tes)){
            $sql = ' AND id_tes="'.$id_tes.'"';
        }
        $order = '';
        if($urutkan=='soal'){
            $order = 'id_soal ASC';
        }else{
            $order = 'id_tes_siswa ASC';
        }

        $this->db->select('tes_soal.id_tes_soal, tes_soal.jawaban_text, tes.*, soal.*')
                 ->where('(tipe="2" AND jawaban_text IS NOT NULL AND comment IS NULL '.$sql.' )')
                 ->from($this->table)
                 ->join('tes', 'tes_siswa.id_tes = tes.id_tes')
                 ->join('tes_soal', 'tes_soal.id_tes_siswa = tes_siswa.id_tes_siswa')
                 ->join('soal', 'tes_soal.id_soal = soal.id_soal')
                 ->order_by($order)
                 ->limit($rows, $start);
        return $this->db->get();
    }
    
    function get_datatable_evaluasi_count($id_tes, $order){
        $sql = '';
        if(!empty($id_tes)){
            $sql = ' AND id_tes="'.$id_tes.'"';
        }

        $this->db->select('COUNT(*) AS hasil')
                 ->where('(tipe="2" AND jawaban_text IS NOT NULL AND comment IS NULL '.$sql.' )')
                 ->join('tes_soal', 'tes_soal.id_tes_siswa = tes_siswa.id_tes_siswa')
                 ->join('soal', 'tes_soal.id_soal = soal.id_soal')
                 ->from($this->table);
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
        $this->db->select('tes_siswa.*,kelas.kelas, tes.*, siswa.*, SUM(`tes_soal`.`nilai`) AS nilai ')
                 ->where('(token IN ('.$token.'))')
                 ->from($this->table)
                 ->join('siswa', 'tes_siswa.id_siswa = siswa.id_siswa')
                 ->join('kelas', 'siswa.id_kelas = kelas.id_kelas')
                 ->join('tes', 'tes_siswa.id_tes = tes.id_tes')
                 ->join('tes_soal', 'tes_soal.id_tes_siswa = tes_siswa.id_tes_siswa')
                 ->group_by('tes_siswa.id_tes_siswa')
                 ->order_by('date_created DESC')
                 ->limit($rows, $start);
        return $this->db->get();
    }
    
    function get_datatable_operator_count($token){
        $this->db->select('COUNT(*) AS hasil')
                 ->where('(token IN ('.$token.'))')
                 ->from($this->table);
        return $this->db->get();
    }
}