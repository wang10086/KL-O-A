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

                            <include file="Customer:widely_navigate" />

                            <div class="box box-warning mt20">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                    <div class="box-tools pull-right">
                                        <if condition="rolemenu(array('Customer/widely_add'))">
                                        <a href="{:U('Customer/widely_add')}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> 新增活动计划</a>
                                        </if>
                                    </div>
                                </div><!-- /.box-header -->

                                <div class="box-body">
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th class="sorting" data="">活动标题</th>
                                        <th class="sorting" data="">计划时间</th>
                                        <th class="sorting" data="">活动负责人</th>
                                        <th class="sorting" data="">活动类型</th>
                                        <th class="sorting" data="">活动费用(元)</th>
                                        <th class="sorting" data="">活动方案</th>
                                        <if condition="rolemenu(array('Op/plans_info'))">
                                        <th width="40" class="taskOptions">编辑</th>
                                        </if>

                                        <if condition="rolemenu(array('Op/delpro'))">
                                        <th width="40" class="taskOptions">删除</th>
                                        </if>
                                    </tr>
                                    <foreach name="lists" item="row">
                                    <tr>
                                        <td>{$row.}</td>
                                        <td>{$row.}</td>
                                        <td>{$row.}</td>
                                        <td>{$row.}</td>
                                        <td>{$row.}</td>
                                        <td>{$row.}</td>
                                        <td>{$row.}</td>
                                        <if condition="rolemenu(array('Op/plans_follow'))">
                                        <td class="taskOptions">
                                        <a href="" title="详情" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
                                        </td>
                                        </if>
                                        <if condition="rolemenu(array('Op/delpro'))">
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
                <input type="hidden" name="c" value="Op">
                <input type="hidden" name="a" value="index">
                <input type="hidden" name="pin" value="{$pin}">

                <div class="form-group col-md-12">
                    <input type="text" class="form-control" name="title" placeholder="项目名称">
                </div>

                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="id" placeholder="编号">
                </div>

                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="oid" placeholder="团号">
                </div>

                 <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="dest" placeholder="目的地">
                </div>



                <div class="form-group col-md-4">
                    <select  class="form-control"  name="status">
                        <option value="-1">成团状态</option>
                        <option value="0">未成团</option>
                        <option value="1">已成团</option>
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <select  class="form-control"  name="as">
                         <option value="-1">状态</option>
                        <option value="0">未审批</option>
                        <option value="1">通过审批</option>
                        <option value="2">未通过审批</option>
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <select class="form-control" name="kind">
                        <option value="">项目类型</option>
                        <foreach name="kinds" key="k"  item="v">
                        <option value="{$k}">{$v}</option>
                        </foreach>
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="ou" placeholder="立项人">
                </div>

                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="jd" placeholder="计调">
                </div>

                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="su" placeholder="销售">
                </div>

                </form>
            </div>

<include file="Index:footer2" />


