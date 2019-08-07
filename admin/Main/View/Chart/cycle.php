<include file="Index:header" />

        <div class="wrapper row-offcanvas row-offcanvas-left">
            
			<include file="Index:menu" />
            
            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{$year}年度项目平均结算周期</h1>
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
                    	   
                        <include file="Chart:op_cycle" />
                        
                        
                        
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