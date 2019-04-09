<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>回款管理 <small>季度回款</small></h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li class="active">季度回款管理</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">

                            <div class="btn-group" id="catfont" style="padding-bottom:5px;">
                                <?php if($prveyear>2016){ ?>
                                    <a href="{:U('Finance/payment_quarter',array('year'=>$prveyear,'quarter'=>$quarter,'pin'=>$pin))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>
                                <?php } ?>
                                <?php
                                for($i=1;$i<5;$i++){
                                    if($quarter==$i){
                                        echo '<a href="'.U('Finance/payment_quarter',array('year'=>$year,'quarter'=>$i,'pin'=>$pin)).'" class="btn btn-info" style="padding:8px 18px;">'.$i.'季度</a>';
                                    }else{
                                        echo '<a href="'.U('Finance/payment_quarter',array('year'=>$year,'quarter'=>$i,'pin'=>$pin)).'" class="btn btn-default" style="padding:8px 18px;">'.$i.'季度</a>';
                                    }
                                }
                                ?>
                                <?php if($year<date('Y')){ ?>
                                    <a href="{:U('Finance/payment_quarter',array('year'=>$nextyear,'quarter'=>$quarter,'pin'=>$pin))}" class="btn btn-default" style="padding:8px 18px;">下一年</a>
                                <?php } ?>
                            </div>

                            <div class="box box-warning">
                                <div class="box-header">
                                   <!-- <h3 class="box-title">季度回款管理</h3>-->

                                    <div class="box-header">
                                        <div class="box-tools btn-group" id="chart_btn_group">
                                            <a href="{:U('Finance/payment_quarter',array('year'=>$year,'quarter'=>$quarter))}" class="btn btn-sm btn-info">季度回款统计</a>
                                            <a href="{:U('Finance/quarter_arrears_detail',array('year'=>$year,'quarter'=>$quarter,'pin'=>1))}" class="btn btn-sm btn-group-header">当季度回款详情</a>
                                            <a href="{:U('Finance/quarter_arrears_detail',array('year'=>$year,'quarter'=>$quarter,'pin'=>2))}" class="btn btn-sm btn-group-header">历史欠款详情</a>
                                        </div>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                    	<th class="taskOptions">业务部门</th>
                                        <th class="taskOptions" data="">计划回款</th>
                                        <th class="taskOptions" data="">历史欠款金额</th>
                                        <th class="taskOptions" data="">实际回款金额</th>
                                        <th class="taskOptions" data="">回款及时率</th>

                                        
                                    </tr>
                                    <foreach name="lists" item="row">
                                    <tr>
                                    	<td class="taskOptions"><a href="{:U('Finance/public_payment_detail',array('department'=>$row['id'],'year'=>$year,'quarter'=>$quarter))}" target="_blank">{$row.department}</a></td>
                                        <td class="taskOptions"><?php echo $row['this_month']?$row['this_month']:'0.00'; ?></td>
                                        <td class="taskOptions"><?php echo $row['history']?$row['history']:'0.00'; ?></td>
                                        <td class="taskOptions"><?php echo $row['this_month_return']?$row['this_month_return']:'0.00'; ?></td>
                                        <td class="taskOptions">{$row.money_back_average}</td>
                                    </tr>
                                    </foreach>
                                    <tr>
                                        <td class="taskOptions black"><b>合计</b></td>
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
