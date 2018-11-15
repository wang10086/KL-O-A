<include file="Index:header2" />
<style>
    .file {
        position: relative;
        display: inline-block;
        background: #D0EEFF;
        border: 1px solid #99D3F5;
        border-radius: 4px;
        padding: 8px 15px;
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
            <section class="content">

                <div class="row">
                    <div class="col-xs-12" style="width: 120em;">
                        <div class="box">
                            <div class="box-header">
                                <div class="tip" style="padding: 5px 12px;">
                                    <form method="post" action="{:U('Approval/Approval_file')}" enctype="multipart/form-data">
                                        <a href="javascript:;" class="file" style="float:left;background-color:#00acd6;color:#FFFFFF;"><i class="fa fa-upload"></i> 上传修改后文件
                                            <input type="file" name="file" id="approval_file">
                                            <input type="hidden" name="user_id" value="{$id}">
                                            <input type="hidden" name="style" value="1">
                                        </a>
                                        <button type="submit" style="float:left;width:6em;height:2.4em;background-color:#00acd6;border-radius:6px;font-size:1.2em;color:#ffffff;margin-left:1em;margin-top:-0.1em;line-height:0em;">保 存</button>
                                    </form>
                                </div>
                            </div><!-- /.box-header -->
                            <foreach name="approval_file" item="f">
                                <div class="box-body">

                                    <!-- 文件信息-->
                                    <table class="table table-bordered">
                                        <tr class="orders" style="text-align:center;">
                                            <th class="sorting" style="text-align:center;width:6em;"><b>ID</b></th>
                                            <th class="sorting" style="text-align:center;width:10em;"><b>上传者</b></th>
                                            <th class="sorting" style="text-align:center;width:10em;"><b>文件名称</b></th>
                                            <th class="sorting" style="text-align:center;width:10em;"><b>文件大小</b></th>
                                            <th class="sorting" style="text-align:center;width:10em;"><b>文件格式</b></th>
                                            <th class="sorting" style="text-align:center;width:10em;"><b>上传时间</b></th>
                                            <th class="sorting" style="text-align:center;width:10em;"><b>修改后文件名称</b></th>
                                            <th class="sorting" style="text-align:center;width:10em;"><b>修改后文件大小</b></th>
                                            <th class="sorting" style="text-align:center;width:10em;"><b>修改后文件格式</b></th>
                                            <th class="sorting" style="text-align:center;width:10em;"><b>修改人姓名</b></th>
                                            <th class="sorting" style="text-align:center;width:10em;"><b>修改时间</b></th>
                                        </tr>

                                        <tr style="text-align:center;">
                                            <td >{$f['file']['id']}</td>
                                            <td>{$f['file']['account_name']}</td>
                                            <td>
                                                <a href="{$f['file']['file_url']}">
                                                    <?php if(!empty($f['file']['file_name']) && !empty($f['file']['file_format'])){echo $f['file']['file_name'].'.'.$f['file']['file_format'];}?>
                                                </a>
                                            </td>
                                            <td>{$f['file']['file_size']}</td>
                                            <td>{$f['file']['file_format']}</td>
                                            <td><?php if(!empty($f['file']['createtime'])){echo date('Y-m-d H:i:s',$f['file']['createtime']);}?></td>
                                            <td style="text-align:center;">
                                                <a href="{$f['flie_update']['file_url']}">
                                                    <?php if(!empty($f['flie_update']['file_name']) && !empty($f['flie_update']['file_format'])){echo $f['flie_update']['file_name'].'.'.$f['flie_update']['file_format'];}?>
                                                </a>
                                            </td>
                                            <td>{$f['flie_update']['file_size']}</td>
                                            <td>{$f['flie_update']['file_format']}</td>
                                            <td style="text-align:center;">{$f['flie_update']['account_name']}</td>
                                            <td style="text-align:center;">
                                                <?php if(!empty($f['flie_update']['update_time'])){echo date('Y-m-d H:i:s',$f['flie_update']['update_time']);}?>
                                            </td>
                                        </tr>
                                    </table><br><br>

                                    <!-- 已选审批人员  已审批人员-->
                                    <div class="box-header">
                                        <div class="form-group  col-md-6" >
                                            <label>
                                                <b style="font-size:1.3em;color:#09F;padding:2em;letter-spacing:0.2em;">已选审批人员 : </b>
                                            </label><br><br>
                                            <div style="margin-left:5em;">
                                                <foreach name="f['file']['user']" item="n">
                                                    <span style="padding:1em;">
                                                        <b>
                                                            {$n['username']}
                                                            <b style="<?php if($n['status']==0){echo 'color:red';}elseif($n['status']>0){echo 'color:#00CC33';}?>">
                                                                [ <?php if($n['status']==0){echo "未批注";}elseif($n['status']>0){echo "已批注";}?> ]
                                                            </b>
                                                        </b>
                                                    </span>
                                                </foreach>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>
                                                <b style="font-size:1.3em;color:#09F;padding:2em;letter-spacing:0.2em;">最终审核人员 : </b>
                                            </label><br><br>
                                            <div style="margin-left:5em;">

                                                <span style="padding:1em;">
                                                    <b>
                                                        {$f['file']['file_leader_name']}
                                                        <b style="<?php if($f['file']['file_leader_status']==0){echo 'color:red';}elseif($f['file']['file_leader_status']==1|| $f['file']['file_leader_status']==2){echo 'color:red';}elseif($f['file']['file_leader_status']==3){echo 'color:#00CC33';}elseif($f['file']['file_leader_status']==4){echo 'color:red';}?>">
                                                            [ <?php if($f['file']['file_leader_status']==0){echo "未批注";}elseif($f['file']['file_leader_status']==1 || $f['file']['file_leader_status']==2){echo "已批注";}elseif($f['file']['file_leader_status']==3){echo "已批准";}elseif($f['file']['file_leader_status']==4){echo "审批未通过";}?> ]
                                                        </b>
                                                    </b>
                                                </span>

                                            </div>
                                        </div>
                                    </div><br><br>

                                    <!-- 文件 和 批注信息-->
                                    <div class="box-header" style="width: 117em;">
                                        <div class="form-group col-md-6">
                                            <label>
                                                <b style="font-size:1.3em;color:#09F;letter-spacing:0.2em;">上传文件 : </b>
                                            </label><br><br>
                                            <div style="width:65em;height:83em;overflow: hidden;border:solid 2px #d2d5d8;">
                                                <iframe src="https://view.officeapps.live.com/op/view.aspx?src={$url}" style="overflow-y:scroll;overflow-x:scroll;word-wrap:break-word;margin-top:-6em;width:65em;height:92em;">
                                                </iframe>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6" style="float:right;width:50em;">
                                            <label>
                                                <b style="font-size:1.3em;color:#09F;padding:1em;letter-spacing:0.2em;">批注内容 : </b>
                                                <b style="margin-left:20em;" id="approval_submit_show">
                                                    <input type="submit" value="添加审批批注" class="btn btn-info"  style="margin-right:1em;">
                                                </b>
                                                <b style="margin-left:20em;display:none;"id="approval_submit_hidden1">
                                                    <input type="submit" value="提交审批批注" class="btn btn-info"   style="margin-right:1em;">
                                                </b>
                                            </label><br><br>

                                            <div  id="approval_submit_show1" style="margin:-0.6em 0em 0em;padding:1em;height:83em;border:solid 2px #d2d5d8;overflow-y:scroll;overflow-x:scroll;word-wrap:break-word;width:45em;" >
                                                <foreach name="f['flie_annotation']" item="ann">
                                                    <p>
                                                        <b style="color:#339933;">{$ann['account_name']}&nbsp;</b>
                                                        <span>[ <?php echo date('Y-m-d H:i:s',$ann['createtime']);?> ]</span>
                                                        <span style="color:#CC3333">[ 批注 ] ：</span>

                                                            <span style="letter-spacing:0.1em;line-height:2em;text-indent:25px">
                                                                {$ann['annotation_content']}
                                                            </span>

                                                    </p>
                                                </foreach>
                                            </div>

                                            <textarea style="margin:-0.6em 0em 0em 0em;padding:1em;height:83em;border:solid 2px #d2d5d8;overflow-y:scroll;overflow-x:scroll;word-wrap:break-word;width:45em;display:none;text-indent:2.5em;line-height:2em;letter-spacing:0.1em;"  name="comment">
                                            </textarea>

                                        </div>
                                    </div><br>
                                    <div style="text-align: center;">
                                            <?php if($_SESSION['userid'] == $approval_file[0]['file']['file_leader_id'] && $approval_file[0]['file']['status']==2){?>
                                        <input type="submit" value="审批通过" class="btn btn-info "  onclick="approval_update_file(1)" style="margin-right:1em;">
                                        <input type="submit" value="审批驳回" class="btn btn-info"   onclick="approval_update_file(2)" style="margin-right:1em;">
                                            <?php }?>
                                        <?php if($_SESSION['userid'] == $approval_file[0]['file']['account_id'] &&  $approval_file[0]['file']['status']==4){?>
                                        <input type="submit" value="提交批注修改" class="btn btn-info"   onclick="approval_update_file(3)" style="margin-right:1em;">
                                            <?php }?>

                                    </div>
                                </div>
                            </foreach>
                        </div><!-- /.box -->

                    </div><!-- /.col -->
                 </div>

            </section><!-- /.content -->
        </aside><!-- /.right-side -->


<include file="Index:footer2" />
<script>

    $('#approval_submit_show').click(function(){ //点击 ‘添加审批批注’ 效果隐藏显示
        $(this).hide();
        $('textarea').show();
        $('#approval_submit_show1').hide();
        $('#approval_submit_hidden1').show();
    });

    $('#approval_submit_hidden1').click(function(){ //添加批注信息
        var text    = $('textarea').val().replace(/\n|\r\n/g,'<br/>');
        var file_id = "<?php echo $id;?>";
        $.ajax({
            url:"{:U('Ajax/Ajax_approval_textarea')}",
            type:"POST",
            data:{'text':text,'file_id':file_id},
            dataType:"json",
            success:function(date){
                if(date.sum==1){
                    alert(date.msg);
                }else{
                    alert(date.msg);
                }
            }
        });
    });


    //审批obj  1通过 2驳回 3 修改
    function approval_update_file(obj) {

        var file_id = "<?php echo $id;?>";

        $.ajax({
            url:"{:U('Ajax/Ajax_approval_flie')}",
            type:"POST",
            data:{'type':obj,'file_id':file_id},
            dataType:"json",
            success:function(date){
                if(date.sum==1){
                    alert(date.msg);
                }else{
                    alert(date.msg);
                }
            }
        });

    }

</script>


