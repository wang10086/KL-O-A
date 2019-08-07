<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>API测试</title>
<script src="http://libs.baidu.com/jquery/1.9.1/jquery.min.js"></script>
<style type="text/css">
body{ font-family:'微软雅黑'; line-height:1.5; font-size:14px; color:#666;}
table tr td{ padding:5px;}
input{ outline:none; width:500px}
button{ width:100px; height:32px; background:#09F; color:#ffffff; font-size:14px; text-align:center; line-height:32px; border:none; border-radius:5px; margin:0; padding:0; outline:none; cursor:pointer;}
button:hover{ opacity:0.8;}
.unit{ width:100%; border-top:2px solid #C00; margin-top:38px; padding-top:30px;}
strong{ color:#09F;}
a{ color:#09F;}
a:hover{ opacity:0.9;}
#menu{ width:100%; height:auto !important; float:left; clear:both;}
#menu ul{ list-style:none; width:100%; height:40px; margin:0; padding:0; padding-bottom:10px; border-bottom:2px solid #c00; float:left; clear:both;}
#menu ul li{ list-style:none; padding:5px; width:120px; height:30px; float:left; margin:0;}
#menu a{ width:120px; height:30px; float:left; line-height:30px; text-align:center; background:#cccccc; color:#333333; text-decoration:inherit;border-radius:5px; }
.listval{ width:200px;}
</style>
<script type="text/javascript">
	function selects(){
		var c = $('#cval').val();
		$('.listval').removeAttr('name').hide();
		$('.'+c).attr('name','aval').show();	
	}
	$(document).ready(function(e) {
        selects();
    });
</script>
</head>

<body>
<!--
<div id="menu">
    <ul>
        <li><a href="/video_test.html" target="_blank">测试上传视频</a></li>
        <li><a href="/avatar_test.html" target="_blank">测试上传头像</a></li>
    </ul>
</div>
-->
<div style="margin-top:10px; width:100%; height:auto !important; float:left; clear:both;">
<form action="{:U('Index/test')}" method="post">
<table style="width:100%" rules="none" border="0" cellpadding="0" cellspacing="0">
	<tr>
       <td>
       	<select name="cval" onChange="selects()" id="cval">
        	 <option value="Client" <?php if($cval=='Client'){ echo 'selected';} ?> >Client</option>
       </select>
       
       <select name="aval" class="listval Client">
             <option value="config" <?php if($aval=='config'){ echo 'selected';} ?> >C-获取选项配置</option>
       </select>      
      
       </td>
    </tr>
    <tr>
       <td>参数</td>
    </tr>
    <tr>
       <td>
       	<textarea name="code" style="width:100%; height:60px; border:1px solid #dedede; border-radius:5px; outline:none;">{$code}</textarea>
       </td>
    </tr>
    <tr>
       <td><button type="submit">提交测试</button></td>
    </tr>
    <tr>
    	<td></td>
    </tr>
</table>
</form>

<?php if(isset($_POST['cval']) && isset($_POST['aval']) && isset($_POST['code']) ){ ?>

<div class="unit">
<table rules="none" width="100%"  border="0" cellpadding="0" cellspacing="0">
	<tr>
    	<td><strong>参数：</strong></td>
    </tr>
    <tr>
       <td>{$code}</td>
    </tr>
    <tr>
    	<td><strong>密文：</strong></td>
    </tr>
    <tr>
       <td>{$encode}</td>
    </tr>
    <tr>
    	<td><strong>校验：</strong></td>
    </tr>
    <tr>
       <td>{$verify}</td>
    </tr>
    <tr>
    	<td><strong>测试：</strong><a href="{$url}" target="_blank">测试地址</a></td>
    </tr>
</table>
</div>

<div class="unit">{$jieguo}</div>

<?php } ?>
</div>
</body>
</html>
