<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_training extends CI_Migration
{

    public function up()
    {
        // $this->dbforge->drop_table('form_application');
        $this->dbforge->add_field(array(
                'id' => array(
                    'type'           => 'INT',
                    'constraint'     => 5,
                    'unsigned'       => true,
                    'auto_increment' => true
                ),
                'name' => array(
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                ),
                'employee_id' => array(
                    'type' => 'INT',
                    'null' => true,
                ),
                'company_id' => array(
                    'type' => 'INT',
                    'null' => true,
                ),
                'description' => array(
                    'type' => 'TEXT',
                    'null' => true,
                ),
                'from' => array(
                    'type' => 'DATETIME',
                ),
                'to' => array(
                    'type' => 'DATETIME',
                ),
                'status' => array(
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
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
        $this->dbforge->create_table('trainings');
    }

    public function down()
    {
        $this->dbforge->drop_table('form_application');
    }
}
