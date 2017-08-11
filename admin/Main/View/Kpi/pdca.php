<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{$_action_}</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Kpi/pdca')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
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
                                    <div class="box-tools pull-right">
                                    	 
                                         <if condition="rolemenu(array('Kpi/editpdca'))">
                                         <a href="{:U('Kpi/editpdca')}" class="btn btn-info btn-sm" ><i class="fa fa-upload"></i> 制定PDCA计划</a>
                                         </if>
                                         
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th class="sorting" width="60" data="month">月份</th>
                                        <th class="sorting" data="title">标题</th>
                                        <th class="sorting" data="tab_user_id">编制人</th>
                                        <th class="sorting" data="tab_time">编制时间</th>
                                        <th class="sorting" data="app_user_id">审批人</th>
                                        <th class="sorting" data="app_time">审批时间</th>
                                        <th class="sorting" data="eva_user_id">考评人</th>
                                        <th class="sorting" data="eva_time">考评时间</th>
                                        <th class="sorting" data="total_score">评分</th>
                                        <th class="sorting" data="status">状态</th>
                                        <if condition="rolemenu(array('Kpi/editpdca'))">
                                        <th width="50" class="taskOptions">编辑</th>
                                        </if>
                                        <if condition="rolemenu(array('Kpi/delpdca'))">
                                        <th width="50" class="taskOptions">删除</th>
                                        </if>
                                    </tr>
                                    <foreach name="lists" item="row"> 
                                    <tr>
                                        <td>{$row.month}</td>
                                        <td>{$row.title}</td>
                                        <td>{:username($row['tab_user_id'])}</td>
                                        <td><if condition="$row['tab_time']">{$row.tab_time|date='Y-m-d H:i:s',###}</if></td>
                                        <td>{:username($row['app_user_id'])}</td>
                                        <td><if condition="$row['app_time']">{$row.app_time|date='Y-m-d H:i:s',###}</if></td>
                                        <td>{:username($row['eva_user_id'])}</td>
                                        <td><if condition="$row['eva_time']">{$row.eva_time|date='Y-m-d H:i:s',###}</if></td>
                                        <td>{$row.total_score}</td>
                                        <td>{$row.status}</td>
                                        <if condition="rolemenu(array('Kpi/editpdca'))">
                                        <td class="taskOptions">
                                        <a href="{:U('Kpi/editpdca',array('id'=>$row['id']))}" title="维护" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
                                        </td>
                                        </if>
                                        <if condition="rolemenu(array('Kpi/delpdca'))">
                                        <td class="taskOptions">
                                        <button onclick="javascript:ConfirmDel('{:U('Kpi/delpdca',array('id'=>$row['id']))}')" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button>
                                       
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
            
            
            <div id="mkdir">
                <form method="post" action="{:U('Files/mkdirs')}" name="myform" id="gosub">
            	<input type="hidden" name="dosubmit"  value="1">
                <input type="hidden" name="pid" value="{$pid}">
                <input type="hidden" name="level" value="{$level}">
                <div class="form-group col-md-12">
                    <input type="text" class="form-control" name="filename" placeholder="文件夹名称">
                </div>
                </form>
            </div>
            
            
           

<include file="Index:footer2" />
