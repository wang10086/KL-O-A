<include file="Index:header2" />


			<aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                       {$_action_}
                        <small>{$_pagedesc_}</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Product/standard_product')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
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
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">编辑标准化产品</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <input type="hidden" name="dosubmit" value="1">
                                    <input type="hidden" name="savetype" value="1">
                                    <input type="hidden" name="id" value="{$id}" >

                                    <div class="form-group col-md-8">
                                        <label>产品模块名称</label>
                                        <input type="text" name="info[title]" id="title" value="{$row.title}"  class="form-control" required />
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>使用时间：</label>
                                        <select class="form-control" name="apply_time">
                                            <option value="" selected disabled>==请选择==</option>
                                            <foreach name="apply_times" key="k" item="v">
                                                <option value="{$v['year']}" <?php if($apply_time == $v['year']){ echo "selected"; } ?>>{$v['title']}</option>
                                            </foreach>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>是否是标准化产品：</label>
                                        <select class="form-control" name="info[standard]" required>
                                            <option value="" selected disabled>==请选择==</option>
                                            <foreach name="standard" key="k" item="v">
                                                <option value="{$k}" <?php if ($row['standard'] == $k) echo 'selected'; ?>>{$v}</option>
                                            </foreach>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>适用人群</label>
                                        <select name="info[age]" class="form-control">
                                            <foreach name="apply" key="k" item="v">
                                                <option value="{$k}" <?php if ($k == $row['age']) echo 'selected'; ?>>{$v}</option>
                                            </foreach>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>科学领域</label>
                                        <select  class="form-control"  name="info[subject_field]">
                                            <option value="0">请选择</option>
                                            <foreach name="subject_fields" key="k" item="v">
                                                <option value="{$k}" <?php if ($row && ($k == $row['subject_field'])) echo ' selected'; ?> >{$v}</option>
                                            </foreach>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>来源</label>
                                        <select  class="form-control"  name="info[from]">
                                            <option value="0">请选择</option>
                                            <foreach name="product_from" key="k" item="v">
                                                <option value="{$k}" <?php if ($row && ($k == $row['from'])) echo ' selected'; ?> >{$v}</option>
                                            </foreach>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>核算模式</label>
                                        <select  class="form-control"  name="info[reckon_mode]" id="reckon_mode">
                                            <option value="" selected disabled>==请选择==</option>
                                            <foreach name="reckon_mode" key="k" item="v">
                                                <option value="{$k}" <?php if ($row['reckon_mode'] == $k) echo 'selected'; ?> >{$v}</option>
                                            </foreach>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>参考成本价</label>
                                        <input class="form-control" type="text" name="info[sales_price]" value="{$row.sales_price}" />
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label>配套物资清单</label>
                                        <input class="form-control" type="text" name="info[matching]" value="{$row.matching}" />
                                    </div>

                                    <div class="form-group col-md-12">
                                        <span class="lm_c black">适用项目类型</span>
                                        <foreach name="kinds" key="k" item="v">
                                            <span class="lm_c"><input type="checkbox" name="business_dept[]" <?php if(in_array($v['id'],$business_dept)){ echo 'checked';} ?>  value="{$v.id}"> {$v.name}</span>
                                        </foreach>
                                    </div>

                                    <div class="form-group col-md-12"></div>
                                    <div class="form-group col-md-12">
                                        <label>产品简介</label>
                                        <?php echo editor('content',$row['content']); ?>
                                    </div>
                                    <div class="form-group">&nbsp;</div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            
                            
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">包含产品模块</h3>
                                </div>
                                <div class="box-body">
                                    <div class="content">
                                        <div class="content" style="padding-top:0px;">
                                            <div class="form-group col-md-12" id="productlist" style="display:block;">
                                                <table class="table table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th width="100">模块</th>
                                                        <th width="80">类别</th>
                                                        <th width="120">科学领域</th>
                                                        <th width="80">来源</th>
                                                        <th width="120">适合年龄</th>
                                                        <th width="100">核算方式</th>
                                                        <th width="100">参考价</th>
                                                        <th width="20">&nbsp;</th>
                                                        <th width="50">数量</th>
                                                        <th width="100">参考费用</th>
                                                        <th width="80">删除</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="product_tbody">
                                                    <foreach name="product_need" item="v">
                                                        <tr class="expense" id="product_id_{$v.id}">
                                                            <td><input type="hidden" name="resetid[2000{$v.id}][id]" value="{$v.id}" >
                                                                <input type="hidden" name="costacc[20000{$v.id}][id]" value="{$v.id}">
                                                                <input type="hidden" name="costacc[20000{$v.id}][title]" value="{$v.title}">
                                                                <input type="hidden" name="costacc[20000{$v.id}][product_id]" value="{$v.product_id}">
                                                                <input type="hidden" name="costacc[20000{$v.id}][total]" value="{$v.total}">
                                                                <a href="javascript:;" onClick="open_product({$v.product_id},{$v.product.title})">{$v.title}</a></td>
                                                            <td>{$product_type[$v[ptype]]}</td>
                                                            <td>{$subject_fields[$v[subject_field]]}</td>
                                                            <td>{$product_from[$v[from]]}</td>
                                                            <td>{$v.age_list}</td>
                                                            <td>{$reckon_mode[$v[reckon_mode]]}</td>
                                                            <td><input type="text" name="costacc[20000{$v.id}][unitcost]" placeholder="价格" value="{$v.unitcost}" class="form-control min_input cost" readonly /></td>
                                                            <td><span>X</span></td>
                                                            <td><input type="text" name="costacc[20000{$v.id}][amount]" placeholder="数量" value="{$v.amount}" class="form-control min_input amount" /></td>
                                                            <td class="total">&yen;{$v.total}</td>
                                                            <td><a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('product_id_{$v.id}')">删除</a></td></tr>
                                                        </tr>
                                                    </foreach>
                                                    </tbody>
                                                    <tfoot>
                                                    <tr>
                                                        <td align="left" colspan="11">
                                                            <a href="javascript:;" class="btn btn-success btn-sm" style="margin-left:-8px;"  onClick="selectproduct()"><i class="fa fa-fw  fa-plus"></i> 选择产品模块</a>
                                                            <!--<a  href="javascript:;" class="btn btn-info btn-sm" onClick="javascript:save('save_product','<?php /*echo U('Op/public_save'); */?>',{$op.op_id});">保存</a>-->
                                                        </td>
                                                    </tr>
                                                    </tfoot>
                                                </table>
                                                <!--</div>-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">包含资源模块</h3>
                                </div>
                                <div class="box-body">
                                    <div class="content">
                                        <div class="content" style="padding-top:0px;">
                                            <div class="form-group col-md-12" id="reslist" style="display:block;">
                                                <table class="table table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th width="50%">资源名称</th>
                                                        <th width="18%">性质</th>
                                                        <th width="18%">所在地</th>
                                                        <th width="80">删除</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="res_tbody">
                                                    <foreach name="res_need" item="v">
                                                        <tr class="expense" id="res_id_{$v.id}">
                                                            <td><input type="hidden" name="res_ids[2000{$v.id}][res_id]" value="{$v.id}" >
                                                                <a href="javascript:;" onClick="open_res({$v.res_id},{$v.res.title})">{$v.title}</a></td>
                                                            <td>{$in_cas[$v[in_cas]]}</td>
                                                            <td>{$v[diqu]}</td>
                                                            <td><a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('res_id_{$v.id}')">删除</a></td></tr>
                                                        </tr>
                                                    </foreach>
                                                    </tbody>
                                                    <tfoot>
                                                    <tr>
                                                        <td align="left" colspan="11">
                                                            <a href="javascript:;" class="btn btn-success btn-sm" style="margin-left:-8px;"  onClick="selectres()"><i class="fa fa-fw  fa-plus"></i> 选择资源模块</a>
                                                            <!--<a  href="javascript:;" class="btn btn-info btn-sm" onClick="javascript:save('save_res','<?php /*echo U('Op/public_save'); */?>',{$op.op_id});">保存</a>-->
                                                        </td>
                                                    </tr>
                                                    </tfoot>
                                                </table>
                                                <!--</div>-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">上传相关附件</h3>
                                </div>
                                <div class="box-body">
                                    <div class="content">
                                        <!--<div class="form-group col-md-12">
                                            <label class="upload_label">上传原理及实施要求</label>
                                            {:upload_m('theory_file','theory_files',$theory,'上传原理及实施要求','theory_box','theory','文件名称')}
                                            <span style="line-height:30px; margin-left:15px; margin-top:15px; color:#999999;">请选择小于80M的文件，支持JPG / GIF / PNG / DOC / XLS / PDF / ZIP / RAR文件类型</span>
                                            <div id="theory_box"></div>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label class="upload_label">上传图片</label>
                                            {:upload_m('pic_file','pic_files',$pic,'上传图片','pic_box','pic','图片名称')}
                                            <span style="line-height:30px; margin-left:15px; margin-top:15px; color:#999999;">请选择不超过3张图片文件</span>
                                            <div id="pic_box"></div>
                                        </div>

                                        <div class="form-group col-md-12">
                                        <label class="upload_label">上传相关视频</label>
                                        {:upload_m('video_file','video_files',$video,'&nbsp;上传视频资料','video_box','video','视频名称')}
                                        <span style="line-height:30px; margin-left:15px; margin-top:15px; color:#999999;">请选择小于80M的文件，支持JPG / GIF / PNG / DOC / XLS / PDF / ZIP / RAR文件类型</span>
                                        <div id="video_box"></div>
                                        </div>-->

                                    	<div class="form-group col-md-12">
                                            <table id="flist" class="table" style="margin-top:10px;">
                                            	<tr>
                                                	<th align="left" width="45%">文件名称</th>
                                                    <th align="left" width="10%">大小</th>
                                                    <th align="left" width="30%">上传进度</th>
                                                    <th align="left" width="15%">操作</th>
                                                </tr>
                                                <foreach name="atts" item="v">
                                                <tr id="aid_{$v.id}" valign="middle"> 
                                                    <td><input type="text" name="newname[{$v.id}]" value="{$v.filename}" class="form-control"  /></td>
                                                    <td>{:fsize($v['filesize'])}</td>
                                                    <td>
                                                        <div class="progress sm"> 
                                                            <div class="progress-bar progress-bar-aqua" rel="aid_{$v.id}"  role="progressbar" style="width: 100%;"  aria-valuemin="0" aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><a class="btn btn-danger btn-xs " href="javascript:;" onclick="removeThisFile('aid_{$v.id}');"><i class="fa fa-times"></i>删除</a>&nbsp;&nbsp;&nbsp;&nbsp; <a class="btn btn-success btn-xs " href="{$v.filepath}" onclick=""><i class="fa fa-download"></i>下载</a></td>
                                                </tr>        
                                                </foreach>  
                                            </table>
                                             
                                            <a href="javascript:;" id="pickupfile" class="btn btn-success btn-sm" style="margin-top:15px;"><i class="fa fa-upload"></i> 上传附件</a>
                                            <div id="container" style="display:none;">
                                                <foreach name="atts" item="v">
                                                <input type="hidden" rel="aid_{$v.id}" name="resfiles[]" value="{$v.id}" />
                                                </foreach>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


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

