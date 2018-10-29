<include file="Index:header2" />
<style>
    .file {
        position: relative;
        display: inline-block;
        background: #D0EEFF;
        border: 1px solid #99D3F5;
        border-radius: 4px;
        padding: 4px 12px;
        overflow: hidden;
        color: #1E88C7;
        text-decoration: none;
        text-indent: 0;
        line-height: 20px;
    }
    .file input {
        position: absolute;
        font-size: 100px;
        right: 0;
        top: 0;
        opacity: 0;
    }
    .file:hover {
        background: #AADFFD;
        border-color: #78C3F3;
        color: #004974;
        text-decoration: none;
    }
</style>
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
                <div class="content ">
                    <div class="col-md-12 mt10" id="Approvel_uploadtid" >
                        <lebal class="upload-lebal">选择审批人<span></span></lebal>
                        <form method="post" action="{:U('Approval/Approval_file')}" enctype="multipart/form-data">
                        <foreach name="personnel" item="v">
                            <a style=" width:10em; display: inline-block;" class="{$v.id}">
                                <input type="checkbox" value="{$v.id}" name="user_id[]" checkbox="">
                                &nbsp;{$v.nickname}</a>
                        </foreach>
                    </div>

                    <div class="col-md-12 mt10" style=" vertical-align:text-top;">
                        <lebal class="upload-lebal">文件类型</lebal><br>
<!--                        <a href="javascript:;" id="approval_file" class="btn btn-success btn-sm" style="margin-top:15px; float:left;">-->
<!--                            <i class="fa fa-upload"></i> 选择文件-->
<!--                        </a>-->
                        <a href="javascript:;" class="file" style="float:left;background-color:#008d4c;color:#FFFFFF;"><i class="fa fa-upload"></i> 选择文件
                            <input type="file" name="file" id="approval_file">
                        </a>
                        <span style="line-height:30px; float:left;margin-left:15px; color:#999999;">请选择小于100M的文件，支持JPG / GIF / PNG / DOC / XLS / PDF / ZIP / RAR文件类型</span>
                    </div>
                    <div class="form-group col-md-12">

                        <table id="flist" class="table" style="margin-top:15px; float:left; clear:both; border-top:1px solid #dedede;">
                            <tr>
                                <th align="left" width="30%">文件名称</th>
                                <th align="left" width="20%">文件格式</th>
                                <th align="left" width="20%">大小</th>
                                <th align="left" width="30%">上传时间</th>
                            </tr>
                            <foreach name="cooki" item="c">
                                <tr>
                                    <td align="left" width="30%"><?php if(!empty($c['3']) && !empty($c['2'])){echo $c['3'].'.'.$c['2'];}?></td>
                                    <td align="left" width="20%">{$c['2']}</td>
                                    <td align="left" width="20%">{$c['1']}</td>
                                    <td align="left" width="30%"><?php if(!empty($c['0'])){echo date('Y-m-d H:i:s',$c['0']);}?></td>
                                </tr>
                            </foreach>
                        </table>
                       
                    </div>
                    <div id="formsbtn">
                        <button type="submit" id="approval_file_upload" style="color:#FFFFFF;width:5em;height:2em;background-color:#008d4c;font-size:1.5em;border-radius:7px;">保 存</button>
                    </div>
                </div>
                </form>
                </div>
            </div>
        </div>
        </section>

</aside>

        <include file="Index:footer" />

        