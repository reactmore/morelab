<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseController;
use App\Models\InvoicesModel;
use App\Models\UserModel;

class InvoicesManagement extends BaseController
{
    protected $invoiceModel;

    public function __construct()
    {
        $this->invoiceModel = new InvoicesModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {

        $data['title'] = trans("invoice_management");
        $pagination = $this->paginate($this->invoiceModel->get_paginated_count());
        $data['invoices'] =  $this->invoiceModel->get_paginated($pagination['per_page'], $pagination['offset']);
        $data['paginations'] = $pagination['pagination'];



        return view('admin/invoices/list', $data);
    }

    public function add_invoice()
    {

        $data['title'] = trans("add_invoice");
        $data['client'] = $this->userModel->asObject()->where('role', 'user')->findAll();

        return view('admin/invoices/add_invoice', $data);
    }

    public function add_invoice_post()
    {
        //validate inputs
        $rules = [
            'invoice_no' => [
                'label'  => trans('invoice_no'),
                'rules'  => 'required|min_length[4]|max_length[100]',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'min_length' => trans('form_validation_min_length'),
                    'max_length' => trans('form_validation_max_length'),
                ],
            ],


        ];


        if ($this->validate($rules)) {
            if ($this->invoiceModel->save_invoice()) {

                $this->session->setFlashData('success', trans("invoice") . " " . trans("msg_suc_added"));
                return redirect()->to($this->agent->getReferrer());
            } else {
                $this->session->setFlashData('error', trans("msg_error"));
                return redirect()->back()->withInput();
            }
        } else {
            $this->session->setFlashData('errors_form', $this->validator->listErrors());
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }
    }


    public function edit_invoice($id)
    {

        $data['title'] = trans("update_profile");
        $data['invoice'] = $this->invoiceModel->asObject()->find($id);
        $data['client'] = $this->userModel->asObject()->where('role', 'user')->findAll();

        if (empty($data['invoice']->id)) {
            return redirect()->back();
        }

        return view('admin/invoices/edit_invoice', $data);
    }

    public function edit_invoice_post()
    {
        //validate inputs
        $rules = [
            'invoice_no' => [
                'label'  => trans('invoice_no'),
                'rules'  => 'required|min_length[4]|max_length[100]',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'min_length' => trans('form_validation_min_length'),
                    'max_length' => trans('form_validation_max_length'),
                ],
            ],


        ];


        if ($this->validate($rules)) {
            if ($this->invoiceModel->save_invoice($this->request->getVar('id'))) {

                $this->session->setFlashData('success', trans("invoice") . " " . trans("msg_suc_updated"));
                return redirect()->to($this->agent->getReferrer());
            } else {
                $this->session->setFlashData('error', trans("msg_error"));
                return redirect()->back()->withInput();
            }
        } else {
            $this->session->setFlashData('errors_form', $this->validator->listErrors());
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }
    }

    public function delete_invoice_post()
    {

        $id = $this->request->getVar('id');
        if ($this->invoiceModel->delete_invoice($id)) {
            $this->session->setFlashData('success', trans("invoice") . " " . trans("msg_suc_deleted"));
        } else {
            $this->session->setFlashData('error', trans("msg_error"));
        }
    }

    public function view_invoice($id)
    {

        $data['invoice'] = $this->invoiceModel->getInvoiceById($id);
        $data['title'] = $data['invoice']->invoice_no;


        if (empty($data['invoice']->id)) {
            return redirect()->back();
        }

        return view('admin/invoices/detail_invoice', $data);
    }
}
