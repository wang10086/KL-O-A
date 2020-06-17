<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{$_action_}</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Product/public_pro_need')}"><i class="fa fa-gift"></i> 产品方案需求</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">

                            <include file="Product:pro_navigate" />

                            <div class="box box-warning mt20">
                                <div class="box-header">
                                    <h3 class="box-title">基本信息
                                        <?php echo $list['group_id'] ? "<span style='font-weight:normal; color:#ff3300;'>（团号：".$list['group_id']."）</span>" : ' <span style=" color:#999999;">(该项目暂未成团)</span>'; ?>
                                    </h3>
                                    <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;">
                                        <span class="green">项目编号：{$list.op_id}</span> &nbsp;&nbsp;创建者：{$list.create_user_name}
                                    </h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                        <div class="form-group col-md-12">
                                            <div class="form-group col-md-12">
                                                <label>客户名称：{$list.project}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>项目类型：{$kinds[$list['kind']]}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>递交客户时间：{$list.time|date='Y-m-d',###}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>适合人群：{$list['apply_to']}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                            <label>预计人数：{$list.number}人</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>计划出团日期：{$list.departure}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>行程天数：{$list.days}天</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>目的地省份：{$provinces[$list['province']]}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>详细地址：{$list.destination}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>客户单位：{$list.customer}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>接待实施部门：{$departments[$list['dijie_department_id']]}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>线控负责人：{$list.line_blame_name}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>客户预算：{$list.cost}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>业务人员：{$list.sale_user}</label>
                                            </div>

                                            <div class="form-group col-md-8">
                                                <label>业务部门：<?php echo $departments[$list['create_user_department_id']] ?></label>
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label>备注：{$list.remark}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

                            <?php if (!$jiesuan && in_array(cookie('userid'), array($list['line_blame_uid'],11111,11)) && !$jiesuan){ ?>
                                <include file="handover_edit" />
                            <?php }else{ ?>
                                <include file="handover_read" />
                            <?php } ?>

                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                </section><!-- /.content -->

            </aside><!-- /.right-side -->

  </div>
</div>

<include file="Index:footer2" />

<script type="text/javascript">

    //增加交接项目
    function task(obj){

        var i = parseInt($('#task_val').text())+1;

        var header = '<div class="daylist" id="task_ti_'+i+'">'+
            '<a class="aui_close" href="javascript:;" style="right:25px;" onclick="del_timu(\'task_ti_'+i+'\')">×</a>'+
            '<div class="col-md-12 pd">'+
            '<label class="titou"><strong>第<span class="tihao">'+i+'</span>项</strong></label>';
        var content = '<div class="form-group input-group-3"> <input type="text" name="info['+i+'][day]" class="form-control inputdate" value="" placeholder="活动日期" /> </div>'+
            '<div class="form-group input-group-3 ml4r"> <input type="text" name="info['+i+'][in_time]" class="form-control inputdate_b" value="" placeholder="活动时间" /> </div>'+
            '<div class="form-group input-group-3 ml4r"> <input type="text" name="info['+i+'][addr]" class="form-control" value="" placeholder="活动地点" /> </div>'+
            '<div class="form-group input-group-3"> <input type="text" name="info['+i+'][plan]" class="form-control" value="" placeholder="活动安排" /> </div>'+
            '<div class="form-group input-group-3 ml4r"> <input type="text" name="info['+i+'][material]" class="form-control" value="" placeholder="物资情况" /> </div>'+
            '<div class="form-group input-group-3 ml4r"> <input type="text" name="info['+i+'][blame]" class="form-control" value="" placeholder="项目负责人" /> </div>'+
            '<div class="input-group"><input type="text" name="info['+i+'][note]" class="form-control" value="" placeholder="注意事项" /></div>'+
            '<div class="input-group pads"><textarea class="form-control" name="info['+i+'][remark]" placeholder="备注"></textarea></div>';
        var footer = '</div></div>';

        var html = header+content+footer;

        $('#task_timu').append(html);
        $('#task_val').html(i);
        relaydate();
        //重编题号
        $('.tihao').each(function(index, element) {
            var no = index*1+1;
            $(this).text(no);
        });
    }

    //删除日程
    function del_timu(obj){
        $('#'+obj).remove();
        $('.tihao').each(function(index, element) {
            var no = index*1+1;
            $(this).text(no);
        });
    }
</script>

