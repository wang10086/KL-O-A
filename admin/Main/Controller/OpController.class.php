<?php
namespace Main\Controller;
use FontLib\Table\Type\post;
use phpDocumentor\Reflection\Types\Array_;
use Sys\P;

ulib('Page');
use Sys\Page;
ulib('Pinyin');
use Sys\Pinyin;

// @@@NODE-2###Op###计调操作###
class OpController extends BaseController
{

    protected $_pagetitle_ = '计调操作';
    protected $_pagedesc_ = '';

    // @@@NODE-3###index###出团计划列表###
    public function index()
    {
        $this->title('出团计划列表');

        $db = M('op');

        $title = I('title');        //项目名称
        $opid = I('id');            //项目编号
        $oid = I('oid');            //项目团号
        $dest = I('dest');            //目的地
        $ou = I('ou');            //立项人
        $status = I('status', '-1');    //成团状态
        $as = I('as', '-1');        //审核状态
        $kind = I('kind');            //类型
        $su = I('su');            //销售
        $pin = I('pin');
        $cus = I('cus');            //客户单位
        $jd = I('jd');            //计调

        $where = array();
        if ($title) $where['o.project'] = array('like', '%' . $title . '%');
        if ($oid) $where['o.group_id'] = array('like', '%' . $oid . '%');
        if ($opid) $where['o.op_id'] = $opid;
        if ($dest) $where['o.destination'] = $dest;
        if ($ou) $where['o.create_user_name'] = $ou;
        if ($status != '-1') $where['o.status'] = $status;
        if ($as != '-1') $where['o.audit_status'] = $as;
        if ($kind) $where['o.kind'] = $kind;
        if ($su) $where['o.sale_user'] = array('like', '%' . $su . '%');
        if ($cus) $where['o.customer'] = $cus;
        if ($pin == 1) $where['o.create_user'] = cookie('userid');
        if ($jd) $where['a.nickname'] = array('like', '%' . $jd . '%');
        $where['o.type'] = 1;
        if ($pin == 2) {
            $where['o.create_user'] = cookie('userid');
            $where['o.type'] = '0';
        }

        //分页
        $pagecount = $db->table('__OP__ as o')->field($field)->join('__OP_AUTH__ as u on u.op_id = o.op_id', 'LEFT')->join('__ACCOUNT__ as a on a.id = u.line', 'LEFT')->where($where)->count();
        $page = new Page($pagecount, P::PAGE_SIZE);
        $this->pages = $pagecount > P::PAGE_SIZE ? $page->show() : '';


        $field = 'o.*,a.nickname as jidiao,c.dep_time';
        $lists = $db->table('__OP__ as o')->field($field)->join('__OP_AUTH__ as u on u.op_id = o.op_id', 'LEFT')->join('__ACCOUNT__ as a on a.id = u.line', 'LEFT')->join('__OP_TEAM_CONFIRM__ as c on c.op_id=o.op_id', 'LEFT')->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('o.create_time'))->select();
        $dijie_opids = get_dijie_opids();

        foreach ($lists as $k => $v) {
            //判断是否成团
            if ($v['group_id']) {
                $lists[$k]['group_id'] = '<span class="green">' . $v['group_id'] . '</span>';
            } else {
                $lists[$k]['group_id'] = '未成团';
            }

            //判断项目是否审核通过
            if ($v['audit_status'] == 0) $lists[$k]['zhuangtai'] = '<span class="blue">未审核</span>';
            if ($v['audit_status'] == 1) $lists[$k]['zhuangtai'] = '<span class="blue">立项通过</span>';
            if ($v['audit_status'] == 2) $lists[$k]['zhuangtai'] = '<span class="blue">立项未通过</span>';

            //判断预算是否通过
            $yusuan = M('op_budget')->where(array('op_id' => $v['op_id']))->find();
            if ($yusuan && $yusuan['audit_status'] == 0) $lists[$k]['zhuangtai'] = '<span class="green">已提交预算</span>';
            if ($yusuan['audit_status'] == 1) $lists[$k]['zhuangtai'] = '<span class="green">预算通过</span>';
            if ($yusuan['audit_status'] == 2) $lists[$k]['zhuangtai'] = '<span class="green">预算未通过</span>';

            //判断结算是否通过
            $jiesuan = M('op_settlement')->where(array('op_id' => $v['op_id']))->find();
            if ($jiesuan && $jiesuan['audit_status'] == 0) $lists[$k]['zhuangtai'] = '<span class="yellow">已提交结算</span>';
            if ($jiesuan['audit_status'] == 1) $lists[$k]['zhuangtai'] = '<span class="yellow">完成结算</span>';
            if ($jiesuan['audit_status'] == 2) $lists[$k]['zhuangtai'] = '<span class="yellow">结算未通过</span>';

            if ($v['group_id']) {
                if (in_array($v['op_id'], $dijie_opids)) {
                    $lists[$k]['has_qrcode'] = ''; //不显示二维码
                } else {
                    $lists[$k]['has_qrcode'] = 1;  //显示二维码
                }
            }
        }

        $this->lists = $lists;
        $this->kinds = M('project_kind')->getField('id,name', true);
        $this->pin = $pin;

