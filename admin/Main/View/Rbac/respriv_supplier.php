<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        {$_pagetitle_}
                        <small>{$_pagedesc_}</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Rbac/index')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

				<form action="{:U('Rbac/respriv_supplier')}" method="post" name="myform" id="myform">                
                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                    <div class="box-tools pull-right">
                                         
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                


                                <input type="hidden" name="dosubmit" value="1" />
                                <input type="hidden" name="res" value="{$res}" />
                                <input type="hidden" name="resid" value="{$resid}" />
                                
                                
                                                                
                                    <table class="table table-bordered dataTable fontmini"  style="margin: 5px;" id="tablelist">
                                        <tr role="row" >
                                            <th width="50%">部门/角色</th>
                                            <th><input type="checkbox"  id="vall"/> 可查看 </th>
<!--                                             <th><input type="checkbox"  id="dall"/> 可下载 </th> -->
                                            <th><input type="checkbox"  id="uall"/> 可使用 </th>
                                        </tr>
                                            
                                
                                        <foreach name="roles" item="row">
                                        
                                            <tr>
                                                <td><input type="hidden" name="roles[]" value="{$row.id}"/>{:tree_pad($row['level'])} {$row.role_name}  </td>
                                                <td><input type="checkbox" rel="v" name="info[{$row.id}][v]" value="1"  <?php if(isset($rights[$row['id']]) && $rights[$row['id']][v] == 1) echo 'checked'; ?> /></td>
                                               <!-- <td><input type="checkbox" rel="d" name="info[{$row.id}][d]" value="1"  <?php if(isset($rights[$row['id']]) && $rights[$row['id']][d] == 1) echo 'checked'; ?>/></td> --> 
                                                <td><input type="checkbox" rel="u" name="info[{$row.id}][u]" value="1"  <?php if(isset($rights[$row['id']]) && $rights[$row['id']][u] == 1) echo 'checked'; ?>/></td>
                                            </tr>
                                        </foreach>										
                                
                                    </table>
   

                                
                                </div><!-- /.box-body -->
                                
                            </div><!-- /.box -->
							<div id="formsbtn">
                            	<button type="submit" class="btn btn-info btn-lg" id="lrpd">保存</button>
                            </div>
                        </div><!-- /.col -->
                     </div>

                </section><!-- /.content -->
        
				</form>                
                
            </aside><!-- /.right-side -->

        <include file="Index:footer2" />
        
<script type="text/javascript" >

$(document).ready(function(e){
	$('#vall').on('ifChecked', function() {
		$('input[rel=v]').iCheck('check');
	});
	$('#vall').on('ifUnchecked', function() {
		$('input[rel=v]').iCheck('uncheck');
	});

	$('#dall').on('ifChecked', function() {
		$('input[rel=d]').iCheck('check');
	});
	$('#dall').on('ifUnchecked', function() {
		$('input[rel=d]').iCheck('uncheck');
	});

	$('#uall').on('ifChecked', function() {
		$('input[rel=u]').iCheck('check');
	});
	$('#uall').on('ifUnchecked', function() {
		$('input[rel=u]').iCheck('uncheck');
	});
	
});
</script>

