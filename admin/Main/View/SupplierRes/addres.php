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
                        <li><a href="{:U('SupplierRes/res')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                            <!-- general form elements disabled -->
                            <form method="post" action="{:U('SupplierRes/addres')}" name="myform" id="myform" onsubmit="return submitBefore()">
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                </div><!-- /.box-header -->
                                <div class="form-group col-md-12 mt10">
                                    <div class="callout callout-danger mb-0">
                                        <h4>提示！</h4>
                                        <p>1、供方名称应完整、准确，否则影响报销事项！</p>
                                        <p>2、“供方分类”应准确，否则影响结算时对供方选择！</p>
                                    </div>
                                </div>

                                <div class="box-body">
                                    <input type="hidden" name="dosubmit" value="1" />
                                    <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
                                    <if condition="$row"><input type="hidden" name="id" value="{$row.id}" /></if>
                                    <!-- text input -->
                                    
                                    <div class="form-group col-md-8">
                                        <label>供方名称</label>
                                        <input type="text" name="info[name]" id="title" value="{$row.name}"  class="form-control" required />
                                    </div>
                                    
                                    <div class="form-group col-md-4">
                                        <label>供方分类</label>
                                        <select  class="form-control"  name="info[kind]" required>
                                        <foreach name="kinds" item="v">
                                            <option value="{$v.id}" <?php if ($row && ($v['id'] == $row['kind'])) echo ' selected'; ?> >{$v.name}</option>
                                        </foreach>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group col-md-4">
                                        <label>国家</label>
                                        <input type="text" name="info[country]" id="country"   value="{$row.country}" class="form-control" required />
                                    </div>
                                    
                                    <div class="form-group col-md-4">
                                        <label>省份</label>
                                        <input type="text" name="info[prov]" id="prov"   value="{$row.prov}" class="form-control" required />
                                    </div>
                                    
                                    <div class="form-group col-md-4">
                                        <label>所在城市</label>
                                        <input type="text" name="info[city]" id="city"   value="{$row.city}" class="form-control" required />
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>联系人</label>
                                        <input type="text" name="info[contact]" id="contact"   value="{$row.contact}" class="form-control" required />
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>联系电话</label>
                                        <input type="text" name="info[tel]" id="tel" value="{$row.tel}"  class="form-control" required />
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>供方级别</label>
                                        <select name="info[type]" class="form-control" <?php if (!rolemenu(array('SupplierRes/edit_res_type'))){ echo "disabled"; } ?>>
                                            <option value="1" <?php if ($row['type']==1) echo "selected"; ?>>普通供方</option>
                                            <option value="2" <?php if ($row['type']==2) echo "selected"; ?>>合格供方</option>
                                            <option value="3" <?php if ($row['type']==3) echo "selected"; ?>>集中采购方</option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group col-md-12">
                                        <label>介绍</label>
                                        <?php 
                                             echo editor('content',$row['desc']); 
                                             ?>
                                    </div>
                                    
                                   
                                    <div class="form-group">&nbsp;</div>
                                    

                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            <div id="formsbtn">
                            	<button type="submit" class="btn btn-info btn-lg" id="lrpd">保存</button>
                            </div>
                            </form>
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                </section><!-- /.content -->
                
            </aside><!-- /.right-side -->

  </div>
</div>

<script type="text/javascript"> 

	$(document).ready(function() {	

		//$('#myform').validate();

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

    function submitBefore() {
        $("select[name='info[type]']").attr('disabled',false);
    }

</script>	
            
<include file="Index:footer2" />