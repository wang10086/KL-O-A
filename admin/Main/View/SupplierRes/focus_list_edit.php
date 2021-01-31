<include file="Index:header_art" />
<script type="text/javascript">
    window.gosubmint= function(){
        $('#gosub').submit();
    }
</script>

    <div class="box-body art_box-body">
        <div class="content">
            <form method="post" action="{:U('SupplierRes/public_save')}" name="myform" id="gosub">
                <input type="hidden" name="dosubmint" value="1">
                <input type="hidden" name="savetype" value="1">
                <input type="hidden" name="id" value="{$list.id}">
                <div class="form-group col-md-12">
                    <albel>标题</albel>
                    <input type="text" class="form-control" name="info[title]" value="{$list['title']}" />
                </div>

                <div class="form-group col-md-12">
                    <albel>内容</albel>
                    <textarea name="info[content]" class="form-control" style="min-height: 80px">{$list['content']}</textarea>
                </div>

                <div class="form-group col-md-12">
                    <albel>衡量方法</albel>
                    <textarea name="info[rules]" class="form-control" style="min-height: 80px">{$list['rules']}</textarea>
                </div>
            </form>
        </div>
    </div>

    <include file="Index:footer" />
