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
                        <p>姓名：{$row.name}</p>
                    </div>
                    <div class="form-group col-md-4 viwe">
                        <p>类型：{$reskind[$row[kind]]}</p>
                    </div>
                    
                    <div class="form-group col-md-4 viwe">
                        <p>费用：{$row.fee}</p>
                    </div>
                    
                    <div class="form-group col-md-4 viwe">
                        <p>性别：{$row.sex}</p>
                    </div>
                    
                    <div class="form-group col-md-4 viwe">
                        <p>生日：{$row.birthday}</p>
                    </div>
                    
                    <div class="form-group col-md-4 viwe">
                        <p>学校：{$row.school}</p>
                    </div>
                    
                    <div class="form-group col-md-4 viwe">
                        <p>专业：{$row.major}</p>
                    </div>
                    
                    <div class="form-group col-md-4 viwe">
                        <p>学历：{$row.edu}</p>
                    </div>
                    
                    
                    <div class="form-group col-md-4 viwe">
                        <p>年级：{$row.grade}</p>
                    </div>

                    <div class="form-group col-md-4 viwe">
                        <p>地区：{$row.area}</p>
                    </div>
                    
                    <div class="form-group col-md-4 viwe">
                        <p>电话：{$row.tel}</p>
                    </div>
                    
                    <div class="form-group col-md-4 viwe">
                        <p>邮箱：{$row.email}</p>
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
                    
                    <div class="form-group col-md-12 viwe">
                        <p>擅长领域：{$row.field}</p>
                    </div>
     
                </div>  
                
                <div class="content" style="margin-top:10px; border-top:1px solid #dedede;">
                    <div class="form-group col-md-12 viwe">{$row.experience}</div>
                </div>
                           
                   
            </div> 
        </section>


        <include file="Index:footer" />
        