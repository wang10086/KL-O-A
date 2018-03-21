<?php use Sys\P; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo P::SYSTEM_NAME; ?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="__HTML__/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="__HTML__/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="__HTML__/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- jquery-ui style -->
        <link href="__HTML__/css/jQueryUI/jquery-ui-1.10.3.custom.min.css" rel="stylesheet" type="text/css" />
        <!-- ArtDialog -->
        <link href="__HTML__/css/artDialog.css" rel="stylesheet" type="text/css"  />
        <link href="__HTML__/css/artdialog/ui-dialog.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="__HTML__/css/py.css" rel="stylesheet" type="text/css" />
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="__HTML__/js/html5shiv.min.js"></script>
          <script src="__HTML__/js/respond.min.js"></script>
        <![endif]-->
        <script src="__HTML__/js/jquery-1.7.2.min.js"></script>
        <!-- Bootstrap -->
        <script src="__HTML__/js/bootstrap.min.js" type="text/javascript"></script>
        <?php echo PHP_EOL . $__additional_css__ ?>

    </head>
    <body>

		<script type="text/javascript">
        window.gosubmint= function(){
			$('#gosub').submit();
		 } 
        </script>
       
        <section class="content">
        	<div id="selectbox">
            <form action="{:U('Worder/assign_user')}" method="get" id="feedbackform">
            <input type="hidden" name="m" value="Main">
            <input type="hidden" name="c" value="Worder">
            <input type="hidden" name="a" value="assign_user">
            <input type="hidden" name="opid" value="{$opid}">
            <input type="text" class="form-control" name="key"  placeholder="关键字" value="">
            <button type="submit" class="btn btn-success">搜索</button>
            </form>
            
            </div>
            
            <form method="post" action="{:U('Worder/assign_user')}" name="myform" id="gosub">
            <input type="hidden" name="dosubmit" value="1">
            <input type="hidden" name="id" value="{$opid}">
            <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                <tr role="row" class="orders" >
                	<th width="60" style="text-align:center">选择</th>
                    <th class="sorting" data="nickname" width="22%">姓名</th>
                    <th class="sorting" data="mobile" width="22%">手机</th>
                    <th class="sorting" data="email" width="22%">邮箱</th>
                    <th class="sorting" data="roleid">部门</th>
                </tr>
                <foreach name="lists" item="row">                      
                <tr class="guidelist">
                	<td align="center">
                    <input type="radio" name="info" value="{$row.id}">
                    </td>
                    <td>{$row.nickname}</td>
                    <td>{$row.mobile}</td>
                    <td>{$row.email}</td>
                    <td>{$role.$row[roleid]}</td>
                </tr>
                </foreach>		
                
            </table>
            </form>
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
                <div class="pagestyle">{$pages}</div>
            </div>
        </section>


        <include file="Index:footer" />
        