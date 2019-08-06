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

				<form action="{:U('Rbac/audit_config')}" method="post" name="myform" id="myform">                
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
                                    
                                    <table class="table table-bordered dataTable fontmini"  style="margin: 5px;" id="tablelist">
                                        <tr role="row" >
                                            <th style="min-width: 200px">部门/角色</th>
                                            <foreach name="req_types" key="k" item="v">
                                                <th width="48"><input type="checkbox"  id="r_{$k}"/> {$v} </th>
                                            </foreach>
                                            
                                        </tr>
                                            
                                
                                        <foreach name="roles" item="row">
                                        
                                            <tr>
                                                <td><input type="hidden" name="roles[]" value="{$row.id}"/>
                                                <input type="checkbox" id="role_{$row.id}" /> 
                                                {:tree_pad($row['level'])} {$row.role_name}
                                                </td>
                                                <!-- 
                                                <td><input type="checkbox" rel="v" name="info[{$row.id}][v]" value="1"  /></td>
                                                 -->
                                                <foreach name="req_types" key="k" item="v">
                                                <td><input type="checkbox" rel="r_{$k}" data="role_{$row.id}" name="info[{$row.id}][{$k}]" value="1"  <?php if(isset($rights[$row['id']]) && $rights[$row['id']][$k] == true) echo 'checked'; ?>/></td>
                                                </foreach>
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
	$('[id^=r_]').on('ifChecked', function() {
		$('input[rel='+ $(this).attr('id') + ']').iCheck('check');
	});
	$('[id^=r_]').on('ifUnchecked', function() {
		$('input[rel='+ $(this).attr('id') + ']').iCheck('uncheck');
	});
	$('[id^=role_]').on('ifChecked', function() {
		$('input[data='+ $(this).attr('id') + ']').iCheck('check');
	});
	$('[id^=role_]').on('ifUnchecked', function() {
		$('input[data='+ $(this).attr('id') + ']').iCheck('uncheck');
	});
	
});
</script>

