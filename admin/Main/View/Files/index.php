<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>文件管理</h1>
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
                                    <div class="tip">
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
                                            <if condition="rolemenu(array('Files/copyfile'))">
                                                <a href="javascript:;" onClick="copyfile()"  class="btn btn-info" style="padding:6px 12px;"><i class="fa fa-copy"></i> 复制</a>
                                            </if>
                                        </div>
                                    
                                    
                                    </div>
                                    <div class="box-tools pull-right">
                                        <a href="javascript:;" class="btn btn-success btn-sm" onclick="javascript:opensearch('searchtext',400,120);"><i class="fa fa-search"></i> 搜索</a>
                                    	 <if condition="rolemenu(array('Files/mkdirs'))">
                                    	 <a href="javascript:;" class="btn btn-danger btn-sm" onclick="javascript:opensearch('mkdir',400,120,'创建文件夹');"><i class="fa fa-folder-open"></i> 创建文件夹</a>
                                         </if>
                                         <if condition="rolemenu(array('Files/upload'))">
                                         <!--<a href="javascript:;" class="btn btn-info btn-sm" onclick="uploadFile()"><i class="fa fa-upload"></i> 上传文件</a>-->
                                         <a href="{:U('Files/upload',array('pid'=>$pid,'level'=>$level))}" class="btn btn-info btn-sm"><i class="fa fa-upload"></i> 上传文件</a>
                                         </if>
                                         
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                <div class="fileRoute">
                                	<a href="{:U('Files/index')}" class="file_tips">首页</a>
                                    <foreach name="dir_path" item="v">
                                    &gt; <a href="{:U('Files/index',array('pid'=>$v['id']))}" class="file_tips">{$v.file_name}</a>
                                    </foreach>
                                </div>
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                    	<th width="40" style="text-align:center;"><input type="checkbox" id="accessdata"/></th>
                                        <th class="sorting" data="file_name">文件名称</th>
                                        <th width="100" class="sorting" data="file_type">文件类型</th>
                                        <th width="80" class="sorting" data="file_ext">文件格式</th>
                                        <th width="80" class="sorting" data="file_size">文件大小</th>
                                        <th width="100" class="sorting" data="est_user">创建者</th>
                                        <th width="160" class="sorting" data="est_time">创建时间</th>
                                        <if condition="rolemenu(array('Files/upd_file'))">
                                            <th width="80" class="taskOptions" data="">编辑文件</th>
                                        </if>
                                    </tr>
                                    <foreach name="datalist" item="row"> 
                                    <tr>
                                    	<td align="center">
                                        <input type="checkbox"  value="{$row.id}" class="accessdata" />
                                        </td>
                                        <td><a href="{$row.url}" {$row.target}>{$row.file_name}</a></td>
                                        <td>{$row.file_types}</td>
                                        <td><if condition="$row['file_ext']">{$row.file_ext}</if></td>
                                        <td><if condition="$row['file_size']">{:fsize($row['file_size'])}</if></td>
                                        <td>{$row.est_user}</td>
                                        <td>{$row.est_time|date='Y-m-d H:i:s',###}</td>
                                        <if condition="rolemenu(array('Files/upd_file'))">
                                            <td class="taskOptions">
                                                <if condition="$row['file_type'] eq 0">
                                                    <a href="javascript:edit_dir('/index.php?m=Main&c=Files&a=edit_dir&id='+{$row.id})" title="编辑" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
                                                    <else />
                                                    <a href="{:U('Files/upd_file',array('id'=>$row['id']))}" title="编辑" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
                                                </if>
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
            
            
            <div id="mkdir">
                <form method="post" action="{:U('Files/mkdirs')}" name="myform" id="gosub">
            	<input type="hidden" name="dosubmit"  value="1">
                <input type="hidden" name="pid" value="{$pid}">
                <input type="hidden" name="level" value="{$level}">
                <div class="form-group col-md-12">
                    <input type="text" class="form-control" name="filename" placeholder="文件夹名称">
                </div>
                </form>
            </div>

            <div id="searchtext">
                <form action="" method="get" id="searchform">
                    <input type="hidden" name="m" value="Main">
                    <input type="hidden" name="c" value="Files">
                    <input type="hidden" name="a" value="index">
                    <input type="hidden" name="pid" value="{$pid}">

                    <div class="form-group col-md-12">
                        <input type="text" class="form-control" name="filename" placeholder="请输入文件名称关键字">
                    </div>
                </form>
            </div>
           
            
            <script type="text/javascript">

			$(document).ready(function(e) {
				//选择
				$('#accessdata').on('ifChecked', function() {
					$('.accessdata').iCheck('check');
				});
				$('#accessdata').on('ifUnchecked', function() {
					$('.accessdata').iCheck('uncheck');
				});
			});
			
			
			
			//移动文件
			function movefile(){
				var fid = '';
				$('.accessdata').each(function(index, element) {
					var checked = $(this).parent().attr('aria-checked');
                    if(checked=='true'){
						fid += $(this).val() + '.';	
					}
                });	
				
				if(fid){
					//打开目录窗口
					art.dialog.open("index.php?m=Main&c=Files&a=movefile&fid="+fid,{
						lock:true,
						title: '移动至',
						width:500,
						height:500,
						okValue: '提交',
						fixed: true,
						ok: function () {
							var files = this.iframe.contentWindow.gosubmint();	
							//保存数据
							$.ajax({
				               type: "POST",
				               url: "<?php echo U('Files/move'); ?>",
							   dataType:'json', 
				               data: {files:files},
				               success:function(data){
									if(data.status==0){
										location.reload();
									}else{
										alert('保存数据失败');
									}
									
				               }
				           });
						},
						cancelValue:'取消',
						cancel: function () {
						}
					});	
				}else{
					alert('请选择要移动的文件');	
				}
			}
			
			
			//删除文件
			function delfile(){
				var fid = '';
				$('.accessdata').each(function(index, element) {
					var checked = $(this).parent().attr('aria-checked');
                    if(checked=='true'){
						fid += $(this).val() + '.';	
					}
                });
				
				if (confirm("真的要删除吗？")){
					//保存数据
					$.ajax({
		               type: "POST",
		               url: "<?php echo U('Files/delfile'); ?>",
					   dataType:'json', 
		               data: {fid:fid},
		               success:function(data){
							if(data.status==0){
								location.reload();
							}else{
								alert('删除失败');
							}
							
		               }
		           });
				}else{
					return false;
				}
	
				
			}

            //复制文件
            function copyfile(){
                var fid = '';
                $('.accessdata').each(function(index, element) {
                    var checked = $(this).parent().attr('aria-checked');
                    if(checked=='true'){
                        fid += $(this).val() + '.';
                    }
                });
                let n       = patch('.',fid);
                let newid   = del_last_str(fid,'.');
                let dir_ids = "{$dir_ids}".split(',');

                if (n < 1){ alert('没有选择文件'); return false; }
                if (n > 1){ alert('只能选择一个文件'); return false; }
                if (in_array(newid,dir_ids)){ alert('暂不支持文件夹复制'); return false; }

                if (confirm('确定要复制该文件吗?')){
                    //保存数据
                    $.ajax({
                        type: "POST",
                        url: "<?php echo U('Files/copyfile'); ?>",
                        dataType:'json',
                        data: {fid:newid},
                        success:function(data){
                            art_show_msg(data.msg,3);
                            if(data.num > 0){
                                setInterval(function () {
                                    window.location.reload();
                                }, 1500);
                            }
                        }
                    });
                }else{
                    return false;
                }
            }
			
			//配置权限
			function authfile(){
				var fid = '';
				$('.accessdata').each(function(index, element) {
					var checked = $(this).parent().attr('aria-checked');
                    if(checked=='true'){
						fid += $(this).val() + '.';	
					}
                });	
				
				if(fid){
					//打开目录窗口
					art.dialog.open("index.php?m=Main&c=Files&a=authfile&fid="+fid,{
						lock:true,
						title: '配置权限',
						width:1000,
						height:500,
						okValue: '提交',
						fixed: true,
						ok: function () {
							var files = this.iframe.contentWindow.gosubmint();	
							//保存数据
							$.ajax({
				               type: "POST",
				               url: "<?php echo U('Files/auth'); ?>",
							   dataType:'json', 
				               data: {files:files},
				               success:function(data){
									if(data.status==0){
										location.reload();
									}else{
										alert('保存数据失败');
									}
									
				               }
				           });
						},
						cancelValue:'取消',
						cancel: function () {
						}
					});	
				}else{
					alert('请选择要配置权限的文件');	
				}
			}
			
			
			//上传
			function uploadFile() {
				art.dialog.open("{:U('Files/upload',array('pid'=>$pid,'level'=>$level))}",{
					lock:true,
					title: '上传文件',
					width:800,
					height:500,
					okValue: '提交',
					fixed: true,
					ok: function () {
						
						//获取上传数据
						var files = this.iframe.contentWindow.gosubmint();	
						//保存数据
						$.ajax({
			               type: "POST",
			               url: "<?php echo U('Files/savefile'); ?>",
						   dataType:'json', 
			               data: {files:files},
			               success:function(data){
								if(data.status==0){
									location.reload();
								}else{
									alert('保存数据失败');
								}
								
			               }
			           });
					
					},
					cancelValue:'取消',
					cancel: function () {
					}
				});	
			}

			//编辑文件夹
            function edit_dir(obj) {
                art.dialog.open(obj, {
                    lock:true,
                    id:'audit_win',
                    title: '编辑文件夹',
                    width:500,
                    height:200,
                    okVal: '提交',
                    ok: function () {
                        this.iframe.contentWindow.gosubmint();
                        return false;
                    },
                    cancelVal:'取消',
                    cancel: function () {
                    }
                });
            }

			
			</script>

<include file="Index:footer2" />
