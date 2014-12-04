<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_wt_settings extends CI_Migration
{

    public function up()
    {

        $this->dbforge->add_field(array(
              'id' => array(
                    'type' => 'INT',
                    'constraint' => 5,
                    'unsigned' => TRUE,
                    'auto_increment' => TRUE
              ),
              'period' => array(
                        'type' => 'TEXT',
              ),
              'to_range' => array(
                        'type' => 'FLOAT',
              ),
              'from_range' => array(
                    'type' => 'FLOAT'
              ),
              'dependents' => array(
                        'type' => 'TEXT',
              ),
              'index' => array(
                        'type' => 'INT',
              ),
              'exemption' => array(
                        'type' => 'FLOAT',
              ),
              'status' => array(
                        'type' => 'FLOAT',
              ),
              'created_at' => array(
                         'type' => 'DATETIME',
                    
                ),
              'updated_at' => array(
                         'type' => 'DATETIME',
                    
                ),
              'company_id' => array(
                         'type' => 'INT',
                    
                ),
              'deleted_at' => array(
                        'type' => 'DATETIME',
                        'null' => TRUE,
                ),
        ));
    
       $this->dbforge->add_key('id', TRUE);
       $this->dbforge->create_table('wt_settings');    
    }

    public function down()
    {
        $this->dbforge->drop_table('wt_settings');
    }
    
}

