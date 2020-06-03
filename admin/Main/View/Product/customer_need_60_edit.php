<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">客户需求详情</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="content">

            <form method="post" action="{:U('Product/public_save_customer_need')}" name="myform" id="detailForm">
                <input type="hidden" name="dosubmit" value="1">
                <input type="hidden" name="savetype" value="1">
                <input type="hidden" name="id" value="{$need.id}">
                <input type="hidden" name="opid" value="{$list.op_id}">

                <P class="border-bottom-line"> 研发方案需求</P>
                <div class="form-group col-md-12">
                    <label>课程名称：</label>
                    <input type="text" class="form-control" name="data[title]" value="{$need['title'] ? $need['title'] : $detail['title']}" required />
                </div>

                <div class="form-group col-md-8">
                    <label>上课地址：</label>
                    <input type="text" class="form-control" name="data[addr]" value="{$need['addr'] ? $need['addr'] : $detail['addr']}" required />
                </div>

                <div class="form-group col-md-4">
                    <label>开课时间：(第一次上课时间)</label><input type="text" name="data[lession_time]"  value="<?php echo $need['lession_time'] ? date('Y-m-d',$need['lession_time']) : ($detail['lession_time'] ? date('Y-m-d',$detail['lession_time']) : ''); ?>" class="form-control inputdatetime"  required />
                </div>

                <div class="form-group col-md-4">
                    <label>课程时间：</label>
                    <select name="data[week]" class="form-control" required>
                        <option value="">==请选择==</option>
                        <?php for ($i = 1; $i<=7; $i++){ ?>
                            <option value="{$i}" <?php if ($need['week'] ? $need['week']==$i : $detail['week']==$i) echo "selected"; ?>>星期{$i}</option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label>课程具体时间：</label><input type="text" name="in_time"  value="<?php echo $need['st_time'] ? date('H:i:s',$need['st_time']).' - '.date('H:i:s',$need['et_time']) : ($detail['st_time'] ? date('H:i:s',$detail['st_time']).' - '.date('H:i:s',$detail['et_time']) : ''); ?>" class="form-control inputdate_b"  required />
                </div>

                <div class="form-group col-md-4">
                    <label>班级人数：</label>
                    <input type="text" class="form-control" name="data[member]" value="{$need['member'] ? $need['member'] : $detail['member']}" required />
                </div>

                <div class="form-group col-md-4">
                    <label>上课次数：</label>
                    <input type="text" class="form-control" name="data[lession_num]" value="{$need['lession_num'] ? $need['lession_num'] : $detail['lession_num']}" required />
                </div>

                <div class="form-group col-md-4" id="standard_box">
                    <p><label>是否设置动手实践</label></p>
                    <input type="radio" name="data[hands_on]" value="1" <?php if ($need ? $need['hands_on']==1 : $detail['hands_on']==1) echo 'checked'; ?>> &#8194;是 &#12288;
                    <input type="radio" name="data[hands_on]" value="0" <?php if ($need ? $need['hands_on']==0 : $detail['hands_on']==0) echo 'checked'; ?>> &#8194;否
                </div>

                <div class="form-group col-md-4">
                    <label>材料预算：</label>
                    <input type="text" class="form-control" name="data[material_cost]" value="{$need['material_cost'] ? $need['material_cost'] : $detail['material_cost']}" />
                </div>

                <P class="border-bottom-line"> 资源管理需求</P>
                <div class="form-group col-md-4">
                    <label>教师数量</label><input type="text" name="data[teacher_num]"  value="{$need['teacher_num'] ? $need['teacher_num'] : $detail['teacher_num']}" class="form-control" />
                </div>

                <div class="form-group col-md-4">
                    <label>教师级别：</label>
                    <select name="data[teacher_level]" class="form-control" required>
                        <option value="">==请选择==</option>
                        <foreach name="teacher_level" item="v">
                            <option value="{$v}" <?php if ($need ? $need['teacher_level'] == $v : $detail['teacher_level']==$v) echo "selected"; ?>>{$v}</option>
                        </foreach>
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label>教师费用：</label>
                    <select name="data[teacher_cost]" class="form-control">
                        <option value="">==请选择==</option>
                        <option value="250" <?php if ($need ? $need['teacher_cost']==250 : $detail['teacher_cost']==250) echo "selected"; ?>>250元</option>
                        <option value="300" <?php if ($need ? $need['teacher_cost']==250 : $detail['teacher_cost']==300) echo "selected"; ?>>300元</option>
                        <option value="500" <?php if ($need ? $need['teacher_cost']==250 : $detail['teacher_cost']==500) echo "selected"; ?>>500元</option>
                        <option value="800" <?php if ($need ? $need['teacher_cost']==250 : $detail['teacher_cost']==800) echo "selected"; ?>>800元</option>
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label>教师要求</label><input type="text" name="data[teacher_condition]"  value="{$need['teacher_condition'] ? $need['teacher_condition'] : $detail['teacher_condition']}" class="form-control" />
                </div>

                <div class="form-group col-md-8">
                    <label>其他资源需求</label><input type="text" name="data[other_res_condition]"  value="{$need['other_res_condition'] ? $need['other_res_condition'] : $detail['other_res_condition']}" class="form-control" />
                </div>

                <div class="form-group col-md-12">
                    <label>备注：</label><textarea class="form-control"  name="data[remark]">{$need['remark'] ? $need['remark'] : $detail['remark']}</textarea>
                </div>
            </form>

            <div id="formsbtn">
                <button type="button" class="btn btn-info btn-sm" onclick="$('#detailForm').submit()">保存</button>
            </div>
        </div>
    </div><!-- /.box-body -->
</div>