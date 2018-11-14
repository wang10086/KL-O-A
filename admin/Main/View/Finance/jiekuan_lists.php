<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>借款单</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="javascript:;"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">借款单</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">借款单列表</h3>
                                    <div class="box-tools pull-right">
                                    	 <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',600,160);"><i class="fa fa-search"></i> 搜索</a>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th class="sorting" width="180" data="j.jkd_id">借款单号</th>
                                        <th class="sorting" width="150" data="j.group_id">团号</th>
                                        <th class="sorting" data="o.project">项目名称</th>
                                        <th class="sorting" data="j.jk_user">借款人</th>
                                        <th class="sorting" width="80" data="j.sum">借款金额</th>
                                        <th class="sorting" data="j.zhuangtai">审批状态</th>
                                        <if condition="rolemenu(array('Finance/jiekuandan_info'))">
                                            <th width="40" class="taskOptions">详情</th>
                                        </if>
                                        <if condition="rolemenu(array('Finance/del_jkd'))">
                                            <th width="40" class="taskOptions">删除</th>
                                        </if>

                                    </tr>
                                    <foreach name="lists" item="row"> 
                                    <tr>
                                        <td>{$row.jkd_id}</td>
                                        <td>{$row.group_id}</td>
                                        <td><div class=""><a href="javascript:;" title="{$row.project}">{$row.project}</a></div></td>
                                        <td>{$row.jk_user}</td>
                                        <td>{$row.sum}</td>
                                        <td>{$row.zhuangtai}</td>
                                        <if condition="rolemenu(array('Finance/jiekuandan_info'))">
                                            <td class="taskOptions">
                                                <a href="{:U('Finance/jiekuandan_info',array('jkid'=>$row['id']))}" title="详情" class="btn btn-info btn-smsm"><i class="fa fa-bars"></i></a>
                                            </td>
                                        </if>
                                        <if condition="rolemenu(array('Finance/del_jkd'))">
                                            <td class="taskOptions">
                                                <button onClick="javascript:ConfirmDel('{:U('Finance/del_jkd',array('id'=>$row['id']))}')" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button>
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
                <input type="hidden" name="a" value="jiekuan_lists">

                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="title" placeholder="项目名称">
                </div>

                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="oid" placeholder="团号">
                </div>
                
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="jkdid" placeholder="借款单号">
                </div>
               	
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="ou" placeholder="借款人">
                </div>
                
                </form>
            </div>

<include file="Index:footer2" />
