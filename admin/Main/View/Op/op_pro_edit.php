<form method="post" action="<?php echo U('Op/public_save'); ?>" name="myform" id="save_op_info">
    <input type="hidden" name="dosubmint" value="1">
    <input type="hidden" name="opid" value="{$op.op_id}">
    <input type="hidden" name="savetype" value="10">
    <div class="form-group col-md-4" >
        <label>项目名称：</label><input type="text" name="info[project]"  value="{$op.project}" class="form-control" />
    </div>

    <div class="form-group col-md-4">
        <label>项目类型：</label>
        <select  class="form-control"  name="info[kind]" id="kind" required>
            <foreach name="kinds" key="k" item="v">
                <option value="{$k}" <?php if ($op && ($k == $op['kind'])) echo ' selected'; ?> >{$v}</option>
            </foreach>
        </select>
    </div>

    <div class="form-group col-md-4">
        <label>适合人群：</label>
        <select  class="form-control"  name="info[apply_to]" required>
            <option value="" selected disabled>请选择适合人群</option>
            <foreach name="apply_to" key="k" item="v">
                <option value="{$k}" <?php if ($op && ($k == $op['apply_to'])) echo ' selected'; ?> >{$v}</option>
            </foreach>
        </select>
    </div>

    <div class="form-group col-md-4" id="standard_box">
        <p><label>是否标准化产品</label></p>
        <input type="radio" name="info[standard]" value="1" <?php echo $op['standard']==1 ? "checked" : ''; ?>> &#8194;标准化 &#12288;
        <input type="radio" name="info[standard]" value="2" <?php echo $op['standard']==2 ? "checked" : ''; ?>> &#8194;非标准化
    </div>

    <div class="form-group col-md-4" style="clear: right;" id="line_or_product">
        <?php if ($op['standard']==1){ ?>
            <label style="display: block">标准化产品</label>
            <input type="text" name="producted_title" class="form-control" value="{$producted_list.title}" style="width: 75%; display: inline-block;" readonly>
            <input type="hidden" name="info[producted_id]" value="{$op.producted_id}">
            <span style="display: inline-block; width: 20%">
                <a href="javascript:;" class="btn btn-success btn-sm" onClick="select_standard_product()">获取产品</a>
            </span>
        <?php }else{ ?>
            <label style="display: block">行程方案</label>
            <input type="text" name="line_title" class="form-control" value="{$line_list.title}" style="width: 75%; display: inline-block;" readonly>
            <input type="hidden" name="info[line_id]" value="{$op.line_id}">
            <span style="display: inline-block; width: 20%">
                <a href="javascript:;" class="btn btn-success btn-sm" onClick="selectmodel()">获取线路</a>
            </span>
        <?php } ?>
    </div>

    <div class="form-group col-md-4">
        <label>预计人数：</label><input type="text" name="info[number]" value="{$op.number}" class="form-control" />
    </div>

    <div class="form-group col-md-4">
        <label>计划出团日期：</label><input type="text" name="info[departure]" value="{$op.departure}"  class="form-control inputdate"/>
    </div>

    <div class="form-group col-md-4">
        <label>行程天数：</label><input type="text" name="info[days]" value="{$op.days}" class="form-control" />
    </div>

    <div class="form-group col-md-4">
        <label>目的地：</label><input type="text" name="info[destination]" value="{$op.destination}" class="form-control" />
    </div>

    <!--<div class="form-group col-md-4">
        <label>业务部门：</label>
        <select  class="form-control" name="info[op_create_user]">
        <foreach name="rolelist" key="k" item="v">
            <option value="{$v}" <?php /*if($v==$op['op_create_user']){ echo 'selected';} */?> >{$v}</option>
        </foreach>
        </select>
    </div>-->

    <div class="form-group col-md-4">
        <label>客户单位：</label>
        <input type="text" class="form-control" name="info[customer]" value="{$op.customer}" list="customer" />
        <datalist id="customer">
            <foreach name="geclist" item="v">
                <option value="{$v}" label="" />
            </foreach>
        </datalist>
    </div>

    <!--<div class="form-group col-md-4" style="padding: 0">
        <div class="col-md-12"  style="padding-right: 0">
            <span class="lm_c">协助销售实施专家：</span>
            <foreach name="expert" key="k" item="v">
                <span class="lm_c"><input type="checkbox" name="expert[]" value="{$k}" <?php /*if (in_array($k,$op_expert)) echo "checked"; */?>> {$v}</span>
            </foreach>
        </div>
        <div class="col-md-12"  style="padding-right: 0">
            <span class="lm_c">背景提升产品负责人：</span>
            <span class="lm_c"><input type="checkbox" name="expert[]" value="202" <?php /*if (in_array(202,$op_expert)) echo "checked"; */?>> 于洵</span>
        </div>
    </div>-->

    <div class="form-group col-md-4">
        <label>是否本公司其他项目部地接</label>
        <select  name="info[in_dijie]" class="form-control" required id="dijie" onchange="is_or_not_dijie()">
            <option value="" disabled>--请选择--</option>
            <option value="1" <?php if ($op['in_dijie'] ==1){echo 'selected';} ?> >是</option>：
            <option value="2" <?php if ($op['in_dijie'] ==2 || !$op['in_dijie']){echo 'selected';} ?> >否</option>
        </select>
    </div>

    <div class="form-group col-md-4" id="dijie_or_sale"></div>
    <?php if ($is_dijie){ ?> <!--内部地接-->
    <div class="form-group col-md-12">
        <div class="form-group col-md-8">
            <div class="form-group col-md-12" style="margin-left:-15px;">
                <label>备注：</label><textarea class="form-control"  name="info[context]">{$op.context}</textarea>
            </div>

            <div class="form-group col-md-12" id="addti_btn">
                <a  href="javascript:;" class="btn btn-info btn-sm" onClick="check_op_form:public_save('save_op_info','<?php echo U('Op/public_save'); ?>');">保存</a>
            </div>
        </div>

        <div class="form-group col-md-4">
            <label style="width:100%; border-bottom:1px solid #dedede; padding-bottom:10px; font-weight:bold;">内部满意度评分二维码&emsp;<span class="red">(请发送给组团方：{$is_dijie.create_user_name})</span></label>
            <div id="code"></div>
        </div>
    </div>
    <?php }else{ ?>
        <div class="form-group col-md-12">
            <label>备注：</label><textarea class="form-control"  name="info[context]">{$op.context}</textarea>
        </div>

        <div class="form-group col-md-12" id="addti_btn">
            <a  href="javascript:;" class="btn btn-info btn-sm" onClick="javascript:check_op_form('save_op_info','<?php echo U('Op/public_save'); ?>');">保存</a>
        </div>
    <?php } ?>
