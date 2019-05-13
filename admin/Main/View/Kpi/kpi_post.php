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
                            	<?php if($prveyear>2017){ ?>
                                <a href="{:U('Kpi/postkpi',array('year'=>$prveyear,'month'=>'01','post'=>$post))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>
                                <?php } ?>
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
                                <?php if($year<date('Y')){ ?>
                                <a href="{:U('Kpi/postkpi',array('year'=>$nextyear,'month'=>'01','post'=>$post))}" class="btn btn-default" style="padding:8px 18px;">下一年</a>
                                <?php } ?>
                            </div>
                            
                            
                                    
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">考核指标</h3>
                                    <?php if($upost){ ?>
                                    <div class="box-tools pull-right">
                                        <select class="form-control"  onchange="window.location=this.value;">
                                            
                                            <foreach name="upost" key="k" item="v">
                                            <?php 
                                            $par = array();
                                            $par['year']  = $year;
                                            $par['month'] = $month;
                                            $par['post']  = $k;
                                            ?> 
                                            <option value="{:U('Kpi/postkpi',$par)}" <?php if($post==$k){ echo 'selected';} ?> >{$v}</option>
                                            </foreach>
                                        </select>
                                    </div>
                                    <?php } ?>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    	
                                    <table class="table table-bordered dataTable fontmini" id="tablecenter">
                                        <tr role="row" class="orders" >
                                            <th <?php if($check){ echo 'rowspan="2"';} ?> width="40">序号</th>
                                            <th <?php if($check){ echo 'rowspan="2"';} ?> style="text-align:left;">被考评人</th>
                                            <?php
											if($check){ 
												foreach($postlist as $k=>$v){
													$kp = explode('-',$v); 
													echo '<th colspan="2">'.$kp[0].'</th>';	
												}
											}else{
												echo '<th>KPI指标</th>';	
											}
											?>
                                            <th <?php if($check){ echo 'rowspan="2"';} ?> width="80">总分</th>
                                        </tr>
                                        <?php if($check){  ?>
                                        <tr role="row" class="orders" >
                                        	<?php 
											foreach($postlist as $k=>$v){
												echo '<th >得分</th><th>权重</th>';	
											}
											?>
                                        </tr>
                                        <?php } ?>
                                        <foreach name="kpils" key="key" item="row"> 
                                        <tr>
                                            <td align="center"><?php echo $key+1; ?></td>
                                            <td style="text-align:left;"><a href="{:U('Kpi/kpiinfo',array('year'=>$year,'month'=>$month,'uid'=>$row['id']))}">{$row.nickname}</a></td>
                                            <?php 
											$zf = 0;
											
											if($kpils[$key]['kpi']){
												foreach($kpils[$key]['kpi'] as $k=>$v){
													echo '<th>'.$v['score'].'</th><th>'.$v['weight'].'</th>';	
													$zf += $v['score'];
												}
											}else{
												echo '<th colspan="'.(count($postlist)*2).'" style="color:#999999;">暂未获取KPI信息</th>';
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
    
    