<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_sss_employer extends CI_Migration {

	public function up() {
		$this->dbforge->add_column('payslips', array(
			'sss_employer' => array(
				'type' => 'FLOAT',
				'constraint' => 11,
			),

		));

	}

	public function down() {
		$this->dbforge->drop_table('leave_types');
	}
}
