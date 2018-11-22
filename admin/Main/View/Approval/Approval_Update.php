<include file="Index:header2" />

        <aside class="right-side" >
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>文件详情</h1>
                <ol class="breadcrumb">
                    <li><a href="{:U('Files/index')}"><i class="fa fa-home"></i> 首页</a></li>
                    <li><a href="{:U('Approval/Approval_Index')}">文件审批</a></li>
                    <li><a href="">文件详情</a></li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content" >

                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-body" >

                                <!-- 文件信息-->
                                <table class="table table-bordered" style="text-align:center;margin:2em auto;width:96%;">
                                    <tr class="orders">
                                        <th class="sorting" style="text-align:center;width:6em;"><b>ID</b></th>
                                        <th class="sorting" style="text-align:center;width:9em;"><b>拟稿人</b></th>
                                        <th class="sorting" style="text-align:center;width:9em;"><b>原拟稿名称</b></th>
                                        <th class="sorting" style="text-align:center;width:9em;"><b>原文件大小</b></th>
                                        <th class="sorting" style="text-align:center;width:9em;"><b>原上传时间</b></th>
                                        <th class="sorting" style="text-align:center;width:9em;"><b>修改拟稿人姓名</b></th>
                                        <th class="sorting" style="text-align:center;width:9em;"><b>修改后拟稿名称</b></th>
                                        <th class="sorting" style="text-align:center;width:9em;"><b>修改后文件大小</b></th>
                                        <th class="sorting" style="text-align:center;width:9em;"><b>修改后上传时间</b></th>
                                        <th class="sorting" style="text-align:center;width:9em;"><b>状态</b></th>
                                    </tr>

                                    <tr style="text-align:center;">
                                        <td>{$approval['Approval']['id']}</td>
                                        <td>{$approval['Approval']['account_name']}</td>
                                        <td><a href="{$approval['Approval']['file_url']}">{$approval['Approval']['file_name']}</a></td>
                                        <td>{$approval['Approval']['file_size']}</td>
                                        <td><?php if(is_numeric($approval['Approval']['createtime'])){echo date('Y-m-d H:i:s',$approval['Approval']['createtime']);}else{echo'';}?></td>
                                        <td >{$approval['Approval_url']['modify_name']}</td>
                                        <td><a href="{$approval['Approval_url']['modify_url']}">{$approval['Approval_url']['modify_filename']}</a></td>
                                        <td>{$approval['Approval_url']['modify_size']}</td>
                                        <td><?php if(is_numeric($approval['Approval_url']['modify_time'])){echo date('Y-m-d H:i:s',$approval['Approval_url']['modify_time']);}else{echo'';}?></td>
                                        <td style="text-align:center;">
                                                <?php if($approval['Approval']['status']==1){echo"待上级审核";}elseif($approval['Approval']['status']==2){echo"待综合审核";}elseif($approval['Approval']['status']==3){echo"待各级领导审核";}elseif($approval['Approval']['status']==4){echo"待最终审核";}elseif($approval['Approval']['status']==5){echo"审核通过";}elseif($approval['Approval']['status']==6){echo"审核驳回";}?>
                                        </td>

                                    </tr>
                                </table><br><br>

                                <div style="margin:-5em 0em 4em 3em;width:96%;text-align: center;">
                                    <div>
                                        <form method="post" action="{:U('Approval/file_change')}" enctype="multipart/form-data">
                                            <input type="hidden" name="file_id" value="{$approval['Approval_url']['file_id']}">
                                            <input type="hidden" name="file_url_id" value="{$approval['Approval_url']['id']}">

                                            <div class="col-md-12 mt10" id="postid"></div>
                                            <div class="form-group col-md-12"></div>
                                            <div class="form-group col-md-12" style="margin-left:-1em;">
                                                <a href="javascript:;" id="pickupfile" class="btn btn-success btn-sm" style="margin-top:15px; float:left;"><i class="fa fa-upload"></i> 修改上传文件</a>

                                                <span style="line-height:30px; float:left;margin-left:15px; margin-top:15px; color:#999999;">请选择小于100M的文件，支持JPG / GIF / PNG / DOC / XLS / PDF / ZIP / RAR文件类型</span>
                                                <div class="form-group col-md-12"></div>
                                                <table id="flist" class="table" style="margin-top:15px; float:left; clear:both; border-top:1px solid #dedede;">
                                                    <tr>
                                                        <th align="left" width="">文件名称</th>
                                                        <th align="left" width="100">大小</th>
                                                        <th align="left" width="30%">上传进度</th>
                                                        <th align="left" width="60">操作</th>
                                                    </tr>

                                                </table>
                                                <div id="container" style="display:none;"></div>
                                            </div>
                                            <div id="formsbtn" ><br>
                                                <button type="submit" class="btn btn-success btn-sm" style="width:7em;font-size:1.2em;margin:0em auto;">保 存</button>
                                            </div><br><br><br>
                                            <table style="width:98%;"  class="table">
                                                    <th width=""></th>
                                            </table>
                                        </form>
                                    </div>
                                </div><!-- /.box-header -->



                                <!-- 选择审批人员  选择审批人员-->
                                <div style="margin:-4em 0em 0em 2em;width:96%;">
                                    <form method="post" action="{:U('Approval/add_final_judgment')}" enctype="multipart/form-data">
                                        <input type="hidden" name="file_id" value="{$approval['Approval']['file_id']}">
                                        <input type="hidden" name="file_url_id" value="{$approval['Approval']['id']}">
                                        <div class="box-header" >
                                            <div class="form-group  col-md-6" >
                                                <label>
                                                    <b style="font-size:1.3em;color:#09F;letter-spacing:0.2em;">选择审批人员 : </b>
                                                </label><br>
                                                <foreach name="approver" item="app">
                                                    <label style="margin-left:2em;" class="col-md-3">
                                                        <b><input type="checkbox" name="check[]" value="{$app['id']}">
                                                            {$app['nickname']}
                                                        </b>
                                                    </label>
                                                </foreach>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>
                                                    <b style="font-size:1.3em;color:#09F;letter-spacing:0.2em;">选择终审人员 : </b>
                                                </label><br>
                                                <foreach name="office" item="off">
                                                    <label style="margin-left:2em;" class="col-md-3">
                                                       <b><input type="checkbox" name="judgment[]" value="{$off['id']}">
                                                                {$off['nickname']}
                                                       </b>
                                                    </label>
                                                </foreach>
                                            </div>

                                        </div>
                                        <center><br>
                                            <button type="submit" class="btn btn-success btn-sm" style="width:7em;font-size:1.2em;margin-left:1.7em;">
                                                保 存
                                            </button>
                                        </center>
                                    </form><br><br><br>
                                    <div class="box-header" ></div>
                                </div><br>


                                <!-- 已选审批人员  已审批人员-->
                                <div  style="width:96%;">
                                    <div class="form-group  col-md-6" >
                                        <label>
                                            <b style="font-size:1.3em;color:#09F;padding:2em;letter-spacing:0.2em;">已选审批状态 : </b>
                                        </label><br><br>
                                        <div style="margin-left:5em;">
                                            <foreach name="judgmen['annotation1']" item="j">
                                                <span style="padding:1em;">
                                                    <b>
                                                        {$j['username']}
                                                        <b style="<?php if($j['steta']==0 || $j['steta']=="" || $j['steta']==1){echo 'color:red';}elseif($j['steta']>0){echo 'color:#00CC33';}?>">
                                                            [ <?php if($j['steta']==0 || $j['steta']=="" || $j['steta']==1){echo "未批注";}elseif($j['steta']==2){echo "已批注";}?> ]
                                                        </b>
                                                    </b>
                                                </span>
                                            </foreach>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>
                                            <b style="font-size:1.3em;color:#09F;padding:2em;letter-spacing:0.2em;">最终审核状态 : </b>
                                        </label><br><br>
                                        <div style="margin-left:5em;">
                                            <foreach name="judgmen['annotation2']" item="an">
                                            <span style="padding:1em;">
                                                <b>
                                                    {$an['username']}
                                                    <b style="<?php if($j['steta']==0 || $j['steta']=="" || $j['steta']==1){echo 'color:red';}elseif($j['steta']>0){echo 'color:#00CC33';}?>">
                                                            [ <?php if($j['steta']==0 || $j['steta']=="" || $j['steta']==1){echo "未批注";}elseif($j['steta']==2){echo "已批注";}?> ]
                                                    </b>
                                                </b>
                                            </span>
                                            </foreach>
                                        </div>
                                    </div>
                                </div><br><br><br><br><br><br><br>
                                <table style="margin-left:2em;width:96%;"  class="table">
                                    <th width=""></th>
                                </table>

                                <!-- 文件 和 批注信息-->
                                <div style="width:96%;margin-left:2em;">
                                    <div style="float:left;width:68%;overflow-y:scroll;overflow-y:visible;">
                                        <label>
                                            <b style="font-size:1.3em;color:#09F;letter-spacing:0.2em;">上传文件 : </b>
                                        </label><br><br>
                                        <div style="height:90em;overflow: hidden;border-top:solid 2px #d2d5d8;">
                                             <iframe src="https://view.officeapps.live.com/op/view.aspx?src={$sercer}<?php if($approval['Approval_url']['modify_url']!==""){echo $approval['Approval_url']['modify_url'];}else{echo $approval['Approval']['file_url'];}?>" style="overflow-y:scroll;overflow-x:scroll;word-wrap:break-word;width:100%;height:100%;overflow-x:hidden;margin-top:-6em;">
                                            </iframe>
                                        </div>
                                    </div>

                                    <div style="float:right;width:30%;" >
                                        <label>
                                            <b style="font-size:1.3em;color:#09F;padding:1em;letter-spacing:0.2em;">批注内容 : </b>
                                            <a class="btn btn-default" onclick="salary2();" style="margin-top: -1em;color:#000000;background-color: lightgrey;"><i class="fa fa-print"></i> 打印</a>
                                        </label><br><br>

                                        <div  id="approval_submit_show1" style="padding:1em;height:84em;border:solid 2px #d2d5d8;overflow-y:scroll;overflow-x:scroll;word-wrap:break-word;" >
                                            <foreach name="annotation" item="ann">
                                                <p>
                                                    <b style="color:#339933;">{$ann['account_name']}&nbsp;</b>
                                                    <span>[ <?php echo date('Y-m-d H:i:s',$ann['createtime']);?> ]</span>
                                                    <span style="color:#CC3333">[ 批注 ] ：</span>

                                                    <span style="letter-spacing:0.1em;line-height:2em;text-indent:50px;">
                                                        {$ann['annotation_content']}
                                                    </span>

                                                </p>
                                            </foreach>
                                        </div>
                                    </div>
                                </div><br>
                                <div style="text-align:center;width:96%;">
                                    <form method="post" action="{:U('Approval/add_annotation')}" enctype="multipart/form-data">
                                        <input type="hidden" name="file_id" value="{$approval['Approval']['file_id']}">
                                        <input type="hidden" name="file_url_id" value="{$approval['Approval']['id']}">
                                         <textarea style="margin:2em -4em 2em 0em;padding:1em;height: 15em;border:solid 2px #d2d5d8;overflow-y:scroll;overflow-x:scroll;word-wrap:break-word;width:100%;text-indent:2.5em;line-height:2em;letter-spacing:0.1em;"  name="comment">
                                            </textarea>
                                        <input type="submit" value="提交批注" name="status" class="btn btn-info"  style="margin-right:1em;">
                                        <input type="submit" value="审批驳回" name="status" class="btn btn-info"  style="margin-right:1em;">
                                    </form>
                                </div>
                            </div>
                        </div><!-- /.box -->

                    </div><!-- /.col -->
                 </div>

            </section><!-- /.content -->
        </aside><!-- /.right-side -->


