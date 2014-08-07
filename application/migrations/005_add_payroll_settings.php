<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_payroll_settings extends CI_Migration {

        public function up()
        {
        		
                $this->dbforge->add_field(array(
                        'id' => array(
                                'type' => 'INT',
                                'constraint' => 5,
                                'unsigned' => TRUE,
                                'auto_increment' => TRUE
                        ),
                        'form_name' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '100',
                        ),
                        'json_config' => array(
                                'type' => 'TEXT',
                                'null' => TRUE,
                        ),
                        'date_published' => array(
                                 'type' => 'DATETIME',
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
                $this->dbforge->create_table('payroll_settings');
        }

        public function down()
        {
                $this->dbforge->drop_table('payroll_settings');
        }
}