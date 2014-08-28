<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_companyid extends CI_Migration
{

    public function up()
    {
        // $this->dbforge->drop_table('branches');
        $this->dbforge->add_column('employees', array(
                'company_id' => array(
                    'type'       => 'INT',
                    'constraint' => 5,
                )));
    
        $this->dbforge->add_column('branches', array(
                'company_id' => array(
                    'type'       => 'INT',
                    'constraint' => 5,
                )));
        $this->dbforge->add_column('job_position', array(
                'company_id' => array(
                    'type'       => 'INT',
                    'constraint' => 5,
                )));

        $this->dbforge->add_column('payroll_group', array(
                'company_id' => array(
                    'type'       => 'INT',
                    'constraint' => 5,
                )));
        $this->dbforge->add_column('timesheet', array(
                'company_id' => array(
                    'type'       => 'INT',
                    'constraint' => 5,
                )));
        $this->dbforge->add_column('department', array(
                'company_id' => array(
                    'type'       => 'INT',
                    'constraint' => 5,
                )));
        $this->dbforge->add_column('announcement', array(
                'company_id' => array(
                    'type'       => 'INT',
                    'constraint' => 5,
                )));

        $this->dbforge->add_column('allowances', array(
                'company_id' => array(
                    'type'       => 'INT',
                    'constraint' => 5,
                )));
    
        $this->dbforge->add_column('deductions', array(
                'company_id' => array(
                    'type'       => 'INT',
                    'constraint' => 5,
                )));
    
        $this->dbforge->add_column('groups', array(
                'company_id' => array(
                    'type'       => 'INT',
                    'constraint' => 5,
                )));

        $this->dbforge->add_column('holiday_years', array(
                'company_id' => array(
                    'type'       => 'INT',
                    'constraint' => 5,
                )));
    
        $this->dbforge->add_column('holidays', array(
                'company_id' => array(
                    'type'       => 'INT',
                    'constraint' => 5,
                )));

        $this->dbforge->add_column('payslips', array(
                'company_id' => array(
                    'type'       => 'INT',
                    'constraint' => 5,
                )));
    
    
    
    
    

    }

    public function down()
    {
        $this->dbforge->drop_table('branches');
    }
}

