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

                            <include file="Product:pro_navigate" />

                            <div class="box box-warning mt20">
                                <div class="box-header">
                                    <h3 class="box-title">项目计划列表</h3>
                                    <div class="box-tools pull-right">
                                    	 <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',600,190);"><i class="fa fa-search"></i> 搜索</a>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th class="sorting" width="80" data="o.op_id">编号</th>
                                        <th class="sorting" data="o.status">团号</th>
                                        <th class="sorting" data="o.project" width="160">项目名称</th>
                                        <!--<th class="sorting" data="o.number">人数</th>
                                        <th class="sorting" data="o.departure">出行时间</th>
                                        <th class="sorting" data="o.days">天数</th>-->
                                        <th class="sorting" width="" data="o.destination">目的地</th>
                                        <th class="sorting" width="" data="o.kind">类型</th>
                                        <th class="sorting" data="o.create_user_name">创建者</th>
                                        <th class="sorting" data="o.audit_status">状态</th>
                                        <if condition="rolemenu(array('Op/plans_info'))">
                                        <th width="40" class="taskOptions">跟进</th>
                                        </if>
                                        
                                        <!--<if condition="rolemenu(array('Op/delpro'))">
                                        <th width="40" class="taskOptions">删除</th>
                                        </if> -->
                                    </tr>
                                    <foreach name="lists" item="row"> 
                                    <tr>
                                        <td>{$row.op_id}</td>
                                        <td>{$row.group_id}<?php if ($row['has_qrcode']){ echo "<i class='fa  fa-qrcode' title='获取满意度二维码' style='color:#3CF; margin-left:8px; cursor:pointer;' onClick=\"get_qrcode(`/index.php?m=Main&c=Op&a=qrcode&opid=$row[op_id]`)\"></i>"; } ?></td>
                                        <td><div class="tdbox_long"><a href="{:U('Op/plans_follow',array('opid'=>$row['op_id']))}" title="{$row.project}">{$row.project}</a></div></td>
                                        <!--<td>{$row.number}人</td>
                                        <td><?php /*echo $row['dep_time'] ? date('Y-m-d',$row['dep_time']) : "<font color='#999'>$row[departure]</font>"; */?></td>
                                        <td>{$row.days}天</td>-->
                                        <td><div class="tdbox_long" style="width:80px" title="{$row.destination}">{$row.destination}</div></td>
                                        <td><div class="tdbox_long" style="width:80px" title="<?php echo $kinds[$row['kind']]; ?>"><?php echo $kinds[$row['kind']]; ?></div></td>
                                        <td>{$row.create_user_name}</td>
                                        <td>{$row.zhuangtai}</td>
                                        <if condition="rolemenu(array('Op/plans_follow'))">
                                        <td class="taskOptions">
                                        <a href="{:U('Op/plans_follow',array('opid'=>$row['op_id']))}" title="详情" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
                                        </td>
                                        </if>
                                        <!--<if condition="rolemenu(array('Op/delpro'))">
                                        <td class="taskOptions">
                                        <button onClick="javascript:has_jiekuan('{$row.op_id}','{$row.id}')" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button>
                                        </td>
                                        </if>-->
                                    </tr>
                                    </foreach>					
                                </table>
                                </div><!-- /.box-body -->

                                 <div class="box-footer clearfix">
                                	<div class="pagestyle">{$pages}</div>
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
                <input type="hidden" name="a" value="public_pro_index">

                <div class="form-group col-md-12">
                    <input type="text" class="form-control" name="title" placeholder="项目名称">
                </div>
                
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="id" placeholder="编号">
                </div>
                
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="oid" placeholder="团号">
                </div>
                
                 <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="dest" placeholder="目的地">
                </div>
                
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="su" placeholder="销售">
                </div>
                
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
