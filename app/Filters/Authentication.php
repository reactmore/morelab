<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Authentication implements FilterInterface
{

	public function before(RequestInterface $request, $arguments = null)
	{
		if (session()->get('vr_sess_logged_in') != TRUE) :
			return redirect()->to(base_url('/auth/login'));
		endif;
	}
	public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
	{
		//

	}
}
