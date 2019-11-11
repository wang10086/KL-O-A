<include file="Index:header_mini" />

<script type="text/javascript">
    window.gosubmint= function(){
        $('#myform').submit();
    }
</script>

            <aside class="right-side">
                <!-- Main content -->
                <section class="content">
                <form method="post" action="{:U('Approval/edit_record')}" name="myform" id="myform">
                <input type="hidden" name="dosubmint" value="1">
                <input type="hidden" name="id" value="{$row['id']}">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="content">
                                <div class="form-group col-md-12">
                                    文件名称：{$file.newFileName}
                                </div>
                                <div class="form-group col-md-12">
                                    <label>原文件内容(请复制原文件相关内容)</label>
                                    <textarea class="form-control" name="file_content">{$record.file_content}</textarea>
                                </div>

                                <div class="form-group col-md-12">
                                    <label>建议调整为</label>
                                    <textarea class="form-control" name="suggest">{$record.suggest}</textarea>
                                </div>
                            </div>
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                    </form>
                </section><!-- /.content -->
            </aside><!-- /.right-side -->

  </div>
</div>

<include file="Index:footer2" />