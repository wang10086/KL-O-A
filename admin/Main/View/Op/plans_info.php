<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>项目计划</h1>
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
                        	
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">项目信息</h3>
                                    <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;"><span class="green">项目编号：{$op.op_id}</span> &nbsp;&nbsp;创建者：{$op.create_user_name}</h3>
                                    
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                    
                                    	<div class="form-group col-md-12">
                                            <span id="chengtuanstatus">
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
                                            </span>
                                        </div>
                                        
                                        <div class="form-group col-md-4 viwe">
                                            <p>审批状态：{$op.showstatus}</p>
                                        </div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>审批人：{$op.show_user}</p>
                                        </div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>审批时间：{$op.show_time}</p>
                                        </div>
                                        <php> if($op['show_reason']){ </php>
                                        <div class="form-group col-md-4 viwe">
                                            <p>审批说明：{$op.show_reason}</p>
                                        </div>
                                        <php> } </php>
                                        
                                     
                                        <include file="op_pro" />
                                        
                                        
                                    </div>
                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            <php> if($op['audit_status']==1){ </php>
                                <div class="box box-warning">
                                    <div class="box-header">
                                        <h3 class="box-title">成本核算</h3>
                                    </div>
                                    <div class="box-body">
                                        <php> if(cookie('userid') == $op['create_user']){ </php>
                                        <include file="op_costacc_edit" />
                                        <php> }else{ </php>
                                        <include file="op_costacc" />
                                        <php> } </php>
                                    </div>
                                </div>
                            
                            
                            
                                <div class="box box-warning">
                                    <div class="box-header">
                                        <h3 class="box-title">项目行程</h3>
                                        <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;">
                                        <php> if($opauth && $opauth['line']){ </php>
                                        负责人：{$user.$opauth[line]}
                                        <php> }else{ </php>
                                        	<php> if(rolemenu(array('Op/assign_line'))){ </php>
                                        	<a href="javascript:;" onclick="javascript:assign('{:U('Op/assign_line',array('opid'=>$op['op_id']))}','指派项目线路行程负责人');" style="color:#09F;">指派负责人</a>
                                            <php> }else{ </php>
                                            暂未指派负责人
                                            <php> } </php>
                                            
										<php> } </php>
                                        </h3>
                                    </div>
                                    <div class="box-body">
                                        
                                        <include file="op_line" />
                                        
                                        <div class="form-group">&nbsp;</div>
                                    </div>
                                </div>
                                
                                <div class="box box-warning">
                                    <div class="box-header">
                                        <h3 class="box-title">专家辅导员调度</h3>
                                        <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;">
                                        <php> if($opauth && $opauth['guide']){ </php>
                                        负责人：{$user.$opauth[guide]}
                                        <php> }else{ </php>
                                        暂未指派负责人
										<php> } </php>
                                        </h3>
                                    </div>
                                    
                                    <include file="op_res_guide" />
                                    
                                </div>
                                
                                
                                
                                
                                
                                
                                <div class="box box-warning">
                                    <div class="box-header">
                                        <h3 class="box-title">合格供方调度</h3>
                                        <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;">
                                        <php> if($opauth && $opauth['material']){ </php>
                                        负责人：{$user.$opauth[material]}
                                        <php> }else{ </php>
                                        暂未指派负责人
										<php> } </php>
                                        </h3>
                                    </div>
                                    
                                    <include file="op_res_material" />
                                    
                                </div>
                                
                                
                                
                                
                                <div class="box box-warning">
                                    <div class="box-header">
                                        <h3 class="box-title">物资调度</h3>
                                        <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;">
                                        <php> if($opauth && $opauth['res']){ </php>
                                        负责人：{$user.$opauth[res]}
                                        <php> }else{ </php>
                                        暂未指派负责人
										<php> } </php>
                                        </h3>
                                    </div>
                                    
                                    <include file="op_res" />
                                    
                                </div>
                                
                                
                                
                                <div class="box box-warning">
                                    <div class="box-header">
                                        <h3 class="box-title">人员名单</h3>
                                    </div>
                                    <div class="box-body">
                                        
                                        <include file="op_member" />
                                        
                                    </div>
                                </div>
                               
                                
                                <div class="box box-warning">
                                    <div class="box-header">
                                        <h3 class="box-title">项目标价</h3>
                                        <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;">
                                        <php> if($opauth && $opauth['price']){ </php>
                                        负责人：{$user.$opauth[price]}
                                        <php> }else{ </php>
                                        暂未指派负责人
										<php> } </php>
                                        </h3>
                                    </div>
                                    <div class="box-body">
                                        <div class="content">
                                            
                                            <include file="op_price" />
                                           
                                        </div>
                                    </div>
                                </div>
                                
                                <php> if(cookie('userid') == $op['create_user'] && $op['audit_status']==1 && $op['status']==0){ </php>
                                <include file="op_end" />
                                <php> } </php>
                                
                                
                                
                                <div class="box box-warning">
                                    <div class="box-header">
                                        <h3 class="box-title">项目操作记录</h3>
                                    </div>
                                    <div class="box-body">
                                        <div class="content">
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
                            
                            <php> } </php>
                           
                        </div>
                    </div>
                    
                    
                </section><!-- /.content -->
                
            </aside><!-- /.right-side -->
			
  </div>
</div>

<include file="Index:footer2" />
