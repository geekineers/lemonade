<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_date_happened extends CI_Migration {

	public function up() {
		$this->dbforge->add_column('histories', array(
			'date_happened' => array(
				'type' => 'DATE',
			),

		));

	}

	public function down() {
		$this->dbforge->drop_table('leave_types');
	}
}
