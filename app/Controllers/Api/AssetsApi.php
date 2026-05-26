<?php

namespace App\Controllers\Api;

use App\Models\AssetModel;
use App\Models\CategoryModel;
use App\Models\MaintenanceLogModel;
use CodeIgniter\RESTful\ResourceController;

class AssetsApi extends ResourceController
{
    protected $format = 'json';

    public function index()
    {
        $cache    = cache();
        $key      = 'api_assets_' . md5(json_encode($this->request->getGet()));
        if ($cached = $cache->get($key)) return $this->respond($cached);

        $model    = new AssetModel();
        $search   = $this->request->getGet('search');
        $category = $this->request->getGet('category_id');
        $status   = $this->request->getGet('status');
        $page     = (int) ($this->request->getGet('page') ?? 1);
        $perPage  = (int) ($this->request->getGet('per_page') ?? 15);

        $builder = $model->withCategory();
        if ($search)   $builder->like('assets.name', $search);
        if ($category) $builder->where('assets.category_id', $category);
        if ($status)   $builder->where('assets.status', $status);

        $total  = $builder->countAllResults(false);
        $assets = $builder->paginate($perPage, 'default', $page);

        $response = [
            'status' => 'success',
            'data'   => $assets,
            'meta'   => ['total' => $total, 'page' => $page, 'per_page' => $perPage],
        ];

        $cache->save($key, $response, 300);
        return $this->respond($response);
    }

    public function show($id = null)
    {
        $model = new AssetModel();
        $asset = $model->withCategory()->find($id);

        if (! $asset) return $this->failNotFound('Asset not found.');

        $maintenance = (new MaintenanceLogModel())
            ->where('asset_id', $id)
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->findAll();

        $asset['recent_maintenance'] = $maintenance;

        return $this->respond(['status' => 'success', 'data' => $asset]);
    }

    public function availability($id = null)
    {
        $model = new AssetModel();
        $asset = $model->find($id);

        if (! $asset) return $this->failNotFound('Asset not found.');

        $isAvailable = $asset['status'] === 'active' && $asset['quantity'] > 0;

        return $this->respond([
            'status'       => 'success',
            'asset_id'     => (int) $id,
            'asset_tag'    => $asset['asset_tag'],
            'name'         => $asset['name'],
            'asset_status' => $asset['status'],
            'quantity'     => (int) $asset['quantity'],
            'location'     => $asset['location'],
            'assigned_to'  => $asset['assigned_to'],
            'is_available' => $isAvailable,
            'checked_at'   => date('Y-m-d H:i:s'),
        ]);
    }

    public function categories()
    {
        $cache = cache();
        if ($cached = $cache->get('api_categories')) return $this->respond($cached);

        $categories = (new CategoryModel())->findAll();
        $response   = ['status' => 'success', 'data' => $categories];
        $cache->save('api_categories', $response, 600);

        return $this->respond($response);
    }
}
