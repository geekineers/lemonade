<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_companyinfo extends CI_Migration
{

    public function up()
    {
        // $this->dbforge->drop_table('branches');
        $this->dbforge->add_column('companies', array(
                'company_sss' => array(
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                ),
                'line_of_business' => array(
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                ),
                'company_tin' => array(
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                ),
                'company_zip' => array(
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                ),
                'company_rdo' => array(
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                ),
                'company_philhealth' => array(
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                ),
                'company_tel' => array(
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                ),
       

                ));
    
    
    
    
    

    }

    public function down()
    {
        $this->dbforge->drop_table('branches');
    }
}

