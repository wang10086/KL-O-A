<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">客户满意度追责</h3>
        <!--<h3 class="box-title pull-right" style="font-weight:normal; color:#333333;"><span class="green">项目编号：{$op.op_id}</span> &nbsp;&nbsp;创建者：{$op.create_user_name}</h3>-->
    </div>
    <div class="box-body">
        <div class="content">
            <div class="form-group col-md-12 ml-12" id="is_blame">
                <h2 class="tcs_need_h2">是否需要追责</h2>
                <input type="radio" name="is_blame_or_not" value="0"  <?php if($rad==0){ echo 'checked';} ?>> &#8194;不需要 &#12288;&#12288;&#12288;
                <input type="radio" name="is_blame_or_not" value="1"  <?php if($rad==1){ echo 'checked';} ?>> &#8194;需要
            </div>
        </div>

        <div class="" id="zhuize">
            <form method="post" action="{:U('Inspect/blame')}" name="myform" id="myform">
                <input type="hidden" name="dosubmint" value="1">
                <input type="hidden" name="op_id" value="{$op_id}">

                <div class="form-group col-md-12">
                    <label>问题原因：</label>
                    <textarea name="info[problem]"  class="form-control problem" style="height:100px;" required>{$row['problem']}</textarea>
                </div>

                <div class="form-group col-md-12" style="margin-top:15px;">
                    <div class="checkboxlist" id="problemcheckbox">
                        <input type="radio" name="info[solve]" value="0" <?php if($row['solve']==0){ echo 'checked';} ?> > 未解决
                        &nbsp;&nbsp;
                        <input type="radio" name="info[solve]" value="1" <?php if($row['solve']==1){ echo 'checked';} ?> > 已解决
                    </div>
                </div>

                <div class="form-group col-md-12 issolvebox" <?php if($row['solve']==1){ echo ' style="display:none;"';} ?>>
                    <textarea name="info[resolvent]"  class="form-control"  placeholder="解决方案" style="height:100px;">{$row.resolvent}</textarea>
                </div>

                <div style="width:100%; text-align:center; margin-top:30px;">
                    <button type="submit" class="btn btn-info btn-lg" id="lrpd">保存</button>
                </div>
            </form>

        </div>

    </div>

</div><!--/.col (right) -->