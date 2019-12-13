<?php
namespace Main\Controller;
use Think\Controller;
ulib('Page');
use Sys\Page;
use Sys\P;

class ChartController extends BaseController {




    //整体分析
    public function index(){

        $db = M('month_report');

        //项目总量
        $this->op_sum = M('op')->count();

        //当月采购支出
        $month = month_phase(date('Ymd'));
        $where = array('between',array($month['start'],$month['end']));
        $this->purchase = M('material_into')->where(array('type'=>0,'audit_status'=>1,'into_time'=>$where))->sum('total');

        //当月采购支出
        $month = month_phase(date('Ymd'));
        $where = array('between',array($month['start'],$month['end']));
        $this->purchase = M('material_into')->where(array('type'=>0,'audit_status'=>1,'into_time'=>$where))->sum('total');

        //当月已批预算
        $this->budget = M('op_budget')->where(array('audit_status'=>1,'create_time'=>$where))->sum('budget');

        //当月销售实收金额
        $this->settlement = M('op_settlement')->where(array('audit_status'=>1,'create_time'=>$where))->sum('shouru');


        //图表数据填充
        $this->month = implode(',',array_reverse($db->limit(12)->order('month DESC')->GetField('month',true)));

        $this->pro_new_sum = implode(',',array_reverse($db->limit(12)->order('month DESC')->GetField('pro_new_sum',true)));

        $this->pro_trip_sum = implode(',',array_reverse($db->limit(12)->order('month DESC')->GetField('pro_trip_sum',true)));

        $this->pro_settlement_sum = implode(',',array_reverse($db->limit(12)->order('month DESC')->GetField('pro_settlement_sum',true)));

        $this->pro_income = implode(',',array_reverse($db->limit(12)->order('month DESC')->GetField('pro_income',true)));

        $this->pro_profit = implode(',',array_reverse($db->limit(12)->order('month DESC')->GetField('pro_profit',true)));

        $this->pro_exp_supplier = implode(',',array_reverse($db->limit(12)->order('month DESC')->GetField('pro_exp_supplier',true)));

        $this->pro_exp_guide = implode(',',array_reverse($db->limit(12)->order('month DESC')->GetField('pro_exp_guide',true)));

        $this->pro_exp_material = implode(',',array_reverse($db->limit(12)->order('month DESC')->GetField('pro_exp_material',true)));

        $this->add_pro_sum = implode(',',array_reverse($db->limit(12)->order('month DESC')->GetField('add_pro_sum',true)));

        $this->add_line_sum = implode(',',array_reverse($db->limit(12)->order('month DESC')->GetField('add_line_sum',true)));

        $this->add_model_sum = implode(',',array_reverse($db->limit(12)->order('month DESC')->GetField('add_model_sum',true)));

        $this->add_supplier_sum = implode(',',array_reverse($db->limit(12)->order('month DESC')->GetField('add_supplier_sum',true)));

        $this->add_guide_sum = implode(',',array_reverse($db->limit(12)->order('month DESC')->GetField('add_guide_sum',true)));

        $this->add_customer_gec_sum = implode(',',array_reverse($db->limit(12)->order('month DESC')->GetField('add_customer_gec_sum',true)));

        $this->add_customer_member_sum = implode(',',array_reverse($db->limit(12)->order('month DESC')->GetField('add_customer_member_sum',true)));

        $this->material_purchase = implode(',',array_reverse($db->limit(12)->order('month DESC')->GetField('material_purchase',true)));


        $this->display('index');



    }





