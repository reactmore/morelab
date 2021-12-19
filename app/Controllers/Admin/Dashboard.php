<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseController;
use App\Helpers\Request_helper;

class Dashboard extends BaseController
{

    protected $requestHelper;

    public function __construct()
    {
        $this->requestHelper = new Request_helper();
    }

    public function index()
    {
        $data['title'] = trans('dashboard');

        return view('admin/dashboard', $data);
    }
}
