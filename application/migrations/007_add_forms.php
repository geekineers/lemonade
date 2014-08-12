<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_forms extends CI_Migration {

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
                                'type' => 'VARCHAR'
                            ),
                        'form_content' => array(
                                'type' => 'TEXT'
                        ),
                        'user_id' => array(
                                'type' => 'INT',
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
                        )

                ));
                $this->dbforge->add_key('id', TRUE);
                $this->dbforge->create_table('forms');
        }

        public function down()
        {
                $this->dbforge->drop_table('forms');
        }
}
