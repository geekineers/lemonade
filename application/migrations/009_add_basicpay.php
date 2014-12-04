<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_basicpay extends CI_Migration {

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
                        'created_by' => array(
                                'type' => 'INT',
                                'constraint' => '5',
                        ),
                        'current_basic_pay' => array(
                                'type' => 'FLOAT',
                                'constraint' => 20,
                        ),
                        'new_basic_pay' => array(
                                'type' => 'FLOAT',
                                'constraint' => 20,
                                
                        ),
                        'effective_date' => array(
                        		 'type' => 'DATE',
                        	),
                        'adjustment_date' => array(
                                 'type' => 'DATE',
                            ),
                        'adjustment_reason' => array(
                                 'type' => 'TEXT'
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
                $this->dbforge->create_table('basic_pay_adjustments');
        }

        public function down()
        {
                $this->dbforge->drop_table('branches');
        }
}