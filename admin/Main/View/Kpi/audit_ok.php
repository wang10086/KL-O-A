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
    var time    = <?php echo $time?$time:2000; ?>;
	setTimeout(function(){
		window.top.location.reload();
	}, time);
});
</script>