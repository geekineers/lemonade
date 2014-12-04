<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_timeshift extends CI_Migration {

        public function up()
        {
        		// $this->dbforge->drop_table('branches');
                $this->dbforge->add_column('employees', array(
                       'timeshift_start' => array('type' => 'TIME'),
                       'timeshift_end' => array('type' => 'TIME')


                ));
        }

        public function down()
        {
                $this->dbforge->drop_table('branches');
        }
}