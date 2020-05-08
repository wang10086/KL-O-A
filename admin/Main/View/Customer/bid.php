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

                            <include file="Customer:bid_navigate" />

                            <div class="box box-warning mt20">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                    <div class="box-tools pull-right">
                                        <!--<if condition="rolemenu(array('Customer/bid_add'))">-->
                                        <a href="{:U('Customer/public_bid_add')}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> 新增活动计划</a>
                                        <!--</if>-->
                                    </div>
                                </div><!-- /.box-header -->

                                <div class="box-body">
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th class="sorting" data="">投标项目</th>
                                        <th class="sorting" data="">招标方</th>
                                        <th class="sorting" data="">投标时间</th>
                                        <th class="sorting" data="">投标费用(元)</th>
                                        <th class="sorting" data="">提交人</th>
                                        <th class="sorting" data="">工作方案</th>
                                        <if condition="rolemenu(array('Customer/bid_add'))">
                                        <th width="40" class="taskOptions">编辑</th>
                                        </if>

                                        <if condition="rolemenu(array('Customer/del_bid'))">
                                        <th width="40" class="taskOptions">删除</th>
                                        </if>
                                    </tr>
                                    <foreach name="lists" item="row">
                                    <tr>
                                        <td>{$row.title}</td>
                                        <td>{$row.customer}</td>
                                        <td>{$row.bid_time|date='Y-m-d',###}</td>
                                        <td>{$row.cost}</td>
                                        <td>{$row.blame_name}</td>
                                        <td>{$row.}</td>
                                        <if condition="rolemenu(array('Customer/bid_add'))">
                                        <td class="taskOptions">
                                        <a href="{:U('Customer/public_bid_add',array('id'=>$row['id']))}" title="编辑" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
                                        </td>
                                        </if>
                                        <if condition="rolemenu(array('Customer/del_bid'))">
                                        <td class="taskOptions">
                                        <button onClick="javascript:ConfirmDel('{:U('Customer/del_bid',array('id'=>$row['id']))}')" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button>
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
                <input type="hidden" name="c" value="Customer">
                <input type="hidden" name="a" value="bid">

                <div class="form-group col-md-12">
                    <input type="text" class="form-control" name="title" placeholder="关键字">
                </div>
                </form>
            </div>

<include file="Index:footer2" />


