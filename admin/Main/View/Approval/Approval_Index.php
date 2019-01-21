<include file="Index:header2" />


            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>文件审批</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Files/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Approval/Approval_Index')}">文件审批</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">

                                    <a class="btn btn-info btn-sm" href="{:U('Approval/Approval_Upload')}" style="float:right;margin:1em 2em 0em 0em;background-color:#008d4c;"><b>+</b> 创建文件夹</a>
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                <table class="table table-bordered dataTable"  style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th style="text-align:center;width:6em;"><b>文件夹ID </b></th>
                                        <th style="text-align:center;width:8em;"><b>创建人姓名</b></th>
                                        <th style="text-align:center;width:15em;"><b>文件夹名称</b></th>
                                        <th style="text-align:center;width:8em;"><b>创建时间</b></th>
                                        <th style="text-align:center;width:6em;"><b>审批天数</b></th>
                                        <th style="text-align:center;width:6em;"><b>状态</b></th>
                                        <th style="text-align:center;width:10em;"><b>编辑 | 详情 <if condition="rolemenu(array('Approval/file_delete'))">| 删除</if></b></th>
                                    </tr>
                                    <foreach name="approval" item="app">
                                        <tr>
                                            <td style="text-align:center;">{$app['id']}</td>
                                            <td style="text-align:center;color:#3399FF;">{$app['username']}</td>
                                            <td style="text-align:center;"><a href="{$app['file_url']}">{$app['file_name']}</a></td>
                                            <td style="text-align:center;"><?php if(is_numeric($app['createtime'])){echo date('Y-m-d H:i:s',$app['createtime']);}else{echo'';}?></td>
                                            <td style="text-align:center;">{$app['file_date']} ( 天 )</td>
                                            <td style="text-align:center;<?php if($app['statu']<5 || $app['statu']==6){echo 'color:red;';}else{echo 'color:#00CC33;';}?>"> <?php if($app['statu']==1){echo '待上级领导审核';}elseif($app['statu']==2){echo '待综合审核';}elseif($app['statu']==3){echo '待审议人员审核';}elseif($app['statu']==4){echo '待终审批准';}elseif($app['statu']==5){echo '已批准';}elseif($app['statu']==6){echo '驳回';}?></td>

                                            <td style="text-align:center;font-size: 1em;">
                                                <a href="{:U('Approval/Approval_Upload',array('id'=>$app['id']))}" title="编辑" class="btn btn-info btn-smsm">
                                                    <i class="fa fa-pencil"></i>
                                                </a>

                                                | <a href="{:U('Approval/Approval_Update',array('id'=>$app['id']))}" title="详情" class="btn btn-info btn-smsm">
                                                    <i class="fa fa-bars"></i>
                                                </a>
                                                <if condition="rolemenu(array('Approval/file_delete'))">
                                                    |  <a href="{:U('Approval/file_delete',array('id'=>$app['id']))}" title="删除" class="btn btn-warning btn-smsm">
                                                        <i class="fa fa-times"></i>
                                                    </a>
                                                </if>
                                            </td>
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


<include file="Index:footer2" />

<script type="text/javascript">

</script>
