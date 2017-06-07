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
                        <li><a href="{:U('Product/index')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                            <!-- general form elements disabled -->
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <form method="post" action="{:U('Product/addres')}" name="myform" id="myform">
                                        <input type="hidden" name="dosubmit" value="1" />
                                        <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
                                        <if condition="$row"><input type="hidden" name="id" value="{$row.id}" /></if>
                                        <!-- text input -->
                                        
                                        <div class="form-group col-md-12">
                                            <label>资源名称</label>
                                            <input type="text" name="info[title]" id="title" value="{$row.title}"  class="form-control" />
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>资源类型</label>
                                            <select  class="form-control"  name="info[kind]" required>
                                            <foreach name="kinds" item="v">
                                                <option value="{$v.id}" <?php if ($row && ($v['id'] == $row['kind'])) echo ' selected'; ?> >{$v.name}</option>
                                            </foreach>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>销售价</label>
                                            <input type="text" name="info[sales_price]" id="sales_price"   value="{$row.sales_price}" class="form-control" />
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>同行价</label>
                                            <input type="text" name="info[peer_price]" id="peer_price"   value="{$row.peer_price}" class="form-control" />
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>所在地区</label>
                                            <input type="text" name="info[diqu]" id="diqu"   value="{$row.diqu}" class="form-control" />
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>地址</label>
                                            <input type="text" name="info[address]" id="address"   value="{$row.address}" class="form-control" />
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>电话</label>
                                            <input type="text" name="info[tel]" id="tel" value="{$row.tel}"  class="form-control" />
                                        </div>
                                        
                                        
                                        
                                        <div class="form-group col-md-12">
                                            <label>介绍</label>
                                            <?php 
												 echo editor('content',$row['content']); 
												 ?>
                                        </div>
                                        
                                        <div class="form-group col-md-12">
                                        	<button type="submit" class="btn btn-success">保存</button>
                                        </div>
                                        
                                        <div class="form-group">&nbsp;</div>
                                        

                                    </form>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                </section><!-- /.content -->
                
            </aside><!-- /.right-side -->

  </div>
</div>

<script type="text/javascript"> 

	$(document).ready(function() {	

		$('#myform').validate();

		var uploader = new plupload.Uploader({
			runtimes : 'html5,flash,silverlight,html4',
			browse_button : 'pickupfile', // you can pass in id...
			container: document.getElementById('container'), // ... or DOM Element itself
			url : 'index.php?m=Util&c=File&a=upload_file',
			flash_swf_url : '__LIB__/plupload/Moxie.swf',
			silverlight_xap_url : '__LIB__/plupload/Moxie.xap',
			multiple_queues:false,
			
			filters : {
				max_file_size : '10mb',
				mime_types: [
					{title : "Files", extensions : "jpg,jpeg,png,zip,rar,7z,doc,docx,ppt,pptx,xls,xlsx"}
				]
			},

			init: {
				PostInit: function() {
					//$('div.moxie-shim').width(104).height(67);
				},

				FilesAdded: function(up, files) {
					plupload.each(files, function(file) {
						$('#flist').append(
								'<tr id="' + file.id + '"><td>' + file.name + '</td> <td width="10%">' + plupload.formatSize(file.size) 
								+ '</td> <td width="20%">' 
							    + '<div class="progress"> ' 
	                            + '<div class="progress-bar progress-bar-aqua" rel="'+ file.id +'"  role="progressbar"  aria-valuemin="0" aria-valuemax="100">' 
	                            + '</div></div></td>'
	                            + '<td width="10%"><a href="javascript:;" onclick="removeThisFile(\''+ file.id +'\');">删除</a></td></tr>'
	                        );

					});

					uploader.start();
					
				},

				FileUploaded: function(up, file, res) {
					var rs = eval('(' + res.response +')');
					if (rs.rs ==  'ok') {
						$('div[rel=' + file.id + ']').css('width', '100%');
						$('#container').append('<input type="hidden" rel="'+file.id+'" name="resfiles[]" value="' + file.name + '<&>' + rs.fileurl + '" />');

					} else {
	                    alert('上传文件失败，请重试');
					}

				},

				UploadProgress: function(up, file) {
                    $('div[rel=' + file.id + ']').css('width', file.percent + '%');
				},

				Error: function(up, err) {
					alert(err.code + ": " + err.message);
				}
			}
		});

		uploader.init();

	});

	function removeThisFile(fid) {
        $('#' + fid).empty().remove();
        $('input[rel=' + fid +']').remove();
	}

</script>	
            
<include file="Index:footer2" />