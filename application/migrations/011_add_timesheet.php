<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_timesheet extends CI_Migration {

        public function up()
        {
        		$this->dbforge->drop_table('basic_pay_adjustments');
                $this->dbforge->add_field(array(
                        'id' => array(
                                'type' => 'INT',
                                'constraint' => 5,
                                'unsigned' => TRUE,
                                'auto_increment' => TRUE
                        ),
                        'employee_id' => array(
                                'type' => 'INT',
                                'constraint' => '5',
                        ),
                        'source' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 100,
                        ),
                        'time_in' => array(
                                'type' => 'DATETIME',
                           
                        ),
                        'time_out' => array(
                                'type' => 'DATETIME',
                        
                                
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
                $this->dbforge->create_table('timesheet');
        }

        public function down()
        {
                $this->dbforge->drop_table('branches');
        }
}