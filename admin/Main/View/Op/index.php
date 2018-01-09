<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        项目管理
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
                                    	 <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',800,160);"><i class="fa fa-search"></i> 搜索</a>
                                         <a href="{:U('Op/plans')}" class="btn btn-sm btn-danger"><i class="fa fa-plus"></i> 新建项目计划</a>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                
                                <div class="btn-group" id="catfont">
                                    <a href="{:U('Op/index',array('pin'=>0))}" class="btn <?php if($pin==0){ echo 'btn-info';}else{ echo 'btn-default';} ?>">所有项目</a>
                                    <a href="{:U('Op/index',array('pin'=>1))}" class="btn <?php if($pin==1){ echo 'btn-info';}else{ echo 'btn-default';} ?>">我的项目</a>
                                    <!-- <a href="{:U('Op/index',array('pin'=>2))}" class="btn <?php if($pin==2){ echo 'btn-info';}else{ echo 'btn-default';} ?>">我参与的项目</a> -->
                                </div>
                                
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th class="sorting" width="80" data="o.op_id">编号</th>
                                        <th class="sorting" data="o.status">团号</th>
                                        <th class="sorting" data="o.project" width="160">项目名称</th>
                                        <th class="sorting" data="o.number">人数</th>
                                        <!--
                                        <th class="sorting" data="sale_cost">销售价</th>
                                        <th class="sorting" data="peer_cost">同行价</th>
                                        -->
                                        <th class="sorting" data="o.departure">出行时间</th>
                                        <th class="sorting" data="o.days">天数</th>
                                        <th class="sorting" width="80" data="o.destination">目的地</th>
                                        <th class="sorting" width="80" data="o.kind">类型</th>
                                        <th class="sorting" data="a.jidiao">计调</th>
                                        <!-- <th class="sorting" data="o.sale_user">销售</th> -->
                                        <th class="sorting" data="o.create_user_name">创建者</th>
                                        <th class="sorting" data="o.audit_status">状态</th>
                                        <if condition="rolemenu(array('Op/plans_info'))">
                                        <th width="40" class="taskOptions">跟进</th>
                                        </if>
                                        
                                        <if condition="rolemenu(array('Op/delpro'))">
                                        <th width="40" class="taskOptions">删除</th>
                                        </if> 
                                    </tr>
                                    <foreach name="lists" item="row"> 
                                    <tr>
                                        <td>{$row.op_id}</td>
                                        <td><?php if($row['status']==1){ echo "<span class='green'>".$row['group_id']."</span>";}elseif($row['status']==2){ echo "<span class='red' title='".$row['nogroup']."'>不成团</span>";}else{ echo '未成团';} ?></td>
                                        <td><div class="tdbox_long"><a href="{:U('Op/plans_follow',array('opid'=>$row['op_id']))}" title="{$row.project}">{$row.project}</a></div></td>
                                        <td>{$row.number}人</td>
                                        <!--
                                        <td><?php if($row['sale_cost']){ ?>&yen;{$row.sale_cost}<?php } ?></td>
                                        <td><?php if($row['peer_cost']){ ?>&yen;{$row.peer_cost}<?php } ?></td>
                                        -->
                                        <td>{$row.departure}</td>
                                        <td>{$row.days}天</td>
                                        <td><div class="tdbox_long" style="width:80px" title="{$row.destination}">{$row.destination}</div></td>
                                        <td><div class="tdbox_long" style="width:80px" title="<?php echo $kinds[$row['kind']]; ?>"><?php echo $kinds[$row['kind']]; ?></div></td>
                                        <td>{$row.jidiao}</td>
                                        <!-- <td>{$row.sale_user}</td> -->
                                        <td>{$row.create_user_name}</td>
                                        <td>{$row.zhuangtai}</td>
                                        <if condition="rolemenu(array('Op/plans_follow'))">
                                        <td class="taskOptions">
                                        <a href="{:U('Op/plans_follow',array('opid'=>$row['op_id']))}" title="详情" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
                                        </td>
                                        </if>
                                        <if condition="rolemenu(array('Op/delpro'))">
                                        <td class="taskOptions">
                                        <button onClick="javascript:ConfirmDel('{:U('Op/delpro',array('id'=>$row['id']))}')" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button>
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
