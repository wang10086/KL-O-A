<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>财务审批</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="javascript:;"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">团内支出借款</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">团内支出借款</h3>
                                    <div class="box-tools pull-right">
                                    	 <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',600,160);"><i class="fa fa-search"></i> 搜索</a>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th class="sorting" width="80" data="o.op_id">编号</th>
                                        <th class="sorting" width="150" data="o.status">团号</th>
                                        <th class="sorting" data="o.project">项目名称</th>
                                        <th class="sorting" data="o.kind">类型</th>
                                        <th class="sorting" width="80" data="a.jidiao">计调</th>
                                        <th class="sorting" width="80" data="o.create_user_name">创建者</th>
                                        <th class="sorting" data="o.audit_status">状态</th>
                                        <if condition="rolemenu(array('Finance/jk_detail'))">
                                        <th width="40" class="taskOptions">借款</th>
                                        </if>

                                    </tr>
                                    <foreach name="lists" item="row"> 
                                    <tr>
                                        <td>{$row.op_id}</td>
                                        <td><?php if($row['status']==1){ echo "<span class='green'>".$row['group_id']."</span>";}elseif($row['status']==2){ echo "<span class='red' title='".$row['nogroup']."'>不成团</span>";}else{ echo '未成团';} ?></td>
                                        <td><div class="tdbox_long"><a href="javascript:;" title="{$row.project}">{$row.project}</a></div></td>
                                        <td><div class="tdbox_long" style="width:80px" title="<?php echo $kinds[$row['kind']]; ?>"><?php echo $kinds[$row['kind']]; ?></div></td>
                                        <td>{$row.jidiao}</td>
                                        <td>{$row.create_user_name}</td>
                                        <td>{$row.zhuangtai}</td>
                                        <if condition="rolemenu(array('Finance/jk_detail'))">
                                        <td class="taskOptions">
                                        <a href="{:U('Finance/jk_detail',array('opid'=>$row['op_id']))}" title="借款" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
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
                <input type="hidden" name="a" value="jiekuan">

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
