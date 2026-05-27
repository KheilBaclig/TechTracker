<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table          = 'transactions';
    protected $useTimestamps  = true;
    protected $useSoftDeletes = true;
    protected $allowedFields  = [
        'ref_code', 'asset_id', 'user_id', 'type', 'quantity',
        'from_location', 'to_location', 'assigned_to', 'notes',
    ];

    public function withAssetAndUser(): static
    {
        return $this->select('transactions.*, assets.name as asset_name, assets.asset_tag, users.name as user_name')
                    ->join('assets', 'assets.id = transactions.asset_id')
                    ->join('users', 'users.id = transactions.user_id');
    }

    public function generateRef(): string
    {
        $last = $this->orderBy('id', 'DESC')->first();
        $num  = $last ? ((int) substr($last['ref_code'], 4)) + 1 : 1;
        return 'TXN-' . str_pad($num, 3, '0', STR_PAD_LEFT);
    }
}
