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
                                
                                    <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                        <tr role="row" class="orders" >
                                            <th class="sorting" width="150" data="o.group_id">团号</th>
                                            <th class="sorting" width="" data="o.project">项目名称</th>
                                            <th class="sorting" width="100" data="c.amount">计划回款金额</th>
                                            <th class="sorting" width="100" data="c.pay_amount">实际回款金额</th>
                                            <th class="sorting" width="100" data="c.return_time">计划回款时间</th>
                                            <th class="sorting" width="100" data="c.pay_time">实际回款时间</th>
                                            <th class="taskOptions" width="80" >回款状态</th>
                                        </tr>

                                        <foreach name="lists" item="row">
                                        <tr>
                                            <td>{$row.group_id}</td>
                                            <td>{$row.project}</td>
                                            <td>{$row.amount}</td>
                                            <td>{$row.pay_amount}</td>
                                            <td><?php echo $row['return_time']?date('Y-m-d',$row['return_time']):''; ?></td>
                                            <!--<td>{$row.pay_time|date='Y-m-d',###}</td>-->
                                            <td><?php echo $row['pay_time']?date('Y-m-d',$row['pay_time']):''; ?></td>
                                            <td class="taskOptions">{$row.stu}</td>
                                        </tr>
                                        </foreach>
                                        <tr>
                                            <td><b>合计</b></td>
                                            <td></td>
                                            <td>{$data.plan_back}</td>
                                            <td>{$data.money_back}</td>
                                            <td colspan="3" class="taskOptions">回款率：{$data.money_back_average}</td>
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
                <input type="hidden" name="a" value="public_money_back_detail">
                <input type="hidden" name="uid" value="{$uid}">
                <input type="hidden" name="rtime" value="{$rtime}">

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
