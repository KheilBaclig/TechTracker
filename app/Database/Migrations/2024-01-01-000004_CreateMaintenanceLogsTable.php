<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMaintenanceLogsTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'asset_id'     => ['type' => 'INT', 'unsigned' => true],
            'user_id'      => ['type' => 'INT', 'unsigned' => true],
            'type'         => ['type' => 'ENUM', 'constraint' => ['preventive', 'corrective', 'inspection', 'upgrade'], 'default' => 'preventive'],
            'technician'   => ['type' => 'VARCHAR', 'constraint' => 150],
            'description'  => ['type' => 'TEXT'],
            'cost'         => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0],
            'status'       => ['type' => 'ENUM', 'constraint' => ['scheduled', 'in_progress', 'completed', 'cancelled'], 'default' => 'scheduled'],
            'scheduled_at' => ['type' => 'DATE', 'null' => true],
            'completed_at' => ['type' => 'DATE', 'null' => true],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('maintenance_logs');
    }

    public function down(): void
    {
        $this->forge->dropTable('maintenance_logs');
    }
}
