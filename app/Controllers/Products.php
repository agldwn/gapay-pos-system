<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Products extends BaseController
{
    protected $helpers = ['form', 'url'];

    public function index()
    {
        $productModel = new ProductModel();

        return view('products/index', [
            'title' => 'Products',
            'products' => $productModel->orderBy('id', 'DESC')->findAll()
        ]);
    }

    public function create()
    {
        return view('products/form', [
            'title' => 'Add Product',
            'product' => null,
            'isEdit' => false
        ]);
    }

    public function store()
    {
        $rules = [
            'name' => 'required|min_length[2]|max_length[100]',
            'price' => 'required|decimal',
            'stock_quantity' => 'required|integer|greater_than_equal_to[0]',
            'image' => 'uploaded[image]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]|max_size[image,2048]'
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $image = $this->request->getFile('image');
        $imageName = $image->getRandomName();
        $image->move(FCPATH . 'uploads/products', $imageName);

        $productModel = new ProductModel();

        $productModel->insert([
            'name' => $this->request->getPost('name'),
            'price' => $this->request->getPost('price'),
            'stock_quantity' => $this->request->getPost('stock_quantity'),
            'image' => $imageName
        ]);

        return redirect()
            ->to(site_url('products'))
            ->with('success', 'Product added successfully.');
    }

    public function edit($id)
    {
        $productModel = new ProductModel();
        $product = $productModel->find($id);

        if (!$product) {
            return redirect()
                ->to(site_url('products'))
                ->with('error', 'Product not found.');
        }

        return view('products/form', [
            'title' => 'Edit Product',
            'product' => $product,
            'isEdit' => true
        ]);
    }

    public function update($id)
    {
        $productModel = new ProductModel();
        $product = $productModel->find($id);

        if (!$product) {
            return redirect()
                ->to(site_url('products'))
                ->with('error', 'Product not found.');
        }

        $rules = [
            'name' => 'required|min_length[2]|max_length[100]',
            'price' => 'required|decimal',
            'stock_quantity' => 'required|integer|greater_than_equal_to[0]'
        ];

        $image = $this->request->getFile('image');

        if ($image && $image->isValid() && !$image->hasMoved()) {
            $rules['image'] = 'is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]|max_size[image,2048]';
        }

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $imageName = $product['image'];

        if ($image && $image->isValid() && !$image->hasMoved()) {
            $imageName = $image->getRandomName();
            $image->move(FCPATH . 'uploads/products', $imageName);

            if ($product['image']) {
                $oldImage = FCPATH . 'uploads/products/' . $product['image'];

                if (is_file($oldImage)) {
                    unlink($oldImage);
                }
            }
        }

        $productModel->update($id, [
            'name' => $this->request->getPost('name'),
            'price' => $this->request->getPost('price'),
            'stock_quantity' => $this->request->getPost('stock_quantity'),
            'image' => $imageName
        ]);

        return redirect()
            ->to(site_url('products'))
            ->with('success', 'Product updated successfully.');
    }

    public function delete($id)
    {
        $productModel = new ProductModel();
        $product = $productModel->find($id);

        if (!$product) {
            return redirect()
                ->to(site_url('products'))
                ->with('error', 'Product not found.');
        }

        if ($product['image']) {
            $imagePath = FCPATH . 'uploads/products/' . $product['image'];

            if (is_file($imagePath)) {
                unlink($imagePath);
            }
        }

        $productModel->delete($id);

        return redirect()
            ->to(site_url('products'))
            ->with('success', 'Product deleted successfully.');
    }
}