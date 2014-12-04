<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_company extends CI_Migration {

        public function up()
        {
                $this->dbforge->add_field(array(
                        'id' => array(
                                'type' => 'INT',
                                'constraint' => 5,
                                'unsigned' => TRUE,
                                'auto_increment' => TRUE
                        ),
                        'company_name' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '100',
                        ),
                        'company_description' => array(
                                'type' => 'TEXT',
                                'null' => TRUE,
                        ),
                        'company_address' => array(
                                'type' => 'TEXT',
                                
                        ),
                        'company_contact_number' => array(
                        		 'type' => 'VARCHAR',
                                'constraint' => '30',
                        	),
                        'company_logo' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 100
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
                $this->dbforge->create_table('companies');
        }

        public function down()
        {
                $this->dbforge->drop_table('branches');
        }
}