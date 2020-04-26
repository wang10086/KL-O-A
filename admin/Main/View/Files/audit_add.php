<include file="Index:header2" />

<aside class="right-side">
    <section class="content-header">
        <h1>文件审批</h1>
        <ol class="breadcrumb">
            <li><a href="{:U('Files/index')}"><i class="fa fa-home"></i> 首页</a></li>
            <li><a href="javascript:;">{$_action_}</a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-warning">
                    <div class="box-header">
                        <h3 class="box-title">{$_action_}</h3>
                    </div><!-- /.box-header -->
                    <div class="content">
                        <form method="post" action="{:U('files/public_save')}" name="myform" id="myform">
                            <input type="hidden" name="dosubmint" value="1">
                            <input type="hidden" name="saveType" value="1">
                            <input type="hidden" name="id" value="{$row.id}">

                            <div class="form-group box-float-4">
                                <label>文件审核人 <font color="#999">(请点击选择匹配到的人员信息)</font></label>：
                                <input type="text" name="info[audit_user_name]" value="{$row['audit_user_name']}" class="form-control" id="username" />
                                <input type="hidden" name="info[audit_user_id]" value="{$row['audit_user_id']}" class="form-control" id="userid" />
                            </div>

                            <div class="form-group box-float-4">
                                <label>文件类型</label>：
                                <select class="form-control" name="info[type]" id="type">
                                    <option value="">请选择文件类型</option>
                                    <foreach name="types" item="v">
                                        <option value="{$v.id}" <?php if ($row['type'] == $v['id']){ echo "selected"; }?>>{$v.title}</option>
                                    </foreach>
                                </select>
                            </div>

                            <div class="form-group box-float-4">
                                <label>文件类型详情</label>：
                                <select class="form-control" name="info[typeInfo]" id="typeInfo">
                                    <?php if ($typeInfo){ ?>
                                        <foreach name="typeInfo" item="v">
                                            <option class="form-control" value="{$v.id}" <?php if ($row['typeInfo'] == $v['id']) echo "selected"; ?>>{$v['title']}</option>
                                        </foreach>
                                    <?php }else{ ?>
                                        <option class="form-control" value="">请先选择文件类型</option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group box-float-6">
                                <label>文件适用年份</label>：
                                <select class="form-control" name="info[year]">
                                    <option value="">请选择</option>
                                        <?php for ($i=date('Y'); $i <= date('Y')+2; $i++){ ?>
                                            <option value="{$i}" <?php if ($row['year'] == $i){ echo "selected"; }?>>{$i}年</option>
                                        <?php } ?>
                                </select>
                            </div>

                            <div class="form-group box-float-6">
                                <label>文件适用周期</label>：
                                <select class="form-control" name="info[timeType]">
                                    <option value="">请选择</option>
                                    <foreach name="timeType" key="k" item="v">
                                        <option value="{$k}" <?php if ($row['timeType'] == $k){ echo "selected"; }?>>{$v}</option>
                                    </foreach>
                                </select>
                            </div>

                            <div class="form-group box-float-12 mt-50"></div>
                            <div class="form-group box-float-12">
                                <label>文件描述：</label>
                                <textarea class="form-control"  name="info[content]" >{$row.content}</textarea>
                            </div>

                            <div class="form-group col-md-12"></div>
                            <div class="form-group col-md-12">
                                <a href="javascript:;" id="pickupfile" class="btn btn-success btn-sm" style="margin-top:15px; float:left;"><i class="fa fa-upload"></i> 选择文件</a>
                                <span style="line-height:30px; float:left;margin-left:15px; margin-top:15px; color:#999999;">请选择<font color="red">一个</font>小于20M的PDF文件</span>

                                <table id="flist" class="table" style="margin-top:15px; float:left; clear:both; border-top:1px solid #dedede;">
                                    <tr>
                                        <th align="left" width="">文件名称</th>
                                        <th align="left" width="100">大小</th>
                                        <th align="left" width="30%">上传进度</th>
                                        <th align="left" width="60">操作</th>
                                    </tr>

                                    <?php if ($file){ ?>
                                    <tr id="{$file['id']}"  valign="middle" class="un_upload">
                                        <td class="iptval">
                                            <input type="text" name="newname[{$file['id']}]" value="{$file['newFileName']}" class="form-control file_val" />
                                            <input type="hidden" name="fileid[{$file['id']}]" value="{$file['id']}">
                                            <input type="hidden" name="fileurl[{$file['id']}]" value="'+rs.fileurl+'" />
                                        </td>
                                        <td> <?php echo round($file[file_size]/1024,2); ?>Kb</td>
                                        <td>
                                            <div class="progress sm">
                                                <div class="progress-bar progress-bar-aqua" rel="{$file['id']}"  role="progressbar"  aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                                            </div>
                                        </td>
                                        <td><a class="btn btn-danger btn-xs " href="javascript:;" onclick="removeThisFile({$file['id']});"><i class="fa fa-times"></i>删除</a></td>
                                    </tr>
                                    <?php } ?>

                                </table>
                                <div id="container" style="display:none;"></div>
                            </div>
                            <br><br><br>


                            <div class="form-group col-md-12"></div>
                        </form>

                        <form method="post" action="{:U('files/public_save')}" id="auditForm">
                            <input type="hidden" name="dosubmint" value="1">
                            <input type="hidden" name="saveType" value="2">
                            <input type="hidden" name="id" value="{$list.id}">
                        </form>
                        <div id="formsbtn">
                            <button type="button" class="btn btn-info" onclick="javascript:public_save('myform','<?php echo U('files/public_save'); ?>')">&emsp;保存&emsp;</button>
                            <button type="button" class="btn btn-warning" style="margin-left: 10px" onclick="javascript:ConfirmSub('auditForm','提交审核后，文件流转期间将不可更改，<br />确定提交审核吗？')">提交审核</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>

<include file="Index:footer" />

<script type="text/javascript">
    const keywords = <?php echo $userkey; ?>;

    $(document).ready(function(e) {
        autocomplete_id('username','userid',keywords);

        //上传文件
        var uploader = new plupload.Uploader({
            runtimes : 'html5,flash,silverlight,html4',
            browse_button : 'pickupfile', // you can pass in id...
            container: document.getElementById('container'), // ... or DOM Element itself
            //url : 'index.php?m=Main&c=Files&a=public_upload_file',
            url : 'index.php?m=Main&c=File&a=upload_file',
            flash_swf_url : '__HTML__/comm/plupload/Moxie.swf',
            silverlight_xap_url : '__HTML__/comm/plupload/Moxie.xap',
            multiple_queues:false,
            multipart_params: {
                //fileType: 1 //主文件
            },

            filters : {
                max_file_size : '20mb',
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
                    let rs   = eval('(' + res.response +')');
                    let html = '<input type="hidden" rel="'+file.id+'" name="resfiles[]" value="' + rs.aid + '" />';
                    html     += '<input type="hidden" name="fileurl['+rs.aid+']" value="'+rs.fileurl+'" />';
                    if (rs.rs ==  'ok') {
                        $('div[rel=' + file.id + ']').css('width', '100%');
                        $('#container').append(html);
                        $('input[name=nm_' + file.id +']').prop('name', 'newname['+rs.aid+']');
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

    //文件类型(二级联动)
    $('#type').change(function () {
        var type    = $(this).val();
        //check_file_type(type);
        if (type){
            $.ajax({
                type : 'POST',
                url : "<?php echo U('Ajax/get_approval_file_type_info'); ?>",
                dataType : 'JSON',
                data : {type:type},
                success : function (msg) {
                    $("#typeInfo").empty();
                    if (msg.length>0){
                        var count = msg.length;
                        var i= 0;
                        var b="";
                        b+='<option value="" disabled selected>请选择</option>';
                        for(i=0;i<count;i++){
                            b+="<option value='"+msg[i].id+"'>"+msg[i].title+"</option>";
                        }
                    }else{
                        var b="";
                        b+='<option value="" disabled selected>暂无数据</option>';
                    }
                    $("#typeInfo").append(b);
                }
            })
        }else{
            art_show_msg('文件类型错误',2);
        }
    })


</script>
