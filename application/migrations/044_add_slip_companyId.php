<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_slip_companyId extends CI_Migration
{

    public function up()
    {
        // $this->dbforge->drop_table('form_application');
        $this->dbforge->add_column('payslips', array(
                'company_id' => array(
                    'type'       => 'INT',
                    'constraint' => 5,
                ),
                

        ));
    
    
    
    
    

    }

    public function down()
    {
        $this->dbforge->drop_table('payslips');
    }
}

