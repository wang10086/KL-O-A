<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        顾客满意度
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li class="active">顾客满意度</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">顾客满意度</h3>
                                    <div class="box-tools pull-right">
                                    	 <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',800,160);"><i class="fa fa-search"></i> 搜索</a>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th class="sorting" width="80" data="o.op_id">编号</th>
                                        <th class="sorting" data="o.status">团号</th>
                                        <th class="sorting" data="o.project" width="160">项目名称</th>
                                        <th class="sorting" data="o.number">人数</th>

                                        <th class="sorting" data="o.departure">完成时间</th>
                                         <th class="sorting" data="o.sale_user">业务人员</th>
                                        <th class="sorting" data="o.days">调查人员</th>
                                        <th class="taskOptions" width="80" data="o.destination">满意度状态</th>
                                        <th class="taskOptions" width="80" data="o.kind">是否追责</th>
                                        <th class="taskOptions">详情</th>
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
                                         <td>{$row.sale_user}</td>
                                        <td>{$row.days}天</td>
                                        <td><div class="tdbox_long" style="width:80px" title="{$row.destination}">{$row.destination}</div></td>
                                        <td><div class="tdbox_long" style="width:80px" title="<?php echo $kinds[$row['kind']]; ?>"><?php echo $kinds[$row['kind']]; ?></div></td>

                                        <if condition="rolemenu(array('Op/plans_follow'))">
                                        <td class="taskOptions">
                                        <a href="{:U('Op/plans_follow',array('opid'=>$row['op_id']))}" title="详情" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
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
                <input type="hidden" name="c" value="Inspect">
                <input type="hidden" name="a" value="score">
                
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
                    <input type="text" class="form-control" name="ou" placeholder="立项人">
                </div>
                
                </form>
            </div>

<include file="Index:footer2" />
