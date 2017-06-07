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
                        <li><a href="{:U('Project/index')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                        
      					<form role="form" method="post" action="{:U('Product/addres')}" name="myform" id="myform">        
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                    <div class="box-tools pull-right">
                                         
                                    </div>
                                </div><!-- /.box-header -->
                                 <div class="box-body">
                       
        
        <input type="hidden" name="dosubmit" value="1" />
        <if condition="$row">
        <input type="hidden" name="id" value="{$row.id}" />
        </if>
        <input type="hidden" name="info[type]" value="<?php echo Sys\P::RES_TYPE_PRODUCT; ?>" />
         
         <div class="form-group hr">
                <label>名称：</label>
                <div class="hr-group">
                    <input type="text" class="form-control" name="info[name]" value="{$row.name}" required />
                </div>
            </div>
         
         
         <div class="form-group hr">
                <label>资源分类：</label>
                <div class="hr-group">
                   <select  class="form-control"  name="info[kind]" required>
                    <foreach name="kinds" item="v">
                        <option value="{$v.id}" <?php if ($row && ($v['id'] == $row['kind'])) echo ' selected'; ?> >{$v.name}</option>
                    </foreach>
                    </select>      
                </div>
          </div>
            
            
        <div class="form-group hr">
            <label>资源描述：</label>
            <div class="hr-group">
                <textarea name="info[desc]" class="form-control" >{$row['desc']}</textarea>
            </div>
        </div>
       
        
        <div class="form-group hr">
            <label>上传文件：</label>
            <div class="hr-group">
                
                
                   <table id="flist" class="table">
                   
                   
                   
                   </table>
                 
                  <a href="javascript:;" id="pickupfile" class="btn btn-default "><i class="fa fa-upload"></i> 点击上传新文件</a>
                  <div id="container"></div>
            </div>
        </div>   
            
        
        </div><!-- /.box-body -->
        <div class="box-footer">
        <div class="form-group">
            <input type="submit" value="保存" class="btn btn-primary add-left-space" />
        </div>
        </div>
                 </div><!-- /.box -->
     </form>
                        </div><!-- /.col -->

          
                     </div>

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