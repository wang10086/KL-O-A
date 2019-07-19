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
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                    <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;">月份：{$yearMonth}</h3>&emsp;&emsp;
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="btn-group" id="catfont">
                                        <a href="{:U('Kpi/public_sales_ratio',array('pin'=>1,'ym'=>$yearMonth,'sum_ids'=>$sum_ids,'sale_ids'=>$sale_ids))}" class="btn <?php if($pin==1){ echo 'btn-info';}else{ echo 'btn-default';} ?>">当月全部人数</a>
                                        <a href="{:U('Kpi/public_sales_ratio',array('pin'=>2,'ym'=>$yearMonth,'sum_ids'=>$sum_ids,'sale_ids'=>$sale_ids))}" class="btn <?php if($pin==2){ echo 'btn-info';}else{ echo 'btn-default';} ?>">业务人员</a>
                                    </div>
								<table class="table table-bordered dataTable fontmini">
                                    <tr role="row">
                                        <th width="60">ID</th>
                                        <th>姓名</th>
                                        <th>所在部门</th>
                                        <th>岗位</th>
                                        <th>业务属性</th>
                                    </tr>
                                    <foreach name="lists" item="row">
                                        <tr>
                                            <td>{$row.id}</td>
                                            <td>{$row.nickname}</td>
                                            <td>{$row.department}</td>
                                            <td>{$row.position}</td>
                                            <td>{$row.isSale}</td>
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
        <input type="hidden" name="c" value="Rbac">
        <input type="hidden" name="a" value="kpi_quota">

        <div class="form-group col-md-12"></div>
        <div class="form-group col-md-12">
            <input type="text" class="form-control" name="tit" placeholder="请输入指标名称关键字">
        </div>
        <div class="form-group col-md-12">
            <input type="text" class="form-control" name="con" placeholder="请输入指标内容关键字">
        </div>
    </form>
</div>

<include file="Index:footer2" />
