<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_evaluation extends CI_Migration
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
                'evaluation_name' => array(
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                ),
                'employee_id' => array(
                    'type'       => 'INT',
                    'constraint' => 5,

                ),
                'created_by' => array(
                    'type'       => 'INT',
                    'constraint' => 5,

                ),
                'date_from' => array(
                    'type' => 'DATETIME',

                ),
                'date_to' => array(
                    'type' => 'DATETIME',

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
        $this->dbforge->create_table('evaluation');
    }

    public function down()
    {
        $this->dbforge->drop_table('announcement');
    }
}