    //项目统计 bak(20190403)
    /*public function settlement(){

        $db = M('op_settlement');
        $kind = M('project_kind')->GetField('id,name',true);

        //获取月份和部门
        $st    = I('st',0);
        $et    = I('et',0);
        $xs    = I('xs');
        $dept  = I('dept',0);
        $js    = I('js','-1');
        $lx    = I('lx','-1');

        $yue   = I('month');
        $moon  = month_phase($yue);

        $where = array();
        $where['o.group_id'] = array('neq','');

        if($js=='1')  $where['b.audit'] = array('eq','1');
        if($js=='0')  $where['b.audit'] = array('neq','1');
        if($lx!='-1') $where['o.kind']  = $lx;
        if($st && $et){
            $where['a.audit_time'] = array('between',array(strtotime($st),strtotime($et)));
            $this->onmoon    = $st.'至'.$et.'项目统计报表';
        }else if($st){
            $where['a.audit_time'] = array('gt',strtotime($st));
            $this->onmoon    = $st.'之后项目统计报表';
        }else if($et){
            $where['a.audit_time'] = array('lt',strtotime($et));
            $this->onmoon    = $et.'之前项目统计报表';
        }else if($yue){
            $where['a.audit_time'] = array('between',array($moon['start'],$moon['end']));
            $this->onmoon    = date('Y年m月份',$moon['start']).'项目统计报表';
        }else{
            $this->onmoon    = '项目统计报表';
        }
        if($xs)   $where['o.create_user_name'] = array('like','%'.$xs.'%');
        if($dept) $where['o.create_user'] = array('in',Rolerelation($dept,1));


        $field = array();
        $field[] = 'o.op_id';
        $field[] = 'o.kind';
        $field[] = 'o.op_create_user';
        $field[] = 'o.project';
        $field[] = 'o.group_id';
        $field[] = 'o.number';
        $field[] = 'o.customer';
        $field[] = 'o.create_user_name';
        $field[] = 'o.destination';
        $field[] = 'o.days';
        $field[] = 'o.remark';
        $field[] = 'y.xinzhi';
        $field[] = 'a.audit_time';
        $field[] = 'b.audit';
        $field[] = 'b.renshu as js_renshu';
        $field[] = 'b.shouru as js_shouru';
        $field[] = 'b.maoli as js_maoli';
        $field[] = 'b.maolilv as js_maolilv';
        $field[] = 'b.renjunmaoli as js_renjunmaoli';
        $field[] = 'y.renshu as ys_renshu';
        $field[] = 'y.shouru as ys_shouru';
        $field[] = 'y.maoli as ys_maoli';
        $field[] = 'y.maolilv as ys_maolilv';
        $field[] = 'y.renjunmaoli as ys_renjunmaoli';

        $count = $db->table('__OP__ as o')->field(implode(',',$field))
            ->join('__OP_SETTLEMENT__ as b on b.op_id = o.op_id','LEFT')
            ->join('__OP_BUDGET__ as y on y.op_id = o.op_id','LEFT')
            ->join('__AUDIT_LOG__ as a on a.req_id = b.id and a.req_type = 801','LEFT')
            ->where($where)->count();
        $page = new Page($count, P::PAGE_SIZE);
        $this->pages = $page->show();


        $datalist = $db->table('__OP__ as o')->field(implode(',',$field))
            ->join('__OP_SETTLEMENT__ as b on b.op_id = o.op_id','LEFT')
            ->join('__OP_BUDGET__ as y on y.op_id = o.op_id','LEFT')
            ->join('__AUDIT_LOG__ as a on a.req_id = b.id and a.req_type = 801','LEFT')
            ->where($where)->limit($page->firstRow . ',' . $page->listRows)
            ->order('b.create_time DESC')->select();

        foreach($datalist as $k=>$v){

            if($v['audit']==1){
                $datalist[$k]['renshu']      = $v['js_renshu'];
                $datalist[$k]['shouru']      = $v['js_shouru'];
                $datalist[$k]['maoli']       = $v['js_maoli'];
                $datalist[$k]['maolilv']     = $v['js_maolilv'];
                $datalist[$k]['renjunmaoli'] = $v['js_renjunmaoli'];
            }else{
                $datalist[$k]['renshu']      = '<span class="yellow">'.$v['ys_renshu'].'</span>';
                $datalist[$k]['shouru']      = '<span class="yellow">'.$v['ys_shouru'].'</span>';
                $datalist[$k]['maoli']       = '<span class="yellow">'.$v['ys_maoli'].'</span>';
                $datalist[$k]['maolilv']     = '<span class="yellow">'.$v['ys_maolilv'].'</span>';
                $datalist[$k]['renjunmaoli'] = '<span class="yellow">'.$v['ys_renjunmaoli'].'</span>';
            }

            //计调
            //$jd = M('op_record')->where(array('op_id'=>$v['op_id'],'explain'=>'保存成本核算'))->order('id DESC')->find();
            //$datalist[$k]['jidiao'] = $jd['uname'];

            //获取结算时间
            $datalist[$k]['jiesuanshijian'] = $v['audit_time'] ? date('Y-m-d',$v['audit_time']) : '<span class="yellow">未结算</span>';

            //格式化类型
            $datalist[$k]['leixing'] = $kind[$v['kind']];
        }


        $this->dept      = $dept;
        $this->kind      = $kind;
        $this->js        = $js;
        $this->lx        = $lx;
        $this->month     = I('month');
        $this->moon      = $yue ? $moon : month_phase(date('Ymd'));

        $url = array();
        if($st)          $url['st']    = $st;
        if($et)          $url['et']    = $et;
        if($xs)          $url['xs']    = $xs;
        if($dept)        $url['dept']  = $dept;
        if($yue)         $url['month'] = $yue;
        if($js!='-1')    $url['js']    = $js;
        $this->exporturl = U('Export/chart_settlement',$url);

        $this->datalist  = $datalist;
        $this->display('settlement');



    }*/




