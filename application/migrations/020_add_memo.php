<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_memo extends CI_Migration {

        public function up()
        {
                $this->dbforge->add_field(array(
                        'id' => array(
                                'type' => 'INT',
                                'constraint' => 5,
                                'unsigned' => TRUE,
                                'auto_increment' => TRUE
                        ),
                        'from' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '100',
                        ),
                        'to' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 100,
                        ),
                        'message' => array(
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
                $this->dbforge->create_table('memos');
        }

        public function down()
        {
                $this->dbforge->drop_table('branches');
        }
}