<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{$_pagetitle_}</h1>
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

                            <include file="Product:pro_navigate" />

                            <div class="box box-warning mt20">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                    <div class="box-tools pull-right">
                                        <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',500,160);"><i class="fa fa-search"></i> 搜索</a>
                                        <if condition="rolemenu(array('Op/plans'))">
                                            <a href="{:U('Product/public_pro_need_add')}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> 新增方案需求</a>
                                        </if>
                                    </div>
                                </div><!-- /.box-header -->

                                <div class="box-body">
                                    <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                        <tr role="row" class="orders" >
                                            <th class="sorting" data="" >需求名称</th>
                                            <th class="sorting" data=""80 width="">人数</th>
                                            <th class="sorting" data="">出行时间</th>
                                            <th class="sorting" data="" width="80">天数</th>
                                            <th class="sorting" data="">目的地</th>
                                            <th class="sorting" data="">类型</th>
                                            <th class="sorting" data="">创建者</th>
                                            <th class="sorting" data="">状态</th>
                                            <if condition="rolemenu(array('Op/plans'))">
                                                <th width="40" class="taskOptions">跟进</th>
                                            </if>

                                            <if condition="rolemenu(array(''))">
                                                <th width="40" class="taskOptions">删除</th>
                                            </if>
                                        </tr>
                                        <foreach name="lists" item="row">
                                            <tr>
                                                <td><div class="tdbox_long"><a href="{:U('Product/public_pro_need_detail',array('id'=>$row['id']))}" title="{$row.title}">{$row.title}</a></div></td>
                                                <td>{$row.number}人</td>
                                                <td>{$row['departure']|date='Y-m-d',###}</td>
                                                <td>{$row.days}天</td>
                                                <td>{$provinces[$row[province]]} - {$row.addr}</td>
                                                <td><?php echo $kinds[$row['kind']]; ?></td>
                                                <td>{$row.create_user_name}</td>
                                                <td>{$status[$row[status]]}</td>
                                                <if condition="rolemenu(array('Op/plans'))">
                                                    <td class="taskOptions">
                                                        <a href="{:U('Product/public_pro_need_add',array('id'=>$row['id']))}" title="编辑" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
                                                    </td>
                                                </if>
                                                <if condition="rolemenu(array(''))">
                                                    <td class="taskOptions">
                                                        <button onClick="javascript:ConfirmDel('{:U('',array('id'=>$row['id']))}')" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button>
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
                <input type="hidden" name="c" value="Product">
                <input type="hidden" name="a" value="public_pro_need">

                <div class="form-group col-md-12">
                    <input type="text" class="form-control" name="title" placeholder="名称">
                </div>

                </form>
            </div>

<include file="Index:footer2" />


