<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;
use App\Libraries\Bcrypt;
use CodeIgniter\HTTP\ResponseInterface;

class User extends ResourceController
{
    use ResponseTrait;

    protected $userModel;
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->bcrypt = new Bcrypt();
        helper('custom_helper');
        helper('text');
        helper('url');
    }

    // get all product
    public function index(): ResponseInterface
    {

        $response = [
            'status'   => 200,
            'error'    => false,
            'messages' => null,
            'data' => $this->userModel->findAll()
        ];


        return $this->respond($response);
    }



    // get single product
    public function show($id = null)
    {
        $data = $this->userModel->find($id);
        $response = [
            'status'   => 200,
            'error'    => false,
            'messages' => null,
            'data' => $data
        ];

        if ($data) {
            return $this->respond($response);
        } else {
            return $this->failNotFound('No Data Found with id ' . $id);
        }
    }

    // create a product
    public function create()
    {

        $rules = [
            'first_name'         => 'required|min_length[4]|max_length[100]',
            'last_name'         => 'required|min_length[4]|max_length[100]',
            'username'         => 'required|min_length[4]|max_length[100]',
            'email'            => 'required|max_length[200]|valid_email',
            'password'         => 'required|min_length[4]|max_length[200]',
            'confirm_password' => 'required|min_length[4]|max_length[100]|matches[password]',
        ];

        $messages = [
            "username" => [
                "required" => "Username is required"
            ],
            "email" => [
                "required" => "Email required",
                "valid_email" => "Email address is not in format",
                "is_unique" => "Email address already exists"
            ],
            "password" => [
                "required" => "Phone Number is required"
            ],
            "confirm_password" => [
                "required" => "Phone Number is required",
                "matches" => "Phone Number is required"
            ],
        ];

        if (!$this->validate($rules, $messages)) {

            $response = [
                'status' => 500,
                'error' => true,
                'message' => $this->validator->getErrors(),
                'data' => []
            ];
        } else {

            //is username unique
            if (!$this->userModel->is_unique_username($this->request->getPost('username'))) {

                $response = [
                    'status' => 500,
                    'error' => true,
                    'message' => 'The Username has already been taken.',
                    'data' => []
                ];

                return $this->respondCreated($response);
            }

            //is email unique
            if (!$this->userModel->is_unique_email($this->request->getPost('email'))) {

                $response = [
                    'status' => 500,
                    'error' => true,
                    'message' => 'The email has already been taken.',
                    'data' => []
                ];

                return $this->respondCreated($response);
            }

            $data = array(
                'username' => strtolower(remove_special_characters(trim($this->request->getPost('username')))),
                'email' => $this->request->getPost('email'),
                'password' => $this->bcrypt->hash_password($this->request->getPost('password')),
                'first_name' => $this->request->getPost('first_name'),
                'last_name' => $this->request->getPost('last_name'),
                'user_type' => 'registered',
                'token' => generate_unique_id(),
                'slug' => $this->userModel->generate_uniqe_slug($this->request->getPost('username')),
                'status' => 1,
                'role' => 'user',
                'last_seen' => date('Y-m-d H:i:s'),
            );


            $user = $this->userModel->protect(false)->insert($data);
            if ($user) {
                $response = [
                    'status' => 201,
                    'error' => false,
                    'message' => 'Employee added successfully',
                    'data' => []
                ];
            } else {
                //error
                $response = [
                    'status' => 200,
                    'error' => false,
                    'message' => 'There was a problem during registration. Please try again!',
                    'data' => []
                ];
            }
        }

        return $this->respondCreated($response);
    }

    // update product
    public function update($id = null)
    {

        $rules = [
            'first_name'         => 'required|min_length[4]|max_length[100]',
            'last_name'         => 'required|min_length[4]|max_length[100]',
            'username'         => 'required|min_length[4]|max_length[100]',
            'email'            => 'required|max_length[200]|valid_email',
        ];

        $messages = [
            "username" => [
                "required" => "Username is required"
            ],
            "email" => [
                "required" => "Email required",
                "valid_email" => "Email address is not in format",
                "is_unique" => "Email address already exists"
            ],
            "password" => [
                "required" => "Phone Number is required"
            ],

        ];

        if ($this->request->getPost('password')) {
            $rules['password'] = 'required|min_length[4]|max_length[200]';
            $messages['password'] = [
                "required" => "Phone Number is required"
            ];
        }

        if (!$this->validate($rules, $messages)) {

            $response = [
                'status' => 500,
                'error' => true,
                'message' => $this->validator->getErrors(),
                'data' => []
            ];
        } else {

            //is username unique
            if (!$this->userModel->is_unique_username($this->request->getPost('username'), $id)) {

                $response = [
                    'status' => 500,
                    'error' => true,
                    'message' => 'The Username has already been taken.',
                    'data' => []
                ];

                return $this->respondCreated($response);
            }

            //is email unique
            if (!$this->userModel->is_unique_email($this->request->getPost('email'), $id)) {

                $response = [
                    'status' => 500,
                    'error' => true,
                    'message' => 'The email has already been taken.',
                    'data' => []
                ];

                return $this->respondCreated($response);
            }

            $data = array(
                'username' => strtolower(remove_special_characters(trim($this->request->getPost('username')))),
                'email' => $this->request->getPost('email'),
                'first_name' => $this->request->getPost('first_name'),
                'last_name' => $this->request->getPost('last_name'),
            );

            if ($this->request->getPost('password')) {
                $data['password'] = $this->bcrypt->hash_password($this->request->getPost('password'));
            }


            $user = $this->userModel->protect(false)->update($id, $data);
            if ($user) {
                $response = [
                    'status' => 200,
                    'error' => false,
                    'message' => 'Updated successfully',
                    'data' => []
                ];
            } else {
                //error
                $response = [
                    'status' => 200,
                    'error' => false,
                    'message' => 'There was a problem during update. Please try again!',
                    'data' => []
                ];
            }
        }

        return $this->respondUpdated($response);
    }

    // delete product
    public function delete($id = null)
    {
        $model = new UserModel();
        $data = $model->find($id);
        if ($data) {
            $model->delete($id);
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => 'Data Deleted'
            ];

            return $this->respondDeleted($response);
        } else {
            return $this->failNotFound('No Data Found with id ' . $id);
        }
    }
}
