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
                                    <a href="{:U('Finance/history_arrears',array('year'=>$prveyear,'month'=>'01'))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>
                                <?php } ?>
                                <?php
                                    for($i=1;$i<13;$i++){
                                        $par = array();
                                        $par['year']  = $year;
                                        $par['month'] = str_pad($i,2,"0",STR_PAD_LEFT);
                                        if($month==$i){
                                            echo '<a href="'.U('Finance/history_arrears',$par).'" class="btn btn-info" style="padding:8px 18px;">'.$i.'月</a>';
                                        }else{
                                            echo '<a href="'.U('Finance/history_arrears',$par).'" class="btn btn-default" style="padding:8px 18px;">'.$i.'月</a>';
                                        }
                                    }
                                ?>
                                <?php if($year<date('Y')){ ?>
                                    <a href="{:U('Finance/history_arrears',array('year'=>$nextyear,'month'=>'01'))}" class="btn btn-default" style="padding:8px 18px;">下一年</a>
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
                                            <a href="{:U('Finance/public_payment_chart',array('pin'=>1,'year'=>$year,'month'=>$month))}" class="btn btn-sm btn-group-header">回款统计</a>
                                            <a href="{:U('Finance/public_payment_chart',array('pin'=>2,'year'=>$year,'month'=>$month))}" class="btn btn-sm btn-group-header">当月回款详情</a>
                                            <a href="{:U('Finance/history_arrears',array('year'=>$year,'month'=>$month))}" class="btn btn-sm btn-info">历史欠款详情</a>
                                        </div>
                                    </div><!-- /.box-header -->
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                    <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                        <tr role="row" class="orders" >
                                            <th class="sorting" width="150" data="o.group_id">团号</th>
                                            <th class="sorting" width="" data="o.project">项目名称</th>
                                            <th class="sorting" width="" data="t.dep_time">实施日期</th>
                                            <th class="sorting" width="" data="t.ret_time">返回日期</th>
                                            <th class="sorting" width="" data="">笔次/笔数</th>
                                            <th class="sorting" width="120" data="c.amount">计划回款金额</th>
                                            <th class="sorting" width="120" data="c.pay_amount">实际回款金额</th>
                                            <th class="sorting" width="120" data="c.return_time">计划回款时间</th>
                                            <th class="sorting" width="120" data="c.pay_time">实际回款时间</th>
                                            <th class="taskOptions" width="80" >回款状态</th>
                                        </tr>

                                        <foreach name="lists" item="row">
                                            <tr>
                                                <td>{$row.group_id}</td>
                                                <td><a href="{:U('Contract/detail',array('id'=>$row[cid]))}" title="查看合同信息">{$row.project}</a></td>
                                                <td><?php echo $row['dep_time']?date('Y-m-d',$row['dep_time']):''; ?></td>
                                                <td><?php echo $row['ret_time']?date('Y-m-d',$row['ret_time']):''; ?></td>
                                                <td></td>
                                                <td>{$row.amount}</td>
                                                <td>{$row.pay_amount}</td>
                                                <td><?php echo $row['return_time']?date('Y-m-d',$row['return_time']):''; ?></td>
                                                <td><?php echo $row['pay_time']?date('Y-m-d',$row['pay_time']):''; ?></td>
                                                <td class="taskOptions">{$row.stu}</td>
                                            </tr>
                                        </foreach>
                                        <?php /*if($pin==0){ */?><!--
                                            <tr>
                                                <td><b>小计</b></td>
                                                <td colspan="4"></td>
                                                <td>{$data.this_month}</td>
                                                <td><?php /*echo $data['this_month_return']?$data['this_month_return']:'0.00'; */?></td>
                                                <td colspan="3"></td>
                                            </tr>
                                            <tr>
                                                <td><b>历史欠款</b></td>
                                                <td colspan="4"></td>
                                                <td>{$data.history}</td>
                                                <td><?php /*echo $data['history_return']?$data['history_return']:'0.00'; */?></td>
                                                <td colspan="3"></td>
                                            </tr>
                                            <tr>
                                                <td><b>合计</b></td>
                                                <td colspan="4"></td>
                                                <td><?php /*echo $data['this_month']+$data['history']; */?></td>
                                                <td><?php /*echo $data['this_month_return']?$data['this_month_return']:'0.00'; */?></td>
                                                <td colspan="3" class="taskOptions">回款率：{$data.money_back_average}</td>
                                            </tr>
                                        <?php /*}else if($pin==1){ */?>
                                            <tr>
                                                <td><b>合计</b></td>
                                                <td colspan="4"></td>
                                                <td>{$data.history}</td>
                                                <td>{$data.history_return}</td>
                                                <td colspan="3"></td>
                                            </tr>
                                        --><?php /*} */?>

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
