<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class CheckPermissions implements FilterInterface
{

    public function before(RequestInterface $request, $arguments = null)
    {
        if (!auth_check()) {
            return redirect()->route('admin/login');
        } else {
            if (!check_user_permission($arguments)) {

                if ($arguments[0] === 'admin_panel') {
                    return redirect()->to(base_url());
                } else {
                    return redirect()->to(admin_url());
                }
            }
        }
    }


    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
