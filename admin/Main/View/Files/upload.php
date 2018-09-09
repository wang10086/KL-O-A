<include file="Index:header2" />

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
<aside class="right-side">
    <section class="content-header">
        <h1>文件管理</h1>
        <ol class="breadcrumb">
            <li><a href="{:U('Files/index')}"><i class="fa fa-home"></i> 首页</a></li>
            <li><a href="javascript:;">上传文件</a></li>
        </ol>
    </section>

    <section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">上传文件</h3>
                </div><!-- /.box-header -->
                <form method="post" action="{:U('Files/savefile')}" name="myform" id="myform">
                    <input type="hidden" name="pid" value="{$pid}">
                    <input type="hidden" name="level" value="{$level}">
                <div class=" content ">
                    <div class="col-md-12" id="departmentid">
                        <lebal class="upload-lebal">所属部门<span></span></lebal>
                        <!--<span class="lebal-span" style="margin-right: 6px"><input type="checkbox" id="departmentcheckbox"> &nbsp;全选</span>-->
                        <foreach name="department" key="k" item="v">
                            <!--<span class="lebal-span"><input type="checkbox" value="{$k}" name="department[]" class="departmentcheckbox"> &nbsp;{$v}</span>-->
                            <span class="lebal-span"><input type="radio" value="{$k}" name="department[]" class="departmentcheckbox" <?php if ($departmentid == $k) {echo 'checked';} ?>> &nbsp;{$v}</span>
                        </foreach>
                    </div>


                    <div class="col-md-12 mt10" id="postid">
                        <!--<lebal class="upload-lebal">所属岗位<span></span></lebal>
                        <span class="lebal-span" style="margin-right: 6px"><input type="checkbox" id="postscheckbox"> &nbsp;全选</span>
                        <foreach name="posts" key="k" item="v">
                            <span class="lebal-span"><input type="checkbox" value="{$v['id']}" name="posts[]" class="postscheckbox"> &nbsp;{$v['post_name']}</span>
                        </foreach>-->
                    </div>
                    <div class="col-md-12 mt10">
                        <lebal class="upload-lebal">文件类型</lebal>
                        <foreach name="file_tag" key="k" item="v">
                            <span class="lebal-span"><input type="radio" value="{$k}" name="file_tag"> &nbsp;{$v}</span>
                        </foreach>
                    </div>

                    <div class="form-group col-md-12"></div>
                    <div class="form-group col-md-12">
                        <a href="javascript:;" id="pickupfile" class="btn btn-success btn-sm" style="margin-top:15px; float:left;"><i class="fa fa-upload"></i> 选择文件</a>
                        <span style="line-height:30px; float:left;margin-left:15px; margin-top:15px; color:#999999;">请选择小于100M的文件，支持JPG / GIF / PNG / DOC / XLS / PDF / ZIP / RAR文件类型</span>

                        <table id="flist" class="table" style="margin-top:15px; float:left; clear:both; border-top:1px solid #dedede;">
                            <tr>
                                <th align="left" width="">文件名称</th>
                                <th align="left" width="100">大小</th>
                                <th align="left" width="30%">上传进度</th>
                                <th align="left" width="60">操作</th>
                            </tr>

                        </table>
                        <div id="container" style="display:none;"></div>
                    </div>
                    <div id="formsbtn">
                        <button type="submit" class="btn btn-info btn-lg" id="lrpd">保存</button>
                    </div>
                </div>
                </form>
                </div>
            </div>
        </div>
        </section>
</aside>

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

            reload();

            $('#postid').html('');
            $('#departmentid').find('ins').each(function(index, element) {
                $(this).click(function(){
                    var departmentid = $(this).prev().val();
                   $.ajax({
                       type: 'POST',
                       url: "{:U('Ajax/get_posts')}",
                       dataType: 'JSON',
                       data: {departmentid: departmentid},
                       success: function (msg) {
                           var html = '<lebal class="upload-lebal">所属岗位<span></span></lebal>';
                           if (msg) {
                               html += '<span class="lebal-span"><input type="checkbox" id="postscheckbox" class="delem-checkbox"> &nbsp;全选</span>'
                               for (var i = 0; i<msg.length; i++) {
                                   html += '<span class="lebal-span"><input type="checkbox" value="'+msg[i].id+'" name="posts[]" class="postscheckbox delem-checkbox"> &nbsp;'+msg[i].post_name+'</span>';
                               }
                           }else{
                                html += '<span class="lebal-span" style="margin-right: 10px">暂无岗位信息!</span>'
                           }
                           $('#postid').html(html);
                           //reload();
                           checkAll();
                       },
                       error: function () {
                           alert('数据获取失败');
                       }
                   })
                })
            });
				
        });

        function reload(){
            //所属部门
            /*$('#departmentcheckbox').on('ifChecked', function() {
             $('.departmentcheckbox').iCheck('check');
             });
             $('#departmentcheckbox').on('ifUnchecked', function() {
             $('.departmentcheckbox').iCheck('uncheck');
             });*/

            //所属岗位
            $('#postscheckbox').on('ifChecked', function() {
                $('.postscheckbox').iCheck('check');
            });
            $('#postscheckbox').on('ifUnchecked', function() {
                $('.postscheckbox').iCheck('uncheck');
            });
        }

        function checkAll(){
            $('#postscheckbox').click(function () {
                if ($(this).attr('checked')){
                    //$('.postscheckbox').iCheck('check');
                    $('.postscheckbox').prop('checked','checked');
                }else {
                    $('.postscheckbox').removeAttr('checked');
                }
            })
        }

		function removeThisFile(fid) {
			if (confirm('确定要删除此附件吗？')) {
				$('#' + fid).empty().remove();
				$('input[rel=' + fid +']').remove();
			}
		}


        </script>
        