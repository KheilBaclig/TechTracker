<?php

namespace App\Models;

use CodeIgniter\Model;

class AssetModel extends Model
{
    protected $table          = 'assets';
    protected $useTimestamps  = true;
    protected $useSoftDeletes = true;
    protected $allowedFields  = [
        'category_id', 'asset_tag', 'name', 'brand', 'model', 'serial_number',
        'description', 'purchase_date', 'purchase_cost', 'warranty_expiry',
        'location', 'assigned_to', 'status', 'quantity', 'low_stock_threshold',
        'image', 'notes',
    ];

    protected $validationRules = [
        'name'        => 'required|min_length[2]|max_length[200]',
        'asset_tag'   => 'required|is_unique[assets.asset_tag,id,{id}]',
        'category_id' => 'required|integer',
        'status'      => 'required|in_list[active,under_maintenance,retired,disposed]',
        'quantity'    => 'required|integer|greater_than_equal_to[0]',
    ];

    public function withCategory(): static
    {
        return $this->select('assets.*, categories.name as category_name')
                    ->join('categories', 'categories.id = assets.category_id');
    }

    public function getLowStock(): array
    {
        return $this->select('assets.*, categories.name as category_name')
                    ->join('categories', 'categories.id = assets.category_id')
                    ->where('assets.quantity <= assets.low_stock_threshold', null, false)
                    ->where('assets.status', 'active')
                    ->orderBy('assets.quantity', 'ASC')
                    ->findAll();
    }

    public function getStatusCounts(): array
    {
        $rows = $this->select('status, COUNT(*) as count')
                     ->groupBy('status')
                     ->findAll();
        $counts = ['active' => 0, 'under_maintenance' => 0, 'retired' => 0, 'disposed' => 0];
        foreach ($rows as $r) {
            $counts[$r['status']] = (int) $r['count'];
        }
        return $counts;
    }
}
