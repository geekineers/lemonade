<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_timesheet_absent extends CI_Migration
{

    public function up()
    {
        // $this->dbforge->drop_table('branches');
        $this->dbforge->add_column('timesheet', array(
                'absent' => array(
                    'type'       => 'BOOLEAN',
                ),
                

                ));
    
    
    
    
    

    }

    public function down()
    {
        $this->dbforge->drop_table('branches');
    }
}

