<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">审核</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="content">
            <form method="post" action="{:U('Product/public_save')}" id="audit_form">
                <input type="hidden" name="dosubmit" value="1">
                <input type="hidden" name="savetype" value="8">
                <input type="hidden" name="id" value="{$list.id}">

                <div class="form-group box-float-12">
                    <label class="">审核意见：</label>
                    <input type="radio" name="status" value="1"> &#8194;审核通过 &#12288;&#12288;&#12288;
                    <input type="radio" name="status" value="2"> &#8194;审核不通过
                </div>

                <div class="form-group box-float-12">
                    <label>备注</label>
                    <textarea class="form-control" name="audit_remark"></textarea>
                </div>

                <div id="formsbtn">
                    <button type="button" class="btn btn-info btn-sm" onclick="$('#audit_form').submit()">保存</button>
                </div>
            </form>
        </div>
    </div><!-- /.box-body -->
</div>