<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_allowance extends CI_Migration {

        public function up()
        {

                $this->dbforge->drop_table('employee_deductions');
              
                $this->dbforge->add_field(array(
                        'id' => array(
                                'type' => 'INT',
                                'constraint' => 5,
                                'unsigned' => TRUE,
                                'auto_increment' => TRUE
                        ),
                        'employee_id' => array(
                                'type' => 'INT',
                                'constraint' => 5
                        ),
                        'deduction_id' => array(
                                'type' => 'INT',
                                'constraint' => 5,
                        ),

                        'recurring' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 100
                            ),
                    
                      'amount' => array(
                                'type' => 'FLOAT',
                                'constraint' => 11
                        ),
                      
                       'valid_from' => array(
                                'type' => 'DATE'
                        ),
                       'valid_to' => array(
                                'type' => 'DATE'
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
                $this->dbforge->create_table('employee_deductions');

        		// $this->dbforge->drop_table('deductions');
                $this->dbforge->add_field(array(
                        'id' => array(
                                'type' => 'INT',
                                'constraint' => 5,
                                'unsigned' => TRUE,
                                'auto_increment' => TRUE
                        ),
                        'allowance_name' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '100',
                        ),
                   
                        'created_by' => array(
                             'type' => 'VARCHAR',
                                'constraint' => '100',
                                
                        ),
                  
	                   'created_at' => array(
                        		 'type' => 'DATETIME',
                            
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
                $this->dbforge->create_table('allowances');


                $this->dbforge->add_field(array(
                        'id' => array(
                                'type' => 'INT',
                                'constraint' => 5,
                                'unsigned' => TRUE,
                                'auto_increment' => TRUE
                        ),
                        'employee_id' => array(
                                'type' => 'INT',
                                'constraint' => 5
                        ),
                        'allowance_id' => array(
                                'type' => 'INT',
                                'constraint' => 5,
                        ),

                        'recurring' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 100
                            ),
                   
                      'amount' => array(
                                'type' => 'FLOAT',
                                'constraint' => 11
                        ),
                       'valid_from' => array(
                                'type' => 'DATE'
                        ),
                       'valid_to' => array(
                                'type' => 'DATE'
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
                $this->dbforge->create_table('employee_allowances');


        }

        public function down()
        {
                $this->dbforge->drop_table('branches');
        }
}