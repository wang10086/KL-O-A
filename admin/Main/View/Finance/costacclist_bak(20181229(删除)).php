<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>成本核算</h1>
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
                                    <h3 class="box-title">项目成本核算列表</h3>
                                    <div class="box-tools pull-right">
                                    	 <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',600,160);"><i class="fa fa-search"></i> 搜索</a>
                                         
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th class="sorting" data="op_id">编号</th>
                                        <th class="sorting" data="project" >项目名称</th>
                                        <th class="sorting" data="number">预计人数</th>
                                        <th class="sorting" data="costacc">成本价格</th>
                                        <th class="sorting" data="costacc_min_price">最低报价</th>
                                        <th class="sorting" data="costacc_max_price">最高报价</th>
                                        <th class="sorting" data="create_user_name">创建者</th>
                                        <if condition="rolemenu(array('Finance/costacc'))">
                                        <th width="50" class="taskOptions">跟进</th>
                                        </if>
                                        
                                    </tr>
                                    <foreach name="lists" item="row"> 
                                    <tr>
                                        <td>{$row.op_id}</td>
                                       
                                        <td><a href="{:U('Finance/costacc',array('opid'=>$row['op_id']))}" title="{$row.project}">{$row.project}</a></td>
                                        <td>{$row.number}人</td>
                                        <td>&yen; {$row.costacc}</td>
                                        <td>&yen; {$row.costacc_min_price}</td>
                                        <td>&yen;{$row.costacc_max_price}</td>
                                        <td>{$row.create_user_name}</td>
                                        <if condition="rolemenu(array('Finance/costacc'))">
                                        <td class="taskOptions">
                                        <a href="{:U('Finance/costacc',array('opid'=>$row['op_id']))}" title="详情" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
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
                <input type="hidden" name="a" value="costacclist">
                
                <div class="form-group col-md-12">
                    <input type="text" class="form-control" name="title" placeholder="项目名称">
                </div>
                
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="opid" placeholder="项目编号">
                </div>
                
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="oid" placeholder="项目团号">
                </div>
                
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="cname" placeholder="创建者">
                </div>
               
                
                </form>
            </div>

<include file="Index:footer2" />
