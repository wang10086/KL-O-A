<include file="Index:header_mini" />


<div style="margin: 15px 10px 10px 10px;">
<form action="{:U('Rights/grant')}" method="post" name="myform" id="myform">

<input type="hidden" name="dosubmit" value="1" />
<input type="hidden" name="res" value="{$res}" />
<input type="hidden" name="resid" value="{$resid}" />


                                
	<table class="table table-bordered " id="tablelist">
        <tr role="row" >
            <th width="50%">部门/角色</th>
            <th style="text-align: center;"><input type="checkbox"  id="vall"/> 可查看 </th>
            <th style="text-align: center;"><input type="checkbox"  id="dall"/> 可下载 </th>
            <th style="text-align: center;"><input type="checkbox"  id="uall"/> 可使用 </th>
        </tr>
            

        <foreach name="roles" item="row">
        
            <tr>
                <td><input type="hidden" name="roles[]" value="{$row.id}"/>{:tree_pad($row['level'])} {$row.role_name}  </td>
                <td style="text-align: center;"><input type="checkbox" rel="v" name="info[{$row.id}][v]" value="1"  <?php if(isset($rights[$row['id']]) && $rights[$row['id']][v] == 1) echo 'checked'; ?> /></td>
                <td style="text-align: center;"><input type="checkbox" rel="d" name="info[{$row.id}][d]" value="1"  <?php if(isset($rights[$row['id']]) && $rights[$row['id']][d] == 1) echo 'checked'; ?>/></td>
                <td style="text-align: center;"><input type="checkbox" rel="u" name="info[{$row.id}][u]" value="1"  <?php if(isset($rights[$row['id']]) && $rights[$row['id']][u] == 1) echo 'checked'; ?>/></td>
            </tr>
        </foreach>										

    </table>
   
        
</form>
</div>
<include file="Index:footer" />

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