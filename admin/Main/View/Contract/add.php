<include file="Index:header2" />



            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        {$_pagetitle_}
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
                            <form method="post" action="{:U('Contract/add')}" name="myform" id="myform" onsubmit="return beforeSubmit(this)">
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    
                                    <input type="hidden" name="dosubmit" value="1" />
                                    <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
                                    <input type="hidden" name="id" value="{$row.id}" />
                                    
                                    <!-- text input -->
                                    
                                    <div class="form-group col-md-12">
                                   		<h2 style="font-size:16px; color:#ff3300; border-bottom:2px solid #dedede; padding-bottom:10px;">合同信息</h2>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <label>项目团号</label>
                                        <div class="input-group">
                                            <input type="text"  name="info[group_id]" placeholder="团号" class="form-control" value="{$row.group_id}" id="groupid" required>
                                            <!--<span class="input-group-addon" style="width:32px;"><a href="javascript:;" onClick="getop();" >获取</a></span>-->
                                            <span class="input-group-addon" style="width:32px;"><a href="javascript:;" onClick="check_contract();" >获取</a></span>
                                        </div>
                                    </div>
                                    <div class="form-group  col-md-4">
                                        <label>项目名称</label>
                                        <input type="text" name="info[pro_name]" class="form-control" id="proname" value="{$row.pro_name}" required />
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>出团人数</label>
                                        <input type="text" name="info[number]" id="number"   value="{$row.number}" class="form-control" required />
                                    </div>
                                    
                                    <div class="form-group col-md-4">
                                        <label>合同金额</label>
                                        <input type="text" name="info[contract_amount]" id="contract_amount"   value="{$row.contract_amount}" class="form-control" required />
                                    </div>
                                    
                                    <div class="form-group col-md-4">
                                        <label>出团时间</label>
                                        <input type="text" name="info[dep_time]" id="dep_time"   value="{$row.dep_time}" class="form-control inputdate" />
                                    </div>
                                    
                                    <div class="form-group col-md-4">
                                        <label>结束时间</label>
                                        <input type="text"  name="info[end_time]" id="end_time"   value="{$row.end_time}" class="form-control inputdate" />
                                    </div>
                                    
                                    
                                    <div class="form-group col-md-12">
                                        <label>备注</label>
                                        <textarea class="form-control" name="info[remarks]">{$row.remarks}</textarea>
                                    </div>
                                    
                                    
                            		<div class="form-group col-md-12">
                                   		<h2 style="font-size:16px; color:#ff3300; border-bottom:2px solid #dedede; padding-bottom:10px;">合同电子扫描件</h2>
                                    </div>
                                    
                                    {:upload_m('uploadfile','files',$atts,'上传文件')}
                                    
                                    
                                    
                                    <!--<div class="content" style="padding-top:0px;">
                                    	<h2 style="font-size:16px; color:#ff3300; border-bottom:2px solid #dedede; padding-bottom:10px;">回款计划</h2>
                                        <div id="payment">
                                            <div class="userlist">
                                                <div class="unitbox_20">回款金额(元)</div>
                                                <div class="unitbox_20">回款比例(%)</div>
                                                <div class="unitbox_20">计划回款时间</div>
                                                <div class="unitbox_40">备注</div>
                                            </div>
                                            <?php /*if($pays){ */?>
                                            <foreach name="pays" key="kk" item="pp"> 
                                            <div class="userlist" id="pretium_8888{$pp.id}">
                                                <span class="title"><?php /*echo $kk+1; */?></span>
                                                <input type="hidden" name="payment[8888{$pp.id}][no]" class="payno"  value="{$pp.no}">
                                                <input type="hidden" class="form-control" name="payment[8888{$pp.id}][pid]" value="{$pp.id}">
                                                <div class="f_20">
                                                    <input type="text" class="form-control" name="payment[8888{$pp.id}][amount]" value="{$pp.amount}">
                                                </div>
                                                <div class="f_20">
                                                    <input type="text" class="form-control" name="payment[8888{$pp.id}][ratio]" value="{$pp.ratio}">
                                                </div>
                                                <div class="f_20">
                                                    <input type="text" class="form-control inputdate"  name="payment[8888{$pp.id}][return_time]" value="<if condition="$pp['return_time']">{$pp.return_time|date='Y-m-d',###}</if>">
                                                </div>
                                                <div class="f_40">
                                                    <input type="text" class="form-control" name="payment[8888{$pp.id}][remarks]" value="{$pp.remark}">
                                                </div>
                                               
                                                <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('pretium_8888{$pp.id}')">删除</a>
                                            </div>
                                            </foreach>
                                            <?php /*}else{ */?>
                                            <div class="userlist" id="pretium_id">
                                                <span class="title">1</span>
                                                <input type="hidden" name="payment[1][no]" class="payno" value="1">
                                                <div class="f_20">
                                                    <input type="text" class="form-control" name="payment[1][amount]" value="">
                                                </div>
                                                <div class="f_20">
                                                    <input type="text" class="form-control" name="payment[1][ratio]" value="">
                                                </div>
                                                <div class="f_20">
                                                    <input type="text" class="form-control inputdate"  name="payment[1][return_time]" value="">
                                                </div>
                                                <div class="f_40">
                                                    <input type="text" class="form-control" name="payment[1][remarks]" value="">
                                                </div>
                                               
                                                <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('pretium_id')">删除</a>
                                            </div>
                                            <?php /*} */?>
                                        </div>
                                        <div id="payment_val">1</div>
                                        <div class="form-group col-md-12" id="useraddbtns">
                                            <a href="javascript:;" class="btn btn-success btn-sm" onClick="add_payment()"><i class="fa fa-fw fa-plus"></i> 增加回款信息</a> 
                                             
                                        </div>
                                        <div class="form-group">&nbsp;</div>
                                    </div>-->

                                    <div class="form-group">&nbsp;</div>
                                </div>
                                    
                                    
                            </div><!-- /.box -->
                            
                            
                            
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
    function check_contract(){
        var gid = $('#groupid').val();
        if(gid){
            $.ajax({
                type: "POST",
                url: "{:U('Ajax/get_contract')}",
                dataType:'json',
                data: {gid:gid},
                success:function(data){
                    if (data){
                        art_show_msg('该项目合同已存在');
                        return false;
                    }else{
                        getop();
                    }
                }
            });
        }else{
            art_show_msg('请输入团号');
        }
    }

