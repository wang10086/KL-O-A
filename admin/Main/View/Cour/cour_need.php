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

                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">

                            <include file="Cour:cour_navigate" />

                            <!--<div class="box box-warning mt20">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                    <div class="box-tools pull-right">
                                        <if condition="rolemenu(array('Op/plans'))">
                                        <a href="{:U('')}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> 新增培训计划</a>
                                        </if>
                                    </div>
                                </div>

                                <div class="box-body">
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th class="sorting" width="60" data="">编号</th>
                                        <th class="sorting" data="">培训标题</th>
                                        <th class="sorting" data="">计划时间</th>
                                        <th class="sorting" data="">培训负责人</th>
                                        <th class="sorting" data="">培训类型</th>
                                        <th class="sorting" data="">培训对象</th>
                                        <th class="sorting" data="">培训费用(元)</th>
                                        <th class="sorting" data="">培训方案(按钮,点击查看方案)</th>
                                        <if condition="rolemenu(array('Op/plans_info'))">
                                        <th width="40" class="taskOptions">编辑</th>
                                        </if>

                                        <if condition="rolemenu(array('Op/delpro'))">
                                        <th width="40" class="taskOptions">删除</th>
                                        </if>
                                    </tr>
                                    <foreach name="lists" item="row">
                                    <tr>
                                        <td>{$row.op_id}</td>
                                        <td>{$row.group_id}<?php /*if ($row['has_qrcode']){ echo "<i class='fa  fa-qrcode' title='获取满意度二维码' style='color:#3CF; margin-left:8px; cursor:pointer;' onClick=\"get_qrcode(`/index.php?m=Main&c=Op&a=qrcode&opid=$row[op_id]`)\"></i>"; } */?></td>
                                        <td><div class="tdbox_long"><a href="{:U('Op/plans_follow',array('opid'=>$row['op_id']))}" title="{$row.project}">{$row.project}</a></div></td>
                                        <td>{$row.number}人</td>
                                        <td><?php /*echo $row['dep_time'] ? date('Y-m-d',$row['dep_time']) : "<font color='#999'>$row[departure]</font>"; */?></td>
                                        <td>{$row.days}天</td>
                                        <td><div class="tdbox_long" style="width:80px" title="{$row.destination}">{$row.destination}</div></td>
                                        <td><div class="tdbox_long" style="width:80px" title="<?php /*echo $kinds[$row['kind']]; */?>"><?php /*echo $kinds[$row['kind']]; */?></div></td>
                                        <if condition="rolemenu(array('Op/plans_follow'))">
                                        <td class="taskOptions">
                                        <a href="{:U('Op/plans_follow',array('opid'=>$row['op_id']))}" title="详情" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
                                        </td>
                                        </if>
                                        <if condition="rolemenu(array('Op/delpro'))">
                                        <td class="taskOptions">
                                        <button onClick="javascript:has_jiekuan('{$row.op_id}','{$row.id}')" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button>
                                        </td>
                                        </if>
                                    </tr>
                                    </foreach>
                                </table>
                                </div>

                                 <div class="box-footer clearfix">
                                	<div class="pagestyle">{$pages}</div>
                                </div>
                            </div>-->

                        </div>
                     </div>

                </section>
            </aside>


            <!--<div id="searchtext">
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

                </form>
            </div>-->

<include file="Index:footer2" />


