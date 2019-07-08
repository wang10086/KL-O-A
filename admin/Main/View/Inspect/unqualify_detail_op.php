<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{$_action_}</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th class="sorting" width="60" data="o.op_id">项目编号</th>
                                        <th class="sorting" data="o.group_id">团号</th>
                                        <th class="sorting" data="o.project">项目名称</th>
                                        <th class="sorting" data="show_stu">处理状态</th>
                                        <th class="sorting" data="title">处理信息</th>
                                    </tr>

                                    <foreach name="lists" item="row"> 
                                    <tr>
                                        <td>{$row.op_id}</td>
                                        <td>{$row.group_id}</td>
                                        <td><a href="{:U('Inspect/score_info',array('opid'=>$row['op_id']))}" title="满意度详情">{$row.project}</a></td>
                                        <td>{$row.show_stu}</td>
                                        <td><a href="javascript:;" onClick="qadetail({$row.id})" >{$row.title}</a></td>
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
    //查看详情
    function qadetail(id) {
        art.dialog.open('index.php?m=Main&c=Kpi&a=qadetail&id='+id,{
            lock:true,
            title: '品质报告详情',
            width:800,
            height:'90%',
            fixed: true,

        });
    }
</script>