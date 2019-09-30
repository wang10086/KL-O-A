<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>计调工作及时率详情</h1>
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
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                    <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;"></h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                    <include file="timely_detail_nave" />
                                    <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                        <tr role="row" class="orders" >
                                            <th class="taskOptions" width="60">序号</th>
                                            <th class="taskOptions">团号</th>
                                            <th class="taskOptions">项目名称</th>
                                            <th class="taskOptions">结算时间</th>
                                            <th class="taskOptions">报账时间</th>
                                            <th class="taskOptions">结算收入</th>
                                            <th class="taskOptions">结算毛利</th>
                                            <th class="taskOptions">销售</th>
                                            <th class="taskOptions">计调</th>
                                            <th class="taskOptions">报账状态</th>
                                            <if condition="rolemenu(array('Sale/reimbursement'))">
                                            <th class="taskOptions">销账</th>
                                            </if>
                                        </tr>
                                        <foreach name="lists" key="k" item="v">
                                            <tr>
                                                <td class="taskOptions">{$k+1}</td>
                                                <td class="taskOptions"><?php echo $v['group_id'] ? $v['group_id'] : "<font class='#999'>未成团</font>"; ?></td>
                                                <td class="taskOptions" style="max-width: 150px;"><a href="{:U('Finance/settlement',array('opid'=>$v['op_id']))}">{$v.project}</a></td>
                                                <td class="taskOptions">{$v.audit_time|date="Y-m-d H:i",###}</td>
                                                <td class="taskOptions"> <?php echo $v['reimbursement_time'] ? date('Y-m-d H:i',$v['reimbursement_time']) : "<font color='#999999'>未报帐</font>" ?></td>
                                                <td class="taskOptions">{$v.shouru}</td>
                                                <td class="taskOptions">{$v.maoli}</td>
                                                <td class="taskOptions">{$v.sale_user}</td>
                                                <td class="taskOptions">{$v.req_uname}</td>
                                                <td class="taskOptions">{$v.reimbursement_stu}</td>
                                                <if condition="rolemenu(array('Sale/reimbursement'))">
                                                <td class="taskOptions">
                                                    <if condition="$v['reimbursement_status'] eq 1">
                                                        <a href="javascript:;" type="button" title="已销账" class="btn btn-default btn-sm">已销账</a>
                                                        <else />
                                                        <a href="javascript:ConfirmReimbursement(`{:U('Sale/reimbursement',array('opid'=>$v['op_id']))}`);" type="button" title="销账" class="btn btn-info btn-sm">确认销账</a>
                                                    </if>
                                                </td>
                                                </if>
                                            </tr>
                                        </foreach>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

                        </div><!-- /.col -->
                    </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->

<include file="Index:footer2" />


<script type="text/javascript">
    function ConfirmReimbursement(url,msg) {
        if(!msg){
            var msg = '确认该团已完成报销了吗？';
        }

        art.dialog({
            title: '提示',
            width:400,
            height:100,
            lock:true,
            fixed: true,
            content: '<span style="width:100%; text-align:center; font-size:18px;float:left; clear:both;">'+msg+'</span>',
            ok: function (msg) {
                window.location.href=url;
                //this.title('3秒后自动关闭').time(3);
                return false;
            },
            cancelVal: '取消',
            cancel: true //为true等价于function(){}
        });

    }

</script>
