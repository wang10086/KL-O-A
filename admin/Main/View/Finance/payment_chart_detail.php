<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>回款管理</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li class="active">回款管理</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">

                            <div class="btn-group" id="catfont" style="padding-bottom:20px;">
                                <?php if($prveyear>2017){ ?>
                                    <a href="{:U('Finance/public_payment_chart_detail',array('year'=>$prveyear,'month'=>'01','pin'=>$pin,'department'=>$department))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>
                                <?php } ?>
                                <?php
                                    for($i=1;$i<13;$i++){
                                        $par = array();
                                        $par['year']  = $year;
                                        $par['month'] = str_pad($i,2,"0",STR_PAD_LEFT);
                                        $par['pin']   = $pin;
                                        $par['department']=$department;
                                        if($month==$i){
                                            echo '<a href="'.U('Finance/public_payment_chart_detail',$par).'" class="btn btn-info" style="padding:8px 18px;">'.$i.'月</a>';
                                        }else{
                                            echo '<a href="'.U('Finance/public_payment_chart_detail',$par).'" class="btn btn-default" style="padding:8px 18px;">'.$i.'月</a>';
                                        }
                                    }
                                ?>
                                <?php if($year<date('Y')){ ?>
                                    <a href="{:U('Finance/public_payment_chart_detail',array('year'=>$nextyear,'month'=>'01','pin'=>$pin,'department'=>$department))}" class="btn btn-default" style="padding:8px 18px;">下一年</a>
                                <?php } ?>
                            </div>

                            <div class="box box-warning">
                                <div class="box-header">
                                    <!--<h3 class="box-title">回款管理</h3>
                                    <div class="box-tools pull-right">
                                    	 <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',700,160);"><i class="fa fa-search"></i> 搜索</a>
                                    </div>-->
                                    <div class="box-header">
                                        <div class="box-tools btn-group" id="chart_btn_group">
                                            <a href="{:U('Finance/public_payment_chart_detail',array('pin'=>0,'year'=>$year,'month'=>$month,'department'=>$department))}" class="btn btn-sm <?php if ($pin==0){ echo 'btn-info';}else{echo "btn-group-header";} ?>">回款统计</a>
                                            <a href="{:U('Finance/public_payment_chart_detail',array('pin'=>1,'year'=>$year,'month'=>$month,'department'=>$department))}" class="btn btn-sm <?php if ($pin==1){ echo 'btn-info';}else{echo "btn-group-header";} ?>">当月回款详情</a>
                                            <a href="{:U('Finance/public_payment_chart_detail',array('pin'=>2,'year'=>$year,'month'=>$month,'department'=>$department))}" class="btn btn-sm <?php if ($pin==2){ echo 'btn-info';}else{echo "btn-group-header";} ?>">历史欠款详情</a>
                                        </div>
                                    </div><!-- /.box-header -->
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                    	<th class="taskOptions">姓名</th>
                                        <th class="taskOptions" data="">当月计划回款金额</th>
                                        <th class="taskOptions" data="">历史欠款金额</th>
                                        <th class="taskOptions" data="">实际回款金额</th>
                                        <th class="taskOptions" data="">回款及时率</th>

                                        
                                    </tr>
                                    <foreach name="lists" item="row">
                                    <tr>
                                    	<td class="taskOptions"><a href="{:U('Finance/public_money_back_detail',array('uid'=>$row['id'],'start_time'=>$cycle_time['begintime'],'end_time'=>$cycle_time['endtime']))}" target="_blank">{$row.nickname}</a></td>
                                        <td class="taskOptions">{$row.this_month}</td>
                                        <td class="taskOptions">{$row.history}</td>
                                        <td class="taskOptions">{$row.this_month_return}</td>
                                        <td class="taskOptions">{$row.money_back_average}</td>
                                    </tr>
                                    </foreach>
                                    <tr>
                                        <td class="taskOptions black">合计</td>
                                        <td class="taskOptions black">{$sum.this_month}</td>
                                        <td class="taskOptions black">{$sum.history}</td>
                                        <td class="taskOptions black">{$sum.this_month_return}</td>
                                        <td class="taskOptions black">{$sum.sum_average}</td>
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
                <input type="hidden" name="c" value="Finance">
                <input type="hidden" name="a" value="payment">
                
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="title" placeholder="项目名称">
                </div>
                
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="ou" placeholder="销售">
                </div>
                
                <div class="form-group col-md-4">
                    <select  class="form-control"  name="as">
                        <option value="-1">回款状态</option>
                        <option value="0">未回款</option>
                        <option value="1">回款中</option>
                        <option value="2">已回款</option>
                    </select>                   
                </div>
                
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="opid" placeholder="项目编号">
                </div>
                
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="cid" placeholder="合同编号">
                </div>
                
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="gid" placeholder="项目团号">
                </div>
                
                
               
                
                </form>
            </div>

<include file="Index:footer2" />
