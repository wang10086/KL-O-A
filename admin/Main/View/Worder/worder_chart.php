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
                                    <a href="{:U('Worder/worder_chart',array('year'=>$prveyear,'month'=>'01','pin'=>$pin))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>
                                <?php } ?>
                                <?php
                                    for($i=1;$i<13;$i++){
                                        $par = array();
                                        $par['year']  = $year;
                                        $par['month'] = str_pad($i,2,"0",STR_PAD_LEFT);
                                        $par['pin']  = $pin;
                                        if($month==$i){
                                            echo '<a href="'.U('Worder/worder_chart',$par).'" class="btn btn-info" style="padding:8px 18px;">'.$i.'月</a>';
                                        }else{
                                            echo '<a href="'.U('Worder/worder_chart',$par).'" class="btn btn-default" style="padding:8px 18px;">'.$i.'月</a>';
                                        }
                                    }
                                ?>
                                <?php if($year<date('Y')){ ?>
                                    <a href="{:U('Worder/worder_chart',array('year'=>$nextyear,'month'=>'01','pin'=>$pin))}" class="btn btn-default" style="padding:8px 18px;">下一年</a>
                                <?php } ?>
                            </div>

                            <div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title">工单列表</h3>
                                    <div class="box-tools pull-right">
                                    	 <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',500,120);"><i class="fa fa-search"></i> 搜索</a>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                <if condition="rolemenu(array('Worder/worder_chart'))">
                                    <div class="btn-group" id="catfont">
                                        <a href="{:U('Worder/worder_chart',array('year'=>$year,'month'=>$month,'pin'=>0))}" class="btn <?php if($pin==0){ echo 'btn-info';}else{ echo 'btn-default';} ?>">公司</a>
                                        <a href="{:U('Worder/public_worder_account_chart',array('year'=>$year,'month'=>$month,'pin'=>1))}" class="btn <?php if($pin==1){ echo 'btn-info';}else{ echo 'btn-default';} ?>">员工</a>
                                    </div>
                                </if>

                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th class="sorting" width="60" data="id">ID</th>
                                        <th class="sorting" width="120" data="worder_title">工单标题</th>
                                        <th class="sorting" width="80" data="init_user_name">发起人姓名</th>
                                        <th class="sorting" width="80"  data="exe_user_name">接收人姓名</th>
                                        <th class="sorting" width="80"  data="assign_name">执行人姓名</th>
                                        <th class="sorting" width="80" data="status">工单状态</th>
                                        <th class="sorting" width="125">工单创建时间</th>
                                        <th class="taskOptions" width="125">完成状态</th>
                                        <th class="taskOptions" width="80">满意度</th>
                                        <th class="taskOptions" width="40">详情</th>
                                    </tr>
                                    <foreach name="lists" item="row"> 
                                    <tr>
                                        <td>{$row.id}<if condition="($row.urgent eq 2) and (in_array($row.status,array(0,1,2)))"><small class="badge pull-right bg-red" style="margin-right:4px;">加急</small></if></td>
                                        <td><a href="{:U('Worder/worder_info',array('id'=>$row['id']))}">{$row.worder_title}</a></td>
                                        <td>{$row.ini_user_name}</td>
                                        <td>{$row.exe_user_name}</td>
                                        <td><?php echo $row['assign_name']?$row['assign_name']:"<span class=\"yellow\">未指派</span>"; ?></td>
                                        <td>{$row.sta}</td>
                                        <td>{$row.create_time|date='Y-m-d H:i:s',###}</td>
                                        <td class="taskOptions">{$row.com_stu}</td>
                                        <td class="taskOptions">{$row.score_avg}</td>
                                        <td class="taskOptions">
                                            <button onClick="javascript:window.location.href='{:U('Worder/worder_info',array('id'=>$row['id']))}';" title="详情" class="btn btn-success  btn-smsm"><i class="fa  fa-building-o"></i></button>
                                        </td>
                                    </tr>
                                    </foreach>
                                    <tr class="black">
                                        <td colspan="2">合计：{$data.sum_num}</td>
                                        <td colspan="3">及时数：{$data.ok_num}</td>
                                        <td colspan="2">及时率：{$data.average}</td>
                                        <td colspan="3">已评分满意度：{$data.score_avg}</td>
                                    </tr>
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
                <input type="hidden" name="c" value="Worder">
                <input type="hidden" name="a" value="worder_chart">

                <div class="form-group col-md-12"></div>
                <div class="form-group col-md-12">
                    <input type="text" class="form-control" name="tit" placeholder="工单名称关键字">
                </div>
                
                </form>
            </div>

<include file="Index:footer2" />
