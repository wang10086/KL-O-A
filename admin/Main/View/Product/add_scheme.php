<include file="Index:header2" />


        <aside class="right-side">
            <section class="content-header">
                <h1>{$_action_}</h1>
                <ol class="breadcrumb">
                    <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                    <li><a href="{:U('Product/public_scheme')}"><i class="fa fa-gift"></i>{$_action_} </a></li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <form method="post" action="{:U('Product/add_scheme')}" name="myform" id="myform">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-warning mt20">
                            <div class="box-header">
                                <h3 class="box-title">产品方案需求基本信息</h3>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <input type="hidden" name="dosubmit" value="1" />
                                <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
                                <input type="hidden" name="savetype" value="1">
                                <input type="hidden" name="id" value="{$oplist.scheme_id}">
                                <div class="form-group col-md-4">
                                    <label>项目名称：</label>
                                    <select  class="form-control"  name="op_id" onchange="get_op_data($(this).val())" <?php if ($oplist['scheme_id']) echo 'readonly';  ?>>
                                        <option value="">请选项目</option>
                                        <foreach name="projects" key="k" item="v">
                                            <option value="{$k}" <?php if ($oplist['op_id'] == $k) echo "selected" ?> > {$v}</option>
                                        </foreach>
                                    </select>
                                    <foreach>

                                    </foreach>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>项目类型：</label>
                                    <input type="text" name="" value="{$oplist.kind}" id="kind" class="form-control" readonly />
                                </div>

                                <div class="form-group col-md-4">
                                    <label>适合人群：</label>
                                    <input type="text" name="" value="{$oplist.apply_to}" id="apply_to" class="form-control" readonly />
                                </div>

                                <div class="form-group col-md-4">
                                    <label>预计人数：</label>
                                    <input type="text" name="" value="{$oplist.number}" id="number" class="form-control" readonly />
                                </div>

                                <div class="form-group col-md-4">
                                    <label id="ctrq">计划出团日期：</label>
                                    <input type="text" name="" value="{$oplist.departure}" id="departure" class="form-control" readonly />
                                </div>

                                <div class="form-group col-md-4">
                                    <label id="xcts">行程天数：</label>
                                    <input type="text" name="" value="{$oplist.days}" id="days" class="form-control" readonly />
                                </div>

                                <div class="form-group col-md-4">
                                    <label>目的地：</label>
                                    <input type="text" name="" value="{$oplist.destination}" id="destination" class="form-control" readonly />
                                </div>


                                <div class="form-group col-md-4">
                                    <label>客户单位：</label>
                                    <input type="text" name="" value="{$oplist.customer}" id="customer" class="form-control" readonly />
                                </div>

                                <div class="form-group col-md-4">
                                    <label>接待实施部门</label>
                                    <input type="text" name="" value="{$oplist.dijie_department}" id="dijie_department" class="form-control" readonly />
                                </div>

                                <div class="form-group col-md-4">
                                    <label>线控负责人：</label>
                                    <input type="text" name="" value="{$oplist.line_blame_name}" id="line_blame_name" class="form-control" readonly />
                                </div>

                                <div class="form-group col-md-4">
                                    <label>客户预算：</label>
                                    <input type="text" name="" value="{$oplist.cost}" id="cost" class="form-control"  readonly />
                                </div>

                                <div class="form-group col-md-4">
                                    <label>业务：</label>
                                    <input type="text" name="" value="{$oplist.sale_user}" id="sale_user" class="form-control" readonly />
                                </div>

                                <div class="form-group col-md-12">
                                    <label>备注：</label><textarea  name="" class="form-control" id="remark" readonly >{$oplist.remark}</textarea>
                                </div>

                                <div class="form-group">&nbsp;</div>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->

                    </div><!--/.col (right) -->
                </div>   <!-- /.row -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-warning">
                            <div class="box-header">
                                <h3 class="box-title">选择产品模块</h3>
                                <div class="box-tools pull-right">

                                     <a href="javascript:;" class="btn btn-danger btn-sm" onclick="selectmodel()">选择模块</a>
                                </div>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                            <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                <tr role="row" class="orders" >
                                    <th width="80">ID</th>
                                    <th>模块名称</th>
                                    <th width="120">专家</th>
                                    <th width="50" class="taskOptions">删除</th>
                                </tr>

                                <?php
                                foreach($pro_lists as $row){
                                    echo '<tr id="tpl_a99999'.$row['id'].'"><td><input type="hidden" name="pro[]" value="'.$row['id'].'">'.$row['id'].'</td><td><a href="'.U('Product/view', array('id'=>$row['id'])).'" target="_blank">'.$row['title'].'</a></td><td>'.$row['input_uname'].'</td><td class="taskOptions"><button onClick="javascript:del_timu(\'tpl_a99999'.$row['id'].'\')" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button></td></tr>';
                                }
                                ?>

                            </table>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->

                    </div><!--/.col (right) -->
                </div>   <!-- /.row -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-warning">
                            <div class="box-header">
                                <h3 class="box-title">选择产品实施方案模板</h3>
                                <div class="box-tools pull-right">
                                     <a href="javascript:;" class="btn btn-success btn-sm" onclick="selecttpl()">选择模板</a>
                                </div>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                            <table class="table table-bordered dataTable fontmini" id="tablelist_model" style="margin-top:10px;">
                                <tr role="row" class="orders" >
                                    <th width="80">ID</th>
                                    <th>模板名称</th>
                                    <th width="120">专家</th>
                                    <th width="50" class="taskOptions">删除</th>
                                </tr>

                                <?php
                                foreach($pro_model_lists as $row){
                                    echo '<tr id="tpl_b99999'.$row['id'].'"><td><input type="hidden" name="pro_model[]" value="'.$row['id'].'">'.$row['id'].'</td><td><a href="'.U('Product/model_view', array('id'=>$row['id'])).'" target="_blank">'.$row['title'].'</a></td><td>'.$row['input_uname'].'</td><td class="taskOptions"><button onClick="javascript:del_timu(\'tpl_b99999'.$row['id'].'\')" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button></td></tr>';
                                }
                                ?>
                            </table>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div><!--/.col (right) -->
                </div>   <!-- /.row -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-warning">
                            <div class="box-header">
                                <h3 class="box-title">选择参考产品实施方案</h3>
                                <div class="box-tools pull-right">
                                    <a href="javascript:;" class="btn btn-success btn-sm" onclick="select_line()">选择方案</a>
                                </div>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <table class="table table-bordered dataTable fontmini" id="tablelist_line" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th width="80">ID</th>
                                        <th>方案名称</th>
                                        <th width="120">上传人员</th>
                                        <th width="50" class="taskOptions">删除</th>
                                    </tr>
                                    <?php
                                        foreach ($line_lists as $row){
                                            echo '<tr id="tpl_c99999'.$row['id'].'"><td><input type="hidden" name="line[]" value="'.$row['id'].'">'.$row['id'].'</td><td><a href="'. U('Product/view_line', array('id'=>$row['id'])).'" target="_blank">'.$row['title'].'</a></td><td>'.$row['input_uname'].'</td><td class="taskOptions"><button onClick="javascript:del_timu(\'tpl_c99999'.$row['id'].'\')" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button></td></tr>';
                                        }
                                    ?>
                                </table>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div><!--/.col (right) -->
                </div>   <!-- /.row -->

                <div class="row">
                    <div class="col-md-12">
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
                                        <foreach name="atta_lists" item="v">
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
                                        <foreach name="atta_lists" item="v">
                                        <input type="hidden" rel="aid_{$v.id}" name="resfiles[]" value="{$v.id}" />
                                        </foreach>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>

                    <div id="formsbtn">
                        <button type="submit" class="btn btn-info btn-lg" id="lrpd">保存</button>
                    </div>

                </div>
                </form>
            </section><!-- /.content -->

        </aside><!-- /.right-side -->
  </div>
