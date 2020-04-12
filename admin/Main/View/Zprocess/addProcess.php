<include file="Index:header2" />

        <aside class="right-side">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>{$_action_}</h1>
                <ol class="breadcrumb">
                    <li><a href="{:U('Zprocess/public_index')}"><i class="fa fa-home"></i> 首页</a></li>
                    <li><a href="javascript:;">{$_action_}</a></li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
            <form method="post" action="{:U('Zprocess/addProcess')}" name="myform">
            <input type="hidden" name="dosubmint" value="1">
            <input type="hidden" name="id" value="{$list.id}">
                <div class="row">
                     <!-- right column -->
                    <div class="col-md-12">
                        <div class="box box-success">
                            <div class="box-header">
                                <h3 class="box-title">{$_action_}</h3>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <div class="content">
                                    <div class="form-group col-md-6">
                                        <label>标题：</label><input type="text" name="info[title]" class="form-control" value="{$list.title}" required />
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>流程类型：</label>
                                        <select  class="form-control"  name="info[type]"  required>
                                            <option value="" selected disabled>请选择流程类型</option>
                                            <foreach name="typeLists" item="vv">
                                                <option value="{$vv.id}" <?php if ($vv['id'] == $list['type']) echo "selected"; ?> >{:tree_pad($vv['level'], true)} {$vv.title}</option>
                                            </foreach>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label>备注：</label><textarea class="form-control"  name="info[remark]">{$list.remark}</textarea>
                                        <span id="contextTip"></span>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <a href="javascript:;" id="pickupfile" class="btn btn-success btn-sm" style="margin-top:15px; float:left;"><i class="fa fa-upload"></i> 流程图</a>
                                        <!--<span style="line-height:30px; float:left;margin-left:15px; margin-top:15px; color:#999999;">请选择小于10M的文件，支持JPG / GIF / PNG / DOC / XLS / PDF / ZIP / RAR文件类型</span>-->
                                        <span style="line-height:30px; float:left;margin-left:15px; margin-top:15px; color:#999999;">请选择小于10M的流程图，支持JPG / PNG 等图片文件</span>

                                        <table id="flist" class="table" style="margin-top:15px; float:left; clear:both; border-top:1px solid #dedede;">
                                            <tr>
                                                <th align="left" width="">文件名称</th>
                                                <th align="left" width="100">大小</th>
                                                <th align="left" width="30%">上传进度</th>
                                                <th align="left" width="60">操作</th>
                                            </tr>

                                            <?php if($files){?>
                                                <foreach name="files" key="k" item="v">
                                                    <tr id="<?php echo $v['id']?>"  valign="middle" class="un_upload" >
                                                        <td class="iptval">
                                                            <input type="text" name="newname[{$v['id']}]" value="<?php echo $v['filename'];?>" class="form-control file_val" />
                                                            <input type="hidden" name="fileid[{$v['id']}]" value="{$v['id']}">
                                                        </td>
                                                        <td> <?php echo $v['filesize'];?></td>
                                                        <td>
                                                            <div class="progress sm">
                                                                <div class="progress-bar progress-bar-aqua" rel="o_1d1aj6qv6hneji21v471vah17u1c" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <a class="btn btn-danger btn-xs " href="javascript:;" onclick="removeThisFile(<?php echo $v['id']?>)">
                                                                <i class="fa fa-times"></i>删除
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </foreach>
                                            <?php } ?>

                                        </table>
                                        <div id="container" style="display:none;"></div>
                                    </div>

                                    <div class="form-group col-md-12 ml-12" id="is_or_not_file">
                                        <h2 class="tcs_need_h2">后期是否需要审核文件：</h2>
                                        <input type="radio" name="need_or_not" value="0"  <?php if(!$fileTypes){ echo 'checked';} ?>> &#8194;不需要 &#12288;&#12288;&#12288;
                                        <input type="radio" name="need_or_not" value="1"  <?php if($fileTypes){ echo 'checked';} ?>> &#8194;需要
                                    </div>

                                    <div class="form-group col-md-12 ml-12" id="wonder_department" style="margin-top: -30px;">
                                    <?php if ($fileTypes){ ?>
                                        <foreach name="fileTypes" key="k" item="v">
                                            <?php if ($v['pid'] == 0){ ?>
                                                <input type="hidden" name="resid[888{$k}][id]" value="{$v.id}" />
                                                <input type="hidden" name="fileTypes[888{$k}][id]" value="{$v.id}" />
                                                <input type="hidden" name="fileTypes[888{$k}][pid]" value="{$v.pid}" />
                                            <?php }else{ ?>
                                                <div class="tasklist worder_box" id="task_ti_{$k}">
                                                    <a class="worder_close" href="javascript:;" onClick="del_box(`task_ti_{$k}`)">×</a>
                                                    <div class="col-md-12">
                                                        <input type="hidden" name="resid[888{$k}][id]" value="{$v.id}" />
                                                        <input type="hidden" name="fileTypes[888{$k}][id]" value="{$v.id}" />
                                                        <input type="hidden" name="fileTypes[888{$k}][pid]" value="{$v.pid}" />
                                                        <input type="text" class="form-control" name="fileTypes[888{$k}][title]" value="{$v.title}"  placeholder="请输入文件类型"  style="width:100%; margin-right:10px;"/>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </foreach>
                                    <?php }else{ ?>
                                        <div class="tasklist worder_box" id="task_ti_1" >
                                            <div class="col-md-12">
                                                <input type="text" class="form-control" name="fileTypes[]"  placeholder="请输入文件类型" />
                                            </div>
                                        </div>
                                    <?php } ?>
                                    </div>

                                    <!--<div class="form-group col-md-12 ml-12" id="wonder_department" style="margin-top: -30px;">
                                        <div class="tasklist worder_box" id="task_ti_1" >
                                            <div class="col-md-12">
                                                <input type="text" class="form-control" name="fileTypes[]"  placeholder="请输入文件类型" />
                                            </div>
                                        </div>
                                    </div>-->

                                    <div id="costacc_val">1</div>
                                    <div class="form-group col-md-12" id="boxaddbtns" style="margin-left:15px;">
                                        <a href="javascript:;" class="btn btn-success btn-sm" onClick="add_box()"><i class="fa fa-fw fa-plus"></i> 新增文件类型</a>
                                    </div>

                                    <div id="formsbtn">
                                        <button type="submit" class="btn btn-info btn-lg" id="lrpd">保存</button>
                                    </div>
                                </div>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div><!--/.col (right) -->
                </div>   <!-- /.row -->
                </form>
            </section><!-- /.content -->

        </aside><!-- /.right-side -->

  </div>
</div>

<include file="Index:footer2" />

<script type="text/javascript">
    let fileTypes = <?php echo $fileTypes ? 1 : 0; ?>;
    if (fileTypes == 0){
        $('#wonder_department').hide();
        $('#boxaddbtns').hide();
    }

    $(function () {
        let html = '<div class="tasklist worder_box" id="task_ti_1" >';
            html +='<div class="col-md-12">';
            html +='<input type="text" class="form-control" name="fileTypes[]"  placeholder="请输入文件类型" />';
            html +='</div></div>';
        //后期是否需要审核文件
        $('#is_or_not_file').find('ins').each(function (index,ele) {
            $(this).click(function () {
                var is_worder   = $(this).prev('input[name="need_or_not"]').val();
                if (is_worder == 1){    //需要
                    $('#wonder_department').show();
                    $('#boxaddbtns').show();
                    $('#wonder_department').html(html);
                }else{
                    $('#wonder_department').hide();
                    $('#boxaddbtns').hide();
                    $('input[name="exe_user_id[]"]').parent('div').removeClass('checked');
                }
            })
        })
    })

    function add_box(){
        var i = parseInt($('#costacc_val').text())+1;
        var html = '<div class="tasklist worder_box" id="task_ti_'+i+'">';
        html += '<a class="worder_close" href="javascript:;" onClick="del_box(`task_ti_'+i+'`)">×</a>';
        html += '<div class="col-md-12">';
        html += '<input type="text" class="form-control" name="fileTypes[]"  placeholder="请输入文件类型"  style="width:100%; margin-right:10px;"/>';
        html += '</div></div>';

        $('#wonder_department').append(html);
        $('#costacc_val').html(i);
        //orderno();
    }

    //编号
    function orderno(){
        $('#wonder_department').find('.title').each(function(index, element) {
            $(this).text(parseInt(index)+1);
        });
    }

    //移除
    function del_box(obj){
        $('#'+obj).remove();
        //orderno();
    }

    $(document).ready(function(e) {
        //主文件
        var uploader = new plupload.Uploader({
            runtimes : 'html5,flash,silverlight,html4',
            browse_button : 'pickupfile', // you can pass in id...
            container: document.getElementById('container'), // ... or DOM Element itself
            url : 'index.php?m=Main&c=File&a=upload_file',
            flash_swf_url : '__HTML__/comm/plupload/Moxie.swf',
            silverlight_xap_url : '__HTML__/comm/plupload/Moxie.xap',
            multiple_queues:false,
            multipart_params: {
                //fileType: 1 //主文件
            },

            filters : {
                mime_types : [ //只允许上传图片和zip文件
                    { title : "Image files", extensions : "jpg,gif,png,JPG,GIF,PNG" }
                    //{ title : "Zip files", extensions : "zip" }
                ],
                max_file_size : '10mb', //最大只能上传400kb的文件
                prevent_duplicates : true //不允许选取重复文件
            },

            init: {
                PostInit: function() {
                    //$('div.moxie-shim').width(104).height(67);
                },

                FilesAdded: function(up, files) {
                    plupload.each(files, function(file) {
                        var time = new Date();
                        var month = time.getMonth() +1;
                        if (month < 10) month = "0" + month;

                        var t = time.getFullYear()+ "/"+ month + "/" + time.getDate()+ " "+time.getHours()+ ":"+ time.getMinutes() + ":" +time.getSeconds();
                        $('#flist').append(
                            '<tr id="' + file.id + '"  valign="middle" class="un_upload"><td class="iptval">'
                            /* + '<input type="hidden" name="pid_' + file.id + '" value="{$pid}" class="pid_val" />'
                             + '<input type="hidden" name="level_' + file.id + '" value="{$level}" class="level_val" />'*/
                            + '<input type="text" name="nm_' + file.id + '" value="'+ file.name +'" class="form-control file_val" />'
                            + '</td> <td>' + plupload.formatSize(file.size) +''
                            + '</td> <td>'
                            + '<div class="progress sm"> '
                            + '<div class="progress-bar progress-bar-aqua" rel="'+ file.id +'"  role="progressbar"  aria-valuemin="0" aria-valuemax="100">'
                            + '</div></div></td>'
                            + '<td><a class="btn btn-danger btn-xs " href="javascript:;" onclick="removeThisFile(\''+ file.id +'\');"><i class="fa fa-times"></i>删除</a></td></tr>'
                        );
                    });
                    uploader.start();
                },

                FileUploaded: function(up, file, res) {
                    var rs = eval('(' + res.response +')');
                    if (rs.rs ==  'ok') {
                        $('div[rel=' + file.id + ']').css('width', '100%');
                        $('#container').append('<input type="hidden" rel="'+file.id+'" name="resfiles[]" value="' + rs.aid + '" />');
                        $('input[name=nm_' + file.id +']').prop('name', 'newname['+rs.aid+']');
                        /*$('input[name=pid_' + file.id +']').prop('name', 'pid['+rs.aid+']');
                        $('input[name=level_' + file.id +']').prop('name', 'level['+rs.aid+']');*/
                        $('#' + file.id).find('.iptval').append('<input type="hidden" name="fileid['+rs.aid+']" value="'+rs.aid+'" class="id_val" />');
                    } else {
                        alert('上传文件失败，请重试');
                    }
                },

                UploadProgress: function(up, file) {
                    $('div[rel=' + file.id + ']').css('width', file.percent + '%');
                },

                Error: function(up, err) {
                    alert(err.code + ": " + err.message);
                }
            }
        });

        uploader.init();
    });

    function removeThisFile(fid) {
        if (confirm('确定要删除此附件吗？')) {
            $('#' + fid).empty().remove();
            $('input[rel=' + fid +']').remove();
        }
    }

    function del_timu(sid) {
        $('#username_div_'+sid).remove();
    }

    /*artDialog.alert = function (content, status) {
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
    }*/

</script>
