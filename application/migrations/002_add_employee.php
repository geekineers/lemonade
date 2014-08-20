<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_employee
 extends CI_Migration {

        public function up()
        {
        		$this->dbforge->drop_table('employees');
                $this->dbforge->add_field(array(
                        'id' => array(
                                'type' => 'INT',
                                'constraint' => 5,
                                'unsigned' => TRUE,
                                'auto_increment' => TRUE
                        ),
                        'user_id' => array(
                        		'type' => 'VARCHAR',
                        		'constraint' => '10'
                        ),
                        // Employee Information 
                        'first_name' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '100',
                        ),
                        'last_name' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '100',
                        ),
                        'middle_name' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '100',
                        ),
                        'full_address' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '255',
                        ),

                        'birthdate' => array(
                                'type' => 'DATE'
                            ),
                        'gender' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '100'
                            ),
                        'marital_status' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 100
                            ),
                        'spouse_name' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 255
                            ),
                        // Employee details

                        'employee_type' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 100
                            ),

                        'payroll_period' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 100
                            ),
                       'job_position' => array(
                                'type' => 'INT',
                                'constraint' => 5,
                        ),
                      'department' => array(
                                'type' => 'INT',
                                'constraint' => 5,
                        ),
                        'role_id' => array(
                                'type' => 'INT',
                                'constraint' => 5
                        ),
                        'branch_id' => array(
                               	'type' => 'INT',
                                'constraint' => 5,
                        ),
                        'date_hired' => array(
                                'type' => 'DATE'
                            ),
                        'date_ended' => array(
                                'type' => 'DATE'
                            ),

                        // Governmanet Details
                        'basic_pay' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '100',

                        ),
                        'tin_number' => array(
                        		'type' => 'VARCHAR',
                        		'constraint' => '100',

                        	),
                        'sss_number' => array(
                        		'type' => 'VARCHAR',
                        		'constraint' => '100',

                        	),

                        'pagibig_number' => array(
                        		'type' => 'VARCHAR',
                        		'constraint' => '100',

                        	),
                        'dependents' => array(
                                'type' => 'INT',
                                'constraint' => 5,

                        ), 

                  
                          'profile_picture' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '100',

                            ),  

                        // Contact Information

                        'contact_number' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '100',

                            ),


                        'fb' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '100'
                            ),                 
                        'email' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '100'
                            ),                 

	                   'created_at' => array(
                        		 'type' => 'DATETIME',
                                'null' => TRUE,
                        	),
                      'updated_at' => array(
                        		 'type' => 'DATETIME',
                             'null' => TRUE,
                    	),
                      'deleted_at' => array(
                      			'type' => 'DATETIME',
                      			'null' => TRUE,
                      	),


                ));
                $this->dbforge->add_key('id', TRUE);
                $this->dbforge->create_table('employees');
        }

        public function down()
        {
                $this->dbforge->drop_table('branches');
        }
}