<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">详细信息</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="content">

            <form method="post" action="{:U('Product/public_save_customer_need')}" name="myform" id="detailForm">
                <input type="hidden" name="dosubmit" value="1">
                <input type="hidden" name="savetype" value="9">
                <input type="hidden" name="id" value="{$need.id}">
                <input type="hidden" name="opid" value="{$list.op_id}">

                <P class="border-bottom-line"> 基本信息</P>
                <div class="form-group col-md-6">
                    <label>预约院所：</label><input type="text" name="data[institutes]"  value="{$need ? $need['institutes'] : $detail['institutes']}" class="form-control"  required />
                </div>

                <div class="form-group col-md-6">
                    <label>预约时间：</label><input type="text" name="data[time]"  value="<?php echo $need ? ($need['time'] ? date('Y-m-d',$need['time']) : '') : ($detail['time'] ? date('Y-m-d',$detail['time']) : ''); ?>" class="form-control inputdate"  required />
                </div>

                <div class="form-group col-md-6">
                    <label>参观内容：</label><input type="text" name="data[content]"  value="{$need ? $need['content'] : $detail['content']}" class="form-control"  />
                </div>

                <div class="form-group col-md-6">
                    <label>参观时长：</label><input type="text" name="data[long]"  value="{$need ? $need['long'] : $detail['long']}" class="form-control"  />
                </div>

                <div class="form-group col-md-12">
                    <label>是否接受调剂同领域/级别其他专家：</label>
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