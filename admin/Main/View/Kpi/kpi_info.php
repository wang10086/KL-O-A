		<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{$year}年度KPI - {$user.nickname} </h1>
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
                            	<?php if($prveyear>2019){ ?>
                                <a href="{:U('Kpi/kpiinfo',array('year'=>$prveyear,'uid'=>$uid))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>
								<?php } ?>
								<?php 
                                for($i=1;$i<13;$i++){
                                    if (strlen($i)<2){ $i = str_pad($i,2,'0',STR_PAD_LEFT);}
                                    $par = array();
                                    $par['year']  = $year;
                                    $par['month'] = $i;
									$par['uid']   = $uid;
                                    if($month==$i){
                                        echo '<a href="'.U('Kpi/kpiinfo',$par).'" class="btn btn-info" style="padding:8px 18px;">'.$i.'月</a>';
                                    }else{
                                        echo '<a href="'.U('Kpi/kpiinfo',$par).'" class="btn btn-default" style="padding:8px 18px;">'.$i.'月</a>';
                                    }
                                }
                                ?>
                                <?php if($year<date('Y')){ ?>
                                <a href="{:U('Kpi/kpiinfo',array('year'=>$nextyear,'uid'=>$uid))}" class="btn btn-default" style="padding:8px 18px;">下一年</a>
                                <?php } ?>
                            </div>
                                    
                            
                            <?php if($kpi['id']){ ?>
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">考核指标</h3>
                                    <div class="box-tools pull-right">

                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                    	<span class="rtxt" style="margin-top:-10px;">
                                        月份：{$kpi.month} &nbsp;&nbsp;&nbsp;&nbsp;
                                        被考评人：{:username($kpi['user_id'])} &nbsp;&nbsp;&nbsp;&nbsp;
                                        <!--
                                        考评人：{$kpi.kaoping} &nbsp;&nbsp;&nbsp;&nbsp;
                                        -->
                                        考评得分：{$kpi.score} &nbsp;&nbsp;&nbsp;&nbsp;
                                        <!--
                                        状态：{$kpi.status_str}
                                        -->
                                        </span> 
                                        
                                        <a href="{:u('Ajax/updatekpi',array('month'=>$allmonth,'uid'=>$uid))}" class="btn btn-success btn-sm" style="float:right;"><i class="fa fa-fw  fa-refresh"></i> 更新数据</a>  
                                        
                                        
                                        <div class="box-body table-responsive no-padding">
                                        <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                            <tr role="row" class="orders" >
                                                <th width="50">序号</th>
                                                <th style="min-width: 10rem;">指标名称</th>
                                                <th width="180">周期</th>
                                                <th width="100">目标</th>
                                                <th width="100">完成</th>
                                                <th width="100">完成率</th>
                                                <th width="100">权重</th>
                                                
                                                <th width="100">考评得分</th>
                                                <th width="60">锁定</th>
                                                <?php 
												if(cookie('roleid')==43 || cookie('roleid')==44 || cookie('userid')==$kpi['mk_user_id'] || cookie('roleid')==10 || C('RBAC_SUPER_ADMIN')==cookie('username') ){
												?>
                                                
                                                <if condition="rolemenu(array('Kpi/editkpi'))">
                                                <th width="50" class="taskOptions">编辑</th>
                                                </if>
                                                <?php }?>
                                            </tr>
                                            <foreach name="lists" key="key" item="row">
                                            <tr>
                                                <td align="center"><?php echo $key+1; ?></td><!--227=>王丹(城市合伙人-满意度),180=>(李徵红)院内资源满意度;185=>(赵冬)日常服务工作满意度-老科学家演讲团教务专员-->
                                                <td><a href="javascript:;" onClick="kpi({$row.quota_id})">{$row.quota_title}</a> <?php if (in_array($row['quota_id'],array(227,180,185))){ echo "<i class='fa  fa-qrcode' title='获取满意度二维码' style='color:#3CF; margin-left:8px; cursor:pointer;' onClick='get_qrcode(`/index.php?m=Main&c=Kpi&a=public_qrcode&uid=$row[user_id]&tit=$row[quota_title]&kpi_quota_id=$row[quota_id]`)'></i>"; } ?> </td>
                                                <td>{$row.start_date|date='Y-m-d',###} 至 {$row.end_date|date='Y-m-d',###}</td>
                                                <td>{$row.target}</td>
                                                <td>
                                                    <?php if ($row['url']){ ?>
                                                        <a href="{$row['url']}" target="_blank">{$row.complete}</a>
                                                    <?php }else{ ?>
                                                        {$row.complete}
                                                    <?php } ?>
                                                </td>
                                                <td>{$row.complete_rate}</td>
                                                <td>{$row.weight}</td>
                                                <td>{$row.score}</td>
												<td><?php if($row['automatic']){ echo '<i class="fa fa-lock" style="color:#ff6600;font-size:14px;"></i>';} ?></td>
                                                
                                                
                                                <?php 
												
												if(cookie('roleid')==43 || cookie('roleid')==44 || cookie('userid')==$kpi['mk_user_id'] || cookie('roleid')==10 || C('RBAC_SUPER_ADMIN')==cookie('username') ){
												?>
                                                <if condition="rolemenu(array('Kpi/editkpi'))">
                                                <td class="taskOptions">
                                                <a href="javascript:;" onClick="edit_kpi({$row.id})" title="编辑" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
                                                </td>
                                                </if>
                                                
                                                <?php }?>
                                            </tr>
                                            </foreach>					
                                        </table> 

                                        </div>
                                        <div class="form-group">&nbsp;</div>
                                    </div>
                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            <?php } ?>

                            <?php if ($encourage_type == 1){ ?>
                                <include file="kpi_encourage_yw" />
                            <?php }elseif ($encourage_type == 2){ ?>
                                <include file="kpi_encourage_jd" />
                            <?php }elseif ($encourage_type == 3){ ?>
                                <include file="kpi_encourage_3" />
                            <?php } ?>

                            <div class="box box-warning">
                                <div class="box-body">
                                    <?php
                                    if(!$kpi['id']){
                                        ?>
                                        <p style="text-align:center; width:100%; font-size:18px; padding:40px 0;">暂未制定KPI指标</p>
                                        <?php
                                    }
                                    ?>
                                    <!--
                                    <if condition="rolemenu(array('Kpi/addkpi'))">

									<form method="post" action="{:U('Kpi/addkpi')}" name="myform" id="myform">
									<input type="hidden" name="dosubmint" value="1">
									<input type="hidden" name="year" value="{$year}">
                                    <input type="hidden" name="uid" value="{$uid}">
									<div class="form-group col-md-12" style="text-align:center; margin-top:20px;">
									<button type="submit" class="btn btn-info btn-lg" id="lrpd">获取KPI数据</button>
									</div>
									</form>

                                	</if>
                                    -->

                                    <?php
                                    if($kpi['status']==0 && cookie('userid')==$kpi['user_id']){
                                        ?>
                                        <!--
                                        <form method="post" action="{:U('Kpi/kpi_applyscore')}" name="myform" id="myform">
                                        <input type="hidden" name="dosubmint" value="1">
                                        <input type="hidden" name="kpiid" value="{$kpi.id}">
                                        <input type="hidden" name="status" value="1">
                                        <div class="form-group col-md-12" style="text-align:center; margin-top:20px;">
                                        <button type="submit" class="btn btn-info btn-lg" id="lrpd">申请审核</button>
                                        </div>
                                        </form>
                                        -->
                                        <?php
                                    }
                                    ?>



                                    <?php
                                    if($kpi['status']==1 && cookie('userid')==$kpi['ex_user_id'] ){
                                        ?>
                                        <!--
                                        <form method="post" action="{:U('Kpi/kpi_applyscore')}" name="myform" id="myform">
                                        <input type="hidden" name="dosubmint" value="1" />
                                        <input type="hidden" name="kpiid" value="{$kpi.id}">
                                        <div class="form-group col-md-12" style=" margin-top:20px;">
                                            <div class="checkboxlist" id="applycheckbox">
                                            <input type="radio" name="status" value="2"> 通过 &nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="radio" name="status" value="3"> 不通过
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12 select_2 ">
                                            <textarea class="form-control"  placeholder="不通过原因" name="app_remark" ></textarea>
                                        </div>

                                        <div class="form-group col-md-12" style="text-align:center; margin-top:20px;">
                                        <button type="submit" class="btn btn-info btn-lg" id="lrpd">保存</button>
                                        </div>

                                        </form>
                                        -->
                                    <?php } ?>




                                    <?php
                                    if($kpi['status']==2 && cookie('userid')==$kpi['user_id']){
                                        ?>
                                        <!--
                                        <form method="post" action="{:U('Kpi/kpi_applyscore')}" name="myform" id="myform">
                                        <input type="hidden" name="dosubmint" value="1">
                                        <input type="hidden" name="kpiid" value="{$kpi.id}">
                                        <input type="hidden" name="status" value="4">
                                        <div class="form-group col-md-12" style="text-align:center; margin-top:20px;">
                                        <button type="submit" class="btn btn-info btn-lg" id="lrpd">申请评分</button>
                                        </div>
                                        </form>
                                        -->
                                        <?php
                                    }
                                    ?>


                                    <?php
                                    if($kpi['status']==4 && cookie('userid')==$kpi['mk_user_id']){
                                        ?>
                                        <!--
                                        <form method="post" action="{:U('Kpi/kpi_score')}" name="myform" id="myform">
                                        <input type="hidden" name="dosubmint" value="1">
                                        <input type="hidden" name="kpiid" value="{$kpi.id}">
                                        <div class="form-group col-md-12" style="text-align:center; margin-top:20px;">
                                        {$totalstr}
                                        </div>
                                        <div class="form-group col-md-12" style="text-align:center; margin-top:20px;">
                                        <button type="submit" class="btn btn-info btn-lg" id="lrpd">确定评分</button>
                                        </div>
                                        </form>
                                        -->
                                        <?php
                                    }
                                    ?>

                                    <!--
                                    <?php if($applist){ ?>
                                    <div class="form-group col-md-12" id="apptab" style="margin-top:40px;">
                                        <div class="box-body no-padding">
                                            <table class="table">
                                                <tr>
                                                    <th width="150">审核日期</th>
                                                    <th width="150">审核结果</th>
                                                    <th width="150">审核者</th>
                                                    <th>备注</th>
                                                </tr>
                                                <foreach name="applist" key="k" item="v">
                                                <tr>
                                                	<td><if condition="$v['apply_time']">{$v.apply_time|date='Y-m-d H:i',###}</if></td>
                                                    <td>{$v.status}</td>
                                                    <td>{$v.apply_user_nme}</td>
                                                    <td>{$v.remark}</td>
                                                </tr>
                                                </foreach>
                                            </table>
                                        </div>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                    -->

                                    <div class="form-group col-md-12" id="apptab" style="margin-top:40px;">
                                        <div class="box-body no-padding">
                                            <table class="table">
                                                <tr class="orders">
                                                    <th width="150">操作时间</th>
                                                    <th width="150">操作者</th>
                                                    <th>备注</th>
                                                </tr>
                                                <foreach name="applist" key="k" item="v">
                                                    <tr>
                                                        <td><if condition="$v['op_time']">{$v.op_time|date='Y-m-d H:i',###}</if></td>
                                                        <td>{$v.op_user_name}</td>
                                                        <td>{$v.remarks}</td>
                                                    </tr>
                                                </foreach>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="form-group">&nbsp;</div>
                                </div>
                            </div>
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                </section><!-- /.content -->
                
            </aside><!-- /.right-side -->
			
  		</div>
	</div>

	<include file="Index:footer2" />
    
    <script>
    //编辑KPI指标
	function edit_kpi(id) {
		var kpiid = '{$kpi.id}';
		art.dialog.open('index.php?m=Main&c=Kpi&a=editkpi&kpiid='+kpiid+'&id='+id,{
			lock:true,
			title: '完成指标',
			width:1000,
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
	
	//单项评分
	function unitscore(id) {
		art.dialog.open('index.php?m=Main&c=Kpi&a=kpi_unitscore&id='+id,{
			lock:true,
			title: 'KPI指标评分',
			width:700,
			height:300,
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
	
	
	 //查看KPI指标
	function kpi(id) {
		art.dialog.open('index.php?m=Main&c=Kpi&a=kpidetail&id='+id,{
			lock:true,
			title: 'KPI指标详情',
			width:800,
			height:400,
			fixed: true,
			
		});	
	}
    
	/*
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
	*/

    //获取评分二维码
    function get_qrcode(url) {
        art.dialog.open(url,{
            id:'qrcode',
            lock:true,
            title: '二维码',
            width:600,
            height:400,
            fixed: true,
        });
    }

	</script>