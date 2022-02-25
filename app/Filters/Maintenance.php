<?php

namespace App\Filters;

use App\Models\MenuManagementModel;
use App\Models\RolesPermissionsModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Users;

class Maintenance implements FilterInterface
{

	public function before(RequestInterface $request, $arguments = null)
	{
		helper('custom');
		if (get_general_settings()->maintenance_mode_status == 1) {
			if (!is_admin()) {
				return redirect()->to(base_url('maintenance'));
			}
		}
	}
	public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
	{
		//
	}
}
