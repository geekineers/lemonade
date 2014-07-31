<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_department extends CI_Migration {

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
                        'department_name' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '100',
                        ),
                        'department_description' => array(
                                'type' => 'TEXT',
                                'null' => TRUE,
                        ),'created_at' => array(
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
                $this->dbforge->create_table('department');
        }

        public function down()
        {
                $this->dbforge->drop_table('department');
        }
}