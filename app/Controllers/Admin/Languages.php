<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseController;
use App\Models\EmailModel;
use App\Models\ProfileModel;

class Languages extends BaseController
{

    public function index()
    {
        $data["title"] = trans("language_settings");
        $data["languages"] = model('LanguageModel')->builder()->get()->getResultObject();

        return view('admin/language/languages', $data);
    }
}
