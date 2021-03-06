<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_sss_settings extends CI_Migration
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
              'from_range' => array(
                        'type' => 'FLOAT',
              ),
              'to_range' => array(
                        'type' => 'FLOAT',
              ),
              'monthly_salary_credit' => array(
                    'type' => 'FLOAT'
              ),
              'ER' => array(
                        'type' => 'FLOAT',
              ),
              'EE' => array(
                        'type' => 'FLOAT',
              ),
              'EC' => array(
                        'type' => 'FLOAT',
              ),
              'TTC' => array(
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
       $this->dbforge->create_table('sss_settings');    
    }

    public function down()
    {
        $this->dbforge->drop_table('sss_settings');
    }
    
}

