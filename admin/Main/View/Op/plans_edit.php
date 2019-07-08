<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>项目跟进</h1>
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
                        	
                            <div class="btn-group" id="catfont">
                                <if condition="rolemenu(array('Op/plans_follow'))"><a href="{:U('Op/plans_follow',array('opid'=>$op['op_id']))}" class="btn btn-info">项目跟进</a></if>
                                <if condition="rolemenu(array('Finance/costacc'))"><a href="{:U('Finance/costacc',array('opid'=>$op['op_id']))}" class="btn btn-default">成本核算</a></if>
                                <if condition="rolemenu(array('Op/confirm'))"><a href="{:U('Op/confirm',array('opid'=>$op['op_id']))}" class="btn btn-default">成团确认</a></if>
                                <if condition="rolemenu(array('Finance/op'))"><a href="{:U('Finance/op',array('opid'=>$op['op_id']))}" class="btn btn-default">项目预算</a></if>
                                <if condition="rolemenu(array('Op/app_materials'))"><a href="{:U('Op/app_materials',array('opid'=>$op['op_id']))}" class="btn btn-default">申请物资</a></if>
                                
                                <!--
                                <if condition="rolemenu(array('Sale/goods'))"><a href="{:U('Sale/goods',array('opid'=>$op['op_id']))}" class="btn btn-default">项目销售</a></if>
                                -->
                                <if condition="rolemenu(array('Finance/settlement'))"><a href="{:U('Finance/settlement',array('opid'=>$op['op_id']))}" class="btn btn-default">项目结算</a></if>
                                <if condition="rolemenu(array('Finance/huikuan'))"><a href="{:U('Finance/huikuan',array('opid'=>$op['op_id']))}" class="btn btn-default">项目回款</a></if>
                                <if condition="rolemenu(array('Contract/index'))"><a href="{:U('Contract/index',array('opid'=>$op['op_id']))}" class="btn btn-default">合同管理</a></if>
                                <if condition="rolemenu(array('Op/evaluate'))"><a href="{:U('Op/evaluate',array('opid'=>$op['op_id']))}" class="btn btn-default">项目评价</a></if>
                            </div>

                            <div class="box box-warning" style="margin-top:15px;">
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
                                    <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;"><span class="green">项目编号：{$op.op_id}</span> &nbsp;&nbsp;创建者：{$op.create_user_name}
                                        <?php if (rolemenu(array('Op/change_op')) && (C('RBAC_SUPER_ADMIN')==cookie('username') || in_array(cookie('userid'),array(11,$manager_uid,77)) || ($change &&$op['create_user']==cookie('userid')))){ ?>
                                            <span  style=" border: solid 1px #00acd6; padding: 0 5px; border-radius: 5px; background-color: #00acd6; color: #ffffff; margin-left: 20px" onClick="open_change({$op['op_id']})" title="交接该团" class="">交接该团</span>
                                        <?php } ?>
                                    </h3>
                                    
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                    
                                        
                                        <div class="form-group col-md-4 viwe">
                                            <p>审批状态：{$op.showstatus}</p>
                                        </div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>审批人：{$op.show_user}</p>
                                        </div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>审批时间：{$op.show_time}</p>
                                        </div>
                                        <?php  if($op['show_reason']){ ?>
                                        <div class="form-group col-md-4 viwe">
                                            <p>审批说明：{$op.show_reason}</p>
                                        </div>
                                        <?php  } ?>
                                        
                                        <?php  if((cookie('userid') == $op['create_user']  && $settlement['audit']!=1) || C('RBAC_SUPER_ADMIN')==cookie('username') || cookie('roleid')==10){ ?>
                                        <include file="op_pro_edit" />
                                        <?php  }else{ ?>
                                        <include file="op_pro" />
                                        <?php  } ?>
                                        
                                    </div>
                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->


                           <?php  if($op['audit_status']==1){ ?>
                               <div class="box box-warning">
                                   <div class="box-header">
                                       <h3 class="box-title">行程方案及资源需求</h3>
                                       <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;">
                                           负责人：{$op.sale_user}
                                       </h3>
                                   </div>
                                   <div class="box-body">
                                       <?php if (in_array($op['kind'],$arr_product)){ ?>
                                           <?php if(rolemenu(array('Op/select_module')) && $settlement['audit']!=1 && ($op['create_user']==cookie('userid') ||C('RBAC_SUPER_ADMIN')==cookie('username') ||cookie('roleid')==10)){ ?>
                                                <include file="op_product_edit" />
                                           <?php }else{ ?>
                                               <include file="op_product_read" />
                                           <?php } ?>
                                       <?php }else{ ?>
                                           <?php if(rolemenu(array('Op/public_save_line')) && $settlement['audit']!=1  && ($opauth['line']==cookie('userid')|| C('RBAC_SUPER_ADMIN')==cookie('username') ||rolemenu(array('Op/assign_line')))){ ?>
                                               <?php if($isFixedLine){ ?>
                                                   <include file="op_line" />
                                               <?php }else{ ?>
                                                   <include file="op_line_edit" />
                                               <?php } ?>
                                           <?php }else{ ?>
                                               <include file="op_line" />
                                           <?php  } ?>
                                       <?php } ?>
                                   </div>

                                   <div class="box-body">
                                       <?php if((($op['create_user']==cookie('userid') && !$guide_confirm) || C('RBAC_SUPER_ADMIN')==cookie('username') || cookie('roleid')==10) && $settlement['audit']!=1){ ?>
                                           <include file="op_tcs_sure_edit" />
                                       <?php }else{ ?>
                                           <include file="op_tcs_sure_read" />
                                       <?php } ?>
                                       <div class="form-group">&nbsp;</div>
                                   </div>
                               </div>
                                
                                 <div class="box box-warning">
                                    <div class="box-header">
                                        <h3 class="box-title">成本核算</h3>
                                        <!--<if condition="rolemenu(array('Finance/costacc'))">
                                        <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;">
                                        	<a href="{:U('Finance/costacc',array('opid'=>$op['op_id']))}" style="color:#09F;">编辑成本</a>
                                        </h3>
                                        </if>-->
                                        <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;">
                                        <?php  if($opauth && $opauth['hesuan']){ ?>
                                            负责人：{$user.$opauth[hesuan]}
                                        <?php  }else{ ?>
                                            <?php  if(rolemenu(array('Op/assign_hesuan'))){ ?>
                                                <a href="javascript:;" onclick="javascript:assign('{:U('Op/assign_hesuan',array('opid'=>$op['op_id']))}','指派成本核算负责人');" style="color:#09F;">指派负责人</a>
                                            <?php  }else{ ?>
                                                暂未指派负责人
                                            <?php  } ?>
                                        <?php  } ?>
                                        </h3>
                                    </div>
                                    <div class="box-body">
                                    	
                                        <div class="content" style="padding-top:40px;">
                                        	<?php if(!$costacc){ 
												/*if(!$op['line_id']){
													echo '<div class="form-group col-md-4">请先确认行程方案！</div>';
												}else{*/
													echo '<div class="form-group col-md-4">尚未核算成本，<a href="'.U('Finance/costacc',array('opid'=>$op['op_id'])).'">立即核算</a>！</div>';
												/*}*/
											}else{ ?>
                                            <div class="form-group col-md-4">
                                                <label>成本价格：{$op.costacc} {$op.costacc_unit}</label>
                                            </div>
                                            
                                            <div class="form-group col-md-4">
                                                <label>建议最低报价：{$op.costacc_min_price} {$op.costacc_min_price_unit}</label>
                                            </div>
                                            
                                            <div class="form-group col-md-4">
                                                <label>建议最高报价：{$op.costacc_max_price} {$op.costacc_max_price_unit}</label>
                                            </div>
                                            <?php } ?>
                                        </div>
                                        
                                    </div>
                                </div>
                                
                                
                                <div class="box box-warning">
                                    <div class="box-header">
                                        <h3 class="box-title">项目标价</h3>
                                        <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;">
                                        <?php  if($opauth && $opauth['price']){ ?>
                                        负责人：{$user.$opauth[price]}
                                        <?php  }else{ ?>
                                        	<?php  if(rolemenu(array('Op/assign_price'))){ ?>
                                        	<a href="javascript:;" onclick="javascript:assign('{:U('Op/assign_price',array('opid'=>$op['op_id']))}','指派项目标价负责人');" style="color:#09F;">指派负责人</a>
                                            <?php  }else{ ?>
                                            暂未指派负责人
                                            <?php  } ?>
										<?php  } ?>
                                        </h3>
                                    </div>
                                    <div class="box-body">
                                        <div class="content">
                                            <?php  if(rolemenu(array('Op/public_save_price')) && $op['costacc']!='0.00' && $settlement['audit']!=1 && ($opauth['price']==cookie('userid') || C('RBAC_SUPER_ADMIN')==cookie('username') || rolemenu(array('Op/assign_price')))){ ?>
                                            <include file="op_price_edit" />
                                            <?php }else{ ?>
                                            <include file="op_price" />
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <?php if(( C('RBAC_SUPER_ADMIN')==cookie('username') || cookie('userid') == $op['create_user'])  && $op['audit_status']==1 && $op['status']==0  && $settlement['audit']!=1){ ?>
                                <include file="op_end" />
                                <?php } ?>
                                
                                
                                <div class="box box-warning">
                                    <div class="box-header">
                                        <h3 class="box-title">项目预算</h3>
                                        <!--<if condition="rolemenu(array('Finance/op'))">
                                        <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;">
                                        	<a href="{:U('Finance/op',array('opid'=>$op['op_id']))}" style="color:#09F;">编辑预算</a>
                                        </h3>
                                        </if>-->
                                        <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;">
                                            <?php  if($opauth && $opauth['yusuan']){ ?>
                                                负责人：{$user.$opauth[yusuan]}
                                            <?php  }else{ ?>
                                                <?php  if(rolemenu(array('Op/assign_yusuan'))){ ?>
                                                    <a href="javascript:;" onclick="javascript:assign('{:U('Op/assign_yusuan',array('opid'=>$op['op_id']))}','指派项目预算负责人');" style="color:#09F;">指派负责人</a>
                                                <?php  }else{ ?>
                                                    暂未指派负责人
                                                <?php  } ?>
                                            <?php  } ?>
                                        </h3>
                                    </div>
                                    <div class="box-body">
                                        <div class="content" style="padding-top:40px;">
                                        	<?php if(!$budget){ 
												if($op['costacc']=='0.00'){
													echo '<div class="form-group col-md-4">请先核算成本！</div>';
												}else{
                                                    echo '<div class="form-group col-md-4">暂未确认预算<a href="'.U('Finance/op',array('opid'=>$op['op_id'])).'">，立即确认预算</a>！</div>';
												}
                                            
                                            }else{ ?>
                                            
                                            <div class="form-group col-md-12">
                                                <label>预算：<span style="font-size:16px; color:#ff3300;">&yen; {$budget.budget}</span></label>
                                            </div>
                                            
                                            <div class="form-group col-md-4">
                                                <label>人数：{$budget.renshu}人</label>
                                            </div>
                                            
                                            <div class="form-group col-md-4">
                                                <label>预算收入：{$budget.shouru}</label>
                                            </div>
                                            
                                            <div class="form-group col-md-4">
                                                <label>收入性质：{$budget.xinzhi}</label>
                                            </div>
                                            
                                            <div class="form-group col-md-4">
                                                <label>毛利：{$budget.maoli}</label>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label>毛利率：{$budget.maolilv}</label>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label>人均毛利：{$budget.renjunmaoli}</label>
                                            </div>
                                            <?php } ?>
                                           
                                            
                                        </div>
                                    </div>
                                </div>
                                
                                
                                <div class="box box-warning">
                                    <div class="box-header">
                                        <h3 class="box-title">专家辅导员调度</h3>
                                        <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;">
                                            <?php  if($opauth && $opauth['guide']){ ?>
                                                负责人：{$user.$opauth[guide]}
                                            <?php  }/*else{ */?><!--
                                                <?php /* if(rolemenu(array('Op/assign_guide'))){ */?>
                                                    <a href="javascript:;" onclick="javascript:assign('{:U('Op/assign_guide',array('opid'=>$op['op_id']))}','指派专家辅导员负责人');" style="color:#09F;">指派负责人</a>
                                                <?php /* }else{ */?>
                                                    暂未指派负责人
                                                <?php /* } */?>
                                            --><?php /* } */?>
                                        </h3>
                                    </div>

                                        <include file="op_res_guide" />

                                </div>

                                
                                <div class="box box-warning">
                                    <div class="box-header">
                                        <h3 class="box-title">合格供方调度</h3>
                                        <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;">
                                        <?php  if($opauth && $opauth['material']){ ?>
                                        负责人：{$user.$opauth[material]}
                                        <?php  }else{ ?>
                                        	<?php  if(rolemenu(array('Op/assign_material'))){ ?>
                                        	<a href="javascript:;" onclick="javascript:assign('{:U('Op/assign_material',array('opid'=>$op['op_id']))}','指派合格供方负责人');" style="color:#09F;">指派负责人</a>
                                            <?php  }else{ ?>
                                            暂未指派负责人
                                            <?php  } ?>
										<?php  } ?>
                                        </h3>
                                    </div>
                                    <?php  if(rolemenu(array('Op/public_save'))  && $budget['audit_status']==1 && $settlement['audit']!=1 && ($opauth['material']==cookie('userid') || C('RBAC_SUPER_ADMIN')==cookie('username') || rolemenu(array('Op/assign_res')))){ ?>
                                    <include file="op_res_material_edit" />
                                    <?php  }else{ ?>
                                    <include file="op_res_material" />
                                    <?php  } ?>
                                </div>
                                
                                
                                
                                
                                <div class="box box-warning">
                                    <div class="box-header">
                                        <h3 class="box-title">物资调度</h3>
                                        <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;">
                                        <?php  if($opauth && $opauth['res']){ ?>
                                        负责人：{$user.$opauth[res]}
                                        <?php  }else{ ?>
                                        	<?php  if(rolemenu(array('Op/assign_res'))){ ?>
                                        	<a href="javascript:;" onclick="javascript:assign('{:U('Op/assign_res',array('opid'=>$op['op_id']))}','指派项目资源调度负责人');" style="color:#09F;">指派负责人</a>
                                            <?php  }else{ ?>
                                            暂未指派负责人
                                            <?php  } ?>
										<?php  } ?>
                                        </h3>
                                    </div>
                                    <?php  if(rolemenu(array('Op/public_save'))  && $budget['audit_status']==1 && $settlement['audit']!=1 && ($opauth['res']==cookie('userid') || C('RBAC_SUPER_ADMIN')==cookie('username') || rolemenu(array('Op/assign_res')))){ ?>
                                    <include file="op_res_edit" />
                                    <?php  }else{ ?>
                                    <include file="op_res" />
                                    <?php  } ?>
                                </div>
                                
                                
                                <div class="box box-warning">
                                    <div class="box-header">
                                        <h3 class="box-title">人员名单</h3>
                                    </div>
                                    <div class="box-body">
                                        <?php /* if((cookie('userid') == $op['create_user'] || C('RBAC_SUPER_ADMIN')==cookie('username')) && $settlement['audit']!=1){ */?>
                                        <?php  if((cookie('userid') == $op['create_user'] || C('RBAC_SUPER_ADMIN')==cookie('username')) && $huikuan_status!=2){ ?>
                                        <include file="op_member_edit" />
                                        <?php  }else{ ?>
                                        <include file="op_member" />
                                        <?php  } ?>
                                    </div>
                                </div>
                                
                                
                                <div class="box box-warning">
                                    <div class="box-header">
                                        <h3 class="box-title">项目结算</h3>
                                        <!--<if condition="rolemenu(array('Finance/op'))">
                                        <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;">
                                        	<a href="{:U('Finance/settlement',array('opid'=>$op['op_id']))}" style="color:#09F;">编辑结算</a>
                                        </h3>
                                        </if>-->
                                        <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;">
                                            <?php  if($opauth && $opauth['jiesuan']){ ?>
                                                负责人：{$user.$opauth[jiesuan]}
                                            <?php  }else{ ?>
                                                <?php  if(rolemenu(array('Op/assign_jiesuan'))){ ?>
                                                    <a href="javascript:;" onclick="javascript:assign('{:U('Op/assign_jiesuan',array('opid'=>$op['op_id']))}','指派项目结算负责人');" style="color:#09F;">指派负责人</a>
                                                <?php  }else{ ?>
                                                    暂未指派负责人
                                                <?php  } ?>
                                            <?php  } ?>
                                        </h3>
                                    </div>
                                    <div class="box-body">
                                        <div class="content" style="padding-top:40px;">
                                        	<?php if(!$settlement){
                                                echo '<div class="form-group col-md-4">暂未结算<a href="'.U('Finance/settlement',array('opid'=>$op['op_id'])).'">，立即编辑结算</a>！</div>';
                                             }else{ ?>
                                            <div class="form-group col-md-4">
                                                <label>实际人数：{$settlement.renshu}</label>
                                            </div>
                                            
                                            <div class="form-group col-md-4">
                                                <label>预算收入：{$settlement.shouru}</label>
                                            </div>
                                            
                                            
                                            <div class="form-group col-md-4">
                                                <label>毛利：{$settlement.maoli}</label>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label>毛利率：{$settlement.maolilv}</label>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label>人均毛利：{$settlement.renjunmaoli}</label>
                                            </div>
                                            <?php } ?>
                                           
                                            
                                        </div>
                                    </div>
                                </div>

                               <div class="box box-warning">
                                   <div class="box-header">
                                       <h3 class="box-title">前期资源、研发评价</h3>
                                   </div>
                                   <div class="box-body">
                                       <?php if((cookie('roleid')==10 || cookie('userid')==$op['create_user'] || C('RBAC_SUPER_ADMIN')==cookie('username')) && $settlement['audit']!=1 ){ ?>
                                           <include file="score_edit" />
                                       <?php }else{ ?>
                                           <include file="score_read" />
                                       <?php }?>
                                   </div>
                               </div>
                                
                                <div class="box box-warning">
                                    <div class="box-header">
                                        <h3 class="box-title">项目操作记录</h3>
                                    </div>
                                    <div class="box-body">
                                        <div class="content" style="padding:10px 30px;">
                                            <table rules="none" border="0">
                                            	<tr>
                                                	<th style="border-bottom:2px solid #06E0F3; font-weight:bold;" width="160">操作时间</th>
                                                    <th style="border-bottom:2px solid #06E0F3; font-weight:bold;" width="100">操作人</th>
                                                    <th style="border-bottom:2px solid #06E0F3; font-weight:bold;" width="500">操作说明</th>
                                                </tr>
                                                <foreach name="record" item="v">
                                                <tr>
                                                	<td style="padding:20px 0 0 0">{$v.op_time|date='Y-m-d H:i:s',###}</td>
                                                    <td style="padding:20px 0 0 0">{$v.uname}</td>
                                                    <td style="padding:20px 0 0 0">{$v.explain}</td>
                                                </tr>
                                                </foreach>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            
                            <?php  } ?>
                           
                        </div>
                    </div>
                    
                    
                </section><!-- /.content -->
                
            </aside><!-- /.right-side -->
			
  </div>
</div>

<include file="Index:footer2" />

<script type="text/javascript">
    var price_kind = '';
    var opid    = {$opid};

    $(function(){
        $('#hide_div').html('');
        var rad     = {$rad};

        $.ajax({
            type:"POST",
            url:"{:U('Ajax/get_gpk')}",
            data:{opid:opid},
            success:function(msg){
                if(msg){
                    price_kind = msg;
                    $(".gpk").empty();
                    var count = msg.length;
                    var i= 0;
                    var b="";
                    b+='<option value="" disabled selected>请选择</option>';
                    for(i=0;i<count;i++){
                        b+="<option value='"+msg[i].id+"'>"+msg[i].name+"</option>";
                    }
                    $(".gpk").append(b);
                    //获取职能类型信息
                    assign_option(1);
                }else{
                    $(".gpk").empty();
                    var b='<option value="" disabled selected>无数据</option>';
                    $(".gpk").append(b);
                    assign_option(1);
                }
            }
        })

        if (rad == 1){
            $('#tcs_need_form').show();
        }else{
            $('#tcs_need_form').hide();
        }

        //是否需要辅导员/教师/专家
        $('#tcscheckbox').find('ins').each(function(index, element) {
            $(this).click(function(){
                if(index==0){
                    $('#tcs_need_form').hide();
                }else{
                    $('#tcs_need_form').show();
                }
            })
        });

        var url = 'http://tcs.kexueyou.com/op.php?m=Main&c=Score&a=index&opid='+{$op.op_id};
        qrcode_js(url,100,100); //加载js二维码
    })



    //新增名单
	function adduser(){
		var i = parseInt($('#user_val').text())+1;

		var html = '<div class="userlist" id="user_'+i+'"><span class="title"></span><input type="text" placeholder="姓名" class="form-control mem-name" name="member['+i+'][name]"><div class="input-group"><span class="input-group-addon">男<input type="radio" name="member['+i+'][sex]" value="男"></span><span class="input-group-addon" style="border-left:0;">女<input type="radio" name="member['+i+'][sex]" value="女"></span></div><input type="text" placeholder="证件号码" class="form-control mem-number" name="member['+i+'][number]"><input type="text" placeholder="电话" class="form-control mem-tel" name="member['+i+'][mobile]"><input type="text" placeholder="家长姓名" class="form-control mem-name" name="member['+i+'][ecname]"><input type="text" placeholder="家长电话" class="form-control mem-tel" name="member['+i+'][ecmobile]"><input type="text" placeholder="单位" class="form-control mem-remark" name="member['+i+'][remark]"><a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox(\'user_'+i+'\')">删除</a></div>';
		$('#mingdan').append(html);	
		$('#user_val').html(i);
		orderno();
	}
	
	
	
	
	
	
	//新增价格政策
	function add_pretium(){
		var i = parseInt($('#pretium_val').text())+1;

		var html = '<div class="userlist" id="pretium_'+i+'"><span class="title"></span><input type="text" class="form-control" name="pretium['+i+'][pretium]"><input type="text"  class="form-control" name="pretium['+i+'][sale_cost]"><input type="text" class="form-control" name="pretium['+i+'][peer_cost]"><input type="number" class="form-control" name="pretium['+i+'][adult]"><input type="number" class="form-control" name="pretium['+i+'][children]"><input type="text" class="form-control" name="pretium['+i+'][remark]"><a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox(\'pretium_'+i+'\')">删除</a></div>';
		$('#pretium').append(html);	
		$('#pretium_val').html(i);
		orderno();
	}
	
	//编号
	function orderno(){
		$('#mingdan').find('.title').each(function(index, element) {
            $(this).text(parseInt(index)+1);
        });
		$('#pretium').find('.title').each(function(index, element) {
            $(this).text(parseInt(index)+1);
        });
		$('#costacc').find('.title').each(function(index, element) {
            $(this).text(parseInt(index)+1);
        });
        $('#tcs').find('.title').each(function(index, element) {
            $(this).text(parseInt(index)+1);
        });
	}
	
	//移除
	function delbox(obj){
		$('#'+obj).remove();
		orderno();
	}
	
	
	//重新选择模板
	function selectmodel() {
		art.dialog.open('<?php echo U('Op/select_product'); ?>',{
			lock:true,
			title: '选择行程线路',
			width:1000,
			height:500,
			okValue: '提交',
			fixed: true,
			ok: function () {
				var origin = artDialog.open.origin;
				var pro = this.iframe.contentWindow.gosubmint();
				var slt = '<h4>行程来源：<a href="<?php echo U('Product/view_line'); ?>&id='+pro[0].id+'" target="" id="travelcom">'+pro[0].title+'</a><input type="hidden" name="line_id" value="'+pro[0].id+'" ></h4>';
				$('#task_title').html(slt);
				
				$.get("<?php echo U('Op/public_ajax_line'); ?>",{id:pro[0].id}, function(result){
					$("#task_timu").html(result);
				});
				
			},
			cancelValue:'取消',
			cancel: function () {
			}
		});	
	}


	//选择导游辅导员
	function selectguide() {
		art.dialog.open('<?php echo U('Op/select_guide',array('opid'=>$opid)); ?>',{
			lock:true,
			title: '选择导游辅导员',
			width:1000,
			height:500,
			okValue: '提交',
			fixed: true,
			ok: function () {
				var origin = artDialog.open.origin;
				var guide = this.iframe.contentWindow.gosubmint();
				var guide_html = '';
				for (var j = 0; j < guide.length; j++) {
					if (guide[j].id) { 
						var i = parseInt(Math.random()*100000)+j;
						var cost = '<input type="hidden" name="cost['+i+'][item]" value="'+guide[j].kind+'"><input type="hidden" name="cost['+i+'][cost_type]" value="2"><input type="hidden" name="cost['+i+'][remark]" value="'+guide[j].name+'"><input type="hidden" name="cost['+i+'][relevant_id]" value="'+guide[j].id+'">';	
						guide_html += '<tr class="expense" id="guide_'+i+'"><td>'+cost+'<input type="hidden" name="guide['+i+'][guide_id]" value="'+guide[j].id+'"><input type="hidden" name="guide['+i+'][name]" value="'+guide[j].name+'"><input type="hidden" name="guide['+i+'][kind]" value="'+guide[j].kind+'"><input type="hidden" name="guide['+i+'][sex]" value="'+guide[j].sex+'"><a href="javascript:;" onClick="open_guide('+guide[j].id+',\''+guide[j].name+'\')">'+guide[j].name+'</a><i class="fa  fa-calendar" style="color:#3CF; margin-left:8px; cursor:pointer;"  onClick="course('+guide[j].id+',\'<?php echo $op['op_id']; ?>\')"></i></td><td>'+guide[j].kind+'</td><td>'+guide[j].sex+'</td><td><input type="text" name="cost['+i+'][cost]" placeholder="价格" value="'+guide[j].fee+'" class="form-control min_input cost" /></td><td><span>X</span></td><td><input type="text" name="cost['+i+'][amount]" placeholder="数量" value="1" class="form-control min_input amount" /></td><td class="total">&yen;'+guide[j].fee*1+'</td><td><input type="text" name="guide['+i+'][remark]" value="" class="form-control" /></td><td><a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox(\'guide_'+i+'\')">删除</a></td></tr>';
					};
				}
				$('#guidelist').show();
				$('#nonetext').hide();
				$('#guidelist').find('tbody').append(guide_html);	
				total();
			},
			cancelValue:'取消',
			cancel: function () {
			}
		});	
	}

    //选择校园科技节产品
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
                        var costacc = '<input type="hidden" name="costacc['+i+'][type]" value="5">' +
                            '<input type="hidden" name="costacc['+i+'][title]" value="'+product[j].title+'">' +
                            '<input type="hidden" name="costacc['+i+'][product_id]" value="'+product[j].id+'">';
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
                $('#nonetext').hide();
                $('#productlist').find('tbody').append(product_html);
                total();
            },
            cancelValue:'取消',
            cancel: function () {
            }
        });
    }


    //选择合格供方
	function selectsupplier() {
		art.dialog.open('<?php echo U('Op/select_supplier'); ?>',{
			lock:true,
			title: '选择合格供方',
			width:1000,
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
						var cost = '<input type="hidden" name="cost['+i+'][item]" value="'+supplier[j].kind+'"><input type="hidden" name="cost['+i+'][remark]" value="'+supplier[j].name+'"><input type="hidden" name="cost['+i+'][cost_type]" value="3"><input type="hidden" name="cost['+i+'][relevant_id]" value="'+supplier[j].id+'">';	
						supplier_html += '<tr class="expense" id="supplier_'+i+'"><td style="vertical-align:middle">'+cost+'<input type="hidden" name="supplier['+i+'][supplier_id]" value="'+supplier[j].id+'"><input type="hidden" name="supplier['+i+'][supplier_name]" value="'+supplier[j].name+'"><input type="hidden" name="supplier['+i+'][kind]" value="'+supplier[j].kind+'"><input type="hidden" name="supplier['+i+'][city]" value="'+supplier[j].city+'"><div class="tdbox"><a href="javascript:;" onClick="open_supplier('+supplier[j].id+',\''+supplier[j].name+'\')">'+supplier[j].name+'</a></div></td><td>'+supplier[j].kind+'</td><td>'+supplier[j].city+'</td><td><input type="text" name="cost['+i+'][cost]" placeholder="价格"  value="0.00" class="form-control min_input cost" /></td><td><span>X</span></td><td><input type="text" name="cost['+i+'][amount]" placeholder="数量" value="1" class="form-control min_input amount" /></td><td class="total">&yen;0</td><td><input type="text" name="supplier['+i+'][remark]" value="" class="form-control" /></td><td><a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox(\'supplier_'+i+'\')">删除</a></td></tr>';
					};
				}
				$('#supplierlist').show();
				$('#nonetext').hide();
				$('#supplierlist').find('tbody').append(supplier_html);	
				total();
			},
			cancelValue:'取消',
			cancel: function () {
			}
		});	
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
				var user_html = '';
				var no = parseInt($('#user_val').text());
				for (var j = 0; j < user.length; j++) {
					var i = parseInt(Math.random()*100000)+j;
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
				$('#user_val').html(parseInt(user.length)+parseInt(no));
				orderno();
			},
			cancelValue:'取消',
			cancel: function () {
			}
		});	
	}
	

	//物资申请
	function selectmaterial() {
		art.dialog.open('<?php echo U('Op/select_material'); ?>',{
			lock:true,
			title: '申请物资',
			width:1000,
			height:500,
			okValue: '提交',
			fixed: true,
			ok: function () {
				var origin = artDialog.open.origin;
				var wuzi = this.iframe.contentWindow.gosubmint();	
				var i = parseInt($('#wuzi_val').text())+1;
				
				var cost = '<input type="hidden" name="cost['+i+'][item]" value="物资费"><input type="hidden" name="cost['+i+'][cost_type]" value="4"><input type="hidden" name="cost['+i+'][relevant_id]" value="'+wuzi[0].id+'"><input type="hidden" name="cost['+i+'][remark]" value="'+wuzi[0].materialname+'">';
				var wuzi_html = '<tr class="expense" id="wuzi_'+i+'"><td>'+cost+'<input type="hidden" name="wuzi['+i+'][material]" value="'+wuzi[0].materialname+'"><input type="hidden" name="wuzi['+i+'][material_id]" value="'+wuzi[0].id+'">'+wuzi[0].materialname+'</td><td><input type="text" name="cost['+i+'][cost]" value="'+wuzi[0].unit_price+'" placeholder="价格" class="form-control min_input cost" /></td><td><span>X</span></td><td><input type="text" name="cost['+i+'][amount]" value="'+wuzi[0].amount+'" placeholder="数量" class="form-control min_input amount" /></td><td class="total">&yen;'+parseInt(wuzi[0].unit_price)*parseInt(wuzi[0].amount)+'</td><td><input type="text" name="wuzi['+i+'][remarks]" value="'+wuzi[0].remarks+'" class="form-control" /></td><td><a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox(\'wuzi_'+i+'\')">删除</a></td></tr>';
				
				
				$('#opmaterial').show();
				$('#nonetext').hide();
				$('#opmaterial').find('tbody').append(wuzi_html);	
				$('#wuzi_val').html(i);
				total();
				
			},
			cancelValue:'取消',
			cancel: function () {
			}
		});	
	}
	

	//查看供方信息
	function open_supplier(url,title) {
		art.dialog.open('index.php?m=Main&c=SupplierRes&a=res_view&viewtype=1&id='+url,{
			lock:true,
			title: title,
			width:1000,
			height:500,
			fixed: true,
		});	
	}
	

	//查看专家辅导员信息
	function open_guide(url,title) {
		art.dialog.open('index.php?m=Main&c=GuideRes&a=res_view&viewtype=1&id='+url,{
			lock:true,
			title: title,
			width:1000,
			height:500,
			fixed: true,
		});	
	}
	

	//增加日程
	function task(obj){
		
		var i = parseInt($('#task_val').text())+1;

		var header = '<div class="daylist" id="task_ti_'+i+'"><a class="aui_close" href="javascript:;" style="right:25px;" onClick="del_timu(\'task_ti_'+i+'\')">×</a><div class="col-md-12 pd"><label class="titou"><strong>第<span class="tihao">'+i+'</span>天</strong></label>';
		
		var days = '<div class="input-group"><input type="text" placeholder="所在城市" name="days['+i+'][citys]" class="form-control"></div><div class="input-group pads"><textarea class="form-control" placeholder="行程安排"  name="days['+i+'][content]"></textarea></div><div class="input-group"><input type="text" placeholder="房餐车安排" name="days['+i+'][remarks]" class="form-control"></div>';
		
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
	
	//删除日程
	function del_timu(obj){
		$('#'+obj).remove();
		$('.tihao').each(function(index, element) {
			 var no = index*1+1;
		   $(this).text(no);     
		});
	}
	
	//更新价格与数量
	function total(){
		$('.expense').each(function(index, element) {
            $(this).find('.cost').blur(function(){
				var cost = $(this).val();
				var amount = $(this).parent().parent().find('.amount').val();
				$(this).parent().parent().find('.total').html('&yen;'+accMul(cost,amount));	
				$(this).parent().parent().find('.cost_cost').val(cost);	
				$(this).parent().parent().find('.totalval').val(accMul(cost,amount));	
			});
			 $(this).find('.amount').blur(function(){
				var amount = $(this).val();
				var cost = $(this).parent().parent().find('.cost').val();
				$(this).parent().parent().find('.total').html('&yen;'+accMul(cost,amount));	
				$(this).parent().parent().find('.cost_amount').val(amount);	
				$(this).parent().parent().find('.totalval').val(accMul(cost,amount));	
			});
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
	function save(id,url,opid){
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
		
		 setTimeout("history.go(0)",1000);
		/*
		if(id=='save_line_days'){
			$.get("<?php /*echo U('Op/public_ajax_material'); */?>",{id:opid}, function(result){
				$('#opmaterial').find('tbody').html(result);
			});
		}
		*/
	}
	
	
	function ctselect(){
		var status = $('#opstatus').val();
		if(status == '1'){
			$('#chengtuala').show();
			$('#buchengtuan').hide();
		}else{
			$('#chengtuala').hide();
			$('#buchengtuan').show();	
		}
	}
	
	function ConfirmOp(id,url) {
		
		if (confirm("您真的确定操作吗？")){
			$.ajax({
             type: "POST",
             url: url,
			 dataType:'json', 
             data: $('#'+id).serialize(),
             success:function(data){
                 if(parseInt(data)>0){
					  $('#chengtuan').hide();
					  $('#chengtuanstatus').html('<span class="green">项目已成团</span>');
					  //$('body,html').animate({scrollTop:0},1000); 
					  location.reload(); 
				 }else{
					  art.dialog.alert('保存失败','warning');	 
				 }
             }
        	});	
		}else{
			return false;
		}
	}
	
	
	//指派责任人
	function assign(url,title){
		art.dialog.open(url,{
			lock:true,
			title: title,
			width:800,
			height:500,
			okValue: '提交',
			ok: function () {
				this.iframe.contentWindow.gosubmint();
				return false;
			},
			cancelValue:'取消',
			cancel: function () {
			}
		});	
	}
	
		
	
	$(document).ready(function(e) {
        total();
		$.formValidator.initConfig({autotip:true,formid:"save_op",onerror:function(msg){}});
		$("#gid").formValidator({onshow:"请输入项目团号",onfocus:"请输入项目团号"}).inputValidator({min:4,max:20,onerror:""}).regexValidator({regexp:"ps_username",datatype:"enum",onerror:"项目团号有误"}).ajaxValidator({
			type : "get",
			url : "<?php echo U('Op/public_checkname_ajax'); ?>",
			datatype : "html",
			async:'false',
			success : function(data){
				if( data == 1 ) {
					return true;
				} else {
					return false;
				}
			},
			buttons: $("#dosubmit"),
			onerror : "项目团号已存在",
			onwait : "请稍候..."
		});
		
    });
	
	
	//排课
	function course(id,opid) {
		art.dialog.open('index.php?m=Main&c=Op&a=course&opid='+opid+'&id='+id,{
			lock:true,
			title: '排课',
			width:1000,
			height:700,
			fixed: true,
		});	
	}

    //新增辅导员/教师、专家
    function add_tcs(){
        var i = parseInt($('#tcs_val').text())+1;
        var html = '<div class="userlist no-border" id="tcs_'+i+'">' +
            '<span class="title"></span> ' +
            '<select  class="form-control" style="width:15%" name="data['+i+'][guide_kind_id]" id="se_'+i+'" onchange="getPrice('+i+')"><option value="" selected disabled>请选择</option> <foreach name="guide_kind" key="k" item="v"> <option value="{$k}">{$v}</option></foreach></select> ' +
            '<select  class="form-control gpk" style="width:15%" name="data['+i+'][gpk_id]" id="gpk_id_'+i+'" onchange="getPrice('+i+')"><option value="" selected disabled>请选择</option> <foreach name="hotel_start" key="k" item="v"> <option value="{$k}">{$v}</option></foreach></select> ' +
            '<input type="text"  class="form-control" style="width:6%" name="data['+i+'][days]" id="days_'+i+'" onblur="getTotal('+i+')" > ' +
            '<input type="text"  class="form-control" style="width:6%" name="data['+i+'][num]" id="num_'+i+'" onblur="getTotal('+i+')" > ' +
            '<input type="text"  class="form-control" style="width:10%" name="data['+i+'][price]" id="dj_'+i+'" value="" onblur="getTotal('+i+')">' +
            '<input type="text"  class="form-control" style="width:10%" name="data['+i+'][total]" id="total_'+i+'">' +
            '<input type="text"  class="form-control" style="width:20%" name="data['+i+'][remark]">' +
            '<a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox(\'tcs_'+i+'\')">删除</a></div>';
        $('#tcs').append(html);
        $('#tcs_val').html(i);
        assign_option(i);
        orderno();
    }

    function assign_option(a){
        if(price_kind){
            $("#gpk_id_"+a).empty();
            var count = price_kind.length;
            var i= 0;
            var b="";
            b+='<option value="" disabled selected>请选择</option>';
            for(i=0;i<count;i++){
                b+="<option value='"+price_kind[i].id+"'>"+price_kind[i].name+"</option>";
            }
            $("#gpk_id_"+a).append(b);
        }else{
            $("#gpk_id_"+a).empty();
            var b='<option value="" disabled selected>无数据</option>';
            $("#gpk_id_"+a).append(b);
        }
    }

    //获取单价信息
    function getPrice(a){
        var guide_kind_id = $('#se_'+a).val();
        var gpk_id        = $('#gpk_id_'+a).val();
        $.ajax({
            type:'POST',
            url:"{:U('Ajax/getPrice')}",
            data:{guide_kind_id:guide_kind_id,gpk_id:gpk_id,opid:opid},
            success:function(msg){
                $('#dj_'+a).val(msg);
                getTotal(a);
            }
        })
    }

    //获取人数,计算出总价格\
    function getTotal(a){
        var num     = parseInt($('#num_'+a).val());
        var days    = parseInt($('#days_'+a).val());
        var price   = parseFloat($('#dj_'+a).val());
        var total   = num*price*days;
        $('#total_'+a).val(total);
    }

    //项目交接
    function open_change (opid) {
        art.dialog.open('<?php echo U('Op/change_op',array('opid'=>$opid)) ?>', {
            lock:true,
            id: 'change',
            title: '项目交接',
            width:600,
            height:300,
            okValue: '提交',
            ok: function () {
                this.iframe.contentWindow.gosubmint();
                location.reload();
                return false;
            },
            cancelValue:'取消',
            cancel: function () {
            }
        });
    }

</script>	


     


