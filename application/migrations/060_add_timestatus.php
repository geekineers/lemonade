<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_timestatus extends CI_Migration {

	public function up() {
		$this->dbforge->add_column('timesheet', array(
			'status' => array(
				'type' => 'VARCHAR',
				'constraint' => 255
			),

		));

	}

	public function down() {
		$this->dbforge->drop_table('leave_types');
	}
}
