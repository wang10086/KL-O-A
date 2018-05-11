<include file="Index:header2" />


        <aside class="right-side">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>编辑行程方案</h1>
                <ol class="breadcrumb">
                    <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                    <li><a href="{:U('Product/line')}"><i class="fa fa-gift"></i> 线路管理</a></li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <form method="post" action="{:U('Product/edit_line')}" name="myform" id="myform">
                <div class="row">
                    <!-- right column -->
                    <div class="col-md-12">
                        <!-- general form elements disabled -->
                        <div class="box box-warning">
                            <div class="box-header">
                                <h3 class="box-title">行程方案描述</h3>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <input type="hidden" name="dosubmit" value="1" />
                                <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
                                <input type="hidden" name="line_id" value="{$row.id}" />
                                <!-- text input -->
                                <div class="form-group col-md-8">
                                    <label>线路名称</label>
                                    <input type="text" name="info[title]" id="title" value="{$row.title}"  class="form-control" />
                                </div>

                                <div class="form-group col-md-4">
                                    <label>线路种类</label>
                                    <select  class="form-control"  name="info[type]" onchange="check_type()" id="line_type" required>
                                        <foreach name="line_type" key="k" item="v">
                                            <option value="{$k}" <?PHP if($row['type'] == $k) echo "selected"; ?>> {$v}</option>
                                        </foreach>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>目的地</label>
                                    <input type="text" name="info[dest]" id="dest" value="{$row.dest}"  class="form-control" />
                                </div>

                                <div class="form-group col-md-4">
                                    <label>行程天数</label>
                                    <input type="text" name="info[days]" id="days" value="{$row.days}"  class="form-control" />
                                </div>

                                <div class="form-group col-md-4">
                                    <label>类型</label>
                                    <select  class="form-control"  name="info[kind]">
                                    <option value="0">请选择</option>
                                    <foreach name="kindlist" item="v">
                                        <option value="{$v.id}" <?php if ($row && ($v['id'] == $row['kind'])) echo ' selected'; ?> >{:tree_pad($v['level'], true)}{$v.name}</option>
                                    </foreach>
                                    </select>
                                </div>



                                <div class="form-group col-md-4">
                                    <label>参考价格</label>
                                    <input type="text" name="info[sales_price]" id="sales_price"   value="{$row.sales_price}" class="form-control" />
                                </div>

                                <!--
                                <div class="form-group col-md-4">
                                    <label>同行价格</label>
                                    <input type="text" name="info[peer_price]" id="peer_price" value="{$row.peer_price}"  class="form-control" />
                                </div>
                                -->


                                <div class="form-group col-md-8">
                                    <label>备注</label>
                                    <input type="text" name="info[remarks]" id="remarks" value="{$row.remarks}"  class="form-control" />
                                </div>

                                <div class="form-group">&nbsp;</div>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->

                    </div><!--/.col (right) -->
                </div>   <!-- /.row -->

                <div class="row"  id="show_or_hide">
                    <div class="col-md-12"><!-- general form elements disabled -->
                        <div class="box box-warning">
                            <div class="box-header">
                                <h3 class="box-title">填写价格信息</h3>
                            </div><!-- /.box-header -->

                            <div class="box-body mb-50">
                                <div class="content" style="padding-top:0px;">
                                    <div id="choose">
                                        <h3 class="price-title">可选价格信息(住宿,车辆信息)</h3>
                                        <div class="userlist form-title">
                                            <div class="unitbox">星级</div>
                                            <div class="unitbox">人数</div>
                                            <div class="unitbox">价格</div>
                                            <div class="unitbox lp_remark">备注</div>
                                        </div>
                                        <?php if($carHotel){ ?>
                                            <foreach name="carHotel" key="k" item="v">
                                                <div class="userlist no-border" id="choose_id_{$v.id}">
                                                    <span class="title"><?php echo $k+1; ?></span>
                                                    <select  class="form-control"  name="carHotel[{$k}][start]">
                                                        <foreach name="hotel_start" key="key" item="value">
                                                            <option value="{$key}" <?php if($v['start']==$key) echo 'selected'; ?>>{$value}</option>
                                                        </foreach>
                                                    </select>
                                                    <input type="text" class="form-control" name="carHotel[{$k}][num]" value="{$v.num}">
                                                    <input type="text" class="form-control" name="carHotel[{$k}][price]" value="{$v.price}"  id="check_carhotel">
                                                    <input type="text" class="form-control lp_remark" name="carHotel[{$k}][remark]" value="{$v.remark}">
                                                    <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('choose_id_{$v.id}')">删除</a>
                                                </div>
                                            </foreach>
                                        <?php }else{ ?>
                                            <div class="userlist no-border" id="choose_id">
                                                <span class="title">1</span>
                                                <select  class="form-control"  name="carHotel[1][start]">
                                                    <option value="" selected disabled>请选择</option>
                                                    <foreach name="hotel_start" key="k" item="v">
                                                        <option value="{$k}">{$v}</option>
                                                    </foreach>
                                                </select>
                                                <!--<input type="text" class="form-control" name="carHotel[1][start]" value="">-->
                                                <input type="text" class="form-control" name="carHotel[1][num]" value="">
                                                <input type="text" class="form-control" name="carHotel[1][price]" value="">
                                                <input type="text" class="form-control lp_remark" name="carHotel[1][remark]" value="">
                                                <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('choose_id')">删除</a>
                                            </div>
                                        <?php } ?>
                                    </div>

                                    <div id="choose_val">1</div>
                                    <div class="form-group col-md-12" id="useraddbtns">
                                        <a href="javascript:;" class="btn btn-success btn-sm" onClick="add_choose()"><i class="fa fa-fw fa-plus"></i> 可选价格信息</a>
                                    </div>
                                    <div class="form-group">&nbsp;</div>
                                </div>
                            </div><!-- /.box-body -->

                            <div class="box-body">
                                <div class="content" style="padding-top:0px;">
                                    <div id="pretium">
                                        <h3 class="price-title">常规价格信息</h3>
                                        <div class="userlist form-title">
                                            <div class="unitbox">名称</div>
                                            <div class="unitbox">单价</div>
                                            <div class="unitbox">数量</div>
                                            <div class="unitbox">总价</div>
                                            <div class="unitbox lp_remark">备注</div>
                                        </div>
                                        <?php if($cost){ ?>
                                            <foreach name="cost" key="k" item="v">
                                                <div class="userlist" id="pretium_id_{$v.id}">
                                                    <span class="title"><?php echo $k+1; ?></span>
                                                    <input type="text" class="form-control" name="cost[{$k}][pname]" value="{$v.pname}" id="check_cost">
                                                    <input type="text" class="form-control" name="cost[{$k}][price]" value="{$v.price}" id="price_{$k+1}">
                                                    <input type="text" class="form-control" name="cost[{$k}][num]" value="{$v.num}" id="num_{$k+1}" onblur="sum_price('{$k+1}')">
                                                    <input type="text" class="form-control" name="cost[{$k}][sum]" value="{$v.sum}" id="sum_{$k+1}">
                                                    <input type="text" class="form-control lp_remark" name="cost[{$k}][remark]" value="{$v.remark}">
                                                    <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('pretium_id_{$v.id}')">删除</a>
                                                </div>
                                            </foreach>
                                        <?php }else{ ?>
                                            <div class="userlist" id="pretium_id">
                                                <span class="title">1</span>
                                                <input type="text" class="form-control" name="cost[1][pname]" value="">
                                                <input type="text" class="form-control" name="cost[1][price]" value="" id="price_1">
                                                <input type="text" class="form-control" name="cost[1][num]" value=""  id="num_1" onblur="sum_price(1)">
                                                <input type="text" class="form-control" name="cost[1][sum]" value="" id="sum_1">
                                                <input type="text" class="form-control lp_remark" name="cost[1][remark]" value="">
                                                <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('pretium_id')">删除</a>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div id="pretium_val">1</div>
                                    <div class="form-group col-md-12" id="useraddbtns">
                                        <a href="javascript:;" class="btn btn-success btn-sm" onClick="add_pretium()"><i class="fa fa-fw fa-plus"></i> 常规价格信息</a>
                                    </div>
                                    <div class="form-group">&nbsp;</div>
                                </div>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->

                    </div><!--/.col (right) -->
                </div>   <!-- /.row -->

                <div class="row">
                    <!-- right column -->
                    <div class="col-md-12">
                        <!-- general form elements disabled -->
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
                                foreach($pro_list as $row){
                                    echo '<tr id="tpl_'.$tpl.$row['id'].'"><td><input type="hidden" name="pro[]" value="'.$row['id'].'">'.$row['id'].'</td><td><a href="'.U('Product/view', array('id'=>$row['id'])).'" target="_blank">'.$row['title'].'</a></td><td>'.$row['input_uname'].'</td><td class="taskOptions"><button onClick="javascript:del_timu(\'tpl_'.$tpl.$row['id'].'\')" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button></td></tr>';
                                }
                                ?>
                            </table>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->

                    </div><!--/.col (right) -->
                </div>   <!-- /.row -->


                <div class="row">
                    <!-- right column -->
                    <div class="col-md-12">
                        <!-- general form elements disabled -->
                        <div class="box box-warning">
                            <div class="box-header">
                                <h3 class="box-title">选择产品模板</h3>
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
                                foreach($pro_model_list as $row){
                                    echo '<tr id="tpl_'.$tpl.$row['id'].'"><td><input type="hidden" name="pro_model[]" value="'.$row['id'].'">'.$row['id'].'</td><td><a href="'.U('Product/model_view', array('id'=>$row['id'])).'" target="_blank">'.$row['title'].'</a></td><td>'.$row['input_uname'].'</td><td class="taskOptions"><button onClick="javascript:del_timu(\'tpl_'.$tpl.$row['id'].'\')" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button></td></tr>';
                                }
                                ?>
                            </table>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->

                    </div><!--/.col (right) -->
                </div>   <!-- /.row -->


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

                <div class="row">
                    <div class="col-md-12">
                            <div class="box box-success">
                            <div class="box-header">
                                <h3 class="box-title">日程安排</h3>
                            </div><!-- /.box-header -->
                            <div class="box-body">

                                <div id="task_timu">
                                <?php
                                foreach($days_list as $k=>$row){
                                    echo '<div class="tasklist" id="task_a_'.$row['id'].'"><a class="aui_close" href="javascript:;" onClick="del_timu(\'task_a_'.$row['id'].'\')">×</a><div class="col-md-12 pd"><label class="titou"><strong>第<span class="tihao">'.($k+1).'</span>天</strong></label><div class="input-group"><input type="text" placeholder="所在城市" name="days['.$row['id'].'][citys]" class="form-control" value="'.$row['citys'].'"></div><div class="input-group pads"><textarea class="form-control" placeholder="行程安排"  name="days['.$row['id'].'][content]">'.$row['content'].'</textarea></div><div class="input-group"><input type="text" placeholder="房餐车安排" name="days['.$row['id'].'][remarks]" value="'.$row['remarks'].'" class="form-control"></div></div></div>';
                                }
                                ?>
                                </div>

                                <div style="display:none" id="task_val"><?php echo count($days_list); ?></div>

                                <div class="form-group col-md-12" id="addti_btn">
                                    <a href="javascript:;" class="btn btn-success btn-sm" onClick="task(1)" style="margin-right:10px;"><i class="fa fa-fw  fa-plus"></i> 添加日程</a>
                                </div>


                                <div class="form-group">&nbsp;</div>
                            </div><!-- /.box-body -->
                        </div>

                    </div>

                    <div id="formsbtn">
                        <button type="submit" class="btn btn-info btn-lg" id="lrpd">保存</button>
                    </div>


                </div>   <!-- /.row -->




                </form>
            </section><!-- /.content -->

        </aside><!-- /.right-side -->

        <!----------------------------start------------------------------->
        <div class="row"  id="hide"><!-- right column --><!--js引入使用-->
            <div class="col-md-12"><!-- general form elements disabled -->
                <div class="box box-warning">
                    <div class="box-header">
                        <h3 class="box-title">填写价格信息</h3>
                    </div><!-- /.box-header -->



                    <div class="box-body">
                        <div class="content" style="padding-top:0px;">
                            <div id="pretium">
                                <h3 class="price-title">常规价格信息</h3>
                                <div class="userlist form-title">
                                    <div class="unitbox">名称</div>
                                    <div class="unitbox">单价</div>
                                    <div class="unitbox">数量</div>
                                    <div class="unitbox">总价</div>
                                    <div class="unitbox lp_remark">备注</div>
                                </div>
                                <?php if($cost){ ?>
                                    <foreach name="cost" key="k" item="v">
                                        <div class="userlist no-border" id="pretium_id_{$v.id}">
                                            <span class="title"><?php echo $k+1; ?></span>
                                            <input type="text" class="form-control" name="cost[{$k}][pname]" value="{$v.pname}">
                                            <input type="text" class="form-control" name="cost[{$k}][price]" value="{$v.price}" id="price_{$k+1}">
                                            <input type="text" class="form-control" name="cost[{$k}][num]" value="{$v.num}" id="num_{$k+1}" onblur="sum_price('{$k+1}')">
                                            <input type="text" class="form-control" name="cost[{$k}][sum]" value="{$v.sum}" id="sum_{$k+1}">
                                            <input type="text" class="form-control lp_remark" name="cost[{$k}][remark]" value="{$v.remark}">
                                            <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('pretium_id_{$v.id}')">删除</a>
                                        </div>
                                    </foreach>
                                <?php }else{ ?>
                                    <div class="userlist no-border" id="pretium_id">
                                        <span class="title">1</span>
                                        <input type="text" class="form-control" name="cost[1][pname]" value="">
                                        <input type="text" class="form-control" name="cost[1][price]" value="" id="price_1">
                                        <input type="text" class="form-control" name="cost[1][num]" value=""  id="num_1" onblur="sum_price(1)">
                                        <input type="text" class="form-control" name="cost[1][sum]" value="" id="sum_1">
                                        <input type="text" class="form-control lp_remark" name="cost[1][remark]" value="">
                                        <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('pretium_id')">删除</a>
                                    </div>
                                <?php } ?>
                            </div>
                            <div id="pretium_val">1</div>
                            <div class="form-group col-md-12" id="useraddbtns">
                                <a href="javascript:;" class="btn btn-success btn-sm" onClick="add_pretium()"><i class="fa fa-fw fa-plus"></i> 常规价格信息</a>
                            </div>
                            <div class="form-group">&nbsp;</div>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->

            </div><!--/.col (right) -->
        </div>   <!-- /.row -->
        <!------------------------------end----------------------------->

  </div>
</div>

<include file="Index:footer2" />

		<script type="text/javascript">
            $(function () {
                $('#hide').hide();
                var cost = $('#check_cost').val();
                var carhotel = $('#check_carhotel').val();
                if(cost || carhotel){
                    $('#show_or_hide').show();
                }else{
                    $('#show_or_hide').html('');
                    $('#show_or_hide').hide();
                }

            })

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
							modelhtml += '<tr id="tpl_a_'+model[i].id+'"><td><input type="hidden" name="pro_model[]" value="'+model[i].id+'">'+model[i].id+'</td><td><a href="<?php echo U('Product/model_view'); ?>&id='+model[i].id+'" target="_blank">'+model[i].title+'</a></td><td>'+model[i].input_uname+'</td><td class="taskOptions"><button onClick="javascript:del_timu(\'tpl_a_'+model[i].id+'\')" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button></td></tr>';
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
							mokuaihtml += '<tr id="tpl_a_'+mokuai[i].id+'"><td><input type="hidden" name="pro[]" value="'+mokuai[i].id+'">'+mokuai[i].id+'</td><td><a href="<?php echo U('Product/view'); ?>&id='+mokuai[i].id+'" target="_blank">'+mokuai[i].title+'</a></td><td>'+mokuai[i].input_uname+'</td><td class="taskOptions"><button onClick="javascript:del_timu(\'tpl_a_'+mokuai[i].id+'\')" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button></td></tr>';
						}
					}
					$('#tablelist').find('tbody').append(mokuaihtml);	
				},
				cancelValue:'取消',
				cancel: function () {
				}
			});	
		}
		
		function task_tag(){
			
			var i = parseInt($('#task_tag_val').text())+1;
			
			var html = '<div class="col-md-2 pd" id="tag_'+i+'"><div class="input-group"><input type="text" placeholder="标签" name="tag[]" class="form-control"><span class="input-group-addon" style="width:32px;"><a href="javascript:;"  onClick="deltag(\'tag_'+i+'\')">X</a></span></div></div>';
			
			$('#task_tag_list').append(html);	
			$('#task_tag_val').html(i);
		}
		
		
		function deltag(obj){
			$('#'+obj).remove();
		}
		
		function task(obj){
			
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
		}
		
		//移除题目
		function del_timu(obj){
			$('#'+obj).remove();
			$('.tihao').each(function(index, element) {
				 var no = index*1+1;
               $(this).text(no);     
            });
		}
		
		$(document).ready(function(e) {
            $('.tihao').each(function(index, element) {
				 var no = index*1+1;
               $(this).text(no);     
            });
        
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
						{title : "Files", extensions : "jpg,jpeg,png,zip,rar,7z,doc,docx,ppt,pptx,xls,xlsx,txt"}
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

            //线路种类(普通行程 和 固定线路)
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


            //新增价格政策
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
            }

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
                /*$('#costacc').find('.title').each(function(index, element) {
                    $(this).text(parseInt(index)+1);
                });*/
            }

            //求总价
            function sum_price(i){
                var price   = $("#price_"+i).val();
                var num     = $("#num_"+i).val();
                if(price && num){
                    $("#sum_"+i).val(price*num);
                }else{
                    $("#sum_"+i).val(price);
                }
            }
		</script>
     


