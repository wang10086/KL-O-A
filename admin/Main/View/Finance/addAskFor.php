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
    <script src="__HTML__/comm/laydate/laydate.js"></script>
    <script src="__HTML__/js/public.js?v=1.0.6"></script>
    <?php echo PHP_EOL . $__additional_css__ ?>
    
</head>
<body>

<script type="text/javascript">
    window.gosubmint= function(){
        $('#myform').submit();
    }
</script>

<section class="content">
    <form method="post" action="{:U('Finance/addAskFor')}" name="myform" id="myform">
        <input type="hidden" name="dosubmint" value="1">
        <input type="hidden" name="opid" value="{$opid}">
        <input type="hidden" name="id" value="{$list.id}">
        <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
        <div class="content" >
            <div class="form-group col-md-4">
                <label>申请日期：</label>
                <input type="text" name="info[day]" class="form-control inputdate" value="{$list['day'] ? date('Y-m-d',$list['day']) : ''}" required />
            </div>

            <div class="form-group col-md-4">
                <label>申请人：</label>
                <input type="text" name="info[create_user_name]" class="form-control" value="{:cookie('nickname')}" readonly />
                <input type="hidden" name="info[create_user_id]" class="form-control" value="{:cookie('userid')}" />
            </div>

            <div class="form-group col-md-4">
                <label>合同编号：</label>
                <input type="text" name="info[contract_num]" class="form-control" value="{$list.contract_num}" required />
            </div>

            <div class="form-group col-md-4">
                <p><label>是否首次申请</label></p>
                <input type="radio" name="info[first]" value="1" <?php if ($list['first']=='1') echo 'checked'; ?>> &#8194;是 &#12288;
                <input type="radio" name="info[first]" value="0" <?php if ($list['first']=='0') echo 'checked'; ?>> &#8194;否
            </div>

            <div class="form-group col-md-4">
                <p><label>是否有欠款</label></p>
                <input type="radio" name="info[is_debt]" value="1" <?php if ($list['is_debt']=='1') echo 'checked'; ?>> &#8194;是 &#8194;
                <input type="text" name="info[debt]" value="{$list.debt}" style="border: none; border-bottom: solid 1px; width: 80px">元 &#12288;
                <input type="radio" name="info[is_debt]" value="0" <?php if ($list['is_debt']=='0') echo 'checked'; ?>> &#8194;否
            </div>

            <div class="form-group col-md-4">
                <label>开票主体：</label>
                <select class="form-control" name="info[company]" required>
                    <option value="0">选择</option>
                    <foreach name="companys" key="k" item="v">
                        <option value="{$k}" <?php if($list['company']==$k){ echo 'selected'; } ?>>{$v}</option>
                    </foreach>
                </select>
            </div>

            <div class="form-group col-md-4">
                <label>开票类型：</label>
                <select class="form-control" name="info[type]" required>
                    <option value="">选择</option>
                    <option value="增值税专用" <?php if ($list['type'] == '增值税专用') echo "selected";  ?>>增值税专用</option>
                    <option value="普通发票" <?php if ($list['type'] == '普通发票') echo "selected";  ?>>普通发票</option>
                </select>
            </div>

            <div class="form-group col-md-4">
                <label>开票金额：</label>
                <input type="text" name="info[money]" class="form-control" value="{$list.money}" required />
            </div>

            <div class="form-group col-md-4">
                <label>开票单位名称：</label>
                <input type="text" name="info[name]" class="form-control" value="{$list.name}"/>
            </div>

            <div class="form-group col-md-4">
                <label>开票单位纳税人识别号：</label>
                <input type="text" name="info[num]" class="form-control" value="{$list.num}"/>
            </div>

            <div class="form-group col-md-4">
                <label>地址：</label>
                <input type="text" name="info[addr]"  class="form-control" value="{$list.addr}"/>
            </div>

            <div class="form-group col-md-4">
                <label>电话号码：</label>
                <input type="text" name="info[mobile]" class="form-control" value="{$list.mobile}"/>
            </div>

            <div class="form-group col-md-8">
                <label>开户银行：</label>
                <input type="text" name="info[bank_name]" class="form-control" value="{$list.bank_name}"/>
            </div>

            <div class="form-group col-md-4">
                <label>账号：</label>
                <input type="text" name="info[bank_num]" class="form-control" value="{$list.bank_num}"/>
            </div>

            <div class="form-group col-md-12">
                <label>备注：</label>
                <textarea name="info[remark]" class="form-control">{$list.remark}</textarea>
            </div>

        </div>
    </form>
</section>


<include file="Index:footer" />

<script type="text/javascript">
    $(function () {
        relaydate();
    })
</script>

