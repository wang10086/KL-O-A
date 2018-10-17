<include file="Index:header2" />

<aside class="right-side">
    <section class="content-header">
        <h1>文件管理</h1>
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
                <form method="post" action="{:U('Files/savefile')}" name="myform" id="myform">
                    <input type="hidden" name="pid" value="{$pid}">
                    <input type="hidden" name="level" value="{$level}">
                <div class="content ">
                    <div class="col-md-12 mt10" id="Approvel_uploadtid" >
                        <lebal class="upload-lebal">选择审批人<span></span></lebal>

                        <foreach name="personnel" item="v">
                            <a style="padding:1em;"><input type="checkbox" value="{$v.id}" name="department[]"> &nbsp;{$v.nickname}</a>
                        </foreach>
                    </div>

                    <div class="col-md-12 mt10" id="Approvel_upload_postid">

                    </div>
                    <div class="col-md-12 mt10" style=" vertical-align:text-top;">
                        <lebal class="upload-lebal">文件类型</lebal>
                        <foreach name="file_tag" key="k" item="v">
                            <span class="lebal-span"  ><input type="radio" value="{$k}" name="file_tag"> &nbsp;{$v}</span>
                        </foreach>
                    </div>

                    <div class="form-group col-md-12"></div>
                    <div class="form-group col-md-12">
                        <a href="javascript:;" id="pickupfile" class="btn btn-success btn-sm" style="margin-top:15px; float:left;"><i class="fa fa-upload"></i> 选择文件</a>
                        <span style="line-height:30px; float:left;margin-left:15px; margin-top:15px; color:#999999;">请选择小于100M的文件，支持JPG / GIF / PNG / DOC / XLS / PDF / ZIP / RAR文件类型</span>

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

            var html ='';
            html += '<lebal class="upload-lebal">已选审批人<span></span></lebal>';
            $('#Approvel_uploadtid a').on('ifChecked', function() {
                $('#Approvel_uploadtid a').each(function(){
                        var  check = $(this).find('.checked');
                        if(check !=="checked"){
                            html += $(this).html();
                        }
                        alert(check);
                    });
//                html += $(this).html();
                console.log(html);
//                html += $(this).html();
                $('#Approvel_upload_postid').html(html);
            });



   </script>
        