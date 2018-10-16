<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>文件审批</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Files/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Approval/Approval_Index')}">文件审批</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <div class="tip">
                                        <a href="javascript:;" onClick="delfile()"  class="btn btn-danger" style="padding:6px 12px;"><i class="fa fa-trash-o"></i> 删除</a>
                                        <a href="{:U('Approval/Approval_Upload')}" class="btn btn-info btn-sm"><i class="fa fa-upload"></i> 上传文件</a>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                <div class="fileRoute">
                                	<a href="{:U('Files/index')}" class="file_tips">首页</a>
                                    <foreach name="dir_path" item="v">
                                    &gt; <a href="{:U('Approval/Approval_Index')}" class="file_tips">文件审批</a>
                                    </foreach>
                                </div>
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >

                                    	<th style="text-align:center;width:6em;"><input type="checkbox" id="Approval_checkbox"/></th>
                                        <th style="text-align:center;width:10em;"><b>拟稿人姓名</b></th>
                                        <th style="text-align:center;width:10em;"><b>单位部门</b></th>
                                        <th style="text-align:center;width:10em;"><b>文件名称</b></th>
                                        <th style="text-align:center;width:10em;"><b>创建时间</b></th>
                                        <th style="text-align:center;width:10em;"><b>文件格式</b></th>
                                        <th style="text-align:center;width:10em;"><b>文件页码</b></th>
                                        <th style="text-align:center;width:10em;"><b>操作</b></th>
                                    </tr>
                                    <tr>
                                    	<td align="center">
                                            <input type="checkbox"  value="" class="Approval_checkbox" />
                                        </td>
                                        <td style="text-align:center;color:#3399FF;">刘金垒</td>
                                        <td style="text-align:center;">天龙八部</td>
                                        <td style="text-align:center;">人生理想空谈</td>
                                        <td style="text-align:center;">208809</td>
                                        <td style="text-align:center;">docx</td>
                                        <td style="text-align:center;">5</td>
                                        <td style="text-align:center;"><a href="">查看</a></td>
                                    </tr>

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
            
            
           
            
            <script type="text/javascript">
                $('#Approval_checkbox').click(function(){
                    $('.Approval_checkbox').each(){

                    }
                })


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


			</script>

<include file="Index:footer2" />
