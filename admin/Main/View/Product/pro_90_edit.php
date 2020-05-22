<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">详细信息</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="content">

            <form method="post" action="{:U('Product/public_save')}" name="myform" id="detailForm">
                <input type="hidden" name="dosubmit" value="1">
                <input type="hidden" name="savetype" value="11">
                <input type="hidden" name="need_id" value="{$list.id}">
                <input type="hidden" name="id" value="{$detail.id}">
                <input type="hidden" name="opid" value="{$list.op_id}">

                <!--是否标准化-->
                <include file="is_standard" />

                <P class="border-bottom-line"> 研发方案需求</P>
                <div class="form-group col-md-4">
                    <label>类型：</label>
                    <select name="data[type]" class="form-control">
                        <option value="">==请选择==</option>
                        <option value="背景提升" <?php if ($detail['type']=='背景提升') echo "selected"; ?>>背景提升</option>
                        <option value="科研实习" <?php if ($detail['type']=='科研实习') echo "selected"; ?>>科研实习</option>
                        <option value="深度课题" <?php if ($detail['type']=='深度课题') echo "selected"; ?>>深度课题</option>
                        <option value="其他" <?php if ($detail['type']=='其他') echo "selected"; ?>>其他</option>
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label>产品状态：</label>
                    <select name="data[standard]" class="form-control">
                        <option value="">==请选择==</option>
                        <option value="1" <?php if ($detail['standard']=='1') echo "selected"; ?>>定制</option>
                        <option value="2" <?php if ($detail['standard']=='2') echo "selected"; ?>>标准化</option>
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label>学科：<font color="#999">(精确到二级学科)</font></label>
                    <input type="text" name="data[lession]"  value="{$detail.lession}" class="form-control"  />
                </div>

                <div class="form-group col-md-4">
                    <label>领域：</label>
                    <input type="text" name="data[field]"  value="{$detail.field}" class="form-control"  />
                </div>

                <div class="form-group col-md-4">
                    <label>授课形式：</label>
                    <input type="text" name="data[teaching_form]"  value="{$detail.teaching_form}" class="form-control"  />
                </div>

                <div class="form-group col-md-4">
                    <label>成果：</label>
                    <input type="text" class="form-control" name="data[gain]" value="{$detail.gain}" />
                </div>

                <div class="form-group col-md-4">
                    <label>授课课时及比例：</label>
                    <input type="text" class="form-control" name="data[lession_ratio]" value="{$detail.lession_ratio}" />
                </div>


                <div class="form-group col-md-8">
                    <label>其他研发需求</label><input type="text" name="data[other_yf_condition]"  value="{$detail['other_yf_condition']}" class="form-control" />
                </div>

                <P class="border-bottom-line"> 资源管理需求</P>
                <div class="form-group col-md-12">
                    <label>场地信息：</label>
                    <foreach name="expert_level" item="v">
                        <input type="checkbox" name="expert_level[]" value="{$v}" <?php if (in_array($v,$detail_expert_level)) echo "checked"; ?>> &#8194;{$v} &#12288;
                    </foreach>
                </div>

                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 120px;">是否指定院所</label>
                    <div style="width: 15%; float: left;">
                        <input type="radio" name="data[is_sure_ins]" value="1" <?php if ($detail['is_sure_ins'] == 1) echo "checked"; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_sure_ins]" value="0" <?php if ($detail['is_sure_ins'] == 0) echo "checked"; ?>> &#8194;否
                    </div>
                    <div style="width: 50%; float: left;">
                        院所名称：<input type="text" name="data[ins_name]" value="{$detail['ins_name']}" style="border: none; border-bottom: solid 1px; min-width: 200px;" > &#12288;&#12288;
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label>辅导员(教研秘书)数量</label><input type="text" name="data[guide_num]"  value="{$detail['guide_num']}" class="form-control" />
                </div>

                <div class="form-group col-md-6">
                    <label>辅导员(教研秘书)要求</label><input type="text" name="data[guide_condition]"  value="{$detail['guide_condition']}" class="form-control" />
                </div>

                <div class="form-group col-md-12">
                    <label>其他资源需求</label><input type="text" name="data[other_zy_condition]"  value="{$detail['other_zy_condition']}" class="form-control" />
                </div>

                <P class="border-bottom-line"> 市场设计需求</P>
                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 80px;">科学海报：</label>
                    <div style="width: 15%; float: left;">
                        <input type="radio" name="data[is_need_poster]" value="1" <?php if ($detail['is_need_poster'] == 1) echo "checked"; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_need_poster]" value="0" <?php if ($detail['is_need_poster'] == 0) echo "checked"; ?>> &#8194;否
                    </div>
                    <div style="width: 75%; float: left;">
                        要求：<input type="text" name="data[poster_condition]" value="{$detail['poster_condition']}" style="border: none; border-bottom: solid 1px; min-width: 100px;" > &#12288;&#12288;
                    </div>
                </div>

                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 80px;">微信软文：</label>
                    <div style="width: 15%; float: left;">
                        <input type="radio" name="data[is_need_wechat]" value="1" <?php if ($detail['is_need_wechat'] == 1) echo "checked"; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_need_wechat]" value="0" <?php if ($detail['is_need_wechat'] == 0) echo "checked"; ?>> &#8194;否
                    </div>
                    <div style="width: 75%; float: left;">
                        要求：<input type="text" name="data[wechat_condition]" value="{$detail['wechat_condition']}" style="border: none; border-bottom: solid 1px; min-width: 100px;" > &#12288;&#12288;
                    </div>
                </div>

                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 100px;">H5宣传</label>
                    <div style="width: 20%; float: left;">
                        <input type="radio" name="data[is_need_H5]" value="1" <?php if ($detail['is_need_H5'] == 1) echo "checked"; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_need_H5]" value="0" <?php if ($detail['is_need_H5'] == 0) echo "checked"; ?>> &#8194;否
                    </div>
                    <div style="width: 70%; float: left;">
                        数量：<input type="text" name="data[H5_num]" value="{$detail['H5_num']}" style="border: none; border-bottom: solid 1px; min-width: 160px;" > &#12288;&#12288;
                        要求：<input type="text" name="data[H5_condition]" value="{$detail['H5_condition']}" style="border: none; border-bottom: solid 1px; min-width: 160px;" > &#12288;&#12288;
                    </div>
                </div>

                <div class="form-group col-md-12">
                    <label>其他设计需求</label><input type="text" name="data[other_sj_condition]"  value="{$detail['other_sj_condition']}" class="form-control" />
                </div>
            </form>

            <form method="post" action="{:U('Product/public_save')}" name="myform" id="submitForm">
                <input type="hidden" name="dosubmit" value="1">
                <input type="hidden" name="savetype" value="7">
                <input type="hidden" name="id" value="{$list.id}">
            </form>

            <!--保存 提交按钮-->
            <include file="pro_submit_btns" />

            <!--<div id="formsbtn">
                <button type="button" class="btn btn-info btn-sm" onclick="$('#detailForm').submit()">保存</button>
                <?php /*if ($detail['id'] && $list['process'] == 0){ */?>
                    <button type="button" class="btn btn-warning btn-sm" onclick="$('#submitForm').submit()" >提交</button>
                <?php /*} */?>
            </div>-->
        </div>
    </div><!-- /.box-body -->
</div>