<include file="Index:footer2" />

<script type="text/javascript"> 

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
	
	//移除
	function delbox(obj){
		$('#'+obj).remove();
	}

    //选择产品模块
    function selectproduct() {
        art.dialog.open("<?php echo U('Op/select_module',array('opid'=>$opid)); ?>",{
            lock:true,
            title: '选择产品模块',
            width:1000,
            height:500,
            okValue: '提交',
            fixed: true,
            ok: function () {
                var origin = artDialog.open.origin;
                var product = this.iframe.contentWindow.gosubmint();
                var product_html = '';
                for (var j = 0; j < product.length; j++) {
                    if (product[j].id) {
                        var i = parseInt(Math.random()*100000)+j;
                        var costacc = '<input type="hidden" name="costacc['+i+'][title]" value="'+product[j].title+'">' +
                            '<input type="hidden" name="costacc['+i+'][product_id]" value="'+product[j].id+'">'+
                            '<input type="hidden" name="costacc['+i+'][total]" class="totalval" />';
                        product_html += '<tr class="expense" id="product_'+i+'">' +
                            '<td>'+costacc+ '<a href="javascript:;" onClick="open_product('+product[j].id+',\''+product[j].title+'\')">'+product[j].title+'</a></td>' +
                            '<td>'+product[j].type+'</td>' +
                            '<td>'+product[j].subject_fields+'</td>' +
                            '<td>'+product[j].from+'</td>' +
                            '<td>'+product[j].age+'</td>' +
                            '<td>'+product[j].reckon_mode+'</td>' +
                            '<td><input type="text" name="costacc['+i+'][unitcost]" placeholder="价格" value="'+product[j].sales_price+'" class="form-control min_input cost" readonly /></td>' +
                            '<td><span>X</span></td>' +
                            '<td><input type="text" name="costacc['+i+'][amount]" placeholder="数量" value="1" class="form-control min_input amount" /></td>' +
                            '<td class="total">&yen;'+product[j].sales_price*1+'</td>' +
                            '<td><a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox(\'product_'+i+'\')">删除</a></td></tr>';
                    };
                }
                $('#productlist').show();
                $('#productlist').find('#product_tbody').append(product_html);
                total();
            },
            cancelValue:'取消',
            cancel: function () {
            }
        });
    }

    //更新价格与数量
    function total(){
        $('.expense').each(function(index, element) {
            $(this).find('.cost').blur(function(){
                var cost = $(this).val();
                var amount = $(this).parent().parent().find('.amount').val();
                $(this).parent().parent().find('.total').html('&yen;'+accMul(cost,amount));
                $(this).parent().parent().find('.totalval').val(accMul(cost,amount));
            });
            $(this).find('.amount').blur(function(){
                var amount = $(this).val();
                var cost = $(this).parent().parent().find('.cost').val();
                $(this).parent().parent().find('.total').html('&yen;'+accMul(cost,amount));
                $(this).parent().parent().find('.totalval').val(accMul(cost,amount));
            });
        });
    }

    //选择资源模块
    function selectres() {
        art.dialog.open("<?php echo U('Product/public_select_res',array('opid'=>$opid)); ?>",{
            lock:true,
            title: '选择产品模块',
            width:1000,
            height:500,
            okValue: '提交',
            fixed: true,
            ok: function () {
                var origin = artDialog.open.origin;
                var res = this.iframe.contentWindow.gosubmint();
                var res_html = '';
                for (var j = 0; j < res.length; j++) {
                    if (res[j].id) {
                        var i = parseInt(Math.random()*100000)+j;
                        var res_ids = '<input type="hidden" name="res_ids['+i+'][res_id]" value="'+res[j].id+'">';
                        res_html += '<tr class="expense" id="res_'+i+'">' +
                            '<td>'+res_ids+ '<a href="javascript:;" onClick="">'+res[j].title+'</a></td>' +
                            '<td>'+res[j].in_cas+'</td>' +
                            '<td>'+res[j].diqu+'</td>' +
                            '<td><a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox(\'res_'+i+'\')">删除</a></td></tr>';
                    };
                }
                $('#reslist').show();
                $('#reslist').find('#res_tbody').append(res_html);
            },
            cancelValue:'取消',
            cancel: function () {}
        });
    }

</script>	
     


