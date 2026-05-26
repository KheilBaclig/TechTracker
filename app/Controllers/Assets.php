<?php

namespace App\Controllers;

use App\Models\AssetModel;
use App\Models\CategoryModel;
use App\Models\MaintenanceLogModel;
use App\Models\TransactionModel;

class Assets extends BaseController
{
    protected AssetModel $model;

    public function __construct()
    {
        $this->model = new AssetModel();
    }

    public function index(): string
    {
        $search   = $this->request->getGet('search');
        $category = $this->request->getGet('category');
        $status   = $this->request->getGet('status');

        $builder = $this->model->withCategory();
        if ($search)   $builder->groupStart()->like('assets.name', $search)->orLike('assets.asset_tag', $search)->orLike('assets.brand', $search)->groupEnd();
        if ($category) $builder->where('assets.category_id', $category);
        if ($status)   $builder->where('assets.status', $status);

        $total  = $builder->countAllResults(false);
        $assets = $builder->orderBy('assets.created_at', 'DESC')->paginate(12);
        $pager  = $this->model->pager;

        $categories = (new CategoryModel())->findAll();

        return $this->render('assets/index', compact('assets', 'categories', 'pager', 'search', 'category', 'status', 'total'));
    }

    public function new(): string
    {
        $categories = (new CategoryModel())->findAll();
        return $this->render('assets/form', ['asset' => null, 'categories' => $categories]);
    }

    public function create()
    {
        if (! $this->validate($this->model->validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'category_id'         => (int) $this->request->getPost('category_id'),
            'asset_tag'           => strtoupper(esc($this->request->getPost('asset_tag'))),
            'name'                => esc($this->request->getPost('name')),
            'brand'               => esc($this->request->getPost('brand')),
            'model'               => esc($this->request->getPost('model')),
            'serial_number'       => esc($this->request->getPost('serial_number')),
            'description'         => esc($this->request->getPost('description')),
            'purchase_date'       => $this->request->getPost('purchase_date') ?: null,
            'purchase_cost'       => $this->request->getPost('purchase_cost') ? (float) $this->request->getPost('purchase_cost') : null,
            'warranty_expiry'     => $this->request->getPost('warranty_expiry') ?: null,
            'location'            => esc($this->request->getPost('location')),
            'assigned_to'         => esc($this->request->getPost('assigned_to')),
            'status'              => $this->request->getPost('status'),
            'quantity'            => (int) $this->request->getPost('quantity'),
            'low_stock_threshold' => (int) ($this->request->getPost('low_stock_threshold') ?? 2),
            'notes'               => esc($this->request->getPost('notes')),
        ];

        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && ! $file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/assets', $newName);
            service('image')
                ->withFile(ROOTPATH . 'public/uploads/assets/' . $newName)
                ->fit(800, 600, 'center')
                ->save(ROOTPATH . 'public/uploads/assets/' . $newName);
            $data['image'] = $newName;
        }

        $this->model->insert($data);
        return redirect()->to('/assets')->with('success', 'Asset added successfully.');
    }

    public function show($id): string
    {
        $asset = $this->model->withCategory()->find($id);
        if (! $asset) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $maintenance = (new MaintenanceLogModel())
            ->select('maintenance_logs.*, users.name as user_name')
            ->join('users', 'users.id = maintenance_logs.user_id')
            ->where('asset_id', $id)
            ->orderBy('maintenance_logs.created_at', 'DESC')
            ->findAll();

        $transactions = (new TransactionModel())
            ->select('transactions.*, users.name as user_name')
            ->join('users', 'users.id = transactions.user_id')
            ->where('asset_id', $id)
            ->orderBy('transactions.created_at', 'DESC')
            ->findAll();

        return $this->render('assets/show', compact('asset', 'maintenance', 'transactions'));
    }

    public function edit($id): string
    {
        $asset      = $this->model->find($id);
        if (! $asset) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        $categories = (new CategoryModel())->findAll();
        return $this->render('assets/form', compact('asset', 'categories'));
    }

    public function update($id)
    {
        $asset = $this->model->find($id);
        if (! $asset) return redirect()->to('/assets')->with('error', 'Asset not found.');

        $rules = [
            'name'        => 'required|min_length[2]|max_length[200]',
            'asset_tag'   => "required|is_unique[assets.asset_tag,id,{$id}]",
            'category_id' => 'required|integer',
            'status'      => 'required|in_list[active,under_maintenance,retired,disposed]',
            'quantity'    => 'required|integer|greater_than_equal_to[0]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'category_id'         => (int) $this->request->getPost('category_id'),
            'asset_tag'           => strtoupper(esc($this->request->getPost('asset_tag'))),
            'name'                => esc($this->request->getPost('name')),
            'brand'               => esc($this->request->getPost('brand')),
            'model'               => esc($this->request->getPost('model')),
            'serial_number'       => esc($this->request->getPost('serial_number')),
            'description'         => esc($this->request->getPost('description')),
            'purchase_date'       => $this->request->getPost('purchase_date') ?: null,
            'purchase_cost'       => $this->request->getPost('purchase_cost') ? (float) $this->request->getPost('purchase_cost') : null,
            'warranty_expiry'     => $this->request->getPost('warranty_expiry') ?: null,
            'location'            => esc($this->request->getPost('location')),
            'assigned_to'         => esc($this->request->getPost('assigned_to')),
            'status'              => $this->request->getPost('status'),
            'quantity'            => (int) $this->request->getPost('quantity'),
            'low_stock_threshold' => (int) ($this->request->getPost('low_stock_threshold') ?? 2),
            'notes'               => esc($this->request->getPost('notes')),
        ];

        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && ! $file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/assets', $newName);
            service('image')
                ->withFile(ROOTPATH . 'public/uploads/assets/' . $newName)
                ->fit(800, 600, 'center')
                ->save(ROOTPATH . 'public/uploads/assets/' . $newName);
            $data['image'] = $newName;
        }

        $this->model->update($id, $data);
        return redirect()->to('/assets/' . $id)->with('success', 'Asset updated successfully.');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->to('/assets')->with('success', 'Asset deleted.');
    }
}


