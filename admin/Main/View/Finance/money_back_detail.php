<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>回款详情</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="javascript:;"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">回款详情</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">回款信息</h3>
                                    <div class="box-tools pull-right">
                                    	 <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',500,200);"><i class="fa fa-search"></i> 搜索</a>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                    <div class="btn-group no-print" id="catfont">
                                        <a href="{:U('Finance/public_money_back_detail',array('uid'=>$uid,'start_time'=>$start_time,'end_time'=>$end_time,'pin'=>0))}" class="btn <?php if ($pin ==0){echo 'btn-info';}else{echo 'btn-default';}; ?>">当月回款</a>
                                        <a href="{:U('Finance/public_money_back_detail',array('uid'=>$uid,'start_time'=>$start_time,'end_time'=>$end_time,'pin'=>1))}" class="btn <?php if ($pin ==1){echo 'btn-info';}else{echo 'btn-default';}; ?>">历史欠款</a>
                                    </div>
                                
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
                                        <?php if($pin==0){ ?>
                                            <tr>
                                                <td><b>小计</b></td>
                                                <td colspan="4"></td>
                                                <td>{$data.this_month}</td>
                                                <td><?php echo $data['this_month_return']?$data['this_month_return']:'0.00'; ?></td>
                                                <td colspan="3"></td>
                                            </tr>
                                            <tr>
                                                <td><b>历史欠款</b></td>
                                                <td colspan="4"></td>
                                                <td>{$data.history}</td>
                                                <td><?php echo $data['history_return']?$data['history_return']:'0.00'; ?></td>
                                                <td colspan="3"></td>
                                            </tr>
                                            <tr>
                                                <td><b>合计</b></td>
                                                <td colspan="4"></td>
                                                <td><?php echo $data['this_month']+$data['history']; ?></td>
                                                <td><?php echo $data['this_month_return']?$data['this_month_return']:'0.00'; ?></td>
                                                <td colspan="3" class="taskOptions">回款率：{$data.money_back_average}</td>
                                            </tr>
                                        <?php }else if($pin==1){ ?>
                                            <tr>
                                                <td><b>合计</b></td>
                                                <td colspan="4"></td>
                                                <td>{$data.history}</td>
                                                <td>{$data.history_return}</td>
                                                <td colspan="3"></td>
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
                <input type="hidden" name="a" value="public_money_back_detail">
                <input type="hidden" name="uid" value="{$uid}">
                <input type="hidden" name="start_time" value="{$start_time}">
                <input type="hidden" name="end_time" value="{$end_time}">

                <div class="form-group col-md-12">
                    <input type="text" class="form-control" name="title" placeholder="项目名称">
                </div>

                <div class="form-group col-md-12">
                    <input type="text" class="form-control" name="oid" placeholder="团号">
                </div>

                <div class="form-group col-md-12">
                    <input type="text" class="form-control" name="opid" placeholder="项目编号">
                </div>
                
                </form>
            </div>

<include file="Index:footer2" />

<script>
    function ConfirmPrint(id,msg) {

        art.dialog({
            title: '提示',
            width:400,
            height:100,
            fixed: true,
            id : 'is_print',
            lock:true,
            content: '<span style="width:100%; text-align:center; font-size:18px;float:left; clear:both;">'+msg+'</span>',
            ok: function () {
                //window.location.href=url;
                //this.title('3秒后自动关闭').time(3);
                top.art.dialog({id:"is_print"}).close();
                $.ajax({
                    type:'POST',
                    url: "{:U('Finance/sure_print')}",
                    data:{jkid:id},
                    success:function (info) {
                        art_show_msg(info.msg,info.time);
                        setTimeout(function(){
                            location.reload()
                        },2000);
                        return false;
                    }
                });
            },
            cancelVal: '取消',
            cancel: true //为true等价于function(){}
        });
    }

    function check_url() {
        var jkids        = '';
        $('.accessdata').each(function (index,element) {
            var checked     = $(this).parent().attr('aria-checked');
            if (checked=='true'){
                jkids += $(this).val()+',';
            }
        });
        if (!jkids){
            art_show_msg('请选择要打印的借款单');
            return false;
        }else{
            var url =  '/index.php?m=Main&c=Print&a=printLoanBill&jkids='+jkids;
            window.location.href=url;
        }
    }

    $(document).ready(function(e) {
        //选择
        $('#accessdata').on('ifChecked', function() {
            $('.accessdata').iCheck('check');
        });
        $('#accessdata').on('ifUnchecked', function() {
            $('.accessdata').iCheck('uncheck');
        });
    });
</script>
