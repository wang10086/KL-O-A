<include file="Index:header_mini" />
 
 <div style="margin: 65px 50px 30px 50px;">                    
	<table class="table" style="margin: 5px;">
        <tr role="row" >
            <td style="text-align: center; font-size:16px;">{$msg}</td>
        </tr>
        <tr role="row" >
            <td style="text-align: center;">&nbsp;</td>
        </tr>
    </table> 
</div>

<include file="Index:footer" />

<script type="text/javascript" >
$(document).ready(function(e) {
	setTimeout(function(){ 
		parent.art.dialog.list["edit_box"].close();
		parent.art.top.location.reload();
	}, 2000);
});
</script>