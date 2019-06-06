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
                        <li><a href="{:U('Product/standard_product')}"><i class="fa fa-gift"></i> {$pageTitle}</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                            <!-- general form elements disabled -->
                            <form method="post" action="{:U('Product/public_save')}" name="myform" id="myform">
                			<input type="hidden" name="dosubmit" value="1">
                            <input type="hidden" name="savetype" value="1">
                			<input type="hidden" name="id" value="{$id}" >
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                    <div class="box-tools pull-right"> </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                        <div class="form-group col-md-8">
                                        <label>产品名称：</label>
                                             <input class="form-control" type="text" id="pname" name="name" value="{$row.name}" />
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>使用时间：</label>
                                            <select class="form-control" name="apply_time">
                                                <option value="" selected disabled>==请选择==</option>
                                                <foreach name="apply_times" key="k" item="v">
                                                    <option value="{$v}" <?php if ($pin == $k) echo 'selected'; ?>>{$v}</option>
                                                </foreach>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>价格：</label>
                                            <input class="form-control" type="text" name="info[price]" value="{$row.price}" />
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>适用人群</label>
                                            <foreach name="kindssss" key="k" item="v">
                                                <span class="lm_c"><input type="checkbox" name="kind[]" <?php if(in_array($v['id'],$pkind)){ echo 'checked';} ?>  value="{$v.id}"> {$v.name}</span>
                                            </foreach>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <span class="lm_c black">适用项目类型</span>
                                            <foreach name="kinds" key="k" item="v">
                                                <span class="lm_c"><input type="checkbox" name="kind[]" <?php if(in_array($v['id'],$pkind)){ echo 'checked';} ?>  value="{$v.id}"> {$v.name}</span>
                                            </foreach>
                                        </div>

                                        <!--<div class="form-group" style="padding: 0 15px;">
                                        <label style="width: 100%;">已选中产品：</label>
                                               <table id="flistmodel" class="table table-bordered" >
                                               <tr valign="middle">
                                                    <th style="text-align: center;" width="80">ID</th>
                                                    <th style="text-align: center;">产品名称</th>
                                                    <th style="text-align: center;">科学领域</th>
                                                    <th style="text-align: center;">适用年龄</th>
                                                    <th style="text-align: center;">操作</th>
                                                </tr>   
                                                
                                                <foreach name="pids" item="v">
                                                <tr id="pid_{$v.id}" valign="middle">
                                                    <td align="center">{$v.id}<input type="hidden" name="pids[]" value="{$v.id}" /></td>
                                                    <td align="center">{$v.title}</td>
                                                    <td align="center">{:C('SUBJECT_FIELD.'.$v['subject_field'])}</td>
                                                    <td align="center">{:C('AGE_LIST.'.$v['age'])}</td>
                                                    <td align="center"><a class="btn btn-danger btn-xs " href="javascript:;" onclick="removeLine('pid_{$v.id}');"><i class="fa fa-times"></i>删除</a></td>
                                                </tr> 
                                                
                                                </foreach> 
                                               
                                                </table>
                                                <a href="javascript:;" class="btn btn-success btn-sm" style="margin-top:15px;" onClick="selectmodel()">选择包含产品</a>
                                         </div>-->
	                            	</div>
                              </div><!-- /.box-body -->
                          
                              
                           </div><!-- /.box -->     
                           
                           
                           <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">上传附件</h3>
                                    
                                </div>
                                <div class="box-body">
                                    <div class="content">
                                    	<div class="form-group col-md-12">
                                            <table id="flist" class="table" style="margin-top:10px;">
                                                <foreach name="atts" item="v">
                                                <tr id="aid_{$v.id}" valign="middle"> 
                                                    <td><input type="text" name="newname[{$v.id}]" value="{$v.filename}" class="form-control"  /></td>
                                                    <td width="10%">{:fsize($v['filesize'])}</td>
                                                    <td width="30%">
                                                        <div class="progress sm"> 
                                                            <div class="progress-bar progress-bar-aqua" rel="aid_{$v.id}"  role="progressbar" style="width: 100%;"  aria-valuemin="0" aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td width="15%"><a class="btn btn-danger btn-xs " href="javascript:;" onclick="removeThisFile('aid_{$v.id}');"><i class="fa fa-times"></i>删除</a>&nbsp;&nbsp;&nbsp;&nbsp; <a class="btn btn-success btn-xs " href="{$v.filepath}" onclick=""><i class="fa fa-download"></i>下载</a></td>
                                                </tr>        
                                                </foreach>  
                                            </table>
                                             
                                            <a href="javascript:;" id="pickupfile" class="btn btn-success btn-sm"><i class="fa fa-upload"></i> 上传附件</a>
                                            <div id="container" style="display:none;">
                                                <foreach name="atts" item="v">
                                                <input type="hidden" rel="aid_{$v.id}" name="resfiles[]" value="{$v.id}" />
                                                </foreach>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                           <div class="box-footer clearfix">
                                <div style="width:100%; text-align:center;">
	                            <button type="submit" class="btn btn-info btn-lg" id="lrpd" onclick="return checkForm();">保存</button>
	                            </div>
                           </div>
                             
                          </form>
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                   
                </section><!-- /.content -->
                
            </aside><!-- /.right-side -->
			
  </div>
</div>

