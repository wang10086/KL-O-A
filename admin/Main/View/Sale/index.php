<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        出团计划列表
                    </h1>
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
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">项目计划列表</h3>
                                    <div class="box-tools pull-right">
                                    	 <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',600,160);"><i class="fa fa-search"></i> 搜索</a>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th class="sorting" width="100" data="op_id">编号</th>
                                        <th class="sorting" data="status">团号</th>
                                        <th class="sorting" data="project" width="160">项目名称</th>
                                        <th class="sorting" data="number">预计人数</th>
                                        
                                        <th class="sorting" data="departure">出行时间</th>
                                        <th class="sorting" data="days">天数</th>
                                        <th class="sorting" width="80" data="destination">目的地</th>
                                        <th>销售价</th>
                                        <th>同行价</th>
                                        <if condition="rolemenu(array('Op/plans_info'))">
                                        <th width="50" class="taskOptions">报名</th>
                                        </if>
                                        
                                    </tr>
                                    <foreach name="lists" item="row"> 
                                    <tr>
                                        <td>{$row.op_id}</td>
                                        <td><?php if($row['status']==1){ echo "<span class='green'>".$row['group_id']."</span>";}elseif($row['status']==2){ echo "<span class='red' title='".$row['nogroup']."'>不成团</span>";}else{ echo '未成团';} ?></td>
                                        <td><div class="tdbox"><a href="{:U('Sale/goods',array('opid'=>$row['op_id']))}" title="{$row.project}">{$row.project}</a></div></td>
                                        <td>{$row.number}人</td>
                                        
                                        <td>{$row.departure}</td>
                                        <td>{$row.days}天</td>
                                        <td><div class="tdbox_long" style="width:80px" title="{$row.destination}">{$row.destination}</div></td>
                                        <td><?php if($row['sale_cost']){ ?>&yen;{$row.sale_cost}<?php } ?></td>
                                        <td><?php if($row['peer_cost']){ ?>&yen;{$row.peer_cost}<?php } ?></td>
                                        <if condition="rolemenu(array('Sale/goods'))">
                                        <td class="taskOptions">
                                        <a href="{:U('Sale/goods',array('opid'=>$row['op_id']))}" title="详情" class="btn btn-info btn-smsm"><i class="fa fa-shopping-cart"></i></a>
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
                <input type="hidden" name="c" value="Sale">
                <input type="hidden" name="a" value="index">
                
                <div class="form-group col-md-12">
                    <input type="text" class="form-control" name="project" placeholder="计划名称">
                </div>
                
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="opid" placeholder="编号">
                </div>
                
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="groupid" placeholder="团号">
                </div>
                
                 <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="departure" placeholder="出行日期">
                </div>
                
                <div class="form-group col-md-12">
                    <input type="text" class="form-control" name="destination" placeholder="目的地">
                </div>
                
                </form>
            </div>

<include file="Index:footer2" />
