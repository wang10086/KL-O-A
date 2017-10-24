		<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>参与KPI考核人员</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Rbac/kpi_users')}"><i class="fa fa-gift"></i> KPI</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                
                
                	<div class="row">
                        <div class="col-xs-12">
                        	 <div class="btn-group" id="catfont" style="padding-bottom:20px;">
								<?php 
                                foreach($postlist as $k=>$v){
                                    $par = array();
                                    $par['pid']  = $k;
                                    if($pid==$k){
                                        echo '<a href="'.U('Rbac/kpi_users',$par).'" class="btn btn-info" style="padding:8px 18px;">'.$v.'</a>';
                                    }else{
                                        echo '<a href="'.U('Rbac/kpi_users',$par).'" class="btn btn-default" style="padding:8px 18px;">'.$v.'</a>';
                                    }
                                }
                                ?>
                            </div>
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">用户列表</h3>
                                    <if condition="rolemenu(array('Rbac/adduser'))">
                                    <div class="box-tools pull-right">
                                         <a href="{:U('Rbac/adduser')}" class="btn btn-sm btn-danger"><i class="fa fa-plus"></i> 新增用户</a>
                                    </div>
                                    </if>
                                </div><!-- /.box-header -->
                                <div class="box-body">
								<table class="table table-bordered dataTable fontmini" id="tablelist">
                                    <tr role="row" class="orders" >
                                        <th class="sorting" data="id" width="60">ID</th>
                                        <th class="sorting" data="nickname" width="200">姓名</th>
                                        <th class="sorting" data="roleid">部门</th>
                                        <if condition="rolemenu(array('Rbac/adduser'))">
                                        <th width="60" class="taskOptions">KPI</th>
                                        </if>
                                    </tr>
                                    <foreach name="userlist" item="row">
                                        <tr>
                                            <td>{$row.id}</td>
                                            <td>{$row.nickname}</td>
                                            <td>{$row.rolename}</td>
                                           
                                            <if condition="rolemenu(array('Rbac/kpi_data'))">
                                            <td class="taskOptions">
                                            <button onClick="javascript:window.location.href='{:U('Rbac/kpi_data',array('uid'=>$row['id']))}';" title="KPI" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></button>
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
			
  		</div>
	</div>

	<include file="Index:footer2" />
   