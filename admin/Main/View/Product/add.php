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
                                    <if condition="$row"><input type="hidden" name="id" value="{$row.id}" /></if>
                                    <!-- text input -->
                                    
                                    <div class="form-group col-md-12">
                                        <label>产品模块名称</label>
                                        <input type="text" name="info[title]" id="title" value="{$row.title}"  class="form-control" />
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
                                        <label>参考成本价</label>
                                        <input type="text" name="info[sales_price]" id="sales_price"   value="{$row.sales_price}" class="form-control" />
                                    </div>
                                    
                                    
                                    
                                    <div class="form-group col-md-4">
                                        <label>研发专家</label>
                                        <?php if ($row) { ?>
                                        <input type="text" name="info[input_uname]" id="input_uname"   value="{$row.input_uname}" class="form-control" readonly />
                                        <?php } else { ?>
                                        <input type="text" name="info[input_uname]" id="input_uname"   value="{:session('nickname')}" class="form-control" readonly />
                                        <?php } ?>
                                    </div>
                                    
                                    
                                    <div class="form-group col-md-12">
                                        <label><a href="javascript:;" onClick="selectages()">选择适用年龄</a> <span style="color:#999999">(选择后您可以点击删除)</span></label>
                                        <div id="pro_ages_text">
                                        <foreach name="agelist" item="v">
                                             <span class="unitbtns" title="点击删除该选项"><input type="hidden" name="age[]" value="{$v.id}"><button type="button" class="btn btn-default btn-sm">{$v.name}</button></span>
                                        </foreach>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="form-group col-md-12">
                                        <label><a href="javascript:;" onClick="selectkinds()">选择适用项目类型</a> <span style="color:#999999">(选择后您可以点击删除)</span></label>
                                        <div id="pro_kinds_text">
                                        
                                        <foreach name="deptlist" item="v">
                                             <span class="unitbtns" title="点击删除该选项"><input type="hidden" name="business_dept[]" value="{$v.id}"><button type="button" class="btn btn-default btn-sm">{$v.name}</button></span>
                                        </foreach>
                                        
                                        </div>
                                    </div>
                                    
                                    
                                    
                                    
                                    <div class="form-group col-md-12">
                                        <label>产品模块介绍</label>
                                        <?php echo editor('content',$row['content']); ?>
                                    </div>
                                    
                                    <div class="form-group col-md-12">
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
                                    </div>
                                    
                                    <div class="form-group">&nbsp;</div>
                                    
                                </div><!-- /.box-body -->
                                
                                
                            </div><!-- /.box -->
                            
                            
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">模块费用清单</h3>
                                </div>
                                <div class="box-body">
                                    <div class="content">
                                        <div class="content" style="padding-top:0px;">
                                        	<style type="text/css">
											#material .material_name{ width:120px;}
                                            #material .longinput{ width:100px;}
                                            </style>
                                            <div id="material">
                                                <div class="userlist" id="material_id">
                                                    <div class="unitbox material_name">物资名称</div>
                                                    <div class="unitbox longinput">规格</div>
                                                    <div class="unitbox">数量</div>
                                                    <div class="unitbox">参考单价</div>
                                                    <div class="unitbox">类型</div>
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
                                                    <input type="text" class="form-control" name="material[888{$v.id}][amount]" value="{$v.amount}">
                                                    <input type="text" class="form-control" name="material[888{$v.id}][unitprice]" value="{$v.unitprice}">
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
                                                    <input type="text" class="form-control material_name" name="material[0][material]">
                                                    <input type="text" class="form-control longinput" name="material[0][spec]">
                                                    <input type="text" class="form-control" name="material[0][amount]">
                                                    <input type="text" class="form-control" name="material[0][unitprice]">
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
                                    <h3 class="box-title">上传附件</h3>
                                    
                                </div>
                                <div class="box-body">
                                    <div class="content">
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
		
		closebtns();
		
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

		var html = '<div class="userlist" id="material_'+i+'"><span class="title"></span><input type="text" class="form-control material_name" name="material['+i+'][material]"><input type="text" class="form-control longinput" name="material['+i+'][spec]" value=""><input type="text" class="form-control amount" name="material['+i+'][amount]"><input type="text" class="form-control" name="material['+i+'][unitprice]"><select class="form-control"  name="material['+i+'][type]" ><option value="1">物资</option><option value="2">专家辅导员</option><option value="3">合格供方</option><option value="4">其他</option></select><input type="text" class="form-control longinput" name="material['+i+'][channel]" value=""><input type="text" class="form-control longinput" name="material['+i+'][remarks]"><a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox(\'material_'+i+'\')">删除</a></div>';
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
	/*
	function total(){
		$('.userlist').each(function(index, element) {
            $(this).find('.cost').blur(function(){
				var cost = $(this).val();
				var amount = $(this).parent().find('.amount').val();
				$(this).parent().find('.total').val(accMul(cost,amount));	
			});
			 $(this).find('.amount').blur(function(){
				var amount = $(this).val();
				var cost = $(this).parent().find('.cost').val();
				$(this).parent().find('.total').val(accMul(cost,amount));	
			});
			
        });		
	}
	*/
	
	
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
     


