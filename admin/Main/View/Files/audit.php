<include file="Index:header2" />

    <aside class="right-side">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>{$_pagetitle_}</h1>
            <ol class="breadcrumb">
                <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                <li><a href="{:U('Approval/index')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                <li class="active">{$_action_}</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="row">
                 <!-- right column -->
                <div class="col-md-12" style="padding-bottom:200px;">

                    <div class="box box-warning">
                        <div class="box-header">
                            <h3 class="box-title">文件详情</h3>
                            <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;"><span class="green mr20">文件状态：{$status[$list['audit_status']]}</span></h3>

                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="content">
                                <div class="form-group col-md-12 viwe">文件名：{$list.filename}</div>

                                <div class="form-group col-md-4 viwe">文件类型 : {$typelists[$list['type']]}</div>
                                <div class="form-group col-md-4 viwe">文件类型详情：{$typelists[$list['typeInfo']]}</div>
                                <div class="form-group col-md-4 viwe">文件适用时间：{$list.year}年{$timeType[$list['timeType']]}</div>

                                <div class="form-group col-md-4 viwe">文件上传人：{$list.create_user_name} </div>
                                <div class="form-group col-md-4 viwe">上传时间：{$list.create_time|date='Y-m-d H:i',###}</div>
                                <div class="form-group col-md-4 viwe">文件审核人：{$list.audit_user_name}</div>

                                <div class="form-group col-md-12" style="margin-top:20px;">
                                    <label style="width:100%; border-bottom:1px solid #dedede; padding-bottom:10px; font-weight:bold;">文件说明</label>
                                    <div style="width:100%; margin-top:10px;">{$list.content}</div>
                                </div>

                                <if condition="$list['audit_msg']">
                                    <div class="form-group col-md-12" style="margin-top:20px;">
                                        <label style="width:100%; border-bottom:1px solid #dedede; padding-bottom:10px; font-weight:bold;">审核备注</label>
                                        <div style="width:100%; margin-top:10px;">{$list.audit_msg}</div>
                                    </div>
                                </if>
                            </div>

                        </div><!-- /.box-body -->
                    </div><!-- /.box -->

                    <div class="box box-warning">
                        <div class="box-header">
                            <h3 class="box-title">{$_action_}</h3>
                            <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;"></h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="content" style="overflow: hidden">
                                <div class="callout callout-danger">
                                    <h4>提示！</h4>
                                    <p>1、请优先使用谷歌浏览器，其他浏览器可能无法在线显示文件内容；</p>
                                </div>

                                <div class="form-group" style="width: 100%; text-align: center; display: inline-block; font-weight: bolder;">文件内容</div>
                                <div style="width: 100%; height: 600px; border: 1px #a8a8a8 solid;">
                                    <a class="media" href="{$list.filepath}"></a>
                                </div>

                                <div class="form-group col-md-12 mt40">&emsp;</div>

                                <?php if (in_array(cookie('userid'), array($list['audit_user_id'], 1)) && $list['audit_status'] == 0){ ?>
                                <form method="post" action="{:U('Files/public_save')}" id="audit_form">
                                    <input type="hidden" name="dosubmint" value="1">
                                    <input type="hidden" name="saveType" value="3">
                                    <input type="hidden" name="id" value="{$list.id}">

                                    <div class="form-group box-float-12">
                                        <label class="">审核意见：</label>
                                        <input type="radio" name="audit_status" value="1"> &#8194;审核通过 &#12288;&#12288;&#12288;
                                        <input type="radio" name="audit_status" value="2"> &#8194;审核不通过
                                    </div>

                                    <div class="form-group box-float-12">
                                        <label>备注</label>
                                        <textarea class="form-control" name="audit_msg"></textarea>
                                    </div>

                                    <div class="form-group box-float-12 mt20" style="width:100%; text-align:center;">
                                        <button type="button" onclick="public_save('audit_form','<?php echo U('Files/public_save'); ?>')" class="btn btn-info btn-lg" id="lrpd">保存</button>
                                    </div>
                                </form>
                                <?php } ?>

                            </div>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div>
            </div>
        </section><!-- /.content -->
    </aside><!-- /.right-side -->
<include file="Index:footer2" />

<script src="__HTML__/js/jquery.media.js"></script>
<script type="text/javascript" charset="utf-8">
    $(function () {
        $('a.media').media({width:1000, height:600});
        $('a.mediase').media({width:1000, height:600});
    })

    artDialog.alert = function (content, status) {
        return artDialog({
            id: 'Alert',
            icon: status,
            width: 300,
            height: 120,
            fixed: true,
            lock: true,
            time: 1,
            content: content,
            ok: true
        });
    }

</script>





