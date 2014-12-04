<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_employee_credits1 extends CI_Migration {

        public function up()
        {
                // $this->dbforge->drop_table('payslips_group');
                $this->dbforge->add_field(array(
                        'id' => array(
                                'type' => 'INT',
                                'constraint' => 5,
                                'unsigned' => TRUE,
                                'auto_increment' => TRUE
                        ),
                        'employee_id' => array(
                                'type' => 'INT',
                                'null' => TRUE,
                        ),
                        'credit_name' => array(
                                'type' => 'TEXT',
                                'null' => TRUE
                        ),
                        'remaining_credits' => array(
                                'type' => 'INT',
                                'null' => TRUE
                        ),
                        'credit_purpose' => array(
                            'type' => 'TEXT',
                            'null' => TRUE
                        ),
                        'valid' => array(
                                'type' => 'DATE',
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
                $this->dbforge->create_table('employee_credits');
        }

        public function down()
        {
                $this->dbforge->drop_table('employee_credits');
        }
}