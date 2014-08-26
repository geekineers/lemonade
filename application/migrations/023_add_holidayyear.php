<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_holidayyear extends CI_Migration
{

    public function up()
    {
        $this->dbforge->add_field(array(
                'id' => array(
                    'type'           => 'INT',
                    'constraint'     => 5,
                    'unsigned'       => true,
                    'auto_increment' => true
                ),
                'year' => array(
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                ),
                
                'created_by' => array(
                    'type'       => 'INT',
                    'constraint' => 5,

                ),
               
                'created_at' => array(
                    'type' => 'DATETIME',

                ),
                'updated_at' => array(
                    'type' => 'DATETIME',

                ),
                'deleted_at' => array(
                    'type' => 'DATETIME',
                    'null' => true,
                ),

            ));
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('holiday_years');
    }

    public function down()
    {
        $this->dbforge->drop_table('announcement');
    }
}
