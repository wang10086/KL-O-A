<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>工单管理 <small>工单统计</small> </h1>
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

                            <div class="btn-group" id="catfont" style="padding-bottom:20px;">
                                <?php if($prveyear>2017){ ?>
                                    <a href="{:U('Worder/public_worder_account_chart',array('year'=>$prveyear,'month'=>'01','pin'=>$pin))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>
                                <?php } ?>
                                <?php
                                    for($i=1;$i<13;$i++){
                                        $par = array();
                                        $par['year']  = $year;
                                        $par['month'] = str_pad($i,2,"0",STR_PAD_LEFT);
                                        $par['pin']  = $pin;
                                        if($month==$i){
                                            echo '<a href="'.U('Worder/public_worder_account_chart',$par).'" class="btn btn-info" style="padding:8px 18px;">'.$i.'月</a>';
                                        }else{
                                            echo '<a href="'.U('Worder/public_worder_account_chart',$par).'" class="btn btn-default" style="padding:8px 18px;">'.$i.'月</a>';
                                        }
                                    }
                                ?>
                                <?php if($year<date('Y')){ ?>
                                    <a href="{:U('Worder/public_worder_account_chart',array('year'=>$nextyear,'month'=>'01','pin'=>$pin))}" class="btn btn-default" style="padding:8px 18px;">下一年</a>
                                <?php } ?>
                            </div>

                            <div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title">工单列表</h3>
                                    <div class="box-tools pull-right"></div>
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                <div class="btn-group" id="catfont">
                                    <a href="{:U('Worder/worder_chart',array('year'=>$year,'month'=>$month,'pin'=>0))}" class="btn <?php if($pin==0){ echo 'btn-info';}else{ echo 'btn-default';} ?>">公司</a>
                                    <a href="{:U('Worder/public_worder_account_chart',array('year'=>$year,'month'=>$month,'pin'=>1))}" class="btn <?php if($pin==1){ echo 'btn-info';}else{ echo 'btn-default';} ?>">员工</a>
                                </div>

                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th class="taskOptions" width="60" data="id">人员ID</th>
                                        <th class="taskOptions" width="120" data="">姓名</th>
                                        <th class="taskOptions" width="80" data="">工单数量</th>
                                        <th class="taskOptions" width="80" data="">及时数量</th>
                                        <th class="taskOptions" width="80"  data="">及时率</th>
                                        <th class="taskOptions" width="40">详情</th>
                                    </tr>
                                    <foreach name="lists" item="row"> 
                                    <tr>
                                        <td>{$row.id}<if condition="($row.urgent eq 2) and (in_array($row.status,array(0,1,2)))"><small class="badge pull-right bg-red" style="margin-right:4px;">加急</small></if></td>
                                        <td><a href="{:U('Worder/worder_info',array('id'=>$row['id']))}">{$row.worder_title}</a></td>
                                        <td>{$worder_type[$row[worder_type]]}</td>
                                        <td>{$row.ini_user_name}</td>
                                        <td>{$row.exe_user_name}</td>
                                        <td class="taskOptions">
                                            <button onClick="javascript:window.location.href='{:U('Worder/worder_info',array('id'=>$row['id']))}';" title="详情" class="btn btn-success  btn-smsm"><i class="fa  fa-building-o"></i></button>
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
