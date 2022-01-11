<?php

namespace App\Models;

use CodeIgniter\Model;

class InvoicesModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'invoices';
    protected $primaryKey       = 'id';
    // protected $allowedFields = [];
    protected $useAutoIncrement = true;

    protected $useSoftDeletes = true;

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Custom 
    protected $session;
    protected $request;

    public function __construct()
    {
        parent::__construct();
        $this->session = session();
        $this->request = \Config\Services::request();
        $this->db->query("SET sql_mode = ''");
    }

    //get paginated users
    public function get_paginated($per_page, $offset)
    {


        $this->builder()->select(
            'invoices.*, 
            users.username as client_username,
            CONCAT(users.first_name, "  " , users.last_name) AS client_name'
        );



        $this->builder()->join('users', 'users.id = invoices.user_id ', 'Left')
            ->where('invoices.deleted_at', null)
            ->orderBy('invoices.id', 'ASC');
        $this->_filter();

        $query = $this->builder()->get($per_page, $offset);

        return $query->getResult();
    }


    public function get_paginated_count()
    {
        $this->builder()->select('COUNT(invoices.id) AS count, invoices.id, users.username as client_username,
        CONCAT(users.first_name, "  " , users.last_name) AS client_name');
        $this->builder()->where('invoices.deleted_at', NULL);
        $this->builder()->join('users', 'users.id = invoices.user_id ', 'Left');
        $this->_filter();
        $query = $this->builder()->get();
        return $query->getRow()->count;
    }

    public function _filter()
    {
        $request = service('request');
        $search = trim($request->getGet('search'));
        if (!empty($search)) {
            $this->builder()->groupStart()
                ->like('invoices.invoice_no', clean_str($search))
                ->orLike('users.username', clean_str($search))
                ->orLike('users.first_name', clean_str($search))
                ->orLike('users.last_name', clean_str($search))
                ->groupEnd();
        }

        $status = trim($request->getGet('status'));
        if (!empty($status)) {
            $this->builder()->where('invoices.payment_status', clean_str($status));
        }
    }

    //input values
    public function input_values()
    {
        $data = array(
            'admin_id' => user()->id,
            'invoice_no' => $this->request->getVar('invoice_no'),
            'txn_id' => generate_uuid(),
            'sub_total' => $this->request->getVar('sub_total'),
            'total_tax' => $this->request->getVar('total_tax'),
            'discount' => $this->request->getVar('discount'),
            'grand_total' => $this->request->getVar('grand_total'),
            'currency ' => 'IDR',
            'payment_option' => '',
            'payment_method' => '',
            'payment_status ' => $this->request->getVar('payment_status'),
            'client_note ' => $this->request->getVar('client_note'),
            'created_at' => date('Y-m-d H:i:s', strtotime($this->request->getVar('billing_date'))),
            'due_date' => date('Y-m-d H:i:s', strtotime($this->request->getVar('due_date')))
        );
        return $data;
    }

    public function save_invoice($id = null)
    {
        $data = $this->input_values();

        $items_detail =  array(
            'product_description' => $this->request->getVar('product_description'),
            'quantity' => $this->request->getVar('quantity'),
            'price' => $this->request->getVar('price'),
            'tax' => $this->request->getVar('tax'),
            'total' => $this->request->getVar('total'),
        );

        $data['items_detail'] = serialize($items_detail);

        $data['user_id'] = $this->request->getVar('client_id');

        if ($id) {
            return $this->protect(false)->update($id, $data);
        } else {
            return $this->protect(false)->insert($data);
        }
    }

    public function getInvoiceById($id)
    {
        $this->builder()->select(
            'invoices.*, 
            users.username as client_username,
            CONCAT(users.first_name, "  " , users.last_name) AS client_name,
            users.address as client_address'
        );

        $this->builder()->join('users', 'users.id = invoices.user_id ', 'Left')
            ->where('invoices.id', clean_number($id));

        $query = $this->builder()->get();

        return $query->getRowObject();
    }

    public function delete_invoice($id)
    {
        $id = clean_number($id);
        $invoice = $this->asObject()->find($id);
        if (!empty($invoice)) {
            return $this->where('id', $invoice->id)->delete();
        }
        return false;
    }
}