function getop(){
	var gid = $('#groupid').val();
	if(gid){
		$.ajax({
			type: "GET",
			url: "<?php echo U('Ajax/getop'); ?>",
			dataType:'json', 
			data: {gid:gid},
			success:function(data){
				if(data){
					$('#proname').val(data.project);
					$('#number').val(data.renshu);
					$('#dep_time').val(data.departure);
					$('#contract_amount').val(data.shouru);
				}else{
					art_show_msg('未获取到项目信息'); 
				}
			}
		});	
   }else{
	   art_show_msg('请输入团号');  
   }
}


//新增汇款期
function add_payment(){
	var i = parseInt($('#payment_val').text())+1;

	var html = '<div class="userlist" id="pretium_'+i+'">';
		html += '<span class="title"></span>';
		html += '<input type="hidden" name="payment['+i+'][no]" class="payno" value="">';
		html += '<div class="f_20"><input type="text" class="form-control" name="payment['+i+'][amount]" value=""></div>';
		html += '<div class="f_20"><input type="text" class="form-control" name="payment['+i+'][ratio]" value=""></div>';
		html += '<div class="f_20"><input type="text" class="form-control inputdate"  name="payment['+i+'][return_time]" value=""></div>';
		html += '<div class="f_40"><input type="text" class="form-control" name="payment['+i+'][remarks]" value=""></div>';
		html += '<a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox(\'pretium_'+i+'\')">删除</a>';
		html += '</div>';
	$('#payment').append(html);	
	$('#payment_val').html(i);
	orderno();
	
	relaydate();
	
}


	
	

//编号
function orderno(){
	$('#payment').find('.title').each(function(index, element) {
		$(this).text(parseInt(index)+1);
	});
	$('#payment').find('.payno').each(function(index, element) {
		$(this).val(parseInt(index)+1);
	});
}


//移除
function delbox(obj){
	$('#'+obj).remove();
	orderno();
}

//表单提交
function beforeSubmit(obj){
    var contract_amount = parseInt($('#contract_amount').val());
    if (!contract_amount){
        art_show_msg('合同金额填写有误',3);
        return false;
    }else{
        obj.submit();
    }
}
	
</script>