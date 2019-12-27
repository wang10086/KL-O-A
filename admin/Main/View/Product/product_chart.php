<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{$_action_}</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="javascript:;"><i class="fa fa-gift"></i> 数据统计</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">

                            <div class="btn-group" id="catfont" style="padding-bottom:20px;">
                                <?php if($prveyear>2019){ ?>
                                    <a href="{:U('Product/public_product_chart',array('year'=>$prveyear,'month'=>'01'))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>
                                <?php } ?>
                                <?php
                                    for($i=1;$i<5;$i++){
                                        $par            = array();
                                        $par['year']    = $year;
                                        $par['quarter'] = $i;
                                        if($quarter==$i){
                                            echo '<a href="'.U('Product/public_product_chart',$par).'" class="btn btn-info" style="padding:8px 18px;">'.$i.'季度</a>';
                                        }else{
                                            echo '<a href="'.U('Product/public_product_chart',$par).'" class="btn btn-default" style="padding:8px 18px;">'.$i.'季度</a>';
                                        }
                                    }
                                ?>
                                <?php if($year<date('Y')){ ?>
                                    <a href="{:U('Product/public_product_chart',array('year'=>$nextyear,'month'=>'01'))}" class="btn btn-default" style="padding:8px 18px;">下一年</a>
                                <?php } ?>
                            </div>

                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                    <div class="box-tools pull-right"></div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                        <tr role="row" class="orders" >
                                            <th class="taskOptions">项目类型</th>
                                            <th class="taskOptions">项目数</th>
                                            <th class="taskOptions">标准化项目数</th>
                                            <th class="taskOptions">成本总额</th>
                                            <th class="taskOptions">标准化成本总额</th>
                                            <th class="taskOptions">标准化率</th>
                                            <th width="80" class="taskOptions">详情</th>
                                        </tr>
                                        <foreach name="lists" key="k" item="v">
                                            <tr>
                                                <td class="taskOptions">{$v.kind_name}</td>
                                                <td class="taskOptions">{$v.sum_op_num}</td>
                                                <td class="taskOptions">{$v.standard_op_num}</td>
                                                <td class="taskOptions">{$v.sum_cost}</td>
                                                <td class="taskOptions">{$v.standard_cost}</td>
                                                <td class="taskOptions">{$v.average}</td>
                                                <td class="taskOptions">
                                                    <a href="{:U('Product/public_product_chart_detail',array('year'=>$year,'quarter'=>$quarter,'kid'=>$v['kind_id']))}" title="详情" class="btn btn-info btn-smsm"><i class="fa fa-bars"></i></a>
                                                </td>
                                            </tr>
                                        </foreach>
                                        <tr class="black">
                                            <td class="taskOptions">合计</td>
                                            <td class="taskOptions">{$sum.sum_op_num}</td>
                                            <td class="taskOptions">{$sum.standard_op_num}</td>
                                            <td class="taskOptions">{$sum.sum_cost}</td>
                                            <td class="taskOptions">{$sum.standard_cost}</td>
                                            <td class="taskOptions">{$sum.average}</td>
                                            <td class="taskOptions">
                                                <a href="{:U('Product/public_product_chart_detail',array('year'=>$year,'quarter'=>$quarter))}" title="详情" class="btn btn-info btn-smsm"><i class="fa fa-bars"></i></a>
                                            </td>
                                        </tr>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

                        </div><!-- /.col -->
                    </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->

<include file="Index:footer2" />