<include file="Index:footer2" />
<script>

    $(document).ready(function(e) {
        $('#supplierlist').show();
        var uploader = new plupload.Uploader({
            runtimes : 'html5,flash,silverlight,html4',
            browse_button : 'pickupfile', // you can pass in id...
            container: document.getElementById('container'), // ... or DOM Element itself
            url : 'index.php?m=Main&c=File&a=upload_file',
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
                        $('#flist').append(
                            '<tr id="' + file.id + '"  valign="middle" class="un_upload"><td class="iptval">'
                            + '<input type="hidden" name="pid_' + file.id + '" value="{$pid}" class="pid_val" />'
                            + '<input type="hidden" name="level_' + file.id + '" value="{$level}" class="level_val" />'
                            + '<input type="text" name="nm_' + file.id + '" value="'+ file.name +'" class="form-control file_val" />'
                            + '</td> <input type="hidden" name="file_size" value="'+plupload.formatSize(file.size)+'"/>'    
                            + '<td>' + plupload.formatSize(file.size) +''
                            + '</td> <td>'
                            + '<div class="progress sm"> '
                            + '<div class="progress-bar progress-bar-aqua" rel="'+ file.id +'"  role="progressbar"  aria-valuemin="0" aria-valuemax="100">'
                            + '</div></div></td>'
                            + '<td><a class="btn btn-danger btn-xs " href="javascript:;" onclick="removeThisFile(\''+ file.id +'\');"><i class="fa fa-times"></i>删除</a></td></tr>'
                        );
//                        $('#container').append('<input type="text" name="file_size" value="'+plupload.formatSize(file.size)+'"/>';
                    });

                    uploader.start();
                },
                FileUploaded: function(up, file, res) {
                    var rs = eval('(' + res.response +')');
                    if (rs.rs ==  'ok') {
                        console.log(up);
                        var html = '<div><input type="text" name="file_url" value="'+rs.fileurl+'" style="display:none;" ></div>';
                            html += '<div><input type="text" name="file_name" value="'+file.name+'" style="display:none;" ></div>';
                        $('#postid').append(html);
                        $('div[rel=' + file.id + ']').css('width', '100%');
                        $('#container').append('<input type="hidden" rel="'+file.id+'" name="resfiles[]" value="' + rs.aid + '" />');
                        $('input[name=nm_' + file.id +']').prop('name', 'newname['+rs.aid+']');
                        $('input[name=pid_' + file.id +']').prop('name', 'pid['+rs.aid+']');
                        $('input[name=level_' + file.id +']').prop('name', 'level['+rs.aid+']');
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
    function salary2(){
        var id = $('#approval_submit_show1').prop("id");
        var html = '<div style="text-align:center;font-weight:bold;font-size:2em;">';
            html += "<?php if($approval['Approval_url']['modify_filename']!==''){echo $approval['Approval_url']['modify_filename'];}else{echo $approval['Approval']['file_name'];}?> &nbsp;审批批注</div>";

        $('#approval_submit_show1').prepend(html);
        print_view(id);

    }

</script>


