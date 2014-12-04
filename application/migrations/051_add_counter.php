<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_counter extends CI_Migration
{

    public function up()
    {
        // $this->dbforge->drop_table('employee_leave_c');
        $this->dbforge->add_column('employee_leave_credits', array(
                'counter' => array(
                    'type'       => 'INT',
                    'constraint' => 5,
                ),
                

        ));
    
    
    
    
    

    }

    public function down()
    {
        $this->dbforge->drop_table('leave_types');
    }
}

