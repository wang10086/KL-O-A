<include file="Index:header2" />

<aside class="right-side">
    <section class="content-header">
        <h1>文件审批</h1>
        <ol class="breadcrumb">
            <li><a href="{:U('Files/index')}"><i class="fa fa-home"></i> 首页</a></li>
            <li><a href="javascript:;">上传文件</a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">上传文件</h3>
                    </div><!-- /.box-header -->

                    <form method="post" action="{:U('Approval/Approval_file')}" name="myform" id="myform">

                        <div style="padding:2em;margin:0em 0em -2em 0em;<?php if(empty($approval)){echo'display:none;';}?>" >
                            <table class="table table-bordered dataTable">
                                <tr role="row" class="orders" >
                                    <th style="text-align:center;width:6em;"><b>文件ID </b></th>
                                    <th style="text-align:center;width:6em;"><b>拟稿人姓名</b></th>
                                    <th style="text-align:center;width:8em;"><b>文件名称</b></th>
                                    <th style="text-align:center;width:6em;"><b>创建时间</b></th>
                                    <th style="text-align:center;width:6em;"><b>审批天数</b></th>
                                    <th style="text-align:center;width:15em;"><b>文件描述 </b></th>
                                </tr>
                                <tr>
                                    <td style="text-align:center;">{$approval['id']}</td>
                                    <input type="hidden" name="file_id" value="{$approval['id']}">
                                    <td style="text-align:center;color:#3399FF;">{$approval['username']}</td>
                                    <td style="text-align:center;"><a href="{$approval['file_url']}">{$approval['file_name']}</a></td>
                                    <td style="text-align:center;"><?php echo date('Y-m-d H:i:s',$approval['createtime']);?></td>
                                    <td style="text-align:center;">{$approval['file_date']} （天）</td>
                                    <td style="text-align:center;">{$approval['describe']}</td>
                                </tr>
                            </table>
                        </div>

                        <div  class="content" style="<?php if(!empty($approval)){echo'display:none;';}?>">
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" name="days" placeholder="审批天数 例如：8">
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" name="username" value="<?php echo $_SESSION['username'];?>" readonly="readonly">
                            </div>
                            <div class="form-group col-md-12">
                               <textarea rows="5" class="form-control" style="resize:none" name="describe" placeholder="文件描述">
                                </textarea>
                            </div>
                        </div>

                        <div class="content">
                            <div class="col-md-12">
                                <lebal class="upload-lebal" >选择上级领导审批:<span></span></lebal>
                                <input type="text" class="form-control keywords_kpr" placeholder="上级领导"  style="width:180px;margin-top:1em;"/>
                                <input type="hidden" name="user_id" id="kpr" value="{$approval['pid']}">
                            </div>

                            <div class="col-md-12 mt10" id="postid"></div>
                            <div class="form-group col-md-12"></div>
                            <div class="form-group col-md-12">
                                <a href="javascript:;" id="pickupfile" class="btn btn-success btn-sm" style="margin-top:15px; float:left;"><i class="fa fa-upload"></i> 选择主文件</a>
                                <span style="line-height:30px; float:left;margin-left:15px; margin-top:15px; color:#999999;">请选择小于100M的单个文件，支持DOC文件类型</span>
                                <div class="form-group col-md-12"></div>
                                <table id="flist" class="table" style="margin-top:15px; float:left; clear:both; border-top:1px solid #dedede;">
                                    <tr>
                                        <th align="left" width="">文件名称</th>
                                        <th align="left" width="100">大小</th>
                                        <th align="left" width="30%">上传进度</th>
                                        <th align="left" width="60">操作</th>
                                    </tr>

                                    <?php if(!empty($save[0]['id'])){?>
                                    <tr id="<?php echo $save[0]['id'];?>"  valign="middle" class="un_upload" >
                                        <td class="iptval"><input type="text" value="<?php echo $save[0]['file_name'];?>" class="form-control file_val" readonly="readonly" /></td>
                                        <td><?php echo $save[0]['file_size'];?></td>
                                        <td>
                                            <div class="progress sm">
                                                <div class="progress-bar progress-bar-aqua" rel="o_1d1aj6qv6hneji21v471vah17u1c" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                                            </div>
                                        </td>
                                        <td>
                                            <a class="btn btn-danger btn-xs " href="javascript:;" onclick="removeThisFile1(<?php echo $save[0]['id'];?>)">
                                                <i class="fa fa-times"></i>删除
                                            </a>
                                        </td>
                                    </tr>
                                    <?php } ?>

                                </table>
                                <div id="container" style="display:none;"></div>
                            </div>
                            <br><br><br>


                            <div class="col-md-12 mt10" id="postid1"></div>
                            <div class="form-group col-md-12"></div>
                            <div class="form-group col-md-12">
                                <a href="javascript:;" id="pickupfile1" class="btn btn-success btn-sm" style="margin-top:15px; float:left;"><i class="fa fa-upload"></i> 选择附文件</a>

                                <span style="line-height:30px; float:left;margin-left:15px; margin-top:15px; color:#999999;">请选择小于100M的多个文件，支持DOC文件类型</span>
                                <div class="form-group col-md-12"></div>
                                <table id="flist1" class="table" style="margin-top:15px; float:left; clear:both; border-top:1px solid #dedede;border-bottom:1px solid #dedede;">
                                    <tr>
                                        <th align="left" width="" style="font-size: 14px;">文件名称</th>
                                        <th align="left" width="100" style="font-size: 14px;">大小</th>
                                        <th align="left" width="30%" style="font-size: 14px;">上传进度</th>
                                        <th align="left" width="60" style="font-size: 14px;">操作</th>
                                    </tr>

                                    <foreach name="save[1]" item="s">
                                        <?php if(!empty($s['id'])){?>
                                        <tr id="<?php echo $s['id'];?>"  valign="middle" class="un_upload" >
                                            <td class="iptval"><input type="text" value="<?php echo $s['file_name'];?>" class="form-control file_val" readonly="readonly" /></td>
                                            <td> <?php echo $s['file_size'];?></td>
                                            <td>
                                                <div class="progress sm">
                                                    <div class="progress-bar progress-bar-aqua" rel="o_1d1aj6qv6hneji21v471vah17u1c" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                                                </div>
                                            </td>
                                            <td>
                                                <a class="btn btn-danger btn-xs " href="javascript:;" onclick="removeThisFile1(<?php echo $s['id'];?>)">
                                                    <i class="fa fa-times"></i>删除
                                                </a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </foreach>


                                </table>
                                <div id="container1" style="display:none;"></div>
                            </div>

                            <div id="formsbtn">
                                <button type="submit" class="btn btn-info btn-lg" id="lrpd">保存</button>
                            </div>
                        </div>
                   </form>
                </div>
            </div>
        </div>
    </section>
</aside>

<include file="Index:footer" />

<script type="text/javascript">
    $(document).ready(function(e) {
        $('#supplierlist').show();
        var uploader = new plupload.Uploader({
            runtimes : 'html5,flash,silverlight,html4',
            browse_button : 'pickupfile', // you can pass in id...
            container: document.getElementById('container'), // ... or DOM Element itself
            url : 'index.php?m=Main&c=Approval&a=Approval_upload_file',
            flash_swf_url : '__HTML__/comm/plupload/Moxie.swf',
            silverlight_xap_url : '__HTML__/comm/plupload/Moxie.xap',
            multiple_queues:false,
            multipart_params: {
                catid: 1
            },
            filters : {
                max_file_size : '100mb',
            },
            init: {
                PostInit: function() {
                },
                FilesAdded: function(up, files) {
                    plupload.each(files, function(file) {
                        var time = new Date();
                        var month = time.getMonth() +1;
                        if (month < 10) month = "0" + month;

                        var t = time.getFullYear()+ "/"+ month + "/" + time.getDate()+ " "+time.getHours()+ ":"+ time.getMinutes() + ":" +time.getSeconds();
                        $('#flist  tr:gt(0)').empty();
                        $('#flist').append(
                            '<tr id="' + file.id + '"  valign="middle" class="un_upload"><td class="iptval">'
                            + '<input type="text" value="'+ file.name +'" class="form-control file_val" readonly="readonly" />'
                            + '</td> <input type="hidden" name="file_size" value="'+plupload.formatSize(file.size)+'"/><td>' + plupload.formatSize(file.size) +''
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
                        var html = '<div><input type="text" class="hid' + file.id +'" name="file_url" value="'+rs.fileurl+'" style="display:none;" ></div>';
                            html += '<div><input type="text" class="hid' + file.id +'" name="file_name" value="'+file.name+'" style="display:none;" ></div>';
                        $('#postid').empty();
                        $('#postid').append(html);
                        $('div[rel=' + file.id + ']').css('width', '100%');
                        $('input[name=pid_' + file.id +']').prop('name', 'pid['+rs.aid+']');
                        $('input[name=level_' + file.id +']').prop('name', 'level['+rs.aid+']');
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


        var uploader1 = new plupload.Uploader({
            runtimes : 'html5,flash,silverlight,html4',
            browse_button : 'pickupfile1', // you can pass in id...
            container: document.getElementById('container1'), // ... or DOM Element itself
            url : 'index.php?m=Main&c=Approval&a=Approval_upload_file',
            flash_swf_url : '__HTML__/comm/plupload/Moxie.swf',
            silverlight_xap_url : '__HTML__/comm/plupload/Moxie.xap',
            multiple_queues:false,
            multipart_params: {
                catid: 1
            },

            filters : {
                max_file_size : '100mb',
            },
            init: {
                PostInit: function() {
                },
                FilesAdded: function(up, files) {
                    plupload.each(files, function(file) {
                        var time = new Date();
                        var month = time.getMonth() +1;
                        if (month < 10) month = "0" + month;

                        var t = time.getFullYear()+ "/"+ month + "/" + time.getDate()+ " "+time.getHours()+ ":"+ time.getMinutes() + ":" +time.getSeconds();
                        $('#flist1').append(
                            '<tr id="' + file.id + '"  valign="middle" class="un_upload"><td class="iptval">'
                            + '<input type="text" value="'+ file.name +'" class="form-control file_val" readonly="readonly" />'
                            + '</td> <input type="hidden" name="file_size1[]" value="'+plupload.formatSize(file.size)+'"/><td>' + plupload.formatSize(file.size) +''
                            + '</td> <td>'
                            + '<div class="progress sm"> '
                            + '<div class="progress-bar progress-bar-aqua" rel="'+ file.id +'"  role="progressbar"  aria-valuemin="0" aria-valuemax="100">'
                            + '</div></div></td>'
                            + '<td><a class="btn btn-danger btn-xs " href="javascript:;" onclick="removeThisFile(\''+ file.id +'\');"><i class="fa fa-times"></i>删除</a></td></tr>'
                        );
                    });

                    uploader1.start();
                },
                FileUploaded: function(up, file, res) {
                    var rs = eval('(' + res.response +')');
                    if (rs.rs ==  'ok') {
                        var html = '<div><input type="text" class="hid' + file.id +'" name="file_url1[]" value="'+rs.fileurl+'" style="display:none;" ></div>';
                        html += '<div><input type="text" class="hid' + file.id +'" name="file_name1[]" value="'+file.name+'" style="display:none;" ></div>';
                        $('#postid1').append(html);
                        $('div[rel=' + file.id + ']').css('width', '100%');
                        $('input[name=pid_' + file.id +']').prop('name', 'pid['+rs.aid+']');
                        $('input[name=level_' + file.id +']').prop('name', 'level['+rs.aid+']');
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
        uploader1.init();
    });

    function removeThisFile(fid) {
        if (confirm('确定要删除此附件吗？')) {
            $('#' + fid).empty().remove();
            $('input[rel=' + fid +']').remove();
            $('.hid'+fid).remove();
        }
    }

    $(document).ready(function(e) {
        var keywords = <?php  if($userkey==""){echo 0;}else{echo $userkey;} ?>;
        $(".keywords_kpr").autocomplete(keywords, {
            matchContains: true,
            highlightItem: false,
            formatItem: function(row, i, max, term) {
                return '<span style=" display:none">'+row.pinyin+'</span>'+row.text;
            },
            formatResult: function(row) {
                return row.user_name;
            }
        }).result(function(event, item) {
            $('#kpr').val(item.id);
        });
    });

    function removeThisFile1(id){
        $.ajax({
            url: "{:U('Approval/Approval_detele_file')}",
            type: "POST",
            data: {
                'id': id,
            },
            dataType:"json",
            success:function(date){
                 alert(date['msg']);
                 $('#'+id).remove();
            }
        });
    }



</script>
        