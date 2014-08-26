<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_holiday extends CI_Migration
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
                
                'holiday_year_id' => array(
                    'type'       => 'INT',
                    'constraint' => 5,

                ),
                'holiday_name' => array(
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                ),
                'holiday_type' => array(
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                ),
                'holiday_from' => array(
                    'type'       => 'DATE'
                ),
                'holiday_to' => array(
                    'type'       => 'DATE'
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
        $this->dbforge->create_table('holidays');
    }

    public function down()
    {
        $this->dbforge->drop_table('announcement');
    }
}
