<include file="Index:header" />

        <div class="wrapper row-offcanvas row-offcanvas-left">
            
			<include file="Index:menu" />
            
            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{$year}年度项目提成统计</h1>
                    <ol class="breadcrumb">
                        <li><i class="fa fa-home"></i> 首页</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <!-- Main row -->
                    <div class="row">
                    	
                        <script type="text/javascript">
                        $(function() {
							var chart;
						});
                        </script>
                    	   
                        <div class="col-md-12">                            
                             <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">{$year}年项目计调提成统计</h3>
                                </div>
                                <div class="box-body no-padding">
                                    <div id="op_jd_chart" style="width:100%; height:380px;"></div>
                                </div>
                            </div>
                        </div>
                        
                        
                        
                        <div class="col-md-12">                            
                             <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">{$year}年项目研发提成统计</h3>
                                </div>
                                <div class="box-body no-padding">
                                    <div id="op_yf_chart" style="width:100%; height:380px;"></div>
                                </div>
                            </div>
                        </div>
                                
                        <script type="text/javascript">
                       
                        //项目计调提成统计
                        function chart_line_jd(id){
                            window.chart_line = new Highcharts.Chart({
                                chart: {
                                    renderTo: 'op_jd_chart'
                                },
                                title: {
                                    text: '<?php echo $year; ?>年项目计调提成统计'
                                },
                                xAxis: {
                                    categories: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月']
                                },
                                yAxis: {
                                    min: 0,
                                    title: {
                                        text: '金额'
                                    }
                                },
                                tooltip: {
                                    formatter: function() {
                                        return ''+
                                            this.x +': '+ this.y+'元';
                                    }
                                },
                                plotOptions: {
                                    column: {
                                        pointPadding: 0.2,
                                        borderWidth: 0
                                    }
                                },credits: {
                                    enabled: false
                                },
                                series: <?php echo $jidiao_data; ?>
                            })
                        }
                        
						//项目研发提成统计
                        function chart_line_yf(id){
                            window.chart_line = new Highcharts.Chart({
                                chart: {
                                    renderTo: 'op_yf_chart'
                                },
                                title: {
                                    text: '<?php echo $year; ?>年项目研发提成统计'
                                },
                                xAxis: {
                                    categories: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月']
                                },
                                yAxis: {
                                    min: 0,
                                    title: {
                                        text: '金额'
                                    }
                                },
                                tooltip: {
                                    formatter: function() {
                                        return ''+
                                            this.x +': '+ this.y+'元';
                                    }
                                },
                                plotOptions: {
                                    column: {
                                        pointPadding: 0.2,
                                        borderWidth: 0
                                    }
                                },credits: {
                                    enabled: false
                                },
                                series: <?php echo $yanfa_data; ?>
                            })
                        }
                        
                        
						
                        $(document).ready(function(e) {
                            chart_line_jd();
							chart_line_yf();
                            //onsum(1);
                        });
                        </script>

                        
                        
                        
                    </div><!-- /.row (main row) -->

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
        
         
        
		        
        <include file="Index:footer" />
        
        <script type="text/javascript">
        $(document).ready(function(e) {
            $('.chart_tab').find('a').each(function(index, element) {
				$(this).click(function(){
					$(this).parent().find('a').removeClass('btn-info');
					$(this).addClass('btn-info');
					
				})
            });
        });
        </script>