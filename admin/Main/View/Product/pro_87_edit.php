<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">详细信息</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="content">

            <form method="post" action="{:U('Product/public_save')}" name="myform" id="detailForm">
                <input type="hidden" name="dosubmit" value="1">
                <input type="hidden" name="savetype" value="16">
                <!--<input type="hidden" name="need_id" value="{$list.id}">-->
                <input type="hidden" name="id" value="{$detail.id}">
                <input type="hidden" name="opid" value="{$list.op_id}">

                <!--是否标准化-->
                <include file="is_standard" />

                <P class="border-bottom-line"> 基本信息</P>
                <div class="form-group col-md-6">
                    <label>预约院所：</label><input type="text" name="data[institutes]"  value="{$detail.institutes}" class="form-control"  required />
                </div>

                <div class="form-group col-md-6">
                    <label>预约时间：</label><input type="text" name="data[time]"  value="<?php echo $detail['time'] ? date('Y-m-d',$detail['time']) : ''; ?>" class="form-control inputdate"  required />
                </div>

                <div class="form-group col-md-6">
                    <label>参观内容：</label><input type="text" name="data[content]"  value="{$detail.content}" class="form-control"  />
                </div>

                <div class="form-group col-md-6">
                    <label>参观时长：</label><input type="text" name="data[long]"  value="{$detail.long}" class="form-control"  />
                </div>

                <div class="form-group col-md-12">
                    <label>是否接受调剂同领域/级别其他专家：</label>
                    <input type="radio" name="data[adjust]" value="1" <?php if ($detail['adjust']==1) echo "checked"; ?>> &#8194;是 &#12288;
                    <input type="radio" name="data[adjust]" value="0" <?php if ($detail['adjust']==0) echo "checked"; ?>> &#8194;否 &#12288;
                </div>

                <div class="form-group col-md-12">
                    <label>其他相关需求</label>
                    <textarea class="form-control"  name="data[other_condition]">{$detail.other_condition}</textarea>
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