    //财务统计
    public function finance(){

        $db			= M('op_settlement');
        $post 		= C('POST_TEAM');
        $postmore	= C('POST_TEAM_MORE');

        //获取月份和部门
        $st    		= I('st',0);
        $et    		= I('et',0);
        $xs    		= I('xs');
        $dept  		= I('dept',0);
        $uid        = I('uid',0);

        //获取团队相关数据
        $where = array();
        $where['roleid'] = array('in',$postmore[$dept]);
        $where['status'] = array('eq',0);
        $users = M('account')->where($where)->select();
        $ulist = array();
        foreach($users as $k=>$v){
            $ulist[] = $v['id'];
        }


        $yue   = I('month');
        $moon  = month_phase($yue);

        $where = array();
        $where['b.audit_status'] = 1;
        $where['l.req_type']	= 801;
        if($st && $et){
            $where['l.audit_time'] = array('between',array(strtotime($st),strtotime($et)));
            $this->onmoon    = $st.'至'.$et.'结算报表';
        }else if($st){
            $where['l.audit_time'] = array('gt',strtotime($st));
            $this->onmoon    = $st.'之后结算报表';
        }else if($et){
            $where['l.audit_time'] = array('lt',strtotime($et));
            $this->onmoon    = $et.'之前结算报表';
        }else if($yue){
            $where['l.audit_time'] = array('between',array($moon['start'],$moon['end']));
            $this->onmoon    = date('Y年m月份',$moon['start']).'结算报表';
        }else{
            $this->onmoon    = '结算报表';
        }
        if($xs)   $where['o.create_user_name']	= array('like','%'.$xs.'%');
        if($dept) $where['o.create_user']		= array('in',implode(',',$ulist));

        $counts             = $db->table('__OP_SETTLEMENT__ as b')->group('o.op_id')->field('b.*,o.project,o.group_id,o.number,o.customer,o.create_user_name,o.destination,o.days,o.remark,l.audit_time')->join('__OP__ as o on b.op_id = o.op_id','LEFT')->join('__AUDIT_LOG__ as l on l.req_id = b.id','LEFT')->join('__ACCOUNT__ as a on a.id = o.create_user','LEFT')->where($where)->select();
        $count              = count($counts);
        $page               = new Page($count, P::PAGE_SIZE);
        $this->pages        = $page->show();

        $datalist           = $db->table('__OP_SETTLEMENT__ as b')->group('o.op_id')->field('b.*,o.project,o.group_id,o.number,o.customer,o.create_user_name,o.destination,o.days,o.remark,l.audit_time')->join('__OP__ as o on b.op_id = o.op_id','LEFT')->join('__AUDIT_LOG__ as l on l.req_id = b.id','LEFT')->join('__ACCOUNT__ as a on a.id = o.create_user','LEFT')->where($where)->limit($page->firstRow . ',' . $page->listRows)->order('l.audit_time DESC')->select();
        foreach($datalist as $k=>$v){
            $datalist[$k]['shuihou'] = $v['maoli'] -  sprintf("%.2f", ($v['maoli']*0.06));
        }

        $kpi_sum_list       = $db->table('__OP_SETTLEMENT__ as b')->group('o.op_id')->field('b.*,o.project,o.group_id,o.number,o.customer,o.create_user_name,o.destination,o.days,o.remark,l.audit_time')->join('__OP__ as o on b.op_id = o.op_id','LEFT')->join('__AUDIT_LOG__ as l on l.req_id = b.id','LEFT')->join('__ACCOUNT__ as a on a.id = o.create_user','LEFT')->where($where)->select();
        $kpi_sum            = array();
        $kpi_sum['renshu']  = array_sum(array_column($kpi_sum_list,'renshu'));
        $kpi_sum['shouru']  = array_sum(array_column($kpi_sum_list,'shouru'));
        $kpi_sum['maoli']   = array_sum(array_column($kpi_sum_list,'maoli'));

        //获取月份的开始结束时间戳
        $this->post		= $post;
        $this->dept		= $dept;
        $this->month	= I('month');
        $this->moon		= $yue ? $moon : month_phase(date('Ymd'));
        $this->datalist	= $datalist;
        $this->kpi_total= I('kpi_total');
        $this->kpi_sum  = $kpi_sum;
        $this->uid      = $uid;


        $url = array();
        if($st)     $url['st']    = $st;
        if($et)     $url['et']    = $et;
        if($xs)     $url['xs']    = $xs;
        if($dept)   $url['dept']  = $dept;
        if($yue)    $url['month'] = $yue;

        $this->url = $url;
        $this->exporturl = U('Export/chart_finance',$url);

        $this->display('finance');



    }


    //项目统计
    public function op(){

        $db   = M();
        $year = I('year',date('Y'));
        $type = I('type');

        //年度开始时间
        $start_day = $year.'-01-01 00:00:00';
        $start = strtotime($start_day);

        //年度结束时间
        $end_day = ($year+1).'-01-01 00:00:00';
        $end = strtotime($end_day)-1;

        //年度项目总数
        $where = array();
        $where['create_time'] = array('between',array($start,$end));
        $this->zong_op = M('op')->where($where)->count();

        //年度结算项目总数
        $where = array();
        $where['a.audit_time']  = array('between',array($start,$end));
        $where['b.audit']       = 1;
        $this->zong_js = $db->table('__OP__ as o')->join('__OP_SETTLEMENT__ as b on b.op_id = o.op_id','LEFT')->join('__AUDIT_LOG__ as a on a.req_id = b.id and a.req_type = 801','LEFT')->where($where)->count();

        //年度总收入（已结算）
        $this->zong_sr = $db->table('__OP__ as o')->join('__OP_SETTLEMENT__ as b on b.op_id = o.op_id','LEFT')->join('__AUDIT_LOG__ as a on a.req_id = b.id and a.req_type = 801','LEFT')->where($where)->sum('b.shouru');

        //年度总毛利（已结算）
        $this->zong_ml = $db->table('__OP__ as o')->join('__OP_SETTLEMENT__ as b on b.op_id = o.op_id','LEFT')->join('__AUDIT_LOG__ as a on a.req_id = b.id and a.req_type = 801','LEFT')->where($where)->sum('b.maoli');



        //各部门收入统计
        $this->jwdata_sr = business('京外',$year);
        $this->xndata_sr = business('校内',$year);
        $this->xwdata_sr = business('校外',$year);

        //各部门收入统计
        $this->jwdata_ml = business('京外',$year,2);
        $this->xndata_ml = business('校内',$year,2);
        $this->xwdata_ml = business('校外',$year,2);


        $this->year = $year;
        $this->display('op');

    }


