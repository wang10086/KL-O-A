<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>订单详情</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Sale/order')}"><i class="fa fa-gift"></i> 销售记录</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12" style="padding-bottom:200px;">
                        	
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">订单信息</h3>
                                    <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;"><span class="green">订单编号：{$order.order_id}</span></h3>
                                    
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                    
                                        <div class="form-group col-md-12">
                                            <label>项目名称：</label>{$op.project}
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>出团日期：</label>{$op.departure}
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>行程天数：</label>{$op.days}天
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>目的地：</label>{$op.destination}
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>销售单价：</label>&yen;{$pretium.sale_cost} ({$pretium.pretium})
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>销售数量：</label>{$order.amount} 份
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>合计人数：</label><?php echo $fornum*$order['amount']; ?>人 (含<?php echo $pretium['adult']*$order['amount']; ?>成人，<?php echo $pretium['children']*$order['amount']; ?>儿童)
                                        </div>
                                        
                                        <div class="form-group col-md-12">
                                            <label>实收金额：</label><if condition="$order['actual_cost']">&yen; {$order.actual_cost}</if>
                                        </div>
                                        
                                        <div class="form-group col-md-12">
                                            <label>订单备注：</label>{$order.remark}
                                        </div>
                                        
                                        

                                    </div>
                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            
                            
                            
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">名单信息</h3>
                                </div>
                                <div class="box-body">
                                	<input type="hidden" id="maxsum" value="{$order.number}">
                                    <input type="hidden" id="current" value="{$save_member}">
                                    <php> if(cookie('userid') == $order['sales_person_uid']){ </php>
                                    <include file="member_edit" />
                                    <php> }else{ </php>
                                    <include file="member" />
                                    <php> } </php>
                                </div>
                            </div>
                            
                            
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">项目行程</h3>
                                </div>
                                <div class="box-body">
                                    
                                    <div id="task_timu">
										<?php if($days){ ?>
                                        <foreach name="days" key="k" item="v">
                                        <div class="daylist">
                                             <div class="col-md-12 pd"><label class="titou"><strong>第<span class="tihao">1</span>天&nbsp;&nbsp;&nbsp;&nbsp;{$v.citys}</strong></label><div class="input-group pads">{$v.content}</div><div class="input-group">{$v.remarks}</div></div>
                                        </div>
                                        </foreach>
                                         <?php }else{ echo '<div class="content"><div class="form-group col-md-12">暂无线路行程信息！</div></div>';} ?>
                                    </div>
                                    
                                    <div class="form-group">&nbsp;</div>
                                </div>
                            </div>
                            
                           
                        </div>
                    </div>
                    
                    
                </section><!-- /.content -->
                
            </aside><!-- /.right-side -->
			
  </div>
</div>

<include file="Index:footer2" />

