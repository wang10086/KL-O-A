		<include file="Index:header" />
        
        <div class="wrapper row-offcanvas row-offcanvas-left">
           
            <include file="Index:menu" />

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>分配权限</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('User/role')}">角色管理</a></li>
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
                                    <h3 class="box-title">权限列表</h3>
                                    <div class="pull-right box-tools" style="color:#ff3300; font-size:16px;">
                                         <strong>当前选择角色：{$rolename}</strong>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                	<form name="myform" id="myform" action="{:U('Rbac/priv')}" method="post" >
                                	<input  type="hidden" name="roleid" value="{$roleid}" />
                                	<input type="hidden" name="dosubmit" value="1" />
                                    <foreach name="nodes" item="app">
                                    <table class="table table-bordered dataTable fontmini">
                                    	<tr role="row">
											<th style="text-align:center;" width="40"><input type="checkbox" name="access[]" level="1" value="{$app.id}_1" <?php if($app['access']){ echo 'checked';} ?> /></th>
                                            <th width="40">ID</th>
                                            <th width="">节点名称</th>
                                            <th width="80">类型</th>
                                            <th width="80">状态</th>
										</tr>
                                        <foreach name="app.child" item="action">
                                    	<tr bgcolor="#3c8dbc">
                                        	<td style="text-align:center;" >
                                            	<input type="checkbox" name="access[]" level="2" value="{$action.id}_2"  <?php if($action['access']){ echo 'checked';} ?>  />
                                            </td>
                                        	<td style="color:#ffffff;">{$action.id}</td>
                                            <td style="color:#ffffff;" onClick="ontags('box_{$action.id}');">{$action.title}</td>
                                            <td style="color:#ffffff;">控制器</td>
                                            <td style="color:#ffffff;"><?php echo statustr($action['status']); ?></td>
                                           
                                        </tr>
                                        <foreach name="action.child" item="method">
                                        <tr class="box_{$action.id}">
                                        	<td style="text-align:center;" ><input type="checkbox" name="access[]" level="3" value="{$method.id}_3" <?php if($method['access']){ echo 'checked';} ?>  /></td>
                                        	<td>{$method.id}</td>
                                            <td>{$method.title}</td>
                                            <td>方法</td>
                                            <td><?php echo statustr($method['status']); ?></td>
                                            
                                        </tr>	
                                        </foreach>
                                        </foreach>		
                                        
                                    </table>
                                    </foreach>
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