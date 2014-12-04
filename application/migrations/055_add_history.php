<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_history extends CI_Migration {

        public function up()
        {
        		
                $this->dbforge->add_field(array(
                        'id' => array(
                                'type' => 'INT',
                                'constraint' => 5,
                                'unsigned' => TRUE,
                                'auto_increment' => TRUE
                        ),
                        'employee_id'
                        => array(
                                'type' => 'INT',
                                'constraint' => 5,
                
                        ),
                           'company_id'
                        => array(
                                'type' => 'INT',
                                'constraint' => 5,
                
                        ),
                        'action'
                        => array(
                                'type' => 'TEXT',
                
                        ),

                       'created_at' => array(
                                 'type' => 'DATETIME',
                                'null' => TRUE,
                            ),
                      'updated_at' => array(
                        		 'type' => 'DATETIME',
                            
                    	),
                      'deleted_at' => array(
                      			'type' => 'DATETIME',
                      			'null' => TRUE,
                      	),

                      


                ));
                $this->dbforge->add_key('id', TRUE);
                $this->dbforge->create_table('histories');
        }

        public function down()
        {
                $this->dbforge->drop_table('payroll_settings');
        }
}