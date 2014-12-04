<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_documents extends CI_Migration {

        public function up()
        {
        		$this->dbforge->drop_table('documents');
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
                        'name' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '100',
                        ),
                        'file_description' => array(
                                'type' => 'TEXT',
                                'null' => TRUE,
                        ),
                        'file_name' => array(
                                 'type' => 'VARCHAR',
                                'constraint' => '100',
                                
                        ),
                        'file_size' => array(
                        		 'type' => 'VARCHAR',
                                'constraint' => '255',
                        	),
	                   'file_type' => array(
                        		  'type' => 'VARCHAR',
                                'constraint' => '255',
                            
                        	),
                      'file_extension' => array(
                        		  'type' => 'VARCHAR',
                                'constraint' => '255',
                            
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
                $this->dbforge->create_table('documents');
        }

        public function down()
        {
                $this->dbforge->drop_table('branches');
        }
}