<script type="text/javascript"> 
	
	//新增名单
	function adduser(){
		var current = parseInt($('#current').val())+1;
		var maxsum = parseInt($('#maxsum').val());
		if(current<=maxsum){
			var i = parseInt(Math.random()*1000);
			
			var html = '<div class="userlist" id="user_'+i+'"><span class="title"></span><input type="text" placeholder="姓名" class="form-control mem-name" name="member['+i+'][name]"><div class="input-group"><span class="input-group-addon">男<input type="radio" name="member['+i+'][sex]" value="男"></span><span class="input-group-addon" style="border-left:0;">女<input type="radio" name="member['+i+'][sex]" value="女"></span></div><input type="text" placeholder="证件号码" class="form-control mem-number" name="member['+i+'][number]"><input type="text" placeholder="电话" class="form-control mem-tel" name="member['+i+'][mobile]"><input type="text" placeholder="家长姓名" class="form-control mem-name" name="member['+i+'][ecname]"><input type="text" placeholder="家长电话" class="form-control mem-tel" name="member['+i+'][ecmobile]"><input type="text" placeholder="单位" class="form-control mem-remark" name="member['+i+'][remark]"><a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox(\'user_'+i+'\')">删除</a></div>';
			$('#mingdan').append(html);	
			$('#current').val(current);
			orderno();
		}else{
			art.dialog.alert('已超过订单人数限制','warning');	 
		}
	}
	
	
	
	//编号
	function orderno(){
		$('#mingdan').find('.title').each(function(index, element) {
            $(this).text(parseInt(index)+1);
        });
		$('#pretium').find('.title').each(function(index, element) {
            $(this).text(parseInt(index)+1);
        });	
	}
	
	//移除
	function delbox(obj){
		var current = parseInt($('#current').val())-1;
		$('#current').val(current);
		$('#'+obj).remove();
		orderno();
	}
	
	//导入名单
	function importuser() {
		art.dialog.open('<?php echo U('Op/importuser'); ?>',{
			lock:true,
			title: '导入名单',
			width:1000,
			height:500,
			okValue: '导入',
			fixed: true,
			ok: function () {
				var origin = artDialog.open.origin;
				var user = this.iframe.contentWindow.gosubmint();
				var current = parseInt($('#current').val());
				var maxsum = parseInt($('#maxsum').val());
				var renshu = current+parseInt(user.length);
				if(renshu<=maxsum){
					var user_html = '';
					for (var j = 0; j < user.length; j++) {
						var i = parseInt(Math.random()*10000)+j;
						if(user[j].sex=='男'){
							var sexbox = '<div class="input-group"><span class="input-group-addon">男<input type="radio" name="member['+(1000+parseInt(i))+'][sex]" checked value="男"></span><span class="input-group-addon" style="border-left:0;">女<input type="radio" name="member['+(1000+parseInt(i))+'][sex]" value="女"></span></div>';	
						}else if(user[j].sex=='女'){
							var sexbox = '<div class="input-group"><span class="input-group-addon">男<input type="radio" name="member['+(1000+parseInt(i))+'][sex]" value="男"></span><span class="input-group-addon" style="border-left:0;">女<input type="radio" name="member['+(1000+parseInt(i))+'][sex]" checked value="女"></span></div>';	
						}else{
							var sexbox = '<div class="input-group"><span class="input-group-addon">男<input type="radio" name="member['+(1000+parseInt(i))+'][sex]" value="男"></span><span class="input-group-addon" style="border-left:0;">女<input type="radio" name="member['+(1000+parseInt(i))+'][sex]" value="女"></span></div>';	
						}
						user_html += '<div class="userlist" id="user_im_'+i+'"><span class="title"></span><input type="text" placeholder="姓名" class="form-control mem-name" name="member['+(1000+parseInt(i))+'][name]" value="'+user[j].name+'">'+sexbox+'<input type="text" placeholder="证件号码" class="form-control mem-number" name="member['+(1000+parseInt(i))+'][number]" value="'+user[j].number+'"><input type="text" placeholder="电话" class="form-control mem-tel" name="member['+(1000+parseInt(i))+'][mobile]" value="'+user[j].mobile+'"><input type="text" placeholder="家长姓名" class="form-control mem-name" name="member['+(1000+parseInt(i))+'][ecname]" value="'+user[j].ecname+'"><input type="text" placeholder="家长电话" class="form-control mem-tel" name="member['+(1000+parseInt(i))+'][ecmobile]" value="'+user[j].ecmobile+'"><input type="text" placeholder="单位" class="form-control mem-remark" name="member['+(1000+parseInt(i))+'][remark]" value="'+user[j].remark+'"><a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox(\'user_im_'+i+'\')">删除</a></div>';
						
					}
					
					$('#mingdan').append(user_html);	
					$('#current').val(renshu);
					
					orderno();
				}else{
					art.dialog.alert('已超过订单人数限制','warning');	 
				}
			},
			cancelValue:'取消',
			cancel: function () {
			}
		});	
	}
	
	artDialog.alert = function (content, status) {
		return artDialog({
			id: 'Alert',
			icon: status,
			width:300,
			height:120,
			fixed: true,
			lock: true,
			time: 1,
			content: content,
			ok: true
		});
	};
	
	//保存信息
	function save(id,url){
		$.ajax({
             type: "POST",
             url: url,
		     dataType:'json', 
             data: $('#'+id).serialize(),
             success:function(data){
                 if(parseInt(data)>0){
				      art.dialog.alert('保存成功','success');
			     }else{
					  art.dialog.alert('保存失败','warning');	 
				 }
             }
        });	
	}
</script>