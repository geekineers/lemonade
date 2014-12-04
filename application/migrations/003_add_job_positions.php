<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_job_positions extends CI_Migration {

        public function up()
        {
        		$this->dbforge->drop_table('job_position');
                $this->dbforge->add_field(array(
                        'id' => array(
                                'type' => 'INT',
                                'constraint' => 5,
                                'unsigned' => TRUE,
                                'auto_increment' => TRUE
                        ),
                        'job_position' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '100',
                        ),
                        'job_description' => array(
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
                $this->dbforge->create_table('job_position');
        }

        public function down()
        {
                $this->dbforge->drop_table('job_position');
        }
}