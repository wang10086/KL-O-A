		<include file="Index:header" />
        
        <div class="wrapper row-offcanvas row-offcanvas-left">
           
            <include file="Index:menu" />

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>分配KPI考核指标</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Rbac/post')}">岗位管理</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                   

                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                         <div class="col-md-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title"><strong style="color:#ff3300;">{$postname}</strong> 考核指标</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                	<form name="myform" id="myform" action="{:U('Rbac/rolequto')}" method="post" >
                                	<input  type="hidden" name="postid" value="{$postid}" />
                                	<input type="hidden" name="dosubmit" value="1" />
                                    <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
                                    <table class="table table-bordered dataTable fontmini">
                                    	<tr role="row">
											<th style="text-align:center;" width="60">选择</th>
                                            <th width="40">ID</th>
                                            <th>指标名称</th>
                                            <th>指标内容</th>
										</tr>
                                        <foreach name="datalist" item="row">
                                    	<tr>
                                        	<td style="text-align:center;" >
                                            	<input type="checkbox" name="quto[]"  value="{$row.id}"  <?php if(in_array($row['id'], $sel)){ echo 'checked';} ?>  />
                                            </td>
                                        	<td>{$row.id}</td>
                                            <td>{$row.quota_title}</td>
                                            <td>{$row.quota_content}</td>
                                           
                                        </tr>
                                        
                                        </foreach>		
                                        
                                    </table>
                                    </form>
                                </div><!-- /.box-body -->
                                <div class="box-footer clearfix">
                                	<button onclick="javascript:$('#myform').submit();" class="btn btn-success">保存</button>
                                </div>
                            </div><!-- /.box -->

                            
                        </div><!-- right col -->
                    </div><!-- /.row (main row) -->

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!-- add new calendar event modal -->


        <include file="Index:footer" />
        
        <script type="text/javascript">

		$(document).ready(function(e) {
			
			$('input[level=1]').click(function(e){
				var cks = $(this).parents('.block').find('input');
				var ischecked = $(this).is(":checked");
				cks.each(function(index, element) {
					element.checked = ischecked;
				});
			});
		
			$('input[level=2]').click(function(e){
				var cks = $(this).parents('dl').find('input');
				var ischecked = $(this).is(":checked");
				cks.each(function(index, element) {
					element.checked = ischecked;
				});
				if (ischecked) {
					var uplevel = $(this).parents('.block').find('input[level=1]');
					uplevel.each(function(index, element) {
						element.checked = ischecked;
					});
				} 
			});
			
			$('input[level=3]').click(function(e){
				var ischecked = $(this).is(":checked");
				if (ischecked) {
					var uplevel = $(this).parents('.block').find('input[level=1]');
					uplevel.each(function(index, element) {
						element.checked = ischecked;
					});
					uplevel = $(this).parents('dl').find('input[level=2]');
					uplevel.each(function(index, element) {
						element.checked = ischecked;
					});
				}
			});
		
		});
		
		
		function ontags(obj){
			$('.'+obj).toggle();
		}
		
		</script>