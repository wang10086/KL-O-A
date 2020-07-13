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
                                        <input type="hidden" name="uid" value="{$uid}">
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
                            <th width="20"></th>
                            <th width="">提醒类型</th>
                            <th width="">标题</th>
                            <?php /*if (cookie('userid')==1){ */?>
                            <th width="">节点类型</th>
                            <?php /*} */?>
                            <th width="">创建时间</th>
                            <th width="">督办</th>
                            <!--<th width="">操作者</th>
                            <th width="">操作时间</th>-->
                        </tr>
                        </thead>
                        <tbody>
                            <foreach name="lists" key="k" item="v">
                                <tr class="userlist">
                                    <td></td>
                                    <td>{$pro_status_arr[$v['pro_status']]}</td>
                                    <td><a href="{:U($v['url'],array('id'=>$v['req_id']))}" onclick="read_log({$v.id},{$v.to_uid},{$v.pro_status})">{$v.title}</a></td>
                                    <?php /*if (cookie('userid')==1){ */?>
                                    <td>{$v.nodeTitle}</td>
                                    <?php /*} */?>
                                    <td>{$v.req_time|date='Y-m-d H:i:s',###}</td>
                                    <td><a href="javascript:;" onclick="javascript:urge('{:U('Zprocess/urge',array('id'=>$v['id']))}')" class="btn btn-info btn-smsm">督办</a></td>
                                    <!--<td></td>
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
            <label>请输入人员信息 <font color="#999">(点击匹配到的内容)</font> </label>
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


    function read_log(log_id,to_uid,pro_status) {
        $.ajax({
            type: 'POST',
            url : "{:U('Ajax/read_process_log')}",
            dataType: 'JSON',
            data: {log_id:log_id, to_uid:to_uid, pro_status:pro_status},
            success: function () { },
            error: function () {
                console.log('error');
                return false;
            }
        })
    }

    function urge(url,msg) {
        if(!msg){ var msg = '确定要督办此事项吗？'; }
        var refer   = window.location.host;

        art.dialog({
            title: '提示',
            width:400,
            height:100,
            lock:true,
            fixed: true,
            content: '<span style="width:100%; text-align:center; font-size:18px;float:left; clear:both;">'+msg+'</span>',
            ok: function (msg) {
                window.location.href=url;
                //this.title('3秒后自动关闭').time(3);
                return false;
            },
            cancelVal: '取消',
            cancel: true //为true等价于function(){}
        });

    }
</script>

