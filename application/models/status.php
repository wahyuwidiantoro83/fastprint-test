<?php
class Status extends CI_Model {

    public $id_status;
    public $nama_status;

    public function __construct(){
        $db = $this->load->database();
    }

    public function getAllStatus(){
        $query = $this->db->query('Select * from status');

        return $query->result_array();
    }

    public function insertStatus($nama){
        $data['nama_status'] = $nama;
        $this->db->insert('status',$data);
    }

}