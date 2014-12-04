<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_ph_settings extends CI_Migration
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
              'salary_base' => array(
                    'type' => 'FLOAT'
              ),
              'total_monthly_premium' => array(
                        'type' => 'FLOAT',
              ),
              'employee_share' => array(
                        'type' => 'FLOAT',
              ),
              'employer_share' => array(
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
       $this->dbforge->create_table('ph_settings');    
    }

    public function down()
    {
        $this->dbforge->drop_table('sss_settings');
    }
    
}

