<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{$_pagetitle_}</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Rbac/index')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">

                            <include file="Cour:cour_navigate" />

                            <div class="box box-success mt20">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                        <form action="{:U('Cour/public_save_process')}" method="post">
                                            <input type="hidden" name="dosubmint" value="1">
                                            <input type="hidden" name="saveType" value="3">
                                        <div class="form-group col-md-12">
                                            <label>培训标题：</label>
                                            <input type="hidden" name="info[title]" id="title" value="{$list.title}">
                                            <select class="form-control" name="info[plan_id]" onchange="get_plan_data($(this).val())">
                                                <option value="" selected disabled>==请选择==</option>
                                                <foreach name="pro_need_lists" item="v">
                                                    <option value="{$v.id}">{$v.title}</option>
                                                </foreach>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>培训负责人：</label><font color="#999">(点击匹配到的人员)</font>
                                            <input type="text" name="info[blame_name]" value="{$list['blame_name']}" class="form-control" placeholder="培训负责人" id="blame_name" readonly />
                                            <input type="hidden" name="info[blame_uid]" value="{$list['blame_uid']}" class="form-control" id="blame_uid" />
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>培训类型：</label>
                                            <select class="form-control" name="info[process_id]" id="process_id" readonly>
                                                <foreach name="process_data" item="v">
                                                    <option value="{$v.id}" <?php if ($v['id']==$list['process_id']) echo 'selected'; ?>>{$v.title}</option>
                                                </foreach>
                                            </select>
                                        </div>


                                        <div class="form-group col-md-6 ">
                                            <label>是否产生培训费用</label> &emsp;
                                            <input type="radio" name="info[is_cost]" value="0"  <?php if($list['is_cost']==0){ echo 'checked';} ?>> &#8194;不需要 &#12288;&#12288;&#12288;
                                            <input type="radio" name="info[is_cost]" value="1"  <?php if($list['is_cost']==1){ echo 'checked';} ?>> &#8194;需要
                                        </div>

                                        <div class="form-group col-md-6 ">
                                            <label>是否需要人资综合部的协助</label> &emsp;
                                            <input type="radio" name="info[need_help]" value="0"  <?php if($list['need_help']==0){ echo 'checked';} ?>> &#8194;不需要 &#12288;&#12288;&#12288;
                                            <input type="radio" name="info[need_help]" value="1"  <?php if($list['need_help']==1){ echo 'checked';} ?>> &#8194;需要
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label>培训目的：</label><input type="text" name="info[obj]" class="form-control" value="{$list.obj}" required />
                                        </div>

                                        <div class="form-group col-md-12">
                                            <!--<P class="border-bottom-line"> 完成时点详情</P>-->
                                            <div class="form-group col-md-12" id="payment">
                                                <div class="userlist">
                                                    <div class="unitbox_12">培训时间</div>
                                                    <div class="unitbox_12">培训地点</div>
                                                    <div class="unitbox_12">培训对象</div>
                                                    <div class="unitbox_12">培训人</div>
                                                    <div class="unitbox_23">培训内容</div>
                                                    <div class="unitbox_12">培训时长</div>
                                                    <div class="unitbox_12">培训课件</div>
                                                </div>
                                                <?php if($timeLists){ ?>
                                                    <foreach name="timeLists" key="kk" item="pp">
                                                        <div class="userlist" id="pretium_8888{$pp.id}">
                                                            <span class="title"><?php echo $kk+1; ?></span>
                                                            <input type="hidden" name="payment[8888{$pp.id}][reset_id]" value="{$pp.id}">

                                                            <div class="f_12">
                                                                <!--<input type="text" class="form-control" name="payment[8888{$pp.id}][title]" value="{$pp.title}">-->
                                                                <select class="form-control" name="payment[8888{$pp.id}][timeType]">
                                                                    <option value="">请选择</option>
                                                                    <?php foreach ($timeType as $tk =>$tv){ ?>
                                                                        <option value="{$tk}" <?php if ($pp['timeType'] == $tk) echo "selected"; ?>>{$tv}</option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                            <div class="f_12">
                                                                <select class="form-control" name="payment[8888{$pp.id}][st_month]">
                                                                    <option value="">请选择</option>
                                                                    <?php for ($i=1; $i<=12; $i++){ ?>
                                                                        <option value="{$i}" <?php if ($pp['st_month'] == $i) echo "selected"; ?>>{$i}月</option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                            <div class="f_12">
                                                                <select class="form-control" name="payment[8888{$pp.id}][st_day]">
                                                                    <option value="">请选择</option>
                                                                    <?php for ($i=1; $i<=31; $i++){ ?>
                                                                        <option value="{$i}" <?php if ($pp['st_day'] == $i) echo "selected"; ?>>{$i}日</option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                            <div class="f_12">
                                                                <select class="form-control" name="payment[8888{$pp.id}][et_month]">
                                                                    <option value="">请选择</option>
                                                                    <?php for ($i=1; $i<=12; $i++){ ?>
                                                                        <option value="{$i}" <?php if ($pp['et_month'] == $i) echo "selected"; ?>>{$i}月</option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                            <div class="f_12">
                                                                <select class="form-control" name="payment[8888{$pp.id}][et_day]">
                                                                    <option value="">请选择</option>
                                                                    <?php for ($i=1; $i<=31; $i++){ ?>
                                                                        <option value="{$i}" <?php if ($pp['et_day'] == $i) echo "selected"; ?>>{$i}日</option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                            <div class="f_25">
                                                                <input type="text" class="form-control" name="payment[8888{$pp.id}][remark]" value="{$pp.remark}">
                                                            </div>

                                                            <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('pretium_8888{$pp.id}')">删除</a>

                                                        </div>
                                                    </foreach>
                                                <?php }else{ ?>
                                                    <div class="userlist" id="pretium_id">
                                                        <span class="title">1</span>
                                                        <!--<input type="hidden" name="data[1][no]" class="payno" value="1">-->
                                                        <div class="f_12">
                                                            <input type="text" class="form-control inputdate" name="data[1][time]" value="">
                                                        </div>

                                                        <div class="f_12">
                                                            <input type="text" class="form-control" name="data[1][addr]" value="">
                                                        </div>

                                                        <div class="f_12">
                                                            <input type="text" class="form-control" name="data[1][obj]" value="">
                                                        </div>
                                                        <div class="f_12">
                                                            <input type="text" name="data[1][blame_name]" value="" class="form-control" id="blame_name_1" />
                                                            <input type="hidden" name="data[1][blame_uid]" value="" class="form-control" id="blame_uid_1" />
                                                        </div>
                                                        <div class="f_23">
                                                            <input type="text" class="form-control" name="data[1][content]" value="">
                                                        </div>
                                                        <div class="f_12">
                                                            <input type="text" class="form-control" name="data[1][long]" value="">
                                                        </div>

                                                        <div class="f_12">
                                                            <input type="text" class="form-control" name="data[1][pro]" value="">
                                                        </div>

                                                        <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('pretium_id')">删除</a>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <div id="payment_val">1</div>
                                            <div class="form-group col-md-12" id="useraddbtns">
                                                <a href="javascript:;" class="btn btn-success btn-sm" onClick="add_payment()"><i class="fa fa-fw fa-plus"></i> 增加时点数据</a>
                                            </div>
                                        </div>

                                        <div id="formsbtn">
                                            <button type="submit" class="btn btn-info btn-lg" id="lrpd">保存</button>
                                        </div>
                                        </form>
                                    </div>
                                </div><!-- /.box-body -->
                            </div>
                        </div>
                     </div>

                </section>
            </aside>

<include file="Index:footer2" />

<script type="text/javascript">
    const keywords = <?php echo $userkey; ?>;
    $(document).ready(function(e){
        autocomplete_id('blame_name_1','blame_uid_1',keywords);
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
        html += '<div class="f_12"><input type="text" class="form-control inputdate" name="data['+i+'][time]" value=""></div>';
        html += '<div class="f_12"><input type="text" class="form-control" name="data['+i+'][addr]" value=""></div>';
        html += '<div class="f_12"><input type="text" class="form-control" name="data['+i+'][obj]" value=""></div>';
        html += '<div class="f_12"><input type="text" name="data['+i+'][blame_name]" value="" class="form-control" id="blame_name_'+i+'" />' +
            '<input type="hidden" name="data['+i+'][blame_uid]" value="" class="form-control" id="blame_uid_'+i+'" /></div>';
        html += '<div class="f_23"><input type="text" class="form-control" name="data['+i+'][content]" value=""></div>';
        html += '<div class="f_12"><input type="text" class="form-control" name="data['+i+'][long]" value=""></div>';
        html += '<div class="f_12"><input type="text" class="form-control" name="data['+i+'][pro]" value=""></div>';
        html += '<a href="javascript:;" class="btn btn-danger btn-flat" onclick=`delbox("pretium_'+i+'")`>删除</a>';
        $('#payment').append(html);
        $('#payment_val').html(i);
        autocomplete_id('blame_name_'+i,'blame_uid_'+i,keywords);
        orderno();
        relaydate();
    }

    function get_plan_data(plan_id) {
        if (!plan_id){ art_show_msg('培训标题错误',2000); return false; }
        let db      = 'cour_plan';
        $.ajax({
            type:"POST",
            url:"{:U('Ajax/get_public_plan_data')}",
            data:{db:db,id:plan_id},
            success:function(data){
                if(data.nn == 0){
                    art_show_msg(data.msg,3000);
                    return false;
                }else{
                    $('#title').val(data.title);
                    $('#blame_uid').val(data.blame_uid);
                    $('#blame_name').val(data.blame_name);
                    $('#process_id').val(data.process_id)
                    $('#process_id').find("option[value="+data.process_id+"]").attr('selected',true);
                }
            }
        })
    }
</script>


