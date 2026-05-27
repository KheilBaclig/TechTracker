<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransactionsTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'ref_code'    => ['type' => 'VARCHAR', 'constraint' => 30],
            'asset_id'    => ['type' => 'INT', 'unsigned' => true],
            'user_id'     => ['type' => 'INT', 'unsigned' => true],
            'type'        => ['type' => 'ENUM', 'constraint' => ['checkout', 'checkin', 'transfer'], 'default' => 'checkout'],
            'quantity'    => ['type' => 'INT', 'default' => 1],
            'from_location' => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'to_location'   => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'assigned_to'   => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'notes'       => ['type' => 'TEXT', 'null' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('transactions');
    }

    public function down(): void
    {
        $this->forge->dropTable('transactions');
    }
}
