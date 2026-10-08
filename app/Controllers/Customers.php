<?php

namespace App\Controllers;

use App\Models\CustomerModel;

class Customers extends BaseController
{
    protected $helpers = ['form', 'url'];

    public function index()
    {
        $customerModel = new CustomerModel();

        return view('customers/index', [
            'title' => 'Customers',
            'customers' => $customerModel->orderBy('id', 'DESC')->findAll()
        ]);
    }

    public function create()
    {
        return view('customers/form', [
            'title' => 'Add Customer',
            'customer' => null,
            'isEdit' => false
        ]);
    }

    public function store()
    {
        $rules = [
            'full_name' => 'required|min_length[2]|max_length[100]',
            'email' => 'required|valid_email|max_length[100]',
            'phone' => 'permit_empty|max_length[20]'
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $customerModel = new CustomerModel();

        $customerModel->insert([
            'full_name' => $this->request->getPost('full_name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone')
        ]);

        return redirect()
            ->to(site_url('customers'))
            ->with('success', 'Customer added successfully.');
    }

    public function edit($id)
    {
        $customerModel = new CustomerModel();
        $customer = $customerModel->find($id);

        if (!$customer) {
            return redirect()
                ->to(site_url('customers'))
                ->with('error', 'Customer not found.');
        }

        return view('customers/form', [
            'title' => 'Edit Customer',
            'customer' => $customer,
            'isEdit' => true
        ]);
    }

    public function update($id)
    {
        $customerModel = new CustomerModel();
        $customer = $customerModel->find($id);

        if (!$customer) {
            return redirect()
                ->to(site_url('customers'))
                ->with('error', 'Customer not found.');
        }

        $rules = [
            'full_name' => 'required|min_length[2]|max_length[100]',
            'email' => 'required|valid_email|max_length[100]',
            'phone' => 'permit_empty|max_length[20]'
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $customerModel->update($id, [
            'full_name' => $this->request->getPost('full_name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone')
        ]);

        return redirect()
            ->to(site_url('customers'))
            ->with('success', 'Customer updated successfully.');
    }

    public function delete($id)
    {
        $customerModel = new CustomerModel();
        $customer = $customerModel->find($id);

        if (!$customer) {
            return redirect()
                ->to(site_url('customers'))
                ->with('error', 'Customer not found.');
        }

        $customerModel->delete($id);

        return redirect()
            ->to(site_url('customers'))
            ->with('success', 'Customer deleted successfully.');
    }
}