<?php

namespace App\Filters;

use App\Models\UsersModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\IncomingRequest;

use CodeIgniter\API\ResponseTrait;
use Config\Services;


class SecureAPI implements FilterInterface
{
    use ResponseTrait;

    public function before(RequestInterface $request, $arguments = null)
    {
        helper('custom_helper');
        $enableApi = 1;
        $requests = service('request');
        // $response_test = [
        //     'status'   =>  403,
        //     'error'    => false,
        //     'messages' => 'Invalid Credentials',
        //     'data' =>   $requests->getHeader('X-Api-Key')->getValue()
        // ];
        // Services::response()->setJSON($response_test);


        // return Services::response()
        //     ->setStatusCode(ResponseInterface::HTTP_FORBIDDEN);

        if ($enableApi) {
            $userModel = new UsersModel();
            $user = $userModel->get_user_by_username($requests->getHeader('X-Api-Key')->getValue());
            if ($requests->getHeader('X-Api-Key')->getValue() == '' ||  empty($user)) {
                $response = [
                    'status'   =>  403,
                    'error'    => false,
                    'messages' => 'Invalid Credentials',
                    'data' => NULL
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
                'data' => []
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
