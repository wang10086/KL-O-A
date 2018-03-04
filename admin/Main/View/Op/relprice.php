<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>项目比价</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Op/index')}"><i class="fa fa-gift"></i> 项目计划</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                <form method="post" action="{:U('Op/relprice')}" name="myform" id="myform">
                	<input type="hidden" name="dosubmint" value="1">
                    <input type="hidden" name="reid" value="{$rel.id}">
                    <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                            
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">项目编号：{$op.op_id}</h3>
                                </div>
                                <div class="box-body">
                                    <div class="content">
                                        <div class="form-group col-md-6">
                                            <label>项目编号：</label><input type="text" name="info[op_id]" class="form-control" value="{$op_id}" />
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>比价类型：</label>
                                            <select class="form-control" name="info[type]">
                                            	<option value="0">请选择</option>
                                            	<foreach name="kinds" item="v" key="k">
                                            	<option value="{$k}" <?php if($k==$vtype){ echo 'selected';} ?> >{$v}</option>
                                                </foreach>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>业务名称：</label><input type="text" name="info[business_name]" class="form-control" value="{$b_name}" />
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>顾客需求：</label>
                                            <textarea name="info[demand]"  class="form-control">{$rel.demand}</textarea>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>比价后意见：</label>
                                            <textarea name="info[opinion]"  class="form-control">{$rel.opinion}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div id="rellist">
                            
                            	<?php foreach($com as $k=>$v){ ?>
                                <div class="box box-success" id="rel_{$k}" data="{$k}">
                                    <div class="box-header">
                                        <h3 class="box-title reltitle">单位A</h3>
                                        <div class="box-tools pull-right">
                                            <i class="fa fa-times delxxx" onclick="delrel('rel_{$k}')"></i>
                                        </div>
                                    </div>
                                    <div class="box-body">
                                        <div class="content contenthotbox">
                                        	<input type="hidden" name="com[{$k}][comid]"  value="{$v.id}"/>
                                            <div class="form-group col-md-12">
                                                <input type="text" name="com[{$k}][company]" class="form-control" placeholder="公司名称"  value="{$v.company}"/>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <input type="text" name="com[{$k}][contacts]" class="form-control" placeholder="联系人" value="{$v.contacts}"/>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <input type="text" name="com[{$k}][contacts_tel]" class="form-control" placeholder="联系电话" value="{$v.contacts_tel}"/>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <input type="text" name="com[{$k}][contacts_email]" class="form-control" placeholder="邮箱地址" value="{$v.contacts_email}"/>
                                            </div>
                                        </div>
                                        <div class="content contentbot">
                                            <h2>比选项目</h2>
                                            <div id="newlistbox" class="rels">
                                                <div class="userlist">
                                                    <div class="unitbox_25">比选项目</div>
                                                    <div class="unitbox_25">价格</div>
                                                    <div class="unitbox_50">内容标准</div>
                                                </div>
                                                <?php foreach($v['info'] as $kk=>$vv){ ?>
                                                <div class="userlist">
                                                	<input type="hidden"  name="com[{$k}][info][{$kk}][id]" value="{$vv.id}">
                                                    <span class="title nolist"><?php echo $kk+1; ?></span>
                                                    <div class="f_25">
                                                        <input type="text" class="form-control" name="com[{$k}][info][{$kk}][term]" value="{$vv.term}">
                                                    </div>
                                                    <div class="f_25">
                                                        <input type="text" class="form-control" name="com[{$k}][info][{$kk}][price]" value="{$vv.price}">
                                                    </div>
                                                    <div class="f_50">
                                                        <input type="text" class="form-control" name="com[{$k}][info][{$kk}][term_standard]" value="{$vv.term_standard}">
                                                    </div>
                                                    <a href="javascript:;" class="btn btn-danger btn-smsm" onclick="delrelpro(this)" data="rel_{$k}"><i class="fa fa-minus"></i></a>
                                                </div>
                                                <?php } ?>
                                            </div>
                                            <div class="form-group col-md-12" id="useraddbtns">
                                                <a href="javascript:;" class="btn btn-success btn-sm" onclick="addrelpro('rel_{$k}')"><i class="fa fa-fw fa-plus"></i> 增加比价项</a> 
                                            </div>
                                            <div class="form-group">&nbsp;</div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <?php } ?>
                            
                            </div>
                            
                            <a href="javascript:;" class="btn btn-warning btn-sm" onclick="addrel()" ><i class="fa fa-fw  fa-plus"></i> 增加比价单位</a>
                            
                            
                            <div style="width:100%; text-align:center; margin-top:30px;">
                            <button type="submit" class="btn btn-info btn-lg" id="lrpd">保存</button>
                            </div>
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                    </form>
                </section><!-- /.content -->
                
            </aside><!-- /.right-side -->
			
  </div>
