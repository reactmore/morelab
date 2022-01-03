<?php

namespace App\Filters;

use App\Models\UserModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

use CodeIgniter\API\ResponseTrait;
use Config\Services;

class SecureAPI implements FilterInterface
{
    use ResponseTrait;

    public function before(RequestInterface $request, $arguments = null)
    {
        $enableApi = 1;

        if ($enableApi) {
            $userModel = new UserModel();
            $user = $userModel->get_user_by_username($request->getHeader('X-Api-Key')->getValue());
            if ($request->getHeader('X-Api-Key')->getValue() == '' ||  empty($user)) {
                $response = [
                    'status'   =>  403,
                    'error'    => false,
                    'messages' => 'Invalid Credentials',
                ];

                Services::response()->setJSON($response);


                return Services::response()
                    ->setStatusCode(ResponseInterface::HTTP_FORBIDDEN);
            }
        } else {

            $response = [
                'status'   =>  403,
                'error'    => false,
                'messages' => 'Service API Disable',
            ];

            Services::response()->setJSON($response);

            return Services::response()
                ->setStatusCode(ResponseInterface::HTTP_FORBIDDEN);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here

    }
}
