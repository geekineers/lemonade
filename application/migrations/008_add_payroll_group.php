<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_payroll_group extends CI_Migration {

        public function up()
        {
        		
                $this->dbforge->add_field(array(
                        'id' => array(
                                'type' => 'INT',
                                'constraint' => 5,
                                'unsigned' => TRUE,
                                'auto_increment' => TRUE
                        ),
                      
                        'branch_id' => array(
                                'type' => 'INT',
                                'null' => TRUE,
                        ),
                        'group_name' => array(
                                'type' => 'TEXT',
                                'null' => TRUE,
                        ),
                        'period' => array(
                                'type' => 'TEXT',
                                'null' => TRUE,
                        ),
                        'prepared_by' => array(
                                'type' => 'TEXT',
                                'null' => TRUE,
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
                $this->dbforge->create_table('payroll_group');
        }

        public function down()
        {
                $this->dbforge->drop_table('payroll_group');
        }
}