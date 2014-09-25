<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_leave_types extends CI_Migration {

        public function up()
        {
        		
                $this->dbforge->add_field(array(
                        'id' => array(
                                'type' => 'INT',
                                'constraint' => 5,
                                'unsigned' => TRUE,
                                'auto_increment' => TRUE
                        ),
                        'leave_type_name' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '100',
                        ),
                        'leave_type_approval_sequence' => array(
                                 'type' => 'VARCHAR',
                                'constraint' => '100',
                                'null' => TRUE,
                        ),
                        'leave_type_required_approval' => array(
                                 'type' => 'VARCHAR',
                                'constraint' => '100',
                                'null' => TRUE,
                            ),
                        'leave_type_base_points' => array(
                                  'type' => 'INT',
                                'constraint' => 5,
                                'null' => TRUE,
                            ), 
                        'leave_type_points_earning' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '100',
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
                $this->dbforge->create_table('leave_types');
        }

        public function down()
        {
                $this->dbforge->drop_table('payroll_settings');
        }
}