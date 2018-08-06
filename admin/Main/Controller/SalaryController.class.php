<?php
namespace Main\Controller;
use Think\Controller;
use Sys\P;
ulib('Page');
use Sys\Page;
class SalaryController extends BaseController {
     public function salaryindex(){

         $this->assign('ptitle',人力管理);
         $this->assign('title',员工薪资);
         $this->display();
    }
    private function operationlistadd(){


    }
}