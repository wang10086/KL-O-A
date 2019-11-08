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

                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">文件详情</h3>
                            <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;"><span class="green mr20">文件状态：{$status[$list['status']]}</span></h3>

                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="content">
                                <div class="form-group col-md-12 viwe">
                                    <p>文件名：{$file_list.newFileName}</p>
                                </div>

                                <div class="form-group col-md-4 viwe">
                                    <p>上传人：{$list.create_user_name} </p>
                                </div>

                                <div class="form-group col-md-4 viwe">
                                    <p>上传时间：{$list.create_time|date='Y-m-d H:i',###}</p>
                                </div>

                                <div class="form-group col-md-4 viwe">
                                    <p>计划结束时间：{$list.plan_time|date='Y-m-d H:i',###}</p>
                                </div>

                                <div class="form-group col-md-12" style="margin-top:20px;">
                                    <label style="width:100%; border-bottom:1px solid #dedede; padding-bottom:10px; font-weight:bold;">文件说明</label>
                                    <div style="width:100%; margin-top:10px;">{$list.content}</div>
                                </div>
                            </div>

                        </div><!-- /.box-body -->
                    </div><!-- /.box -->

                    <div class="box box-primary">
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

                                <style>
                                    #fileContentBox{ width: 60%; height: 600px; overflow: hidden ; float: left; border: 1px #a8a8a8 solid;}
                                    #fileAuditBox{ width: 38%; height: 600px; overflow: hidden; float: right; border: 1px #a8a8a8 solid;}
                                    .fileContentTitle{ width: 60%; text-align: center; display: inline-block; font-weight: bolder; }
                                    .fileAuditTitle{ width: 38%; text-align: center; display: inline-block; font-weight: bolder; }
                                </style>

                                <div class="form-group fileContentTitle">文件内容</div>
                                <div class="form-group fileAuditTitle">审核内容</div>
                                <div id="fileContentBox">
                                    <a class="media" href="{$file_url}"></a>
                                </div>

                                <div id="fileAuditBox">
                                    <div class="fileAuditBoxTitle">审核记录</div>
                                </div>
                                <div class="form-group col-md-12 mt40">&emsp;</div>

                                <form method="post" action="{:U('Approval/public_save')}">
                                    <input type="hidden" name="dosubmint" value="1">
                                    <input type="hidden" name="saveType" value="3">
                                    <div class="form-group box-float-12">
                                        <label>原文件内容</label>
                                        <textarea class="form-control" name=""></textarea>
                                    </div>
                                    <div class="form-group box-float-12">
                                        <label>建议调整为</label>
                                        <textarea class="form-control" name=""></textarea>
                                    </div>
                                </form>
                            </div>

                            <div style="width:100%; text-align:center;">
                                <button type="button" onclick="alert('开发中...')" class="btn btn-info btn-lg" id="lrpd">保存</button>
                            </div>

                            <div class="form-group mt40"></div>
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
        $('a.media').media({width:700, height:600});
        $('a.mediase').media({width:700, height:600});
    })

</script>


     


