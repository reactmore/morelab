<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Administrator extends AdminController
{
    public function index()
    {
        $data['title'] = trans('dashboard');

        return view('admin/dashboard', $data);
    }
    public function index2()
    {
        return view('welcome_message');
    }
    public function index3()
    {
        return view('welcome_message');
    }
}
