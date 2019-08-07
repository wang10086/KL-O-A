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
                                        <th class="sorting" style="text-align:center;width:6em;"><b>拟稿人</b></th>
                                        <th class="sorting" style="text-align:center;width:15em;"><b>文件名称</b></th>
                                        <th class="sorting" style="text-align:center;width:6em;"><b>文件大小</b></th>
                                        <th class="sorting" style="text-align:center;width:10em;"><b>上传时间</b></th>
                                        <th class="sorting" style="text-align:center;width:6em;"><b>审批天数</b></th>
                                    </tr>

                                    <foreach name="list[1]" item="l">
                                        <tr style="text-align:center;">
                                            <td>{$l['id']}</td>
                                            <td>{$list[0]['account_name']}</td>
                                            <p style="display:none;" id="{$l['id']}">{$l['file_url']}</p>
                                            <td> <a href="javascript:;" onclick="file_book_look({$l['id']})"><?php echo $l['file_name'];?></a></td>
                                            <td>{$l['file_size']}</td>

                                            <td><?php if(is_numeric($l['createtime'])){echo date('Y-m-d H:i:s',$l['createtime']);}else{echo'';}?></td>
                                            <td >{$list[0]['file_date']}</td>
                                        </tr>
                                    </foreach>
                                </table><br><br><br>


                                <!-- 选择审批人员  选择审批人员  -->
                                <if condition="rolemenu(array('Approval/add_final_judgment'))">
                                <div style="margin:-4em 0em 0em 2em;width:96%;<?php if($annotation[0]['statu']!==2){ echo 'display:none;';}?>" id="add_final_judgment">
                                    <form method="post" action="{:U('Approval/add_final_judgment')}" enctype="multipart/form-data">
                                        <input type="hidden" name="file_id" value="{$list[0]['id']}">
                                        <div class="box-header">
                                            <div class="form-group  col-md-6" >
                                                <label>
                                                    <b style="font-size:1.3em;color:#09F;letter-spacing:0.2em;">选择审议人员 : </b>
                                                </label><br>
                                                <foreach name="approver" item="app">
                                                    <label style="margin-left:2em;" class="col-md-3">
                                                        <b><input type="checkbox" name="consider[]" value="{$app['id']}">
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
                                    </form><br><br>
                                    <div class="box-header" ></div>
                                </div><br>
                                </if>


                                <!-- 已选审批人员  已审批人员-->
                                <div  style="width:96%;<?php if($status==1){ echo 'margin:-4em 0em 0em -1.5em;';}?>" >
                                    <div class="form-group  col-md-6" >
                                        <label>
                                            <b style="font-size:1.3em;color:#09F;padding:2em;letter-spacing:0.2em;">已选审议状态 : </b>
                                        </label><br><br>
                                        <div style="margin-left:5em;">
                                            <foreach name="judgment[1]" item="con">
                                                <span style="padding:1em;">
                                                    <b>
                                                        {$con['name']}
                                                        <b style="<?php if($con['status']==1){echo 'color:#00CC33';}else{echo 'color:red';}?>">
                                                             [ <?php if($con['status']==1){echo "已批注";}else{echo "未批注";}?> ]
                                                        </b>
                                                    </b>
                                                </span>
                                            </foreach><br><br>
                                            <if condition="rolemenu(array('Approval/add_final_judgment'))">
                                            <span style="<?php if($_SESSION['userid']==13 || $_SESSION['userid']==1){}else{echo 'display:none;';}?>">
                                                <b class="btn btn-success btn-sm add_final_judgment1" style="width:8em;font-size:1em;margin-left:1.7em;"> 修改审议人员</b>
                                            </span>
                                            </if>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>
                                            <b style="font-size:1.3em;color:#09F;padding:2em;letter-spacing:0.2em;">最终审核状态 : </b>
                                        </label><br><br>
                                        <div style="margin-left:5em;">
                                            <foreach name="judgment[0]" item="ju">
                                                <span style="padding:1em;">
                                                    <b>
                                                        {$ju['name']}
                                                        <b style="<?php if($ju['status']==1){echo 'color:#00CC33';}else{echo 'color:red';}?>" >
                                                            [ <?php if($ju['status']==1){echo "已批注";}else{echo "未批注";}?> ]
                                                        </b>
                                                    </b>
                                                </span>
                                            </foreach><br><br>
                                            <if condition="rolemenu(array('Approval/add_final_judgment'))">
                                            <span style="<?php if($_SESSION['userid']==13 || $_SESSION['userid']==1){}else{echo 'display:none;';}?>">
                                                <b class="btn btn-success btn-sm add_final_judgment1" style="width:8em;font-size:1em;margin-left:1.7em;"> 修改审核人员</b>
                                            </span>
                                            </if>
                                        </div><br><br>
                                    </div>

                                </div><br><br><br><br><br><br><br>
                                <table style="margin-left:2em;width:96%;"  class="table">
                                    <th width=""></th>
                                </table>

                                <!-- 文件 和 批注信息-->
                                <div style="width:96%;margin-left:2em;" >
                                    <div style="float:left;width:68%;overflow-y:scroll;overflow-y:visible;">
                                        <label>
                                            <b style="font-size:1.3em;color:#09F;letter-spacing:0.2em;">上传文件 : </b>
                                        </label><br><br>
                                        <div style="height:90em;overflow: hidden;border-top:solid 2px #d2d5d8;" id="file_book_look1">
                                          <iframe src="https://view.officeapps.live.com/op/view.aspx?src={$sercer}{$list[1][0]['file_url']}" style="overflow-y:scroll;overflow-x:scroll;word-wrap:break-word;width:100%;height:100%;overflow-x:hidden;margin-top:-6em;">
                                            </iframe>
                                        </div>
                                    </div>

                                    <div style="float:right;width:30%;" >
                                        <label>
                                            <b style="font-size:1.3em;color:#09F;padding:1em;letter-spacing:0.2em;">批注内容 : </b>
                                            <a class="btn btn-default" onclick="salary2();" style="margin-top: -1em;color:#000000;background-color: lightgrey;"><i class="fa fa-print"></i> 打印</a>
                                        </label><br><br>

                                        <div style="padding:1em;height:84em;border:solid 2px #d2d5d8;overflow-y:scroll;overflow-x:scroll;word-wrap:break-word;" >
                                            <foreach name="annotation" item="ann">
                                                <p>
                                                    <b style="color:#339933;"><?php echo $ann['username'];?>&nbsp;</b>
                                                    <span>[ <?php echo date('Y-m-d H:i:s',$ann['createtime']);?> ]</span>
                                                    <span style="color:#CC3333">[ 批注 ] ：</span>
                                                    <span style="letter-spacing:0.1em;line-height:2em;text-indent:50px;">
                                                        {$ann['annotation']}
                                                    </span>
                                                </p>
                                            </foreach>
                                        </div>
                                    </div>
                                </div><br>
                                <div style="text-align:center;width:96%;<?php if($statu!==1){echo 'display:none;';}?>">
                                    <form method="post" action="{:U('Approval/add_annotation')}" enctype="multipart/form-data">
                                        <input type="hidden" name="file_id" value="{$list[0]['id']}">
                                         <textarea style="margin:2em -4em 2em 0em;padding:1em;height: 15em;border:solid 2px #d2d5d8;overflow-y:scroll;overflow-x:scroll;word-wrap:break-word;width:100%;text-indent:2.5em;line-height:2em;letter-spacing:0.1em;"  name="comment">
                                            </textarea>
                                        <input type="submit" value="同意" name="status" class="btn btn-info"  style="margin-right:1em;">
                                        <input type="submit" value="不同意" name="status" class="btn btn-info"  style="margin-right:1em;">
                                    </form>
                                </div>
                            </div>
                        </div><!-- /.box -->

                            <!--             打印页面           -->
                        <div  id="approval_submit_show1" style="display:none;">
                            <table class="table table-bordered" style="margin:2em auto;width:96%;border:1px solid #000000;font-size:2em;" >
                                <tr>
                                    <th style="width:10em;letter-spacing:0.1em;border:1px solid #000000;font-size:0.8em;text-align:center;"><b>文件名称</b></th>
                                    <th colspan="5" style="width:10em;letter-spacing:0.2em;border:1px solid #000000;font-size:0.8em;text-align:center;">{$printing['file_name']}</th>
                                </tr>
                                <tr style=";border:1px solid #000000;font-size:0.8em;">
                                    <th style="width:10em;letter-spacing:0.1em;border:1px solid #000000;font-size:0.8em;text-align:center;"><b>起草部门</b></th>
                                    <th style="width:10em;letter-spacing:0.2em;border:1px solid #000000;font-size:0.8em;text-align:center;">{$printing['file_department']}</th>
                                    <th style="width:10em;border:1px solid #000000;font-size:0.8em;text-align:center;"><b>拟稿人</b></th>
                                    <th style="width:10em;letter-spacing:0.2em;border:1px solid #000000;font-size:0.8em;text-align:center;">{$printing['file_username']}</th>
                                    <th style="width:10em;letter-spacing:0.1em;border:1px solid #000000;font-size:0.8em;text-align:center;"><b>新编/修改</b></th>
                                    <th style="width:10em;letter-spacing:0.2em;border:1px solid #000000;font-size:0.8em;text-align:center;">新建</th>
                                </tr>
                                <tr style="letter-spacing:0.1em;border:1px solid #000000;font-size:0.8em;">
                                    <th style="width:10em;text-align:center;letter-spacing:0.1em;border:1px solid #000000;font-size:0.8em;"><b>发放范围</b></th>
                                    <th colspan="5" style="text-align:center;letter-spacing:0.2em;border:1px solid #000000;font-size:0.8em;">公司各部门、经理办公室成员</th>

                                </tr>
                                <tr>
                                    <th style="letter-spacing:0.1em;border:1px solid #000000;font-size:0.8em;text-align:center;"><b>相关人员修改意见</b></th>
                                    <th colspan="5" style="letter-spacing:0.1em;border:1px solid #000000;font-size:0.8em;">
                                        <p style="text-align:center;margin-bottom:2em;"><b>请经理办公室会扩大会成员及各业务中心（项目部）负责人阅，提出建设性意见。</b></p>
                                        <div style="height:60em;">
                                        <foreach name="annotation" item="an">
                                            <?php if($an['type']<4){?>
                                            <p>
                                                <b style="color:#339933;;"><?php echo $an['username'];?>&nbsp;</b>
                                                <span>[ <?php echo date('Y-m-d H:i:s',$an['createtime']);?> ]</span>
                                                <span style="letter-spacing:0.1em;line-height:2em;text-indent:50px;">
                                                     <?php echo $an['annotation'];?>
                                                 </span>
                                            </p>
                                            <?php }?>
                                        </foreach>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th style="text-align:center;letter-spacing:0.1em;border:1px solid #000000;font-size:0.8em;"><b>文件批准</b></th>
                                    <th colspan="5" style="letter-spacing:0.1em;border:1px solid #000000;font-size:0.8em;">
                                        <foreach name="annotation" item="a">
                                            <?php if($a['type']==4){?>
                                                <p>
                                                    <?php echo $a['annotation'];?>
                                                </p>
                                                <p style="float: right;letter-spacing:0.2em;">
                                                    <span style="padding-right:2em;"><?php echo $a['username'];?></span><br>

                                                    <span style=";padding-right: 2em;"><?php echo date('Y年m月d日',$a['createtime']);?></span>
                                                </p>
                                            <?php }?>
                                        </foreach>
                                    </th>
                                </tr>

                            </table>
                        </div>

                    </div><!-- /.col -->
                 </div>

            </section><!-- /.content -->
        </aside><!-- /.right-side -->


<include file="Index:footer2" />
<script>


    function salary2(){
        $('#approval_submit_show1').show();
        var id = $('#approval_submit_show1').prop("id");
        var html = '<div style="text-align:center;font-weight:bold;font-size:4em;">';
            html += "<?php echo $file['file_primary'];?> &nbsp;文件审批单</div><br><br>";
        $('#approval_submit_show1').prepend(html);
        print_view(id);
    }
    $('.add_final_judgment1').click(function(){
        $('#add_final_judgment').toggle();
    });
    function file_book_look(id){
        var url = $('#'+id).text();
        var curl = 'https://view.officeapps.live.com/op/view.aspx?src=<?php echo $sercer;?>'+url;
        $('#file_book_look1 iframe').attr("src",curl);
    }

</script>


