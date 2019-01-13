<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>借款单</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="javascript:;"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">借款单</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">借款单列表</h3>
                                    <div class="box-tools pull-right">
                                    	 <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',600,160);"><i class="fa fa-search"></i> 搜索</a>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="btn-group" id="catfont">
                                        <a href="{:U('Finance/jiekuan_lists',array('pin'=>0))}" class="btn <?php if($pin==0){ echo 'btn-info';}else{ echo 'btn-default';} ?>">全部借款单</a>
                                        <a href="{:U('Finance/jiekuan_lists',array('pin'=>1))}" class="btn <?php if($pin==1){ echo 'btn-info';}else{ echo 'btn-default';} ?>">团内借款单</a>
                                        <a href="{:U('Finance/jiekuan_lists',array('pin'=>2))}" class="btn <?php if($pin==2){ echo 'btn-info';}else{ echo 'btn-default';} ?>">非团借款单</a>
                                    </div>
                                
                                    <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                        <tr role="row" class="orders" >
                                            <th width="40" style="text-align:center;">
                                                <a href="javascript:;" type="button" onclick="check_url()" class="btn btn-info btn-sm" title="打印" ><i class="fa fa-print"></i></a>
                                                <!--<input type="checkbox" id="accessdata">-->
                                            </th>
                                            <th class="sorting" width="180" data="j.jkd_id">借款单号</th>
                                            <if condition="$pin neq 2">
                                                <th class="sorting" width="150" data="j.group_id">团号</th>
                                            </if>
                                            <th class="sorting" width="" data="j.description">用途说明</th>
                                            <th class="sorting" width="60" data="j.jk_user">借款人</th>
                                            <th class="sorting" width="100" data="j.department_id">借款部门</th>
                                            <th class="sorting" width="80" data="j.sum">借款金额</th>
                                            <th class="sorting" width="60" data="j.type">借款方式</th>
                                            <th class="sorting" width="80" data="j.zhuangtai">审批状态</th>
                                            <if condition="rolemenu(array('Finance/jiekuandan_info'))">
                                                <th width="40" class="taskOptions">详情</th>
                                            </if>
                                            <if condition="rolemenu(array('Finance/edit_jiekuandan'))">
                                                <th width="40" class="taskOptions">修改</th>
                                            </if>
                                            <if condition="rolemenu(array('Finance/sure_print'))">
                                                <th width="40" class="taskOptions">打印</th>
                                            </if>
                                            <if condition="rolemenu(array('Finance/del_jkd'))">
                                                <th width="40" class="taskOptions">删除</th>
                                            </if>
                                        </tr>

                                        <foreach name="lists" item="row">
                                        <tr>
                                            <td style="text-align:center;"><input type="checkbox" value="{$row.id}" class="accessdata"/></td>
                                            <td>{$row.jkd_id}</td>
                                            <if condition="$pin neq 2">
                                                <td><?php echo $row['group_id']?$row['group_id']:'非团借款'; ?></td>
                                            </if>
                                            <td>
                                                <div class="text-overflow-lines">
                                                    <if condition="rolemenu(array('Finance/jiekuandan_info'))">
                                                        <if condition="$row.jkd_type neq 2">
                                                        <a href="{:U('Finance/jiekuandan_info',array('jkid'=>$row['id']))}" title="{$row.description}">{$row.description}</a>
                                                        <else />
                                                        <a href="{:U('Finance/nopjk_info',array('jkid'=>$row['id']))}" title="{$row.description}">{$row.description}</a>
                                                        </if>
                                                    <else />
                                                        <a href="javascript:;" title="{$row.project}">{$row.project}</a>
                                                    </if>
                                                </div>
                                            </td>
                                            <td>{$row.jk_user}</td>
                                            <td>{$row.department}</td>
                                            <td>{$row.sum}</td>
                                            <td>{$jk_type[$row[type]]}</td>
                                            <td>{$row.zhuangtai}</td>
                                            <if condition="rolemenu(array('Finance/jiekuandan_info'))">
                                                <td class="taskOptions">
                                                    <if condition="$row.jkd_type neq 2">
                                                        <a href="{:U('Finance/jiekuandan_info',array('jkid'=>$row['id']))}" title="详情" class="btn btn-info btn-smsm"><i class="fa fa-bars"></i></a>
                                                        <else />
                                                        <a href="{:U('Finance/nopjk_info',array('jkid'=>$row['id']))}" title="详情" class="btn btn-info btn-smsm"><i class="fa fa-bars"></i></a>
                                                    </if>
                                                </td>
                                            </if>
                                            <if condition="rolemenu(array('Finance/edit_jiekuandan'))">
                                                <td class="taskOptions">
                                                    <a href="{:U('Finance/edit_jiekuandan',array('jkid'=>$row['id']))}" title="修改" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
                                                </td>
                                            </if>
                                            <if condition="rolemenu(array('Finance/sure_print'))">
                                                <td class="taskOptions">
                                                    <if condition="$row.is_print eq 1">
                                                        <span class="green">已打印</span>
                                                    <else />
                                                        <a href="javascript:;" onclick="ConfirmPrint(`{$row['id']}`,'确认已打印该借款单吗?')" title="打印" class="btn btn-warning btn-smsm"><i class="fa fa-print"></i></a>
                                                    </if>
                                                </td>
                                            </if>
                                            <if condition="rolemenu(array('Finance/del_jkd'))">
                                                <td class="taskOptions">
                                                    <button onClick="javascript:ConfirmDel('{:U('Finance/del_jkd',array('id'=>$row['id']))}')" title="删除" class="btn btn-danger btn-smsm"><i class="fa fa-times"></i></button>
                                                </td>
                                            </if>
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
                <input type="hidden" name="c" value="Finance">
                <input type="hidden" name="a" value="jiekuan_lists">

                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="title" placeholder="项目名称">
                </div>

                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="oid" placeholder="团号">
                </div>
                
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="jkdid" placeholder="借款单号">
                </div>
               	
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="ou" placeholder="借款人">
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
