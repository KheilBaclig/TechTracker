<?php

namespace App\Models;

use CodeIgniter\Model;

class MaintenanceLogModel extends Model
{
    protected $table          = 'maintenance_logs';
    protected $useTimestamps  = true;
    protected $useSoftDeletes = true;
    protected $allowedFields  = [
        'asset_id', 'user_id', 'type', 'technician', 'description',
        'cost', 'status', 'scheduled_at', 'completed_at',
    ];

    protected $validationRules = [
        'asset_id'    => 'required|integer',
        'technician'  => 'required|min_length[2]',
        'description' => 'required|min_length[5]',
        'type'        => 'required|in_list[preventive,corrective,inspection,upgrade]',
        'status'      => 'required|in_list[scheduled,in_progress,completed,cancelled]',
    ];

    public function withAssetAndUser(): static
    {
        return $this->select('maintenance_logs.*, assets.name as asset_name, assets.asset_tag, users.name as user_name')
                    ->join('assets', 'assets.id = maintenance_logs.asset_id')
                    ->join('users', 'users.id = maintenance_logs.user_id');
    }
}
