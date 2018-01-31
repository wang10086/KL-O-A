<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1><span class="red">{$month}</span> {$_action_}</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Kpi/pdca')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                	<div class="kjss">
                                    	<form action="" method="get" id="searchform">
                                        <input type="hidden" name="m" value="Main">
                                        <input type="hidden" name="c" value="Kpi">
                                        <input type="hidden" name="a" value="pdca">
                                        <input type="hidden" name="bkpr" id="bkpr" value="">
                                        <input type="hidden" name="kpr" id="kpr" value="">
                                    	<input type="text" name="month" class="form-control monthly" placeholder="月份" style="width:100px; margin-right:10px;" />
                                    	<input type="text" class="form-control keywords_bkpr" placeholder="被考评人"  style="width:180px; margin-right:10px;"/>
                                        <input type="text" class="form-control keywords_kpr" placeholder="考评人"  style="width:180px;"/>
                                        <button class="btn btn-info btn-sm" style="float:left;"><i class="fa fa-search"></i></button>
                                        </form>
                                    </div>
                                    <div class="box-tools pull-right">
                                    	 
                                         <if condition="rolemenu(array('Kpi/addpdca'))">
                                         <a href="javascript:;" onClick="add_pdca()" class="btn btn-sm btn-danger" ><i class="fa fa-plus"></i> 新建PDCA</a>
                                         </if>
                                         
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                
                                    <div class="btn-group" id="catfont" style="padding-bottom:5px;">
										<?php if($prveyear>2019){ ?>
                                        <a href="{:U('Kpi/pdca',array('year'=>$prveyear,'month'=>'01','show'=>$show))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>
                                        <?php } ?>
                                        <?php 
                                        for($i=1;$i<13;$i++){
                                            $par = array();
											$par['year']  = $year;
                                            $par['month'] = $year.str_pad($i,2,"0",STR_PAD_LEFT);
                                            $par['show']  = $show;
                                            if($month==$year.str_pad($i,2,"0",STR_PAD_LEFT)){
                                                echo '<a href="'.U('Kpi/pdca',$par).'" class="btn btn-info" style="padding:8px 18px;">'.$i.'月</a>';
                                            }else{
                                                echo '<a href="'.U('Kpi/pdca',$par).'" class="btn btn-default" style="padding:8px 18px;">'.$i.'月</a>';
                                            }
                                        }
                                        ?>
                                        <?php if($year<date('Y')){ ?>
                                        <a href="{:U('Kpi/pdca',array('year'=>$nextyear,'month'=>'01','show'=>$show))}" class="btn btn-default" style="padding:8px 18px;">下一年</a>
                                        <?php } ?>
                                    </div>
                            
                                    
                                    <div class="btn-group" id="catfont" style="float:right;">
                                        
                                        <a href="javascript:;" onClick="showme(this)" data="{$show}" class="btn <?php if($show==1){ echo 'btn-info';}else{ echo 'btn-default'; } ?>">我的PDCA</a>
                                        
                                    </div>
                                    <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                        <tr role="row" class="orders" >
                                            <th width="" class="sorting" data="month">月份</th>
                                            <!-- <th class="sorting" data="title">PDCA描述</th> -->
                                            <th width="" class="sorting" data="tab_user_id">被考评人</th>
                                            <th width="" class="sorting" data="tab_user_id">考评人</th>
                                            <th width="" class="sorting" data="total_score">考评得分</th>
                                            <th width="" class="sorting" data="status">状态</th>
                                            <if condition="rolemenu(array('Kpi/pdcainfo'))">
                                            <th width="50" class="taskOptions">项目</th>
                                            </if>
                                            <if condition="rolemenu(array('Kpi/editpdca'))">
                                            <th width="50" class="taskOptions">编辑</th>
                                            </if>
                                            <if condition="rolemenu(array('Kpi/delpdca'))">
                                            <th width="50" class="taskOptions">删除</th>
                                            </if>
    
                                        </tr>
                                        <foreach name="lists" item="row"> 
                                        <tr>
                                            <td><a href="{:U('Kpi/pdcainfo',array('id'=>$row['id']))}" >{$row.month}</a></td>
                                            <!-- <td><a href="{:U('Kpi/pdcainfo',array('id'=>$row['id']))}" >{$row.title}</a></td> -->
                                            <td><a href="{:U('Kpi/pdca',array('bkpr'=>$row['tab_user_id']))}">{:username($row['tab_user_id'])}</a></td>
                                            <td>{$row.kaoping}</td>
                                            <td>{$row.total_score_show}</td>
                                            <td>{$pdcasta.$row[status]}</td>
                                            <if condition="rolemenu(array('Kpi/pdcainfo'))">
                                            <td class="taskOptions">
                                            <a href="{:U('Kpi/pdcainfo',array('id'=>$row['id']))}" title="项目" class="btn btn-success btn-smsm"><i class="fa fa-ellipsis-h"></i></a>
                                            </td>
                                            </if>
                                            <if condition="rolemenu(array('Kpi/editpdca'))">
                                            <td class="taskOptions">
                                            <?php 
                                            if(cookie('userid')==$row['tab_user_id'] || cookie('userid')==$pdca['eva_user_id'] || C('RBAC_SUPER_ADMIN')==cookie('username') || cookie('roleid')==10) {
                                            ?>
                                            <a href="javascript:;" onClick="add_pdca({$row.id})" title="修改" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
                                            <?php 
                                            }
                                            ?>
                                            </td>
                                            </if>
                                            <if condition="rolemenu(array('Kpi/delpdca'))">
                                            <td class="taskOptions">
                                            <?php 
                                            if(cookie('userid')==$row['tab_user_id'] || cookie('userid')==$pdca['eva_user_id'] || C('RBAC_SUPER_ADMIN')==cookie('username') || cookie('roleid')==10) {
                                            ?>
                                            <button onClick="javascript:ConfirmDel('{:U('Kpi/delpdca',array('id'=>$row['id']))}')" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button>
                                            <?php 
                                            }
                                            ?>
                                            </td>
                                            </if>
                                           
                                        </tr>
                                        </foreach>					
                                    </table>
                                </div><!-- /.box-body -->
                                <div class="box-footer clearfix">
                                	<div class="pagestyle">{$pages}</div>
                                </div>
                            </div><!-- /.box -->

                        </div><!-- /.col -->
                     </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
            
            
            
            
           

	<include file="Index:footer2" />


	<script>
    //新建PDCA
	function add_pdca(id) {
		art.dialog.open('index.php?m=Main&c=Kpi&a=addpdca&id='+id,{
			lock:true,
			title: '新建PDCA',
			width:800,
			height:400,
			okValue: '提交',
			fixed: true,
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
		var keywords = <?php echo $userkey; ?>;
		
		$(".keywords_bkpr").autocomplete(keywords, {
			 matchContains: true,
			 highlightItem: false,
			 formatItem: function(row, i, max, term) {
				 return '<span style=" display:none">'+row.pinyin+'</span>'+row.text;
			 },
			 formatResult: function(row) {
				 return row.user_name;
			 }
		}).result(function(event, item) {
		   $('#bkpr').val(item.id);
		});
		
		
		$(".keywords_kpr").autocomplete(keywords, {
			 matchContains: true,
			 highlightItem: false,
			 formatItem: function(row, i, max, term) {
				 return '<span style=" display:none">'+row.pinyin+'</span>'+row.text;
			 },
			 formatResult: function(row) {
				 return row.user_name;
			 }
		}).result(function(event, item) {
		   $('#kpr').val(item.id);
		});
			
	})
	
	
	
	function showme(obj){
		var data = $(obj).attr('data');
		if(data==0){
			$(obj).attr('data','1').removeClass('btn-default').addClass('btn-info');
			window.location.href="{:U('Kpi/pdca',array('month'=>$month,'show'=>1))}";
		}else{
			$(obj).attr('data','0').removeClass('btn-info').addClass('btn-default');
			window.location.href="{:U('Kpi/pdca',array('month'=>$month,'show'=>0))}";
		}
	}
	</script>
