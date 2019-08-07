<include file="Index:header" />

        <div class="wrapper row-offcanvas row-offcanvas-left">
            
			<include file="Index:menu" />
            
            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        科学国旅OA数据统计 
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-home"></i> 首页</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                    	
                        
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3>{$op_sum}</h3>
                                    <p>项目总量</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-document-text"></i>
                                </div>
                            </div>
                        </div><!-- ./col -->
                        
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3>&yen;{$purchase}</h3>
                                    <p>当月物资采购支出</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-ios7-cart"></i>
                                </div>
                            </div>
                        </div><!-- ./col -->
                        
                        
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                    <h3>&yen;{$budget}</h3>
                                    <p>当月已批预算</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-ios7-calculator"></i>
                                </div>
                            </div>
                        </div><!-- ./col -->
                        
                        
                        
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h3>&yen;{$settlement}</h3>
                                    <p>当月结算实收金额</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-card"></i>
                                </div>
                            </div>
                        </div><!-- ./col -->
                    </div><!-- /.row -->

                    <!-- Main row -->
                    <div class="row">
                    
                    	   
                        
                        <div class="col-md-12">                            
                             <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">项目数量统计</h3>
                                </div>
                                <div class="box-body no-padding">
                                    <div id="op_sum_chart" style="width:100%; height:380px;"></div>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="col-md-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">已结算项目收支统计</h3>
                                </div>
                                <div class="box-body no-padding">
                                    <div id="op_sz_chart" style="width:100%; height:380px;"></div>
                                </div>
                            </div>                            
                        </div>
                        
                        
                        
                        <div class="col-md-12">                            
                             <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">OA数据录入统计</h3>
                                </div>
                                <div class="box-body no-padding">
                                    <div id="oa_add_chart" style="width:100%; height:380px;"></div>
                                </div>
                            </div>
                        </div>
                        
                        <!--
                        <div class="col-md-6"> 
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">物资采购</h3>
                                </div>
                                <div class="box-body no-padding">
                                    <div id="container_5" style="width:100%; height:280px;"></div>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="col-md-6"> 
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">物资消耗</h3>
                                </div>
                                <div class="box-body no-padding">
                                	    <table class="table table-striped">
                                        <tbody id="active_gs"></tbody>
                                    </table>  
                                    
                                </div>
                            </div>
                        </div>
                        -->
                        
                        
                        
                        
                    </div><!-- /.row (main row) -->

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
        
         
        
		        
        <include file="Index:footer" />
        
        <script type="text/javascript">
		$(function() {
			var chart;
			$(document).ready(function() {
				op_sum_chart('op_sum_chart');
				op_sz_chart('op_sz_chart');
				oa_add_chart('oa_add_chart');
			});
		
		});
		
		//项目数量统计
		function op_sum_chart(chartbox){
			chart = new Highcharts.Chart({
				chart: {
					renderTo: chartbox,
					type: 'spline'
				},
				title: {
					text: '项目数量统计'
				},
				xAxis: {
					categories: [<?php echo $month; ?>]
				},
				yAxis: {
					min: 0,
					title: {
						text: '数量'
					}
				},credits: {
					enabled: false
				},
				tooltip: {
					formatter: function() {
						return ''+
							this.x +': '+ this.y +' 个';
					}
				},
				plotOptions: {
					column: {
						pointPadding: 0.2,
						borderWidth: 0
					}
				},
					series: [{
					name: '新建项目数',
					data: [<?php echo $pro_new_sum; ?>]
		
				}, {
					name: '成团项目数',
					data: [<?php echo $pro_trip_sum; ?>]
		
				}, {
					name: '完成项目数',
					data: [<?php echo $pro_settlement_sum; ?>]
		
				}]
			});
		}
		
		//项目收支统计
		function op_sz_chart(chartbox){
			chart = new Highcharts.Chart({ 
				chart: {
					renderTo: chartbox,
					type: 'column'
				},
		
				title: {
					text: '项目收支统计'
				},
		
				xAxis: {
					categories: [<?php echo $month; ?>]
				},
		
				yAxis: {
					allowDecimals: false,
					min: 0,
					title: {
						text: '金额（元）'
					}
				},
		
				tooltip: {
					formatter: function() {
						return '<b>'+ this.x +'</b><br/>'+
							this.series.name +': '+ this.y +'元<br/>'+
							'总计: '+ this.point.stackTotal + '元';
					}
				},
		
				plotOptions: {
					column: {
						stacking: 'normal'
					}
				},credits: {
					enabled: false
				},
		
				series: [{
					name: '收入',
					data: [<?php echo $pro_income; ?>],
					stack: 'shouru'
				},{
					name: '利润',
					data: [<?php echo $pro_profit; ?>],
					stack: 'lirun'
				}, {
					name: '物资支出',
					data: [<?php echo $pro_exp_material; ?>],
					stack: 'zhichu'
				}, {
					name: '专家辅导员支出',
					data: [<?php echo $pro_exp_guide; ?>],
					stack: 'zhichu'
				}, {
					name: '合格供方支出',
					data: [<?php echo $pro_exp_supplier; ?>],
					stack: 'zhichu'
				}]
			});	
		}
		
		//OA数据录入统计
		function oa_add_chart(chartbox){
			chart = new Highcharts.Chart({
				chart: {
					renderTo: chartbox,
					type: 'spline'
				},
				title: {
					text: 'OA数据录入统计'
				},
				xAxis: {
					categories: [<?php echo $month; ?>]
				},
				yAxis: {
					min: 0,
					title: {
						text: '数量'
					}
				},credits: {
					enabled: false
				},
				tooltip: {
					formatter: function() {
						return ''+
							this.x +': '+ this.y +' 条';
					}
				},
				plotOptions: {
					column: {
						pointPadding: 0.2,
						borderWidth: 0
					}
				},series: [{
					name: '新增产品模块',
					data: [<?php echo $add_pro_sum; ?>]
		
				}, {
					name: '新增行程方案',
					data: [<?php echo $add_line_sum; ?>],
					visible: false
		
				}, {
					name: '新增产品模板',
					data: [<?php echo $add_model_sum; ?>],
					visible: false
		
				}, {
					name: '新增合格供方',
					data: [<?php echo $add_supplier_sum; ?>],
					visible: false
		
				}, {
					name: '新增专家辅导员',
					data: [<?php echo $add_guide_sum; ?>],
					visible: false
		
				}, {
					name: '新增政企客户',
					data: [<?php echo $add_customer_gec_sum; ?>],
					visible: false
		
				}, {
					name: '新增参团客户',
					data: [<?php echo $add_customer_member_sum; ?>],
					visible: false
		
				}]
			});
		}
        </script>
