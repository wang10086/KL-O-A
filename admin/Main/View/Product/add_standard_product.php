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
                                    <input type="hidden" name="savetype" value="3">
                                    <input type="hidden" name="id" value="{$id}" >

                                    <div class="form-group col-md-8">
                                        <label>标准产品名称</label>
                                        <input type="text" name="info[title]" id="title" value="{$row.title}"  class="form-control" required />
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>使用时间：</label>
                                        <select class="form-control" name="apply_time">
                                            <foreach name="apply_times" key="k" item="v">
                                                <option value="{$v['year']}" <?php if($apply_time == $v['year']){ echo "selected"; } ?>>{$v['title']}</option>
                                            </foreach>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>所在省份：</label>
                                        <select id="s_province" class="form-control" name="info[province]" required>
                                            <option class="form-control" value="" selected disabled>请选择</option>
                                            <foreach name="provinces" key="k" item="v">
                                                <option class="form-control" value="{$k}" <?php if ($partner && $partner['province']==$k) echo "selected"; ?>>{$citys[$k]}</option>
                                            </foreach>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>所在城市：</label>
                                        <select id="s_city" class="form-control" name="info[city]">
                                            <option class="form-control" value="">请先选择省份</option>
                                            <?php if ($partner){ ?>
                                                <foreach name="citys" key="k" item="v">
                                                    <option class="form-control" value="{$k}" <?php if ($partner && $partner['city']==$k) echo "selected"; ?>>{$citys[$k]}</option>
                                                </foreach>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>产品负责人：</label>
                                        <input type="text" name="info[auth_user_name]" id="auth_user_name" value="{$row.auth_user_name}"  class="form-control" required />
                                        <input type="hidden" name="info[auth_user_id]" id="auth_user_id" value="{$row.auth_user_id}" />
                                    </div>

                                    <div class="form-group col-md-12" id="applyProjectKind">
                                        <label>适用项目类型</label>
                                        <div>
                                            <foreach name="kinds" key="k" item="v">
                                                <span class="lm_c"><input type="radio" name="business_dept" <?php if($business_dept == $v['id']){ echo 'checked';} ?>  value="{$v.id}"> {$v.name}</span>
                                            </foreach>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label>产品特色</label>
                                        <?php echo editor('content',$row['content']); ?>
                                    </div>
                                    <div class="form-group">&nbsp;</div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">产品内容</h3>
                                </div>
                                <div class="box-body">
                                    <div class="content">
                                        <div class="content" style="padding-top:0px;">
                                            <div id="standardProduct">
                                                <div class="userlist" id="product_id">
                                                    <div class="unitbox name_box">时间</div>
                                                    <div class="unitbox name_box">课程主题</div>
                                                    <div class="unitbox name_box">课程内容</div>
                                                    <div class="unitbox name_box">可选模块</div>
                                                    <div class="unitbox name_box">备注</div>
                                                </div>
                                                <?php if($product){ ?>
                                                    <foreach name="product" key="k" item="v">
                                                        <div class="userlist" id="product_id_{$v.id}">
                                                            <span class="title"><?php echo $k+1; ?></span>
                                                            <input type="hidden" name="resid[888{$v.id}][id]" value="{$v.id}" />
                                                            <input type="hidden" name="product[888{$v.id}][product_id]" id="888{$v.id}_pid" value="{$v['product_id']}" />
                                                            <input type="text" class="form-control name_box" name="product[888{$v.id}][product]" value="{$v.product}" />
                                                            <input type="text" class="form-control name_box" name="product[888{$v.id}][spec]" value="{$v.spec}" />
                                                            <input type="text" class="form-control name_box" name="product[888{$v.id}][amount]" value="{$v.amount}" />
                                                            <!--<input type="text" class="form-control name_box" name="product[888{$v.id}][unitprice]" value="{$v.unitprice}" id="888{$v.id}_pname" onfocus="selectproduct(888{$v.id})" />-->
                                                            <input type="text" class="form-control name_box" name="product[888{$v.id}][unitprice]" value="{$v.unitprice}" id="888{$v.id}_pname" onfocus="checkProjectKind(888{$v.id})" />
                                                            <input type="text" class="form-control name_box" name="product[888{$v.id}][remarks]" value="{$v.remarks}">
                                                            <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('product_id_{$v.id}')">删除</a>
                                                        </div>
                                                    </foreach>
                                                <?php }else{ ?>
                                                    <div class="userlist" id="product_id_0">
                                                        <span class="title">1</span>
                                                        <input type="hidden" name="product[0][product_id]" id="0_pid" />
                                                        <input type="text" class="form-control name_box" name="product[0][product]" />
                                                        <input type="text" class="form-control name_box" name="product[0][spec]" />
                                                        <input type="text" class="form-control name_box" name="product[0][amount]" />
                                                        <!--<input type="text" class="form-control name_box" name="product[0][unitprice]" id="0_pname" onfocus="selectproduct(0)" />-->
                                                        <input type="text" class="form-control name_box" name="product[0][unitprice]" id="0_pname" onfocus="checkProjectKind(0)" />
                                                        <input type="text" class="form-control name_box" name="product[0][remarks]">
                                                        <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('product_id_0')">删除</a>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <div id="product_val">0</div>

                                            <a href="javascript:;" class="btn btn-success btn-sm" style="margin-top:15px;" onClick="add_product()"><i class="fa fa-fw fa-plus"></i> 新增内容</a>

                                            <div class="form-group">&nbsp;</div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">产品成本核算</h3>
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
                                                    <div class="unitbox material_name">费用项</div>
                                                    <div class="unitbox longinput">规格</div>
                                                    <div class="unitbox material_name">单价</div>
                                                    <div class="unitbox material_name">数量</div>
                                                    <div class="unitbox material_name">合计价格</div>
                                                    <div class="unitbox material_name">类型</div>
                                                    <div class="unitbox longinput">供方</div>
                                                    <div class="unitbox longinput">备注</div>
                                                </div>
                                                <?php if($material){ ?>
                                                    <foreach name="material" key="mk" item="mv">
                                                        <div class="userlist" id="material_id_{$mv.id}">
                                                            <span class="title"><?php echo $mk+1; ?></span>
                                                            <input type="hidden" name="resid[888{$mv.id}][id]" value="{$mv.id}" >
                                                            <input type="text" class="form-control material_name" name="material[888{$mv.id}][material]" value="{$mv.material}">
                                                            <input type="text" class="form-control longinput" name="material[888{$mv.id}][spec]" value="{$mv.spec}">
                                                            <input type="text" class="form-control cost" name="material[888{$mv.id}][unitprice]" value="{$mv.unitprice}" onblur="total()">
                                                            <input type="text" class="form-control amount" name="material[888{$mv.id}][amount]" value="{$mv.amount}" onblur="total()">
                                                            <input type="text" class="form-control total" name="material[888{$mv.id}][total]" value="{$mv.total}">
                                                            <select class="form-control"  name="material[888{$mv.id}][type]" onchange="check_material_type(888{$mv.id},$(this).val())" >
                                                                <foreach name="cost_type" key="key" item="value">
                                                                    <option value="{$key}" <?php if ($mv['type']==$key){ echo 'selected'; } ?>>{$value}</option>
                                                                </foreach>
                                                            </select>
                                                            <span id="888{$mv.id}_channel">
                                                <input type="hidden" id="[888{$mv.id}]_supplierRes_id" name="material[888{$mv.id}][supplierRes_id]" value="{$mv.supplierRes_id}">
                                                <input type="text" id="[888{$mv.id}]_supplierRes_name" class="form-control longinput" name="material[888{$mv.id}][channel]" value="{$mv.channel}">
                                            </span>
                                                            <input type="text" class="form-control longinput" name="material[888{$mv.id}][remarks]" value="{$mv.remarks}">
                                                            <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('material_id_{$mv.id}')">删除</a>
                                                        </div>
                                                    </foreach>
                                                <?php }else{ ?>
                                                    <div class="userlist" id="material_id_0">
                                                        <span class="title">1</span>
                                                        <input type="text" class="form-control material_name" name="material[0][material]" onblur="check_ptype()">
                                                        <input type="text" class="form-control longinput" name="material[0][spec]">
                                                        <input type="text" class="form-control cost" name="material[0][unitprice]" onblur="total()">
                                                        <input type="text" class="form-control amount" name="material[0][amount]" onblur="total()">
                                                        <input type="text" class="form-control total" name="material[0][total]">
                                                        <select class="form-control"  name="material[0][type]" onchange="check_material_type(0,$(this).val())">
                                                            <foreach name="cost_type" key="k" item="v">
                                                                <option value="{$k}" <?php if ($v['type']==$k){ echo 'selected'; } ?>>{$v}</option>
                                                            </foreach>
                                                        </select>
                                                        <span id="0_channel">
                                                <input type="hidden" id="0_supplierRes_id" name="material[0][supplierRes_id]" value="">
                                                <input type="text" id="0_supplierRes_name" class="form-control longinput" name="material[0][channel]">
                                            </span>
                                                        <input type="text" class="form-control longinput" name="material[0][remarks]">
                                                        <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('material_id_0')">删除</a>
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
                                    <h3 class="box-title">上传相关附件</h3>
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
                            </form>

                            <div id="formsbtn" style="padding-bottom:10px;">
                                <div class="content">
                                    <form method="post" action="{:U('Product/public_save')}" name="auditform" id="appsubmint">
                                        <input type="hidden" name="dosubmit" value="1">
                                        <input type="hidden" name="savetype" value="5">
                                        <input type="hidden" name="product_id" value="{$row.id}">
                                    </form>
                                    <button type="button" onClick="check_myform()" class="btn btn-info btn-lg" style=" padding-left:40px; padding-right:40px; margin-right:10px;">保存</button>
                                    <button type="button" onClick="apply_audit()" class="btn btn-success btn-lg" style=" padding-left:40px; padding-right:40px; margin-left:10px;">申请审批</button>
                                </div>
                            </div>
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                </section><!-- /.content -->
                
            </aside><!-- /.right-side -->

  </div>
</div>

<include file="Index:footer2" />

<script type="text/javascript"> 

	$(document).ready(function() {
        var keywords        = {$userkey};
        autocomplete_id('auth_user_name','auth_user_id',keywords);
        check_hesuan(); //核算模式

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
				max_file_size : '50mb',
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

    //新增物资
    function add_product(){
        var i = parseInt($('#product_val').text())+1;
        var html = '<div class="userlist" id="product_id_'+i+'">' +
        '<span class="title"></span>' +
        '<input type="hidden" name="product['+i+'][product_id]" id="'+i+'_pid" />'+
        '<input type="text" class="form-control name_box" name="product['+i+'][product]">' +
        '<input type="text" class="form-control name_box" name="product['+i+'][spec]" value="">' +
        '<input type="text" class="form-control name_box" name="product['+i+'][amount]">' +
        /*'<input type="text" class="form-control name_box" name="product['+i+'][unitprice]" id="'+i+'_pname" onfocus="selectproduct('+i+')">' +*/
        '<input type="text" class="form-control name_box" name="product['+i+'][unitprice]" id="'+i+'_pname" onfocus="checkProjectKind('+i+')">' +
        '<input type="text" class="form-control name_box" name="product['+i+'][remarks]">' +
        '<a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox(\'product_id_'+i+'\')">删除</a>' +
        '</div>';
        $('#standardProduct').append(html);
        $('#product_val').html(i);
        orderno();
    }

    //编号
    function orderno(){
        $('#standardProduct').find('.title').each(function(index, element) {
            $(this).text(parseInt(index)+1);
        });
    }
	
	//移除
	function delbox(obj){
		$('#'+obj).remove();
	}

    /*//选择产品模块
    function selectproduct(num) {
        art.dialog.open("<?php echo U('Product/select_product_module',array('id'=>$id)); ?>",{
            lock:true,
            title: '选择产品模块',
            width:1000,
            height:500,
            okValue: '提交',
            fixed: true,
            ok: function () {
                var origin = artDialog.open.origin;
                var product = this.iframe.contentWindow.gosubmint();
                var product_id = product.id;
                var product_title = product.title;
                $('#'+num+'_pid').val(product_id);
                $('#'+num+'_pname').val(product_title);
            },
            cancelValue:'取消',
            cancel: function () {
            }
        });
    }*/

    //根据适用项目类型获取相应标准化产品模块
    function checkProjectKind(num){
        var projectKind = $('#applyProjectKind').find('ins').parent('div[aria-checked="true"]').children('input[name="business_dept"]').val();
        if (!projectKind){
            art_show_msg('请先选择适用项目类型',3);
            return false;
        }else{
            select_standard_module(num,projectKind);
        }
    }

    //选择标准化模块
    function select_standard_module(num,projectKind) {
        art.dialog.open("/index.php?m=Main&c=Product&a=public_select_standard_module&projectKind="+projectKind,{
            lock:true,
            title: '选择产品模块',
            width:1000,
            height:500,
            okValue: '提交',
            fixed: true,
            ok: function () {
                var origin = artDialog.open.origin;
                var product = this.iframe.contentWindow.gosubmint();
                var product_id = product.id;
                var product_title = product.title;
                $('#'+num+'_pid').val(product_id);
                $('#'+num+'_pname').val(product_title);
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

    //省市联动(所在地)
    $('#s_province').change(function () {
        var province    = $(this).val();
        if (province){
            $.ajax({
                type : 'POST',
                url : "<?php echo U('Ajax/get_city'); ?>",
                dataType : 'JSON',
                data : {province:province},
                success : function (msg) {
                    $("#s_city").empty();
                    $("#s_country").html('<option class="form-control" value="">请先选择城市</option>');
                    if (msg.length>0){
                        var count = msg.length;
                        var i= 0;
                        var b="";
                        b+='<option value="" disabled selected>请选择</option>';
                        for(i=0;i<count;i++){
                            b+="<option value='"+msg[i].id+"'>"+msg[i].name+"</option>";
                        }
                    }else{
                        var b="";
                        b+='<option value="" disabled selected>暂无数据</option>';
                    }
                    $("#s_city").append(b);
                }
            })
        }else{
            art_show_msg('省份信息错误',3);
        }
    })

    //市县联动(所在地)
    /*$('#s_city').change(function () {
        var city     = $(this).val();
        if (city){
            $.ajax({
                type : 'POST',
                url : "<?php echo U('Ajax/get_country'); ?>",
                dataType : 'JSON',
                data : {city:city},
                success : function (msg) {
                    $("#s_country").empty();
                    if (msg.length>0){
                        var count = msg.length;
                        var i= 0;
                        var b="";
                        b+='<option value="" disabled selected>请选择</option>';
                        for(i=0;i<count;i++){
                            b+="<option value='"+msg[i].id+"'>"+msg[i].name+"</option>";
                        }
                    }else{
                        var b="";
                        b+='<option value="" disabled selected>暂无数据</option>';
                    }
                    $("#s_country").append(b);
                }
            })
        }else{
            art_show_msg('城市信息错误',3);
        }
    })*/

    //检查核算模式
    function check_ptype(){
        var hesuan_result = $('#hesuan_result').html();
        if(hesuan_result==''){
            alert('请选择核算模式');
        }
    }

    //核算模式
    function check_hesuan(){
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
    }

    //新增物资
    function add_material(){
        var i = parseInt($('#material_val').text())+1;

        var html = '<div class="userlist" id="material_'+i+'">' +
            '<span class="title"></span>' +
            '<input type="text" class="form-control material_name" name="material['+i+'][material]">' +
            '<input type="text" class="form-control longinput" name="material['+i+'][spec]" value="">' +
            '<input type="text" class="form-control cost" name="material['+i+'][unitprice]" onblur="total()">' +
            '<input type="text" class="form-control amount" name="material['+i+'][amount]" onblur="total()">' +
            '<input type="text" class="form-control total" name="material['+i+'][total]">' +
            '<select class="form-control"  name="material['+i+'][type]" onchange="check_material_type('+i+',$(this).val())">' +
            '<foreach name="cost_type" key="k" item="v">'+
            '<option value="{$k}" <?php if ($v["type"]==$k){ echo "selected"; } ?>>{$v}</option>'+
            '</foreach>'+
            '</select>' +
            '<span id="'+i+'_channel"><input type="text" class="form-control longinput" name="material['+i+'][channel]" value=""></span>' +
            '<input type="text" class="form-control longinput" name="material['+i+'][remarks]">' +
            '<a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox(\'material_'+i+'\')">删除</a>' +
            '</div>';
        $('#material').append(html);
        $('#material_val').html(i);
        orderno();
        keywords();
    }

    //关键字联想
    function keywords(){
        var keywords = <?php echo $material_key; ?>;
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

    //保存
    function check_myform() {
        let title           = $('#title').val().trim();
        let province        = $('#s_province').val();
        let city            = $('#s_city').val();
        let auth_user_id    = $('#auth_user_id').val();

        if (!title){        art_show_msg('模块名称不能为空',3);    return false; }
        if (!province){     art_show_msg('所在省份不能为空',3);    return false; }
        if (!city){         art_show_msg('所在城市不能为空',3);    return false; }
        if (!auth_user_id){ art_show_msg('产品负责人信息错误',3);  return false; }
        $('#myform').submit();
    }

    //提交审核审核
    function apply_audit(){
        let id              = $('input[name="id"]').val();
        if (!id) {  art_show_msg('请先保存内容',3); return false;  }
        ConfirmSub('appsubmint','确认申请审批吗？');
    }

    //根据不同的类型调整不同的供方
    function check_material_type(num,costType) {
        var pub_html            = '<input type="text" class="form-control longinput" name="material['+num+'][channel]" value="">';
        var res_html            = '<input type="hidden" id= "'+num+'_supplierRes_id" name="material['+num+'][supplierRes_id]" value="">'+
            '<input type="text" id="'+num+'_supplierRes_name" class="form-control longinput" name="material['+num+'][channel]" value="" onfocus="get_supplierRes('+num+','+costType+')">'; //研究所台站
        if (costType==6){ //研究所台站
            $('#'+num+'_channel').html(res_html);
        }else{
            $('#'+num+'_channel').html(pub_html);
        }
    }

    //选择合格供方
    function get_supplierRes(num,costType){
        var costType            = costType ? costType : 0;
        art.dialog.open("/index.php?m=Main&c=Product&a=public_select_supplierRes&costType="+costType,{
            lock:true,
            title: '选择合格供方',
            width:1000,
            height:500,
            okVal: '提交',
            fixed: true,
            ok: function () {
                var origin     = artDialog.open.origin;
                var supplierRes= this.iframe.contentWindow.gosubmint();
                var res_id     = supplierRes.id;
                var res_name   = supplierRes.name;
                $('#'+num+'_supplierRes_id').val(res_id);
                $('#'+num+'_supplierRes_name').val(res_name);
            },
            cancelValue:'取消',
            cancel: function () {
            }
        });
    }

</script>	
     


