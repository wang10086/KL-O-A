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
                                        <input type="text" name="info[]" id="" value="{$row.}"  class="form-control" required />
                                    </div>

                                    <div class="form-group col-md-12">
                                        <span class="lm_c black">适用项目类型</span>
                                        <foreach name="kinds" key="k" item="v">
                                            <span class="lm_c"><input type="checkbox" name="business_dept[]" <?php if(in_array($v['id'],$business_dept)){ echo 'checked';} ?>  value="{$v.id}"> {$v.name}</span>
                                        </foreach>
                                    </div>

                                    <div class="form-group col-md-12"></div>
                                    <div class="form-group col-md-12">
                                        <label>产品特色</label>
                                        <?php echo editor('content',$row['content']); ?>
                                    </div>
                                    <div class="form-group">&nbsp;</div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

                            <!--<div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">产品内容</h3>
                                </div>
                                <div class="box-body">
                                    <div class="content">
                                        <div class="content" style="padding-top:0px;">
                                            <div class="form-group col-md-12" id="reslist" style="display:block;">
                                                <table class="table table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th width="15%">时间</th>
                                                        <th width="15%">课程主题</th>
                                                        <th width="20%">课程内容</th>
                                                        <th width="15%">可选模块</th>
                                                        <th width="">备注</th>
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

                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>-->
                                <style>
                                    #standardProduct{ padding:0; margin-top:-20px;}
                                    #standardProduct .form-control{ width:110px; float:left; margin-right:10px; border-radius:0;}
                                    #standardProduct .unitbox{ float:left; clear:none; border:none; padding:0; line-height:42px;}
                                    #standardProduct .title{ width:22px; float:left; height:30px; line-height:30px; margin-left:-30px; text-align:right; position:relative; z-index:100;}
                                    #standardProduct .userlist { width:100%; height:auto !important; float:left; clear:both; padding-bottom:15px; border-bottom:1px solid #cccccc; margin-top:15px;}
                                    #standardProduct .btn{ padding:7px 12px; font-size:12px;}
                                    #standardProduct td{ line-height:34px;}
                                    #material_val{ display:none}
                                    #standardProduct .material_name{ width:17%;margin-right: 10px;}
                                    #standardProduct .longinput{ width:90px;}
                                </style>

                                <div class="box box-warning">
                                    <div class="box-header">
                                        <h3 class="box-title">产品内容</h3>
                                    </div>
                                    <div class="box-body">
                                        <div class="content">
                                            <div class="content" style="padding-top:0px;">
                                                <div id="standardProduct">
                                                    <div class="userlist" id="material_id">
                                                        <div class="unitbox material_name">时间</div>
                                                        <div class="unitbox material_name">课程主题</div>
                                                        <div class="unitbox material_name">课程内容</div>
                                                        <div class="unitbox material_name">可选模块</div>
                                                        <div class="unitbox material_name">备注</div>
                                                    </div>
                                                    <?php if($material){ ?>
                                                        <foreach name="material" key="k" item="v">
                                                            <div class="userlist" id="material_id_{$v.id}">
                                                                <span class="title"><?php echo $k+1; ?></span>
                                                                <input type="hidden" name="resid[888{$v.id}][id]" value="{$v.id}" >
                                                                <input type="text" class="form-control material_name" name="material[888{$v.id}][material]" value="{$v.material}">
                                                                <input type="text" class="form-control material_name" name="material[888{$v.id}][spec]" value="{$v.spec}">
                                                                <input type="text" class="form-control material_name" name="material[888{$v.id}][amount]" value="{$v.amount}">
                                                                <input type="text" class="form-control material_name" name="material[888{$v.id}][unitprice]" value="{$v.unitprice}">
                                                                <input type="text" class="form-control total" name="material[888{$v.id}][total]" value="{$v.total}" onfocus="selectproduct()">
                                                                <input type="text" class="form-control material_name" name="material[888{$v.id}][remarks]" value="{$v.remarks}">
                                                                <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('material_id_{$v.id}')">删除</a>
                                                            </div>
                                                        </foreach>
                                                    <?php }else{ ?>
                                                        <div class="userlist" id="material_id">
                                                            <span class="title">1</span>
                                                            <input type="text" class="form-control material_name" name="material[0][material]">
                                                            <input type="text" class="form-control material_name" name="material[0][spec]">
                                                            <input type="text" class="form-control material_name" name="material[0][amount]">
                                                            <input type="text" class="form-control material_name" name="material[0][unitprice]" onfocus="selectproduct()">
                                                            <input type="text" class="form-control material_name" name="material[0][remarks]">
                                                            <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('material_id')">删除</a>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                                <div id="material_val">0</div>

                                                <a href="javascript:;" class="btn btn-success btn-sm" style="margin-top:15px;" onClick="add_material()"><i class="fa fa-fw fa-plus"></i> 新增内容</a>

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


                            <div id="formsbtn">
                            	<!--<button type="submit" class="btn btn-info btn-lg" id="lrpd">保存</button>-->
                            	<button type="button" onclick="art_show_msg('加班开发中...',3)" class="btn btn-info btn-lg" id="lrpd">保存</button>
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

    //新增物资
    function add_material(){
        var i = parseInt($('#material_val').text())+1;

        var html = '<div class="userlist" id="material_'+i+'">' +
            '<span class="title"></span>' +
            '<input type="text" class="form-control material_name" name="material['+i+'][material]">' +
            '<input type="text" class="form-control material_name" name="material['+i+'][spec]" value="">' +
            '<input type="text" class="form-control material_name" name="material['+i+'][amount]">' +
            '<input type="text" class="form-control material_name" name="material['+i+'][unitprice]" onfocus="selectproduct()">' +
            '<input type="text" class="form-control material_name" name="material['+i+'][remarks]">' +
            '<a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox(\'material_'+i+'\')">删除</a>' +
            '</div>';
        $('#standardProduct').append(html);
        $('#material_val').html(i);
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

</script>	
     


