<?php

namespace App\Controllers;

use App\Models\AssetModel;
use App\Models\TransactionModel;

class Transactions extends BaseController
{
    protected TransactionModel $model;

    public function __construct()
    {
        $this->model = new TransactionModel();
    }

    public function index(): string
    {
        $type    = $this->request->getGet('type');
        $builder = $this->model->withAssetAndUser();
        if ($type) $builder->where('transactions.type', $type);

        $transactions = $builder->orderBy('transactions.created_at', 'DESC')->paginate(12);
        $pager        = $this->model->pager;

        return $this->render('transactions/index', compact('transactions', 'pager', 'type'));
    }

    public function new(): string
    {
        $assets = (new AssetModel())->where('status', 'active')->orderBy('name', 'ASC')->findAll();
        return $this->render('transactions/form', compact('assets'));
    }

    public function create()
    {
        $rules = [
            'asset_id' => 'required|integer',
            'type'     => 'required|in_list[checkout,checkin,transfer]',
            'quantity' => 'required|integer|greater_than[0]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $assetId  = (int) $this->request->getPost('asset_id');
        $type     = $this->request->getPost('type');
        $quantity = (int) $this->request->getPost('quantity');

        $asset = (new AssetModel())->find($assetId);
        if (! $asset) return redirect()->back()->with('error', 'Asset not found.');

        if ($type === 'checkout' && $asset['quantity'] < $quantity) {
            return redirect()->back()->withInput()->with('error', 'Insufficient quantity available.');
        }

        $this->model->insert([
            'ref_code'      => $this->model->generateRef(),
            'asset_id'      => $assetId,
            'user_id'       => session()->get('user_id'),
            'type'          => $type,
            'quantity'      => $quantity,
            'from_location' => esc($this->request->getPost('from_location')),
            'to_location'   => esc($this->request->getPost('to_location')),
            'assigned_to'   => esc($this->request->getPost('assigned_to')),
            'notes'         => esc($this->request->getPost('notes')),
        ]);

        // Adjust quantity
        $assetModel = new AssetModel();
        if ($type === 'checkout') {
            $assetModel->update($assetId, [
                'quantity'    => $asset['quantity'] - $quantity,
                'assigned_to' => esc($this->request->getPost('assigned_to')),
                'location'    => esc($this->request->getPost('to_location')),
            ]);
        } elseif ($type === 'checkin') {
            $assetModel->update($assetId, [
                'quantity'    => $asset['quantity'] + $quantity,
                'assigned_to' => null,
                'location'    => esc($this->request->getPost('to_location')),
            ]);
        } elseif ($type === 'transfer') {
            $assetModel->update($assetId, [
                'location'    => esc($this->request->getPost('to_location')),
                'assigned_to' => esc($this->request->getPost('assigned_to')),
            ]);
        }

        return redirect()->to('/transactions')->with('success', 'Transaction recorded successfully.');
    }

    public function show($id): string
    {
        $transaction = $this->model->withAssetAndUser()->find($id);
        if (! $transaction) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        return $this->render('transactions/show', compact('transaction'));
    }
}
