<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_produk extends CI_Migration {

        public function up()
        {
                $this->dbforge->add_field(array(
                        'id_produk' => array(
                                'type' => 'INT',
                                'constraint' => 20,
                                'unsigned' => TRUE,
                                'auto_increment' => TRUE
                        ),
                        'nama_produk' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '200',
                        ),
                        'harga' => array(
                                'type' => 'INT',
                                'constraint' => 50,
                        ),
                        'kategori_id' => array(
                                'type' => 'INT',
                                'constraint' => 50,
                        ),
                        'status_id' => array(
                                'type' => 'INT',
                                'constraint' => 50,
                        ),
                ));
                $this->dbforge->add_key('id_produk', TRUE);
                $this->dbforge->create_table('produk');
        }

        public function down()
        {
                $this->dbforge->drop_table('produk');
        }
}