<include file="Index:footer2" />
<script type="text/javascript"> 

	//重新选择模板
	function selectmodel() {
		art.dialog.open('<?php echo U('Product/select_product'); ?>',{
			lock:true,
			title: '选择产品',
			width:860,
			height:500,
			okValue: '提交',
			fixed: true,
			ok: function () {
				var origin = artDialog.open.origin;
				var pro = this.iframe.contentWindow.gosubmint();
				var i=0;
				var str = "";
				for (i=0; i<pro.length; i++) {
					str = '<tr id="pid_'+ pro[i].id + '" valign="middle">'
		                +  '    <td align="center">' + pro[i].id + '<input type="hidden" name="pids[]" value="'+ pro[i].id +'" /></td>'
		                +  '    <td align="center">' + pro[i].title + '</td>'
		                +  '    <td align="center">' + pro[i].subject + '</td>'
		                +  '    <td align="center">' + pro[i].age + '</td>'
		                +  '    <td align="center"><a class="btn btn-danger btn-xs " href="javascript:;" onclick="removeLine(\'pid_' + pro[i].id + '\');"><i class="fa fa-times"></i>删除</a></td>'
		                +  '</tr>';  
                    $('#flistmodel').append(str);
				}
				
			},
			cancelValue:'取消',
			cancel: function () {
			}
		});	
	}

	function removeLine (s) {
        $('#' + s).empty().remove();
	}

	function checkForm() {
        if ($('#pname').val() == "") {
            alert('名称不能为空！');
            return false;
        }
        if ($('input[name^=pids]').length == 0) {
            alert('请至少选择一个产品!');
            return false;
        }
        return true;
	}
	
	
	$(document).ready(function() {	

		var uploader = new plupload.Uploader({
			runtimes : 'html5,flash,silverlight,html4',
			browse_button : 'pickupfile', // you can pass in id...
			container: document.getElementById('container'), // ... or DOM Element itself
			url : 'index.php?m=Main&c=File&a=upload_file',
			flash_swf_url : '__HTML__/comm/plupload/Moxie.swf',
			silverlight_xap_url : '__HTML__/comm/plupload/Moxie.xap',
			multiple_queues:false,
			multipart_params: {
                 catid: 1
			},
			
			filters : {
				max_file_size : '100mb',
				mime_types: [
					{title : "Files", extensions : "jpg,jpeg,png,zip,rar,7z,doc,docx,ppt,pptx,xls,xlsx,txt,pdf,pdfx"}
				]
			},

			init: {
				PostInit: function() {
					//$('div.moxie-shim').width(104).height(67);
				},

				FilesAdded: function(up, files) {
					plupload.each(files, function(file) {
						var time = new Date();
						var month = time.getMonth() +1;
						if (month < 10) month = "0" + month;
						
						var t = time.getFullYear()+ "/"+ month + "/" + time.getDate()+ " "+time.getHours()+ ":"+ time.getMinutes() + ":" +time.getSeconds();
						$('#flist').append(
								'<tr id="' + file.id + '"  valign="middle"><td>'
                                + '<input type="text" name="nm_' + file.id + '" value="'+ file.name +'" class="form-control" />'
								+ '</td> <td width="10%">' + plupload.formatSize(file.size) +'' 
								+ '</td> <td width="30%">' 
							    + '<div class="progress sm"> ' 
	                            + '<div class="progress-bar progress-bar-aqua" rel="'+ file.id +'"  role="progressbar"  aria-valuemin="0" aria-valuemax="100">' 
	                            + '</div></div></td>'
	                            + '<td width="15%"><a class="btn btn-danger btn-xs " href="javascript:;" onclick="removeThisFile(\''+ file.id +'\');"><i class="fa fa-times"></i>删除</a></td></tr>'
	                        );

					});

					uploader.start();
					
				},

				FileUploaded: function(up, file, res) {
					var rs = eval('(' + res.response +')');
					if (rs.rs ==  'ok') {
						$('div[rel=' + file.id + ']').css('width', '100%');
						$('#container').append('<input type="hidden" rel="'+file.id+'" name="resfiles[]" value="' + rs.aid + '" />');
                        $('input[name=nm_' + file.id +']').prop('name', 'newname['+rs.aid+']');
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
		if (confirm('确定要删除此附件吗？')) {
            $('#' + fid).empty().remove();
            $('input[rel=' + fid +']').remove();
		}
	}
	
	
	//新增物资
	function add_material(){
		var i = parseInt($('#material_val').text())+1;

		var html = '<div class="userlist" id="material_'+i+'"><span class="title"></span><input type="text" class="form-control longinput" name="material['+i+'][material]"><input type="text" class="form-control longinput" name="material['+i+'][spec]" value=""><input type="text" class="form-control amount" name="material['+i+'][amount]" value="1"><input type="text" class="form-control" name="material['+i+'][unitprice]"><input type="text" class="form-control longinput" name="material['+i+'][channel]" value=""><input type="text" class="form-control longinput" name="material['+i+'][remarks]"><a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox(\'material_'+i+'\')">删除</a></div>';
		$('#material').append(html);	
		$('#material_val').html(i);
		orderno();
	}
	
	//编号
	function orderno(){
		$('#mingdan').find('.title').each(function(index, element) {
            $(this).text(parseInt(index)+1);
        });
		$('#material').find('.title').each(function(index, element) {
            $(this).text(parseInt(index)+1);
        });	
	}
	
	//移除
	function delbox(obj){
		$('#'+obj).remove();
		orderno();
	}
</script>	


     


