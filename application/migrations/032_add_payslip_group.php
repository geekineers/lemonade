<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_payslip_group extends CI_Migration {

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
                        'payroll_group' => array(
                                'type' => 'INT',
                                'null' => TRUE,
                        ),
                        'from' => array(
                                'type' => 'DATE',
                                'null' => TRUE
                        ),
                        'to' => array(
                                'type' => 'DATE',
                                'null' => TRUE
                        ),
                        'status' => array(
                            'type' => 'TEXT',
                            'null' => TRUE
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
                $this->dbforge->create_table('payslips_group');
        }

        public function down()
        {
                $this->dbforge->drop_table('payslips_group');
        }
}