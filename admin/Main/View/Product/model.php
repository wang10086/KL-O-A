<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        产品模板管理
                        <small>{$_pagedesc_}</small>
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
                                    <h3 class="box-title">产品模板列表</h3>
                                    <div class="box-tools pull-right">
                                    	<a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',600,160);"><i class="fa fa-search"></i> 搜索</a>
                                        <a href="{:U('Product/addtpl')}" class="btn btn-sm btn-danger"><i class="fa fa-plus"></i> 新建产品模板</a>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                <div class="btn-group" id="catfont">
                                    <button onClick="javascript:window.location.href='{:U('Product/tpl',array('status'=>'-1'))}';" class="btn <?php if($status=='-1'){ echo 'btn-info';}else{ echo 'btn-default';} ?>">所有的</button>
                                    <button onClick="javascript:window.location.href='{:U('Product/tpl',array('status'=>0))}';" class="btn <?php if($status==0){ echo 'btn-info';}else{ echo 'btn-default';} ?>">未审批</button>
                                    <button onClick="javascript:window.location.href='{:U('Product/tpl',array('status'=>1))}';" class="btn <?php if($status==1){ echo 'btn-info';}else{ echo 'btn-default';} ?>">已通过</button>
                                    <button onClick="javascript:window.location.href='{:U('Product/tpl',array('status'=>2))}';" class="btn <?php if($status==2){ echo 'btn-info';}else{ echo 'btn-default';} ?>">未通过</button>
                                   
                                </div>
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th class="sorting" data="p.id">ID</th>
                                        <th class="sorting" data="p.title">模板名称</th>
                                        <th class="sorting" data="p.business_dept">适用项目类型</th>
                                        <th class="sorting" data="p.input_uname">专家</th>
                                        <th>审批状态</th>
                                        <if condition="rolemenu(array('Product/addtpl'))">
                                        <th width="50" class="taskOptions">编辑</th>
                                        </if>
                                        <if condition="rolemenu(array('Product/deltpl'))">
                                        <th width="50" class="taskOptions">删除</th>
                                        </if>
                                    </tr>
                                    <foreach name="lists" item="row">
                                        <tr>
                                            <td>{$row.id}</td>
                                        
                                            <td><a href="{:U('Product/model_view', array('id'=>$row['id']))}" title="{$row.title}">{$row.title}</a></td>
                                           
                                            <td>{$row.dept}</td>
                                            
                                            <td>{$row.input_uname}</td>
                                            
                                            <?php 
                                            if($row['audit_status']== P::AUDIT_STATUS_NOT_AUDIT){
                                                $show  = '<td>等待审批</td>';	
                                            }else if($row['audit_status'] == P::AUDIT_STATUS_PASS){
                                                $show  = '<td><span class="green">通过</span></td>';	
                                            }else if($row['audit_status'] == P::AUDIT_STATUS_NOT_PASS){
                                                $show  = '<td><span class="red">不通过</span></td>';	
                                            }
                                            echo $show;
                                            ?>
                                            
                                            <if condition="rolemenu(array('Product/addtpl'))">
                                            <td class="taskOptions">
                                            <button onClick="javascript:window.location.href='{:U('Product/addtpl',array('id'=>$row['id']))}';" title="修改" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></button>
                                            </td>
                                            </if>
                                            <if condition="rolemenu(array('Product/deltpl'))">
                                            <td class="taskOptions">
                                            <button onClick="javascript:ConfirmDel('{:U('Product/deltpl',array('id'=>$row['id']))}')" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button>
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
                <input type="hidden" name="a" value="tpl">
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="key" placeholder="关键字">
                </div>
                
                <div class="form-group col-md-4">
                    <select  class="form-control"  name="status">
                        <option value="-1">状态</option>
                        <option value="0">未审批</option>
                        <option value="1">通过审批</option>
                        <option value="2">未通过审批</option>
                    </select>                   
                </div>
                <div class="form-group col-md-4">
                    <select class="form-control" name="bus">
                        <option value="0">适用项目类型</option>
                        <foreach name="business_depts" key="k" item="v">
                        <option value="{$k}">{$v}</option>
                        </foreach>
                    </select>
                </div>
                
               
                
                
                </form>
            </div>
<include file="Index:footer2" />
