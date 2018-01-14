		<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{$title}</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Rbac/kpi_users')}"><i class="fa fa-gift"></i> KPI</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
               
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                            
                                  
                            <div class="btn-group" id="catfont" style="padding-bottom:20px;">
                            	<a href="{:U('Kpi/kpiinfo',array('year'=>$prveyear,'uid'=>$uid))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>
								<?php 
                                for($i=1;$i<13;$i++){
                                    $par = array();
                                    $par['year']  = $year;
                                    $par['month'] = str_pad($i,2,"0",STR_PAD_LEFT);
									$par['post']  = $post;
                                    if($month==$i){
                                        echo '<a href="'.U('Kpi/postkpi',$par).'" class="btn btn-info" style="padding:8px 18px;">'.$i.'月</a>';
                                    }else{
                                        echo '<a href="'.U('Kpi/postkpi',$par).'" class="btn btn-default" style="padding:8px 18px;">'.$i.'月</a>';
                                    }
                                }
                                ?>
                                <a href="{:U('Kpi/kpiinfo',array('year'=>$nextyear,'uid'=>$uid))}" class="btn btn-default" style="padding:8px 18px;">下一年</a>
                            </div>
                            
                            <div class="box-tools pull-right">
                            	<select class="form-control">
                                	<foreach name="upost" key="k" item="v"> 
                                	<option value="{$k}" <?php if($post==$k){ echo 'selected';} ?> >{$v}</option>
                                    </foreach>
                                </select>
                            </div>
                                    
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">考核指标</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    	
                                    <table class="table table-bordered dataTable fontmini" id="tablecenter">
                                        <tr role="row" class="orders" >
                                            <th rowspan="2" width="40">序号</th>
                                            <th rowspan="2" width="80">被考评人</th>
                                            <?php 
											foreach($postlist as $k=>$v){
												echo '<th colspan="2">'.$v.'</th>';	
											}
											?>
                                            <th rowspan="2">总分</th>
                                            
                                        </tr>
                                        <tr role="row" class="orders" >
                                        	<?php 
											foreach($postlist as $k=>$v){
												echo '<th width="70">得分</th><th width="70">权重</th>';	
											}
											?>
                                        </tr>
                                        <foreach name="kpils" key="key" item="row"> 
                                        <tr>
                                            <td align="center"><?php echo $key+1; ?></td>
                                            <td><a href="javascript:;">{$row.nickname}</a></td>
                                            <?php 
											$zf = 0;
											foreach($kpils[$key]['kpi'] as $k=>$v){
												echo '<th width="70">'.$v['score'].'</th><th width="70">'.$v['weight'].'</th>';	
												$zf += $v['score'];
											}
											?>
                                            <td align="center"><?php echo $zf; ?></td>
                                        </tr>
                                        </foreach>					
                                    </table> 
                                    
                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            
                            
                            
                            
                            
                            
                            
                        </div><!--/.col (right) -->
                        
                        
                        
                        
                                    
                        
                        
                        
                       
                        
                    
                    </div>   <!-- /.row -->
                    
                    
                    
                    
                </section><!-- /.content -->
                
            </aside><!-- /.right-side -->
			
  		</div>
	</div>

	<include file="Index:footer2" />
    
    