    //结算周期统计
    public function cycle(){

        $db   = M();
        $year = I('year',date('Y'));
        $type = I('type');

        //年度开始时间
        $start_day = $year.'-01-01 00:00:00';
        $start = strtotime($start_day);

        //年度结束时间
        $end_day = ($year+1).'-01-01 00:00:00';
        $end = strtotime($end_day)-1;


        //各部门收入统计
        $this->jwdata_zq = cycle('京外',$year,2);
        $this->xndata_zq = cycle('校内',$year,2);
        $this->xwdata_zq = cycle('校外',$year,2);

        //P($this->jwdata_ml);

        $this->year = $year;
        $this->display('cycle');

    }


    //项目提成分析
    public function op_tc(){

        $db   = M();
        $year = I('year',date('Y'));



        $this->jidiao_data = ticheng($year,1);
        $this->yanfa_data  = ticheng($year,2);

        $this->year = $year;
        $this->display('op_tc');

    }



    //项目数量统计
    public function opsum(){

        $db   = M();
        $year = I('year',date('Y'));
        $type = I('type',1);

        $jqxw    = array();
        $jqxn    = array();
        $jwyw    = array();
        $cgly    = array();
        $zong    = array();

        for($i=1;$i<=12;$i++){
            $date = $year.'-'.$i.'-01';

            //京区校外
            $jqxwsum = op_sum($date,$type,33);
            $jqxw[]  = $jqxwsum ? intval($jqxwsum) : 0;

            //京区校内
            $jqxnsum = op_sum($date,$type,35);
            $jqxn[]  = $jqxnsum ? intval($jqxnsum) : 0;

            //京外业务
            $jwywsum = op_sum($date,$type,18);
            $jwyw[]  = $jwywsum ? intval($jwywsum) : 0;

            //常规旅游
            $cglysum = op_sum($date,$type,19);
            $cgly[]  = $cglysum ? intval($cglysum) : 0;

            //总计
            $zongsum = op_sum($date,$type,0);
            $zong[]  = $zongsum ? intval($zongsum) : 0;

        }

        $rs = array();
        $rs[0]['name'] = '京区校内';
        $rs[0]['data'] = $jqxn;
        $rs[1]['name'] = '京区校外';
        $rs[1]['data'] = $jqxw;
        $rs[2]['name'] = '京外业务';
        $rs[2]['data'] = $jwyw;
        $rs[3]['name'] = '常规业务';
        $rs[3]['data'] = $cgly;
        $rs[4]['name'] = '总计';
        $rs[4]['data'] = $zong;

        echo json_encode($rs);


    }




    //项目收入统计
    public function opincome(){

        $db   = M();
        $year = I('year',date('Y'));
        $type = I('type',1);

        $jqxw    = array();
        $jqxn    = array();
        $jwyw    = array();
        $cgly    = array();
        $zong    = array();

        for($i=1;$i<=12;$i++){
            $date = $year.'-'.$i.'-01';

            //京区校外
            $jqxwsum = op_income($date,$type,33);
            $jqxw[]  = $jqxwsum ? floatval($jqxwsum) : 0;

            //京区校内
            $jqxnsum = op_income($date,$type,35);
            $jqxn[]  = $jqxnsum ? floatval($jqxnsum) : 0;

            //京外业务
            $jwywsum = op_income($date,$type,18);
            $jwyw[]  = $jwywsum ? floatval($jwywsum) : 0;

            //常规旅游
            $cglysum = op_income($date,$type,19);
            $cgly[]  = $cglysum ? floatval($cglysum) : 0;

            //总计
            $zongsum = op_income($date,$type,0);
            $zong[]  = $zongsum ? floatval($zongsum) : 0;

        }

        $rs = array();
        $rs[0]['name'] = '京区校内';
        $rs[0]['data'] = $jqxn;
        $rs[1]['name'] = '京区校外';
        $rs[1]['data'] = $jqxw;
        $rs[2]['name'] = '京外业务';
        $rs[2]['data'] = $jwyw;
        $rs[3]['name'] = '常规业务';
        $rs[3]['data'] = $cgly;
        $rs[4]['name'] = '总计';
        $rs[4]['data'] = $zong;

        echo json_encode($rs);


    }

