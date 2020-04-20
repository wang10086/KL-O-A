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
                                        <input type="text" name="info[blame_name]" value="{$list['blame_name']}" class="form-control" placeholder="责任人" id="blame_name" />
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
                                        <label>反馈至人员：</label>
                                        <input type="text" name="info[feedback_name]" value="{$list['feedback_name']}" class="form-control" />
                                        <!--<input type="hidden" name="info[feedback_uid]" value="{$list['feedback_uid']}" class="form-control" id="feedback_uid" />-->
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label>备注：</label><textarea class="form-control"  name="info[remark]">{$list.remark}</textarea>
                                        <span id="contextTip"></span>
                                    </div>
                                    <div class="form-group col-md-12"></div>

                                    <div class="form-group col-md-12">
                                        <P class="border-bottom-line"> 完成时点详情</P>
                                        <div class="form-group col-md-12" id="payment">
                                            <div class="userlist">
                                                <div class="unitbox_23">完成时点说明</div>
                                                <div class="unitbox_18">开始月份</div>
                                                <div class="unitbox_18">开始日期</div>
                                                <div class="unitbox_18">结束月份</div>
                                                <div class="unitbox_18">结束日期</div>
                                                <!--<div class="unitbox_25">备注</div>-->
                                            </div>
                                            <?php if($timeLists){ ?>
                                                <foreach name="timeLists" key="kk" item="pp">
                                                    <div class="userlist" id="pretium_8888{$pp.id}">
                                                        <span class="title"><?php echo $kk+1; ?></span>
                                                        <input type="hidden" name="payment[8888{$pp.id}][reset_id]" value="{$pp.id}">

                                                        <div class="f_23">
                                                            <input type="text" class="form-control" name="payment[8888{$pp.id}][title]" value="{$pp.title}">
                                                        </div>
                                                        <div class="f_18">
                                                            <select class="form-control" name="payment[8888{$pp.id}][st_month]">
                                                                <option value="">请选择</option>
                                                                <?php for ($i=1; $i<=12; $i++){ ?>
                                                                    <option value="{$i}" <?php if ($pp['st_month'] == $i) echo "selected"; ?>>{$i}月</option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="f_18">
                                                            <select class="form-control" name="payment[8888{$pp.id}][st_day]">
                                                                <option value="">请选择</option>
                                                                <?php for ($i=1; $i<=31; $i++){ ?>
                                                                    <option value="{$i}" <?php if ($pp['st_day'] == $i) echo "selected"; ?>>{$i}日</option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="f_18">
                                                            <select class="form-control" name="payment[8888{$pp.id}][et_month]">
                                                                <option value="">请选择</option>
                                                                <?php for ($i=1; $i<=12; $i++){ ?>
                                                                    <option value="{$i}" <?php if ($pp['et_month'] == $i) echo "selected"; ?>>{$i}月</option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="f_18">
                                                            <select class="form-control" name="payment[8888{$pp.id}][et_day]">
                                                                <option value="">请选择</option>
                                                                <?php for ($i=1; $i<=31; $i++){ ?>
                                                                    <option value="{$i}" <?php if ($pp['et_day'] == $i) echo "selected"; ?>>{$i}日</option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <!--<div class="f_25">
                                                            <input type="text" class="form-control" name="payment[8888{$pp.id}][remarks]" value="">
                                                        </div>-->

                                                        <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('pretium_8888{$pp.id}')">删除</a>

                                                    </div>
                                                </foreach>
                                            <?php }else{ ?>
                                                <div class="userlist" id="pretium_id">
                                                    <span class="title">1</span>
                                                    <!--<input type="hidden" name="payment[1][no]" class="payno" value="1">-->
                                                    <div class="f_23">
                                                        <input type="text" class="form-control" name="payment[1][title]" value="">
                                                    </div>
                                                    <div class="f_18">
                                                        <select class="form-control" name="payment[1][st_month]">
                                                            <option value="">请选择</option>
                                                            <?php for ($i=1; $i<=12; $i++){ ?>
                                                                <option value="{$i}">{$i}月</option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="f_18">
                                                        <select class="form-control" name="payment[1][st_day]">
                                                            <option value="">请选择</option>
                                                            <?php for ($i=1; $i<=31; $i++){ ?>
                                                                <option value="{$i}">{$i}日</option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="f_18">
                                                        <select class="form-control" name="payment[1][et_month]">
                                                            <option value="">请选择</option>
                                                            <?php for ($i=1; $i<=12; $i++){ ?>
                                                                <option value="{$i}">{$i}月</option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="f_18">
                                                        <select class="form-control" name="payment[1][et_day]">
                                                            <option value="">请选择</option>
                                                            <?php for ($i=1; $i<=31; $i++){ ?>
                                                                <option value="{$i}">{$i}日</option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <!--<div class="f_25">
                                                        <input type="text" class="form-control" name="payment[1][remarks]" value="">
                                                    </div>-->

                                                    <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('pretium_id')">删除</a>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <div id="payment_val">1</div>
                                        <div class="form-group col-md-12" id="useraddbtns">
                                            <a href="javascript:;" class="btn btn-success btn-sm" onClick="add_payment()"><i class="fa fa-fw fa-plus"></i> 增加时点数据</a>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <P class="border-bottom-line"> 反馈至人员详情</P>
                                        <div class="form-group col-md-12" id="user-container">
                                            <button type="button" class="user-box" onclick="javascript:select_all_user($(this))">
                                                全选
                                                <input type="hidden" id="all_user_type" value="1">
                                            </button>
                                            <foreach name="users" item="v">
                                                <button type="button" class="user-box <?php if (in_array($v['nickname'],$userNames)) echo "bg-light-blue"; ?>" onclick="javascript:select_user($(this))">
                                                    {$v.nickname}
                                                    <input type="hidden" <?php if (in_array($v['id'],$userIds)) echo "name='userids[]'"; ?> value="{$v.id}">
                                                </button>
                                            </foreach>
                                        </div>
                                        <div class="form-group">&nbsp;</div>
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
        //autocomplete_id('feedback_name','feedback_uid',keywords);
    })

    //二级联动 , 获取流程列表
    $('#processTypeId').change(function () {
        var typeId    = $(this).val();
        if (typeId){
            $.ajax({
                type : 'POST',
                url : "<?php echo U('Ajax/get_process'); ?>",
                dataType : 'JSON',
                data : {typeId:typeId},
                success : function (msg) {
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

    //编号
    function orderno(){
        $('#payment').find('.title').each(function(index, element) {
            $(this).text(parseInt(index)+1);
        });
        $('#payment').find('.payno').each(function(index, element) {
            $(this).val(parseInt(index)+1);
        });
    }

    //移除
    function delbox(obj){
        $('#'+obj).remove();
        orderno();
    }

    //新增
    function add_payment(){
        var i = parseInt($('#payment_val').text())+1;

        var html = '<div class="userlist" id="pretium_'+i+'">';
        html += '<span class="title"></span>';
        /*html += '<input type="hidden" name="payment['+i+'][no]" class="payno" value="">';*/
        html += '<div class="f_23"><input type="text" class="form-control" name="payment['+i+'][title]" value=""> </div>';
        html += '<div class="f_18"><select class="form-control" name="payment['+i+'][st_month]"> <option value="">请选择</option><?php for ($mm=1; $mm<=12; $mm++){ ?><option value="{$mm}">{$mm}月</option><?php } ?></select></div>';
        html += '<div class="f_18"><select class="form-control" name="payment['+i+'][st_day]"><option value="">请选择</option><?php for ($mm = 1; $mm <= 31; $mm++){ ?> <option value="{$mm}">{$mm}日</option><?php } ?></select></div>';
        html += '<div class="f_18"><select class="form-control" name="payment['+i+'][et_month]"><option value="">请选择</option><?php for ($mm = 1; $mm <= 12; $mm++){ ?><option value="{$mm}">{$mm}月</option><?php } ?></select></div>';
        html += '<div class="f_18"><select class="form-control" name="payment['+i+'][et_day]"><option value="">请选择</option><?php for ($mm = 1; $mm <= 31; $mm++){ ?><option value="{$mm}">{$mm}日</option><?php } ?></select></div>';
        html += '<a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox(\'pretium_'+i+'\')">删除</a>';
        html += '</div>';
        $('#payment').append(html);
        $('#payment_val').html(i);
        orderno();
        //relaydate();
    }

    function select_user(index) {
        let checkClassName = 'bg-light-blue';
        let thisClassName  = index.attr('class');
        let checked        = thisClassName.indexOf(checkClassName);
        if (checked === -1){ //未选中
            index.addClass(checkClassName);
            index.find('input').attr('name','userids[]')
        }else{
            index.removeClass(checkClassName);
            index.find('input').attr('name','')
        }
    }

    //全选
    function select_all_user(index) {
        let checkClassName = 'bg-light-blue';
        let allUserType    = $('#all_user_type').val();
        if (allUserType == 1){ //全选
            $('#all_user_type').val(0);
            $('#user-container').find('.user-box').each(function () {
                let input_id       = $(this).find('input').attr('id');
                if (input_id != 'all_user_type'){
                    $(this).addClass(checkClassName);
                    $(this).find('input').attr('name','userids[]')
                }else{
                    $(this).addClass(checkClassName);
                }
            })
        }else{
            $('#all_user_type').val(1);
            $('#user-container').find('.user-box').each(function () {
                let input_id       = $(this).find('input').attr('id');
                if (input_id != 'all_user_type'){
                    $(this).removeClass(checkClassName);
                    $(this).find('input').attr('name','')
                }else{
                    $(this).removeClass(checkClassName);
                }
            })
        }
    }
</script>

