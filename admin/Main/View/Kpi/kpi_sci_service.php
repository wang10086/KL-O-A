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
                                    <div class="callout callout-danger">
                                        <h4>提示！</h4>
                                        <p>1、未评分项目将按照50%的基础得分取值；</p>
                                        <p>2、如果有未评分项目,请及时将评分二维码发送至相关人员,以免影响您的KPI；</p>
                                    </div>
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th>专家姓名</th>
                                        <th>团号</th>
                                        <th>项目名称</th>
                                        <th>销售人员</th>
                                        <th>核实时间</th>
                                        <th>评分状态</th>
                                        <th>得分</th>
                                    </tr>
                                    <foreach name="list" item="row">
                                    <tr>
                                        <td>{$row.name}
                                            <?php if (!$row['average']){ ?>
                                            <i class='fa fa-qrcode' title='获取满意度二维码' style='color:#3CF; margin-left:8px; cursor:pointer;' onClick="get_qrcode(`/index.php?m=Main&c=Kpi&a=public_qrcode&uid={$uid}&tit={$row[tit]}&quota_id={$quota_id}&ym={$yearMonth}&guide_id={$row[id]}&opid={$row[op_id]}`)"></i>
                                            <?php } ?>
                                        </td>
                                        <td>{$row.group_id}</td>
                                        <td>
                                            <?php if ($row['average']){ ?>
                                                <a href="javascript:;" onClick="javascript:show_detail({$row['score_list']['id']})">{$row.project}</a>
                                            <?php }else{ ?>
                                                <a href="javascript:;" onClick="art_show_msg('未评分',3)">{$row.project}</a>
                                            <?php } ?>
                                        </td>
                                        <td>{$row.create_user_name}</td>
                                        <td>{$row.sure_time|date='Y-m-d',###}</td>
                                        <td>{$row.score_stu}</td>
                                        <td>{$row['average']?$row['average']:'50%'}</td>
                                    </tr>
                                    </foreach>
                                    <tr class="black">
                                        <td>合计</td>
                                        <td colspan="2">应评分次数 : {$sum.sum_num}</td>
                                        <td colspan="2">已评分次数 : {$sum.score_num}</td>
                                        <td colspan="2">总得分 : {$sum.average}</td>
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

    //得分详情
    function show_detail(sid) {
        art.dialog.open('index.php?m=Main&c=Kpi&a=public_sci_service_detail&sid='+sid,{
            lock:true,
            title: '得分详情',
            width:600,
            height:400,
            fixed: true,

        });
    }
</script>
