<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RolesPermissionsModel;
use App\Models\UsersModel;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
class AdminController extends BaseController
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers     = ['cookie', 'date', 'security', 'form', 'menu', 'useraccess', 'custom'];

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        $this->file_count = 60;
        $this->file_per_page = 60;

        $this->userModel      = new UsersModel();
        $this->RolesPermissionsModel      = new RolesPermissionsModel();
        $this->data = array();
        if (!empty(user())) {
            $user    = $this->userModel->getUser(user()->username);
            $segment = $this->request->uri->getSegment(2);
            if ($segment) {
                $subsegment     = $this->request->uri->getSegment(3);
            } else {
                $subsegment     = '';
            }

            $this->data            = [
                'segment'         => $segment,
                'subsegment'     => $subsegment,
                'user'             => $user,
                'MenuCategory'     => $this->RolesPermissionsModel->getAccessMenuCategory(user()->role)
            ];
        }
    }

    public function paginate($total_rows)
    {
        $per_page = 15;
        $pager = service('pager');
        //initialize pagination
        $page = $this->request->getGet('page');
        $page = clean_number($page);


        $page = $page >= 1 ? $page : $pager->getCurrentPage('default');
        $offset      = ($pager->getCurrentPage('default') - 1) * $per_page;

        $data = array(
            'per_page' => $per_page,
            'offset' =>  $offset,
            'current_page' => $pager->getCurrentPage('default'),
            'total' => $total_rows
        );

        $data['pagination'] = $pager->makeLinks($page, $per_page, $data['total'], 'custom_pager');

        return $data;
    }
}
