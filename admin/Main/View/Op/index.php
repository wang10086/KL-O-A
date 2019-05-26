<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        项目管理
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Rbac/index')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">项目计划列表</h3>
                                    <div class="box-tools pull-right">
                                    	 <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',800,160);"><i class="fa fa-search"></i> 搜索</a>
                                        <if condition="rolemenu(array('Op/plans'))">
                                        <a href="{:U('Op/plans')}" class="btn btn-sm btn-danger"><i class="fa fa-plus"></i> 新建项目计划</a>
                                        </if>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                
                                <div class="btn-group" id="catfont">
                                    <a href="{:U('Op/index',array('pin'=>0))}" class="btn <?php if($pin==0){ echo 'btn-info';}else{ echo 'btn-default';} ?>">所有项目</a>
                                    <a href="{:U('Op/index',array('pin'=>1))}" class="btn <?php if($pin==1){ echo 'btn-info';}else{ echo 'btn-default';} ?>">我的项目</a>
                                    <a href="{:U('Op/index',array('pin'=>2))}" class="btn <?php if($pin==2){ echo 'btn-info';}else{ echo 'btn-default';} ?>">我的核算报价</a>
                                </div>
                                
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th class="sorting" width="80" data="o.op_id">编号</th>
                                        <th class="sorting" data="o.status">团号</th>
                                        <th class="sorting" data="o.project" width="160">项目名称</th>
                                        <th class="sorting" data="o.number">人数</th>
                                        <!--
                                        <th class="sorting" data="sale_cost">销售价</th>
                                        <th class="sorting" data="peer_cost">同行价</th>
                                        -->
                                        <th class="sorting" data="o.departure">出行时间</th>
                                        <th class="sorting" data="o.days">天数</th>
                                        <th class="sorting" width="80" data="o.destination">目的地</th>
                                        <th class="sorting" width="80" data="o.kind">类型</th>
                                        <th class="sorting" data="a.jidiao">计调</th>
                                        <!-- <th class="sorting" data="o.sale_user">销售</th> -->
                                        <th class="sorting" data="o.create_user_name">创建者</th>
                                        <th class="sorting" data="o.audit_status">状态</th>
                                        <if condition="rolemenu(array('Op/plans_info'))">
                                        <th width="40" class="taskOptions">跟进</th>
                                        </if>
                                        
                                        <if condition="rolemenu(array('Op/delpro'))">
                                        <th width="40" class="taskOptions">删除</th>
                                        </if> 
                                    </tr>
                                    <foreach name="lists" item="row"> 
                                    <tr>
                                        <td>{$row.op_id}</td>
                                        <td><?php if($row['status']==1){ echo "<span class='green'>".$row['group_id']."</span> <i class='fa  fa-qrcode' title='获取满意度二维码' style='color:#3CF; margin-left:8px; cursor:pointer;' onClick=\"get_qrcode(`/index.php?m=Main&c=Op&a=qrcode&opid=$row[op_id]`)\"></i>";}elseif($row['status']==2){ echo "<span class='red' title='".$row['nogroup']."'>不成团</span>";}else{ echo '未成团';} ?></td>
                                        <td><div class="tdbox_long"><a href="{:U('Op/plans_follow',array('opid'=>$row['op_id']))}" title="{$row.project}">{$row.project}</a></div></td>
                                        <td>{$row.number}人</td>
                                        <!--
                                        <td><?php if($row['sale_cost']){ ?>&yen;{$row.sale_cost}<?php } ?></td>
                                        <td><?php if($row['peer_cost']){ ?>&yen;{$row.peer_cost}<?php } ?></td>
                                        -->
                                        <td>{$row.departure}</td>
                                        <td>{$row.days}天</td>
                                        <td><div class="tdbox_long" style="width:80px" title="{$row.destination}">{$row.destination}</div></td>
                                        <td><div class="tdbox_long" style="width:80px" title="<?php echo $kinds[$row['kind']]; ?>"><?php echo $kinds[$row['kind']]; ?></div></td>
                                        <td>{$row.jidiao}</td>
                                        <!-- <td>{$row.sale_user}</td> -->
                                        <td>{$row.create_user_name}</td>
                                        <td>{$row.zhuangtai}</td>
                                        <if condition="rolemenu(array('Op/plans_follow'))">
                                        <td class="taskOptions">
                                        <a href="{:U('Op/plans_follow',array('opid'=>$row['op_id']))}" title="详情" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
                                        </td>
                                        </if>
                                        <if condition="rolemenu(array('Op/delpro'))">
                                        <td class="taskOptions">
                                        <!--<button onClick="javascript:ConfirmDel('{:U('Op/delpro',array('id'=>$row['id']))}')" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button>-->
                                        <button onClick="javascript:has_jiekuan('{$row.op_id}','{$row.id}')" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button>
                                        </td>
                                        </if>
                                    </tr>
                                    </foreach>					
                                </table>
                                </div><!-- /.box-body -->

                                <style>
                                    .page-right-print{ display: inline-block; float: right; margin-top: -30px;}
                                </style>

                                 <div class="box-footer clearfix">
                                	<div class="pagestyle">{$pages}
                                        <div class="page-right-print" style="background-color: #f9f9f9;">
                                            <if condition="rolemenu(array('Op/export_op'))">
                                                <!--<a href="{:U('Op/export_op')}" class="btn btn-default"><i class="fa fa-arrow-circle-down"></i> 导出兼职辅导员信息</a>-->
                                                <a href="javascript:;" class="btn btn-default" onclick="javascript:exportSearch('exportSearchText',500,200);"><i class="fa fa-arrow-circle-down"></i> 导出兼职辅导员信息</a>
                                            </if>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- /.box -->

                        </div><!-- /.col -->
                     </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
            
            
            <div id="searchtext">
                <form action="" method="get" id="searchform">
                <input type="hidden" name="m" value="Main">
                <input type="hidden" name="c" value="Op">
                <input type="hidden" name="a" value="index">
                <input type="hidden" name="pin" value="{$pin}">
                
                <div class="form-group col-md-12">
                    <input type="text" class="form-control" name="title" placeholder="项目名称">
                </div>
                
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="id" placeholder="编号">
                </div>
                
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="oid" placeholder="团号">
                </div>
                
                 <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="dest" placeholder="目的地">
                </div>
                
                
                
                <div class="form-group col-md-4">
                    <select  class="form-control"  name="status">
                        <option value="-1">成团状态</option>
                        <option value="0">未成团</option>
                        <option value="1">已成团</option>
                    </select>                   
                </div>
                
                <div class="form-group col-md-4">
                    <select  class="form-control"  name="as">
                         <option value="-1">状态</option>
                        <option value="0">未审批</option>
                        <option value="1">通过审批</option>
                        <option value="2">未通过审批</option>
                    </select>                   
                </div>
                
                <div class="form-group col-md-4">
                    <select class="form-control" name="kind">
                        <option value="">项目类型</option>
                        <foreach name="kinds" key="k"  item="v">
                        <option value="{$k}">{$v}</option>
                        </foreach>
                    </select>
                </div>
               	
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="ou" placeholder="立项人">
                </div>
                
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="jd" placeholder="计调">
                </div>
                
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="su" placeholder="销售">
                </div>
                
                </form>
            </div>

