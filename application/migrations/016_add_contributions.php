<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_contributions extends CI_Migration {

        public function up()
        {
        		// $this->dbforge->drop_table('branches');
                $this->dbforge->add_column('employees', array(
                       'deduct_sss' => array(
                                                        'type' => 'BOOLEAN',
                                                    ),

                       'fixed_sss_amount' => array(
                                                        'type' => 'FLOAT',
                                                    ),

                        'deduct_hdmf' => array(
                                                        'type' => 'BOOLEAN',
                                                    ),

                       'fixed_hdmf_amount' => array(
                                                        'type' => 'FLOAT',
                                                    ),
                        'deduct_philhealth' => array(
                                                        'type' => 'BOOLEAN',
                                                    ),

                       'fixed_philhealth_amount' => array(
                                                        'type' => 'FLOAT',
                                                    ),



                ));
        }

        public function down()
        {
                $this->dbforge->drop_table('branches');
        }
}