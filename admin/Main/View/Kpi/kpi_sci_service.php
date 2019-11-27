<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{$_pagetitle_}</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Rbac/index')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">{$title}列表</h3>
                                    <div class="box-tools pull-right">
                                    	 <!--<a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',500,160);"><i class="fa fa-search"></i> 搜索</a>-->
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th>专家姓名</th>
                                        <th>团号</th>
                                        <th>项目名称</th>
                                        <th>销售人员</th>
                                        <th>核实时间</th>
                                        <th>评分信息</th>
                                    </tr>
                                    <foreach name="list" item="row">
                                    <tr>
                                        <td>{$row.name} <i class='fa fa-qrcode' title='获取满意度二维码' style='color:#3CF; margin-left:8px; cursor:pointer;' onClick="get_qrcode(`/index.php?m=Main&c=Kpi&a=public_qrcode&uid={$uid}&tit={$row[tit]}&quota_id={$quota_id}&ym={$yearMonth}&guide_id={$row[id]}&opid={$row[op_id]}`)"></i></td>
                                        <td>{$row.group_id}</td>
                                        <td><a href="{:U('Op/plans_follow',array('opid'=>$row['op_id']))}">{$row.project}</a></td>
                                        <td>{$row.create_user_name}</td>
                                        <td>{$row.sure_time|date='Y-m-d',###}</td>
                                        <td>{$row.}</td>
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

<include file="Index:footer2" />

<script type="text/javascript">
    //获取评分二维码
    function get_qrcode(url) {
        art.dialog.open(url,{
            id:'qrcode',
            lock:true,
            title: '二维码',
            width:600,
            height:400,
            fixed: true,
        });
    }
</script>
