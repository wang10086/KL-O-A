<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h3>增加课程信息</h3>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Op/index')}"><i class="fa fa-gift"></i> 项目计划</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                <form method="post" action="{:U('Project/lession_add')}" name="myform" id="myform">
                <input type="hidden" name="dosubmint" value="1">
                <input type="hidden" name="id" value="{$row.id}">
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">

                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">课程信息</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                    	
                                        <div class="form-group col-md-4">
                                            <label>课程名称：</label><input type="text" name="info[name]" class="form-control" value="{$row.name}" required />
                                        </div>

                                        
                                        <div class="form-group col-md-4">
                                            <label>项目类型：</label>
                                            <select  class="form-control"  name="info[kind_id]" onchange="check_field();check_type()" id="k_id" required>
                                                <option value="" selected disabled>请选择项目类型</option>
                                                <foreach name="kinds" item="v">
                                                    <option value="{$v.id}" <?php if ($row && ($v['id'] == $row['kind_id'])) echo ' selected'; ?> >{:tree_pad($v['level'], true)} {$v.name}</option>
                                                </foreach>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>学科领域：</label>
                                            <select  class="form-control"  name="info[field_id]" onchange="check_type()" id="field">
                                                <if condition="$row[field_id]">
                                                    <option value="{$row.field_id}" >{$row.field}</option>
                                                    <else />
                                                    <option value="" selected disabled>请选择学科领域</option>
                                                </if>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>学科分类：</label>
                                            <!--<select  class="form-control"  name="info[field_id]" onfocus="check_type()" id="type">-->
                                            <select  class="form-control"  name="info[type_id]"  id="type">
                                                <if condition="$row['type_id']">
                                                    <option value="{$row.type_id}" >{$row.type}</option>
                                                    <else />
                                                    <option value="" selected disabled>请选择学科分类</option>
                                                </if>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>课时：</label><input type="text" name="info[les_hours]" class="form-control" value="{$row.les_hours}" />
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>课程类型：</label>
                                            <select  name="info[les_type]" class="form-control">
                                                <option value="" selected disabled>请选择课程类型</option>
                                                <foreach name="les_types" key="k"  item="v">
                                                    <option value="{$k}" <?php if ($row && ($k == $row['les_type'])) echo ' selected'; ?>>{$v}</option>
                                                </foreach>
                                            </select>
                                        </div>
                                       
                                    </div>
                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">上传附件</h3>

                                </div>
                                <div class="box-body">
                                    <div class="content">
                                        <div class="form-group col-md-12">
                                            <table id="flist" class="table" style="margin-top:10px;">
                                                <tr>
                                                    <th align="left" width="45%">文件名称</th>
                                                    <th align="left" width="10%">大小</th>
                                                    <th align="left" width="30%">上传进度</th>
                                                    <th align="left" width="15%">操作</th>
                                                </tr>
                                                <foreach name="atts" item="v">
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
                                                <foreach name="atts" item="v">
                                                    <input type="hidden" rel="aid_{$v.id}" name="resfiles[]" value="{$v.id}" />
                                                </foreach>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                           
                            <div style="width:100%; text-align:center;">
                            <button type="submit" class="btn btn-info btn-lg" id="lrpd">确认添加</button>
                            </div>
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                    </form>
                </section><!-- /.content -->
                
            </aside><!-- /.right-side -->
			
  </div>
</div>

<include file="Index:footer2" />

<script type="text/javascript">
    /*学科领域*/
    function check_field(){
        var kid = $('#k_id').val();
        $.ajax({
            type:"POST",
            url:"{:U('Ajax/fields')}",
            data:{id:kid},
            success:function(msg){
                if(msg){
                    $("#field").empty();
                    var count = msg.length;
                    var i= 0;
                    var b="";
                    b+='<option value="" disabled selected>请选择学科领域</option>';
                    for(i=0;i<count;i++){
                        b+="<option value='"+msg[i].id+"'>"+msg[i].fname+"</option>";
                    }
                    $("#field").append(b);
                }else{
                    $("#field").empty();
                    var b='<option value="" disabled selected>无学科领域信息</option>';
                    $("#field").append(b);
                }

            }
        })
    }

    /*学科分类*/
    function check_type(){
        var kid = $("#k_id").val();
        var fid = $("#field").val();
        $.ajax({
            type:"POST",
            url:"{:U('Ajax/types')}",
            data:{kid:kid,fid:fid},
            success:function(msg){
                console.log(msg);
                if(msg){
                    $("#type").empty();
                    var count = msg.length;
                    var i= 0;
                    var b="";
                    b+='<option value="" disabled selected>请选择学科分类</option>';
                    for(i=0;i<count;i++){
                        b+="<option value='"+msg[i].id+"'>"+msg[i].tname+"</option>";
                    }
                    $("#type").append(b);
                }else{
                    $("#type").empty();
                    var b='<option value="" disabled selected>无学科分类信息</option>';
                    $("#type").append(b);
                }

            }
        })

    }
</script>

<script type="text/javascript">

    $(document).ready(function(e) {
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
                max_file_size : '60mb',
                mime_types: [
                    {title : "Files", extensions : "jpg,jpeg,png,zip,rar,7z,doc,docx,ppt,pptx,xls,xlsx,txt"}
                ]
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
                            '<tr id="' + file.id + '"  valign="middle"><td>'
                            + '<input type="text" name="nm_' + file.id + '" value="'+ file.name +'" class="form-control" />'
                            + '</td> <td width="10%">' + plupload.formatSize(file.size) +''
                            + '</td> <td width="30%">'
                            + '<div class="progress sm"> '
                            + '<div class="progress-bar progress-bar-aqua" rel="'+ file.id +'"  role="progressbar"  aria-valuemin="0" aria-valuemax="100">'
                            + '</div></div></td>'
                            + '<td width="15%"><a class="btn btn-danger btn-xs " href="javascript:;" onclick="removeThisFile(\''+ file.id +'\');"><i class="fa fa-times"></i>删除</a></td></tr>'
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

        closebtns();
    });

    function removeThisFile(fid) {
        if (confirm('确定要删除此附件吗？')) {
            $('#' + fid).empty().remove();
            $('input[rel=' + fid +']').remove();
        }
    }


</script>