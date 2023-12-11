<?php
class Produk extends CI_Model {

    public $id_produk;
    public $nama_produk;
    public $harga;
    public $kategori_id;
    public $status_id;
    
    public function __construct(){
        $db = $this->load->database();
    }

    public function getAllData($status = null){

        if ($status) {
            $query = $this->db->query("Select produk.id_produk, produk.nama_produk, produk.harga, kategori.nama_kategori as kategori, status.nama_status as status from produk join kategori on produk.kategori_id = kategori.id_kategori join status on produk.status_id = status.id_status where status.id_status=$status");
        } else {
            $query = $this->db->query("Select produk.id_produk, produk.nama_produk, produk.harga, kategori.nama_kategori as kategori, status.nama_status as status from produk join kategori on produk.kategori_id = kategori.id_kategori join status on produk.status_id = status.id_status");
        }

        return $query->result_array();
    }

    public function getProdukById($id = null){
        $query = $this->db->query("Select * from produk Where id_produk=$id");
        return $query->row();
    }

    public function insertProduk($nama,$harga,$kategori,$status){
        $data['nama_produk'] = $nama;
        $data['harga'] = $harga;
        $data['kategori_id'] = $kategori;
        $data['status_id'] = $status;
        $this->db->insert('produk',$data);
        return $this->db->affected_rows() > 0;
    }
    
    public function updateProduk($data,$id){
        $this->db->where('id_produk', $id);
        $this->db->update('produk', $data);
        return $this->db->affected_rows() > 0;
    }

    public function deleteProduk($id){
        $this->db->where('id_produk',$id);
        $this->db->delete('produk');
        return $this->db->affected_rows() > 0;
    }
}