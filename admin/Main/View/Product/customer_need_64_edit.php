<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">详细信息</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="content">

            <form method="post" action="{:U('Product/public_save_customer_need')}" name="myform" id="detailForm">
                <input type="hidden" name="dosubmit" value="1">
                <input type="hidden" name="savetype" value="10">
                <input type="hidden" name="id" value="{$need.id}">
                <input type="hidden" name="opid" value="{$list.op_id}">

                <P class="border-bottom-line"> 专家讲座业务需求表</P>
                <div class="form-group col-md-6">
                    <label>讲座时间：</label><input type="text" name="data[time]"  value="<?php echo $need ? ($need['time'] ? date('Y-m-d H:i:s',$need['time']) : '') : ($detail['time'] ? date('Y-m-d H:i:s',$detail['time']) : ''); ?>" class="form-control inputdatetime"  required />
                </div>

                <div class="form-group col-md-6">
                    <label>讲座时长：</label><input type="text" name="data[long]"  value="{$need ? $need['long'] : $detail['long']}" class="form-control"  required />
                </div>

                <div class="form-group col-md-6">
                    <label>讲座地点：</label><input type="text" name="data[addr]"  value="{$need ? $need['addr'] : $detail['addr']}" class="form-control"  />
                </div>

                <div class="form-group col-md-6">
                    <label>学校硬件设备：</label><input type="text" name="data[equipment]"  value="{$need ? $need['equipment'] : $detail['equipment']}" class="form-control"  />
                </div>

                <div class="form-group col-md-6">
                    <label>讲座领域或题目： <font color="#999">如：数理化天地生等</font> </label><input type="text" name="data[field]"  value="{$need ? $need['field'] : $detail['field']}" class="form-control"  />
                </div>

                <div class="form-group col-md-6">
                    <label>专家库： <font color="#999">如：院士/老科学家演讲团/青年科学家演讲团院/博物学家等</font> </label><input type="text" name="data[expert_type]"  value="{$need ? $need['expert_type'] : $detail['expert_type']}" class="form-control"  />
                </div>

                <div class="form-group col-md-12">
                    <label>专家级别：</label>
                    <input type="checkbox" name="expert_level[]" value="助理研究员" <?php if (in_array('助理研究员',($need ? (explode(',',$need['expert_level'])) : explode(',',$detail['expert_level'])))) echo "checked"; ?>> &#8194;助理研究员 &#12288;
                    <input type="checkbox" name="expert_level[]" value="副研究员" <?php if (in_array('副研究员',($need ? (explode(',',$need['expert_level'])) : explode(',',$detail['expert_level'])))) echo "checked"; ?>> &#8194;副研究员 &#12288;
                    <input type="checkbox" name="expert_level[]" value="研究员" <?php if (in_array('研究员',($need ? (explode(',',$need['expert_level'])) : explode(',',$detail['expert_level'])))) echo "checked"; ?>> &#8194;研究员 &#12288;
                    <input type="checkbox" name="expert_level[]" value="高级工程师" <?php if (in_array('高级工程师',($need ? (explode(',',$need['expert_level'])) : explode(',',$detail['expert_level'])))) echo "checked"; ?>> &#8194;高级工程师 &#12288;
                    <input type="checkbox" name="expert_level[]" value="其他中级职称" <?php if (in_array('其他中级职称',($need ? (explode(',',$need['expert_level'])) : explode(',',$detail['expert_level'])))) echo "checked"; ?>> &#8194;其他中级职称 &#12288;
                    <input type="checkbox" name="expert_level[]" value="其他高级职称" <?php if (in_array('其他高级职称',($need ? (explode(',',$need['expert_level'])) : explode(',',$detail['expert_level'])))) echo "checked"; ?>> &#8194;其他高级职称 &#12288;
                </div>

                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 120px;">是否有指定专家：</label>
                    <div style="width: 20%; float: left;">
                        <input type="radio" name="data[is_sure_expert]" value="1" <?php if ($need ? ($need['is_sure_expert'] == 1) : ($detail['is_sure_expert'] == 1)) echo "checked"; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_sure_expert]" value="0" <?php if ($need ? ($need['is_sure_expert'] == 0) : ($detail['is_sure_expert'] == 0)) echo "checked"; ?>> &#8194;否
                    </div>
                    <div style="width: 60%; float: left;">
                        指定专家姓名：<input type="text" name="data[expert_name]" value="{$need ? $need['expert_name'] : $detail['expert_name']} {$detail['']}" style="border: none; border-bottom: solid 1px; min-width: 100px;" > &#12288;&#12288;
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <p><label>接送：</label></p>
                    <input type="radio" name="data[is_transfer]" value="1" <?php if ($need ? ($need['is_transfer'] == 1) : ($detail['is_transfer'] == 1)) echo "checked"; ?>> &#8194;是 &#12288;
                    <input type="radio" name="data[is_transfer]" value="0" <?php if ($need ? ($need['is_transfer'] == 0) : ($detail['is_transfer'] == 0)) echo "checked"; ?>> &#8194;否
                </div>

                <div class="form-group col-md-6">
                    <label>专家费用(元)：</label><input type="text" name="data[cost]"  value="{$need ? $need['cost'] : $detail['cost']}" class="form-control"  />
                </div>

                <div class="form-group col-md-6">
                    <label>讲座形式：</label><input type="text" name="data[type]"  value="{$need ? $need['type'] : $detail['type']}" class="form-control"  />
                </div>

                <div class="form-group col-md-6">
                    <p><label>是否接受调剂同领域/级别其他专家：</label></p>
                    <input type="radio" name="data[adjust]" value="1" <?php if ($need ? ($need['adjust']==1) : ($detail['adjust']==1)) echo "checked"; ?>> &#8194;是 &#12288;
                    <input type="radio" name="data[adjust]" value="0" <?php if ($need ? ($need['adjust']==0) : ($detail['adjust']==0)) echo "checked"; ?>> &#8194;否 &#12288;
                </div>

                <div class="form-group col-md-12">
                    <label>其他相关需求</label>
                    <textarea class="form-control"  name="data[other_condition]">{$need ? $need['other_condition'] : $detail['other_condition']}</textarea>
                </div>
            </form>

            <div id="formsbtn">
                <button type="button" class="btn btn-info btn-sm" onclick="$('#detailForm').submit()">保存</button>
            </div>
        </div>
    </div><!-- /.box-body -->
</div>