</div>

<include file="Index:footer2" />

<script>
	function delrel(obj){
		$('#'+obj).remove();	
		rerel();
	}
	
	
	function addrel(){
		var obj  = parseInt(1000*Math.random());
		var html = '<div class="box box-success" id="rel_'+obj+'" data="'+obj+'">'+
						'<div class="box-header">'+
							'<h3 class="box-title reltitle"></h3>'+
							'<div class="box-tools pull-right">'+
								 '<i class="fa fa-times delxxx"  onclick="delrel(\'rel_'+obj+'\')"></i>'+
							'</div>'+
						'</div>'+
						'<div class="box-body">'+
							'<div class="content contenthotbox">'+
								'<div class="form-group col-md-12">'+
									'<input type="text" name="com['+obj+'][company]" class="form-control" placeholder="公司名称" />'+
								'</div>'+
								'<div class="form-group col-md-4">'+
									'<input type="text" name="com['+obj+'][contacts]" class="form-control" placeholder="联系人" />'+
								'</div>'+
								'<div class="form-group col-md-4">'+
									'<input type="text" name="com['+obj+'][contacts_tel]" class="form-control" placeholder="联系电话" />'+
								'</div>'+
								'<div class="form-group col-md-4">'+
									'<input type="text" name="com['+obj+'][contacts_email]" class="form-control" placeholder="邮箱地址" />'+
								'</div>'+
							'</div>'+
							'<div class="content contentbot">'+
								'<h2>比选项目</h2>'+
								'<div id="newlistbox" class="rels">'+
									'<div class="userlist">'+
										'<div class="unitbox_25">比选项目</div>'+
										'<div class="unitbox_25">价格</div>'+
										'<div class="unitbox_50">内容标准</div>'+
									'</div>'+
									'<div class="userlist">'+
										'<span class="title nolist">1</span>'+
										'<div class="f_25">'+
											'<input type="text" class="form-control" name="com['+obj+'][info][0][term]" value="">'+
										'</div>'+
										'<div class="f_25">'+
											'<input type="text" class="form-control" name="com['+obj+'][info][0][price]" value="">'+
										'</div>'+
										'<div class="f_50">'+
											'<input type="text" class="form-control" name="com['+obj+'][info][0][term_standard]" value="">'+
										'</div>'+
										'<a href="javascript:;" class="btn btn-danger btn-smsm" onclick="delrelpro(this)" data="rel_1"><i class="fa fa-minus"></i></a>'+
									'</div>'+
								'</div>'+
								'<div class="form-group col-md-12" id="useraddbtns">'+
									'<a href="javascript:;" class="btn btn-success btn-sm" onclick="addrelpro(\'rel_'+obj+'\')">'+
										'<i class="fa fa-fw fa-plus"></i> 增加比价项'+
										'</a>'+
								'</div>'+
								'<div class="form-group">&nbsp;</div>'+
							'</div>'+
							
						'</div>'+
					'</div>';	
		$('#rellist').append(html);
		rerel();			
	}
	
	
	function delrelpro(obj){
		var box = $(obj).attr('data');
		$(obj).parent().remove();	
		reno(box);
	}
	
	
	function addrelpro(obj){
		
		var no 		= $('#'+obj).attr('data');
		var ran  	= parseInt(1000*Math.random());
		
		var html =	'<div class="userlist">';
			html +=	'<span class="title nolist">1</span>';
			html +=	'<div class="f_25">';
            html +=	'<input type="text" class="form-control" name="com['+no+'][info]['+ran+'][term]" value="">';
            html +=	'</div>';
			html +=	'<div class="f_25">';
			html +=	'<input type="text" class="form-control" name="com['+no+'][info]['+ran+'][price]" value="">';
			html +=	'</div>';
			html +=	'<div class="f_50">';
			html +=	'<input type="text" class="form-control" name="com['+no+'][info]['+ran+'][term_standard]" value="">';
			html +=	'</div>';
			html +=	'<a href="javascript:;" class="btn btn-danger btn-smsm" onclick="delrelpro(this)" data="'+obj+'"><i class="fa fa-minus"></i></a>';
			html +=	'</div>';
			
		$('#'+obj).find('.rels').append(html);
		reno(obj);

	}
	
	
	function reno(obj){
		//重编题号
		$('#'+obj).find('.nolist').each(function(index, element) {
			var no = index*1+1;
			$(this).text(no);     
		});
	}
	
	
	function rerel(){
		$('.reltitle').each(function(index, element) {
			$(this).text('单位 '+getChar(index));     
		});	
	}
	
	function getChar(i){
        if(i >= 0 && i <= 26){
            return String.fromCharCode(65 + i);
        } else {
            alert('请输入合适数字');
        }
    }
	
	$(document).ready(function(e) {
        rerel();
    });
	
</script>
		