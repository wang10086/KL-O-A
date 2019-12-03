		<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{$year}年度KPI任务 【{$user.nickname}】</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Kpi/kpi')}"><i class="fa fa-gift"></i> KPI</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
               
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                            <!--月度考核-->
                            <div class="btn-group cycle_nav month" id="catfont" style="padding-bottom:20px;">
                                <?php if ($prveyear > 2017){ ?>
                            	<a href="{:U('Rbac/kpi_data',array('year'=>$prveyear,'uid'=>$uid))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>
                                <?php } ?>
								<?php
                                for($i=1;$i<13;$i++){
                                    $par = array();
                                    $par['year']  = $year;
                                    $par['month'] = $i;
									$par['uid']   = $uid;
                                    if($month==$i){
                                        echo '<a href="'.U('Rbac/kpi_data',$par).'" class="btn btn-info" style="padding:8px 18px;">'.$i.'月</a>';
                                    }else{
                                        echo '<a href="'.U('Rbac/kpi_data',$par).'" class="btn btn-default" style="padding:8px 18px;">'.$i.'月</a>';
                                    }
                                }
                                ?>
                                <?php /*if ($prveyear < date('Y')-1){ */?>
                                <?php if ($prveyear < date('Y')){ ?>
                                <a href="{:U('Rbac/kpi_data',array('year'=>$nextyear,'uid'=>$uid))}" class="btn btn-default" style="padding:8px 18px;">下一年</a>
                                <?php } ?>
                            </div>

                            <!--季度考核-->
                            <div class="btn-group cycle_nav quarter" id="catfont" style="padding-bottom:20px;">
                                <?php if ($prveyear > 2017){ ?>
                                <a href="{:U('Rbac/kpi_data',array('year'=>$prveyear,'uid'=>$uid))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>
                                <?php } ?>
                                <?php
                                    for($i=1;$i<5;$i++){
                                        $par = array();
                                        $par['year']  = $year;
                                        $par['quarter'] = $i;
                                        $par['uid']   = $uid;
                                        if($quarter==$i){
                                            echo '<a href="'.U('Rbac/kpi_data',$par).'" class="btn btn-info" style="padding:8px 18px;">'.$i.'季度</a>';
                                        }else{
                                            echo '<a href="'.U('Rbac/kpi_data',$par).'" class="btn btn-default" style="padding:8px 18px;">'.$i.'季度</a>';
                                        }
                                    }
                                ?>
                               <!-- --><?php /*if ($prveyear < date('Y')-1){ */?>
                                <?php if ($prveyear < date('Y')){ ?>
                                    <a href="{:U('Rbac/kpi_data',array('year'=>$nextyear,'uid'=>$uid))}" class="btn btn-default" style="padding:8px 18px;">下一年</a>
                                <?php } ?>
                            </div>

                            <!--半年度考核-->
                            <div class="btn-group cycle_nav half-year" id="catfont" style="padding-bottom:20px;">
                                <?php if ($prveyear > 2017){ ?>
                                    <a href="{:U('Rbac/kpi_data',array('year'=>$prveyear,'uid'=>$uid))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>
                                <?php } ?>
                                <?php
                                    if($half_year==1){
                                        echo '<a href="'.U('Rbac/kpi_data',array('year'=>$year,'half_year'=>1,'uid'=>$uid)).'" class="btn btn-info" style="padding:8px 18px;">上半年</a>'.'<a href="'.U('Rbac/kpi_data',array('year'=>$year,'half_year'=>2,'uid'=>$uid)).'" class="btn btn-default" style="padding:8px 18px;">下半年</a>';
                                    }else{
                                        echo '<a href="'.U('Rbac/kpi_data',array('year'=>$year,'half_year'=>1,'uid'=>$uid)).'" class="btn btn-default" style="padding:8px 18px;">上半年</a>'.'<a href="'.U('Rbac/kpi_data',array('year'=>$year,'half_year'=>2,'uid'=>$uid)).'" class="btn btn-info" style="padding:8px 18px;">下半年</a>';
                                    }
                                ?>
                               <!-- --><?php /*if ($prveyear < date('Y')-1){ */?>
                                <?php if ($prveyear < date('Y')){ ?>
                                    <a href="{:U('Rbac/kpi_data',array('year'=>$nextyear,'uid'=>$uid))}" class="btn btn-default" style="padding:8px 18px;">下一年</a>
                                <?php } ?>
                            </div>

                            <!--年度考核-->
                            <div class="btn-group cycle_nav year" id="catfont" style="padding-bottom:20px;">
                                <?php
                                    for($i=2018;$i<=date('Y');$i++){
                                        $par = array();
                                        $par['year']  = $year;
                                        $par['month'] = $i;
                                        $par['uid']   = $uid;
                                        if($year==$i){
                                            echo '<a href="'.U('Rbac/kpi_data',$par).'" class="btn btn-info" style="padding:8px 18px;">'.$i.'年</a>';
                                        }else{
                                            echo '<a href="'.U('Rbac/kpi_data',$par).'" class="btn btn-default" style="padding:8px 18px;">'.$i.'年</a>';
                                        }
                                    }
                                ?>
                            </div>
                                    
                            
                            <form method="post" action="{:U('Rbac/save_kpi_data')}" name="myform" id="myform" onsubmit="return submitBefore()">
                            <input type="hidden" name="dosubmint" value="1">
                            <input type="hidden" name="kpi_id" value="{$kpi.id}">
                            <input type="hidden" name="account_id" value="{$user.id}">
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">考核指标</h3>
                                    <div class="box-tools pull-right">
                                    	
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                    	<span class="rtxt" style="margin-top:-10px;">
                                        {$year}年{$month}月 &nbsp;&nbsp;&nbsp;&nbsp;
                                        被考核人：{$user.nickname} &nbsp;&nbsp;&nbsp;&nbsp;
                                        所属岗位：{$user.postname}
                                        </span> 
                                        
                                        <!--<a href="{:u('Kpi/addkpi',array('year'=>$year,'uid'=>$uid))}" class="btn btn-danger btn-sm" style="float:right;"><i class="fa fa-fw  fa-refresh"></i> 获取全年指标</a>-->
                                        <a href="javascript:;" onclick="getFullYearKpi()" class="btn btn-danger btn-sm" style="float:right;"><i class="fa fa-fw  fa-refresh"></i> 获取全年指标</a>

                                       <!-- <a href="{:u('Kpi/addkpi',array('year'=>$year,'month'=>$month,'uid'=>$uid))}" class="btn btn-success btn-sm" style="float:right; margin-right:10px;"><i class="fa fa-fw  fa-refresh"></i> 获取本月指标</a>-->
                                        <style>
                                            .set-kpi-select{display: inline-block; width: 13rem; float: right}
                                            .btn-group{margin-top: 0px;}
                                        </style>
                                        <?php /*if ($year == date('Y')){ */?>
                                            <div class="form-group set-kpi-select">
                                                <div class=" col-md-12">
                                                    <select class="form-control" name="cycle" id="cycle" onchange="change_view($(this).val())">
                                                        <option value="">==考核周期==</option>
                                                        <foreach name="kpi_cycle" key="k" item="v">
                                                            <option value="{$k}" <?php if ($cycle == $k){echo 'selected'; } ?>>{$v}</option>
                                                        </foreach>
                                                    </select>
                                                </div>
                                            </div>
                                        <?php /*} */?>

                                        <div class="box-body table-responsive no-padding">
                                        <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                            <tr role="row" class="orders" >
                                                <th width="50">序号</th>
                                                <th style="min-width: 10rem;">指标名称</th>
                                                <th width="140">考核开始</th>
                                                <th width="140">考核结束</th>
                                                <th width="100">计划</th>
                                                <th width="100">目标</th>
                                                <th width="100">权重</th>
                                                <th width="50" class="taskOptions">删除</th>
                                            </tr>
                                            <foreach name="lists" key="key" item="row"> 
                                            <tr>
                                                <td style="line-height:34px;" align="center"><?php echo $key+1; ?></td>
                                                <td style="line-height:34px;"><a href="javascript:;" onClick="kpi({$row.quota_id})">{$row.quota_title}</a></td>
                                                <td><input type="text" class="form-control start_date" name="info[{$row.id}][start_date]" value="{$row.start_date|date='Y-m-d',###}"></td>
                                                <td><input type="text" class="form-control end_date" name="info[{$row.id}][end_date]" value="{$row.end_date|date='Y-m-d',###}"></td>
                                                <td><input type="text" class="form-control" name="info[{$row.id}][plan]" value="<?php echo $row['plan']?$row['plan']:100; ?>"></td>
                                                <td><input type="text" class="form-control" name="info[{$row.id}][target]" value="{$row.target}"></td>
                                                <td><input type="text" class="form-control" name="info[{$row.id}][weight]" value="{$row.weight}"></td>
                                                <td   style="line-height:34px;" class="taskOptions">
                                                <a href="javascript:;" onClick="javascript:ConfirmDel('{:U('Rbac/del_kpi_data',array('id'=>$row['id']))}','您真的要删除此项KPI考核？')" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></a>
                                                </td>
                                                
                                            </tr>
                                            </foreach>
                                        </table>
                                        </div>
                                        <div class="form-group">&nbsp;</div>
                                    </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div><!--/.col (right) -->

                        <div class="col-md-12">
                            <div class="box box-warning">
                                <div class="box-body">
                                	
                                    <if condition="rolemenu(array('Rbac/save_kpi_data'))">
									<div class="form-group col-md-12" style="text-align:center; margin-top:20px;">
									<button type="submit" class="btn btn-info btn-lg" id="lrpd">保存数据</button>
									</div>
                                	</if>
                                    
                        
                           
                                    <div class="form-group col-md-12" id="apptab" style="margin-top:40px;">
                                        <div class="box-body no-padding">
                                            <table class="table">
                                                <tr>
                                                    <th width="150">配置时间</th>
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
                        </div>
                        </form>
                    </div>   <!-- /.row -->
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
  		</div>
	</div>

	<include file="Index:footer2" />
    
    <script>
        $(function () {
            var cycle = <?php echo $kpi['cycle']?$kpi['cycle']:1; ?>;
            $('.cycle_nav').hide();
            if (cycle ==1){ $('.month').show(); }
            if (cycle ==2){ $('.quarter').show(); }
            if (cycle ==3){ $('.half-year').show(); }
            if (cycle ==4){ $('.year').show(); }
        })

    //编辑KPI指标
	function edit_kpi(id) {
		var kpiid = '{$kpi.id}';
		art.dialog.open('index.php?m=Main&c=Kpi&a=editkpi&kpiid='+kpiid+'&id='+id,{
			lock:true,
			title: '新建KPI指标',
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

	//选择KPI考核周期
	function change_view(cycle) {
        var month   = "<?php echo $month?$month:date('m'); ?>";
        var year    = "<?php echo $year?$year:date('Y'); ?>";
        var cycle   = cycle?cycle:{$cycle};
        if (cycle==1){  //月度
            $('.cycle_nav').hide();
            $('.month').show();
        }else if(cycle==2){ //季度
            $('.cycle_nav').hide();
            $('.quarter').show();
        }else if(cycle==3){ //半年度
            $('.cycle_nav').hide();
            $('.half-year').show();
        }else if(cycle==4){ //年度
            $('.cycle_nav').hide();
            $('.year').show();
        }

        $.ajax({
            type : 'POST',
            url : "{:U('Ajax/get_kpi_info')}",
            dataType:'json',
            data:{cycle:cycle,year:year,month:month},
            success:function (data) {
                $('.start_date').val(data.beginTime);
                $('.end_date').val(data.endTime);
            }
        })
    }

    function submitBefore() {
        var cycle = $('#cycle').val();
        if (!cycle){
            art_show_msg('请选择考核周期');
            return false;
        }else {
            $('#myform').submit();
        }
    }

    function getFullYearKpi() {
        var cycle   = $('#cycle').val();
        var year    = {$year};
        var uid     = {$uid};
        var month   = {$month};
        if (!cycle){
            art_show_msg('请选择考核周期');
            return false;
        }else{
            var url = '/index.php?m=Main&c=Kpi&a=addkpi&year='+year+'&month='+month+'&uid='+uid+'&cycle='+cycle;
            window.location.href = url;
        }
    }
	</script>