<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        $data['title'] = trans('dashboard');

        return view('admin/dashboard', $data);
    }
}
