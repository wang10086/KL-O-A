<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>项目销售</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Op/index')}"><i class="fa fa-gift"></i> 出团计划</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12" style="padding-bottom:200px;">
                        	<!--
                            <div class="btn-group" id="catfont">
                                <if condition="rolemenu(array('Op/plans_follow'))"><a href="{:U('Op/plans_follow',array('opid'=>$op['op_id']))}" class="btn btn-default">项目跟进</a></if>
                                <if condition="rolemenu(array('Finance/costacc'))"><a href="{:U('Finance/costacc',array('opid'=>$op['op_id']))}" class="btn btn-default">成本核算</a></if>
                                <if condition="rolemenu(array('Finance/op'))"><a href="{:U('Finance/op',array('opid'=>$op['op_id']))}" class="btn btn-default">项目预算</a></if>
                                <if condition="rolemenu(array('Op/app_materials'))"><a href="{:U('Op/app_materials',array('opid'=>$op['op_id']))}" class="btn btn-default">申请物资</a></if>
                                <if condition="rolemenu(array('Op/revert_materials'))"><a href="{:U('Op/revert_materials',array('opid'=>$op['op_id']))}" class="btn btn-default">归还物资</a></if>
                                <if condition="rolemenu(array('Sale/goods'))"><a href="{:U('Sale/goods',array('opid'=>$op['op_id']))}" class="btn btn-info">项目销售</a></if>
                                <if condition="rolemenu(array('Finance/settlement'))"><a href="{:U('Finance/settlement',array('opid'=>$op['op_id']))}" class="btn btn-default">项目结算</a></if>
                            </div>
                            -->
                             
                            <div class="box box-info" style="margin-top:15px;">
                                <div class="box-header">
                                    <h3 class="box-title">
                                    <?php 
									if($op['status']==1){ 
										$th = '';
										if($op['group_id']) $th = '&nbsp;&nbsp; <span style="font-weight:normal; color:#ff3300;">（团号：'.$op['group_id'].'）</span>';	 
										echo '<span class="green">项目已成团</span>'.$th;
									}elseif($op['status']==2){ 
										echo '<span class="red">项目不成团</span>&nbsp;&nbsp; <span style="font-weight:normal">（原因：'.$op['nogroup'].'）</span>';
									}else{ 
										echo ' <span style=" color:#999999;">该项目暂未成团</span>';
									} ?>
                                    </h3>
                                    <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;"><span class="green">项目编号：{$op.op_id}</span>&nbsp;&nbsp;创建者：{$op.create_user_name}</h3>
                                    
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                    
                                    	
                                        <div class="form-group col-md-12" style="margin-top:20px;">
                                            <label>项目名称：</label>{$op.project}
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>项目类型：</label><?php echo $kinds[$op['kind']]; ?>
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>预计人数：</label>{$op.number}人
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
                                            <label>立项时间：</label>{$op.op_create_date}
                                        </div>
                                        
                                        <if condition="rolemenu(array('Customer/GEC_viwe'))">
                                        <div class="form-group col-md-12">
                                            <label>客户单位：</label><a href="{:U('Customer/GEC_edit',array('id'=>$kh['id']))}" target="_blank">{$op.customer}</a>
                                        </div>
                                        </if>
                                        
                                    </div>
                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            
                            
                            <php> if($op['audit_status']==1){ </php>
                            
                            <div class="box box-info">
                                <div class="box-header">
                                    <h3 class="box-title">项目报价</h3>
                                </div>
                                <div class="box-body">
                                    <div class="content">
                                        
                                        <div id="pretium">
											<?php if($pretium){ ?>
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th width="">价格名称</th>
                                                        <th width="">销售价</th>
                                                        <th width="">同行价</th>
                                                        <th width="">成人人数</th>
                                                        <th width="">儿童人数</th>
                                                        <th width="30%">备注</th>
                                                        <th width="70">报名</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <foreach name="pretium" key="k" item="v">
                                                    <tr>
                                                        <td>{$v.pretium}</td>
                                                        <td>{$v.sale_cost}</td>
                                                        <td>{$v.peer_cost}</td>
                                                        <td>{$v.adult}</td>
                                                        <td>{$v.children}</td>
                                                        <td>{$v.remark}</td>
                                                        <td><a href="javascript:;" class="btn btn-info btn-flat" onclick="sale('{:U('Sale/signup',array('id'=>$v['id'],'opid'=>$v['op_id']))}','{$op.project}')">报名</a></td>
                                                    </tr>    
                                                    </foreach>                                            
                                                </tbody>
                                            </table>
                                            <?php }else{ echo '<div class="form-group" style="padding:20px 0;margin-left:15px;">暂未定价！</div>';} ?>
                                        </div>
                                       
                                    </div>
                                </div>
                            </div>
                            
                           
                            <div class="box box-info">
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
                            
                            <div class="box box-info">
                                <div class="box-header">
                                    <h3 class="box-title">已报名名单</h3>
                                </div>
                                <div class="box-body">
                                    <div class="content" style="padding-top:10px;">
                                        <div id="mingdanmin">
                                            <?php if($member){ ?>
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th width="60">编号</th>
                                                        <th width="150">姓名</th>
                                                        <th width="100">性别</th>
                                                        <th width="200">证件号</th>
                                                        <th width="">单位</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <foreach name="member" key="k" item="v">
                                                    <tr>
                                                        <td><?php echo $k+1; ?></td>
                                                        <td>{$v.name}</td>
                                                        <td>{$v.sex}</td>
                                                        <td>{$v.number}</td>
                                                        <td>{$v.remark}</td>
                                                    </tr>    
                                                    </foreach>                                            
                                                </tbody>
                                            </table>
                                            <?php }else{ echo '<div class="form-group" style="padding:20px 0;">暂无人报名！</div>';} ?>
                                        </div>
                                        
                                        <div class="form-group">&nbsp;</div>
                                    </div>
                                    
                                </div>
                            </div>
                            
                           <php>}</php>
                        </div>
                    </div>
                    
                    
                </section><!-- /.content -->
                
            </aside><!-- /.right-side -->
			
  </div>
</div>

<include file="Index:footer2" />

<script>
	function sale(url,title){
		art.dialog.open(url,{
			lock:true,
			title: title+'报名',
			width: '90%',
			height: '90%',
			fixed: true,
			okValue: '报名',
			ok: function () {
				this.iframe.contentWindow.gosubmint();
				return false;
			},
			cancelValue:'取消',
			cancel: function () {
			}
		});	
	}
</script>