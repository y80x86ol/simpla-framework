<?php

/*
 * 基础系统基础控制器
 */

namespace Illuminate\Http;

use Illuminate\View\View;

class Controller {

    public $template;

    public function __construct() {
        //初始化template
        $this->template = View::getTemplate();
    }

}