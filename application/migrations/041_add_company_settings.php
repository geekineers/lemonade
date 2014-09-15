<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_company_settings extends CI_Migration
{

    public function up()
    {
        // $this->dbforge->drop_table('form_application');
        $this->dbforge->add_column('companies', array(
                'company_lunch_break' => array(
                    'type'       => 'INT',
                
                ),
     
                 'company_leave_credits' => array(
                                'type'       => 'INT',
                                'constraint' => 5,
                            ),
                 'company_holiday_pay_rate' => array(
                                'type'       => 'FLOAT',
                            ),
                 'company_late_grace_period' => array(
                                'type' => 'INT'
                    ),


                

        ));
    
    
    
    
    

    }

    public function down()
    {
        $this->dbforge->drop_table('branches');
    }
}

