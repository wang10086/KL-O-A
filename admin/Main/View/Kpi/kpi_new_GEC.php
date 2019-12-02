<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>客户管理</h1>
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
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                    <div class="box-tools pull-right">
                                    	 <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',400,120);"><i class="fa fa-search"></i> 搜索</a>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th width="60" data="id">ID</th>
                                        <th data="company_name">单位名称</th>
                                        <th data="contacts">联系人</th>
                                        <th data="contacts_phone">联系电话</th>
                                        <!--<th data="province">所在地</th>-->
                                        <th data="cm_id">维护人</th>
                                        <th>项目数</th>
                                        <th>项目记录</th>
                                        <th>结算收入</th>
                                    </tr>
                                    <foreach name="lists" item="row"> 
                                    <tr>
                                        <td>{$row.id}</td>
                                        <td><a href="{:U('Customer/GEC_viwe',array('id'=>$row['id']))}" title="详情">{$row.company_name}</a></td>
                                        <td>{$row.contacts}</td>
                                        <td>{$row.contacts_phone}</td>
                                        <!--<td>{$row.province} {$row.city} {$row.county}</td>-->
                                        <td>{$row.cm_name}</td>
                                        <td>{$row.}</td>
                                        <td>{$row.}</td>
                                        <td>{$row.}</td>
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
                <input type="hidden" name="c" value="Kpi">
                <input type="hidden" name="a" value="public_kpi_new_GEC">
                
                <div class="form-group col-md-12"></div>
                <div class="form-group col-md-12">
                    <input type="text" class="form-control" name="keywords" placeholder="客户名称关键字">
                </div>
                </form>
            </div>
			
			<include file="Index:footer2" />

