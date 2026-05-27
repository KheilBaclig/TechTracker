<?php

namespace App\Controllers;

use App\Models\AssetModel;
use App\Models\MaintenanceLogModel;

class Maintenance extends BaseController
{
    protected MaintenanceLogModel $model;

    public function __construct()
    {
        $this->model = new MaintenanceLogModel();
    }

    public function index(): string
    {
        $status = $this->request->getGet('status');
        $type   = $this->request->getGet('type');

        $builder = $this->model->withAssetAndUser();
        if ($status) $builder->where('maintenance_logs.status', $status);
        if ($type)   $builder->where('maintenance_logs.type', $type);

        $total = (clone $builder)->countAllResults(false);
        $logs  = $builder->orderBy('maintenance_logs.created_at', 'DESC')->paginate(12);
        $pager = $this->model->pager;

        return $this->render('maintenance/index', compact('logs', 'pager', 'status', 'type', 'total'));
    }

    public function new(): string
    {
        $assetId = $this->request->getGet('asset_id');
        $assets  = (new AssetModel())->orderBy('name', 'ASC')->findAll();
        return $this->render('maintenance/form', ['log' => null, 'assets' => $assets, 'preselect_asset' => $assetId]);
    }

    public function create()
    {
        if (! $this->validate($this->model->validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $status = $this->request->getPost('status');
        $data   = [
            'asset_id'     => (int) $this->request->getPost('asset_id'),
            'user_id'      => session()->get('user_id'),
            'type'         => $this->request->getPost('type'),
            'technician'   => esc($this->request->getPost('technician')),
            'description'  => esc($this->request->getPost('description')),
            'cost'         => (float) ($this->request->getPost('cost') ?? 0),
            'status'       => $status,
            'scheduled_at' => $this->request->getPost('scheduled_at') ?: null,
            'completed_at' => $status === 'completed' ? ($this->request->getPost('completed_at') ?: date('Y-m-d')) : null,
        ];

        $this->model->insert($data);

        // Update asset status if maintenance is in_progress
        if ($status === 'in_progress') {
            (new AssetModel())->update($data['asset_id'], ['status' => 'under_maintenance']);
        } elseif ($status === 'completed') {
            (new AssetModel())->update($data['asset_id'], ['status' => 'active']);
        }

        return redirect()->to('/maintenance')->with('success', 'Maintenance log created.');
    }

    public function show($id): string
    {
        $log = $this->model->withAssetAndUser()->find($id);
        if (! $log) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        return $this->render('maintenance/show', compact('log'));
    }

    public function edit($id): string
    {
        $log    = $this->model->find($id);
        if (! $log) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        $assets = (new AssetModel())->orderBy('name', 'ASC')->findAll();
        return $this->render('maintenance/form', compact('log', 'assets'));
    }

    public function update($id)
    {
        $log = $this->model->find($id);
        if (! $log) return redirect()->to('/maintenance')->with('error', 'Log not found.');

        $rules = [
            'technician'  => 'required|min_length[2]',
            'description' => 'required|min_length[5]',
            'type'        => 'required|in_list[preventive,corrective,inspection,upgrade]',
            'status'      => 'required|in_list[scheduled,in_progress,completed,cancelled]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $status = $this->request->getPost('status');
        $data   = [
            'type'         => $this->request->getPost('type'),
            'technician'   => esc($this->request->getPost('technician')),
            'description'  => esc($this->request->getPost('description')),
            'cost'         => (float) ($this->request->getPost('cost') ?? 0),
            'status'       => $status,
            'scheduled_at' => $this->request->getPost('scheduled_at') ?: null,
            'completed_at' => $status === 'completed' ? ($this->request->getPost('completed_at') ?: date('Y-m-d')) : null,
        ];

        $this->model->update($id, $data);

        if ($status === 'in_progress') {
            (new AssetModel())->update($log['asset_id'], ['status' => 'under_maintenance']);
        } elseif ($status === 'completed') {
            (new AssetModel())->update($log['asset_id'], ['status' => 'active']);
        }

        return redirect()->to('/maintenance/' . $id)->with('success', 'Maintenance log updated.');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->to('/maintenance')->with('success', 'Log deleted.');
    }
}