    //个人业绩排行榜
    public function pplist(){
        $year           = I('year',date('Y'));
        $yearTime       = getYearTime($year);

        $db		= M('op');
        $roles	= M('role')->GetField('id,role_name',true);
        $dep    = M('salary_department')->getField('id,department',true);

        //查询所有业务人员信息
        $where                      = array();
        $where['status']			= 0;
        $arr_position_ids           = get_business_position_ids(); //所有业务岗ID

        $field = array();
        $field[] =  'id as create_user';
        $field[] =  'nickname as create_user_name';
        $field[] =  'roleid';
        $field[] =  'departmentid';
        $field[] =  'position_id';

        $lists = M('account')->field($field)->where($where)->select();

        foreach($lists as $k=>$v){

            $lists[$k]['rolename'] 	=  $roles[$v['roleid']];
            $lists[$k]['department']=  $dep[$v['departmentid']];

            //查询2018年度总收入
            $all = personal_income($v['create_user'],0,$yearTime);
            $lists[$k]['zsr'] = $all['zsr'];
            $lists[$k]['zml'] = $all['zml'];
            $lists[$k]['mll'] = $all['mll'];
            $lists[$k]['year_partner_money'] = $all['partner_money'];

            //查询当月总收入'
            $mon = personal_income($v['create_user'],1,$yearTime);
            $lists[$k]['ysr'] = $mon['zsr'];
            $lists[$k]['yml'] = $mon['zml'];
            $lists[$k]['yll'] = $mon['mll'];
            $lists[$k]['month_partner_money'] = $mon['partner_money'];

        }

        $arr  = array();
        foreach ($lists as $kk=>$vv){
            if ($vv['zsr'] != 0.00 || in_array($vv['position_id'],$arr_position_ids)){
                $arr[] = $vv;
            }
        }

        $this->lists    = $arr;
        $this->year 	= $year;
        $this->prveyear	= $year-1;
        $this->nextyear	= $year+1;

        $this->display('pplist');
    }



    //团队业绩排行榜
    public function tplist(){

        $year           = I('year',date('Y'));
        $times          = getYearTime($year);

        $departids      = C('YW_DEPARTS');  //业务部门id
        $post           = M('salary_department')->where(array('id'=>array('in',$departids)))->getField('id,department,manager_name',true);

        foreach($post as $k=>$v){
            $lists[$k]				= tplist($v,$times);
            $lists[$k]['rolename']	= $v['department'];
            $lists[$k]['fzr']       = $v['manager_name'];
        }

        $this->lists    = $lists;
        $this->year 	= $year;
        $this->prveyear	= $year-1;
        $this->nextyear	= $year+1;
        $this->display('tplist');
    }


    //团队人均排行榜
    public function tpavglist(){
        $mod        = D('Chart');
        $year       = I('year',date('Y'));
        if (date('m')=='01'){   //月份人数从上个月获取
            $yearMonth = ($year-1).date('m',strtotime("-1 month"));    //上个月
        }else{
            $yearMonth  = $year.date('m',strtotime("-1 month"));    //上个月
        }
        $times          = getYearTime($year);

        $departids      = C('YW_DEPARTS');  //业务部门id
        $post           = M('salary_department')->where(array('id'=>array('in',$departids)))->getField('id,department,manager_name',true);
        foreach($post as $k=>$v){
            $userInfo               = $mod->getMonthUser_business($v,$yearMonth);
            $lists[$k]				= tplist($v,$times);
            $lists[$k]['rolename']	= $v['department'];
            $lists[$k]['fzr']       = $v['manager_name'];
            $lists[$k]['sumMonth']  = $userInfo[$yearMonth]['sumMonth'];
            $lists[$k]['sumYear']   = $userInfo['sumYear'];
        }

        $this->lists    = $lists;
        $this->year 	= $year;
        $this->prveyear	= $year-1;
        $this->nextyear	= $year+1;
        $this->display('tpavglist');
    }


    //团队业绩详情
    public function tpmore(){
        $year           = I('year',date('Y'));
        $yearTime       = array();
        if ($year <2018){
            $yearBegin  = strtotime('2017-12-26');
            $yearEnd    = strtotime('2018-12-26');
        }else{
            $yearBegin  = strtotime(($year-1).'-12-26');
            $yearEnd    = strtotime($year.'-12-26');
        }
        $yearTime[]     = $yearBegin;
        $yearTime[]     = $yearEnd;

        $dept		    = I('dept');
        $field          = array();
        $field[]        =  'id as create_user';
        $field[]        =  'nickname as create_user_name';
        $field[]        =  'departmentid';
        $lists	        = M('account')->field($field)->where(array('departmentid'=>$dept,'status'=>0))->select();
        $department     = M('salary_department')->where(array('id'=>$dept))->find();

        foreach($lists as $k=>$v){

            $lists[$k]['rolename'] 	=  $department['department'];

            //查询2018年度总收入
            $all = personal_income($v['create_user'],0,$yearTime);
            $lists[$k]['zsr'] = $all['zsr'];
            $lists[$k]['zml'] = $all['zml'];
            $lists[$k]['mll'] = $all['mll'];
            $lists[$k]['year_partner_money'] = $all['partner_money'];

            //查询当月总收入
            $mon = personal_income($v['create_user'],1,$yearTime);
            $lists[$k]['ysr'] = $mon['zsr'];
            $lists[$k]['yml'] = $mon['zml'];
            $lists[$k]['yll'] = $mon['mll'];
            $lists[$k]['month_partner_money'] = $mon['partner_money'];
        }

        $this->deptname = $department['department'];
        $this->lists    = $lists;
        $this->year 	= $year;
        $this->prveyear	= $year-1;
        $this->nextyear	= $year+1;

        $this->display('tpmore');
    }

