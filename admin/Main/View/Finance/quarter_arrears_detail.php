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

                            <div class="btn-group" id="catfont" style="padding-bottom:5px;">
                                <?php if($prveyear>2016){ ?>
                                    <a href="{:U('Finance/quarter_arrears_detail',array('year'=>$prveyear,'quarter'=>$quarter,'pin'=>$pin))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>
                                <?php } ?>
                                <?php
                                for($i=1;$i<5;$i++){
                                    if($quarter==$i){
                                        echo '<a href="'.U('Finance/quarter_arrears_detail',array('year'=>$year,'quarter'=>$i,'pin'=>$pin)).'" class="btn btn-info" style="padding:8px 18px;">'.$i.'季度</a>';
                                    }else{
                                        echo '<a href="'.U('Finance/quarter_arrears_detail',array('year'=>$year,'quarter'=>$i,'pin'=>$pin)).'" class="btn btn-default" style="padding:8px 18px;">'.$i.'季度</a>';
                                    }
                                }
                                ?>
                                <?php if($year<date('Y')){ ?>
                                    <a href="{:U('Finance/quarter_arrears_detail',array('year'=>$nextyear,'quarter'=>$quarter,'pin'=>$pin))}" class="btn btn-default" style="padding:8px 18px;">下一年</a>
                                <?php } ?>
                            </div>

                            <div class="box box-warning">
                                <div class="box-header">
                                    <!--<h3 class="box-title">回款管理</h3>
                                    <div class="box-tools pull-right">
                                    	 <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',700,160);"><i class="fa fa-search"></i> 搜索</a>
                                    </div>-->
                                    <div class="box-tools btn-group" id="chart_btn_group">
                                        <a href="{:U('Finance/payment_quarter',array('year'=>$year,'quarter'=>$quarter))}" class="btn btn-sm btn-group-header">季度回款统计</a>
                                        <a href="{:U('Finance/quarter_arrears_detail',array('year'=>$year,'quarter'=>$quarter,'pin'=>1))}" class="btn btn-sm <?php if ($pin==1){ echo "btn-info";}else{ echo "btn-group-header"; }; ?>">当季度回款详情</a>
                                        <a href="{:U('Finance/quarter_arrears_detail',array('year'=>$year,'quarter'=>$quarter,'pin'=>2))}" class="btn btn-sm <?php if ($pin==2){ echo "btn-info";}else{ echo "btn-group-header"; }; ?>">历史欠款详情</a>
                                    </div>
                                    <div class="box-tools pull-right">
                                        <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',600,160);"><i class="fa fa-search"></i> 搜索</a>
                                    </div>
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
                                            <th class="sorting" width="120" data="o.create_user_name">业务人员</th>
                                            <?php if ($pin==1){ ?>
                                            <th class="sorting" width="120" data="c.pay_time">实际回款时间</th>
                                            <th class="taskOptions" width="80" >回款状态</th>
                                            <?php } ?>
                                            <td class="taskOptions">修改</td>
                                            <td class="taskOptions">删除</td>
                                        </tr>

                                        <foreach name="lists" item="row">
                                            <tr>
                                                <td>{$row.group_id}</td>
                                                <td><a href="{:U('Contract/detail',array('id'=>$row[cid]))}" title="查看合同信息">{$row.pro_name}</a></td>
                                                <td><?php echo $row['dep_time']?date('Y-m-d',$row['dep_time']):''; ?></td>
                                                <td><?php echo $row['ret_time']?date('Y-m-d',$row['ret_time']):''; ?></td>
                                                <td class="taskOptions">{$row.no_sum}</td>
                                                <td class="taskOptions">{$row.amount}</td>
                                                <td class="taskOptions">{$row.pay_amount}</td>
                                                <td><?php echo $row['return_time']?date('Y-m-d',$row['return_time']):''; ?></td>
                                                <td>{$row.create_user_name}</td>
                                                <?php if ($pin==1){ ?>
                                                <td><?php echo $row['pay_time']?date('Y-m-d',$row['pay_time']):''; ?></td>
                                                <td class="taskOptions">{$row.stu}</td>
                                                <?php } ?>
                                                <if condition="rolemenu(array('Finance/huikuan'))">
                                                    <td class="taskOptions">
                                                        <a href="{:U('Finance/huikuan',array('opid'=>$row['op_id']))}" title="修改" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
                                                    </td>
                                                </if>
                                                <if condition="rolemenu(array('Finance/del_payment'))">
                                                    <td class="taskOptions">
                                                        <button onClick="del_confirm({$row['id']})" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button>
                                                    </td>
                                                </if>
                                            </tr>
                                        </foreach>
                                        <?php if($pin==1){ ?>
                                            <tr>
                                                <td><b>小计</b></td>
                                                <td colspan="4"></td>
                                                <td>{$data.this_month}</td>
                                                <td><?php echo $data['this_month_return']?$data['this_month_return']:'0.00'; ?></td>
                                                <td colspan="6"></td>
                                            </tr>
                                            <tr>
                                                <td><b>历史欠款</b></td>
                                                <td colspan="4"></td>
                                                <td>{$data.history}</td>
                                                <td><?php echo $data['history_return']?$data['history_return']:'0.00'; ?></td>
                                                <td colspan="6"></td>
                                            </tr>
                                            <tr>
                                                <td><b>合计</b></td>
                                                <td colspan="4"></td>
                                                <td><?php echo $data['this_month']+$data['history']; ?></td>
                                                <td><?php echo $data['this_month_return']?$data['this_month_return']:'0.00'; ?></td>
                                                <td colspan="6" class="taskOptions">回款率：{$data.money_back_average}</td>
                                            </tr>
                                        <?php }else if($pin==2){ ?>
                                            <tr>
                                                <td><b>合计</b></td>
                                                <td colspan="4"></td>
                                                <td>{$data.history}</td>
                                                <td>{$data.history_return}</td>
                                                <td colspan="5"></td>
                                            </tr>
                                        <?php } ?>

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
                <input type="hidden" name="a" value="arrears_detail">
                <input type="hidden" name="year" value="{$year}">
                <input type="hidden" name="month" value="{$month}">
                <input type="hidden" name="pin" value="{$pin}">

                <div class="form-group col-md-12"></div>
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="title" placeholder="项目名称">
                </div>

                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="gid" placeholder="项目团号">
                </div>
                
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="opid" placeholder="项目编号">
                </div>

                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="ou" placeholder="销售">
                </div>
                </form>
            </div>

<include file="Index:footer2" />

<script>
    //删除
    function del_confirm(id){

        art.dialog({
            title: '提示',
            width:400,
            height:100,
            lock:true,
            fixed: true,
            content: '<span style="width:100%; text-align:center; font-size:18px;float:left; clear:both;">真的要删除吗？</span>',
            ok: function () {
                var host            = "<?php echo $_SERVER['SERVER_NAME'] ?>";
                var url             = "<?php echo U('Finance/del_payment'); ?>";
                window.location.href = 'http://'+host+url+'&id='+id;
                //this.title('3秒后自动关闭').time(3);
                return false;
            },
            cancelVal: '取消',
            cancel: true //为true等价于function(){}
        });

    }
</script>
