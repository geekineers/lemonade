<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_slips extends CI_Migration {

        public function up()
        {
                $this->dbforge->drop_table('payslips');
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
                        'payroll_group' => array(
                                'type' => 'INT',
                                'null' => TRUE,
                        ),
                        'branch_id' => array(
                                'type' => 'INT',
                                'null' => TRUE,
                        ),
                        'sss' => array(
                                'type' => 'INT',
                                'null' => TRUE,
                        ),
                        'philhealth' => array(
                                'type' => 'TEXT',
                                'null' => TRUE,
                        ),
                        'pagibig' => array(
                                'type' => 'TEXT',
                                'null' => TRUE,
                        ),
                        'other_deductions'=> array(
                                'type' => 'INT',
                                'null' => TRUE
                        ),
                        'net' => array(
                                     'type' => 'TEXT',
                                     'null' => TRUE,

                        ),
                        'gross' => array(
                                     'type' => 'FLOAT',
                                     'null' => TRUE,
                        ),
                        'prepared_by' => array(
                                'type' => 'TEXT',
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
                $this->dbforge->create_table('payslips');
        }

        public function down()
        {
                $this->dbforge->drop_table('payslips');
        }
}