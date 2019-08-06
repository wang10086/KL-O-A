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
    <body style="background:#ffffff;">

       <!-- Main content -->
        <section class="content">
            <div class="row">
                
                <div class="content">
                    
                    <div class="form-group col-md-4 viwe">
                        <p>所在国家：{$row.country}</p>
                    </div>
                    <div class="form-group col-md-4 viwe">
                        <p>所在省份：{$row.prov}</p>
                    </div>
                    <div class="form-group col-md-4 viwe">
                        <p>所在城市：{$row.city}</p>
                    </div>
                    
                    <div class="form-group col-md-4 viwe">
                        <p>发布时间：{$row.input_time|date='Y-m-d H:i:s',###}</p>
                    </div>
                    
                    <div class="form-group col-md-4 viwe">
                        <p>联系人：{$row.contact}</p>
                    </div>
                    
                    <div class="form-group col-md-4 viwe">
                        <p>联系电话：{$row.tel}</p>
                    </div>
					
                    <!--
                    <div class="form-group col-md-4 viwe">
                        <p>审批状态：{$row.showstatus}</p>
                    </div>
                    <div class="form-group col-md-4 viwe">
                        <p>审批人：{$row.show_user}</p>
                    </div>
                    <div class="form-group col-md-4 viwe">
                        <p>审批时间：{$row.show_time}</p>
                    </div>
                    -->
     
                </div>  
                
                <div class="content" style="margin-top:10px; border-top:1px solid #dedede;">
                    <div class="form-group col-md-12 viwe">{$row.desc}</div>
                </div>
                           
                   
            </div> 
        </section>


        <include file="Index:footer" />
        