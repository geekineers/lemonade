<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_docutype  extends CI_Migration
{

    public function up()
    {
        // $this->dbforge->drop_table('branches');
        $this->dbforge->add_column('documents', array(
                'document_type' => array(
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
