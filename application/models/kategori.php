<?php
class Kategori extends CI_Model {

    public $id_kategori;
    public $nama_kategori;
    
    public function __construct(){
        $db = $this->load->database();
    }

    public function getAllKategori(){
        
        $query = $this->db->query('Select * from kategori');

        return $query->result_array();

    }

    public function insertKategori($nama){
        $data['nama_kategori'] = $nama;
        $this->db->insert('kategori',$data);
    }
}