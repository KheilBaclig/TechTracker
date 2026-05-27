<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAssetsTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'              => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'category_id'     => ['type' => 'INT', 'unsigned' => true],
            'asset_tag'       => ['type' => 'VARCHAR', 'constraint' => 80],
            'name'            => ['type' => 'VARCHAR', 'constraint' => 200],
            'brand'           => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'model'           => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'serial_number'   => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'description'     => ['type' => 'TEXT', 'null' => true],
            'purchase_date'   => ['type' => 'DATE', 'null' => true],
            'purchase_cost'   => ['type' => 'DECIMAL', 'constraint' => '12,2', 'null' => true],
            'warranty_expiry' => ['type' => 'DATE', 'null' => true],
            'location'        => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'assigned_to'     => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'status'          => ['type' => 'ENUM', 'constraint' => ['active', 'under_maintenance', 'retired', 'disposed'], 'default' => 'active'],
            'quantity'        => ['type' => 'INT', 'default' => 1],
            'low_stock_threshold' => ['type' => 'INT', 'default' => 2],
            'image'           => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'notes'           => ['type' => 'TEXT', 'null' => true],
            'created_at'      => ['type' => 'DATETIME', 'null' => true],
            'updated_at'      => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'      => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('asset_tag');
        $this->forge->createTable('assets');
    }

    public function down(): void
    {
        $this->forge->dropTable('assets');
    }
}
