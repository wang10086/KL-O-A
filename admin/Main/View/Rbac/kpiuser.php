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
								
                                <select class="form-control"  onchange="window.location=this.value;">
                                    <option value="{:U('Rbac/kpi_users')}">所有岗位</option>
                                    <foreach name="postlist" key="k" item="v">
                                    <?php 
                                    $par = array();
                                    $par['year']  = $year;
                                    $par['month'] = $month;
                                    $par['post']  = $k;
                                    ?> 
                                    <if condition="$v"><option value="{:U('Rbac/kpi_users',$par)}" <?php if($pid==$k){ echo 'selected';} ?> >{$v}</option></if>
                                    </foreach>
                                </select>
                                    
                            </div>
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">用户列表</h3>
                                    <div class="box-tools pull-right">
                                    	<a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',600,160);"><i class="fa fa-search"></i> 搜索</a>
                                    </div>
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
    
    		<div id="searchtext">
                <form action="" method="get" id="searchform">
                <input type="hidden" name="m" value="Main">
                <input type="hidden" name="c" value="Rbac">
                <input type="hidden" name="a" value="kpi_users">
                <div class="form-group col-md-12">
                    <input type="text" class="form-control" name="key" placeholder="关键字">
                </div>
                
                <div class="form-group col-md-6">
                    <select class="form-control" name="role">
                        <option value="0">所在部门</option>
                        <foreach name="roles" key="k" item="v">
                        <option value="{$k}">{$v}</option>
                        </foreach>
                    </select>
                </div>
                
                <div class="form-group col-md-6">
                    <select class="form-control" name="post">
                        <option value="0">所属职位</option>
                        <foreach name="posts" key="k" item="v">
                        <option value="{$k}">{$v}</option>
                        </foreach>
                    </select>
                </div>
                
                
                </form>
            </div>

	<include file="Index:footer2" />
   