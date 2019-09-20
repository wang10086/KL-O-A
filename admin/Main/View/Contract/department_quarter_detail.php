<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>合同统计</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="javascript:;"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">合同统计</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="btn-group" id="catfont" style="padding-bottom:20px;">
                                <?php if($prveyear>2017){ ?>
                                    <a href="{:U('Contract/public_department_quarter_detail',array('year'=>$prveyear,'quarter'=>$quarter,'month'=>'01','id'=>$department_info['id']))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>
                                <?php } ?>
                                <?php
                                for($i=1;$i<5;$i++){
                                    $par = array();
                                    $par['year']  = $year;
                                    $par['quarter'] = $i;
                                    $par['month'] = $month;
                                    $par['id']    = $department_info['id'];
                                    if($quarter==$i){
                                        echo '<a href="'.U('Contract/public_department_quarter_detail',$par).'" class="btn btn-info" style="padding:8px 18px;">'.$i.'季度</a>';
                                    }else{
                                        echo '<a href="'.U('Contract/public_department_quarter_detail',$par).'" class="btn btn-default" style="padding:8px 18px;">'.$i.'季度</a>';
                                    }
                                }
                                ?>
                                <?php if($year<date('Y')){ ?>
                                    <a href="{:U('Contract/public_department_quarter_detail',array('year'=>$nextyear,'month'=>'01','id'=>$department_info['id']))}" class="btn btn-default" style="padding:8px 18px;">下一年</a>
                                <?php } ?>
                            </div>

                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">合同统计详情</h3>
                                    <div class="box-title pull-right"><span class="green">部门名称：{$department_info.department}&emsp;</span></div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                        <tr role="row" class="orders" >
                                            <th class="taskOptions" width="" data="">姓名</th>
                                            <th class="taskOptions" width="" data="">项目数量</th>
                                            <th class="taskOptions" width="" data="">签合同项目数量</th>
                                            <th class="taskOptions" width="" data="">合同份数</th>
                                            <th class="taskOptions" width="" data="">合同签订率</th>
                                        </tr>
                                        <foreach name="lists" item="row" key="k">
                                        <tr>
                                            <td class="taskOptions"><a href="{:U('Contract/public_quarter_detail',array('year'=>$year,'quarter'=>$quarter,'month'=>$month,'uid'=>$row['user_id']))}">{$row.user_name}</a></td>
                                            <td class="taskOptions">{$row.op_num}</td>
                                            <td class="taskOptions">{$row.contract_num}</td>
                                            <td class="taskOptions">{$row.}</td>
                                            <td class="taskOptions">{$row.average}</td>
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


            <div id="searchtext">
                <form action="" method="get" id="searchform">
                <input type="hidden" name="m" value="Main">
                <input type="hidden" name="c" value="Contract">
                <input type="hidden" name="a" value="public_department_detail">
                <input type="hidden" name="uid" value="{$uid}">
                <input type="hidden" name="start_time" value="{$start_time}">
                <input type="hidden" name="end_time" value="{$end_time}">
                <input type="hidden" name="pin" value="{$pin}">

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
                    url: "{:U('Contract/sure_print')}",
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
