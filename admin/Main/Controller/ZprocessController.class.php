<?php
namespace Main\Controller;
use Think\Controller;
ulib('Page');
use Sys\Page;
use Sys\P;


class ZprocessController extends BaseController{

    protected $_pagetitle_ = '流程管理';
    protected $_pagedesc_  = '';

	// @@@NODE-3###record###待办事宜###
    public function public_index(){
        $this->title('新建流程');

		$this->display('index');
    }


	// @@@NODE-3###addrecord###新建流程###
	public  function  public_add(){
        $this->title('新建流程');

        $this->display('add');
	}

	//流程类型管理
    public function setType(){
        $this->title('流程类型管理');

        $this->display();
    }

}
