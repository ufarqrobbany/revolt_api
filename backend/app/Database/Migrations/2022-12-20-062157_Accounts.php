<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Accounts extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_account' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true
            ],
            'fullname' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => 15,
            ],
            'gender' => [
                'type' => 'ENUM',
                'constraint' => ['Male', 'Female'],
            ],
            'age' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
        ]);
        $this->forge->addPrimaryKey('id_account');
        $attributes = ['ENGINE' => 'InnoDB'];
        $this->forge->createTable('accounts', false, $attributes);
    }

    public function down()
    {
        //
    }
}
