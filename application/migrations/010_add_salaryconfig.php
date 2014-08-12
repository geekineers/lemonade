<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_salaryconfig extends CI_Migration {

        public function up()
        {
        		// $this->dbforge->drop_table('branches');
                $this->dbforge->add_column('employees', array(
                       'withholding_tax_type' => array(
                                                        'type' => 'VARCHAR',
                                                        'constraint' => 100,
                                                    ),

                       'expanded_withholding_tax' => array(
                                                        'type' => 'FLOAT',
                                                    ),

                       'entitled_night_differential' => array(
                                                        'type' => 'INT',
                                                        'constraint' => 5,
                                                    ),

                       'night_differential_rate' => array(
                                                        'type' => 'FLOAT',
                                                    ),

                       'entitled_overtime_pay' => array(
                                                        'type' => 'INT',
                                                        'constraint' => 5,
                                                    ),

                       'overtime_pay_rate' => array(
                                                        'type' => 'FLOAT',
                                                    ),

                       'timesheet_required' => array(
                                                        'type' => 'INT',
                                                        'constraint' => 5,
                                                    )



                ));
        }

        public function down()
        {
                $this->dbforge->drop_table('branches');
        }
}