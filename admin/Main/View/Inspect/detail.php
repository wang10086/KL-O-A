<include file="Index:header2" />

    <aside class="right-side">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>巡检详情</h1>
            <ol class="breadcrumb">
                <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                <li><a href="{:U('Inspect/record')}"><i class="fa fa-gift"></i> 巡检记录</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
        
            <div class="row">
                 <!-- right column -->
                <div class="col-md-12">
                     
                     
                     
                     <div class="box box-warning" style="margin-top:15px;">
                        <div class="box-header">
                            <h3 class="box-title">
                            {$row.title}
                            </h3>
                            <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;"><span class="green">巡检人员：{$row.ins_uname}</span></h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="content">
                            	<div class="form-group col-md-12">
                                    <h2 class="brh3">巡检信息</h2>
                                </div>
                                <div class="form-group col-md-12">
                                <table width="100%" id="font-14" rules="none" border="0" cellpadding="0" cellspacing="0" style="margin-top:-15px;">
                                    
                                    <tr>
                                        <td width="33.33%">巡检日期：{$row.ins_date}</td>
                                        <td width="33.33%">巡检类型：{$row.type}</td>
                                        <td width="33.33%">巡检对象：{$row.duixiang}</td>
                                    </tr>
                                    <tr>
                                        <td>巡检人员：{$row.ins_uname}</td>
                                        <td>发布时间：{$row.create_time}</td>
                                        <td></td>
                                    </tr>
                                    
                                </table>
                                </div>
                                
                                <div class="form-group col-md-12" style="margin-bottom:0;">
                                    <h2 class="brh3">巡检内容</h2>
                                </div>
                                <div class="form-group col-md-12">
                                    {$row.content}
                                </div>
                                
                                
                                <div class="form-group col-md-12" style="margin-bottom:0; margin-top:15px;">
                                    <h2 class="brh3">巡检结果 <span style="float:right;">{$row.problem_str}</span></h2>
                                </div>
                                <div class="form-group col-md-12">
                                	<?php 
									if($row['problem']==1 || $row['problem_desc']){ 
										echo $row['problem_desc'];
									}else{
										echo '未发现问题';	
									}
									?>
                                    
                                </div>
                                
                                <?php if($row['problem']==1){ ?>
                                <div class="form-group col-md-12" style="margin-bottom:0; margin-top:15px;">
                                    <h2 class="brh3">解决方案 <span style="float:right;">{$row.issolve_str}</span></h2>
                                </div>
                                <div class="form-group col-md-12">
                                	{$row.resolvent}
                                </div>
                                <?php } ?>
                                
                                
                                
                                <if condition="$atts">
                                <div class="form-group col-md-12" style="margin-bottom:0; margin-top:15px;">
                                    <h2 class="brh3">巡检资料</h2>
                                </div>
                                <div class="form-group col-md-12" style=" padding-top:10px;">
                                	<div id="showimglist">
                                        <foreach name="atts" key="k" item="v">
											<?php if(isimg($v['filepath'])){ ?>
                                            <a href="{$v.filepath}" target="_blank"><div class="fileext"><?php echo isimg($v['filepath']); ?></div></a>
                                            <?php }else{ ?>
											<a href="{$v.filepath}" target="_blank"><img src="{:thumb($v['filepath'],100,100)}" style="margin-right:15px; margin-top:15px;"></a>
											<?php } ?>
                                        </foreach>
                                    </div>
                                </div>
                                </if>
                                
                                <div class="form-group">&nbsp;</div>
                                <div class="form-group">&nbsp;</div>
                                
                                
                                
                            </div>
                            
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                    
                    
                    
                    
                </div><!--/.col (right) -->
                
                
               
                
            </div>   <!-- /.row -->
            
        </section><!-- /.content -->
        
    </aside><!-- /.right-side -->
			
  </div>
</div>

<include file="Index:footer2" />

