<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_employee
 extends CI_Migration {

        public function up()
        {
        		// $this->dbforge->drop_table('branches');
                $this->dbforge->add_field(array(
                        'id' => array(
                                'type' => 'INT',
                                'constraint' => 5,
                                'unsigned' => TRUE,
                                'auto_increment' => TRUE
                        ),
                        'user_id' => array(
                        		'type' => 'INT',
                        		'constraint' => 5
                        	),
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
                        'role_id' => array(
                               	'type' => 'INT',
                                'constraint' => 5
                        ),
                        'branch_id' => array(
                               	'type' => 'INT',
                                'constraint' => 5,
                        ),

                        'job_position' => array(
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

                        'contact_number' => array(
                        		'type' => 'VARCHAR',
                        		'constraint' => '100',

                        	),

                        'employee_type' => array(
                        		'type' => 'VARCHAR',
                        		'constraint' => '100',

                        	),	

                        'dependents' => array(
                                'type' => 'INT',
                                'constraint' => '5',

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
                $this->dbforge->create_table('employees_profile');
        }

        public function down()
        {
                $this->dbforge->drop_table('branches');
        }
}