<div id="exportSearchText" style="display: none">
    <form action="" method="get" id="searchform">
        <input type="hidden" name="m" value="Main">
        <input type="hidden" name="c" value="Op">
        <input type="hidden" name="a" value="export_op">
        <input type="hidden" name="pin" value="{$pin}">

        <div class="form-group col-md-12">
            <input type="text" class="form-control inputdate" name="st" value="<?php echo (date('Y')-1).'-12-26'; ?>" placeholder="开始时间">
        </div>

        <div class="form-group col-md-12">
            <input type="text" class="form-control inputdate" name="et" value="<?php echo date('Y-m-d'); ?>" placeholder="结束时间">
        </div>

        <div class="form-group col-md-12">
            <select class="form-control" name="kind">
                <option value="">项目类型</option>
                <foreach name="kinds" key="k"  item="v">
                    <option value="{$k}">{$v}</option>
                </foreach>
            </select>
        </div>

        <!--<div class="form-group col-md-12">
            <input type="text" class="form-control" name="su" placeholder="销售">
        </div>-->

    </form>
</div>

<include file="Index:footer2" />

<script>
    function has_jiekuan(opid,id) {
        $.ajax({
            type: 'post',
            url : "{:U('Ajax/has_jiekuan')}",
            dataType : "JSON",
            data : {opid:opid,id:id},
            success: function (data) {
                ConfirmDel(data.url,data.msg);
            }
        })
    }

    function ConfirmDel(url,msg) {
        /*
         if (confirm("真的要删除吗？")){
         window.location.href=url;
         }else{
         return false;
         }
         */

        if(!msg){
            var msg = '真的要删除吗？';
        }

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

    //获取评分二维码
    function get_qrcode(url) {
        art.dialog.open(url,{
            id:'qrcode',
            lock:true,
            title: '二维码',
            width:600,
            height:400,
            fixed: true,
        });
    }

    function exportSearch(obj,w,h){
        art.dialog({
            content:$('#'+obj).html(),
            lock:true,
            title: '选择导出信息',
            width:w,
            height:h,
            okValue: '搜索',
            ok: function () {
                $('.aui_content').find('input').filter(function(index) {
                    return $(this).val() == '';
                }).remove();
                $('.aui_content').find('form').submit();
            },
            cancelValue:'取消',
            cancel: function () {
            }
        }).show();

        var file_url    = "<?php echo '__HTML__/js/public.js'; ?>";
        reload_jsFile(file_url,'reload_public');
    }

</script>
