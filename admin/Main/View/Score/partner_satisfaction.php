<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>城市合伙人满意度</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="javascript:;"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">城市合伙人满意度</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">

                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">城市合伙人满意度</h3>
                                    <h3 class="box-title pull-right"><span class="green">被评分人：{$account.nickname}</span></h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                        <tr role="row" class="orders" >
                                            <th class="sorting" width="80" data="">评分月份</th>
                                            <th class="sorting" data="">评分时间</th>
                                            <th class="sorting" data="">客户联系方式</th>
                                            <th class="sorting" data="">{$lists[0][AA_title]}</th>
                                            <th class="sorting" data="">{$lists[0][BB_title]}</th>
                                            <th class="sorting" data="">{$lists[0][CC_title]}</th>
                                            <th class="sorting" data="">{$lists[0][DD_title]}</th>
                                            <th class="sorting" data="">{$lists[0][EE_title]}</th>
                                            <th class="sorting" data="">意见建议</th>
                                        </tr>
                                        <foreach name="lists" item="row">
                                        <tr>
                                            <td class="sorting">{$row.monthly}</td>
                                            <td class="sorting">{$row.create_time|date='Y-m-d',###}</td>
                                            <td class="sorting">{$row.mobile}</td>
                                            <td class="sorting">{$row.AA} &nbsp;星</td>
                                            <td class="sorting">{$row.BB} &nbsp;星</td>
                                            <td class="sorting">{$row.CC} &nbsp;星</td>
                                            <td class="sorting">{$row.DD} &nbsp;星</td>
                                            <td class="sorting">{$row.EE} &nbsp;星</td>
                                            <td class="sorting">{$row.content}</td>
                                        </tr>
                                        </foreach>
                                        <tr class="black">
                                            <td colspan="3">评分月份：{$month}</td>
                                            <td colspan="3">评分次数：{$number}</td>
                                            <td colspan="3">平均分：{$complete}</td>
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
</script>
