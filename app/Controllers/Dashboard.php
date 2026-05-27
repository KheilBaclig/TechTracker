<?php

namespace App\Controllers;

use App\Models\AssetModel;
use App\Models\CategoryModel;
use App\Models\MaintenanceLogModel;
use App\Models\TransactionModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    public function index(): string
    {
        $role = session()->get('user_role');
        if ($role === 'superadmin') return $this->superadminDashboard();
        if ($role === 'manager')    return $this->managerDashboard();
        return $this->staffDashboard();
    }

    private function superadminDashboard(): string
    {
        $assetModel  = new AssetModel();
        $maintModel  = new MaintenanceLogModel();
        $txModel     = new TransactionModel();
        $userModel   = new UserModel();

        $totalAssets      = $assetModel->countAllResults();
        $statusCounts     = $assetModel->getStatusCounts();
        $totalUsers       = $userModel->countAllResults();
        $totalMaintenance = $maintModel->countAllResults();
        $lowStockAssets   = $assetModel->getLowStock();

        $recentTx = $txModel->withAssetAndUser()
                            ->orderBy('transactions.created_at', 'DESC')
                            ->limit(6)->findAll();

        $recentMaint = $maintModel->withAssetAndUser()
                                  ->orderBy('maintenance_logs.created_at', 'DESC')
                                  ->limit(5)->findAll();

        $recentUsers = $userModel->orderBy('created_at', 'DESC')->limit(5)->findAll();

        // Asset activity last 7 days
        $activityData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date           = date('Y-m-d', strtotime("-{$i} days"));
            $activityData[] = [
                'date'      => date('M d', strtotime($date)),
                'checkouts' => (int) $txModel->where('type', 'checkout')->where('DATE(transactions.created_at)', $date)->countAllResults(),
                'checkins'  => (int) $txModel->where('type', 'checkin')->where('DATE(transactions.created_at)', $date)->countAllResults(),
            ];
        }

        $categoryStats = (new CategoryModel())
            ->select('categories.name, COUNT(assets.id) as asset_count')
            ->join('assets', 'assets.category_id = categories.id', 'left')
            ->groupBy('categories.id')
            ->findAll();

        return $this->render('dashboard/superadmin', compact(
            'totalAssets', 'statusCounts', 'totalUsers', 'totalMaintenance',
            'lowStockAssets', 'recentTx', 'recentMaint', 'recentUsers',
            'activityData', 'categoryStats'
        ));
    }

    private function managerDashboard(): string
    {
        $assetModel = new AssetModel();
        $maintModel = new MaintenanceLogModel();
        $txModel    = new TransactionModel();

        $totalAssets      = $assetModel->countAllResults();
        $statusCounts     = $assetModel->getStatusCounts();
        $totalMaintenance = $maintModel->countAllResults();
        $lowStockAssets   = $assetModel->getLowStock();

        $recentTx = $txModel->withAssetAndUser()
                            ->orderBy('transactions.created_at', 'DESC')
                            ->limit(8)->findAll();

        $pendingMaint = $maintModel->withAssetAndUser()
                                   ->whereIn('maintenance_logs.status', ['scheduled', 'in_progress'])
                                   ->orderBy('maintenance_logs.scheduled_at', 'ASC')
                                   ->limit(5)->findAll();

        $activityData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date           = date('Y-m-d', strtotime("-{$i} days"));
            $activityData[] = [
                'date'      => date('M d', strtotime($date)),
                'checkouts' => (int) $txModel->where('type', 'checkout')->where('DATE(transactions.created_at)', $date)->countAllResults(),
                'checkins'  => (int) $txModel->where('type', 'checkin')->where('DATE(transactions.created_at)', $date)->countAllResults(),
            ];
        }

        return $this->render('dashboard/manager', compact(
            'totalAssets', 'statusCounts', 'totalMaintenance',
            'lowStockAssets', 'recentTx', 'pendingMaint', 'activityData'
        ));
    }

    private function staffDashboard(): string
    {
        $assetModel = new AssetModel();
        $txModel    = new TransactionModel();

        $totalAssets    = $assetModel->countAllResults();
        $statusCounts   = $assetModel->getStatusCounts();
        $lowStockAssets = $assetModel->getLowStock();

        $recentTx = $txModel->withAssetAndUser()
                            ->orderBy('transactions.created_at', 'DESC')
                            ->limit(5)->findAll();

        $categoryStats = (new CategoryModel())
            ->select('categories.name, COUNT(assets.id) as asset_count')
            ->join('assets', 'assets.category_id = categories.id', 'left')
            ->groupBy('categories.id')
            ->findAll();

        return $this->render('dashboard/staff', compact(
            'totalAssets', 'statusCounts', 'lowStockAssets', 'recentTx', 'categoryStats'
        ));
    }

    public function profile(): string
    {
        $user = (new UserModel())->find(session()->get('user_id'));
        return $this->render('dashboard/profile', compact('user'));
    }

    public function updateProfile()
    {
        $userId = session()->get('user_id');
        $model  = new UserModel();

        if (! $this->validate(['name' => 'required|min_length[2]'])) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $data = ['name' => esc($this->request->getPost('name'))];

        $file = $this->request->getFile('avatar');
        if ($file && $file->isValid() && ! $file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/avatars', $newName);
            $data['avatar'] = $newName;
            session()->set('user_avatar', $newName);
        }

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_BCRYPT);
        }

        $model->update($userId, $data);
        session()->set('user_name', $data['name']);

        return redirect()->to('/profile')->with('success', 'Profile updated successfully.');
    }
}


//