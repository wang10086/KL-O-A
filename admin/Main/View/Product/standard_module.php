<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        {$pageTitle}
                        <small>{$_pagedesc_}</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Product/standard_module')}"><i class="fa fa-gift"></i> {$pageTitle}</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                    <div class="box-tools pull-right">
                                    	<a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',600,160);"><i class="fa fa-search"></i> 搜索</a>
                                        <a href="{:U('Product/add_standard_module')}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> 新建标准化模块</a>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th class="sorting" data="p.id">ID</th>
                                        <th width="200" class="sorting" data="p.title">模块名称</th>
                                        <th class="sorting" data="p.type">类别</th>
                                        <th class="sorting" data="p.subject_field" style="width: 100px;">科学领域</th>
                                        <th class="sorting" data="p.from">来源</th>
                                        <th class="sorting" data="p.age">适用年龄</th>
                                        <th class="sorting">参考单价</th>
                                        <th class="sorting" data="p.sales_price">参考成本价</th>
                                        <th class="sorting" data="p.input_uname">研发人员</th>
                                        <th>审批状态</th>
                                        
                                        <if condition="rolemenu(array('Product/add'))">
                                        <th width="50" class="taskOptions">编辑</th>
                                        </if>
                                        <if condition="rolemenu(array('Product/del'))">
                                        <th width="50" class="taskOptions">删除</th>
                                        </if>
                                    </tr>
                                    <foreach name="lists" item="row">
                                        <tr>
                                            <td>{$row.id}</td>
                                            <td><div style="width:200px;"><a href="{:U('Product/view', array('id'=>$row['id']))}" title="{$row.title}">{$row.title}</a></div></td>
                                            <td>{$ptype[$row['type']]}</td>
                                            <td>{$subject_fields[$row[subject_field]]}</td>
                                            <td>{$pfrom[$row['from']]}</td>
                                            <td>{$row['in_ages']}</td>
                                            <td>
                                                <?php if ($pro){ ?>
                                                    {$reckon_mode[$row[reckon_mode]]}
                                                <?php }else{ ?>
                                                    {$row['dept']}
                                                <?php } ?>
                                            </td>
                                            <td>{$row.sales_price}</td>
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
                                            
                                            <if condition="rolemenu(array('Product/add'))">
                                            <td class="taskOptions">
                                            <button onClick="javascript:window.location.href='{:U('Product/add_standard_module',array('id'=>$row['id']))}';" title="修改" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></button>
                                            </td>
                                            </if>
                                            <if condition="rolemenu(array('Product/del'))">
                                            <td class="taskOptions">
                                            <button onClick="javascript:ConfirmDel('{:U('Product/del',array('id'=>$row['id']))}')" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button>
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
                <input type="hidden" name="a" value="standard_module">
                <input type="hidden" name="pro" value="{$pro}">
                <div class="form-group col-md-12">
                    <input type="text" class="form-control" name="key" placeholder="关键字">
                </div>
                
                <div class="form-group col-md-6">
                    <select class="form-control" name="type">
                        <option value="">类别</option>
                        <foreach name="ptype" key="k" item="v">
                        <option value="{$k}">{$v}</option>
                        </foreach>
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <select class="form-control" name="subject_field">
                        <option value="">领域</option>
                        <foreach name="subject_fields" key="k" item="v">
                            <option value="{$k}">{$v}</option>
                        </foreach>
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <select class="form-control" name="from">
                        <option value="">来源</option>
                        <foreach name="pfrom" key="k" item="v">
                            <option value="{$k}">{$v}</option>
                        </foreach>
                    </select>
                </div>
                
                <div class="form-group col-md-6">
                    <select class="form-control" name="age">
                        <option value="">适用年龄</option>
                        <foreach name="ages" key="k" item="v">
                        <option value="{$k}">{$v}</option>
                        </foreach>
                    </select>
                </div>
                
                </form>
            </div>
<include file="Index:footer2" />