    //数据按部门统计
    public function  department(){
        $pin            = I('pin');
        $year		    = I('year',date('Y'));
        $month		    = I('month',date('m'));
        if (strlen($month)<2) $month = str_pad($month,2,'0',STR_PAD_LEFT);
        $times          = $year.$month;
        $yw_departs     = C('YW_DEPARTS');  //业务部门id
        $where          = array();
        $where['id']    = array('in',$yw_departs);
        $departments    = M('salary_department')->field('id,department')->where($where)->select();
        //预算及结算分部门汇总
        $listdatas      = $this->count_lists($departments,$year,$month,$pin);
        $heji           = $listdatas['heji'];
        $dj_heji        = $listdatas['dj_heji'];
        unset($listdatas['dj_heji']);  //注意顺序
        unset($listdatas['heji']);  //注意顺序
        $this->lists    = $listdatas;
        $this->heji     = $heji;
        $this->dj_heji  = $dj_heji;

        $this->year 	= $year;
        $this->month 	= $month;
        $this->prveyear	= $year-1;
        $this->nextyear	= $year+1;
        $this->pin      = $pin?$pin:0;
        $this->display();
    }

    //统计部门数据(月度)
    public function count_lists($departments,$year,$month='',$pin=0,$quarter=''){
        $yearBegin      			        = ($year-1).'1226';
        $yearEnd        			        = $year.'1226';
        $yeartimes					        = array();
        $yeartimes['yearBeginTime']         = strtotime($yearBegin);
        $yeartimes['yearEndTime']           = strtotime($yearEnd);
        $yearMonth                          = $month?$year.$month:'';
        $quartertimes                       = set_quarter($year,$quarter);
        $userlists      			        = array();
        foreach ($departments as $k=>$v){
            $userlists[$v['id']]['users']   = M('account')->where(array('departmentid'=>$v['id']))->getField('id',true);
            $userlists[$v['id']]['id']      = $v['id'];
            $userlists[$v['id']]['depname'] = $v['department'];
        }

        if ($pin == 0){
            //预算及结算分部门汇总
            $lists                          = D('Chart')->ysjs_deplist($userlists,$yearMonth,$yeartimes,$pin,$quartertimes);
        }else{
            //结算分部门汇总
            $lists                          = D('Chart')->js_deplist($userlists,$yearMonth,$yeartimes,$pin,$quartertimes);
        }
        return $lists;
    }

    /**
     * summary_types 分部门分类型汇总(月度)
     * $year 年 $month 月
     * $type 类型(800=>预算 , 801=>结算)
     */
    public function summary_types(){
        $year               = trim(I('year',date('Y')));//默认或传输年份
        $month              = trim(I('month',date('m')));//默认或传输月份
        $type               = trim(I('type',800));//默认或传输 预算及结算 已结算 类型

        $yw_departs         = C('YW_DEPARTS');  //业务部门id
        $where              = array();
        $where['id']        = array('in',$yw_departs);
        $departments        = M('salary_department')->field('id,department')->where($where)->select();

        $data               = $this->department_type_summary($departments,$year,$month,$type);
        $dj_data            = $data['dijie']; //地接合计
        $heji               = $data['heji']; //分部门分类型合计(含地接)
        $sum                = $data['sum']; //总合计
        unset($data['dijie']);
        unset($data['heji']);
        unset($data['sum']);

        $this->sum          = $sum;
        $this->lists        = $data;//分部门分类型汇总数据
        $this->dijie        = $dj_data;
        $this->heji         = $heji;
        $this->month        = $month;
        $this->type         = $type;
        $this->year         = $year;
        $this->prveyear	    = $year-1;
        $this->nextyear	    = $year+1;

        $this->display();
    }

    public function department_type_summary($departments,$year,$month='',$type=800,$quarter=''){
        $chart_mod                          = D('Chart');
        $yeartimes                          = get_year_cycle($year);
        $monthtimes                         = $month?get_cycle($year.$month):'';
        $quartertimes                       = set_quarter($year,$quarter); //季度 , 备用

        $userlists      			        = array();
        foreach ($departments as $k=>$v){
            $userlists[$v['id']]['users']   = M('account')->where(array('departmentid'=>$v['id']))->getField('id',true);
            $userlists[$v['id']]['id']      = $v['id'];
            $userlists[$v['id']]['depname'] = $v['department'];
        }

        if ($type == 800){ //预算及结算分部门分类型汇总
            $data                            = $chart_mod->ysjs_department_type($userlists,$yeartimes,$monthtimes,$quartertimes);
        }else{ //结算分部门分类型汇总
            $data                            = $chart_mod->js_department_type($userlists,$yeartimes,$monthtimes,$quartertimes);
        }

        return $data;
    }

    //项目分季度统计
    public function quarter_department(){
        $pin            = I('pin');
        $year		    = I('year',date('Y'));
        $month          = I('month',date('m'));
        $quarter		= I('quarter',get_quarter($month));
        $yw_departs     = C('YW_DEPARTS');  //业务部门id
        $where          = array();
        $where['id']    = array('in',$yw_departs);
        $departments    = M('salary_department')->field('id,department')->where($where)->select();
        //预算及结算分部门汇总
        $listdatas      = $this->count_lists($departments,$year,'',$pin,$quarter);
        $heji           = $listdatas['heji'];
        $dj_heji        = $listdatas['dj_heji'];
        unset($listdatas['dj_heji']);  //注意顺序
        unset($listdatas['heji']);  //注意顺序
        $this->lists    = $listdatas;
        $this->heji     = $heji;
        $this->dj_heji  = $dj_heji;

        $this->year 	= $year;
        $this->quarter 	= $quarter;
        $this->prveyear	= $year-1;
        $this->nextyear	= $year+1;
        $this->pin      = $pin?$pin:0;
        $this->display();
    }

