<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        {$title}
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="javascript:;"><i class="fa fa-gift"></i> {$title}</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">

                            <div class="btn-group" id="catfont"  style="padding-bottom:20px;">
                                <a href="{:U('Kpi/public_person_loss',array('pin'=>1,'suids'=>$suids,'luids'=>$luids))}" class="btn <?php if($pin==1){ echo 'btn-info';}else{ echo 'btn-default';} ?>">公司员工</a>
                                <a href="{:U('Kpi/public_person_loss',array('pin'=>2,'suids'=>$suids,'luids'=>$luids))}" class="btn <?php if($pin==2){ echo 'btn-info';}else{ echo 'btn-default';} ?>">流失员工</a>
                            </div>

                            <div class="box box-info">
                                <div class="box-header">
                                    <h3 class="box-title">{$title}</h3>
                                    <h3 class="box-title pull-right green">被考核人员：王茜</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                <div class="content black" style="margin-bottom: -30px;">
                                    <div class="form-group col-md-4">
                                        <p>公司人数：{$data.sum_num}</p>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <p>流失人数：{$data.loss_num}</p>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <p>员工流失率：{$data.complete}</p>
                                    </div>
                                </div>

                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th class="taskOptions">姓名</th>
                                        <th class="taskOptions">员工类别</th>
                                        <th class="taskOptions">状态</th>
                                        <th class="taskOptions">是否被开除</th>
                                    </tr>
                                    <foreach name="lists" item="row">
                                        <tr  class="taskOptions">
                                            <td>{$row.nickname}</td>
                                            <td>{$formal_stu[$row['formal']]}</td>
                                            <td>{$status_stu[$row['status']]}</td>
                                            <td>{$expel_stu[$row['expel']]}</td>
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
