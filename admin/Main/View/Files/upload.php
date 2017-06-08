<?php use Sys\P; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo P::SYSTEM_NAME; ?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="__HTML__/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="__HTML__/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="__HTML__/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- jquery-ui style -->
        <link href="__HTML__/css/jQueryUI/jquery-ui-1.10.3.custom.min.css" rel="stylesheet" type="text/css" />
        <!-- ArtDialog -->
        <link href="__HTML__/css/artDialog.css" rel="stylesheet" type="text/css"  />
        <link href="__HTML__/css/artdialog/ui-dialog.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="__HTML__/css/py.css" rel="stylesheet" type="text/css" />
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="__HTML__/js/html5shiv.min.js"></script>
          <script src="__HTML__/js/respond.min.js"></script>
        <![endif]-->
        <?php echo PHP_EOL . $__additional_css__ ?>
		 <!-- jQuery 1.11.1 -->
        <script src="__HTML__/js/jquery-1.7.2.min.js"></script>
        <!-- Bootstrap -->
        <script src="__HTML__/js/bootstrap.min.js" type="text/javascript"></script>
        <!--JqueryUI-->
        <script src="__HTML__/js/plugins/jqueryui/jquery-ui.js" type="text/javascript"></script>       
        <!--timepicker-->
        <script src="__HTML__/js/plugins/jqueryui/jquery-ui-slide.min.js" type="text/javascript"></script>   
        <script src="__HTML__/js/plugins/jqueryui/jquery-ui-timepicker-addon.js" type="text/javascript"></script>     
        <!--artdialog-->
       
        <!-- FORM -->
        <script src="__HTML__/js/plugins/form/formvalidator.js" type="text/javascript"></script>
        <script src="__HTML__/js/plugins/form/formvalidatorregex.js" type="text/javascript"></script>
        <!-- Sparkline -->
        <script src="__HTML__/js/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
        <!-- iCheck -->
        <script src="__HTML__/js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
        
        <script src="__HTML__/comm/laydate/laydate.js"></script>
        <script src="__HTML__/comm/jquery.autocomplete.min.js"></script>
		 <script type="text/javascript">
        	//laydate.skin('molv');
        </script>

        <!-- AdminLTE App -->
        <?php echo $__additional_js__; ?>
        <?php echo $__additional_jscode__ ?>
        <script src="__HTML__/js/public.js" type="text/javascript"></script>
        <script src="__HTML__/js/py/app.js" type="text/javascript"></script>
        <script src="__HTML__/js/artDialog.js"></script> 
        <script src="__HTML__/js/iframeTools.js"></script> 
        <script src="__HTML__/comm/plupload/plupload.full.min.js" type="text/javascript"></script>
        <script src="__HTML__/comm/charts/highcharts.js" type="text/javascript"></script>
		<script src="__HTML__/comm/charts/modules/exporting.js" type="text/javascript"></script>
    </head>
    <body>

		<script type="text/javascript">
        window.gosubmint= function(){
			var rs = new Array();
			$('.un_upload').each(function(index, element) {
				
					var obj = {};
					obj.pid         = $(element).find(".pid_val").val();
					obj.level       = $(element).find(".level_val").val();
					obj.filename    = $(element).find(".file_val").val();
					obj.fileid      = $(element).find(".id_val").val();
					rs.push(obj);
			
			});
			return rs;	
		 } 
        </script>
       
        <div class="form-group col-md-12">
        	<a href="javascript:;" id="pickupfile" class="btn btn-success btn-sm" style="margin-top:15px; float:left;"><i class="fa fa-upload"></i> 选择文件</a>   
            <span style="line-height:30px; float:left;margin-left:15px; margin-top:15px; color:#999999;">请选择小于100M的文件，支持JPG / GIF / PNG / DOC / XLS / PDF / ZIP / RAR文件类型</span>
            <form method="post" action="" name="myform" id="myform">
            
            <table id="flist" class="table" style="margin-top:15px; float:left; clear:both; border-top:1px solid #dedede;">
                <tr>
                    <th align="left" width="">文件名称</th>
                    <th align="left" width="100">大小</th>
                    <th align="left" width="30%">上传进度</th>
                    <th align="left" width="60">操作</th>
                </tr>
                
            </table>
            <div id="container" style="display:none;"></div>
            </form>
        </div>


        <include file="Index:footer" />
        
        <script type="text/javascript">
        $(document).ready(function(e) {
            $('#supplierlist').show();
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
					/*
					mime_types: [
						{title : "Files", extensions : "jpg,jpeg,png,zip,rar,7z,doc,docx,ppt,pptx,xls,xlsx,txt,pdf,pdfx"}
					]
					*/
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
									'<tr id="' + file.id + '"  valign="middle" class="un_upload"><td class="iptval">'
									+ '<input type="hidden" name="pid_' + file.id + '" value="{$pid}" class="pid_val" />'
            						+ '<input type="hidden" name="level_' + file.id + '" value="{$level}" class="level_val" />'
									+ '<input type="text" name="nm_' + file.id + '" value="'+ file.name +'" class="form-control file_val" />'
									+ '</td> <td>' + plupload.formatSize(file.size) +'' 
									+ '</td> <td>' 
									+ '<div class="progress sm"> ' 
									+ '<div class="progress-bar progress-bar-aqua" rel="'+ file.id +'"  role="progressbar"  aria-valuemin="0" aria-valuemax="100">' 
									+ '</div></div></td>'
									+ '<td><a class="btn btn-danger btn-xs " href="javascript:;" onclick="removeThisFile(\''+ file.id +'\');"><i class="fa fa-times"></i>删除</a></td></tr>'
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
							$('input[name=pid_' + file.id +']').prop('name', 'pid['+rs.aid+']');
							$('input[name=level_' + file.id +']').prop('name', 'level['+rs.aid+']');
							$('#' + file.id).find('.iptval').append('<input type="hidden" name="fileid['+rs.aid+']" value="'+rs.aid+'" class="id_val" />');
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
        </script>
        