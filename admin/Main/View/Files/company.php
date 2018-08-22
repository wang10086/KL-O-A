<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>公司管理手册</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Files/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <foreach name="dir_path" item="v">
                        <li><a href="{:U('Files/index',array('pid'=>$v['id']))}">{$v.file_name}</a></li>
                        </foreach>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">部门职责</h3>
                                    <!--<div class="tip">
                                    	<div  id="catfont">
                                            <if condition="rolemenu(array('Files/movefile'))">
                                            <a href="javascript:;" onClick="movefile()" class="btn btn-success" style="padding:6px 12px;"><i class="fa fa-random"></i> 移动</a>
                                            </if>
                                            <if condition="rolemenu(array('Files/authfile'))">
                                            <a href="javascript:;" onClick="authfile()"  class="btn btn-warning" style="padding:6px 12px;"><i class="fa fa-unlock-alt"></i> 权限</a>
                                            </if>
                                            <if condition="rolemenu(array('Files/delfile'))">
                                            <a href="javascript:;" onClick="delfile()"  class="btn btn-danger" style="padding:6px 12px;"><i class="fa fa-trash-o"></i> 删除</a>
                                            </if>
                                        </div>
                                    </div>-->

                                    <!--<div class="box-tools pull-right">
                                    	 <if condition="rolemenu(array('Files/mkdirs'))">
                                    	 <a href="javascript:;" class="btn btn-danger btn-sm" onclick="javascript:opensearch('mkdir',400,120,'创建文件夹');"><i class="fa fa-folder-open"></i> 创建文件夹</a>
                                         </if>
                                         <if condition="rolemenu(array('Files/upload'))">
                                         <a href="javascript:;" class="btn btn-info btn-sm" onclick="uploadFile()"><i class="fa fa-upload"></i> 上传文件</a>
                                         </if>
                                    </div>-->
                                </div><!-- /.box-header -->

                                <div class="box-body">
                                <!--<div class="fileRoute">
                                	<a href="{:U('Files/index')}" class="file_tips">文件管理</a>
                                    <foreach name="dir_path" item="v">
                                    &gt; <a href="{:U('Files/index',array('pid'=>$v['id']))}" class="file_tips">{$v.file_name}</a>
                                    </foreach>
                                </div>-->
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                    	<th width="40" style="text-align:center;">ID</th>
                                        <th class="sorting" data="file_name">文件名称</th>
                                        <th width="100" class="sorting" data="file_type">文件类型</th>
                                        <th width="100" class="sorting" data="file_ext">文件格式</th>
                                        <th width="100" class="sorting" data="file_size">文件大小</th>
                                        <th width="100" class="sorting" data="est_user">创建者</th>
                                        <th width="160" class="sorting" data="est_time">创建时间</th>
                                    </tr>
                                    <foreach name="datalist" item="row"> 
                                    <tr>
                                    	<td align="center">{$row.id}</td>
                                        <td><a href="{$row.url}" {$row.target}>{$row.file_name}</a></td>
                                        <td>{$row.file_type}</td>
                                        <td><if condition="$row['file_ext']">{$row.file_ext}</if></td>
                                        <td><if condition="$row['file_size']">{:fsize($row['file_size'])}</if></td>
                                        <td>{$row.est_user}</td>
                                        <td>{$row.est_time|date='Y-m-d H:i:s',###}</td>
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

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">岗位说明</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                        <tr role="row" class="orders" >
                                            <th width="40" style="text-align:center;">ID</th>
                                            <th class="sorting" data="file_name">文件名称</th>
                                            <th width="100" class="sorting" data="file_type">文件类型</th>
                                            <th width="100" class="sorting" data="file_ext">文件格式</th>
                                            <th width="100" class="sorting" data="file_size">文件大小</th>
                                            <th width="100" class="sorting" data="est_user">创建者</th>
                                            <th width="160" class="sorting" data="est_time">创建时间</th>
                                        </tr>
                                        <foreach name="datalist" item="row">
                                            <tr>
                                                <td align="center">{$row.id}</td>
                                                <td><a href="{$row.url}" {$row.target}>{$row.file_name}</a></td>
                                                <td>{$row.file_type}</td>
                                                <td><if condition="$row['file_ext']">{$row.file_ext}</if></td>
                                                <td><if condition="$row['file_size']">{:fsize($row['file_size'])}</if></td>
                                                <td>{$row.est_user}</td>
                                                <td>{$row.est_time|date='Y-m-d H:i:s',###}</td>
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

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">相关规程</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                        <tr role="row" class="orders" >
                                            <th width="40" style="text-align:center;">ID</th>
                                            <th class="sorting" data="file_name">文件名称</th>
                                            <th width="100" class="sorting" data="file_type">文件类型</th>
                                            <th width="100" class="sorting" data="file_ext">文件格式</th>
                                            <th width="100" class="sorting" data="file_size">文件大小</th>
                                            <th width="100" class="sorting" data="est_user">创建者</th>
                                            <th width="160" class="sorting" data="est_time">创建时间</th>
                                        </tr>
                                        <foreach name="datalist" item="row">
                                            <tr>
                                                <td align="center">{$row.id}</td>
                                                <td><a href="{$row.url}" {$row.target}>{$row.file_name}</a></td>
                                                <td>{$row.file_type}</td>
                                                <td><if condition="$row['file_ext']">{$row.file_ext}</if></td>
                                                <td><if condition="$row['file_size']">{:fsize($row['file_size'])}</if></td>
                                                <td>{$row.est_user}</td>
                                                <td>{$row.est_time|date='Y-m-d H:i:s',###}</td>
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

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">相关制度</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                        <tr role="row" class="orders" >
                                            <th width="40" style="text-align:center;">ID</th>
                                            <th class="sorting" data="file_name">文件名称</th>
                                            <th width="100" class="sorting" data="file_type">文件类型</th>
                                            <th width="100" class="sorting" data="file_ext">文件格式</th>
                                            <th width="100" class="sorting" data="file_size">文件大小</th>
                                            <th width="100" class="sorting" data="est_user">创建者</th>
                                            <th width="160" class="sorting" data="est_time">创建时间</th>
                                        </tr>
                                        <foreach name="datalist" item="row">
                                            <tr>
                                                <td align="center">{$row.id}</td>
                                                <td><a href="{$row.url}" {$row.target}>{$row.file_name}</a></td>
                                                <td>{$row.file_type}</td>
                                                <td><if condition="$row['file_ext']">{$row.file_ext}</if></td>
                                                <td><if condition="$row['file_size']">{:fsize($row['file_size'])}</if></td>
                                                <td>{$row.est_user}</td>
                                                <td>{$row.est_time|date='Y-m-d H:i:s',###}</td>
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
