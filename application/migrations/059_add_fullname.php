<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_fullname extends CI_Migration {

	public function up() {
		$this->dbforge->add_column('employees', array(
			'full_name' => array(
				'type' => 'VARCHAR',
				'constraint' => 255
			),

		));

	}

	public function down() {
		$this->dbforge->drop_table('leave_types');
	}
}
