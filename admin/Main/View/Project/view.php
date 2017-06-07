<include file="Index:header2" />



            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        <span class="green">{$row.name}</span></span>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Project/index')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                            <!-- general form elements disabled -->
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">项目详情</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                	
                                    <div class="content">
                                		
                                       
                                        <div class="form-group col-md-12 viwe">
                                            <p>项目名称：{$row.name}</p>
                                        </div>
                                         <div class="form-group col-md-12 viwe">
                                            <p>项目分类：{:get_prj_kind_name($row['kind'])}   </p>
                                        </div>
                                        
                                        <div class="form-group col-md-3 viwe">
                                            <p>立项人：{$row.chief}</p>
                                        </div>
                                        
                                        
                                        <div class="form-group col-md-3 viwe">
                                            <p>审批状态：{$row.showstatus}</p>
                                        </div>
                                        <div class="form-group col-md-3 viwe">
                                            <p>审批人：{$row.show_user}</p>
                                        </div>
                                        <div class="form-group col-md-3 viwe">
                                            <p>审批时间：{$row.show_time}</p>
                                        </div>
                                        
                                       
                                    </div>
                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            
                            <?php if($row['desc']){ ?>
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">项目背景</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                	
                                    
                                    <div class="content" style="margin-top:10px;">
                                    	<div class="form-group col-md-12 viwe">{$row.desc}</div>
                                    </div>
                                   
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            <?php } ?>
                            
                            <?php if($pids){ ?>
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">包含产品</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body" >
                                
                                <div style="padding: 0 15px;">
                                
                                     <table id="flist" class="table table-bordered" >
                                           <tr valign="middle">
                                                <th style="text-align: center;" width="80">ID</th>
                                                <th style="text-align: center;">产品名称</th>
                                                <th style="text-align: center;">业务部门</th>
                                                <th style="text-align: center;">科学领域</th>
                                                <th style="text-align: center;">适用年龄</th>
                                                
                                            </tr>   
                                            
                                            <foreach name="pids" item="v">
                        <tr id="pid_{$v.id}" valign="middle">
		                <td align="center">{$v.id}<input type="hidden" name="pids[]" value="{$v.id}" /></td>
		                <td align="center"><a href="{:U('Product/view', array('id'=>$v['id']))}" target="_blank">{$v.title}</a></td>
		                <td align="center">{:C('BUSINESS_DEPT.'.$v['business_dept'])}</td>
		                <td align="center">{:C('SUBJECT_FIELD.'.$v['subject_field'])}</td>
		                <td align="center">{:C('AGE_LIST.'.$v['age'])}</td>
		                </tr> 
                                            
                                            </foreach> 
                                           
                                   </table>
                               </div> 
                 
                            </div><!-- /.box-body -->
                                
                            </div><!-- /.box -->
                          <?php } ?>  
                            
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                </section><!-- /.content -->
                
            </aside><!-- /.right-side -->

  </div>
</div>


            
<include file="Index:footer2" />