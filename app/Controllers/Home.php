<?php

namespace App\Controllers;

class Home extends BaseController
{


    public function index()
    {
        return view('welcome_message');
    }

    //maintenance mode
    public function maintenance()
    {
        return view('maintenance');
    }
}
