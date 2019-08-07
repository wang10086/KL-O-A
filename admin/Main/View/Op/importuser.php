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
			var rs = new Array();
			$('.userlist').each(function(index, element) {
				var obj = {};
				obj.name       = $(element).find("input[name=name]").val();
				obj.sex        = $(element).find("input[name=sex]").val();
				obj.number     = $(element).find("input[name=number]").val();
				obj.mobile     = $(element).find("input[name=mobile]").val();
				obj.ecname     = $(element).find("input[name=ecname]").val();
				obj.ecmobile   = $(element).find("input[name=ecmobile]").val();
				obj.remark     = $(element).find("input[name=remark]").val();
				rs.push(obj);
			});
			return rs;		
		 } 
        </script>
       
        <section class="content">
        	<div id="import">
            <form method="post" action="{:U('Op/importuser')}" method="post"
enctype="multipart/form-data">
            <input type="hidden" name="dosubmit" value="1">
            <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
            <div id="file_text">
                <div class="div">
                     <div class="line">
                       <span class="span">
                           <input name="" type="text" id="viewfile" onmouseout="document.getElementById('upload').style.display='none';" placeholder="请上传小于10M的Excel文件" class="inputstyle" />
                       </span>
                       
                       <label for="unload" onmouseover="document.getElementById('upload').style.display='block';" class="file1">浏览</label>
                       <input type="file" onchange="document.getElementById('viewfile').value=this.value;this.style.display='none';" name="file" class="file" id="upload" />
                       
                    </div>
                </div>
                <button type="submit" class="btn btn-danger btn-sm" style="float:left" id="onfile">读取文件</button>  
                <span style=" float:left; margin-left:10px; margin-top:17px;"><a href="upload/xls/demo.xlsx">名单样本下载</a></span>
            </div>
            </form>       
            </div>
            <?php if($data){ ?>
            <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                <tr role="row" class="orders" >
                    <th>姓名</th>
                    <th>性别</th>
                    <th>证件号</th>
                    <th>联系电话</th>
                    <th>家长姓名</th>
                    <th>家长电话</th>
                    <th>备注</th>
                </tr>
                <foreach name="data" key="k" item="row">  
                <?php if($k>0){ ?>                    
                <tr class="userlist">
                    <td>
					<?php echo $row[0];?>
                    <input type="hidden" name="name" value="<?php echo $row[0];?>">
                    <input type="hidden" name="sex" value="<?php echo $row[1];?>">
                    <input type="hidden" name="number" value="<?php echo $row[2];?>">
                    <input type="hidden" name="mobile" value="<?php echo $row[3];?>">
                    <input type="hidden" name="ecname" value="<?php echo $row[4];?>">
                    <input type="hidden" name="ecmobile" value="<?php echo $row[5];?>">
                    <input type="hidden" name="remark" value="<?php echo $row[6];?>">
                    </td>
                    <td><?php echo $row[1];?></td>
                    <td><?php echo $row[2];?></td>
                    <td><?php echo $row[3];?></td>
                    <td><?php echo $row[4];?></td>
                    <td><?php echo $row[5];?></td>
                    <td><?php echo $row[6];?></td>
                </tr>
                <?php } ?>
                </foreach>		
                
            </table>
            <?php } ?>
            </div><!-- /.box-body -->
            
        </section>


        <include file="Index:footer" />
        