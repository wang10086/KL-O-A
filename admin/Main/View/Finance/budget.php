<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>项目预算</h1>
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
                                    <h3 class="box-title">项目预算列表</h3>
                                    <div class="box-tools pull-right">
                                    	 <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',700,160);"><i class="fa fa-search"></i> 搜索</a>
                                         
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th class="sorting" data="op_id">编号</th>
                                        <th class="sorting" data="group_id">团号</th>
                                        <th class="sorting" data="project">项目名称</th>
                                        <th class="sorting" data="number">人数</th>
                                        <th class="sorting" data="shouru">预计收入</th>
                                        <th class="sorting" data="maoli">毛利</th>
                                        <th class="sorting" data="maolilv">毛利率</th>
                                        <th class="sorting" data="renjunmaoli">人均毛利</th>
                                        <th class="sorting" data="xinzhi">交付性质</th>
                                        <th class="sorting" data="create_user_name">创建者</th>
                                        <th class="sorting" data="audit_status">状态</th>
                                        <if condition="rolemenu(array('Finance/op'))">
                                        <th width="50" class="taskOptions">跟进</th>
                                        </if>
                                        
                                    </tr>
                                    <foreach name="lists" item="row"> 
                                    <tr>
                                        <td>{$row.op_id}</td>
                                        <td>{$row.group_id}</td>
                                        <td><div class="tdbox_long"><a href="{:U('Finance/op',array('opid'=>$row['op_id']))}" title="{$row.project}">{$row.project}</a></div></td>
                                        <td>{$row.number}人</td>
                                        <td>&yen; {$row.shouru}</td>
                                        <td>&yen; {$row.maoli}</td>
                                        <td>{$row.maolilv}</td>
                                        <td>&yen; {$row.renjunmaoli}</td>
                                        
                                        <td>{$row.xinzhi}</td>
                                        <td>{$row.create_user_name}</td>
                                        <td>{$row.budget_audit_status}</td>
                                        <if condition="rolemenu(array('Finance/op'))">
                                        <td class="taskOptions">
                                        <a href="{:U('Finance/op',array('opid'=>$row['op_id']))}" title="详情" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
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
                <input type="hidden" name="c" value="Finance">
                <input type="hidden" name="a" value="budget">
                
                <div class="form-group col-md-12">
                    <input type="text" class="form-control" name="title" placeholder="项目名称">
                </div>
                
                <div class="form-group col-md-3">
                    <select  class="form-control"  name="as">
                         <option value="-1">状态</option>
                        <option value="0">未审批</option>
                        <option value="1">通过审批</option>
                        <option value="2">未通过审批</option>
                    </select>                   
                </div>
                
                <div class="form-group col-md-3">
                    <input type="text" class="form-control" name="oid" placeholder="项目编号">
                </div>
                
                <div class="form-group col-md-3">
                    <input type="text" class="form-control" name="oid" placeholder="项目团号">
                </div>
                
                <div class="form-group col-md-3">
                    <input type="text" class="form-control" name="ou" placeholder="立项人">
                </div>
               
                
                </form>
            </div>

<include file="Index:footer2" />
