<?php

namespace App\Controllers;

use App\Models\SaleModel;
use App\Models\ProductModel;
use App\Models\CustomerModel;

class Sales extends BaseController
{
    protected $helpers = ['form', 'url'];

    public function index()
    {
        $saleModel = new SaleModel();

        $sales = $saleModel
            ->select(
                'sales.*, 
                products.name AS product_name,
                customers.full_name AS customer_name,
                users.full_name AS staff_name'
            )
            ->join('products', 'products.id = sales.product_id')
            ->join('customers', 'customers.id = sales.customer_id', 'left')
            ->join('users', 'users.id = sales.sold_by')
            ->orderBy('sales.id', 'DESC')
            ->findAll();

        return view('sales/index', [
            'title' => 'Sales History',
            'sales' => $sales
        ]);
    }

    public function create()
    {
        $productModel = new ProductModel();
        $customerModel = new CustomerModel();

        return view('sales/create', [
            'title' => 'Record Sale',
            'products' => $productModel
                ->where('stock_quantity >', 0)
                ->orderBy('name', 'ASC')
                ->findAll(),
            'customers' => $customerModel
                ->orderBy('full_name', 'ASC')
                ->findAll()
        ]);
    }

    public function store()
    {
        $rules = [
            'product_id' => 'required|integer',
            'customer_id' => 'permit_empty|integer',
            'quantity' => 'required|integer|greater_than[0]'
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $productId = (int) $this->request->getPost('product_id');
        $customerId = $this->request->getPost('customer_id');
        $quantity = (int) $this->request->getPost('quantity');

        $customerId = $customerId === '' ? null : (int) $customerId;

        $productModel = new ProductModel();
        $saleModel = new SaleModel();

        $product = $productModel->find($productId);

        if (!$product) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Selected product does not exist.');
        }

        if ($quantity > $product['stock_quantity']) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Not enough stock. Available quantity: ' .
                    $product['stock_quantity']
                );
        }

        $totalPrice = $product['price'] * $quantity;
        $newStock = $product['stock_quantity'] - $quantity;

        $db = \Config\Database::connect();

        $db->transStart();

        $productModel->update($productId, [
            'stock_quantity' => $newStock
        ]);

        $saleModel->insert([
            'product_id' => $productId,
            'customer_id' => $customerId,
            'sold_by' => session()->get('user_id'),
            'quantity' => $quantity,
            'total_price' => $totalPrice
        ]);

        $db->transComplete();

        if (!$db->transStatus()) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'The sale could not be recorded.');
        }

        return redirect()
            ->to(site_url('sales'))
            ->with('success', 'Sale recorded and stock updated successfully.');
    }
}