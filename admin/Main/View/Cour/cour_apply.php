		<include file="Index:header" />
        
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <include file="Index:menu" />

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>课件详情</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Cour/courlist')}">课件列表</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        
                        
                        <div class="col-md-12">
                            
                            <div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title" id="bigtit">{$row.subject}</h3>
                                </div>
                                <div class="box-body" id="courapp" style="padding-top:20px;">
                                    <div class="form-group col-md-12">
                                        <label>课件概要</label>
                                        <div class="fonttextms">
                                        <?php if($row['summary']){ echo nl2br($row['summary']); }else{ echo '无';}?>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>教学目的</label>
                                        <div class="fonttextms">
                                        <?php if($row['requirement']){ echo nl2br($row['requirement']); }else{ echo '无';}?>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>备注</label>
                                        <div class="fonttextms">
                                        <?php if($row['remarks']){ echo nl2br($row['remarks']); }else{ echo '无';}?>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12" style="margin-bottom:0; color:#0BABD4;">
                                        <label>标签：</label><span>{$row.tag}</span>
                                    </div>
                                    
                                    <div class="form-group">&nbsp;</div>
                                </div>
                            </div>
                        </div>
                        
                        
                        
                        <div class="col-md-12">
                            <div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title">课件附件</h3>
                                </div>
                                <div class="box-body" style="padding-top:20px; padding-bottom:50px;">
                                    <?php if($atts){ ?>
                                    {:get_upload_m($atts)}
                                    <?php }else{ echo '<div class="col-md-3">无</div>';} ?>
                                    <div class="form-group">&nbsp;</div>
                                </div>
                            </div>
                        </div>
                        
                        
                        
                        <div class="col-md-12">
                            <div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title">所需物资</h3>
                                </div>
                                <div class="box-body" style="padding-top:20px;">                                    
                                    <div id="sitelist">
                                    	<?php if($facall){ ?>
                                    	<foreach name="facall" item="v">
                                        	<div class="col-md-3">
                                            	{$v.res_name}：{$v.res_spec}
                                            </div>
                                        </foreach>
                                        <?php }else{ echo '<div class="col-md-3">无</div>';} ?>
                                    </div>

                                    <div class="form-group">&nbsp;</div>
                                        
                                </div>
                            </div>
                        </div>
                        
                        <!--
                        <div class="col-md-12">
                        		<div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title">课后作业</h3>
                                </div>
                                <div class="box-body">
                                    {:get_qa($courlist)}
                                    <div class="form-group">&nbsp;</div>
                                </div>
                            </div>
                            
                        </div>
                        -->
                        
                        <?php if(isappauth(2)){ ?>
                        <div class="col-md-12">
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">审核</h3>
                                </div>
                                <div class="box-body">
                                    <form method="post" action="{:U('Apply/cour_apply')}" name="myform" id="myform">
                        			<input type="hidden" name="dosubmint" value="1" />
                        			<input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
                        			<input type="hidden" name="cour_id" value="{$row.cour_id}" />
                                    <div class="form-group col-md-12" style="margin-top:10px;">
                                        <div class="checkboxlist" id="applycheckbox" style="margin-top:10px;">
                                        <input type="radio" name="status" value="1" <?php if($app['app_result']==1){ echo 'checked';} ?> > 通过 &nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="radio" name="status" value="2" <?php if($app['app_result']==2){ echo 'checked';} ?> > 不通过
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="form-group col-md-12 select_2 "  <?php if($app['app_result']==1 || $app['app_result']==0){ echo 'style="display:none;"'; } ?> >
                                    	<div style="border-top:2px solid #dedede; margin-top:15px; padding-top:20px;">
                                            <label>拒绝原因</label>
                                            <input type="text" name="reason" class="form-control" value="{$app.ex_opinion}" />
                                        </div>
                                    </div>
                                    
                                    <if condition="$ages">
                                    <div class="form-group col-md-12 select_1" <?php if($app['app_result']==2 || $app['app_result']==0){ echo 'style="display:none;"'; } ?>>
                                    	<div  style="border-top:2px solid #dedede; margin-top:15px; padding-top:20px;">
                                            <label>适用年龄</label>
                                            <ul class="checkboxlist">
                                                <foreach name="ages" key="k" item="v">
                                                    <li class="col-md-3"><input type="checkbox" name="age[]" value="{$k}" <?php if(in_array($k,$arr_age)){ echo 'checked';} ?> > {$v} </li>
                                                </foreach>
                                            </ul>
                                        </div>
                                    </div>
                                    </if>
                                    
                                    <if condition="$prokinds">
                                    <div class="form-group col-md-12 select_1" <?php if($app['app_result']==2 || $app['app_result']==0){ echo 'style="display:none;"'; } ?>>
                                        <label>适用项目类型</label>
                                        <ul class="checkboxlist">
                                            <foreach name="prokinds" key="k" item="v">
                                            	<li class="col-md-3"><input type="checkbox" name="kinds[]" value="{$k}" <?php if(in_array($k,$arr_kind)){ echo 'checked';} ?> > {$v} </li>
                                            </foreach>
                                        </ul>
                                    </div>
                                    </if>
                                   
                                    <div class="form-group">&nbsp;</div>
                                    
                                    <div class="form-group savebtn">
                                        <button class="btn btn-success btn-lg saves" style="float:left;"><i class="fa fa-pencil-square"></i> 保存</button>
                                    </div>
                                    </form>
                                    
                                    
                                    
                                    <if condition="$applist">
                                    <div class="form-group col-md-12" id="apptab" style="margin-top:15px;">
                                        <div class="box-body no-padding">
                                            <table class="table">
                                                <tr>
                                                    <th width="150">申请日期</th>
                                                    <th width="100">审核结果</th>
                                                    <th width="100">审核者</th>
                                                    <th width="150">审核日期</th>
                                                    <th>备注</th>
                                                </tr>
                                                <foreach name="applist" key="k" item="v">
                                                <tr>
                                                    <td>{$v.app_time|date='Y-m-d H:i',###}</td>
                                                    <td>{$v.status}</td>
                                                    <td>{$v.name}</td>
                                                    <td><if condition="$v['ex_time']">{$v.ex_time|date='Y-m-d H:i',###}</if></td>
                                                    <td>{$v.remarks} {$v.ex_opinion}</td>
                                                </tr>
                                                </foreach>
                                            </table>
                                        </div>
                                    </div>
                                    </if>
                                    
                                    <div class="form-group">&nbsp;</div>
                                    
                                </div>
                                
                            </div>
                        </div>
                        <?php } ?>
                        
                        
                    </div><!-- /.row -->
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
        
        
        <include file="Index:footer" />
        <script type="text/jscript">
		$(document).ready(function(e) {
            $('#applycheckbox').find('ins').each(function(index, element) {
                $(this).click(function(){
					if(index==0){
						$('.select_1').show();
						$('.select_2').hide();	
					}else{
						$('.select_2').show();
						$('.select_1').hide();	
					}
				})
            });
        });
        </script>
        
       
        