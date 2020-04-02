<include file="Index:header2" />

<aside class="right-side">
    <section class="content-header">
        <h1>
            {$_pagetitle_}
            <small>{$_action_}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{:U('Zprocess/public_index')}"><i class="fa fa-home"></i> 首页</a></li>
            <li><a href="javascript:;"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
            <li class="active">{$_action_}</li>
        </ol>
    </section>

    <style>
        .padding0{padding: 0;}
        .box-left-3{border-right: 1px solid #999; min-height: 800px;}
        .box-left-title{height: 45px; line-height: 45px; background-color: #f5f5f5;}
        .box-left-titsp{font-weight: 500; font-size: 20px; margin-left: 5px;}
        .menu-title-lc{height: 40px; line-height: 40px; margin-bottom: 0; margin-left: 5px; }

        .box-right-title{height: 80px; line-height: 80px;}
        .box-right-fa{ font-size: 50px; color: #fff;  }
        .box-right-tit-logo{float: left; height: 100%; width: 6%; display: inline-block;}
        .box-right-tit-logo .faspan{display: inline-block; height: 57px; line-height: 57px; width: 57px; background-color: #9031af; padding: 3px; border-radius: 5px; margin: 12px 0 0 5px;}
        .box-right-tit-d{float: right; height: 100%; width: 94%; }
        .box-right-tit-dp{font-size: 22px; height: 40px; line-height: 40px; margin: 0 0 0 5px; }
        .box-right-tit-dpd{ height: 30px; line-height: 30px; margin-left: 5px; margin-bottom: 15px; }
        .box-right-tit-butd{float: right; padding-right: 20px; clear: both;}
    </style>

    <section class="content padding0">
            <div class="col-md-12 padding0">
                <div class="col-md-3 box-left-3 padding0">
                    <div class="box-left-title">
                        <span class="box-left-titsp"><i class="fa fa-th-list"></i> <span style="margin-left: 3px;">全部类型</span></span>
                    </div>
                    <p class="menu-title-lc"> <i class="fa fa-caret-right"></i> <a href="{:U('Zprocess/public_todo',array('p'=>0,'stu'=>$stu,'uid'=>$uid))}" class="{$p==0 ? 'menu-font-color' : ''}">全部({$sum})</a></p>
                    <?php foreach ($typeLists as $v){ ?>
                        <?php if ($v['num'] != 0){ ?>
                            <p class="menu-title-lc"> <i class="fa fa-caret-right"></i><a href="{:U('Zprocess/public_todo',array('t'=>$v['id'],'stu'=>$stu,'uid'=>$uid))}" class="{$t==$v['id'] ? 'menu-font-color' : ''}"> {$v.title}({$v.num})</a></p>
                        <?php } ?>

                        <?php foreach ($processLists as $value){ ?>
                            <?php if ($value['num'] != 0 && $value['type'] == $v['id']){ ?>
                                <p class="menu-title-lc"> &emsp;  <a href="{:U('Zprocess/public_todo',array('p'=>$value['id'],'stu'=>$stu,'uid'=>$uid))}" class="{$p==$value['id'] ? 'menu-font-color' : ''}">{$value.title}({$value.num})</a></p>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                    <!--<p class="menu-title-lc"> <i class="fa fa-caret-right"></i> LTC主干流程(5)</p>
                    <p class="menu-title-lc"> &emsp; 发布/获取业务季销售资料(3)</p>
                    <p class="menu-title-lc"> &emsp; 组织培训/学习业务季产品   (2)</p>
                    <p class="menu-title-lc"> <i class="fa fa-caret-right"></i> IPD主干流程(2)</p>
                    <p class="menu-title-lc"> &emsp; 征集业务季产品需求(2)</p>-->
                </div>

                <div class="col-md-9 padding0" style="min-height: 500px;">
                    <div class="box-right-title">
                        <div class="box-right-tit-logo">
                            <span class="faspan"><i class="fa fa-map-signs box-right-fa"></i></span>
                        </div>

                        <div class="box-right-tit-d">
                            <p class="box-right-tit-dp">待办事宜</p>
                            <div class="box-right-tit-dpd">
                                <a href="{:U('Zprocess/public_todo',array('p'=>$p,'t'=>$t,'uid'=>$uid))}" class="{$stu==0? 'menu-font-color' : ''}">全部({$sum})</a> &nbsp;|&nbsp;
                                <a href="{:U('Zprocess/public_todo',array('p'=>$p,'t'=>$t,'uid'=>$uid,'stu'=>P::PROCESS_STU_NOREAD))}" class="{$stu==P::PROCESS_STU_NOREAD ? 'menu-font-color' : ''}">未读({$stu_num[P::PROCESS_STU_NOREAD] ? $stu_num[P::PROCESS_STU_NOREAD] : 0})</a> &nbsp;|&nbsp;
                                <a href="{:U('Zprocess/public_todo',array('p'=>$p,'t'=>$t,'uid'=>$uid,'stu'=>P::PROCESS_STU_BEFORE))}" class="{$stu==P::PROCESS_STU_BEFORE ? 'menu-font-color' : ''}">事前提醒({$stu_num[P::PROCESS_STU_BEFORE] ? $stu_num[P::PROCESS_STU_BEFORE] : 0})</a> &nbsp;|&nbsp;
                                <a href="{:U('Zprocess/public_todo',array('p'=>$p,'t'=>$t,'uid'=>$uid,'stu'=>P::PROCESS_STU_FEEDBACK))}" class="{$stu==P::PROCESS_STU_FEEDBACK ? 'menu-font-color' : ''}">反馈({$stu_num[P::PROCESS_STU_FEEDBACK] ? $stu_num[P::PROCESS_STU_FEEDBACK] : 0})</a> &nbsp;|&nbsp;
                                <a href="{:U('Zprocess/public_todo',array('p'=>$p,'t'=>$t,'uid'=>$uid,'stu'=>P::PROCESS_STU_TIMEOUT))}" class="{$stu==P::PROCESS_STU_TIMEOUT ? 'menu-font-color' : ''}">超时提醒({$stu_num[P::PROCESS_STU_TIMEOUT] ? $stu_num[P::PROCESS_STU_TIMEOUT] : 0})</a> &nbsp;|&nbsp;
                                <a href="{:U('Zprocess/public_todo',array('p'=>$p,'t'=>$t,'uid'=>$uid,'stu'=>P::PROCESS_STU_QUICKLY))}" class="{$stu==P::PROCESS_STU_QUICKLY ? 'menu-font-color' : ''}">被督办({$stu_num[P::PROCESS_STU_QUICKLY] ? $stu_num[P::PROCESS_STU_QUICKLY] : 0})</a> &nbsp;

                                <div class="box-right-tit-butd">
                                    <!--<input type="button" class="btn btn-info btn-sm" style="width: 80px; margin-right: 20px;" onclick="others()" value="查看他人">-->
                                    <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',500,180);autocomp('user_name','user_id')"><i class="fa fa-search"></i> 查看他人</a>
                                    <form action="{:U('Zprocess/public_todo')}" method="post" style="display: inline-block;">
                                        <input type="text" name="key" class="" style="height: 30px;" placeholder="搜索关键字">
                                        <input type="submit" class="btn btn-default btn-sm" value="提交">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped" id="font-14-p">
                        <thead>
                        <tr style="background-color: #f8f8f8;">
                            <th width="60"></th>
                            <th width="">标题</th>
                            <th width="">节点类型</th>
                            <th width="">创建人</th>
                            <th width="">创建时间</th>
                            <!--<th width="">状态</th>
                            <th width="">操作者</th>
                            <th width="">操作时间</th>-->
                        </tr>
                        </thead>
                        <tbody>
                            <foreach name="lists" key="k" item="v">
                                <tr class="userlist">
                                    <td></td>
                                    <td><a href="{:U($v['url'],array('id'=>$v['req_id']))}">{$v.title}</a></td>
                                    <td>{$v.nodeTitle}</td>
                                    <td> {$v.req_uname}</td>
                                    <td>{$v.req_time|date='Y-m-d H:i:s',###}</td>
                                    <!--<td> {$v.}</td>
                                    <td></td>
                                    <td>{$v.}</td>-->
                                </tr>
                            </foreach>
                        </tbody>
                    </table>
                </div>

            </div><!--/.col (right) -->
    </section><!-- /.content -->
</aside><!-- /.right-side -->


<include file="Index:footer2" />

<div id="searchtext">
    <form action="" method="get" id="searchform">
        <input type="hidden" name="m" value="Main">
        <input type="hidden" name="c" value="Zprocess">
        <input type="hidden" name="a" value="public_todo">

        <div class="form-group col-md-12"></div>
        <div class="form-group col-md-12">
            <label>请输入人员信息</label>
            <input type="text" name="user_name" class="form-control" id="user_name" />
            <input type="hidden" name="uid" class="form-control" id="user_id" />
        </div>

    </form>
</div>

<script type="text/javascript">
    function autocomp(username,userid){
        let userkey = <?php echo $userkey; ?>;
        autocomplete_id(username,userid,userkey);
    }
</script>

