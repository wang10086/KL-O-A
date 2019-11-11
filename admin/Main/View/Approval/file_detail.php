<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{$_pagetitle_}</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Approval/index')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12" style="padding-bottom:200px;">

                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                    <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;"><span class="green mr20">文件状态：{$status[$list['status']]}</span></h3>

                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                        <table class="table table-bordered dataTable fontmini">
                                            <tr role="row" class="orders" >
                                                <th>文件名称</th>
                                                <th>文件类型</th>
                                            </tr>
                                            <foreach name="file_list" item="row">
                                                <tr>
                                                    <td>
                                                        <?php if ($list['status'] == 1 && (in_array(cookie('userid'),$all_audit_users['uids']) || in_array(cookie('userid'),array(1)))){ ?>
                                                        <a href="{:U('Approval/file_audit',array('appid'=>$list['id'],'fid'=>$row['id']))}" title="审核">{$row.filename}</a>
                                                        <?php }else{ ?>
                                                        <a href="{$row.filepath}" title="查看" target="_blank">{$row.newFileName}</a>
                                                        <?php } ?>
                                                    </td>
                                                    <td><?php if ($row['id'] == $list['file_id']){ echo '主文件'; }else{ echo "附件"; } ?></td>
                                                </tr>
                                            </foreach>
                                        </table>

                                        <div class="form-group col-md-12 mt20"></div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>上传人：{$list.create_user_name}</p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p>已审核人：{$audited_users.str_users}</p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p>待审核人：{$audit_users.str_users}</p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p>计划流转工作日：{$list.day} 天</p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p>上传时间：{$list.create_time|date='Y-m-d H:i',###}</p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p>计划结束时间：{$list.plan_time|date='Y-m-d H:i',###}</p>
                                        </div>

                                        <div class="form-group col-md-12" style="margin-top:20px;">
                                            <label style="width:100%; border-bottom:1px solid #dedede; padding-bottom:10px; font-weight:bold;">文件说明</label>
                                            <div style="width:100%; margin-top:10px;">{$list.content}</div>
                                        </div>
                                    </div>

                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
  </div>
</div>

<include file="Index:footer2" />





