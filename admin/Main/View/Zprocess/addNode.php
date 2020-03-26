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
            <form method="post" action="{:U('Zprocess/addNode')}" name="myform">
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
                                    <div class="form-group col-md-4">
                                        <label>工作事项：</label><input type="text" name="info[title]" class="form-control" value="{$list.title}" required />
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>流程类型：</label>
                                        <select  class="form-control"  name="info[processTypeId]"  required id="processTypeId">
                                            <option value="" selected disabled>请选择流程类型</option>
                                            <foreach name="types" key="k" item="v">
                                                <option value="{$k}" <?php if ($list['processTypeId'] == $k) echo "selected"; ?>>{$v}</option>
                                            </foreach>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>所属流程：</label>
                                        <select  class="form-control"  name="info[processId]" id="processId"  required>
                                            <option value="" selected disabled>请先选择流程类型</option>
                                            <foreach name="processIds" key="k" item="v">
                                                <option value="{$k}" <?php if ($list['processId'] == $k) echo "selected"; ?>>{$v}</option>
                                            </foreach>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>责任人职务：</label><input type="text" name="info[job]" class="form-control" value="{$list.job}" required />
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>责任人：</label><font color="#999">(点击匹配到的人员)</font>
                                        <input type="text" name="info[blame_name]" value="{$list['blame_name']}" class="form-control" placeholder="责任人" id="blame_name" required />
                                        <input type="hidden" name="info[blame_uid]" value="{$list['blame_uid']}" class="form-control" id="blame_uid" />
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>所需天数：</label><input type="text" name="info[day]" class="form-control" value="{$list.day}" required />
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>完成时点：</label><input type="text" name="info[time_data]" class="form-control" value="{$list.time_data}" required />
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>完成依据：</label><input type="text" name="info[OK_data]" class="form-control" value="{$list.OK_data}" required />
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>是否提前提醒：</label>
                                        <select  class="form-control"  name="info[before_remind]"  required>
                                            <option value="1">提醒</option>
                                            <option value="0">不提醒</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>是否超时提醒：</label>
                                        <select  class="form-control"  name="info[after_remind]"  required>
                                            <option value="1">提醒</option>
                                            <option value="0">不提醒</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>完成是否反馈：</label>
                                        <select  class="form-control"  name="info[ok_feedback]"  required>
                                            <option value="1">反馈</option>
                                            <option value="0">不反馈</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>反馈至人员：</label><font color="#999">(点击匹配到的人员)</font>
                                        <input type="text" name="info[feedback_name]" value="{$list['feedback_name']}" class="form-control" placeholder="反馈至人员" id="feedback_name" required />
                                        <input type="hidden" name="info[feedback_uid]" value="{$list['feedback_uid']}" class="form-control" id="feedback_uid" />
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label>备注：</label><textarea class="form-control"  name="info[remark]">{$list.remark}</textarea>
                                        <span id="contextTip"></span>
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
    const keywords = <?php echo $userkey; ?>;
    $(document).ready(function(e){
        autocomplete_id('blame_name','blame_uid',keywords);
        autocomplete_id('feedback_name','feedback_uid',keywords);
    })

    //二级联动 , 获取流程列表
    $('#processTypeId').change(function () {
        var typeId    = $(this).val();
        console.log(typeId);
        if (typeId){
            $.ajax({
                type : 'POST',
                url : "<?php echo U('Ajax/get_process'); ?>",
                dataType : 'JSON',
                data : {typeId:typeId},
                success : function (msg) {
                    console.log(msg);
                    $("#processId").empty();
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
                    $("#processId").append(b);
                }
            })
        }else{
            art_show_msg('省份信息错误',3);
        }
    })
</script>

