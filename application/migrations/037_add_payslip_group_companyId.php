<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_payslip_group_companyId extends CI_Migration
{

    public function up()
    {
        // $this->dbforge->drop_table('form_application');
        // $this->dbforge->add_column('payslips_group', array(
        //         'company_id' => array(
        //             'type'       => 'INT',
        //             'constraint' => 5,
        //         ),
                

        // ));
    
    
    
    
    

    }

    public function down()
    {
        $this->dbforge->drop_table('branches');
    }
}

