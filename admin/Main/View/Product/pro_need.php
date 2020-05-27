<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{$_action_} <small></small> </h1>
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

                            <!--<include file="Product:pro_navigate" />-->

                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                    <div class="box-tools pull-right">
                                        <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',500,160);"><i class="fa fa-search"></i> 搜索</a>
                                        <if condition="rolemenu(array('Op/plans'))">
                                            <a href="{:U('Product/public_pro_need_add')}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> 新增产品方案需求</a>
                                        </if>
                                    </div>
                                </div><!-- /.box-header -->

                                <div class="box-body">
                                    <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                        <tr role="row" class="orders" >
                                            <th class="sorting" data="" >项目名称（测试）</th>
                                            <th class="sorting" data="">业务人员</th>
                                            <th class="sorting" data="">业务部门</th>
                                            <th class="sorting" data="">目的地</th>
                                            <th class="sorting" data="">接待实施部门</th>
                                            <th class="sorting" data="">线控负责人</th>
                                            <th class="sorting" data="" width="80">天数</th>
                                            <th class="sorting" data="">参考价格</th>
                                            <th class="sorting" data="">类型</th>
                                            <th class="sorting" data="">发布者</th>
                                            <!--<th class="sorting" data="">审批状态</th>-->
                                            <th class="sorting" data="">方案进程</th>
                                            <if condition="rolemenu(array('Op/plans'))">
                                                <th width="40" class="taskOptions">跟进</th>
                                            </if>

                                            <if condition="rolemenu(array('Product/del_pro_need'))">
                                                <th width="40" class="taskOptions">删除</th>
                                            </if>
                                        </tr>
                                        <foreach name="lists" item="row">
                                            <tr>
                                                <td>
                                                    <div class="tdbox_long">
                                                        <?php if (($row['process'] == 0 && cookie('userid')==$row['create_user']) || in_array(cookie('userid'), array(1,11))){ ?>
                                                            <a href="{:U('Product/public_pro_need_follow',array('opid'=>$row['op_id']))}" title="{$row.project}">{$row.project}</a>
                                                        <?php }else{ ?>
                                                            <a href="{:U('Product/public_pro_need_detail',array('opid'=>$row['op_id']))}" title="{$row.project}">{$row.project}</a>
                                                        <?php } ?>
                                                    </div>
                                                </td>
                                                <td>{$row.create_user_name}</td>
                                                <td>{$departments[$row['create_user_department_id']]}</td>
                                                <td>{$provinces[$row[province]]} - {$row.addr}</td>
                                                <td>{$departments[$row['dijie_department_id']]}</td>
                                                <td>{$row.line_blame_name}</td>
                                                <td>{$row.days}天</td>
                                                <td>{$row.cost}</td>
                                                <td><?php echo $kinds[$row['kind']]; ?></td>
                                                <td>{$row.create_user_name}</td>
                                                <!--<td>{$status[$row[status]]}</td>-->
                                                <td>{$op_process[$row['process']]}</td>
                                                <if condition="rolemenu(array('Op/plans'))">
                                                    <td class="taskOptions">
                                                        <?php if (($row['process'] == 0 && cookie('userid')==$row['create_user']) || in_array(cookie('userid'), array(1,11))){ ?>
                                                            <a href="{:U('Product/public_pro_need_follow',array('opid'=>$row['op_id']))}" title="跟进" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
                                                        <?php }else{ ?>
                                                            <a href="{:U('Product/public_pro_need_detail',array('opid'=>$row['op_id']))}" title="跟进" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
                                                        <?php } ?>
                                                    </td>
                                                </if>
                                                <if condition="rolemenu(array('Product/del_pro_need'))">
                                                    <td class="taskOptions">
                                                        <button onClick="javascript:ConfirmDel('{:U('Product/del_pro_need',array('id'=>$row['id']))}')" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button>
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