        $this->display('index');
    }


    // @@@NODE-3###plans###制定出团计划###
    public function plans()
    {
        $PinYin = new Pinyin();

        if (isset($_POST['dosubmint']) && $_POST['dosubmint']) {
            $db = M('op');
            $mod = D('Op');

            $info = I('info');
            $expert = I('expert');
            $province = I('province');
            $addr = I('addr');
            $info['op_create_user'] = cookie('rolename');
            /*if ($info['in_dijie'] == 1) {
                $info['project']        = '【发起团】'.$info['project'];
            }*/

            $exe_user_id = I('exe_user_id');
            $customer = get_customerlist();
            if (!in_array($info['customer'], $customer)) {
                $this->error('客户单位填写错误' . $db->getError());
            }

            if ($info) {
                $opid = opid();
                $info['project'] = trim($info['project']);
                $info['number'] = trim($info['number']);
                $info['departure'] = trim($info['departure']);
                $info['days'] = trim($info['days']);
                $info['customer'] = trim($info['customer']);
                //$info['context']        = trim($info['context']);
                $info['remark'] = trim($info['remark']);
                $info['expert'] = $expert ? implode(',', $expert) : 0;
                $info['create_time'] = time();
                $info['op_id'] = $opid;
                //$info['speed']          = 1;
                //$info['op_create_date'] = date('Y-m-d',time());
                $info['destination'] = $province . '--' . $addr;
                $info['create_user'] = cookie('userid');
                $info['create_user_name'] = cookie('name');
                $info['audit_status'] = 1; //项目不用审核,默认通过
                $addok = $db->add($info);
                //$this->request_audit(P::REQ_TYPE_PROJECT_NEW, $addok);

                if ($addok) {
                    $data = array();
                    $data['hesuan'] = session('userid');
                    $data['line'] = session('userid');
                    $auth = M('op_auth')->where(array('op_id' => $opid))->find();

                    if ($auth) {
                        M('op_auth')->data($data)->where(array('id' => $auth['id']))->save();
                    } else {
                        $data['op_id'] = $opid;
                        M('op_auth')->add($data);
                    }

                    //保存标准化模块
                    //if ($costacc){ $mod -> save_create_op_product($opid,$costacc); }
                    //保存标准化模块的的费用信息
                    if ($info['standard'] && $info['producted_id']) {
                        $mod->save_create_op_costacc($opid, $info['producted_id']);
                    }
                    //创建工单
                    if ($exe_user_id) {
                        $mod->save_create_op_worder($addok, $info, $exe_user_id);
                    }

                    $record = array();
                    $record['op_id'] = $opid;
                    $record['optype'] = 1;
                    $record['explain'] = '项目立项';
                    op_record($record);

                    $this->success('保存成功！', U('Op/plans_follow', array('opid' => $opid)));
                } else {
                    $this->error('保存失败' . $db->getError());
                }

            } else {
                $this->error('保存失败' . $db->getError());
            }

        } else {
            //固定线路
            $linelist = M('product_line')->field('id,title,pinyin')->where(array('type' => 2))->select();
            foreach ($linelist as $v) {
                if (!$v['pinyin']) {
                    $title = iconv("utf-8", "gb2312", trim($v['title']));
                    $pinyin = strtolower($PinYin->getFirstPY($title));
                    M('product_line')->data(array('pinyin' => $pinyin))->where(array('id' => $v['id']))->save();
                }
            }
            $this->linelist = json_encode($linelist);

            $this->userkey = get_userkey();
            $this->provinces = M('provinces')->getField('id,name', true);
            $geclist = get_customerlist(1, $PinYin); //客户名称关键字
            $this->geclist = $geclist;
            $this->geclist_str = json_encode($geclist, true);
            $this->kinds = get_project_kinds();
            $this->userlist = M('account')->where('`id`>3')->getField('id,nickname', true);
            $this->rolelist = M('role')->where('`id`>10')->getField('id,role_name', true);
            $this->apply_to = C('APPLY_TO');
            $this->dijie_names = C('DIJIE_NAME');
            $this->expert = C('EXPERT');
            //$this->arr_product = json_encode(C('ARR_PRODUCT')); //标准化模块的项目类型
            $this->title('出团计划');
            $this->display('plans');
        }
    }


    // @@@NODE-3###plans_info###出团计划###
    public function plans_info()
    {

        $opid = I('opid');
        $id = I('id');
        if ($id) {
            $op = M('op')->where($where)->find($id);
            $opid = $op['op_id'];
        } else if ($opid) {
            $where = array();
            $where['op_id'] = $opid;
            $op = M('op')->where($where)->find();
        }

        if (!$op) {
            $this->error('项目不存在');
        }

        $pro = M('product')->find($op['product_id']);
        $guide = M()->table('__OP_GUIDE__ as g')->field('g.*,c.cost,c.amount,c.total')->join('__OP_COST__ as c on c.relevant_id=g.guide_id', 'LEFT')->where(array('g.op_id' => $opid, 'c.op_id' => $opid, 'c.cost_type' => 2))->order('g.id')->select();
        $supplier = M()->table('__OP_SUPPLIER__ as s')->field('s.id as sid,s.op_id,s.supplier_id,s.supplier_name,s.city,s.kind,s.remark as sremark,c.*')->join('__OP_COST__ as c on c.relevant_id=s.supplier_id')->where(array('s.op_id' => $opid, 'c.op_id' => $opid, 'c.cost_type' => 3))->order('sid')->select();
        $member = M('op_member')->where(array('op_id' => $opid))->order('id')->select();
        $costlist = M('op_cost')->where(array('op_id' => $opid))->order('cost_type')->select();
        $shouru = $op['sale_cost'] * $op['number'];
        $chengben = M('op_cost')->where(array('op_id' => $opid))->sum('total');
        $wuzi = M()->table('__OP_MATERIAL__ as m')->field('c.*,m.*')->join('__OP_COST__ as c on m.material=c.remark')->where(array('m.op_id' => $opid, 'c.op_id' => $opid, 'c.cost_type' => 4))->order('m.id')->select();
        $pretium = M('op_pretium')->where(array('op_id' => $opid))->order('id')->select();
        $costacc = M('op_costacc')->where(array('op_id' => $opid))->order('id')->select();

        $days = M('op_line_days')->where(array('op_id' => $opid))->select();
        $opauth = M('op_auth')->where(array('op_id' => $opid))->find();
        $record = M('op_record')->where(array('op_id' => $opid))->order('id DESC')->select();


        $where = array();
        $where['req_type'] = P::REQ_TYPE_PROJECT_NEW;
        $where['req_id'] = $op['id'];
        $audit = M('audit_log')->where($where)->find();
        if ($audit['dst_status'] == 0) {
            $show = '未审批';
            $show_user = '未审批';
            $show_time = '等待审批';
        } else if ($audit['dst_status'] == 1) {
            $show = '<span class="green">已通过</span>';
            $show_user = $audit['audit_uname'];
            $show_time = date('Y-m-d H:i:s', $audit['audit_time']);
        } else if ($audit['dst_status'] == 2) {
            $show = '<span class="red">未通过</span>';
            $show_user = $audit['audit_uname'];
            $show_reason = $audit['audit_reason'];
            $show_time = date('Y-m-d H:i:s', $audit['audit_time']);
        }
        $op['showstatus'] = $show;
        $op['show_user'] = $show_user;
        $op['show_time'] = $show_time;
        $op['show_reason'] = $show_reason;

        if ($op['line_id']) {
            $linetext = M('product_line')->find($op['line_id']);
            $this->linetext = '<h4>行程来源：<a href="' . U('Product/view_line', array('id' => $linetext['id'])) . '" target="" id="travelcom">' . $linetext['title'] . '</a><input type="hidden" name="line_id" value="' . $linetext['id'] . '" ></h4>';
        } else {
            $this->linetext = '';
        }

        $this->kinds = M('project_kind')->getField('id,name', true);
        $this->user = M('account')->where('`id`>3')->getField('id,nickname', true);
        $this->op = $op;
        $this->pro = $pro;
        $this->guide = $guide;
        $this->supplier = $supplier;
        $this->member = $member;
        $this->pretium = $pretium;
        $this->costacc = $costacc;
        $this->costlist = $costlist;
        $this->chengben = $chengben;
        $this->shouru = $shouru;
        $this->wuzi = $wuzi;
        $this->days = $days;
        $this->opauth = $opauth;
        $this->record = $record;
        $this->business_depts = C('BUSINESS_DEPT');
        $this->subject_fields = C('SUBJECT_FIELD');
        $this->ages = C('AGE_LIST');
        $this->display('plans_info');
    }


    // @@@NODE-3###plans_follow###项目跟进###
    public function plans_follow()
    {

        header('Content-Type:text/html;charset=utf-8');
        $opid = I('opid');
        $id = I('id');
        if ($id) {
            $where = array();
            $where['id'] = $id;
            $op = M('op')->where($where)->find($id);
            $opid = $op['op_id'];
        } else if ($opid) {
            $where = array();
            $where['op_id'] = $opid;
            $op = M('op')->where($where)->find();
        }

        if (!$op) {
            $this->error('项目不存在');
        }

        $pro = M('product')->find($op['product_id']);
        $guide = M()->table('__GUIDE_PAY__ as p')->field('g.*,p.guide_id,p.op_id,p.num,p.price,p.total,p.really_cost,p.remark,k.name as kind')->join('left join __GUIDE__ as g on p.guide_id=g.id')->join('left join __GUIDEKIND__ as k on g.kind=k.id')->where(array('p.op_id' => $opid))->select();
        $guide_old = M('op_cost')->field('remark as name, cost as price, amount as num,total as really_cost')->where(array('op_id' => $opid, 'cost_type' => 2))->select();
        $supplier = M()->table('__OP_SUPPLIER__ as s')->field('s.id as sid,s.op_id,s.supplier_id,s.supplier_name,s.city,s.kind,s.remark as sremark,c.*')->join('__OP_COST__ as c on c.link_id=s.id')->where(array('s.op_id' => $opid, 'c.op_id' => $opid, 'c.cost_type' => 3))->order('sid')->select();
        $member = M('op_member')->where(array('op_id' => $opid))->order('id')->select();
        $costlist = M('op_cost')->where(array('op_id' => $opid))->order('cost_type')->select();
        $shouru = $op['sale_cost'] * $op['number'];
        $chengben = M('op_cost')->where(array('op_id' => $opid))->sum('total');
        $wuzi = M()->table('__OP_MATERIAL__ as m')->field('c.*,m.*')->join('__OP_COST__ as c on m.id=c.link_id')->where(array('m.op_id' => $opid, 'c.op_id' => $opid, 'c.cost_type' => 4))->order('m.id')->select();
        $pretium = M('op_pretium')->where(array('op_id' => $opid))->order('id')->select();
        $costacc = M('op_costacc')->where(array('op_id' => $opid))->order('id')->select();
        $yusuan = M('op_costacc')->where(array('op_id' => $opid, 'status' => 1))->order('id')->select();

        $opauth = M('op_auth')->where(array('op_id' => $opid))->find();
        $record = M('op_record')->where(array('op_id' => $opid))->order('id DESC')->select();
        $budget = M('op_budget')->where(array('op_id' => $opid))->find();
        $settlement = M('op_settlement')->where(array('op_id' => $opid))->find();

        //根据line_id判断是普通线路还是固定线路
        $line_id = $op['line_id'];
        $line_type = M('product_line')->where(array('id' => $line_id))->getField('type');
        if ($line_type == 2) {
            //固定线路
            $days = M('product_line_days')->where(array('line_id' => $line_id))->select();
            $days['op_id'] = $opid;
        } else {
            //普通行程
            $days = M('op_line_days')->where(array('op_id' => $opid))->select();
        }

        $where = array();
        $where['req_type'] = P::REQ_TYPE_PROJECT_NEW;
        $where['req_id'] = $op['id'];
        $audit = M('audit_log')->where($where)->find();
        if ($audit['dst_status'] == 0) {
            $show = '系统默认通过';
            $show_user = '系统默认';
            $show_time = date('Y-m-d H:i:s', $op['create_time']);
        } else if ($audit['dst_status'] == 1) {
            $show = '<span class="green">已通过</span>';
            $show_user = $audit['audit_uname'];
            $show_time = date('Y-m-d H:i:s', $audit['audit_time']);
        } else if ($audit['dst_status'] == 2) {
            $show = '<span class="red">未通过</span>';
            $show_user = $audit['audit_uname'];
            $show_reason = $audit['audit_reason'];
            $show_time = date('Y-m-d H:i:s', $audit['audit_time']);
        }
        $op['showstatus'] = $show;
        $op['show_user'] = $show_user;
        $op['show_time'] = $show_time;
        $op['show_reason'] = $show_reason;

        /*if($op['line_id']){
			$linetext           = M('product_line')->find($op['line_id']);
			$this->linetext     = '<h4>已选方案：<a href="'.U('Product/view_line',array('id'=>$linetext['id'])).'" target="_blank" id="travelcom">'.$linetext['title'].'</a><input type="hidden" name="line_id" value="'.$linetext['id'].'" ></h4>';
		}else{
			$this->linetext     = '';
		}*/
        $this->line_list = $op['line_id'] ? M('product_line')->find($op['line_id']) : ''; //线路
        $this->producted_list = $op['producted_id'] ? M('producted')->find($op['producted_id']) : ''; //标准化产品

        //自动生成团号
        $roles = M('role')->where(array('role_name' => $op['op_create_user']))->find();
        $tuanhao = $roles['name'] . str_replace("-", "", $op['departure']);
        //验证团号是否可用
        $istuanhao = M('op')->where(array('group_id' => array('like', '%' . $tuanhao . '%')))->count();
        if ($istuanhao) {
            $this->tuanhao = $tuanhao . '-' . ($istuanhao);
        } else {
            $this->tuanhao = $tuanhao;
        }

        //项目类型
        $fixed_lineids = M('product_line')->where(array('type' => 2))->getField('id', true);    //固定线路
        if (in_array($line_id, $fixed_lineids)) {
            $this->isFixedLine = 1;
        }
        $guide_pk_id = M('guide_pricekind')->field('id,name')->select();
        $sum_cost = 0;
        foreach ($guide as $k => $v) {
            $sum_cost += $v['really_cost'];
            foreach ($guide_pk_id as $val) {
                if ($v['gpk_id'] == $val['id']) {
                    $guide[$k]['gpk_name'] = $val['name'];
                }
            }
        }
        $sum_cost_old = 0;
        foreach ($guide_old as $k => $v) {
            $sum_cost_old += $v['really_cost'];
            foreach ($guide_pk_id as $val) {
                if ($v['gpk_id'] == $val['id']) {
                    $guide[$k]['gpk_name'] = $val['name'];
                }
            }
        }
        //获取职能类型
        $priceKind = M()->table('__GUIDE_PRICEKIND__ as gpk')->field('gpk.id,gpk.name')->join('left join __OP__ as op on gpk.pk_id = op.kind')->where(array("op.op_id" => $opid))->select();
        $this->price_kind = $priceKind;
        $this->opid = $opid;
        $this->fa = I('fa', 0);
        //$this->kinds          = M('project_kind')->getField('id,name', true);
        $this->kinds = get_project_kinds();
        $this->user = M('account')->where('`id`>3')->getField('id,nickname', true);
        $this->rolelist = M('role')->where('`id`>10')->getField('id,role_name', true);
        $this->op = $op;
        $this->pro = $pro;
        $this->budget = $budget;
        $this->sum_cost = $sum_cost ? $sum_cost : $sum_cost_old;
        $this->settlement = $settlement;
        $this->supplier = $supplier;
        $this->member = $member;
        $this->pretium = $pretium;
        $this->costacc = $costacc;
        $this->costlist = $costlist;
        $this->chengben = $chengben;
        $this->shouru = $shouru;
        $this->wuzi = $wuzi;
        $this->days = $days;
        $this->opauth = $opauth;
        $this->record = $record;
        $this->business_depts = C('BUSINESS_DEPT');
        $this->subject_fields = C('SUBJECT_FIELD');
        $this->product_type = C('PRODUCT_TYPE');
        $this->product_from = C('PRODUCT_FROM');
        $this->reckon_mode = C('RECKON_MODE');
        $this->ages = C('AGE_LIST');
        $this->guide = $guide ? $guide : $guide_old;
        $this->dijie_names = C('DIJIE_NAME');
        $this->change = M('op')->where(array('dijie_opid' => $opid))->find();
        //$this->expert         = C('expert');
        //$this->op_expert      = explode(',',$op['expert']);
        $this->provinces = M('provinces')->getField('id,name', true);
        $this->departments = M('salary_department')->getField('id,department', true);
        $this->dijie_data = get_dijie_department_data();
        $PinYin = new Pinyin();
        $geclist = get_customerlist(1, $PinYin); //客户名称关键字
        $this->geclist = $geclist;
        $this->geclist_str = json_encode($geclist, true);
        $this->scheme_list = M('op_scheme')->where(array('op_id' => $opid))->find();
        $this->costacc_res = M('op_costacc_res')->where(array('op_id' => $opid))->find();


        $product_need = M()->table('__OP_COSTACC__ as c')->field('c.*,p.from,p.subject_field,p.type as ptype,p.age,p.reckon_mode')->join('left join __PRODUCT__ as p on c.product_id=p.id')->where(array('c.op_id' => $opid, 'c.type' => 5, 'c.status' => 0))->select();
        foreach ($product_need as $k => $v) {
            $ages = explode(',', $v['age']);
            $age_list = array();
            foreach ($this->ages as $key => $value) {
                if (in_array($key, $ages)) {
                    $age_list[] = $value;
                }
            }
            $product_need[$k]['age_list'] = implode(',', $age_list);
        }
        $this->product_need = $product_need;
        $this->yusuan = $yusuan;
        $this->xuhao = 1;
        $this->huikuan_status = M('contract_pay')->where(array('op_id' => $opid))->getField('status');
        $this->guide_kind = M('guidekind')->getField('id,name', true);
        $this->guide_confirm = M()->table('__OP_GUIDE_CONFIRM__ as c')->field('c.id as cid,c.*,p.id as pid,p.*')->join('left join __OP_GUIDE_PRICE__ as p on p.confirm_id = c.id')->where(array('c.op_id' => $opid, 'p.op_id' => $opid))->select();
        $this->apply_to = C('APPLY_TO');
        $this->arr_product = C('ARR_PRODUCT');

        $this->guide_price = M('op_guide_price')->where(array('op_id' => $opid, 'confirm_id' => '0'))->select();
        if ($this->guide_price) {
            $this->rad = 1;
        } else {
            $this->rad = 0;
        }

        //资源需求单接收人员(资源管理部经理)
        //$this->men            = M('account')->field('id,nickname')->where(array('roleid'=>52))->find();
        /*$this->tcs = M()->table('__OP_GUIDE_PRICE__ as gp')
            ->field('gp.*,gk.name as gkname,gpk.name as gpkname')
            ->join('left join __GUIDEKIND__ as gk on gp.guide_kind_id = gk.id')
            ->join('left join __GUIDE_PRICEKIND__ as gpk on gp.gpk_id = gpk.id')
            ->where(array('gp.op_id' => $opid, 'gp.confirm_id' => '0'))
            ->select();*/

        //客户名称关键字
        $where = array();
        if (C('RBAC_SUPER_ADMIN') == cookie('username') || in_array(cookie('roleid'), array(10, 11, 28, 30))) {
            $where['company_name'] = array('neq', '');
        } else {
            $where['company_name'] = array('neq', '');
            $where['cm_id'] = array('in', Rolerelation(cookie('roleid')));
        }
        //$this->geclist     = get_customerlist();

        //人员名单关键字
        $this->userkey = get_username();
        $department_manager = get_department_manager($op['create_user']); //部门主管
        $this->manager_uid = $department_manager['manager_id'];
        $this->manager_data = $department_manager;

        //研发和资源人员信息(用于前期对研发和资源人员评分)
        $score_data = $this->get_score_user($opid);

        $pingfen = $score_data['pingfen'];
        $yanfa = $score_data['yanfa'];
        $ziyuan = $score_data['ziyuan'];
        if ($pingfen) {
            $this->pingfen = json_encode($pingfen);
        }
        $this->yanfa = $yanfa;
        $this->ziyuan = $ziyuan;
        $this->is_dijie = is_dijie($opid); //是否是地接团
        $this->fa = I('fa', 0); //加载不同导航栏
        $this->display('plans_edit');

    }

    private function get_score_user($opid)
    {
        $pingfen = M('op_score')->where(array('op_id' => $opid))->find();
        $yanfa_info = M('worder')->field('exe_user_id , exe_user_name , assign_id, assign_name')->where(array('op_id' => $opid, 'kpi_type' => 3, 'status' => array('neq', -1)))->find();   //京区校内研发
        $ziyuan_info = M('worder')->field('exe_user_id , exe_user_name , assign_id, assign_name')->where(array('op_id' => $opid, 'kpi_type' => 4, 'status' => array('neq', -1)))->find();   //京区校内资源
        $jidiao_info = M()->table('__OP_AUTH__ as o')->field('a.id,a.nickname')->join('__ACCOUNT__ as a on a.id=o.yusuan', 'left')->where(array('o.op_id' => $opid))->find();
        $yanfa = array();
        $yanfa['user_id'] = $pingfen['yf_uid'] ? $pingfen['yf_uid'] : ($yanfa_info['assign_id'] ? $yanfa_info['assign_id'] : $yanfa_info['exe_user_id']);
        $yanfa['user_name'] = $pingfen['yf_uname'] ? $pingfen['yf_uname'] : ($yanfa_info['assign_name'] ? $yanfa_info['assign_name'] : $yanfa_info['exe_user_name']);
        $ziyuan = array();
        $ziyuan['user_id'] = $pingfen['zy_uid'] ? $pingfen['zy_uid'] : ($ziyuan_info['assign_id'] ? $ziyuan_info['assign_id'] : $ziyuan_info['exe_user_id']);
        $ziyuan['user_name'] = $pingfen['zy_uname'] ? $pingfen['zy_uname'] : ($ziyuan_info['assign_name'] ? $ziyuan_info['assign_name'] : $ziyuan_info['exe_user_name']);
        /*$jidiao             = array();
        $jidiao['user_id']  = $pingfen['ji_uid']?$pingfen['ji_uid']:($jidiao_info['id']?$jidiao_info['id']:0);
        $jidiao['user_name']= $pingfen['ji_uname']?$pingfen['ji_uname']:($jidiao_info['nickname']?$jidiao_info['nickname']:'');*/

        $data = array();
        $data['pingfen'] = $pingfen;
        $data['yanfa'] = $yanfa;
        $data['ziyuan'] = $ziyuan;
        //$data['jidiao']     = $jidiao;
        return $data;
    }


    // @@@NODE-3###public_save###保存项目###
    public function public_save()
    {

        if (isset($_POST['dosubmint']) && $_POST['dosubmint']) {

            $db = M('op');
            $op_cost_db = M('op_cost');
            $op_guide_db = M('op_guide');
            $op_member_db = M('op_member');
            $op_supplier_db = M('op_supplier');
            $op_res_db = M('op_res');
            //$op_res_money_db= M('op_res_money');
            $op_guide_price_db = M('op_guide_price');


            $opid = I('opid');
            $info = I('info');
            $guide = I('guide');
            $member = I('member');
            $cost = I('cost');
            $supplier = I('supplier');
            $wuzi = I('wuzi');
            $savetype = I('savetype');
            $days = I('days');
            $resid = I('resid');
            $num = 0;

            //保存专家辅导员信息
            if ($opid && $savetype == 2) {
                $delid = array();
                foreach ($guide as $k => $v) {
                    $data = array();
                    $data = $v;
                    if ($resid && $resid[$k]['id']) {
                        $edits = $op_guide_db->data($data)->where(array('id' => $resid[$k]['id']))->save();
                        $delid[] = $resid[$k]['id'];
                        $cost[$k]['link_id'] = $resid[$k]['id'];
                        $num++;
                    } else {
                        $data['op_id'] = $opid;
                        $savein = $op_guide_db->add($data);
                        $delid[] = $savein;
                        $cost[$k]['link_id'] = $savein;
                        if ($savein) $num++;
                    }
                }

                $where = array();
                $where['op_id'] = $opid;
                if ($delid) $where['id'] = array('not in', $delid);
                $del = $op_guide_db->where($where)->delete();
                if ($del) $num++;

                if ($num) {
                    $record = array();
                    $record['op_id'] = $opid;
                    $record['optype'] = 4;
                    $record['explain'] = '专家辅导员资源';
                    op_record($record);
                }


            }

            //保存合格供方信息
            if ($opid && $savetype == 3) {

                $delid = array();
                foreach ($supplier as $k => $v) {
                    $data = array();
                    $data = $v;
                    if ($resid && $resid[$k]['id']) {
                        $edits = $op_supplier_db->data($data)->where(array('id' => $resid[$k]['id']))->save();
                        $delid[] = $resid[$k]['id'];
                        $cost[$k]['link_id'] = $resid[$k]['id'];
                        $num++;
                    } else {
                        $data['op_id'] = $opid;
                        $savein = $op_supplier_db->add($data);
                        $delid[] = $savein;
                        $cost[$k]['link_id'] = $savein;
                        if ($savein) $num++;
                    }
                }

                $where = array();
                $where['op_id'] = $opid;
                if ($delid) $where['id'] = array('not in', $delid);
                $del = $op_supplier_db->where($where)->delete();
                if ($del) $num++;

                if ($num) {
                    $record = array();
                    $record['op_id'] = $opid;
                    $record['optype'] = 4;
                    $record['explain'] = '调度合格供方资源资源';
                    op_record($record);
                }
            }

            //保存物资信息
            if ($opid && $savetype == 4) {

                $delid = array();
                foreach ($wuzi as $k => $v) {
                    $data = array();
                    $data = $v;
                    if ($resid && $resid[$k]['id']) {
                        $edits = M('op_material')->data($data)->where(array('id' => $resid[$k]['id']))->save();
                        $cost[$k]['link_id'] = $resid[$k]['id'];
                        $delid[] = $resid[$k]['id'];
                        $num++;
                    } else {
                        $data['op_id'] = $opid;
                        $savein = M('op_material')->add($data);
                        $cost[$k]['link_id'] = $savein;
                        $delid[] = $savein;
                        if ($savein) $num++;
                    }
                }

                $where = array();
                $where['op_id'] = $opid;
                if ($delid) $where['id'] = array('not in', $delid);
                $del = M('op_material')->where($where)->delete();
                if ($del) $num++;

                if ($num) {
                    $record = array();
                    $record['op_id'] = $opid;
                    $record['optype'] = 4;
                    $record['explain'] = '调度物资';
                    op_record($record);
                }
            }

            //保存用户名单信息
            if ($opid && $savetype == 5) {

                $delid = array();
                foreach ($member as $k => $v) {
                    $data = array();
                    $data = $v;
                    if ($resid && $resid[$k]['id']) {
                        $edits = $op_member_db->data($data)->where(array('id' => $resid[$k]['id']))->save();
                        $delid[] = $resid[$k]['id'];
                        $num++;
                    } else {
                        $data['op_id'] = $opid;
                        $data['sales_person_uid'] = cookie('userid');
                        $data['sales_time'] = time();
                        $savein = $op_member_db->add($data);
                        $delid[] = $savein;
                        if ($savein) $num++;

                        //将名单保存至客户名单
                        if (!M('customer_member')->where(array('number' => $v['number']))->find()) {
                            $mem = $v;
                            $mem['source'] = cookie('userid');
                            $mem['create_time'] = time();
                            M('customer_member')->add($mem);
                        }
                    }
                }

                $where = array();
                $where['op_id'] = $opid;
                if ($delid) $where['id'] = array('not in', $delid);
                $del = $op_member_db->where($where)->delete();
                if ($del) $num++;

                if ($num) {
                    $record = array();
                    $record['op_id'] = $opid;
                    $record['optype'] = 7;
                    $record['explain'] = '保存用户名单';
                    op_record($record);
                }

            }

            //确定成团
            if ($opid && $savetype == 9) {

                $data = array();
                $data['status'] = I('status');
                $data['group_id'] = strtoupper(I('gid'));
                $data['nogroup'] = I('nogroup');
                $op = M('op')->where(array('op_id' => $opid))->find();
                if ($op['audit_status'] == 1) {
                    //保存成团
                    $issave = M('op')->data($data)->where(array('op_id' => $opid))->save();
                    if ($issave) $num++;
                }
                if ($num) {
                    $record = array();
                    $record['op_id'] = $opid;
                    $record['optype'] = 6;
                    if ($data['status'] == 1) {
                        $record['explain'] = '项目成团操作';
                    } elseif ($data['status'] == 2) {
                        $record['explain'] = '项目不成团操作';
                    }
                    op_record($record);
                }
            }

            //保存产品方案需求
            if ($savetype == 10) {
                $db = M('op');
                $fa = I('fa');
                $info = I('info');
                $info['project'] = trim($info['project']);
                $info['customer'] = trim($info['customer']);
                $info['remark'] = trim($info['remark']);
                $info['destination'] = trim($info['destination']);
                $info['time'] = strtotime($info['time']);
                if (!$info['project']) $this->error('需求标题不能为空');
                if (!$opid) {
                    $this->error('数据错误');
                }
                if (!$info['line_blame_uid'] || !$info['line_blame_name']) $this->error('线控负责人信息错误');
                $db->where(array('op_id' => $opid))->save($info);

                $record = array();
                $record['op_id'] = $opid;
                $record['optype'] = 1;
                $record['explain'] = '编辑产品方案需求基本信息';
                op_record($record);
                $this->success('保存成功', U('Op/plans_follow', array('opid' => $opid, 'fa' => $fa)));
            }

            //保存价格
            if ($cost) {
                $i = 0;
                $op_cost_db->where(array('op_id' => $opid, 'cost_type' => $savetype))->delete();
                foreach ($cost as $k => $v) {
                    $data = array();
                    $data = $v;
                    $data['op_id'] = $opid;
                    if ($data['cost_type'] == 1) {
                        $data['amount'] = $info['number'];
                    }
                    $data['total'] = $data['cost'] * $data['amount'];

                    $op_cost_db->add($data);

                    $i++;
                }
            }

            //保存资源需求单
            if ($opid && $savetype == 11) {

                header('Content-Type:text/html;charset=utf-8');
                $info['op_id'] = $opid;
                $info['in_time'] = strtotime($info['in_time']);
                $act_needs = I('act_need');
                $task_fields = I('task_field');
                $info['act_need'] = implode(',', $act_needs);
                $info['task_field'] = implode(',', $task_fields);

                if ($info['audit_user_id']) {
                    $saved_id = $op_res_db->where(array('op_id' => $opid))->getField('id');
                    if ($saved_id) {
                        $op_res_db->where(array('id' => $saved_id))->save($info);
                        $res = $saved_id;
                    } else {
                        $info['create_time'] = NOW_TIME;
                        $res = $op_res_db->add($info);
                    }
                    if ($res) {
                        $num++;
                        /*$op_res_money_db->where(array('op_res_id'=>$res))->delete();
                        foreach ($data as $v){
                            if ($v['job_name']) {
                                $v['op_res_id'] = $res;
                                $op_res_money_db->add($v);
                            }
                        }*/

                        $record = array();
                        $record['op_id'] = $opid;
                        $record['optype'] = 4;
                        $record['explain'] = '填写资源需求单';
                        op_record($record);

                        $audit_user_id = $info['audit_user_id'];
                        if (cookie('userid') != $info['audit_user_id']) {
                            $op = M('op')->where(array('op_id' => $opid))->find();
                            //发送系统消息
                            $uid = cookie('userid');
                            $title = '您有来自[' . session('rolename') . '--' . $info['ini_user_name'] . ']的资源需求单待审核!';
                            $content = '项目名称：' . $op['project'] . '；团号：' . $op['group_id'];
                            $url = U('Op/res_feedback', array('opid' => $info['op_id']));
                            $user = '[' . $audit_user_id . ']';
                            send_msg($uid, $title, $content, $url, $user, '');
                        }
                    }
                }

            }

            //保存辅导员/教师,专家需求  bak_20200705
            /*if ($opid && $savetype == 12) {
                $data = I('data');
                $op = $db->where(array('op_id' => $opid))->find();

                $savedel = $op_guide_price_db->where(array('op_id' => $opid, 'confirm_id' => 0))->delete();
                if ($savedel) $num++;
                foreach ($data as $k => $v) {
                    $v['op_id'] = $opid;
                    $savein = $op_guide_price_db->add($v);
                    if ($savein) $num++;
                }

                //产品模块化,直接保存到核算costacc表(56=>校园科技节)
                //$arr_product    = C('ARR_PRODUCT');
                //if (in_array($op['kind'],$arr_product)){
                M('op_costacc')->where(array('op_id' => $opid, 'type' => 2, 'status' => 0))->delete();
                foreach ($data as $k => $v) {
                    $data = array();
                    $data['op_id'] = $opid;
                    $data['title'] = '注册辅导员/教师';
                    $data['unitcost'] = $v['price'];
                    $data['amount'] = $v['num'];
                    $data['total'] = $v['total'];
                    $data['remark'] = $v['remark'];
                    $data['type'] = 2;    //专家辅导员
                    $data['status'] = 0;    //核算
                    $savein = M('op_costacc')->add($data);
                    if ($savein) $num++;
                }
                //}

                //数据转存至op_guide_confirm表
                $confirm = M('op_guide_confirm')->where(array('op_id' => $opid))->find();
                if (!$confirm) {
                    $confirm = array();
                    $confirm['op_id'] = $opid;
                    $confirm['tcs_stu'] = 1;    //待要专家辅导员(未成团)
                    $res = M('op_guide_confirm')->add($confirm);
                }

                if ($res) {
                    $record = array();
                    $record['op_id'] = $opid;
                    $record['optype'] = 4;
                    $record['explain'] = '填写专家辅导员资源需求';
                    op_record($record);
                }

            }*/

            //保存辅导员/教师,专家具体需求信息  bak_20200705
            if ($opid && $savetype == 13) {
                //P($_POST);
                $data = I('data');
                $in_day = I('in_day');
                //$tcs_time = I('tcs_time');
                $address = trim(I('address'));
                $confirm_id = I('confirm_id');
                $in_begin_day = substr($in_day, 0, 10);
                $in_end_day = substr($in_day, 13, 10);
                //$tcs_begin_time = $in_end_day.' '.substr($tcs_time,0,8);
                //$tcs_end_time   = $in_end_day.' '.substr($tcs_time,11,8);
                $info['in_begin_day'] = strtotime($in_begin_day);
                $info['in_day'] = strtotime($in_end_day);
                //$info['tcs_begin_time'] = strtotime($tcs_begin_time)?strtotime($tcs_begin_time):strtotime($in_begin_day);
                //$info['tcs_end_time']   = strtotime($tcs_end_time)?strtotime($tcs_end_time):strtotime($in_end_day);
                $info['address'] = $address;
                $info['op_id'] = $opid;
                $info['tcs_stu'] = 2;    //已确认需求(已成团)

                if ($info['in_begin_day'] <= 0 || $info['in_day'] <= 0 || ($info['in_begin_day'] > $info['in_day'])) $this->error('请正确填写出行时间');
                if (!$info['address']) $this->error('请填写实施地点');

                if ($data) {
                    if ($confirm_id) {
                        $res = M('op_guide_confirm')->where(array('id' => $confirm_id))->save($info);
                    } else {
                        //更改项目跟进时提出的需求信息
                        $list = M('op_guide_confirm')->where(array('op_id' => $opid, 'tcs_stu' => 1))->find();
                        if ($list) {
                            $confirm_id = $list['id'];
                            $res = M('op_guide_confirm')->where(array('id' => $confirm_id))->save($info);
                        } else {
                            $confirm_id = M('op_guide_confirm')->add($info);
                        }
                    }
                    if ($confirm_id) {
                        //$op_guide_price_db->where(array('op_id'=>$opid,'confirm_id'=>0))->delete();
                        $res = $op_guide_price_db->where(array('op_id' => $opid, 'confirm_id' => $confirm_id))->delete();
                        if ($res) $num++;
                        foreach ($data as $k => $v) {
                            $v['op_id'] = $opid;
                            $v['confirm_id'] = $confirm_id;
                            $savein = $op_guide_price_db->add($v);
                            if ($savein) $num++;
                        }
                    }
                    if ($num) {
                        $record = array();
                        $record['op_id'] = $opid;
                        $record['optype'] = 4;
                        $record['explain'] = '成团后确认辅导员资源需求(增加/编辑)';
                        op_record($record);
                        $this->success('保存成功');
                    } else {
                        $this->error('保存失败');
                    }
                } else {
                    $this->error('请填写完整信息!');
                }
            }


            //保存项目跟进保存产品模块需求(14 can delete 20191224)
            if ($opid && $savetype == 14) {
                $costacc = I('costacc');
                $resid = I('resid');
                $mod = D('Op');

                /*M('op_product')->where(array('op_id'=>$opid))->delete();
                foreach ($costacc as $k=>$v){
                    $v['op_id']     = $opid;
                    $v['total']     = floatval($v['unitcost'])*intval($v['amount']);
                    $v['status']    = 0;    //核算

                    if($resid && $resid[$k]['id']){
                        $edits      = M('op_costacc')->data($v)->where(array('id'=>$resid[$k]['id']))->save();
                        $delid[]    = $resid[$k]['id'];
                        $num++;
                    }else{
                        $savein     = M('op_costacc')->add($v);
                        $delid[]    = $savein;
                        if($savein) $num++;
                    }
                    $del            = M('op_costacc')->where(array('op_id'=>$opid,'type'=>5,'status'=>0,'id'=>array('not in',$delid)))->delete();
                    if ($del) $num++;

                    $data           = array();
                    $data['op_id']  = $opid;
                    $data['product_id'] = $v['product_id'];
                    $data['amount'] = $v['amount'];
                    $res = M('op_product')->add($data);
                    if ($res) $num++;
                }*/
                $num = $mod->save_create_op_product($opid, $costacc, $resid, $num);
                if ($num) {
                    $record = array();
                    $record['op_id'] = $opid;
                    $record['optype'] = 4;
                    $record['explain'] = '填写项目模块信息';
                    op_record($record);
                }
            }

            //审核资源配置信息(审核15)
            if ($opid && $savetype == 20) {
                if ($info['audit_status']) {
                    $res_id = I('res_id');
                    $info['audit_time'] = NOW_TIME;
                    $where = array();
                    $where['id'] = $res_id;
                    $res = $op_res_db->where($where)->save($info);
                    if ($res) {
                        $status = C('AUDIT_STATUS');
                        $op = M('op')->where(array('op_id' => $opid))->find();
                        if ($info['audit_status'] == 1) {
                            //审核通过(发送系统消息)
                            $uid = cookie('userid');
                            $title = '您有来自[' . session('rolename') . '--' . session('nickname') . ']的资源需求单!';
                            $content = '项目名称：' . $op['project'] . '；团号：' . $op['group_id'];
                            $url = U('Op/res_feedback', array('opid' => $opid));
                            $user = '[' . $info['exe_user_id'] . ']';
                            send_msg($uid, $title, $content, $url, $user, '');
                        } else {
                            $ini_user_id = $op_res_db->where(array('id' => $res_id))->getField('ini_user_id');
                            //审核不通过
                            $uid = cookie('userid');
                            $title = '您有来自[' . session('rolename') . '--' . session('nickname') . ']的资源需求单审核结果通知!';
                            $content = '项目名称：' . $op['project'] . '；团号：' . $op['group_id'] . '；审核结果：' . $status[$info["audit_status"]];
                            $url = U('Op/confirm', array('opid' => $opid));
                            $user = '[' . $ini_user_id . ']';
                            send_msg($uid, $title, $content, $url, $user, '');
                        }

                        //操作记录
                        $record = array();
                        $record['op_id'] = $opid;
                        $record['optype'] = 4;
                        $record['explain'] = '审核资源需求反馈信息[' . $status[$info["audit_status"]] . ']';
                        op_record($record);

                        $num++;
                    }
                }
            }

            //保存资源配置回复信息(完成)
            if ($opid && $savetype == 15) {
                $res_id = I('res_id');
                $info['feedback_time'] = NOW_TIME;
                $where = array();
                $where['id'] = $res_id;
                $res = $op_res_db->where($where)->save($info);
                if ($res) {
                    $record = array();
                    $record['op_id'] = $opid;
                    $record['optype'] = 4;
                    $record['explain'] = '填写资源需求反馈信息';
                    op_record($record);

                    $num++;
                }
            }

            //保存委托设计工作交接单
            if ($opid && $savetype == 16) {

                $info['op_id'] = $opid;
                $info['create_time'] = NOW_TIME;
                $info['need_time'] = strtotime($info['need_time']);
                if (!$info['audit_user_id']) {
                    $this->error('请填写审核人员信息');
                }
                $list = M('op_design')->where(array('op_id' => $opid))->find();
                if ($list) {
                    $res = M('op_design')->where(array('id' => $list['id']))->save($info);
                } else {
                    $res = M('op_design')->add($info);
                }
                if ($res) {
                    //发送审核系统消息
                    $audit_user_id = $info['audit_user_id'];
                    $op = M('op')->where(array('op_id' => $opid))->find();
                    //发送系统消息
                    $uid = cookie('userid');
                    $title = '您有来自[' . session('rolename') . '--' . $info['ini_user_name'] . ']委托设计工作交接单待审核!';
                    $content = '项目名称：' . $op['project'] . '；团号：' . $op['group_id'];
                    $url = U('Op/res_audit', array('opid' => $info['op_id'], 'type' => 1));
                    $user = '[' . $audit_user_id . ']';
                    send_msg($uid, $title, $content, $url, $user, '');

                    $record = array();
                    $record['op_id'] = $opid;
                    $record['optype'] = 4;
                    $record['explain'] = '填写/修改委托设计工作交接单(设计)';
                    op_record($record);

                    $num++;
                }
            }

            //保存"审核"委托设计工作交接单 + 业务实施计划单
            if ($opid && $savetype == 17) {

                $type = I('type');
                if (!$info) {
                    $this->error('审核信息有误!');
                }
                if ($type == 1) {
                    //保存审核委托设计工作交接单
                    $design_id = I('design_id');
                    $info['audit_time'] = NOW_TIME;
                    $res = M('op_design')->where(array('id' => $design_id))->save($info);
                } else {
                    //保存业务实施计划单
                    $plan_id = I('plan_id');
                    $info['audit_time'] = NOW_TIME;
                    $res = M('op_work_plans')->where(array('id' => $plan_id))->save($info);
                }
                if ($res) {
                    $status = C('AUDIT_STATUS');
                    $record = array();
                    $record['op_id'] = $opid;
                    $record['optype'] = 4;
                    if ($type == 1) {
                        $record['explain'] = '审核委托设计工作交接单';
                        $list = M('op_design')->where(array('id' => $design_id))->find();
                    } else {
                        $record['explain'] = '审核业务实施计划单';
                        $list = M('op_work_plans')->where(array('id' => $plan_id))->find();
                    }
                    op_record($record);
                    $op = M('op')->where(array('op_id' => $opid))->find();

                    if ($info['audit_status'] == P::AUDIT_STATUS_PASS) {
                        $exe_user_id = $list['exe_user_id'];
                        //发送系统消息
                        $uid = cookie('userid');
                        $title = '您有来自[' . session('rolename') . '--' . $list['ini_user_name'] . ']委托设计工作交接单!';
                        $content = '项目名称：' . $op['project'] . '；团号：' . $op['group_id'];
                        $url = U('Op/res_audit', array('opid' => $list['op_id'], 'type' => $type));
                        $user = '[' . $exe_user_id . ']';
                        send_msg($uid, $title, $content, $url, $user, '');
                    } else {
                        if ($type == 1) {
                            //工作交接单
                            $ini_user_id = M('op_design')->where(array('id' => $design_id))->getField('ini_user_id');
                            $name = '委托设计工作交接单';
                        } else {
                            //业务实施计划单
                            $ini_user_id = M('op_work_plans')->where(array('id' => $plan_id))->getField('ini_user_id');
                            $name = '业务实施计划单';
                        }
                        //审核不通过
                        $uid = cookie('userid');
                        $title = '您有来自[' . session('rolename') . '--' . session('nickname') . ']的' . $name . '审核结果通知!';
                        $content = '项目名称：' . $op['project'] . '；团号：' . $op['group_id'] . '；审核结果：' . $status[$info["audit_status"]] . '；<span class="red">' . $info['audit_remark'] . '</span>';
                        $url = U('Op/confirm', array('opid' => $opid));
                        $user = '[' . $ini_user_id . ']';
                        send_msg($uid, $title, $content, $url, $user, '');
                    }

                    $this->success('审核成功');
                } else {
                    $this->error('保存数据失败');
                }

            }

            ////保存"完成"委托设计工作交接单
            if ($opid && $savetype == 18) {
                $type = I('type');
                if ($type == 1) {
                    $design_id = I('design_id');
                    $info['finish_time'] = NOW_TIME;
                    $res = M('op_design')->where(array('id' => $design_id))->save($info);
                } else {
                    //保存业务实施计划单
                    $plan_id = I('plan_id');
                    $info['finish_time'] = NOW_TIME;
                    $res = M('op_work_plans')->where(array('id' => $plan_id))->save($info);
                }
                if ($res) {
                    $record = array();
                    $record['op_id'] = $opid;
                    $record['optype'] = 4;
                    if ($type == 1) {
                        $record['explain'] = '完成委托设计工作交接单';
                    } else {
                        $record['explain'] = '完成保存业务实施计划单';
                    }
                    op_record($record);

                    $this->success('保存成功');
                } else {
                    $this->error('保存失败');
                }
            }

            //保存业务实施计划单
            if ($opid && $savetype == 19) {

                $between_time = I('between_time');
                $additive = I('additive');
                $plan_lists = I('plans');
                $begin_time = strtotime(substr($between_time, 0, 10));
                $end_time = strtotime(substr($between_time, -10, 10));
                $info['op_id'] = $opid;
                $info['begin_time'] = $begin_time;
                $info['end_time'] = $end_time;
                $info['additive'] = implode(',', $additive);
                $info['create_time'] = NOW_TIME;

                $planed = M('op_work_plans')->where(array('op_id' => $opid))->find();
                if ($planed) {
                    $plan_id = $planed['id'];
                    $res = M('op_work_plans')->where(array('id' => $plan_id))->save($info);
                } else {
                    $res = M('op_work_plans')->add($info);
                    $plan_id = $res;
                }

                if ($res) {
                    foreach ($plan_lists as $k => $v) {
                        $data = array();
                        $data = $v;
                        if ($resid && $resid[$k]['id']) {
                            M('op_work_plan_lists')->where(array('id' => $resid[$k]['id']))->save($data);
                            $delid[] = $resid[$k]['id'];
                        } else {
                            $data['plan_id'] = $plan_id;
                            $data['op_id'] = $opid;
                            $res = M('op_work_plan_lists')->add($data);
                            $delid[] = $res;
                        }
                    }

                    $where = array();
                    $where['op_id'] = $opid;
                    if ($delid) $where['id'] = array('not in', $delid);
                    M('op_work_plan_lists')->where($where)->delete();

                    //发送审核系统消息
                    $audit_user_id = $info['audit_user_id'];
                    $op = M('op')->where(array('op_id' => $opid))->find();
                    //发送系统消息
                    $uid = cookie('userid');
                    $title = '您有来自[' . session('rolename') . '--' . $info['ini_user_name'] . ']业务实施计划单待审核!';
                    $content = '项目名称：' . $op['project'] . ';&nbsp;团号：' . $op['group_id'];
                    $url = U('Op/res_audit', array('opid' => $info['op_id'], 'type' => 2));
                    $user = '[' . $audit_user_id . ']';
                    send_msg($uid, $title, $content, $url, $user, '');

                    $record = array();
                    $record['op_id'] = $opid;
                    $record['optype'] = 4;
                    $record['explain'] = '填写/修改业务实施计划单(计调)';
                    op_record($record);

                    $num++;
                }
            }

            //保存前期对资源评价
            if ($opid && $savetype == 21) {
                $info['op_id'] = $opid;
                $info['pf_id'] = cookie('userid');
                $info['pf_name'] = cookie('nickname');
                $info['create_time'] = NOW_TIME;
                $pingfen = M('op_score')->where(array('op_id' => $opid))->find();
                if ($pingfen) {
                    $res = M('op_score')->where(array('id' => $pingfen['id']))->save($info);

                    $record = array();
                    $record['op_id'] = $opid;
                    $record['optype'] = 4;
                    $record['explain'] = '修改前期评分信息';
                    op_record($record);
                } else {
                    $res = M('op_score')->add($info);

                    $record = array();
                    $record['op_id'] = $opid;
                    $record['optype'] = 4;
                    $record['explain'] = '填写前期评分信息';
                    op_record($record);
                }
                if ($res) $num++;
            }

            //活动结束后对计调的评价
            /*if ($opid && $savetype==22){
                $info                   = I('info');
                if (!$info['jd_uid']){
                    $data               = array();
                    $data['num']        = 0;
                    $data['msg']        = '获取计调信息失败';
                    $this->ajaxReturn($data);
                }
                $info['jd_score_time']  = NOW_TIME;
                $pingfen                = M('op_score')->where(array('op_id'=>$opid))->find();
                if ($pingfen){
                    $res                = M('op_score')->where(array('id'=>$pingfen['id']))->save($info);

                    $record             = array();
                    $record['op_id']    = $opid;
                    $record['optype']   = 4;
                    $record['explain']  = '修改计调评分信息';
                    op_record($record);
                }else{
                    $info['op_id']      = $opid;
                    $info['pf_id']      = cookie('userid');
                    $info['pf_name']    = cookie('nickname');
                    $info['create_time']= NOW_TIME;
                    $res                = M('op_score')->add($info);

                    $record             = array();
                    $record['op_id']    = $opid;
                    $record['optype']   = 4;
                    $record['explain']  = '填写计调评分信息';
                    op_record($record);
                }

                if ($res) $num++;
                $msg                    = $num > 0 ? '保存成功' : '保存失败';

                $data                   = array();
                $data['num']            = $num;
                $data['msg']            = $msg;
                $this->ajaxReturn($data);
            }*/

            if ($opid && $savetype == 23) {
                $eval_db = M('op_eval');
                $eval_tit_db = M('op_eval_title');
                $opid = I('opid');
                $info = I('info');
                $data = I('data');
                $account_id = $info['account_id'];
                $code = get_op_eval_code($info['type']);
                $returnMsg = array();
                if (!$account_id) {
                    $returnMsg['num'] = 0;
                    $returnMsg['msg'] = '获取' . $code . '信息失败';
                    $this->ajaxReturn($returnMsg);
                }

                $info['op_id'] = $opid;
                $info['input_userid'] = session('userid');
                $info['input_username'] = session('nickname');
                $info['create_time'] = NOW_TIME;

                $list = get_op_score_data($opid, $info['type']);
                if ($list) {
                    $res = $eval_db->where(array('id' => $list['id']))->save($info);
                    $eval_id = $list['id'];
                    $explain = '修改' . $code . '评分信息';
                } else {
                    $res = $eval_db->add($info);
                    $eval_id = $res;
                    $explain = '填写' . $code . '评分信息';
                }

                if ($res) {
                    $num++;
                    $data['eval_id'] = $eval_id;
                    $data['op_id'] = $opid;
                    $list ? $eval_tit_db->where(array('eval_id' => $list['id']))->save($data) : $eval_tit_db->add($data);

                    $record = array();
                    $record['op_id'] = $opid;
                    $record['optype'] = 4;
                    $record['explain'] = $explain;
                    op_record($record);

                    $returnMsg['num'] = $num;
                    $returnMsg['msg'] = $code . '评分成功';
                } else {
                    $returnMsg['num'] = 0;
                    $returnMsg['msg'] = $code . '评分失败';
                }
                $this->ajaxReturn($returnMsg);
            }

            if ($opid && $savetype == 24) {
                $cneed_db = M('op_customer_need_edit');
                $id = I('id');
                $data = I('cneed');
                if (!$data['dep_time']) $this->error('实际出发时间填写有误');
                if (!$data['ret_time']) $this->error('实际返回时间填写有误');
                if (!trim($data['title'])) $this->error('活动名称不能为空');
                if (!trim($data['why'])) $this->error('更改原因不能为空');
                if (!trim($data['ffect'])) $this->error('变更后的影响不能为空');
                if (!trim($data['right'])) $this->error('变更后的纠正措施不能为空');
                if (!trim($data['before'])) $this->error('变更前要素不能为空');
                if (!trim($data['after'])) $this->error('变更后要素不能为空');
                $data['op_id'] = $opid;
                $data['dep_time'] = strtotime($data['dep_time']);
                $data['ret_time'] = strtotime($data['ret_time']);
                $data['title'] = trim($data['title']);
                $data['why'] = trim($data['why']);
                $data['ffect'] = trim($data['ffect']);
                $data['right'] = trim($data['right']);
                $data['before'] = trim($data['before']);
                $data['after'] = trim($data['after']);
                if ($id) {
                    $res = $cneed_db->where(array('id' => $id))->save($data);
                    $explain = '编辑客户需求变更信息';
                } else {
                    $data['input_time'] = NOW_TIME;
                    $res = $cneed_db->add($data);
                    $explain = '填写客户需求变更信息';
                }
                if ($res) {
                    $record = array();
                    $record['op_id'] = $opid;
                    $record['optype'] = 4;
                    $record['explain'] = $explain;
                    op_record($record);

                    //发送系统消息
                    $op = $db->where(array('op_id' => $opid))->find();
                    $department_manager = get_department_manager(cookie('userid'));

                    $uid = cookie('userid');
                    $title = '您有来自[' . cookie('nickname') . ']的客户需求变更待审核!';
                    $content = '项目名称：' . $op['project'] . '；团号：' . $op['group_id'];
                    $url = U('Op/confirm', array('opid' => $opid));
                    $user = '[' . $department_manager["manager_id"] . ']';
                    send_msg($uid, $title, $content, $url, $user, '');
                    $this->success('保存成功');
                } else {
                    $this->error('保存数据失败');
                }
            }

            if ($opid && $savetype == 25) {
                $status = I('status');
                $audit_remark = trim(I('audit_remark'));
                if (!$status) {
                    $this->error('请选择是否审批通过');
                }
                $cneed_db = M('op_customer_need_edit');
                $data = array();
                $data['audit_status'] = $status;
                $data['audit_remark'] = $audit_remark;
                $data['audit_uid'] = cookie('userid');
                $data['audit_uname'] = cookie('nickname');
                $data['audit_time'] = NOW_TIME;
                $res = $cneed_db->where(array('op_id' => $opid))->save($data);
                if ($res) {
                    $record = array();
                    $record['op_id'] = $opid;
                    $record['optype'] = 4;
                    $record['explain'] = '审核客户变更需求';
                    op_record($record);

                    $this->success('保存成功');
                } else {
                    $this->error('保存数据失败');
                }
            }

            if ($opid && $savetype == 26) {
                $id = I('id');
                if (!$id) $this->error('提交失败');
                $op = M('op')->where(array('op_id' => $opid))->find();
                $db = M('op_project');
                $data = array();
                $data['audit_status'] = 3; //已提交,未审核
                $res = $db->where(array('id' => $id))->save($data);
                if ($res) {
                    $process_node = 52; //确认业务实施方案
                    $pro_status = 2; // 事前提醒
                    save_process_log($process_node, $pro_status, $op['project'], $op['id'], '', $op['create_user'], $op['create_user_name']); //保存待办事宜
                    $ok_node_id = 51; //编制业务实施方案
                    save_process_ok($ok_node_id);
                    $this->success('提交成功', U('Op/public_project', array('opid' => $opid)));
                } else {
                    $this->error('提交申请失败');
                }
            }

            if ($opid && $savetype == 27) {
                $id = I('id');
                $status = I('status');
                $audit_remark = trim(I('audit_remark'));
                if (!$id) $this->error('获取数据错误');
                if (!$status) $this->error('请选择审核结果');
                $db = M('op_project');
                $data = array();
                $data['audit_status'] = $status;
                $data['audit_remark'] = $audit_remark;
                $data['audit_time'] = NOW_TIME;
                $res = $db->where(array('id' => $id))->save($data);
                if ($res) {
                    $op = M('op')->where(array('op_id' => $opid))->find();
                    if ($status == 2) { //审核未通过,反馈给线控
                        $process_node = 51; //编制业务实施方案
                        $pro_status = 2; // 事前提醒
                        save_process_log($process_node, $pro_status, $op['project'], $op['id'], '', $op['line_blame_uid'], $op['line_blame_name']); //保存待办事宜
                    }

                    $ok_node_id = 52; //确认业务实施方案
                    save_process_ok($ok_node_id);
                    $this->success('保存成功');
                } else {
                    $this->error('保存失败');
                }
            }

            if ($opid && $savetype == 28){
                $content            = trim(I('content'));
                $id                 = I('id');
                $summary_db         = M('op_summary');
                $data               = array();
                $data['op_id']      = $opid;
                $data['content']    = stripslashes($content);
                $data['user_id']    = cookie('userid');
                $data['user_name']  = cookie('nickname');
                $data['create_time']= NOW_TIME;
                if ($id){
                    $res            = $summary_db -> where(array('id'=>$id))->save($data);
                }else{
                    $res            = $summary_db -> add($data);
                }
                if ($res){
                    $record             = array();
                    $record['op_id']    = $opid;
                    $record['optype']   = 1;
                    $record['explain']  = '保存项目总结';

                    //流程    反馈给实施部门经理、业务部门经理、业务人
                    $oplist             = $db->where(array('op_id'=>$opid))->find();
                    $departments        = array_unique(array($oplist['create_user_department_id'],$oplist['dijie_department_id']));
                    $users              = M('salary_department')->where(array('id'=>array('in',$departments)))->getField('manager_id,manager_name',true);
                    $users[$oplist['create_user']]  = $oplist['create_user_name'];
                    $process_node       = 85; //填写项目总结记录
                    $pro_status         = 1; // 未读信息
                    foreach ($users as $k=>$v){
                        save_process_log($process_node, $pro_status, $oplist['project'], $oplist['id'], '',$k, $v); //保存待办事宜
                    }
                    $this->success('保存成功');
                }else{
                    $this->error('数据保存失败');
                }

            }


            echo $num;
        }

    }


    //@@@NODE-3###res_audit###审核委托设计工作交接单###
    public function res_audit()
    {
        if (isset($_POST['dosubmint'])) {
            $design_id = I('designed');
        } else {
            $opid = I('opid');
            $design = M('op_design')->where(array('op_id' => $opid))->find();         //委托设计工作交接单
            $work_plan = M('op_work_plans')->where(array('op_id' => $opid))->find();     //业务实施计划单
            $plan_lists = M('op_work_plan_lists')->where(array('plan_id' => $work_plan['id']))->select();
            $this->work_plan = $work_plan;
            $this->additive = explode(',', $work_plan['additive']);
            $additive_con = array(
                '1' => '行程或方案',
                '2' => '需解决大交通的《人员信息表》',
                '3' => '其他'
            );
            $this->additive_con = $additive_con;
            $this->plan_lists = $plan_lists;
            $this->type = I('type');
            if (!$design && !$work_plan) {
                $this->error('暂无数据信息');
            }
            $this->design = $design;
            $this->op = M('op')->where(array('op_id' => $opid))->find();
            $user_info = M()->table('__ACCOUNT__ as a')
                ->field('a.mobile,d.department,o.create_user_name')
                ->join('__OP__ as o on o.create_user = a.id', 'left')
                ->join('__SALARY_DEPARTMENT__ as d on d.id = a.departmentid')
                ->where(array('o.op_id' => $opid))
                ->find();
            $this->user_info = $user_info;
            $this->output_info = array(
                '1' => '出片打样',
                '2' => '喷绘',
                '3' => '只提供电子文件'
            );
            $this->audit_status = array(
                P::AUDIT_STATUS_NOT_AUDIT => '<span class="yellow">未审核</span>',
                P::AUDIT_STATUS_PASS => '<span class="green">审核通过</span>',
                P::AUDIT_STATUS_NOT_PASS => '<span class="red">未通过</span>',
            );

            //人员名单关键字
            $this->userkey = get_username();

            $this->display();
        }
    }

    //@@@NODE-3###assign_line###指派人员跟进线路行程信息###
    public function assign_line()
    {
        $opid = I('opid');
        $info = I('info');
        $user = M('account')->getField('id,nickname', true);

        if (isset($_POST['dosubmit']) && $info) {

            $data = array();
            $data['line'] = $info;
            $auth = M('op_auth')->where(array('op_id' => $opid))->find();

            //创建工单
            //$thing  = "行程方案";
            //project_worder($info,$opid,$thing);

            if ($auth) {
                M('op_auth')->data($data)->where(array('id' => $auth['id']))->save();
            } else {
                $data['op_id'] = $opid;
                M('op_auth')->add($data);
            }

            $record = array();
            $record['op_id'] = $opid;
            $record['optype'] = 2;
            $record['explain'] = '指派【' . $user[$info] . '】负责项目行程';
            op_record($record);

            echo '<script>window.top.location.reload();</script>';

        } else {

            //用户列表
            $key = I('key');
            $db = M('account');
            $where = array();
            $where['id'] = array('gt', 3);
            if ($key) $where['nickname'] = array('like', '%' . $key . '%');
            $pagecount = $db->where($where)->count();
            $page = new Page($pagecount, 6);
            $this->pages = $pagecount > 6 ? $page->show() : '';
            $this->lists = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('roleid'))->select();
            $this->role = M('role')->getField('id,role_name', true);
            $this->opid = $opid;
            $this->display('assign_line');
        }
    }

    //@@@NODE-3###assign_hesuan###指派人员跟进成本核算###
    public function assign_hesuan()
    {
        $opid = I('opid');
        $info = I('info');
        $user = M('account')->getField('id,nickname', true);

        if (isset($_POST['dosubmit']) && $info) {

            $data = array();
            $data['hesuan'] = $info;
            $data['yusuan'] = $info;
            $data['jiesuan'] = $info;
            $auth = M('op_auth')->where(array('op_id' => $opid))->find();

            //创建工单
            //$thing          = "行程方案";
            //project_worder($info,$opid,$thing);

            if ($auth) {
                $res = M('op_auth')->data($data)->where(array('id' => $auth['id']))->save();
            } else {
                $data['op_id'] = $opid;
                $res = M('op_auth')->add($data);
            }

            if ($res) {
                $op_list = M('op')->where(array('op_id' => $opid))->find();
                $process_node = 42; //42	进行成本核算
                $pro_status = 2; //事前提醒
                $title = $op_list['project'];
                $req_id = $op_list['id'];
                $to_uname = username($info);
                save_process_log($process_node, $pro_status, $title, $req_id, '', $info, $to_uname); //保存待办事宜

                //消除待办事宜
                $ok_node = 41; //安排成本核算
                save_process_ok($ok_node);

                //发送消息
                $uid = cookie('userid');
                $title = cookie('name') . '指派您跟进项目成本核算';
                $content = '项目名称: ' . $op_list['project'];
                $url = U('Finance/costacc', array('opid' => $opid));
                $users = '[' . $info . ']';
                send_msg($uid, $title, $content, $url, $users, '');

                $record = array();
                $record['op_id'] = $opid;
                $record['optype'] = 2;
                $record['explain'] = '指派【' . $user[$info] . '】跟进项目成本核算';
                op_record($record);
            }

            echo '<script>window.top.location.reload();</script>';

        } else {

            //用户列表
            $key = I('key');
            $db = M('account');
            $where = array();
            $where['id'] = array('gt', 3);
            $where['status'] = array('eq', 0);    //1=>停用, 2=>删除
            if ($key) $where['nickname'] = array('like', '%' . $key . '%');
            $pagecount = $db->where($where)->count();
            $page = new Page($pagecount, 6);
            $this->pages = $pagecount > 6 ? $page->show() : '';
            $this->lists = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('roleid'))->select();

            $this->role = M('role')->getField('id,role_name', true);
            $this->opid = $opid;
            $this->display('assign_hesuan');
        }
    }

    //@@@NODE-3###assign_yusuan###指派人员跟进项目预算###
    public function assign_yusuan()
    {
        $opid = I('opid');
        $info = I('info');
        $user = M('account')->getField('id,nickname', true);

        if (isset($_POST['dosubmit']) && $info) {

            $data = array();
            $data['yusuan'] = $info;
            $data['jiesuan'] = $info;
            $auth = M('op_auth')->where(array('op_id' => $opid))->find();

            //创建工单
            $thing = "行程方案";
            //project_worder($info,$opid,$thing);

            if ($auth) {
                M('op_auth')->data($data)->where(array('id' => $auth['id']))->save();
            } else {
                $data['op_id'] = $opid;
                M('op_auth')->add($data);
            }

            //发送消息
            $uid = cookie('userid');
            $title = cookie('name') . '指派您跟进项目预算';
            $content = '项目编号: ' . $opid;
            $url = U('Finance/op', array('opid' => $opid));
            $users = '[' . $info . ']';
            send_msg($uid, $title, $content, $url, $users, '');

            $record = array();
            $record['op_id'] = $opid;
            $record['optype'] = 2;
            $record['explain'] = '指派【' . $user[$info] . '】跟进项目预算';
            op_record($record);

            echo '<script>window.top.location.reload();</script>';

        } else {

            //用户列表
            $key = I('key');
            $db = M('account');
            $where = array();
            $where['id'] = array('gt', 3);
            $where['status'] = array('eq', 0);    //1=>停用, 2=>删除
            if ($key) $where['nickname'] = array('like', '%' . $key . '%');
            $pagecount = $db->where($where)->count();
            $page = new Page($pagecount, 6);
            $this->pages = $pagecount > 6 ? $page->show() : '';
            $this->lists = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('roleid'))->select();

            $this->role = M('role')->getField('id,role_name', true);
            $this->opid = $opid;
            $this->display('assign_yusuan');
        }
    }

    //@@@NODE-3###assign_jiesuan###指派人员跟进项目预算###
    public function assign_jiesuan()
    {
        $opid = I('opid');
        $info = I('info');
        $user = M('account')->getField('id,nickname', true);

        if (isset($_POST['dosubmit']) && $info) {

            $data = array();
            $data['jiesuan'] = $info;
            $auth = M('op_auth')->where(array('op_id' => $opid))->find();

            //创建工单
            $thing = "行程方案";
            //project_worder($info,$opid,$thing);

            if ($auth) {
                M('op_auth')->data($data)->where(array('id' => $auth['id']))->save();
            } else {
                $data['op_id'] = $opid;
                M('op_auth')->add($data);
            }

            //发送消息
            $uid = cookie('userid');
            $title = cookie('name') . '指派您跟进项目结算';
            $content = '项目编号: ' . $opid;
            $url = U('Finance/settlement', array('opid' => $opid));
            $users = '[' . $info . ']';
            send_msg($uid, $title, $content, $url, $users, '');

            $record = array();
            $record['op_id'] = $opid;
            $record['optype'] = 2;
            $record['explain'] = '指派【' . $user[$info] . '】跟进项目结算';
            op_record($record);

            echo '<script>window.top.location.reload();</script>';

        } else {

            //用户列表
            $key = I('key');
            $db = M('account');
            $where = array();
            $where['id'] = array('gt', 3);
            $where['status'] = array('eq', 0);    //1=>停用, 2=>删除
            if ($key) $where['nickname'] = array('like', '%' . $key . '%');
            $pagecount = $db->where($where)->count();
            $page = new Page($pagecount, 6);
            $this->pages = $pagecount > 6 ? $page->show() : '';
            $this->lists = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('roleid'))->select();
            $this->role = M('role')->getField('id,role_name', true);
            $this->opid = $opid;
            $this->display('assign_jiesuan');
        }
    }

    //@@@NODE-3###assign_res###指派人员跟进资源调度###
    public function assign_res()
    {
        $opid = I('opid');
        $info = I('info');
        $user = M('account')->getField('id,nickname', true);
        if (isset($_POST['dosubmit']) && $info) {

            $data = array();
            $data['res'] = $info;
            $auth = M('op_auth')->where(array('op_id' => $opid))->find();

            //创建工单
            $thing = "物资调度";
            project_worder($info, $opid, $thing);

            if ($auth) {
                M('op_auth')->data($data)->where(array('id' => $auth['id']))->save();
            } else {
                $data['op_id'] = $opid;
                M('op_auth')->add($data);
            }


            $record = array();
            $record['op_id'] = $opid;
            $record['optype'] = 2;
            $record['explain'] = '指派【' . $user[$info] . '】负责项目所需资源调度';
            op_record($record);

            echo '<script>window.top.location.reload();</script>';

        } else {

            //用户列表
            $key = I('key');
            $db = M('account');
            $where = array();
            $where['id'] = array('gt', 3);
            if ($key) $where['nickname'] = array('like', '%' . $key . '%');
            $pagecount = $db->where($where)->count();
            $page = new Page($pagecount, 6);
            $this->pages = $pagecount > 6 ? $page->show() : '';
            $this->lists = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('roleid'))->select();
            $this->role = M('role')->getField('id,role_name', true);
            $this->opid = $opid;
            $this->display('assign_res');
        }
    }

    //@@@NODE-3###assign_res###指派人员跟进导游辅导员调度###
    public function assign_guide()
    {
        $opid = I('opid');
        $info = I('info');
        $user = M('account')->getField('id,nickname', true);
        if (isset($_POST['dosubmit']) && $info) {

            $data = array();
            $data['guide'] = $info;
            $auth = M('op_auth')->where(array('op_id' => $opid))->find();

            //创建工单
            $thing = "专家辅导员调度";
            project_worder($info, $opid, $thing);

            if ($auth) {
                M('op_auth')->data($data)->where(array('id' => $auth['id']))->save();
            } else {
                $data['op_id'] = $opid;
                M('op_auth')->add($data);
            }

            $record = array();
            $record['op_id'] = $opid;
            $record['optype'] = 2;
            $record['explain'] = '指派【' . $user[$info] . '】负责项目导游辅导员调度';
            op_record($record);

            echo '<script>window.top.location.reload();</script>';

        } else {

            //用户列表
            $key = I('key');
            $db = M('account');
            $where = array();
            $where['id'] = array('gt', 3);
            if ($key) $where['nickname'] = array('like', '%' . $key . '%');
            $pagecount = $db->where($where)->count();
            $page = new Page($pagecount, 6);
            $this->pages = $pagecount > 6 ? $page->show() : '';
            $this->lists = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('roleid'))->select();
            $this->role = M('role')->getField('id,role_name', true);
            $this->opid = $opid;
            $this->display('assign_guide');
        }
    }

    //@@@NODE-3###assign_scheme###指派实施方案负责人###
    public function assign_scheme()
    {
        $opid = I('opid');
        $info = I('info');
        $user = M('account')->getField('id,nickname', true);
        if (isset($_POST['dosubmit']) && $info) {

            $data = array();
            $data['scheme'] = $info;
            $auth = M('op_auth')->where(array('op_id' => $opid))->find();

            //创建工单
            //$thing  = "编制实施方案";
            //project_worder($info,$opid,$thing);

            if ($auth) {
                M('op_auth')->data($data)->where(array('id' => $auth['id']))->save();
            } else {
                $data['op_id'] = $opid;
                M('op_auth')->add($data);
            }
            $record = array();
            $record['op_id'] = $opid;
            $record['optype'] = 2;
            $record['explain'] = '指派【' . $user[$info] . '】负责编制实施方案';
            op_record($record);

            echo '<script>window.top.location.reload();</script>';

        } else {

            //用户列表
            $key = I('key');
            $db = M('account');
            $where = array();
            $where['id'] = array('gt', 3);
            if ($key) $where['nickname'] = array('like', '%' . $key . '%');
            $pagecount = $db->where($where)->count();
            $page = new Page($pagecount, 6);
            $this->pages = $pagecount > 6 ? $page->show() : '';
            $this->lists = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('roleid'))->select();
            $this->role = M('role')->getField('id,role_name', true);
            $this->opid = $opid;
            $this->display('assign_scheme');
        }
    }

    //@@@NODE-3###assign_res###指派人员跟进导游辅导员调度###
    public function assign_material()
    {
        $opid = I('opid');
        $info = I('info');
        $user = M('account')->getField('id,nickname', true);
        if (isset($_POST['dosubmit']) && $info) {

            $data = array();
            $data['material'] = $info;
            $auth = M('op_auth')->where(array('op_id' => $opid))->find();

            //创建工单
            $thing = "合格供方调度";
            project_worder($info, $opid, $thing);

            if ($auth) {
                M('op_auth')->data($data)->where(array('id' => $auth['id']))->save();
            } else {
                $data['op_id'] = $opid;
                M('op_auth')->add($data);
            }

            $record = array();
            $record['op_id'] = $opid;
            $record['optype'] = 2;
            $record['explain'] = '指派【' . $user[$info] . '】负责项目合格供方调度';
            op_record($record);

            echo '<script>window.top.location.reload();</script>';

        } else {

            //用户列表
            $key = I('key');
            $db = M('account');
            $where = array();
            $where['id'] = array('gt', 3);
            if ($key) $where['nickname'] = array('like', '%' . $key . '%');
            $pagecount = $db->where($where)->count();
            $page = new Page($pagecount, 6);
            $this->pages = $pagecount > 6 ? $page->show() : '';
            $this->lists = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('roleid'))->select();
            $this->role = M('role')->getField('id,role_name', true);
            $this->opid = $opid;
            $this->display('assign_material');
        }
    }

    //@@@NODE-3###assign_price###指派人员制定价格###
    public function assign_price()
    {
        $opid = I('opid');
        $info = I('info');
        $user = M('account')->getField('id,nickname', true);
        if (isset($_POST['dosubmit']) && $info) {

            $data = array();
            $data['price'] = $info;
            $auth = M('op_auth')->where(array('op_id' => $opid))->find();

            //创建工单
            $thing = "项目标价";
            project_worder($info, $opid, $thing);

            if ($auth) {
                M('op_auth')->data($data)->where(array('id' => $auth['id']))->save();
            } else {
                $data['op_id'] = $opid;
                M('op_auth')->add($data);
            }
            $record = array();
            $record['op_id'] = $opid;
            $record['optype'] = 2;
            $record['explain'] = '指派【' . $user[$info] . '】负责项目标价';
            op_record($record);

            echo '<script>window.top.location.reload();</script>';

        } else {

            //用户列表
            $key = I('key');
            $db = M('account');
            $where = array();
            $where['id'] = array('gt', 3);
            if ($key) $where['nickname'] = array('like', '%' . $key . '%');
            $pagecount = $db->where($where)->count();
            $page = new Page($pagecount, 6);
            $this->pages = $pagecount > 6 ? $page->show() : '';
            $this->lists = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('roleid'))->select();
            $this->role = M('role')->getField('id,role_name', true);
            $this->opid = $opid;
            $this->display('assign_price');
        }
    }

    //@@@NODE-3###public_save_price###保存项目价格###
    public function public_save_price()
    {

        $db = M('op_pretium');
        $opid = I('opid');
        $pretium = I('pretium');
        $resid = I('resid');
        $num = 0;

        //保存价格政策
        if ($opid && $pretium) {

            $delid = array();
            foreach ($pretium as $k => $v) {
                $data = array();
                $data = $v;
                if ($resid && $resid[$k]['id']) {
                    $edits = $db->data($data)->where(array('id' => $resid[$k]['id']))->save();
                    $delid[] = $resid[$k]['id'];
                    $num++;
                } else {
                    $data['op_id'] = $opid;
                    $savein = $db->add($data);
                    $delid[] = $savein;
                    if ($savein) $num++;
                }
            }

            $del = $db->where(array('op_id' => $opid, 'id' => array('not in', $delid)))->delete();
            if ($del) $num++;
        }

        if ($num) {
            $record = array();
            $record['op_id'] = $opid;
            $record['optype'] = 5;
            $record['explain'] = '保存项目标价';
            op_record($record);
        }

        echo $num;
    }

    // @@@NODE-3###public_save_line###保存线路### (public_save_line can delete 20191224)
    /* public function public_save_line(){

		$opid       = I('opid');
		$days       = I('days');
		$line_id    = I('line_id');
		$num        = 0;

		//保存线路
		$isadd = M('op')->data(array('line_id'=>$line_id))->where(array('op_id'=>$opid))->save();
		if($isadd) $num++;

		//删除历史日程
		$del = M('op_line_days')->where(array('op_id'=>$opid))->delete();
		if($del) $num++;
		foreach($days as $v){
			 $data = array();
			 $data['op_id'] = $opid;
			 $data['citys']    =  $v['citys'];
			 $data['content']  =  $v['content'];
			 $data['remarks']  =  $v['remarks'];
			 $savein = M('op_line_days')->add($data);
			 if($savein) $num++;
		}

		$record = array();
		$record['op_id']   = $opid;
		$record['optype']  = 3;
		$record['explain'] = '保存项目行程线路';
		op_record($record);

		echo $num;
	}*/

    // @@@NODE-3###public_ajax_line###获取线路日程### (public_ajax_line can delete 20191224)
    /*public function public_ajax_line(){
		$db = M('product_line_days');
		$line_id = I('id');
		$list = $db->where(array('line_id'=>$line_id))->select();
		if($list){
			foreach($list as $k=>$row){
			 	echo '<div class="daylist" id="task_a_'.$row['id'].'"><a class="aui_close" href="javascript:;" style="right:25px;" onClick="del_timu(\'task_a_'.$row['id'].'\')">×</a><div class="col-md-12 pd"><label class="titou"><strong>第<span class="tihao">'.($k+1).'</span>天</strong></label><div class="input-group"><input type="text" placeholder="所在城市" name="days['.$row['id'].'][citys]" class="form-control" value="'.$row['citys'].'"></div><div class="input-group pads"><textarea class="form-control" placeholder="行程安排"  name="days['.$row['id'].'][content]">'.$row['content'].'</textarea></div><div class="input-group"><input type="text" placeholder="房餐车安排" name="days['.$row['id'].'][remarks]" value="'.$row['remarks'].'" class="form-control"></div></div></div>';
			}
		}

	}*/

    // @@@NODE-3###public_ajax_material###获取模块物资信息###
    public function public_ajax_material()
    {
        $opid = I('id');
        $list = M()->table('__OP_MATERIAL__ as m')->field('c.*,m.*')->join('__OP_COST__ as c on m.material=c.remark')->where(array('m.op_id' => $opid, 'c.op_id' => $opid, 'c.cost_type' => 4))->order('m.id')->select();

        foreach ($list as $v) {
            echo '<tr class="expense" id="wuzi_nid_' . $v['id'] . '"><td><input type="hidden" name="cost[' . (20000 + $v['id']) . '][item]" value="物资费"><input type="hidden" name="cost[' . (20000 + $v['id']) . '][cost_type]" value="4"><input type="hidden" name="cost[' . (20000 + $v['id']) . '][relevant_id]" value="' . $v['material_id'] . '"><input type="hidden" name="cost[' . (20000 + $v['id']) . '][remark]" value="' . $v['material'] . '"><input type="hidden" name="resid[' . (20000 + $v['id']) . '][id]" value="' . $v['id'] . '"><input type="hidden" name="wuzi[' . (20000 + $v['id']) . '][material]" value="' . $v['material'] . '"><input type="hidden" name="wuzi[' . (20000 + $v['id']) . '][material_id]" value="' . $v['material_id'] . '">' . $v['material'] . '</td><td><input type="text" name="cost[' . (20000 + $v['id']) . '][cost]" value="' . $v['cost'] . '" placeholder="价格" class="form-control min_input cost"></td><td><span>X</span></td><td><input type="text" name="cost[' . (20000 + $v['id']) . '][amount]" value="' . $v['amount'] . '" placeholder="数量" class="form-control min_input amount"></td><td class="total">¥' . ($v['cost'] * $v['amount']) . '</td><td><input type="text" name="wuzi[' . (20000 + $v['id']) . '][remarks]" value="' . $v['remarks'] . '" class="form-control"></td><td><a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox(\'wuzi_nid_' . $v['id'] . '\')">删除</a></td></tr>';
        }
    }

    // @@@NODE-3###select_product###选择产品模块###
    public function select_product()
    {

        $key = I('key');
        $status = I('status', '-1');
        $kind = I('kind', '-1');
        $mdd = I('mdd');

        $db = M('product_line');
        $this->status = $status;
        $this->kind = $kind;
        $where = array();
        if ($this->status != '-1') $where['audit_status'] = $this->status;
        if ($this->kind != '-1') $where['kind'] = $this->kind;
        if ($key) $where['title'] = array('like', '%' . $key . '%');
        if ($mdd) $where['dest'] = array('like', '%' . $mdd . '%');

        $pagecount = $db->where($where)->count();
        $page = new Page($pagecount, 25);
        $this->pages = $pagecount > 25 ? $page->show() : '';
        $this->lists = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('input_time'))->select();
        $this->kindlist = M('project_kind')->select();

        $this->display('select_product');
    }

    // @@@NODE-3###public_select_standard_product###选择标准化产品###
    public function public_select_standard_product()
    {
        $db = M('producted');
        $key = I('key');
        $kind = I('kind');
        $where = array();
        $where['business_dept'] = $kind;
        $where['audit_status'] = 1;
        if ($key) $where['title'] = array('like', '%' . $key . '%');

        $pagecount = $db->where($where)->count();
        $page = new Page($pagecount, 25);
        $this->pages = $pagecount > 25 ? $page->show() : '';
        $lists = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('input_time'))->select();
        foreach ($lists as $k => $v) {
            $lists[$k]['apply_time_str'] = get_apply_time_str($v['apply_year'], $v['apply_time']);
        }

        $this->kind = $kind;
        $this->lists = $lists;
        $this->display('select_standard_product');
    }

    // @@@NODE-3###select_module###选择产品模块###
    public function select_module()
    {

        $opid = I('opid');
        $kind = I('kind');
        $key = I('key');
        $type = I('type');
        $subject_field = I('subject_field');
        $from = I('from');
        $kind = $opid ? M('op')->where(array('op_id' => $opid))->getField('kind') : $kind;

        $db = M('product');
        $this->opid = $opid;
        $where = array();
        $where['audit_status'] = 1;
        if ($kind) $where['business_dept'] = array('like', '%' . $kind . '%');
        if ($key) $where['title'] = array('like', '%' . $key . '%');
        if ($type) $where['type'] = array('eq', $type);
        if ($from) $where['from'] = array('eq', $type);
        if ($subject_field) $where['subject_field'] = array('eq', $subject_field);

        $pagecount = $db->where($where)->count();
        $page = new Page($pagecount, 25);
        $this->pages = $pagecount > 25 ? $page->show() : '';
        $lists = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('input_time'))->select();

        $ageval = C('AGE_LIST');
        $reckon_mode = C('RECKON_MODE');
        $new_lists = array();
        foreach ($lists as $k => $v) {
            $business_depts = explode(',', $v['business_dept']);
            if (in_array($kind, $business_depts)) {
                $agelist = array();
                $ages = explode(',', $v['age']);
                foreach ($ageval as $key => $value) {
                    if (in_array($key, $ages)) {
                        $agelist[] = $value;
                    }
                }
                $v['agelist'] = implode(',', $agelist);
                $v['reckon_modelist'] = $reckon_mode[$v['reckon_mode']] ? $reckon_mode[$v['reckon_mode']] : "<span class='red'>未定</span>";
                $v['sales_price'] = $v['sales_price'] ? $v['sales_price'] : '0.00';
                $new_lists[] = $v;
            }

        }

        $this->lists = $new_lists;
        $this->product_type = C('PRODUCT_TYPE');
        $this->subject_fields = C('SUBJECT_FIELD');
        $this->product_from = C('PRODUCT_FROM');
        $this->ages = C('AGE_LIST');
        $this->kind = $kind;
        $this->kindlist = M('project_kind')->select();

        $this->display('select_product_module');

    }

    // @@@NODE-3###select_guide###选择导游辅导员###
    public function select_guide()
    {
        $kind = I('kind');
        $key = I('key');
        $sex = I('sex');
        $opid = I('opid');

        //求项目类型,根据项目类型计算出所选专家的价格
        $kid = M('op')->where(array('op_id' => $opid))->getField('kind');

        $where = array();
        $where['1'] = priv_where(P::REQ_TYPE_GUIDE_RES_U);
        if ($kind) $where['kind'] = $kind;
        if ($key) $where['name'] = array('like', '%' . $key . '%');
        if ($sex) $where['sex'] = $sex;

        //分页
        $pagecount = M('guide')->where($where)->count();
        $page = new Page($pagecount, 25);
        $this->pages = $pagecount > 25 ? $page->show() : '';

        $this->reskind = M('guidekind')->getField('id,name', true);
        $lists = M('guide')->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('input_time'))->select();
        foreach ($lists as $k => $v) {
            $gk_id = $v['kind'];
            $price = M('guide_price')->where(array('kid' => $kid, 'gk_id' => $gk_id))->getField('price');
            //if($v['fee'] == '0.00') $v['fee'] = null;
            $lists[$k]['fee'] = $price;

        }
        $this->lists = $lists;

        $this->display('select_guide');
    }


    // @@@NODE-3###select_supplier###选择合格供方###
    public function select_supplier()
    {

        $kind = I('kind');
        $key = I('key');

        $where = array();
        $where['1'] = priv_where(P::REQ_TYPE_SUPPLIER_RES_U);
        if ($kind) $where['kind'] = $kind;
        if ($key) $where['name'] = array('like', '%' . $key . '%');

        //分页
        $pagecount = M('supplier')->where($where)->count();
        $page = new Page($pagecount, 25);
        $this->pages = $pagecount > 25 ? $page->show() : '';

        $this->reskind = M('supplierkind')->getField('id,name', true);
        $this->lists = M('supplier')->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('input_time'))->select();

        $this->display('select_supplier');
    }


    // @@@NODE-3###importuser###导入名单###
    public function importuser()
    {
        $time = time();
        if (isset($_POST['dosubmit'])) {

            $data = array();

            $file = $_FILES["file"] ? $_FILES["file"] : $this->error('请提交要导入的文件！');

            //获取文件扩展名
            $fileext = explode('.', $file["name"]);

            if ($fileext[1] == 'xls' || $fileext[1] == 'xlsx') {
                if ($file["size"] < 10 * 1024 * 1024) {
                    if ($_FILES["file"]["error"] > 0) {
                        //报错
                        $this->error($file["error"], I('referer', ''));
                    } else {

                        //新文件名
                        $newname = "upload/xls/" . cookie('comid') . '_' . date('YmdHis', time()) . '.' . $fileext[1];

                        //上传留存
                        $ismove = move_uploaded_file($file["tmp_name"], $newname);

                        //读取EXCEL文件
                        if ($ismove) $data = importexcel($newname);
                        $sum = count($data) - 1;

                        $this->data = $data;


                    }
                } else {
                    $this->error('文件大小不能超过10M！');
                }
            } else {
                $this->error('请上传Excel文件！');
            }


        }

        $this->display('importuser');


    }


    // @@@NODE-3###app_materials###申请物资###
    public function app_materials()
    {
        $opid = I('opid');

        if (!$opid) $this->error('出团计划不存在');

        $where = array();
        $where['op_id'] = $opid;

        $op = M('op')->where($where)->find();
        $budget = M('op_budget')->where($where)->find();
        $settlement = M('op_settlement')->where(array('op_id' => $opid))->find();

        $matelist = M()->table('__OP_MATERIAL__ as m')->field('c.*,m.*')->join('__OP_COST__ as c on m.id=c.link_id')->where(array('m.op_id' => $opid, 'c.op_id' => $opid, 'c.cost_type' => 4))->order('m.id')->select();
        foreach ($matelist as $k => $v) {
            //获取物资库存
            $stock = M('material')->where(array('material' => $v['material']))->find();
            $matelist[$k]['stock'] = $stock['stock'] ? $stock['stock'] : 0;
            $matelist[$k]['stages'] = $stock['stages'] ? $stock['stages'] : 0;
            $matelist[$k]['lastcost'] = $stock ? $stock['price'] : '0.00';

            $yichuku = $v['amount'] - $v['outsum'];
            if ($matelist[$k]['stock'] < $yichuku) {
                $matelist[$k]['status'] = $v['purchasesum'] ? '<span class="yellow">等待入库</span>' : '<span class="red">申请采购</span>';
            } else {
                $matelist[$k]['status'] = $v['outsum'] ? '<span class="blue">完成出库</span>' : '<span class="green">申请出库</span>';
            }

        }

        $where = array();
        $where['req_type'] = P::REQ_TYPE_BUDGET;
        $where['req_id'] = $budget['id'];
        $audit = M('audit_log')->where($where)->find();
        if ($audit['dst_status'] == 0) {
            $show = '未审批';
            $show_user = '未审批';
            $show_time = '等待审批';
        } else if ($audit['dst_status'] == 1) {
            $show = '<span class="green">已通过</span>';
            $show_user = $audit['audit_uname'];
            $show_time = date('Y-m-d H:i:s', $audit['audit_time']);
        } else if ($audit['dst_status'] == 2) {
            $show = '<span class="red">未通过</span>';
            $show_user = $audit['audit_uname'];
            $show_reason = $audit['audit_reason'];
            $show_time = date('Y-m-d H:i:s', $audit['audit_time']);
        }
        $op['showstatus'] = $show;
        $op['show_user'] = $show_user;
        $op['show_time'] = $show_time;
        $op['show_reason'] = $show_reason;

        $this->op = $op;
        $this->matelist = $matelist;
        $this->budget = $budget;
        $this->settlement = $settlement;
        $this->business_depts = C('BUSINESS_DEPT');
        $this->subject_fields = C('SUBJECT_FIELD');
        $this->ages = C('AGE_LIST');
        $this->kinds = M('project_kind')->getField('id,name', true);
        $this->display('app_materials');
    }


    // @@@NODE-3###out_materials###申请物资###
    public function out_materials()
    {
        $opid = I('opid');

        //获取项目信息
        $where = array();
        $where['op_id'] = $opid;
        $op = M('op')->where($where)->find();
        $budget = M('op_budget')->where($where)->find();
        $roledet = M('role')->where(array('role_name' => $op['op_create_user']))->find();

        $ckinfo = array();
        $cginfo = array();


        //物资列表
        $matelist = M()->table('__OP_MATERIAL__ as m')->field('c.*,m.*')->join('__OP_COST__ as c on m.id=c.link_id')->where(array('m.op_id' => $opid, 'c.op_id' => $opid, 'c.cost_type' => 4))->order('m.id')->select();
        foreach ($matelist as $k => $v) {
            //获取物资库存
            $wz = M('material')->where(array('material' => $v['material']))->find();
            $stock = $wz['stock'] ? $wz['stock'] : 0;
            $lastcost = $wz['price'] ? $wz['price'] : 0;
            $wz_id = $wz['id'];


            /*处理出库*/
            $outrand = M('material_out')->where(array('op_id' => $opid, 'material' => $v['material'], 'audit_status' => array('neq', 2)))->sum('amount');
            $outsum = $v['amount'] - $outrand;
            $daichuku = $outrand - $v['outsum'];
            $stock = $stock - $daichuku;
            if ($outsum > 0 && $stock > 0) {
                //申请出库
                $ckinfo[$k]['op_id'] = $opid;
                $ckinfo[$k]['material_id'] = $wz_id;
                $ckinfo[$k]['material'] = $v['material'];
                $ckinfo[$k]['unit_price'] = $lastcost;
                $ckinfo[$k]['order_id'] = $op['group_id'];
                $ckinfo[$k]['receive_liable'] = cookie('nickname');
                $ckinfo[$k]['out_time'] = time();
                if ($stock >= $outsum) {
                    //如果库存充足，直接出库
                    $ckinfo[$k]['amount'] = $outsum;
                    $ckinfo[$k]['total'] = $outsum * $lastcost;
                } else {
                    //如果库存不够，申请部分出库
                    $ckinfo[$k]['amount'] = $stock;
                    $ckinfo[$k]['total'] = $stock * $lastcost;
                }
            }


            /*处理采购*/
            $gourand = M('material_purchase')->where(array('op_id' => $opid, 'material' => $v['material'], 'audit_status' => array('neq', 2)))->sum('amount');
            $gousum = $v['amount'] - $gourand - $outrand;
            $caigou = $gousum - $stock;
            if ($stock < $gousum && $caigou > 0) {
                //申请采购
                $cginfo[$k]['op_id'] = $opid;
                $cginfo[$k]['material_id'] = $wz_id;
                $cginfo[$k]['material'] = $v['material'];
                $cginfo[$k]['unit_price'] = $v['cost'];
                $cginfo[$k]['order_id'] = $op['group_id'];
                $cginfo[$k]['department'] = $roledet['id'];
                $cginfo[$k]['create_time'] = time();
                $cginfo[$k]['amount'] = $caigou;
                $cginfo[$k]['total'] = $caigou * $v['cost'];
                $cginfo[$k]['op_user'] = $op['create_user_name'];
            }

        }


        $opnum = 0;
        if (count($ckinfo)) {
            //申请出库
            $ck = array();
            $ck['type'] = 0;
            $ck['order_id'] = $op['group_id'];
            $ck['receive_liable'] = cookie('nickname');
            $ck['op_id'] = $opid;
            $ck['name'] = $op['project'];
            $ck['out_time'] = time();
            $ck['app_user'] = cookie('nickname');
            $batch_id = M('material_out_batch')->add($ck);
            if ($batch_id) {
                $this->request_audit(P::REQ_TYPE_GOODS_OUT, $batch_id);
                foreach ($ckinfo as $v) {
                    $info = array();
                    $info = $v;
                    $info['batch_id'] = $batch_id;
                    M('material_out')->add($info);
                }
                $opnum++;
            }
        }

        if (count($cginfo)) {

            //采购备注
            $proid = M()->table('__PRODUCT_LINE_TPL__ as t')->join('__OP__ as o on o.line_id = t.line_id')->where(array('o.op_id' => $opid, 't.type' => 1))->GetField('pro_id', true);

            //申请采购
            $cg = array();
            $cg['op_id'] = $opid;
            $cg['order_id'] = $op['group_id'];
            $cg['name'] = $op['project'];
            $cg['department'] = $roledet['id'];
            $cg['create_time'] = time();
            $cg['app_user'] = cookie('nickname');
            $cg['op_user'] = $op['create_user_name'];
            $batch_id = M('material_purchase_batch')->add($cg);
            if ($batch_id) {
                $this->request_audit(P::REQ_TYPE_GOODS_PURCHASE, $batch_id);
                foreach ($cginfo as $v) {
                    $info = array();
                    $info = $v;
                    $info['batch_id'] = $batch_id;
                    //采购信息
                    $wzcg = M('product_material')->where(array('material' => $info['material'], 'product_id' => array('in', implode(',', $proid))))->find();
                    if ($wzcg) {
                        $info['unit_price'] = $wzcg['unitprice'];
                        $info['total'] = $wzcg['unitprice'] * $v['amount'];
                        $info['remarks'] = $wzcg['channel'];
                    }
                    M('material_purchase')->add($info);
                }
                $opnum++;
            }
        }

        if ($opnum) {
            M('op')->data(array('app_material_time' => time()))->where(array('op_id' => $opid))->save();
        }

        echo $opnum;


    }

    // @@@NODE-3###revert_materials###归还物资###
    public function revert_materials()
    {
        $opid = I('opid');

        $matelist = M()->table('__OP_MATERIAL__ as m')->field('c.*,m.*')->join('__OP_COST__ as c on m.id=c.link_id')->where(array('m.op_id' => $opid, 'c.op_id' => $opid, 'c.cost_type' => 4))->order('m.id')->select();
        foreach ($matelist as $k => $v) {
            //获取物资库存
            $stock = M('material')->where(array('material' => $v['material']))->find();
            $matelist[$k]['stock'] = $stock['stock'] ? $stock['stock'] : 0;
            $matelist[$k]['stages'] = $stock['stages'] ? $stock['stages'] : 0;
            $matelist[$k]['lastcost'] = $stock ? $stock['price'] : 0;
        }

        $this->matelist = $matelist;
        $this->kinds = M('project_kind')->getField('id,name', true);
        $this->display('revert_materials');
    }

    // @@@NODE-3###select_material###调度物资###
    public function select_material()
    {
        //物料关键字
        $key = M('material')->field('id,pinyin,material')->where(array('asset' => 0))->select();
        if ($key) $this->keywords = json_encode($key);
        $this->material = M('material')->select();
        $this->display('select_material');
    }

    public function public_checkname_ajax()
    {
        $group_id = I('gid', 0);

        //判断会员是否存在
        $db = M('op');
        if ($db->where(array('group_id' => $group_id))->find()) {
            exit('0');
        } else {
            exit('1');
        }
    }

    // @@@NODE-3###delpro###删除项目###
    public function delpro()
    {
        $this->title('删除项目');

        $id = I('id', -1);

        $op = M('op')->find($id);
        if ($op && (cookie('roleid') == 10 || cookie('roleid') == 1)) {
            $opid = $op['op_id'];
            //删除项目相关信息
            M('op_auth')->where(array('op_id' => $opid))->delete();
            M('op_budget')->where(array('op_id' => $opid))->delete();
            M('op_cost')->where(array('op_id' => $opid))->delete();
            M('op_costacc')->where(array('op_id' => $opid))->delete();
            M('op_costacc_res')->where(array('op_id' => $opid))->delete();
            M('op_guide')->where(array('op_id' => $opid))->delete();
            M('op_line_days')->where(array('op_id' => $opid))->delete();
            M('op_material')->where(array('op_id' => $opid))->delete();
            M('op_partake')->where(array('op_id' => $opid))->delete();
            M('op_pretium')->where(array('op_id' => $opid))->delete();
            M('op_record')->where(array('op_id' => $opid))->delete();
            M('op_settlement')->where(array('op_id' => $opid))->delete();
            M('op_supplier')->where(array('op_id' => $opid))->delete();
            M('order')->where(array('op_id' => $opid))->delete();
            M('guide_pay')->where(array('op_id' => $opid))->delete();
            M('op_guide_price')->where(array('op_id' => $opid))->delete();
            M('op_team_confirm')->where(array('op_id' => $opid))->delete();
            M('op_guide_confirm')->where(array('op_id' => $opid))->delete();
            M('op_res')->where(array('op_id' => $opid))->delete();        //资源需求单
            M('op_design')->where(array('op_id' => $opid))->delete();     //委托设计工作交接单
            M('op_work_plans')->where(array('op_id' => $opid))->delete(); //业务实施计划单
            M('worder')->where(array('op_id' => $opid))->delete();        //项目工单
            M('contract')->where(array('op_id' => $opid))->delete(); //合同
            M('contract_pay')->where(array('op_id' => $opid))->delete(); //回款计划
            M('op_huikuan')->where(array('op_id' => $opid))->delete(); //回款
            $score_user_ids = M('tcs_score_user')->where(array('op_id' => $opid))->getField('id', true);
            M('tcs_score')->where(array('uid' => array('in', $score_user_ids)))->delete(); //删除评分信息
            M('tcs_score_user')->where(array('op_id' => $opid))->delete();
            M('tcs_score_problem')->where(array('op_id' => $opid))->delete();

            $record = array();
            $record['op_id'] = $opid;
            $record['optype'] = 1;
            $record['explain'] = '删除项目';
            op_record($record);

            //删除主项目
            M('op')->delete($id);
            $this->success('删除成功！');
        } else {
            $this->error('删除失败！：' . $db->getError());
        }
    }

    //排课
    public function course()
    {
        $op_id = I('opid');
        $guide_id = I('id');

        //判断项目是否已结算
        $jiesuan = M('op_settlement')->where(array('op_id' => $op_id))->find();

        $this->op_id = $op_id;
        $this->guide_id = $guide_id;
        $this->jiesuan = $jiesuan['audit_status'] ? $jiesuan['audit_status'] : 0;
        $this->display('course');
    }

    //排课详情
    public function courselist()
    {

        $op_id = I('get.opid');
        $guide_id = I('get.id');

        $rows = M('op_course')->where(array('op_id' => $op_id, 'guide_id' => $guide_id))->select();
        $data = array();
        foreach ($rows as $k => $v) {
            $data[$k]['id'] = $v['id'];
            $data[$k]['task'] = $v['userid'];
            $data[$k]['builddate'] = $v['coures_date'];
        }
        echo json_encode($data);
    }

    //排课详情
    public function addcourse()
    {

        $op_id = I('op_id');
        $guide_id = I('guide_id');
        $date = I('date');

        $info = array();
        $info['op_id'] = $op_id;
        $info['guide_id'] = $guide_id;
        $info['coures_date'] = $date;
        $info['userid'] = cookie('userid');

        $add = M('op_course')->add($info);
        if ($add) {
            echo $add;
        } else {
            echo 0;
        }

    }

    //删除课程
    public function delcourse()
    {
        $id = I('id');
        $course = M('op_course')->find($id);
        //if($course && $course['userid'] == cookie('userid')){
        $del = M('op_course')->where(array('id' => $id))->delete();
        if ($del) {
            echo 1;
        } else {
            echo 0;
        }
        //}else{
        //	echo 0;
        //}
    }

    // @@@NODE-3###confirm###出团确认###
    public function confirm()
    {

        $id             = I('id'); //流程管理
        $opid           = I('opid') ? I('opid') : ($id ? M('op')->where(array('id' => $id))->getField('op_id') : '');
        if (!$opid) $this->error('项目不存在');

        $where          = array();
        $where['op_id'] = $opid;
        $op             = M('op')->where($where)->find();
        $confirm        = M('op_team_confirm')->where($where)->find();
        $upd_num        = $confirm['upd_num'];

        if (isset($_POST['dosubmit']) && $_POST['dosubmit']) {
            $info = I('info');
            $add_group = I('add_group', 0); //拼团
            $group = I('group');
            $resid = I('resid', '');
            $num = 0;

            if ($add_group == 1 && !$group) {
                $this->error('拼团信息填写有误');
            }

            //判断团号是否可用
            $where = array();
            $where['group_id'] = $info['group_id'];
            $where['op_id'] = array('neq', $opid);
            $check = M('op')->where($where)->find();
            if ($check) $this->error($info['group_id'] . '团号已存在');

            $info['op_id'] = $opid;
            $info['group_id'] = trim($info['group_id']);
            $info['user_id'] = cookie('userid');
            $info['user_name'] = cookie('nickname');
            $info['dep_time'] = $info['dep_time'] ? strtotime($info['dep_time']) : 0;
            $info['ret_time'] = $info['ret_time'] ? strtotime($info['ret_time']) : 0;
            $info['contract_sign_time'] = $info['contract_sign_time'] ? strtotime($info['contract_sign_time']) : 0;
            $info['contract_back_time'] = $info['contract_back_time'] ? strtotime($info['contract_back_time']) : 0;
            $info['back_money_time'] = $info['back_money_time'] ? strtotime($info['back_money_time']) : 0;
            $info['jiaowei_remark'] = trim($info['jiaowei_remark']);

            if (!$info['group_id']) $this->error('团号填写有误');
            if (!$info['dep_time'] || $info['dep_time'] == 0) $this->error('出团时间填写有误');
            if (!$info['ret_time'] || $info['ret_time'] == 0) $this->error('返回时间填写有误');
            if (!is_numeric($info['days']) || $info['days'] == 0) $this->error('实际天数填写有误');
            if (!is_numeric($info['num_adult'])) $this->error('出团成人人数格式错误');
            if (!is_numeric($info['num_children'])) $this->error('出团儿童人数格式错误');

            $op_info = array();
            $op_info['type'] = 1; //已成团
            $op_info['add_group'] = $add_group; //拼团
            $op_res = M('op')->where(array('op_id' => $opid))->save($op_info);
            if ($op_res) $num++;
            //判断是否已经确认
            if ($confirm) {
                if ($upd_num == 1) {
                    if (in_array(cookie('userid'), array(1, 11))) {
                        $res = M('op_team_confirm')->data($info)->where(array('op_id' => $opid))->save();
                        if ($res) $num++;
                    } else {
                        $this->error('您已经修改过一次了,不能反复修改!');
                    }
                } else {
                    $info['upd_num'] = 1;    //用来判断修改次数
                    $res = M('op_team_confirm')->data($info)->where(array('op_id' => $opid))->save();
                    if ($res) $num++;
                }
            } else {
                $info['confirm_time'] = time();
                $res = M('op_team_confirm')->add($info);
                if ($res) $num++;

                //成团确认后可以共享给线控负责人(提醒),业务部门经理和接待实施部门经理(未读)，并设置时间节点的考核；(流程->待办事宜)
                $returnMsgDepartmentIds = array_unique(array($op['create_user_department_id'], $op['dijie_department_id']));
                $uids = M('salary_department')->where(array('id' => array('in', $returnMsgDepartmentIds)))->getField('manager_id', true);
                $process_node = 49; //填写成团信息
                $title = $op['project'];
                $req_id = $op['id'];
                $pro_status = 1; //未读

                foreach ($uids as $v) { //发送给业务部门经理和接待实施部门经理
                    $to_uid = $v;
                    $to_uname = username($v);
                    save_process_log($process_node, $pro_status, $title, $req_id, '', $to_uid, $to_uname);
                }

                //发送给线控部门负责人
                $process_node = 50; //提前安排采购事项
                $to_uid = $op['line_blame_uid'];
                $to_uname = $op['line_blame_name'];
                save_process_log($process_node, $pro_status, $title, $req_id, '', $to_uid, $to_uname);

                //发送给计调
                $process_node = 54; //编制项目预算
                $op_auth_list = M('op_auth')->where(array('op_id' => $opid))->find();
                $to_uid = $op_auth_list['yusuan'] ? $op_auth_list['yusuan'] : $op_auth_list['hesuan'];
                $to_uname = username($to_uid);
                $pro_status = 2; //事前提醒
                save_process_log($process_node, $pro_status, $title, $req_id, '', $to_uid, $to_uname);
            }

            if ($num) {
                $project = M('op_project')->where(array('op_id' => $opid))->find();
                if ($info['is_need_project'] == 1 && !$project) {
                    //需要业务实施方案需求(发送待办事宜给线控)
                    $title = $op['project'];
                    $req_id = $op['id'];
                    $process_node = 51; //编制业务实施方案
                    $pro_status = 2; //事前提醒
                    $to_uid = $op['line_blame_uid'];
                    $to_uname = $op['line_blame_name'];
                    save_process_log($process_node, $pro_status, $title, $req_id, '', $to_uid, $to_uname);
                }

                $this->save_add_group($opid, $resid, $group); //保存拼团信息
                //如果是内部地接, 生成一个新地接团
                /*if ($op['in_dijie'] == 1 && !$op['dijie_opid'] && $op['kind'] != 87) { //87=>单进院所不生成地接团
                    $mod                = D('Op');
                    $new_op_id          = $mod -> create_dejie_op($opid , $info ,$op);
                }*/

                $infos = array();
                //$infos['dijie_opid']    = $new_op_id ? $new_op_id : '';
                $infos['group_id'] = $info['group_id'];
                $infos['status'] = 1;
                M('op')->data($infos)->where(array('op_id' => $opid))->save();

                $record = array();
                $record['op_id'] = $opid;
                $record['optype'] = 4;
                $record['explain'] = '成团确认';
                op_record($record);
                $this->success('保存成功！');
            } else {
                $this->error('保存信息失败');
            }
        } else {

            $this->op       = $op;
            $this->kinds    = M('project_kind')->getField('id,name', true);
            $this->fields   = C('GUI_FIELDS');
            $jiesuan        = M('op_settlement')->where(array('op_id' => $opid, 'audit_status' => 1))->find(); //结算审批通过
            $this->jiesuan  = $jiesuan;
            $resource       = M('op_res')->where(array('op_id' => $opid))->find();
            $this->resource = $resource; //资源需求单
            if ($resource) {
                $this->rad = 1;
                $this->task_fields = explode(',', $resource['task_field']);
                $this->act_needs = explode(',', $resource['act_need']);
                $this->men = M('account')->field('id,nickname')->where(array('id' => $resource['exe_user_id']))->find();
            }

            //辅导员/教师、专家
            $this->guide_price = M()->table('__OP_GUIDE_CONFIRM__ as c')->field('c.id as cid,c.*,p.id as pid,p.*')->join('left join __OP_GUIDE_PRICE__ as p on p.confirm_id = c.id')->where(array('c.op_id' => $opid, 'p.op_id' => $opid))->select();

            //项目跟进时提出的需求信息
            $this->guide_need = M('op_guide_price')->where(array('op_id' => $opid))->select();

            //人员名单关键字
            $this->userkey = get_username();
            //科普资源关键字
            $this->scienceRes = getScienceRes();
            $this->province = get_pid_citys(0);

            //人员列表
            $stu_list = M('op_member')->where(array('op_id' => $opid))->select();
            $this->stu_list = $stu_list;
            $this->confirm = $confirm;
            $this->upd_num = $confirm['upd_num'];
            $this->op_kind = $op['kind'];
            $this->act_need = C('ACT_NEED');
            $this->task_field = C('LES_FIELD');
            $this->apply_to = C('APPLY_TO');
            $this->design = M('op_design')->where(array('op_id' => $opid))->find();    //委托设计工作交接单
            $work_plan = M('op_work_plans')->where(array('op_id' => $opid))->find();//业务实施计划单
            $this->work_plan = $work_plan;
            $this->additive = explode(',', $work_plan['additive']);
            $this->plan_between_time = $work_plan['begin_time'] ? date('Y-m-d', $work_plan['begin_time']) . ' - ' . date('Y-m-d', $work_plan['end_time']) : '';
            $this->plan_lists = M('op_work_plan_lists')->where(array('plan_id' => $work_plan['id']))->select();

            $this->user_info = M()->table('__OP__ as o')
                ->field('a.*,d.department,d.groupno,o.create_user_name')
                ->join('__ACCOUNT__ as a on a.id = o.create_user')
                ->join('__SALARY_DEPARTMENT__ as d on d.id = a.departmentid')
                ->where(array('o.op_id' => $opid))
                ->find();
            $this->output_info = array(
                '1' => '出片打样',
                '2' => '喷绘',
                '3' => '只提供电子文件'
            );
            $this->audit_status = array(
                P::AUDIT_STATUS_NOT_AUDIT => '<span class="yellow">未审核</span>',
                P::AUDIT_STATUS_PASS => '<span class="green">审核通过</span>',
                P::AUDIT_STATUS_NOT_PASS => '<span class="red">未通过</span>',
            );
            $this->additive = explode(',', $work_plan['additive']);
            $additive_con = array(
                '1' => '行程或方案',
                '2' => '需解决大交通的《人员信息表》',
                '3' => '其他'
            );
            $this->additive_con = $additive_con;
            $this->businessDep = C('DIJIE_NAME');
            $this->groups = M('op_group')->where(array('op_id' => $opid))->select();
            $this->provinces = M('provinces')->getField('id,name', true);
            $this->departments = M('salary_department')->getField('id,department', true);
            $this->cneed_edit = M('op_customer_need_edit')->where(array('op_id' => $opid))->find(); //客户需求变更

            ///客户需求详情
            $customer_need_db = get_customer_need_tetail_db($op['kind']);
            $customer_need_list = $customer_need_db ? $customer_need_db->where(array('op_id' => $op['op_id']))->find() : '';
            $detail_db = get_product_pro_need_tetail_db($op['kind']);
            $detail_list = $detail_db ? $detail_db->where(array('op_id' => $op['op_id']))->find() : '';
            $budget_list = M('op_budget')->where(array('op_id' => $opid, 'audit_status' => 1))->find(); //审核通过的预算信息
            $this->budget_list = $budget_list;
            $this->need = $customer_need_list;
            $this->detail = $detail_list;
            $apply_to = C('APPLY_TO');
            $op['apply_to'] = $apply_to[$op['apply_to']];
            $kinds = M('project_kind')->getField('id,name', true);
            $this->list = $op;
            $this->audit_status = get_submit_audit_status();
            $this->kinds = $kinds;
            $this->teacher_level = C('TEACHER_LEVEL'); //教师级别
            $this->expert_level = C('EXPERT_LEVEL'); //专家级别
            $this->producted_list = $op['producted_id'] ? M('producted')->find($op['producted_id']) : ''; //标准化产品
            //产品实施方案
            $project_list = M('op_project')->where(array('op_id' => $opid))->find();
            $atta_ids = $project_list ? explode(',', $project_list['atta_ids']) : '';
            $file_lists = $atta_ids ? M('attachment')->where(array('id' => array('in', $atta_ids)))->select() : '';
            $this->project_list = $project_list;
            $this->atta_lists = $file_lists;

            $this->display('confirm');
        }
    }

    //保存拼团信息
    private function save_add_group($opid, $resid = '', $arr = '')
    {
        $db = M('op_group');
        $delids = array();
        foreach ($arr as $v) {
            if (in_array($v['id'], $resid)) {
                $res = $db->where(array('id' => $v['id']))->save($v);
                $delids[] = $v['id'];
            } else {
                $v['op_id'] = $opid;
                $res = $db->add($v);
                $delids[] = $res;
            }
        }

        if ($delids) {
            $res = $db->where(array('id' => array('not in', $delids), 'op_id' => $opid))->delete();
        } else {
            $res = $db->where(array('op_id' => $opid))->delete();
        }
    }

    // @@@NODE-3###change_op###项目交接###
    public function change_op()
    {
        if (isset($_POST['dosubmit'])) {
            $op_id = I('opid');
            $info = I('info');
            if ($info['create_user']) {
                $info['sale_user'] = $info['create_user_name'];
                $info['op_create_user'] = M()->table('__ACCOUNT__ as a')->join('__ROLE__ as r on r.id = a.roleid', 'left')->where(array('a.id' => $info['create_user']))->getField('r.role_name');
                $res = M('op')->where(array('op_id' => $op_id))->save($info);
                if ($res) {
                    $data = array();
                    $data['hesuan'] = $info['create_user'];
                    $auth = M('op_auth')->where(array('op_id' => $op_id))->find();

                    if ($auth) {
                        M('op_auth')->data($data)->where(array('id' => $auth['id']))->save();
                    } else {
                        $data['op_id'] = $op_id;
                        M('op_auth')->add($data);
                    }

                    $record = array();
                    $record['op_id'] = $op_id;
                    $record['optype'] = 4;
                    $record['explain'] = '项目交接给' . $info['create_user_name'] . '';
                    op_record($record);

                    $this->msg = '操作成功!';
                } else {
                    $this->msg = '操作失败!';
                }
            } else {
                $this->msg = '人员信息错误!';
            }
            $this->display('Index:public_audit');
        } else {
            //人员名单关键字
            $user = M('account')->field("id,nickname")->where(array('status' => 0))->select();
            $user_key = array();
            foreach ($user as $k => $v) {
                $text = $v['nickname'];
                $user_key[$k]['id'] = $v['id'];
                $user_key[$k]['pinyin'] = strtopinyin($text);
                $user_key[$k]['text'] = $text;
            }
            $this->userkey = json_encode($user_key);

            $this->opid = I('opid');
            $this->display();
        }
    }

    // @@@NODE-3###res_feedback###资源配置情况反馈###
    public function res_feedback()
    {
        $op_id = I('opid');
        $op = M('op')->where(array('op_id' => $op_id))->find();
        $this->op = $op;
        $resource = M('op_res')->where(array('op_id' => $op_id))->find();
        $this->op_kind = $op['kind'];
        $this->resource = $resource;
        $this->act_need = C('ACT_NEED');
        $this->task_field = C('LES_FIELD');
        if ($resource) {
            $this->rad = 1;
            $this->task_fields = explode(',', $resource['task_field']);
            $this->act_needs = explode(',', $resource['act_need']);
            $this->men = M('account')->field('id,nickname')->where(array('id' => $resource['exe_user_id']))->find();
        }

        //人员名单关键字
        $this->userkey = get_username();
        $this->audit_status = array(
            P::AUDIT_STATUS_NOT_AUDIT => '<span class="yellow">未审核</span>',
            P::AUDIT_STATUS_PASS => '<span class="green">审核通过</span>',
            P::AUDIT_STATUS_NOT_PASS => '<span class="red">未通过</span>',
        );

        $this->display();
    }

    // @@@NODE-3###relpricelist###项目比价记录###
    public function relpricelist()
    {
        $this->title('项目比价记录');

        $db = M('rel_price');
        $kinds = C('REL_TYPE');

        $title = I('title');        //项目名称
        $opid = I('opid');            //项目编号
        $op = I('op');            //计调
        $type = I('type');

        $where = array();

        if ($title) $where['business_name'] = array('like', '%' . $title . '%');
        if ($op) $where['op_user_name'] = array('like', '%' . $op . '%');
        if ($opid) $where['op_id'] = $opid;
        if ($type) $where['type'] = $type;

        //分页
        $pagecount = $db->where($where)->count();
        $page = new Page($pagecount, P::PAGE_SIZE);
        $this->pages = $pagecount > P::PAGE_SIZE ? $page->show() : '';


        $lists = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('create_time'))->select();
        foreach ($lists as $k => $v) {
            $lists[$k]['kinds'] = $kinds[$v['type']];
            $lists[$k]['create_time'] = date('Y-m-d H:i:s', $v['create_time']);
        }


        $this->lists = $lists;
        $this->kinds = C('REL_TYPE');
        $this->opid = $opid;
        $this->type = $type;
        $this->display('relpricelist');
    }

    // @@@NODE-3###confirm###项目比价###
    public function relprice()
    {
        $opid = I('opid');
        $relid = I('relid');
        $type = I('type');
        $op = M('op')->where(array('op_id' => $opid))->find();

        if (isset($_POST['dosubmint']) && $_POST['dosubmint']) {

            $info = I('info');
            $com = I('com');
            $reid = I('reid');

            $info['op_user_id'] = cookie('userid');
            $info['op_user_name'] = cookie('name');

            //保存主表
            if ($reid) {
                M('rel_price')->where(array('id' => $reid))->data($info)->save();
            } else {
                $info['create_time'] = time();
                $reid = M('rel_price')->add($info);
            }


            $coms = array();
            $list = array();

            foreach ($com as $k => $v) {
                //保存比价单位
                $cominfo = array();
                $cominfo['rel_id'] = $reid;
                $cominfo['op_id'] = $info['op_id'];
                $cominfo['company'] = $v['company'];
                $cominfo['contacts'] = $v['contacts'];
                $cominfo['contacts_tel'] = $v['contacts_tel'];
                $cominfo['contacts_email'] = $v['contacts_email'];
                $cominfo['checkout'] = 0;//isqual($v['company']);
                if ($v['comid']) {
                    M('rel_price_com')->where(array('id' => $v['comid']))->data($cominfo)->save();
                    $comid = $v['comid'];
                    $coms[] = $v['comid'];
                } else {
                    $comid = M('rel_price_com')->add($cominfo);
                    $coms[] = $comid;
                }

                //保存比价项目
                foreach ($v['info'] as $kk => $vv) {
                    $termlist = array();
                    $termlist['op_id'] = $info['op_id'];
                    $termlist['rel_id'] = $reid;
                    $termlist['rel_com_id'] = $comid;
                    $termlist['term'] = $vv['term'];
                    $termlist['term_standard'] = $vv['term_standard'];
                    $termlist['price'] = $vv['price'];
                    if ($vv['id']) {
                        M('rel_price_list')->where(array('id' => $vv['id']))->data($termlist)->save();
                        $list[] = $vv['id'];
                    } else {
                        $list[] = M('rel_price_list')->add($termlist);
                    }

                }

            }

            //清除已删除单位和项目
            $where = array();
            $where['rel_id'] = $reid;
            $where['id'] = array('not in', implode(',', $coms));
            M('rel_price_com')->where($where)->delete();

            $where = array();
            $where['rel_id'] = $reid;
            $where['id'] = array('not in', implode(',', $list));
            M('rel_price_list')->where($where)->delete();

            $this->success('保存成功！', I('referer', ''));

        } else {

            if ($relid) {
                $rel = M('rel_price')->find($relid);
                $com = M('rel_price_com')->where(array('rel_id' => $relid))->select();
                foreach ($com as $k => $v) {
                    $com[$k]['info'] = M('rel_price_list')->where(array('rel_id' => $relid, 'rel_com_id' => $v['id']))->select();
                }
            }

            $this->kinds = C('REL_TYPE');
            $this->b_name = $rel['business_name'] ? $rel['business_name'] : $op['project'];
            $this->op_id = $rel['op_id'] ? $rel['op_id'] : $opid;
            $this->vtype = $rel['type'] ? $rel['type'] : $type;
            $this->op = $op;
            $this->rel = $rel;
            $this->com = $com;
            $this->display('relprice');
        }
    }

    // @@@NODE-3###delrel###删除项目比价###
    public function delrel()
    {

        $relid = I('relid');
        M('rel_price')->where(array('id' => $relid))->delete();
        M('rel_price_com')->where(array('rel_id' => $relid))->delete();
        M('rel_price_list')->where(array('rel_id' => $relid))->delete();

        $this->success('删除成功！');

    }

    // @@@NODE-3###evaluate###项目评价###
    public function evaluate()
    {
        $opid = I('opid');
        $op = M('op')->where(array('op_id' => $opid))->find();

        $op_guide_list = M('op_guide_confirm')->where(array('op_id' => $opid, 'first_dispatch_oa_uid' => array('neq', 0)))->find();
        $jd_score = get_op_score_data($opid, 1);
        $jw_score = get_op_score_data($opid, 2);
        $cp_score = get_op_score_data($opid, 3);
        $zy_score = get_op_score_data($opid, 4);
        $jd_id = $jd_score['account_id'] ? $jd_score['account_id'] : M('op_auth')->where(array('op_id' => $opid))->getField('yusuan');
        $jw_id = $jw_score['account_id'] ? $jw_score['account_id'] : ($op_guide_list['first_dispatch_oa_uid'] ? $op_guide_list['first_dispatch_oa_uid'] : $op_guide_list['heshi_oa_uid']);
        $cp_id = $cp_score['account_id'] ? $cp_score['account_id'] : 232; //232=>梅轶宁
        $zy_id = $zy_score['account_id'] ? $zy_score['account_id'] : 82; //82=>吕严
        $jd = array();
        $jd['user_id'] = $jd_id;
        $jd['user_name'] = username($jd_id);
        $jw = array();
        $jw['user_id'] = $jw_id;
        $jw['user_name'] = username($jw_id);
        $cp = array();
        $cp['user_id'] = $cp_id;
        $cp['user_name'] = username($cp_id);
        $zy = array();
        $zy['user_id'] = $zy_id;
        $zy['user_name'] = username($zy_id);
        $company_res_citys = get_company_res_citys(); //需要公司资源管理部安排资源的省份信息
        $company_res_cityids = array_keys($company_res_citys); //需要公司资源管理部安排资源的省份信息
        $op_res = M('op_res')->where(array('op_id' => $opid, 'province' => array('in', $company_res_cityids)))->find();

        if ($op_res) {
            $this->res_need = $op_res;
        }
        $this->jd_score = $jd_score ? json_encode($jd_score) : '';
        $this->jw_score = $jw_score ? json_encode($jw_score) : '';
        $this->cp_score = $cp_score ? json_encode($cp_score) : '';
        $this->zy_score = $zy_score ? json_encode($zy_score) : '';
        $this->jidiao = $jd;
        $this->jiaowu = $jw;
        $this->chanpin = $cp;
        $this->ziyuan = $zy;
        $this->op = $op;
        $this->display();
    }

    //修改辅导员需求信息
    public function edit_tcs_need()
    {
        $confirm_id = I('confirm_id');
        $price_id = I('price_id');

        $opid = I('opid');
        $this->opid = $opid;
        $this->guide_kind = M('guidekind')->getField('id,name', true);
        //获取职能类型
        $priceKind = M()->table('__GUIDE_PRICEKIND__ as gpk')->field('gpk.id,gpk.name')->join('left join __OP__ as op on gpk.pk_id = op.kind')->where(array("op.op_id" => $opid))->select();
        $this->price_kind = $priceKind;
        $this->fields = C('GUI_FIELDS');
        $this->display();
    }

    //销售人员系数配置
    public function saleConfig()
    {
        $year = I('year', date('Y'));
        $yearTime = array();

        $department_ids = C('YW_DEPARTS');
        $departments = M('salary_department')->field('id,department')->where(array('id' => array('in', $department_ids)))->select();
        $sale_configs = M('sale_config')->where(array('year' => $year))->select();
        foreach ($departments as $k => $v) {
            foreach ($sale_configs as $key => $value) {
                if ($value['department_id'] == $v['id']) {
                    $departments[$k]['January'] = $value['January'];
                    $departments[$k]['February'] = $value['February'];
                    $departments[$k]['March'] = $value['March'];
                    $departments[$k]['April'] = $value['April'];
                    $departments[$k]['May'] = $value['May'];
                    $departments[$k]['June'] = $value['June'];
                    $departments[$k]['July'] = $value['July'];
                    $departments[$k]['August'] = $value['August'];
                    $departments[$k]['September'] = $value['September'];
                    $departments[$k]['October'] = $value['October'];
                    $departments[$k]['November'] = $value['November'];
                    $departments[$k]['December'] = $value['December'];
                }
            }
        }

        $this->year = $year;
        $this->prveyear = $year - 1;
        $this->nextyear = $year + 1;
        $this->departments = $departments;
        $this->display();
    }

    //配置销售人员系数
    public function sale_config_edit()
    {
        $db = M('sale_config');
        if (isset($_POST['dosubmint'])) {
            $info = I('info');
            $info['year'] = trim(I('year'));
            $info['department_id'] = trim(I('department_id'));
            $data = $db->where(array('department_id' => $info['department_id'], 'year' => $info['year']))->find();
            if ($data) {
                $res = $db->where(array('id' => $data['id']))->save($info);
            } else {
                $res = $db->add($info);
            }
            echo "<script>window.top.location.reload();</script>";
        } else {
            $id = trim(I('id'));
            $year = trim(I('year'));
            if ($id && $year) {
                $where = array();
                $where['year'] = $year;
                $where['department_id'] = $id;
                $department = M('salary_department')->field('id,department')->where(array('id' => $id))->find();
                $list = $db->where($where)->find();
                $this->year = $year;
                $this->list = $list;
                $this->department = $department;
                $this->display();
            } else {
                $this->error('获取信息失败');
            }
        }
    }

    private function has_research_and_development()
    {
        $user_id = session('userid');
        $has_rd_departments = array('6');       //有自己研发的部门 6=>京区业务中心
        $userinfo = M('account')->where(array('id' => $user_id))->find();
        if (in_array($userinfo['departmentid'], $has_rd_departments)) {
            $has_rd = 1;
        } else {
            $has_rd = 0;
        }
        return $has_rd;
    }

    //获取满意度二维码
    public function qrcode()
    {
        $opid = I('opid');
        $this->title = M('op')->where(array('op_id' => $opid))->getField('project');
        $qrcode_url = get_qrcode_url($opid);
        $this->url_info = $qrcode_url;

        $this->display();
    }

    //导出excel表
    public function export_op()
    {
        $startTime = strtotime(I('st'));
        $endTime = strtotime(I('et'));
        $kind = I('kind');
        $project_kinds = M('project_kind')->getField('id,name', true);

        $where = array();
        $where['l.audit_time'] = array('between', array($startTime, $endTime));
        $where['l.dst_status'] = 1;
        if ($kind) $where['o.kind'] = $kind;
        $field = 'o.project,o.op_id,o.group_id,o.create_user_name,b.budget,b.shouru,b.maoli,b.maolilv,s.budget,s.shouru,s.maoli,s.maolilv,s.audit_status';
        $lists = M()->table('__AUDIT_LOG__ as l')->join('__OP_BUDGET__ as b on b.id=l.req_id', 'left')->join('__OP__ as o on o.op_id=b.op_id', 'left')->join('__OP_SETTLEMENT__ as s on s.op_id=b.op_id', 'left')->where($where)->field($field)->select();
        foreach ($lists as $k => $v) {
            if ($v['audit_status'] == 1) {
                $lists[$k]['audit_status'] = '审核通过';
            }
            if ($v['audit_status'] == 2) {
                $lists[$k]['audit_status'] = '审核未通过';
            }
            if ($v['audit_status'] == 0) {
                $lists[$k]['audit_status'] = '未提交审核';
            }
        }

        $title = array('项目名称', '项目编号', '团号', '销售', '项目预算', '预算收入', '预算毛利', '预算毛利率', '项目结算', '结算收入', '结算毛利', '结算毛利率', '结算审核状态');
        exportexcel($lists, $title, date('Y-m-d', $startTime) . '至' . date('Y-m-d', $endTime) . $project_kinds[$kind] . '已审批预算项目');
    }

    //结算费用项
    public function op_cost_type()
    {
        $this->title('结算费用项');
        $db = M('op_cost_type');
        //分页
        $pagecount = $db->count();
        $page = new Page($pagecount, P::PAGE_SIZE);
        $this->pages = $pagecount > P::PAGE_SIZE ? $page->show() : '';

        $lists = $db->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('id'))->select();
        $this->lists = $lists;
        $this->display('cost_type');
    }

    //编辑费用结算项
    public function edit_cost_type()
    {
        $db = M('op_cost_type');
        if (isset($_POST['dosubmint'])) {
            $id = I('id');
            $data = array();
            $data['name'] = trim(I('name')) ? trim(I('name')) : $this->error('结算项不能为空');
            $res = $id ? $db->where(array('id' => $id))->save($data) : $db->add($data);
        } else {
            $id = I('id');
            $list = $id ? $db->find($id) : '';
            $this->row = $list;
            $this->display();
        }
    }

    //删除费用结算项
    public function del_cost_type()
    {
        $id = I('id');
        $db = M('op_cost_type');
        $res = $db->where(array('id' => $id))->delete();
        $del = $res ? $this->success('删除数据成功') : $this->error('删除失败');
    }

    //业务实施方案
    public function public_project()
    {
        $this->title('业务实施方案');
        $db = M('op_project');
        if (isset($_POST['dosubmint'])) {
            $opid = I('opid');
            $list = M('op')->where(array('op_id' => $opid))->find();
            $remark = trim(I('remark'));
            $newname = I('newname');
            $resfiles = I('resfiles');
            save_new_file_name($newname);
            $id = I('id');
            if (!$opid) $this->error('获取项目信息错误');
            $data = array();
            $data['op_id'] = $opid;
            $data['remark'] = $remark;
            $data['atta_ids'] = $resfiles ? implode(',', $resfiles) : '';
            $data['input_user_name'] = cookie('nickname');
            $data['input_user_id'] = cookie('userid');
            $data['input_time'] = NOW_TIME;
            $data['audit_uid'] = $list['create_user']; //业务人员审核
            $data['audit_uname'] = $list['create_user_name'];

            if ($id) {
                $res = $db->where(array('id' => $id))->save($data);
                $explain = '编辑业务实施方案';
            } else {
                $res = $db->add($data);
                $explain = '新增业务实施方案';
            }
            if ($res) {
                $record = array();
                $record['op_id'] = $opid;
                $record['optype'] = 4;
                $record['explain'] = $explain;
                op_record($record);

                $this->success('保存成功', U('Op/public_project', array('opid' => $opid)));
            } else {
                $this->error('保存失败', U('Op/public_project', array('opid' => $opid)));
            }
        } else {
            $id = I('id'); //待办事宜
            $opid = $id ? M('op')->where(array('id' => $id))->getField('op_id') : I('opid');
            if (!$opid) $this->error('获取数据失败');
            $fa = I('fa', 1);
            $list = M('op')->where(array('op_id' => $opid))->find();
            $project_list = M('op_project')->where(array('op_id' => $opid))->find();
            $atta_ids = $project_list ? explode(',', $project_list['atta_ids']) : '';
            $file_lists = $atta_ids ? M('attachment')->where(array('id' => array('in', $atta_ids)))->select() : '';

            $apply_to = C('APPLY_TO');
            $list['apply_to'] = $apply_to[$list['apply_to']];
            $departments = M('salary_department')->getField('id,department', true);
            $kinds = M('project_kind')->getField('id,name', true);

            $this->provinces = M('provinces')->getField('id,name', true);
            $this->kinds = $kinds;
            $this->departments = $departments;
            $this->list = $list;
            $this->project_list = $project_list;
            $this->atta_lists = $file_lists;
            $this->jiesuan = M('op_settlement')->where(array('op_id' => $opid, 'audit_status' => 1))->find(); //结算审批通过
            $this->audit_status = get_submit_audit_status();
            $this->opid = $opid;
            $this->fa = $fa;
            $this->display('project');
        }
    }

    //线控 项目交接
    public function handover()
    {
        $this->title('项目实施前的培训及交接');
        $handover_db = M('op_handover');
        $day_db = M('op_handover_day');
        if (isset($_POST['dosubmint'])) {
            $num = 0;
            $opid = I('opid');
            $id = I('id');
            $data = I('data');
            $info = I('info');
            $data['op_id'] = $opid;
            if ($id) {
                $res = $handover_db->where(array('id' => $id))->save($data);
            } else {
                $res = $handover_db->add($data);
            }
            if ($res) $num++;

            $del_res = $day_db->where(array('op_id' => $opid))->delete();
            foreach ($info as $k => $v) {
                $arr = array();
                $arr['op_id'] = $opid;
                $arr['day'] = strtotime($v['day']);
                $arr['st_time'] = strtotime(substr($v['in_time'], 0, 8));
                $arr['et_time'] = strtotime(substr($v['in_time'], -8));
                $arr['addr'] = trim($v['addr']);
                $arr['plan'] = trim($v['plan']);
                $arr['material'] = trim($v['material']);
                $arr['blame'] = trim($v['blame']);
                $arr['note'] = trim($v['note']);
                $arr['remark'] = trim($v['remark']);
                $res = $day_db->add($arr);
                if ($res) $num++;
            }

            if ($num > 0) {
                $this->success('数据保存成功');
            } else {
                $this->error('数据保存失败');
            }


        } else {
            $id                     = I('id'); //待办事宜
            $opid                   = I('opid') ? I('opid') : M('op')->where(array('id' => $id))->getField('op_id');
            if (!$opid) $this->error('获取数据失败');
            $fa                     = I('fa', 1);
            $list                   = M('op')->where(array('op_id' => $opid))->find();
            $handover_list          = M('op_handover')->where(array('op_id' => $opid))->find();

            $apply_to               = C('APPLY_TO');
            $list['apply_to']       = $apply_to[$list['apply_to']];
            $departments            = M('salary_department')->getField('id,department', true);
            $kinds                  = M('project_kind')->getField('id,name', true);

            $this->days             = $day_db->where(array('op_id' => $opid))->select();
            $this->provinces        = M('provinces')->getField('id,name', true);
            $this->kinds            = $kinds;
            $this->departments      = $departments;
            $this->list             = $list;
            $this->handover_list    = $handover_list;
            $this->jiesuan          = M('op_settlement')->where(array('op_id' => $opid, 'audit_status' => 1))->find(); //结算审批通过
            $this->confirm          = M('op_team_confirm')->where(array('op_id' => $opid))->find();
            $this->audit_status     = get_submit_audit_status();
            $this->opid             = $opid;
            $this->fa               = $fa;
            $this->handover_types   = C('handover');

            $this->opid             = $opid;
            $this->display('handover');
        }
    }

    //保存是否交回
    public function public_save_handover(){
        if (isset($_POST['dosubmint'])){
            $opid               = I('opid');
            $id                 = I('id');
            $data               = I('data');
            $db                 = M('op_handover');
            if (!$id){
                $data['op_id']  = $opid;
                $res            = $db->add($data);
            }else{
                $res            = $db->where(array('id'=>$id))->save($data);
            }
            if ($res){
                $this->success('数据保存成功');
            }else{
                $this->error('数据保存失败');
            }
        }
    }

    //评价
    public function public_eval(){
        $this->title('项目评价');
        $id                     = I('id'); //待办事宜
        $opid                   = I('opid') ? I('opid') : M('op')->where(array('id' => $id))->getField('op_id');
        if (!$opid) $this->error('获取数据失败');
        $fa                     = I('fa', 1);
        $list                   = M('op')->where(array('op_id' => $opid))->find();
        $eval_lists             = M('op_evaluate')->where(array('op_id'=>$opid))->select();

        $apply_to               = C('APPLY_TO');
        $list['apply_to']       = $apply_to[$list['apply_to']];
        $departments            = M('salary_department')->getField('id,department', true);
        $kinds                  = M('project_kind')->getField('id,name', true);

        $this->provinces        = M('provinces')->getField('id,name', true);
        $this->kinds            = $kinds;
        $this->departments      = $departments;
        $this->list             = $list;
        $this->eval_lists       = $eval_lists;
        $this->jiesuan          = M('op_settlement')->where(array('op_id' => $opid, 'audit_status' => 1))->find(); //结算审批通过
        $this->audit_status     = get_submit_audit_status();
        $this->summary_list     = M('op_summary')->where(array('op_id'=>$opid))->find(); //项目总结

        $this->opid             = $opid;
        $this->fa               = $fa;
        $this->display('eval');
    }

    //获取相关二维码
    public function public_qrcode(){
        $opid                       = I('opid','');

        $server_name                = $_SERVER['SERVER_NAME'];
        //$this->url                  = "http://".$server_name.U('Op/public_op_eval',array('opid'=>$opid));
        $this->url                  = "http://".$server_name.U('Op/public_eval_score',array('opid'=>$opid));
        $this->title                = M('op')->where(array('op_id'=>$opid))->getField('project');
        $this->display('op_qrcode');
    }

    public function public_eval_score(){
        if (isset($_POST['dosubmint'])){
            $id                     = I('id');
            $token                  = I('token');
            $num                    = 0;
            if ($token == session('token')){
                $db                 = M('op_evaluate');
                $problem            = trim(I('problem'));
                $content            = trim(I('content'));
                $data               = array();
                $data['problem']    = $problem;
                $data['content']    = $content;
                $data['score_stu']  = 1; //已评价
                $data['score_time'] = NOW_TIME;
                $res                = $db->where(array('id'=>$id))->save($data);
                if ($res){
                    $num++;
                    $msg            = '保存成功';
                    session(null);
                }
            }else{
                $msg                = '保存失败';
            }
            $returnMsg              = array();
            $returnMsg['num']       = $num;
            $returnMsg['msg']       = $msg;
            $this->ajaxReturn($returnMsg);
        }else{
            $opid                   = I('opid');
            $list                   = M('op')->where(array('op_id'=>$opid))->find();
            $this->list             = $list;
            $this->token            = make_token();
            $this->mobile           = session('scoreMobile');
            $this->id               = session('reg_id');
            $this->display('eval_score');
        }
    }

    public function public_eval_login(){
        $db                             = M('op_evaluate');
        if (isset($_POST['dosubmit'])) {
            $mobile                     = trim(I('mobile'));
            $mobile_code                = I('mobile_code');
            $opid                       = I('opid','');

            //验证手机验证码
            if ($mobile_code != session('code')) {
                die(return_msg('n','您输入的手机验证码有误,请重新输入'));
            }else{
                if (!$mobile) { die(return_msg('n','手机号码错误')); }
                $register_record        = $db->where(array('op_id'=>$opid,'mobile'=>$mobile,'score_stu'=>0))->find();
                if ($register_record){
                    $register_id        = $register_record['id'];
                    $info               = array();
                    $info['reg_time']   = NOW_TIME;
                    $db->where(array('id'=>$register_id))->save($info);
                }else{
                    $info               = array();
                    $info['mobile']     = $mobile;
                    $info['reg_time']   = NOW_TIME;
                    $info['op_id']      = $opid;
                    $res                = $db->add($info);
                    $register_id        = $res;
                }

                if ($register_id) {
                    session('scoreMobile',$mobile);
                    session('reg_id',$register_id);
                    die(return_msg('y','登录成功'));
                    //die(return_msg('y', "登录成功<script type='text/javascript'> setTimeout('location=\"$referer\"',1000);</script>"));
                }else{
                    die(return_msg('n','登录失败'));
                }
            }
        }else{
            $opid                   = I('opid');
            $this->opid             = $opid;
            $this->token            = make_token();
            $this->display('eval_login');
        }
    }

}
