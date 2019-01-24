<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>报销单</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="javascript:;"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">报销单</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">报销单列表</h3>
                                    <div class="box-tools pull-right">
                                    	 <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',600,160);"><i class="fa fa-search"></i> 搜索</a>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <!---->
                                    <div class="btn-group" id="catfont">
                                        <a href="{:U('Finance/baoxiao_lists',array('pin'=>0))}" class="btn <?php if($pin==0){ echo 'btn-info';}else{ echo 'btn-default';} ?>">全部报销单</a>
                                        <a href="{:U('Finance/baoxiao_lists',array('pin'=>1))}" class="btn <?php if($pin==1){ echo 'btn-info';}else{ echo 'btn-default';} ?>">团内支出报销单</a>
                                        <a href="{:U('Finance/baoxiao_lists',array('pin'=>2))}" class="btn <?php if($pin==2){ echo 'btn-info';}else{ echo 'btn-default';} ?>">非团支出报销单</a>
                                    </div>
                                
                                    <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                        <tr role="row" class="orders" >
                                            <?php if (in_array(cookie('userid'),array(1,11,55))){ ?>   <!--程小平-->
                                                <th width="40" style="text-align:center;">
                                                    <a href="javascript:;" type="button" onclick="batch_sure()" class="btn btn-info btn-sm" title="确认" ><i class="fa fa-check-circle"></i></a>
                                                </th>
                                            <?php } ?>
                                            <th width="40" style="text-align:center;">
                                                <a href="javascript:;" type="button" onclick="check_url()" class="btn btn-info btn-sm" title="打印" ><i class="fa fa-print"></i></a>
                                                <!--<input type="checkbox" id="accessdata">-->
                                            </th>
                                            <th class="sorting" width="180" data="b.bxd_id">报销单号</th>
                                            <if condition="$pin neq 2">
                                                <th class="sorting" width="" data="b.group_ids">团号</th>
                                            </if>
                                            <th class="sorting" data="b.jkd_ids">借款单号</th>
                                            <th class="sorting" width="" data="b.description">用途说明</th>
                                            <th class="sorting" width="100" data="b.bx_user">报销人</th>
                                            <th class="sorting" width="80" data="b.sum">报销金额</th>
                                            <th class="sorting" width="60" data="b.type">报销方式</th>
                                            <th class="sorting" width="80" data="b.zhuangtai">审批状态</th>
                                            <if condition="rolemenu(array('Finance/baoxiaodan_info'))">
                                                <th width="40" class="taskOptions">详情</th>
                                            </if>
                                            <if condition="rolemenu(array('Finance/del_bxd'))">
                                                <th width="40" class="taskOptions">删除</th>
                                            </if>
                                        </tr>
                                        <foreach name="lists" item="row">
                                        <tr>
                                            <?php if (in_array(cookie('userid'),array(1,11,55))){ ?>
                                                <td style="text-align:center;"><input type="checkbox" value="{$row.id}" class="batch_confirm"/></td>
                                            <?php } ?>
                                            <td style="text-align:center;"><input type="checkbox" value="{$row.id}" class="accessdata"/></td>
                                            <td>{$row.bxd_id}</td>
                                            <if condition="$pin neq 2">
                                                <td>
                                                    <if condition="$row.bxd_type eq 1">
                                                    {$row.group_ids}
                                                    <else />
                                                    非团报销单
                                                    </if>
                                                </td>
                                            </if>
                                            <td><?php echo $row['jkd_ids']?$row['jkd_ids']:'暂无借款单信息'; ?></td>
                                            <td>
                                                <if condition="$row.bxd_type eq 1"> <!--团内借款报销-->
                                                    <div class="text-overflow-lines"><a href="{:U('Finance/baoxiaodan_info',array('id'=>$row['id']))}" title="{$row.description}">{$row.description}</a></div>
                                                <else /> <!--非团借款报销-->
                                                    <div class="text-overflow-lines"><a href="{:U('Finance/nopbxd_info',array('id'=>$row['id']))}" title="{$row.description}">{$row.description}</a></div>
                                                </if>
                                            </td>
                                            <td>{$row.bx_user}</td>
                                            <td>{$row.sum}</td>
                                            <td>{$jk_type[$row[type]]}</td>
                                            <td>{$row.zhuangtai}</td>
                                            <if condition="rolemenu(array('Finance/baoxiaodan_info','Finance/nopbxd_info'))">
                                                <td class="taskOptions">
                                                    <if condition="$row.bxd_type eq 1"> <!--团内借款报销-->
                                                        <a href="{:U('Finance/baoxiaodan_info',array('id'=>$row['id']))}" title="详情" class="btn btn-info btn-smsm"><i class="fa fa-bars"></i></a>
                                                        <else /> <!--非团借款报销-->
                                                        <a href="{:U('Finance/nopbxd_info',array('id'=>$row['id']))}" title="详情" class="btn btn-info btn-smsm"><i class="fa fa-bars"></i></a>
                                                    </if>
                                                </td>
                                            </if>
                                            <if condition="rolemenu(array('Finance/del_bxd'))">
                                                <td class="taskOptions">
                                                    <button onClick="javascript:ConfirmDel('{:U('Finance/del_bxd',array('id'=>$row['id']))}')" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button>
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
                <input type="hidden" name="a" value="baoxiao_lists">

                <!--<div class="form-group col-md-6">
                    <input type="text" class="form-control" name="title" placeholder="项目名称">
                </div>-->

                <div class="form-group col-md-12">
                    <input type="text" class="form-control" name="oid" placeholder="团号">
                </div>
                
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="bxdid" placeholder="报销单号">
                </div>
               	
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="ou" placeholder="报销人">
                </div>
                
                </form>
            </div>

<include file="Index:footer2" />

<script>
    function check_url() {
        var bxids        = '';
        $('.accessdata').each(function (index,element) {
            var checked     = $(this).parent().attr('aria-checked');
            if (checked=='true'){
                bxids += $(this).val()+',';
            }
        });
        if (!bxids){
            art_show_msg('请选择要打印的报销单');
            return false;
        }else{
            var url =  '/index.php?m=Main&c=Print&a=printReimbursements&bxids='+bxids;
            window.location.href=url;
        }
    }

    function batch_sure() {
        var bxids        = '';
        $('.batch_confirm').each(function (index,element) {
            var checked     = $(this).parent().attr('aria-checked');
            if (checked=='true'){
                bxids += $(this).val()+',';
            }
        });
        if (!bxids){
            art_show_msg('请选择要确认的报销单');
            return false;
        }else{

            var url     =  '/index.php?m=Main&c=Ajax&a=batch_sure';
            var data    = bxids;
            var msg     = '确定审批通过吗？';
            batch_confirm(url,data,msg);
        }
    }

    function batch_confirm(url,data,msg) {
        if(!msg){
            var msg = '确定要执行吗？';
        }

        art.dialog({
            title: '提示',
            width:400,
            height:100,
            lock:true,
            fixed: true,
            content: '<span style="width:100%; text-align:center; font-size:18px;float:left; clear:both;">'+msg+'</span>',
            ok: function (msg) {
                $.ajax({
                    type: 'POST',
                    url : url,
                    data: {bxids:data},
                    success: function(message){
                        art_show_msg(message);
                        location.reload();
                        return false;
                    }
                })
            },
            cancelVal: '取消',
            cancel: true //为true等价于function(){}
        });

    }
</script>
