<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_forms_application extends CI_Migration {

        public function up()
        {
            $this->dbforge->drop_table('form_application');
                $this->dbforge->add_field(array(
                        'id' => array(
                                'type' => 'INT',
                                'constraint' => 5,
                                'unsigned' => TRUE,
                                'auto_increment' => TRUE
                        ),
                        'form_type' => array(
                                'type' => 'TEXT', 
                        ),
                        'employee_id' => array(
                                'type' => 'INT',
                                'null' => TRUE,
                        ),
                        'prepared_by' => array(
                                'type' => 'INT',
                                'null' => TRUE,
                        ),
                        'effective_date' => array(
                                'type' => 'DATETIME',
                        ),
                        'from' => array(
                                'type' => 'DATETIME',
                        ),
                        'to' => array(
                                'type' => 'DATETIME',
                        ),
                        'status' => array(
                                'type' => 'TEXT',
                        ),
                        'form_data' => array(
                                'type' => 'TEXT',
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
                $this->dbforge->create_table('form_application');
        }

        public function down()
        {
                $this->dbforge->drop_table('form_application');
        }
}