</div>

<include file="Index:footer2" />

		<script type="text/javascript">

            $(document).ready(function(e) {
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
                        max_file_size : '10mb',
                        mime_types: [
                            {title : "Files", extensions : "jpg,jpeg,png,zip,rar,7z,doc,docx,ppt,pptx,xls,xlsx,txt,pdf"}
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

                //closebtns();
            });

            function removeThisFile(fid) {
                if (confirm('确定要删除此附件吗？')) {
                    $('#' + fid).empty().remove();
                    $('input[rel=' + fid +']').remove();
                }
            }
            
            //获取项目基本信息
            function get_op_data(opid) {
                if (!opid){ art_show_msg('项目名称错误',2); return false; }
                $.ajax({
                    type: 'POST',
                    datatype : 'JSON',
                    url : "{:U('Ajax/get_op_data')}",
                    data: {opid:opid},
                    success(data){
                        $('#kind').val(data.kind);
                        $('#apply_to').val(data.apply_to);
                        $('#number').val(data.number);
                        $('#departure').val(data.departure);
                        $('#days').val(data.days);
                        $('#destination').val(data.destination);
                        $('#customer').val(data.customer);
                        $('#dijie_department').val(data.dijie_department);
                        $('#line_blame_name').val(data.line_blame_name);
                        $('#cost').val(data.cost);
                        $('#sale_user').val(data.sale_user);
                        $('#remark').html(data.remark);
                    },
                    error(){
                       console.log('error');
                    }

                })
            }

            //选择参考产品实施方案(原 线路)
            function select_line() {
                var linehtml = '';
                art.dialog.open('<?php echo U('Product/select_line'); ?>',{
                    lock:true,
                    title: '选择行程线路',
                    width:1000,
                    height:500,
                    okValue: '提交',
                    fixed: true,
                    ok: function () {
                        var origin      = artDialog.open.origin;
                        var line        = this.iframe.contentWindow.gosubmint();

                        for (var i = 0; i < line.length; i++) {
                            if (line[i].id) {
                                linehtml += '<tr id="tpl_a_'+line[i].id+'"><td><input type="hidden" name="line[]" value="'+line[i].id+'">'+line[i].id+'</td><td><a href="<?php echo U('Product/view_line'); ?>&id='+line[i].id+'" target="_blank">'+line[i].title+'</a></td><td>'+line[i].input_uname+'</td><td class="taskOptions"><button onClick="javascript:del_timu(\'tpl_a_'+line[i].id+'\')" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button></td></tr>';
                            }
                        }
                        $('#tablelist_line').find('tbody').append(linehtml);

                    },
                    cancelValue:'取消',
                    cancel: function () {
                    }
                });
            }

		//选择模板
		function selecttpl() {
			var modelhtml = '';
			art.dialog.open('<?php echo U('Product/select_tpl'); ?>',{
				lock:true,
				title: '选择模板',
				width:860,
				height:500,
				okValue: '提交',
				fixed: true,
				ok: function () {
					var origin = artDialog.open.origin;
					var model = this.iframe.contentWindow.gosubmint();
					for (var i = 0; i < model.length; i++) {
						if (model[i].id) {
							modelhtml += '<tr id="tpl_b_'+model[i].id+'"><td><input type="hidden" name="pro_model[]" value="'+model[i].id+'">'+model[i].id+'</td><td><a href="<?php echo U('Product/model_view'); ?>&id='+model[i].id+'" target="_blank">'+model[i].title+'</a></td><td>'+model[i].input_uname+'</td><td class="taskOptions"><button onClick="javascript:del_timu(\'tpl_b_'+model[i].id+'\')" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button></td></tr>';
						}
					}
					$('#tablelist_model').find('tbody').append(modelhtml);
				},
				cancelValue:'取消',
				cancel: function () {
				}
			});
		}



		//选择模块
		function selectmodel() {
			var mokuaihtml = '';
			art.dialog.open('<?php echo U('Product/select_product'); ?>',{
				lock:true,
				title: '选择模块',
				width:1100,
				height:500,
				okValue: '提交',
				fixed: true,
				ok: function () {
					var origin = artDialog.open.origin;
					var mokuai = this.iframe.contentWindow.gosubmint();
					for (var i = 0; i < mokuai.length; i++) {
						if (mokuai[i].id) {
							mokuaihtml += '<tr id="tpl_c_'+mokuai[i].id+'"><td><input type="hidden" name="pro[]" value="'+mokuai[i].id+'">'+mokuai[i].id+'</td><td><a href="<?php echo U('Product/view'); ?>&id='+mokuai[i].id+'" target="_blank">'+mokuai[i].title+'</a></td><td>'+mokuai[i].input_uname+'</td><td class="taskOptions"><button onClick="javascript:del_timu(\'tpl_c_'+mokuai[i].id+'\')" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button></td></tr>';
						}
					}
					$('#tablelist').find('tbody').append(mokuaihtml);
				},
				cancelValue:'取消',
				cancel: function () {
				}
			});
		}

		/*function task_tag(){

			var i = parseInt($('#task_tag_val').text())+1;

			var html = '<div class="col-md-2 pd" id="tag_'+i+'"><div class="input-group"><input type="text" placeholder="标签" name="tag[]" class="form-control"><span class="input-group-addon" style="width:32px;"><a href="javascript:;"  onClick="deltag(\'tag_'+i+'\')">X</a></span></div></div>';

			$('#task_tag_list').append(html);
			$('#task_tag_val').html(i);
		}


		function deltag(obj){
			$('#'+obj).remove();
		}*/

		/*function task(obj){

			var i = parseInt($('#task_val').text())+1;

			var days = '<div class="input-group"><input type="text" placeholder="所在城市" name="days['+i+'][citys]" class="form-control"></div><div class="input-group pads"><textarea class="form-control" placeholder="行程安排"  name="days['+i+'][content]"></textarea></div><div class="input-group"><input type="text" placeholder="房餐车安排" name="days['+i+'][remarks]" class="form-control"></div>';


			var header = '<div class="tasklist" id="task_ti_'+i+'"><a class="aui_close" href="javascript:;" onClick="del_timu(\'task_ti_'+i+'\')">×</a><div class="col-md-12 pd"><label class="titou"><strong>第<span class="tihao">'+i+'</span>天</strong></label>';

			var footer = '</div></div>';


			var html = header+days+footer;

			$('#task_timu').append(html);
			$('#task_val').html(i);
			//重编题号
			$('.tihao').each(function(index, element) {
				 var no = index*1+1;
               $(this).text(no);
            });
		}*/

		//移除题目
		function del_timu(obj){
			$('#'+obj).remove();
		}


		/*//线路种类(普通行程 和 固定线路)
        function check_type(){
            var type = $('#line_type').val();
            var lpcon= $('#hide').html();
            if (type ==2){
                $('#show_or_hide').show();
                $('#show_or_hide').html(lpcon);
            }else{
                $('#show_or_hide').hide();
                $('#show_or_hide').html('');
            }
        }

        //新增常规价格政策
        function add_pretium(){
            var i = parseInt($('#pretium_val').text())+1;
            var html = '<div class="userlist no-border" id="pretium_'+i+'"><span class="title"></span><input type="text" class="form-control" name="cost['+i+'][pname]" value=""><input type="text"  class="form-control" name="cost['+i+'][price]" id="price_'+i+'"><input type="text"  class="form-control" name="cost['+i+'][num]" id="num_'+i+'" onblur="sum_price('+i+')"><input type="text"  class="form-control" name="cost['+i+'][sum]" id="sum_'+i+'"><input type="text"  class="form-control lp_remark" name="cost['+i+'][remark]"><a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox(\'pretium_'+i+'\')">删除</a></div>';
            $('#pretium').append(html);
            $('#pretium_val').html(i);
            orderno();
        }

        //新增可选(星级)价格政策
        function add_choose(){
            var i = parseInt($('#choose_val').text())+1;
            var html = '<div class="userlist no-border" id="choose_'+i+'"><span class="title"></span> <select  class="form-control"  name="carHotel['+i+'][start]"> <option value="" selected disabled>请选择</option> <foreach name="hotel_start" key="k" item="v"> <option value="{$k}">{$v}</option> </foreach> </select> <input type="text"  class="form-control" name="carHotel['+i+'][num]" ><input type="text"  class="form-control" name="carHotel['+i+'][price]" ><input type="text"  class="form-control lp_remark" name="carHotel['+i+'][remark]"><a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox(\'choose_'+i+'\')">删除</a></div>';
            $('#choose').append(html);
            $('#choose_val').html(i);
            orderno();
        }*/

        //移除
        function delbox(obj){
            $('#'+obj).remove();
            orderno();
        }

        //编号
        function orderno(){
            $('#choose').find('.title').each(function(index, element) {
                $(this).text(parseInt(index)+1);
            });
            $('#pretium').find('.title').each(function(index, element) {
                $(this).text(parseInt(index)+1);
            });
        }

        //求总价
        /*function sum_price(i){
            var price   = $("#price_"+i).val();
            var num     = $("#num_"+i).val();
            if(price && num){
                $("#sum_"+i).val(price*num);
            }else{
                $("#sum_"+i).val(price);
            }
        }*/
</script>



