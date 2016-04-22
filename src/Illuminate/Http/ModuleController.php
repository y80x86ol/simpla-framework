<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Illuminate\Http;

use Illuminate\Http\Controller;
use Illuminate\View\View;

class ModuleController extends Controller {

    public $template;

    public function __construct() {
        //初始化template
        $this->template = View::getTemplate('module');
    }

}
