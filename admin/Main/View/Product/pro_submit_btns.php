<div id="formsbtn">
    <button type="button" class="btn btn-info btn-sm" onclick="$('#detailForm').submit()">保存</button>
    <?php if ($detail['id'] && $list['process'] == 0){ ?>
        <button type="button" class="btn btn-warning btn-sm" onclick="$('#submitForm').submit()" >提交</button>
    <?php } ?>
</div>