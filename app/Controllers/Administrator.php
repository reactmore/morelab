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
    public function users()
    {
        $data['title'] = trans("users");
        //paginate
        $data['paginate'] = $this->userModel->userPaginate();
        $data['pager'] =  $data['paginate']['pager'];


        return view('admin/users/users', $data);
    }
}
