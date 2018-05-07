<include file="Index:header2" />



            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        <span class="green">劳务费用</span> - <span style="color:#333333">{$row.name}</span>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('GuideRes/res')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                            <!-- general form elements disabled -->

                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">出团记录</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                    <div class="content" style="margin-top:10px;">
                                        <table class="table table-bordered dataTable fontmini" id="tablelist">
                                            <tr role="row" class="orders" >
                                                <th class="sorting" data="op_id">项目编号</th>
                                                <th class="sorting" data="group_id">项目团号</th>
                                                <th class="sorting" data="project">项目名称</th>
                                                <th class="sorting" data="cost">提成</th>
                                                <th class="sorting" data="stu">项目状态</th>
                                                <th class="sorting" data="remark">备注</th>

                                                <!--<if condition="rolemenu(array(''))">
                                                    <th width="60" class="taskOptions">编辑</th>
                                                </if>
                                                <if condition="rolemenu(array(''))">
                                                    <th width="60" class="taskOptions">删除</th>
                                                </if>-->
                                            </tr>
                                            <foreach name="guide" item="row">
                                                <tr>
                                                    <td>{$row.op_id}</td>
                                                    <td>{$row.group_id}</td>
                                                    <td><a href="javascript:;">{$row.project}</a></td>
                                                    <td>¥{$row.cost}</td>
                                                    <td>{$row.stu}</td>
                                                    <td>{$row.remark}</td>

                                                    <!--<if condition="rolemenu(array('Project/lession_add'))">
                                                        <td class="taskOptions">
                                                            <button onClick="javascript:window.location.href='{:U('Project/lession_add',array('id'=>$row['id']))}';" title="修改" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></button>
                                                        </td>
                                                    </if>
                                                    <if condition="rolemenu(array('Project/del'))">
                                                        <td class="taskOptions">
                                                            <button onClick="javascript:ConfirmDel('{:U('Project/lession_del',array('id'=>$row['id']))}');" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button>
                                                        </td>
                                                    </if>-->

                                                </tr>
                                            </foreach>
                                            <tr class="no-border">
                                                <td class="no-border"></td>
                                                <td class="no-border"></td>
                                                <td class="no-border"></td>
                                                <td class="no-border" style="color:red;">￥{$countcost}</td>
                                                <td class="no-border"></td>
                                                <td class="no-border"></td>
                                            </tr>
                                        </table>
                                    </div>

                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            
                            
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                </section><!-- /.content -->
                
            </aside><!-- /.right-side -->

  </div>
</div>


            
<include file="Index:footer2" />