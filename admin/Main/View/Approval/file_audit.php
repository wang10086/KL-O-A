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
                                <div class="form-group col-md-12 viwe">文件名：{$file_list.newFileName}</div>

                                <div class="form-group col-md-4 viwe">起草部门 : {$department.department}</div>
                                <div class="form-group col-md-4 viwe">拟稿人：{$list.create_user_name}</div>
                                <div class="form-group col-md-4 viwe">文件类型：<?php echo $list['type'] == 1 ? '新编' : '修改'; ?></div>

                                <div class="form-group col-md-4 viwe">计划流转工作日：{$list.day} 天</div>
                                <div class="form-group col-md-4 viwe">上传时间：{$list.create_time|date='Y-m-d H:i',###}</div>
                                <div class="form-group col-md-4 viwe">计划结束时间：{$list.plan_time|date='Y-m-d H:i',###}</div>

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

                                <div class="form-group fileContentTitle">文件内容</div>
                                <div class="form-group fileAuditTitle">审核记录</div>
                                <div id="fileContentBox">
                                    <a class="media" href="{$file_url}"></a>
                                </div>

                                <div id="fileAuditBox">
                                    <?php if ($record_list){ ?>
                                        <foreach name="record_list" key="k" item="v">
                                            <div class="mt20 record_detail_box">
                                                <P class="record_detail_title">审核人：{$v['create_user_name']} | 审核时间：{$v['create_time']|date='Y-m-d H:i',###}
                                                    <?php if (($v['create_user'] == cookie('userid') && in_array($list['status'],array(1,2))) || in_array(cookie('userid'),array(1,11))){ ?>
                                                         | <a href="javascript:edit_record('/index.php?m=Main&c=Approval&a=edit_record&rid='+{$v.id}+'&fid='+{$file_list.id})">编辑</a>
                                                        <?php if (in_array(cookie('userid'),array(1,11))){ ?>
                                                         | <a href="javascript:ConfirmDel(`{:U('Approval/del_record',array('id'=>$v['id']))}`)">删除</a>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </P>
                                                <P><span class="black">原文件内容：</span>{$v['file_content']}</P>
                                                <P><span class="black">建议修改内容：</span>{$v['suggest']}</P>
                                            </div>
                                        </foreach>
                                    <?php }else{ ?>
                                        <div class="form-group box-float-12 mt20">暂无审核记录!</div>
                                    <?php } ?>
                                </div>
                                <div class="form-group col-md-12 mt40">&emsp;</div>

                                <?php if ((in_array(cookie('userid'),$audit_uids) || cookie('userid')==1) && in_array($list['status'],array(1,2))){ ?>
                                <form method="post" action="{:U('Approval/public_save')}" id="audit_form">
                                    <input type="hidden" name="dosubmint" value="1">
                                    <input type="hidden" name="saveType" value="3">
                                    <input type="hidden" name="file_id" value="{$file_list.id}">
                                    <input type="hidden" name="appid" value="{$list.id}">
                                    <div class="form-group box-float-12">
                                        <label>原文件内容(请复制原文件相关内容)</label>
                                        <textarea class="form-control" name="file_content"></textarea>
                                    </div>
                                    <div class="form-group box-float-12">
                                        <label>建议调整为</label>
                                        <textarea class="form-control" name="suggest"></textarea>
                                    </div>
                                </form>

                                    <form method="post" action="{:U('Approval/public_save')}" id="sureSubmit">
                                        <input type="hidden" name="dosubmint" value="1">
                                        <input type="hidden" name="saveType" value="8">
                                        <input type="hidden" name="appid" value="{$list.id}">
                                    </form>

                                    <div class="form-group box-float-12 mt20" style="width:100%; text-align:center;">
                                        <button type="button" onclick="submit_audit_form()" class="btn btn-info btn-lg" id="lrpd">保存</button>
                                        <button type="button" onclick="ConfirmSub('sureSubmit','请确认本批次所有文件(包含附件)已审核完毕,提交后将无法修改审核信息!')" class="btn btn-danger btn-lg" id="lrpd">提交</button>
                                    </div>
                                <?php } ?>

                                <div class="form-group col-md-12">
                                    <button class="btn btn-default" style="float:right" onclick="print_file_audit_record({$list.id},{$file_list.id},`{:U('Approval/print_file_audit_record',array('appid'=>$list[id],'fileid'=>$file_list[id]))}`)"> <i class="fa fa-print"></i> 打印</button>
                                </div>
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
        $('a.media').media({width:700, height:600});
        $('a.mediase').media({width:700, height:600});
    })

    function submit_audit_form() {
        let file_id             = $('input[name="file_id"]').val();
        let old_file_content    = $('textarea[name="file_content"]').val().trim();
        let suggest_content     = $('textarea[name="suggest"]').val().trim();
        if (!file_id) { art_show_msg('获取文件信息失败'); return false; }
        if (!old_file_content){ art_show_msg('原文件内容不能为空'); return false; }
        if (!suggest_content){ art_show_msg('建议修改内容不能为空'); return false; }

        public_save('audit_form','<?php echo U('Approval/public_save'); ?>');
    }

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

    function edit_record(obj) {
        art.dialog.open(obj, {
            lock:true,
            id:'edit_box',
            title: '编辑文件审核记录',
            width:700,
            height:320,
            okVal: '提交',
            ok: function () {
                this.iframe.contentWindow.gosubmint();
                return false;
            },
            cancelVal:'取消',
            cancel: function () {
            }
        });
    }

    //打印文件审核记录
    function print_file_audit_record(appid,fileid,url) {
        if (!appid || !fileid){
            art_show_msg('获取审核信息失败',3);
            return false;
        }
        window.location.href = url;
    }
</script>





