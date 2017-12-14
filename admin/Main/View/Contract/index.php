<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        {$_pagetitle_}
                        <small>{$_pagedesc_}</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Contract/index')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
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
                                    	 <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',600,160);"><i class="fa fa-search"></i> 搜索</a>
                                         <a href="{:U('Contract/add')}" class="btn btn-sm btn-danger"><i class="fa fa-plus"></i> 新建合同</a>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                	<table class="table table-bordered dataTable fontmini" id="tablelist">
                                        <tr role="row" class="orders" >
                                        	<th class="sorting" data="c.pro_name">项目名称</th>
                                            <th class="sorting" data="c.group_id" width="120">团号</th>
                                            <th class="sorting" data="c.dep_time" width="120">出团时间</th>
                                            <th class="sorting" data="c.number" width="80">人数</th>
                                         	<th class="sorting" data="c.contract_amount" width="100">合同金额</th>
                                            <th class="sorting" data="c.income_amount" width="100">回款金额</th>
                                            <th class="sorting" data="c.contract_id" width="120">合同编号</th>
                                            <th class="sorting" data="c.status" width="80">确认状态</th>
                                            <th class="sorting" data="c.create_time" width="120">创建时间</th>
                                            <th class="sorting" data="c.create_user_name" width="100">创建者</th>
                                            <if condition="rolemenu(array('Contract/detail'))">
                                            <th width="60" class="taskOptions">详情</th>
                                            </if>
                                            <if condition="rolemenu(array('Contract/add'))">
                                            <th width="60" class="taskOptions">编辑</th>
                                            </if>
                                            <!-- 
                                            <if condition="rolemenu(array('Contract/del'))">
                                            <th width="60" class="taskOptions">删除</th>
                                            </if> 
                                            -->
                                        </tr>
                                        <foreach name="lists" item="row">                      
                                        <tr>
                                            <td><a href="{:U('Contract/detail', array('id'=>$row['id']))}">{$row.pro_name}</a></td>
                                            <td>{$row.group_id}</td>
                                            <td>{$row.dep_time}</td>
                                            <td>{$row.number}</td>
                                            <td>{$row.contract_amount}</td>
                                            <td>{$row.huikuan}</td>
                                            <td>{$row.contract_id}</td>
                                            <td>{$row.strstatus}</td>
                                            <td>{$row.create_time|date='y-m-d H:i',###}</td>
                                            <td>{$row.create_user_name}</td>
                                            <if condition="rolemenu(array('Contract/detail'))">
                                            <td class="taskOptions">
                                            <button onClick="javascript:window.location.href='{:U('Contract/detail',array('id'=>$row['id']))}';" title="详情" class="btn btn-success  btn-smsm"><i class="fa  fa-building-o"></i></button>
                                            </td>
                                            </if>
                                            <if condition="rolemenu(array('Contract/add'))">
                                            <td class="taskOptions">
                                            <button onClick="javascript:window.location.href='{:U('Contract/add',array('id'=>$row['id']))}';" title="修改" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></button>
                                            </td>
                                            </if>
                                            <!--
                                            <if condition="rolemenu(array('Contract/del'))">
                                            <td class="taskOptions">
                                            <button onClick="javascript:ConfirmDel('{:U('Contract/del',array('id'=>$row['id']))}')" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button>
                                            </td>
                                            </if>
                                            -->
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

        <include file="Index:footer2" />
        
        <div id="searchtext">
            <form action="" method="get" id="searchform">
            <input type="hidden" name="m" value="Main">
            <input type="hidden" name="c" value="Contract">
            <input type="hidden" name="a" value="index">
            <div class="form-group col-md-4">
                <input type="text" class="form-control" name="key" placeholder="关键字">
            </div>
            
           
            
            <div class="form-group col-md-4">
                <input type="text" class="form-control" name="gid" placeholder="项目团号">
            </div>
            
            <div class="form-group col-md-4">
                 <input type="text" class="form-control" name="opid" placeholder="项目编号">
            </div>
            
            </form>
        </div>
        <script type="text/javascript">
                function openform(obj){
                    art.dialog.open(obj,{
                        lock:true,
                        id:'respriv',
                        title: '权限分配',
                        width:600,
                        height:300,
                        okValue: '提交',
                        ok: function () {
                            this.iframe.contentWindow.myform.submit();
                            return false;
                        },
                        cancelValue:'取消',
                        cancel: function () {
                        }
                    });	
                } 
        </script>