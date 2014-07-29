<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_branches extends CI_Migration {

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
                        'branch_name' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '100',
                        ),
                        'branch_description' => array(
                                'type' => 'TEXT',
                                'null' => TRUE,
                        ),
                        'branch_address' => array(
                                'type' => 'TEXT',
                                
                        ),
                        'branch_contact_number' => array(
                        		 'type' => 'VARCHAR',
                                'constraint' => '30',
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
                $this->dbforge->create_table('branches');
        }

        public function down()
        {
                $this->dbforge->drop_table('branches');
        }
}