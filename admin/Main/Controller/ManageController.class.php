<?php
namespace Main\Controller;
use Think\Controller;
use Sys\P;
ulib('Page');
use Sys\Page;
class ManageController extends BaseController {

    //月度经营报表
    public function Manage_month(){

        $this->display();
    }
    //季度经营报表
    public function Manage_quarter(){

        $this->display();
    }
    //年度经营报表
    public function Manage_year(){

        $this->display();
    }

 }
