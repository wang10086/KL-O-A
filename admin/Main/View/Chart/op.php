<include file="Index:header" />

        <div class="wrapper row-offcanvas row-offcanvas-left">
            
			<include file="Index:menu" />
            
            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{$year}年度项目数据</h1>
                    <ol class="breadcrumb">
                        <li><i class="fa fa-home"></i> 首页</li>
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
                                    <h3>{$zong_op}</h3>
                                    <p>年度项目总量</p>
                                </div>
                                
                            </div>
                        </div><!-- ./col -->
                        
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h3>{$zong_js}</h3>
                                    <p>年度已结算项目数</p>
                                </div>
                                
                            </div>
                        </div><!-- ./col -->
                        
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3>&yen;{$zong_sr}</h3>
                                    <p>年度总收入(已结算)</p>
                                </div>
                                
                            </div>
                        </div><!-- ./col -->
                        
                        
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                    <h3>&yen;{$zong_ml}</h3>
                                    <p>年度总毛利(已结算)</p>
                                </div>
                                
                            </div>
                        </div><!-- ./col -->
                        
                        
                        
                        
                    </div><!-- /.row -->

                    <!-- Main row -->
                    <div class="row">
                    	
                        <script type="text/javascript">
                        $(function() {
							var chart;
						});
                        </script>
                    	   
                        <include file="Chart:op_sum" />
                        
                        <include file="Chart:op_income" />
                        
                        <include file="Chart:op_sr" />
                        
                        <include file="Chart:op_ml" />
                        
                        
                        
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