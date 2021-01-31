<include file="Index:header_mini" />

<script type="text/javascript">
    window.gosubmint= function(){
        $('#myform').submit();
    }
</script>
    <div class="content">
        <form method="post" action="{:U('Rbac/add_department')}" name="myform" id="myform">
            <input type="hidden" name="dosubmint" value="1">
            <input type="hidden" name="id" value="{$row['id']}">
            <div class="form-group col-md-12">
                <label>部门名称：</label>
                <input type="text" name="department" class="form-control" value="{$row.department}" required />
            </div>

            <div class="form-group col-md-12">
                <label>部门字母：</label>
                <input type="text" name="letter" class="form-control" value="{$row.letter}" required />
            </div>

            <div class="form-group col-md-12">
                <label>团号编码：</label>
                <input type="text" name="groupno" class="form-control" value="{$row.groupno}" />
            </div>
        </form>
    </div>

<include file="Index:footer2" />
