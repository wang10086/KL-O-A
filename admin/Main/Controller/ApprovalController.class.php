<?php
namespace Main\Controller;
use Think\Controller;
use Sys\P;
ulib('Page');
use Sys\Page;
class ApprovalController extends BaseController {

    public function Approval_Index(){

        $this->display();
    }

    public function Approval_Upload(){
        $this->personnel = personnel();

        $this->display();
    }

 }