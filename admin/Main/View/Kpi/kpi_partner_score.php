<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{$_action_}</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="javascript:;"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
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
                                    <h3 class="box-title pull-right"><span class="green">考核月份：{$months}</span></h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <?php if ($lists){ ?>
                                    <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                        <tr role="row" class="orders" >
                                            <th>城市合伙人</th>
                                            <th>合作时间</th>
                                            <th>评分状态</th>
                                            <th>评分号码</th>
                                            <th>得分</th>
                                        </tr>
                                        <foreach name="lists" item="row">
                                        <tr>
                                            <td><a href="{:U('Customer/partner_detail',array('id'=>$row['id']))}">{$row.name}</a></td>
                                            <td>{$row.start_date|date='Y-m-d',###} - {$row.end_date|date='Y-m-d',###}</td>
                                            <td>{$row.is_score}</td>
                                            <td>{$row.smobile}</td>
                                            <td><a onClick="javascript:show_detail({$row.sid});" title="详情">{$row.average}</a></td>
                                        </tr>
                                        </foreach>
                                    </table>
                                    <div class="form-group mt20">
                                        <div style="display: inline-block; width:30%">应评分次数：{$data.should_score_num}</div>
                                        <div style="display: inline-block; width:30%">已评分次数：{$data.score_num}</div>
                                        <div style="display: inline-block; width:30%">总得分：{$data.average}</div>
                                    </div>
                                    <?php }else{ ?>
                                        <div class="content" style="padding-top:40px;">  暂无评分信息!</div>
                                    <?php } ?>
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
                <input type="hidden" name="a" value="public_month_detail">
                <input type="hidden" name="uid" value="{$uid}">
                <input type="hidden" name="year" value="{$year}">
                <input type="hidden" name="month" value="{$month}">

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

    //得分详情
    function show_detail(sid) {
        art.dialog.open('index.php?m=Main&c=Kpi&a=public_score_detail&id='+sid,{
            lock:true,
            title: '得分详情',
            width:600,
            height:400,
            fixed: true,

        });
    }
</script>
