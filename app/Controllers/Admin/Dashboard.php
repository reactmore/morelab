<?php

namespace App\Controllers\Admin;

use App\Libraries\GoogleAnalytics;

class Dashboard extends AdminController
{

    public function __construct()
    {
        $this->analytics = new GoogleAnalytics();
    }

    public function index()
    {
        $data = array_merge($this->data, [
            'title'     => trans('dashboard'),
        ]);

        return view('admin/dashboard', $data);
    }

    public function Blocked()
    {
        $data = array_merge($this->data, [
            'title'     => 'Forbiden Page',

        ]);

        return view('admin/blocked', $data);
    }
}
