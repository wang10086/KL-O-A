<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>品控巡检记录</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">巡检记录</h3>
                                    <div class="box-tools pull-right">
                                    	 <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',800,160);"><i class="fa fa-search"></i> 搜索</a>
                                         <if condition="rolemenu(array('Inspect/edit_ins'))">
                                         <a href="{:U('Inspect/edit_ins')}" class="btn btn-sm btn-danger"><i class="fa fa-plus"></i> 新记录</a>
                                         </if>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                
                                <!--
                                <div class="btn-group" id="catfont">
                               		<a href="{:U('Work/record',array('com'=>0))}" class="btn <?php if($com==0){ echo 'btn-info';}else{ echo 'btn-default';} ?>">所有人的</a>
                                    <a href="{:U('Work/record',array('com'=>1))}" class="btn <?php if($com==1){ echo 'btn-info';}else{ echo 'btn-default';} ?>">关于我的</a>
                                    <a href="{:U('Work/record',array('com'=>2))}" class="btn <?php if($com==2){ echo 'btn-info';}else{ echo 'btn-default';} ?>">我记录的</a>
                                </div>
                                -->
                                
                                <table class="table table-bordered dataTable fontmini" id="tablelist" >
                                    <tr role="row" class="orders" >
                                        <th class="sorting" width="40" data="id">编号</th>
                                        <th class="sorting" data="title">标题</th>
                                        <th class="sorting" data="ins_date">巡检日期</th>
                                        <th class="sorting" data="type">巡检类型</th>
                                        <th>巡检对象</th>
                                        <th class="sorting" data="liable_uname">责任人</th>
                                        <th class="sorting" data="problem">是否遇到问题</th>
                                        <th class="sorting" data="issolve">是否已解决</th>
                                        <th class="sorting" data="ins_uname">巡检人员</th>
                                        <if condition="rolemenu(array('Inspect/detail'))">
                                        <th width="40" class="taskOptions">详情</th>
                                        </if>
                                        <if condition="rolemenu(array('Inspect/edit_ins'))">
                                        <th width="40" class="taskOptions">编辑</th>
                                        </if>
                                    </tr>
                                    <foreach name="lists" item="row"> 
                                    <tr>
                                        <td>{$row.id}</td>
                                        <td><a href="{:U('Inspect/detail',array('insid'=>$row['id']))}">{$row.title}</a></td>
                                        <td>{$row.ins_date}</td>
                                        <td>{$row.type}</td>
                                        <td>{$row.duixiang}</td>
                                        <td>{$row.liable_uname}</td>
                                        <td>{$row.problem}</td>
                                        <td>{$row.issolve}</td>
                                        <td>{$row.ins_uname}</td>
                                        
                                        <if condition="rolemenu(array('Inspect/detail'))">
                                        <td class="taskOptions">
                                        <a href="{:U('Inspect/detail',array('insid'=>$row['id']))}" class="btn btn-success  btn-smsm"><i class="fa  fa-building-o"></i></a>
                                        </td>
                                        </if>
                                        
                                        <if condition="rolemenu(array('Inspect/edit_ins'))">
                                        <td class="taskOptions">
                                        <a href="{:U('Inspect/edit_ins',array('insid'=>$row['id']))}" title="修改" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
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
                <input type="hidden" name="c" value="Inspect">
                <input type="hidden" name="a" value="record">
                
                <div class="form-group col-md-12">
                    <input type="text" class="form-control" name="title" placeholder="标题">
                </div>
                
                <div class="form-group col-md-4">
                    <select class="form-control" name="type">
                        <option value="0">选择类型</option>
                        <foreach name="type" item="v" key="k">
                        <option value="{$k}">{$v}</option>
                        </foreach>
                    </select>
                </div>
                
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="dx" placeholder="巡检对象">
                </div>
                
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="uname" placeholder="巡检人员">
                </div>
                
                
                
                
                </form>
            </div>

<include file="Index:footer2" />
