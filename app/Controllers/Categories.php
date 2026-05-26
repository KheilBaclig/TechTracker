<?php

namespace App\Controllers;

use App\Models\AssetModel;
use App\Models\CategoryModel;

class Categories extends BaseController
{
    protected CategoryModel $model;

    public function __construct()
    {
        $this->model = new CategoryModel();
    }

    public function index(): string
    {
        $categories = $this->model->paginate(10);
        $pager      = $this->model->pager;

        // Attach asset count
        $assetModel = new AssetModel();
        foreach ($categories as &$cat) {
            $cat['asset_count'] = $assetModel->where('category_id', $cat['id'])->countAllResults();
        }

        return $this->render('categories/index', compact('categories', 'pager'));
    }

    public function new(): string
    {
        return $this->render('categories/form', ['category' => null]);
    }

    public function create()
    {
        if (! $this->validate($this->model->validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'name'        => esc($this->request->getPost('name')),
            'slug'        => url_title($this->request->getPost('name'), '-', true),
            'description' => esc($this->request->getPost('description')),
        ]);

        return redirect()->to('/categories')->with('success', 'Category created.');
    }

    public function edit($id): string
    {
        $category = $this->model->find($id);
        if (! $category) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        return $this->render('categories/form', compact('category'));
    }

    public function update($id)
    {
        $rules = [
            'name' => 'required|min_length[2]|max_length[100]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'name'        => esc($this->request->getPost('name')),
            'slug'        => url_title($this->request->getPost('name'), '-', true),
            'description' => esc($this->request->getPost('description')),
        ]);

        return redirect()->to('/categories')->with('success', 'Category updated.');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->to('/categories')->with('success', 'Category deleted.');
    }
}

