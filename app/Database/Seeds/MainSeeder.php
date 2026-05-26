<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainSeeder extends Seeder
{
    public function run(): void
    {
        $now = date('Y-m-d H:i:s');

        // Users
        $this->db->table('users')->insertBatch([
            ['name' => 'Super Admin', 'email' => 'superadmin@techtracker.com', 'password' => password_hash('password', PASSWORD_BCRYPT), 'role' => 'superadmin', 'api_token' => bin2hex(random_bytes(32)), 'created_at' => $now],
            ['name' => 'IT Manager',  'email' => 'manager@techtracker.com',    'password' => password_hash('password', PASSWORD_BCRYPT), 'role' => 'manager',    'api_token' => bin2hex(random_bytes(32)), 'created_at' => $now],
            ['name' => 'Tech Staff',  'email' => 'staff@techtracker.com',      'password' => password_hash('password', PASSWORD_BCRYPT), 'role' => 'staff',      'api_token' => bin2hex(random_bytes(32)), 'created_at' => $now],
        ]);

        // Categories
        $this->db->table('categories')->insertBatch([
            ['name' => 'Laptops & Computers', 'slug' => 'laptops-computers', 'description' => 'Laptops, desktops, and workstations', 'created_at' => $now],
            ['name' => 'Networking',           'slug' => 'networking',        'description' => 'Routers, switches, and access points', 'created_at' => $now],
            ['name' => 'Peripherals',          'slug' => 'peripherals',       'description' => 'Monitors, keyboards, mice, and printers', 'created_at' => $now],
            ['name' => 'Mobile Devices',       'slug' => 'mobile-devices',    'description' => 'Smartphones and tablets', 'created_at' => $now],
            ['name' => 'Servers & Storage',    'slug' => 'servers-storage',   'description' => 'Servers, NAS, and storage devices', 'created_at' => $now],
            ['name' => 'AV Equipment',         'slug' => 'av-equipment',      'description' => 'Projectors, cameras, and audio equipment', 'created_at' => $now],
        ]);

        // Assets
        $assets = [
            ['category_id' => 1, 'asset_tag' => 'LT-001', 'name' => 'Dell XPS 15 Laptop',        'brand' => 'Dell',    'model' => 'XPS 15 9530',    'serial_number' => 'DL9530001', 'purchase_date' => '2023-01-15', 'purchase_cost' => 1899.00, 'warranty_expiry' => '2026-01-15', 'location' => 'IT Department',   'assigned_to' => 'John Doe',    'status' => 'active',            'quantity' => 1, 'low_stock_threshold' => 1],
            ['category_id' => 1, 'asset_tag' => 'LT-002', 'name' => 'MacBook Pro 14"',            'brand' => 'Apple',   'model' => 'MacBook Pro M3',  'serial_number' => 'AP14M3002', 'purchase_date' => '2023-03-20', 'purchase_cost' => 2499.00, 'warranty_expiry' => '2026-03-20', 'location' => 'Design Studio',   'assigned_to' => 'Jane Smith',  'status' => 'active',            'quantity' => 1, 'low_stock_threshold' => 1],
            ['category_id' => 1, 'asset_tag' => 'DT-001', 'name' => 'HP EliteDesk 800 G9',       'brand' => 'HP',      'model' => 'EliteDesk 800',   'serial_number' => 'HP800G9003', 'purchase_date' => '2022-06-10', 'purchase_cost' => 1299.00, 'warranty_expiry' => '2025-06-10', 'location' => 'Finance Dept',    'assigned_to' => null,          'status' => 'under_maintenance', 'quantity' => 1, 'low_stock_threshold' => 1],
            ['category_id' => 2, 'asset_tag' => 'NW-001', 'name' => 'Cisco Catalyst 2960 Switch', 'brand' => 'Cisco',   'model' => 'Catalyst 2960',   'serial_number' => 'CS2960004', 'purchase_date' => '2021-09-05', 'purchase_cost' => 3200.00, 'warranty_expiry' => '2024-09-05', 'location' => 'Server Room',     'assigned_to' => null,          'status' => 'active',            'quantity' => 2, 'low_stock_threshold' => 1],
            ['category_id' => 2, 'asset_tag' => 'NW-002', 'name' => 'Ubiquiti UniFi AP AC Pro',   'brand' => 'Ubiquiti','model' => 'UAP-AC-PRO',      'serial_number' => 'UB-AC005',  'purchase_date' => '2022-11-12', 'purchase_cost' => 149.00,  'warranty_expiry' => '2025-11-12', 'location' => 'Office Floor 2',  'assigned_to' => null,          'status' => 'active',            'quantity' => 6, 'low_stock_threshold' => 2],
            ['category_id' => 3, 'asset_tag' => 'MN-001', 'name' => 'LG UltraWide 34" Monitor',  'brand' => 'LG',      'model' => '34WN80C-B',       'serial_number' => 'LG34006',   'purchase_date' => '2023-02-28', 'purchase_cost' => 699.00,  'warranty_expiry' => '2026-02-28', 'location' => 'Dev Team Area',   'assigned_to' => 'Alice Wong',  'status' => 'active',            'quantity' => 4, 'low_stock_threshold' => 2],
            ['category_id' => 3, 'asset_tag' => 'PR-001', 'name' => 'HP LaserJet Pro M404dn',    'brand' => 'HP',      'model' => 'LaserJet M404dn', 'serial_number' => 'HPLJ007',   'purchase_date' => '2021-04-18', 'purchase_cost' => 399.00,  'warranty_expiry' => '2024-04-18', 'location' => 'Admin Office',    'assigned_to' => null,          'status' => 'active',            'quantity' => 2, 'low_stock_threshold' => 1],
            ['category_id' => 4, 'asset_tag' => 'MB-001', 'name' => 'iPad Pro 12.9" (M2)',       'brand' => 'Apple',   'model' => 'iPad Pro M2',     'serial_number' => 'APIP008',   'purchase_date' => '2023-05-01', 'purchase_cost' => 1099.00, 'warranty_expiry' => '2025-05-01', 'location' => 'Conference Room', 'assigned_to' => null,          'status' => 'active',            'quantity' => 3, 'low_stock_threshold' => 1],
            ['category_id' => 5, 'asset_tag' => 'SV-001', 'name' => 'Dell PowerEdge R750 Server','brand' => 'Dell',    'model' => 'PowerEdge R750',  'serial_number' => 'DLPE009',   'purchase_date' => '2022-01-20', 'purchase_cost' => 8500.00, 'warranty_expiry' => '2027-01-20', 'location' => 'Data Center',     'assigned_to' => null,          'status' => 'active',            'quantity' => 1, 'low_stock_threshold' => 1],
            ['category_id' => 6, 'asset_tag' => 'AV-001', 'name' => 'Epson EB-L200F Projector',  'brand' => 'Epson',   'model' => 'EB-L200F',        'serial_number' => 'EP200010',  'purchase_date' => '2022-08-15', 'purchase_cost' => 1299.00, 'warranty_expiry' => '2025-08-15', 'location' => 'Board Room',      'assigned_to' => null,          'status' => 'retired',           'quantity' => 1, 'low_stock_threshold' => 1],
            ['category_id' => 1, 'asset_tag' => 'LT-003', 'name' => 'Lenovo ThinkPad X1 Carbon', 'brand' => 'Lenovo',  'model' => 'ThinkPad X1',     'serial_number' => 'LN-X1011',  'purchase_date' => '2023-07-10', 'purchase_cost' => 1749.00, 'warranty_expiry' => '2026-07-10', 'location' => 'HR Department',   'assigned_to' => 'Bob Lee',     'status' => 'active',            'quantity' => 1, 'low_stock_threshold' => 1],
            ['category_id' => 2, 'asset_tag' => 'NW-003', 'name' => 'Fortinet FortiGate 60F',    'brand' => 'Fortinet','model' => 'FortiGate 60F',   'serial_number' => 'FG60F012',  'purchase_date' => '2021-12-01', 'purchase_cost' => 750.00,  'warranty_expiry' => '2024-12-01', 'location' => 'Server Room',     'assigned_to' => null,          'status' => 'active',            'quantity' => 1, 'low_stock_threshold' => 1],
        ];
        $this->db->table('assets')->insertBatch($assets);

        // Maintenance Logs
        $this->db->table('maintenance_logs')->insertBatch([
            ['asset_id' => 3, 'user_id' => 2, 'type' => 'corrective',  'technician' => 'Mike Torres',  'description' => 'Fan replacement and thermal paste reapplication due to overheating.', 'cost' => 85.00,  'status' => 'in_progress', 'scheduled_at' => date('Y-m-d', strtotime('-3 days')), 'completed_at' => null, 'created_at' => $now],
            ['asset_id' => 1, 'user_id' => 2, 'type' => 'preventive',  'technician' => 'Sarah Chen',   'description' => 'Quarterly OS updates, driver updates, and disk cleanup.', 'cost' => 0.00,   'status' => 'completed',   'scheduled_at' => date('Y-m-d', strtotime('-30 days')), 'completed_at' => date('Y-m-d', strtotime('-28 days')), 'created_at' => $now],
            ['asset_id' => 9, 'user_id' => 1, 'type' => 'inspection',  'technician' => 'Mike Torres',  'description' => 'Annual server health check, RAID integrity test, and firmware update.', 'cost' => 200.00, 'status' => 'completed',   'scheduled_at' => date('Y-m-d', strtotime('-60 days')), 'completed_at' => date('Y-m-d', strtotime('-58 days')), 'created_at' => $now],
            ['asset_id' => 4, 'user_id' => 2, 'type' => 'upgrade',     'technician' => 'Sarah Chen',   'description' => 'Firmware upgrade to latest stable version.', 'cost' => 0.00,   'status' => 'scheduled',   'scheduled_at' => date('Y-m-d', strtotime('+7 days')),  'completed_at' => null, 'created_at' => $now],
            ['asset_id' => 7, 'user_id' => 3, 'type' => 'corrective',  'technician' => 'James Park',   'description' => 'Paper jam repair and roller replacement.', 'cost' => 45.00,  'status' => 'completed',   'scheduled_at' => date('Y-m-d', strtotime('-15 days')), 'completed_at' => date('Y-m-d', strtotime('-14 days')), 'created_at' => $now],
        ]);

        // Transactions
        $this->db->table('transactions')->insertBatch([
            ['ref_code' => 'TXN-001', 'asset_id' => 1, 'user_id' => 2, 'type' => 'checkout', 'quantity' => 1, 'from_location' => 'IT Storage',     'to_location' => 'IT Department',   'assigned_to' => 'John Doe',   'notes' => 'Assigned for development work.', 'created_at' => date('Y-m-d H:i:s', strtotime('-20 days'))],
            ['ref_code' => 'TXN-002', 'asset_id' => 2, 'user_id' => 2, 'type' => 'checkout', 'quantity' => 1, 'from_location' => 'IT Storage',     'to_location' => 'Design Studio',   'assigned_to' => 'Jane Smith', 'notes' => 'Assigned to design team lead.', 'created_at' => date('Y-m-d H:i:s', strtotime('-18 days'))],
            ['ref_code' => 'TXN-003', 'asset_id' => 6, 'user_id' => 3, 'type' => 'checkout', 'quantity' => 2, 'from_location' => 'IT Storage',     'to_location' => 'Dev Team Area',   'assigned_to' => 'Alice Wong', 'notes' => 'Dual monitor setup for dev team.', 'created_at' => date('Y-m-d H:i:s', strtotime('-15 days'))],
            ['ref_code' => 'TXN-004', 'asset_id' => 3, 'user_id' => 2, 'type' => 'checkin',  'quantity' => 1, 'from_location' => 'Finance Dept',   'to_location' => 'IT Storage',      'assigned_to' => null,         'notes' => 'Returned for maintenance.', 'created_at' => date('Y-m-d H:i:s', strtotime('-3 days'))],
            ['ref_code' => 'TXN-005', 'asset_id' => 8, 'user_id' => 2, 'type' => 'transfer', 'quantity' => 1, 'from_location' => 'IT Storage',     'to_location' => 'Conference Room', 'assigned_to' => null,         'notes' => 'Moved for board meeting use.', 'created_at' => date('Y-m-d H:i:s', strtotime('-5 days'))],
            ['ref_code' => 'TXN-006', 'asset_id' => 11,'user_id' => 2, 'type' => 'checkout', 'quantity' => 1, 'from_location' => 'IT Storage',     'to_location' => 'HR Department',   'assigned_to' => 'Bob Lee',    'notes' => 'New hire equipment assignment.', 'created_at' => date('Y-m-d H:i:s', strtotime('-10 days'))],
        ]);
    }
}
