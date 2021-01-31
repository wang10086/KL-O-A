<include file="Index:header_mini" />

<script type="text/javascript">
    window.gosubmint= function(){
        $('#myform').submit();
    }
</script>

    <aside class="right-side">
        <!-- Main content -->
        <section class="content">
        <form method="post" action="{:U('Files/edit_dir')}" name="myform" id="myform">
        <input type="hidden" name="dosubmint" value="1">
        <input type="hidden" name="id" value="{$list.id}">
            <div class="row">
                <div class="col-md-12">
                    <div class="content">
                        <div class="form-group col-md-12">
                            <label>文件夹名称</label>
                            <input class="form-control" name="file_name" value="{$list.file_name}" />
                        </div>
                    </div>
                </div><!--/.col (right) -->
            </div>   <!-- /.row -->
            </form>
        </section><!-- /.content -->
    </aside><!-- /.right-side -->

<include file="Index:footer2" />