    //项目分部门汇总(项目数详情)
    /*public function public_oplist(){
        $opids          = I('opids');
        $arr_opids      = $opids?explode(',',$opids):'';
        $depname        = trim(I('depname'));
        $db		        = M('op');

        $title	        = I('title');		//项目名称
        $opid	        = I('id');			//项目编号
        $oid	        = I('oid');			//项目团号
        $ou		        = I('ou');			//立项人
        $kind	        = I('kind');			//类型
        $cus	        = I('cus');			//客户单位
        $jd		        = I('jd');			//计调

        $where          = array();

        $where['o.type']                                = 1;
        $where['o.op_id']                               = array('in',$arr_opids);
        if($title)			$where['o.project']			= array('like','%'.$title.'%');
        if($oid)			$where['o.group_id']		= array('like','%'.$oid.'%');
        if($opid)			$where['o.op_id']			= $opid;
        if($ou)				$where['o.create_user_name']= $ou;
        if($kind)			$where['o.kind']			= $kind;
        if($cus)			$where['o.customer']	    = $cus;
        if($jd)				$where['a.nickname']		= array('like','%'.$jd.'%');

        $field	        = 'o.*,a.nickname as jidiao';
        //分页
        $pagecount		= $db->table('__OP__ as o')->field($field)->join('__OP_AUTH__ as u on u.op_id = o.op_id','LEFT')->join('__ACCOUNT__ as a on a.id = u.line','LEFT')->where($where)->count();
        $page			= new Page($pagecount, P::PAGE_SIZE);
        $this->pages	= $pagecount>P::PAGE_SIZE ? $page->show():'';


        $lists          = $db->table('__OP__ as o')->field($field)->join('__OP_AUTH__ as u on u.op_id = o.op_id','LEFT')->join('__ACCOUNT__ as a on a.id = u.line','LEFT')->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('o.create_time'))->select();

        foreach($lists as $k=>$v){

            //判断项目是否审核通过
            if($v['audit_status']==0) $lists[$k]['zhuangtai'] = '<span class="blue">未审核</span>';
            if($v['audit_status']==1) $lists[$k]['zhuangtai'] = '<span class="blue">立项通过</span>';
            if($v['audit_status']==2) $lists[$k]['zhuangtai'] = '<span class="blue">立项未通过</span>';

            //判断预算是否通过
            $yusuan = M('op_budget')->where(array('op_id'=>$v['op_id']))->find();
            if($yusuan && $yusuan['audit_status']==0) $lists[$k]['zhuangtai'] = '<span class="green">已提交预算</span>';
            if($yusuan['audit_status']==1) $lists[$k]['zhuangtai'] = '<span class="green">预算通过</span>';
            if($yusuan['audit_status']==2) $lists[$k]['zhuangtai'] = '<span class="green">预算未通过</span>';

            //判断结算是否通过
            $jiesuan = M('op_settlement')->where(array('op_id'=>$v['op_id']))->find();
            if($jiesuan && $jiesuan['audit_status']==0) $lists[$k]['zhuangtai'] = '<span class="yellow">已提交结算</span>';
            if($jiesuan['audit_status']==1) $lists[$k]['zhuangtai'] = '<span class="yellow">完成结算</span>';
            if($jiesuan['audit_status']==2) $lists[$k]['zhuangtai'] = '<span class="yellow">结算未通过</span>';

            $settlement = M('op_settlement')->where(array('op_id'=>$v['op_id'],'audit_status'=>1))->find();
            $budget     = M('op_budget')->where(array('op_id'=>$v['op_id'],'audit_status'=>1))->find();

            $lists[$k]['shouru']    = $settlement['shouru']?$settlement['shouru']:$budget['shouru'];
            $lists[$k]['maoli']     = $settlement['maoli']?$settlement['maoli']:$budget['maoli'];
        }
        $this->lists    =  $lists;
        $this->kinds    =  M('project_kind')->getField('id,name', true);
        $this->opids    = $opids;
        $this->depname  = $depname;
        $this->display('oplist');
    }*/
    public function public_oplist(){
        $mod                                    = D('Chart');
        $uids                                   = I('uids');
        $arr_uids                               = $uids?explode(',',$uids):M('account')->getField('id',true); //公司
        $depid                                  = I('depid',0);
        $dj                                     = I('dj','');
        $depname                                = I('depname')?trim(I('depname')):($dj == 'dj' ? '地接合计':'公司合计');
        $pin                                    = I('pin',0);
        $startTime                              = I('st');
        $endTime                                = I('et');
        $db		                                = M('op');

        $title	                                = I('title');		//项目名称
        $opid	                                = I('id');			//项目编号
        $oid	                                = I('oid');			//项目团号
        $ou		                                = I('ou');			//立项人
        $kind	                                = I('kind');	    //类型
        $cus	                                = I('cus');			//客户单位
        $jd		                                = I('jd');			//计调

        if ($pin == 0){ //预算及结算
            $data                               = $mod->get_ysjs_detail_data($arr_uids,$startTime,$endTime,$dj);
            $ys_opids                           = $data['ysopids']?explode(',',$data['ysopids']):array();
            $js_opids                           = $data['jsopids']?explode(',',$data['jsopids']):array();
            $arr_opids                          = array_merge($ys_opids,$js_opids);
        }else{ //已结算
            $data                               = $mod->get_js_detail_data($arr_uids,$startTime,$endTime,$dj);
            $ys_opids                           = $data['ysopids']?explode(',',$data['ysopids']):array();
            $js_opids                           = $data['opids']?explode(',',$data['opids']):array();
            $arr_opids                          = array_merge($ys_opids,$js_opids);
        }

        $where                                  = array();
        $where['o.type']                        = 1;
        $where['o.op_id']                       = array('in',$arr_opids);
        if($title)	$where['o.project']			= array('like','%'.$title.'%');
        if($oid)	$where['o.group_id']		= array('like','%'.$oid.'%');
        if($opid)	$where['o.op_id']			= $opid;
        if($ou)		$where['o.create_user_name']= $ou;
        if($kind)	$where['o.kind']			= $kind;
        if($cus)	$where['o.customer']	    = $cus;
        if($jd)		$where['a.nickname']		= array('like','%'.$jd.'%');

        $field	        = 'o.*,a.nickname as jidiao';
        //分页
        $pagecount		= $db->table('__OP__ as o')->field($field)->join('__OP_AUTH__ as u on u.op_id = o.op_id','LEFT')->join('__ACCOUNT__ as a on a.id = u.line','LEFT')->where($where)->count();
        $page			= new Page($pagecount, P::PAGE_SIZE);
        $this->pages	= $pagecount>P::PAGE_SIZE ? $page->show():'';


        $lists          = $db->table('__OP__ as o')->field($field)->join('__OP_AUTH__ as u on u.op_id = o.op_id','LEFT')->join('__ACCOUNT__ as a on a.id = u.line','LEFT')->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('o.create_time'))->select();
        foreach($lists as $k=>$v){

            //判断项目是否审核通过
            if($v['audit_status']==0) $lists[$k]['zhuangtai'] = '<span class="blue">未审核</span>';
            if($v['audit_status']==1) $lists[$k]['zhuangtai'] = '<span class="blue">立项通过</span>';
            if($v['audit_status']==2) $lists[$k]['zhuangtai'] = '<span class="blue">立项未通过</span>';

            //判断预算是否通过
            $yusuan = M('op_budget')->where(array('op_id'=>$v['op_id']))->find();
            if($yusuan && $yusuan['audit_status']==0) $lists[$k]['zhuangtai'] = '<span class="green">已提交预算</span>';
            if($yusuan['audit_status']==1) $lists[$k]['zhuangtai'] = '<span class="green">预算通过</span>';
            if($yusuan['audit_status']==2) $lists[$k]['zhuangtai'] = '<span class="green">预算未通过</span>';

            //判断结算是否通过
            $jiesuan = M('op_settlement')->where(array('op_id'=>$v['op_id']))->find();
            if($jiesuan && $jiesuan['audit_status']==0) $lists[$k]['zhuangtai'] = '<span class="yellow">已提交结算</span>';
            if($jiesuan['audit_status']==1) $lists[$k]['zhuangtai'] = '<span class="yellow">完成结算</span>';
            if($jiesuan['audit_status']==2) $lists[$k]['zhuangtai'] = '<span class="yellow">结算未通过</span>';

            if (in_array($v['op_id'],$js_opids)){
                $list   = M('op_settlement')->where(array('op_id'=>$v['op_id'],'audit_status'=>1))->find();
            }elseif (in_array($v['op_id'],$ys_opids)){
                $list   = M('op_budget')->where(array('op_id'=>$v['op_id'],'audit_status'=>1))->find();
            }

            $lists[$k]['shouru']    = $list['shouru']?$list['shouru']:'0.00';
            $lists[$k]['maoli']     = $list['maoli']?$list['maoli']:'0.00';
            $lists[$k]['renshu']    = $list['renshu']?$list['renshu']:0;
        }
        $this->lists    =  $lists;
        $this->kinds    =  M('project_kind')->getField('id,name', true);
        $this->uids     = $uids;
        $this->dj       = $dj;
        $this->pin      = $pin;
        $this->st       = $startTime;
        $this->et       = $endTime;
        //$this->opids    = $opids;
        $this->depname  = $depname;
        $this->display('oplist');
    }

    //（月度）
    public function quarter_summary_types(){
        $year               = trim(I('year',date('Y')));//默认或传输年份
        $month              = I('month',date('m'));
        $quarter		    = I('quarter',get_quarter($month));
        $type               = trim(I('type',800));//默认或传输 预算及结算 已结算 类型

        $yw_departs         = C('YW_DEPARTS');  //业务部门id
        $where              = array();
        $where['id']        = array('in',$yw_departs);
        $departments        = M('salary_department')->field('id,department')->where($where)->select();

        $data               = $this->department_type_summary($departments,$year,'',$type,$quarter);
        $dj_data            = $data['dijie']; //地接合计
        $heji               = $data['heji']; //分部门分类型合计(含地接)
        $sum                = $data['sum']; //总合计
        unset($data['dijie']);
        unset($data['heji']);
        unset($data['sum']);

        $this->sum          = $sum;
        $this->lists        = $data;//分部门分类型汇总数据
        $this->dijie        = $dj_data;
        $this->heji         = $heji;
        $this->quarter      = $quarter;
        $this->type         = $type;
        $this->year         = $year;
        $this->prveyear	    = $year-1;
        $this->nextyear	    = $year+1;

        $this->display();
    }

}
	