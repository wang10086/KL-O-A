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
                                    <a href="{:U('Contract/department_detail',array('year'=>$prveyear,'month'=>'01','id'=>$department_id))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>
                                <?php } ?>
                                <?php
                                    for($i=1;$i<13;$i++){
                                        $par          = array();
                                        $par['year']  = $year;
                                        $par['month'] = str_pad($i,2,"0",STR_PAD_LEFT);
                                        $par['id']    = $department_id;
                                        if($month==$i){
                                            echo '<a href="'.U('Contract/department_detail',$par).'" class="btn btn-info" style="padding:8px 18px;">'.$i.'月</a>';
                                        }else{
                                            echo '<a href="'.U('Contract/department_detail',$par).'" class="btn btn-default" style="padding:8px 18px;">'.$i.'月</a>';
                                        }
                                    }
                                ?>
                                <?php if($year<date('Y')){ ?>
                                    <a href="{:U('Contract/department_detail',array('year'=>$nextyear,'month'=>'01','id'=>$department_id))}" class="btn btn-default" style="padding:8px 18px;">下一年</a>
                                <?php } ?>
                            </div>

                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">{$lists.department}合同统计</h3>
                                    <div class="box-tools pull-right">
                                        <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',600,160);"><i class="fa fa-search"></i> 搜索</a>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                        <tr role="row" class="orders" >
                                            <th class="sorting" width="" data="">团号</th>
                                            <th class="sorting" width="" data="">项目名称</th>
                                            <th class="sorting" width="" data="">实施日期</th>
                                            <th class="sorting" width="" data="">完成日期</th>
                                            <th class="sorting" width="" data="">业务人员</th>
                                            <th class="sorting" width="" data="">是否签订合同</th>
                                            <th class="sorting" width="" data="">合同份数</th>
                                        </tr>
                                        <foreach name="lists" item="row">
                                        <tr>
                                            <td class="sorting">{$row.group_id}</td>
                                            <td class="sorting"><a href="{:U('Op/plans_follow',array('opid'=>$row['op_id']))}" title="查看项目详情">{$row.project}</a></td>
                                            <td class="sorting">{$row.dep_time|date='Y-m-d',###}</td>
                                            <td class="sorting">{$row.ret_time|date='Y-m-d',###}</td>
                                            <td class="sorting">{$row.create_user_name}</td>
                                            <td class="sorting">{$row.contract_stu}</td>
                                            <td class="sorting">{$row.}</td>
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
                <input type="hidden" name="a" value="department_detail">
                <input type="hidden" name="id" value="{$department_id}">
                <input type="hidden" name="year" value="{$year}">
                <input type="hidden" name="month" value="{$month}">

                <div class="form-group col-md-12"></div>
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="title" placeholder="项目名称">
                </div>

                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="oid" placeholder="团号">
                </div>

                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="opid" placeholder="项目编号">
                </div>

                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="uname" placeholder="销售">
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
