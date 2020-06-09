<div class="row">
    <div class="col-md-12">
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">业务实施方案</h3>
                <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;">  审核状态：{$audit_status[$project_list['audit_status']]}</h3>
            </div>
            <div class="box-body">
                <div class="content">

                    <form method="post" action="{:U('Op/project')}" name="myform" id="myform">
                        <input type="hidden" name="dosubmint" value="1" />
                        <input type="hidden" name="savetype" value="1" />
                        <input type="hidden" name="opid" value="{$list.op_id}" />
                        <input type="hidden" name="id" value="{$project_list.id}" />

                        <div class="form-group col-md-12">
                            <label>方案说明：</label>
                            <textarea class="form-control"  name="remark" required>{$project_list.remark}</textarea>
                        </div>

                        <div class="form-group col-md-12">
                            <P class="border-bottom-line"> 相关文件（说明：请尽量上传PDF文件，以方便相关人员在线查看！）</P>
                            <table id="flist" class="table" style="margin-top:10px;">
                                <tr>
                                    <th align="left" width="45%">文件名称</th>
                                    <th align="left" width="10%">大小</th>
                                    <th align="left" width="30%">上传进度</th>
                                    <th align="left" width="15%">操作</th>
                                </tr>
                                <foreach name="atta_lists" item="v">
                                    <tr id="aid_{$v.id}" valign="middle">
                                        <td><input type="text" name="newname[{$v.id}]" value="{$v.filename}" class="form-control"  /></td>
                                        <td>{:fsize($v['filesize'])}</td>
                                        <td>
                                            <div class="progress sm">
                                                <div class="progress-bar progress-bar-aqua" rel="aid_{$v.id}"  role="progressbar" style="width: 100%;"  aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </td>
                                        <td><a class="btn btn-danger btn-xs " href="javascript:;" onclick="removeThisFile('aid_{$v.id}');"><i class="fa fa-times"></i>删除</a>&nbsp;&nbsp;&nbsp;&nbsp; <a class="btn btn-success btn-xs " href="{$v.filepath}" onclick=""><i class="fa fa-download"></i>下载</a></td>
                                    </tr>
                                </foreach>
                            </table>

                            <a href="javascript:;" id="pickupfile" class="btn btn-success btn-sm" style="margin-top:15px;"><i class="fa fa-upload"></i> 上传附件</a>
                            <div id="container" style="display:none;">
                                <foreach name="atta_lists" item="v">
                                    <input type="hidden" rel="aid_{$v.id}" name="resfiles[]" value="{$v.id}" />
                                </foreach>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<form method="post" action="{:U('Op/public_save')}" name="myform" id="submitForm">
    <input type="hidden" name="dosubmint" value="1">
    <input type="hidden" name="savetype" value="26">
    <input type="hidden" name="opid" value="{$list.op_id}">
    <input type="hidden" name="id" value="{$project_list.id}">
</form>

<div id="formsbtn">
    <button type="button" class="btn btn-info btn-lg" id="lrpd" onclick="$('#myform').submit()">保存</button>
    <?php if ($project_list['id'] && in_array($project_list['audit_status'], array(0,2))){ ?>
        <button type="button" class="btn btn-warning btn-lg" id="lrpd" onclick="$('#submitForm').submit()" >提交</button>
    <?php } ?>
</div>