<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_employee_number extends CI_Migration
{

    public function up()
    {
        // $this->dbforge->drop_table('employee_leave_c');
        $this->dbforge->add_column('employees', array(
                'employee_number' => array(
                    'type'       => 'INT',
                    'constraint' => 10,
                ),
                

        ));
    
    
    
    
    

    }

    public function down()
    {
        $this->dbforge->drop_table('leave_types');
    }
}