</form>

<script>
    var in_dijie = "<?php echo $op['in_dijie']; ?>";
    var dijie_name = '<label>地接单位名称：</label>'+
            '<select  name="info[dijie_name]" class="form-control" required>'+
            '<option value="" selected disabled>--请选择--</option>'+
            '<foreach name="dijie_names" key="k" item="v">'+
            '<option value="{$k}" <?php if ($op['dijie_name']==$k){echo 'selected';} ?>>{$v}</option>'+
            '</foreach>'+
            '</select>';
    var sale = '<label>销售人员：</label> ' +
        '<input type="text" class="form-control" name="info[sale_user]" value="{$op.sale_user}" readonly>';
    $(function () {
        if (in_dijie ==1){
            $('#dijie_or_sale').html(dijie_name);
        }else{
            $('#dijie_or_sale').html(sale);
        }
    })

    function is_or_not_dijie(){
        var dj = $('#dijie').val();
        if (dj == 1){
            $('#dijie_or_sale').html(dijie_name);
        }else{
            $('#dijie_or_sale').html(sale);
        }
    }

    $('#kind').change(function () {
        $('input[name="producted_title"]').val('');
        $('input[name="info[producted_id]"]').val('');
    })

    function check_op_form(id, url){
        let producted_id    = $('input[name="info[producted_id]"]').val();
        let line_id         = $('input[name="info[line_id]"]').val();
        if (!producted_id && !line_id){ art_show_msg("线路或标准化产品不能为空",3); return false; }
        public_save(id,url);
    }

</script>
