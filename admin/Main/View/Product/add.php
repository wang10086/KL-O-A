<include file="Index:header2" />


			<aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        产品模块管理
                        <small>{$_pagedesc_}</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('ScienceRes/res')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                            <!-- general form elements disabled -->
                            <form method="post" action="{:U('Product/add')}" name="myform" id="myform">
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">编辑产品模块</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <input type="hidden" name="dosubmit" value="1" />
                                    <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
                                    <input type="hidden" name="business_dept" value="{$business_dept}">
                                    <if condition="$row"><input type="hidden" name="id" value="{$row.id}" /></if>
                                    <if condition="$row">
                                        <input type="hidden" name="info[input_uname]" value="{$row.input_uname}" class="form-control"  />
                                    <else />
                                        <input type="hidden" name="info[input_uname]" value="{:session('nickname')}" class="form-control"  />
                                    </if>

                                    <div class="form-group col-md-6">
                                        <label>产品模块名称</label>
                                        <input type="text" name="info[title]" id="title" value="{$row.title}"  class="form-control" required />
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>类别</label>
                                        <select  class="form-control"  name="info[type]">
                                            <option value="0">请选择</option>
                                            <foreach name="product_type" key="k" item="v">
                                                <option value="{$k}" <?php if ($row && ($k == $row['type'])) echo ' selected'; ?> >{$v}</option>
                                            </foreach>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>科学领域</label>
                                        <select  class="form-control"  name="info[subject_field]">
                                        <option value="0">请选择</option>
                                        <foreach name="subject_fields" key="k" item="v">
                                            <option value="{$k}" <?php if ($row && ($k == $row['subject_field'])) echo ' selected'; ?> >{$v}</option>
                                        </foreach>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>来源</label>
                                        <select  class="form-control"  name="info[from]">
                                            <option value="0">请选择</option>
                                            <foreach name="product_from" key="k" item="v">
                                                <option value="{$k}" <?php if ($row && ($k == $row['from'])) echo ' selected'; ?> >{$v}</option>
                                            </foreach>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group col-md-12">
                                        <label><a href="javascript:;" onClick="selectages()">选择适用年龄</a> <span style="color:#999999">(选择后您可以点击删除)</span></label>
                                        <div id="pro_ages_text">
                                        <foreach name="agelist" item="v">
                                             <span class="unitbtns" title="点击删除该选项"><input type="hidden" name="age[]" value="{$v.id}"><button type="button" class="btn btn-default btn-sm">{$v.name}</button></span>
                                        </foreach>
                                        </div>
                                    </div>
                                    
                                    
                                    <!--<div class="form-group col-md-12">
                                        <label><a href="javascript:;" onClick="selectkinds()">选择适用项目类型</a> <span style="color:#999999">(选择后您可以点击删除)</span></label>
                                        <div id="pro_kinds_text">
                                        
                                        <foreach name="deptlist" item="v">
                                             <span class="unitbtns" title="点击删除该选项"><input type="hidden" name="business_dept[]" value="{$v.id}"><button type="button" class="btn btn-default btn-sm">{$v.name}</button></span>
                                        </foreach>
                                        
                                        </div>
                                    </div>-->

                                    <div class="form-group col-md-12"></div>

                                    <div class="form-group col-md-12">
                                        <label>产品简介</label>
                                        <?php echo editor('content',$row['content']); ?>
                                    </div>

                                    <!-- <div class="form-group col-md-12">
                                    <table class="table table-striped" id="supplierlist" >
                                    	<thead>
                                            <tr role="row">
                                                <th>资源名称</th>
                                                <th width="100">资源类型</th>
                                                <th width="200">所在地</th>
                                                <th width="60">删除</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	<foreach name="supplier" key="k" item="v">
                                            <tr id="supplier_{$v.id}">
                                                <td><input type="hidden" name="res[]" value="{$v.id}"><a href="{:U('ScienceRes/res_view',array('id'=>$v['id']))}" target="_blank">{$v.title}</a></td>
                                                <td><?php echo $reskind[$v['kind']]; ?></td>
                                                <td>{$v.diqu}</td>
                                                <td><a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('supplier_{$v.id}')">删除</a></td>
                                            </tr>
                                            </foreach>
                                        </tbody>
                                    </table>
                                    </div>
                                    
                                    <div class="form-group col-md-12" >
                                        <a href="javascript:;" class="btn btn-success btn-sm" style="margin-top:15px;" onclick="add_supplier()"><i class="fa fa-fw fa-plus"></i> 关联科普资源</a>
                                    </div>-->
                                    
                                    <div class="form-group">&nbsp;</div>
                                    
                                </div><!-- /.box-body -->
                                
                                
                            </div><!-- /.box -->
                            
                            
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">材料及价格</h3>
                                </div>
                                <div class="box-body">
                                    <div class="content">
                                        <div class="content" style="padding-top:0px;">

                                            <div class="form-group">
                                                <label>核算模式</label>
                                                <div class="produce_hesuan" id="product_hesuan">
                                                    <span><input type="radio" class="hesuan_type mt10" name="info[reckon_mode]" value="1" <?php if($row['reckon_mode']==1){ echo 'checked';} ?>>&#12288;按项目核算</span>
                                                    <span class="ml20"><input type="radio"  name="info[reckon_mode]" value="2" <?php if($row['reckon_mode']==2){ echo 'checked';} ?>>&#12288;按人数核算</span>
                                                    <span class="ml20"><input type="radio"  name="info[reckon_mode]" value="3" <?php if($row['reckon_mode']==3){ echo 'checked';} ?>>&#12288;按批次核算(100人/批)</span>
                                                    <?php if($row && $row['sales_price']){ ?>
                                                        <?php if($row['reckon_mode']==1){ ?>
                                                            <span class="ml50" id="hesuan_result"><input type="text" class="under-line-input" name="info[sales_price]" id="produce_price" value="{$row.sales_price}">元/项</span>
                                                        <?php }elseif($row['reckon_mode']==2){ ?>
                                                            <span class="ml50" id="hesuan_result"><input type="text" class="under-line-input" name="info[sales_price]" id="produce_price" value="{$row.sales_price}">元/人</span>
                                                        <?php }elseif($row['reckon_mode']==3){ ?>
                                                            <span class="ml50" id="hesuan_result"><input type="text" class="under-line-input" name="info[sales_price]" id="produce_price" value="{$row.sales_price}">元/批</span>
                                                        <?php } ?>
                                                    <?php }else{ ?>
                                                    <span class="ml50" id="hesuan_result"></span>
                                                    <?php } ?>
                                                </div>
                                            </div>

                                            <div id="material">
                                                <div class="userlist" id="material_id">
                                                    <div class="unitbox material_name">材料名称</div>
                                                    <div class="unitbox longinput">规格</div>
                                                    <div class="unitbox material_name">数量</div>
                                                    <div class="unitbox material_name">参考单价</div>
                                                    <div class="unitbox material_name">合计价格</div>
                                                    <div class="unitbox material_name">类型</div>
                                                    <div class="unitbox longinput">购买途径</div>
                                                    <div class="unitbox longinput">备注</div>
                                                </div>
                                                <?php if($material){ ?>
                                                <foreach name="material" key="k" item="v">
                                                <div class="userlist" id="material_id_{$v.id}">
                                                    <span class="title"><?php echo $k+1; ?></span>
                                                    <input type="hidden" name="resid[888{$v.id}][id]" value="{$v.id}" >
                                                    <input type="text" class="form-control material_name" name="material[888{$v.id}][material]" value="{$v.material}">
                                                    <input type="text" class="form-control longinput" name="material[888{$v.id}][spec]" value="{$v.spec}">
                                                    <input type="text" class="form-control amount" name="material[888{$v.id}][amount]" value="{$v.amount}" onblur="total()">
                                                    <input type="text" class="form-control cost" name="material[888{$v.id}][unitprice]" value="{$v.unitprice}" onblur="total()">
                                                    <input type="text" class="form-control total" name="material[888{$v.id}][total]" value="{$v.total}">
                                                    <select class="form-control"  name="material[888{$v.id}][type]" >
                                                        <option value="1" <?php if($v['type']==1){ echo 'selected';} ?> >物资</option>
                                                        <option value="2" <?php if($v['type']==2){ echo 'selected';} ?> >专家辅导员</option>
                                                        <option value="3" <?php if($v['type']==3){ echo 'selected';} ?> >合格供方</option>
                                                        <option value="4" <?php if($v['type']==4){ echo 'selected';} ?> >其他</option>
                                                    </select>
                                                    <input type="text" class="form-control longinput" name="material[888{$v.id}][channel]" value="{$v.channel}">
                                                    <input type="text" class="form-control longinput" name="material[888{$v.id}][remarks]" value="{$v.remarks}">
                                                    <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('material_id_{$v.id}')">删除</a>
                                                </div>
                                                </foreach>
                                                <?php }else{ ?>
                                                <div class="userlist" id="material_id">
                                                    <span class="title">1</span>
                                                    <input type="text" class="form-control material_name" name="material[0][material]" onblur="check_ptype()">
                                                    <input type="text" class="form-control longinput" name="material[0][spec]">
                                                    <input type="text" class="form-control amount" name="material[0][amount]" onblur="total()">
                                                    <input type="text" class="form-control cost" name="material[0][unitprice]" onblur="total()">
                                                    <input type="text" class="form-control total" name="material[0][total]">
                                                    <select class="form-control"  name="material[888{$v.id}][type]" >
                                                        <option value="1" <?php if($v['type']==1){ echo 'selected';} ?> >物资</option>
                                                        <option value="2" <?php if($v['type']==2){ echo 'selected';} ?> >专家辅导员</option>
                                                        <option value="3" <?php if($v['type']==3){ echo 'selected';} ?> >合格供方</option>
                                                        <option value="4" <?php if($v['type']==4){ echo 'selected';} ?> >其他</option>
                                                    </select>
                                                    <input type="text" class="form-control longinput" name="material[0][channel]">
                                                    <input type="text" class="form-control longinput" name="material[0][remarks]">
                                                    <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('material_id')">删除</a>
                                                </div>
                                                <?php } ?>
                                            </div>
                                            <div id="material_val">0</div>
                                            
                                            <a href="javascript:;" class="btn btn-success btn-sm" style="margin-top:15px;" onClick="add_material()"><i class="fa fa-fw fa-plus"></i> 新增物资</a> 
                                            
                                            <div class="form-group">&nbsp;</div>
                                        </div>
                                       
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">上传资料</h3>
                                    
                                </div>
                                <div class="box-body">
                                    <div class="content">
                                        <div class="form-group col-md-12">
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
                                        </div>

                                    	<!--<div class="form-group col-md-12">
                                            <label class="upload_label">上传相关附件</label>
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
                                        </div>-->
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
        //是否需要辅导员/教师/专家
        $('#product_hesuan').find('ins').each(function(index, element) {
            $(this).click(function(){
                if(index==0){
                    $('#hesuan_result').html('<input type="text" class="under-line-input" name="info[sales_price]" id="produce_price" value="{$row.sales_price}" >元/项');
                }else if (index==1){
                    $('#hesuan_result').html('<input type="text" class="under-line-input" name="info[sales_price]" id="produce_price" value="{$row.sales_price}" >元/人');
                }else if (index==2){
                    $('#hesuan_result').html('<input type="text" class="under-line-input" name="info[sales_price]" id="produce_price" value="{$row.sales_price}" >元/批');
                }
            })
        });

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
		
		closebtns();
		
	});

	function removeThisFile(fid) {
		if (confirm('确定要删除此附件吗？')) {
            $('#' + fid).empty().remove();
            $('input[rel=' + fid +']').remove();
		}
	}

	//检查核算模式
    function check_ptype(){
        var hesuan_result = $('#hesuan_result').html();
        if(hesuan_result==''){
            alert('请选择核算模式');
        }
    }
	
	//新增物资
	function add_material(){
		var i = parseInt($('#material_val').text())+1;

		var html = '<div class="userlist" id="material_'+i+'"><span class="title"></span><input type="text" class="form-control material_name" name="material['+i+'][material]"><input type="text" class="form-control longinput" name="material['+i+'][spec]" value=""><input type="text" class="form-control amount" name="material['+i+'][amount]" onblur="total()"><input type="text" class="form-control cost" name="material['+i+'][unitprice]" onblur="total()"><input type="text" class="form-control total" name="material['+i+'][total]"><select class="form-control"  name="material['+i+'][type]" ><option value="1">物资</option><option value="2">专家辅导员</option><option value="3">合格供方</option><option value="4">其他</option></select><input type="text" class="form-control longinput" name="material['+i+'][channel]" value=""><input type="text" class="form-control longinput" name="material['+i+'][remarks]"><a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox(\'material_'+i+'\')">删除</a></div>';
		$('#material').append(html);	
		$('#material_val').html(i);
		orderno();
		keywords();
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
	
	//更新价格与数量
	function total(){
		$('.userlist').each(function(index, element) {
            var hesuan_sum = 0;
            $(this).find('.cost').blur(function(){
				var cost = $(this).val();
				var amount = $(this).parent().find('.amount').val();
				$(this).parent().find('.total').val(accMul(cost,amount));

                $('.total').each(function(index, element) {
                    hesuan_sum += parseFloat($(this).val());
                    $('#produce_price').val(hesuan_sum);
                });
			});
			 $(this).find('.amount').blur(function(){
				var amount = $(this).val();
				var cost = $(this).parent().find('.cost').val();
				$(this).parent().find('.total').val(accMul(cost,amount));

                 $('.total').each(function(index, element) {
                     hesuan_sum += parseFloat($(this).val());
                     $('#produce_price').val(hesuan_sum);
                 });
			});

        });
	}

	
	//选择适用年龄
	function selectages() {
		art.dialog.open('<?php echo U('Product/select_ages'); ?>',{
			lock:true,
			title: '选择适用年龄',
			width:600,
			height:400,
			okValue: '提交',
			fixed: true,
			ok: function () {
				var origin = artDialog.open.origin;
				var data = this.iframe.contentWindow.gosubmint();
				var i=0;
				var str = "";
				for (i=0; i<data.length; i++) {
				    str = '<span class="unitbtns" title="点击删除该选项"><input type="hidden" name="age[]" value="'+data[i].id+'"><button type="button" class="btn btn-default btn-sm">'+data[i].age+'</button></span>';
                    	    $('#pro_ages_text').append(str);
				}
				closebtns();
			},
			cancelValue:'取消',
			cancel: function () {
			}
		});	
	}
	
	
	//关联科普资源
	function add_supplier() {
		art.dialog.open('<?php echo U('Product/add_supplier'); ?>',{
			lock:true,
			title: '关联科普资源',
			width:900,
			height:500,
			okValue: '提交',
			fixed: true,
			ok: function () {
				var origin = artDialog.open.origin;
				var supplier = this.iframe.contentWindow.gosubmint();
				var supplier_html = '';
				for (var j = 0; j < supplier.length; j++) {
					if (supplier[j].id) { 
						var i = parseInt(Math.random()*100000)+j;
						
						supplier_html += '<tr id="supplier_'+i+'"><td><input type="hidden" name="res[]" value="'+supplier[j].id+'"><a href="index.php?m=Main&c=ScienceRes&a=res_view&id='+supplier[j].id+'" target="_blank">'+supplier[j].title+'</a></td><td>'+supplier[j].kind+'</td><td>'+supplier[j].diqu+'</td><td><a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox(\'supplier_'+i+'\')">删除</a></td></tr>';
						
						
					};
				}
				
				$('#supplierlist').find('tbody').append(supplier_html);	
			},
			cancelValue:'取消',
			cancel: function () {
			}
		});	
	}
	
	
	
	//选择适用项目类型
	function selectkinds() {
		art.dialog.open('<?php echo U('Product/select_kinds'); ?>',{
			lock:true,
			title: '选择适用项目类型',
			width:600,
			height:400,
			okValue: '提交',
			fixed: true,
			ok: function () {
				var origin = artDialog.open.origin;
				var data = this.iframe.contentWindow.gosubmint();
				var i=0;
				var str = "";
				for (i=0; i<data.length; i++) {
				    str = '<span class="unitbtns" title="点击删除该选项"><input type="hidden" name="business_dept[]" value="'+data[i].id+'"><button type="button" class="btn btn-default btn-sm">'+data[i].kind+'</button></span>';
                    	    $('#pro_kinds_text').append(str);
				}
				closebtns();
			},
			cancelValue:'取消',
			cancel: function () {
			}
		});	
	}
	
	
	function closebtns(){
	    $('.unitbtns').each(function(index, element) {
              $(this).click(function(){
		       $(this).remove();
          	  })  
          });	
	}
	
	
	$(document).ready(function() {	
		keywords();
	})
	
	//关键字联想
	function keywords(){
		var keywords = <?php echo $keywords; ?>;
		$(".material_name").autocomplete(keywords, {
			 matchContains: true,
			 highlightItem: false,
			 formatItem: function(row, i, max, term) {
			 	 return '<span style=" display:none">'+row.pinyin+'</span>'+row.material;
			 },
			 formatResult: function(row) {
				 return row.material;
			 }
		});	
	}
	

</script>	
     


