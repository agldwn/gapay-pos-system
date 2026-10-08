<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CustomerModel;
use App\Models\UserModel;
use App\Models\SaleModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $productModel = new ProductModel();
        $customerModel = new CustomerModel();
        $userModel = new UserModel();
        $saleModel = new SaleModel();

        return view('dashboard/index', [
            'title' => 'Dashboard',
            'productCount' => $productModel->countAllResults(),
            'customerCount' => $customerModel->countAllResults(),
            'userCount' => $userModel->countAllResults(),
            'saleCount' => $saleModel->countAllResults()
        ]);
    }
}