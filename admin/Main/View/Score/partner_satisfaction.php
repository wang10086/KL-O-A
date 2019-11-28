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
                                    <h3 class="box-title pull-right"><span class="green">被评分人：{$account.nickname}</span></h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <?php if ($lists){ ?>
                                    <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                        <tr role="row" class="orders" >
                                            <th width="80">评分月份</th>
                                            <th>评分时间</th>
                                            <th>客户联系方式</th>
                                            <?php if ($lists[0]['AA']){ ?><th>{$lists[0][AA_title]}</th><?php } ?>
                                            <?php if ($lists[0]['BB']){ ?><th>{$lists[0][BB_title]}</th><?php } ?>
                                            <?php if ($lists[0]['CC']){ ?><th>{$lists[0][CC_title]}</th><?php } ?>
                                            <?php if ($lists[0]['DD']){ ?><th>{$lists[0][DD_title]}</th><?php } ?>
                                            <?php if ($lists[0]['EE']){ ?><th>{$lists[0][EE_title]}</th><?php } ?>
                                            <th>意见建议</th>
                                        </tr>
                                        <foreach name="lists" item="row">
                                        <tr>
                                            <td>{$row.monthly}</td>
                                            <td>{$row.create_time|date='Y-m-d',###}</td>
                                            <td><?php echo in_array(cookie('userid'),array(11)) ? $row['mobile'] : $row['hide_mobile']; ?></td>
                                            <?php if ($lists[0]['AA']){ ?><td>{$row.AA} &nbsp;星</td><?php } ?>
                                            <?php if ($lists[0]['BB']){ ?><td>{$row.BB} &nbsp;星</td><?php } ?>
                                            <?php if ($lists[0]['CC']){ ?><td>{$row.CC} &nbsp;星</td><?php } ?>
                                            <?php if ($lists[0]['DD']){ ?><td>{$row.DD} &nbsp;星</td><?php } ?>
                                            <?php if ($lists[0]['EE']){ ?><td>{$row.EE} &nbsp;星</td><?php } ?>
                                            <td>{$row.content}</td>
                                        </tr>
                                        </foreach>
                                    </table>
                                    <div class="form-group mt20">
                                        <div style="display: inline-block; width:30%">评分月份：{$month}</div>
                                        <div style="display: inline-block; width:30%">评分次数：{$number}</div>
                                        <div style="display: inline-block; width:30%">平均分：{$complete}</div>
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
</script>
