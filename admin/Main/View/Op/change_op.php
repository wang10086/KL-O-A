<include file="Index:header_art" />
		<script type="text/javascript">
        window.gosubmint= function(){
			$('#myform').submit();
		 } 
        </script>
       
        <section class="content">
            <div class="row">
                <div class="form-group col-md-12">
                    <div class="callout callout-danger">
                        <h4>提示！</h4>
                        <p>项目交接后,该项目该项目所有的收入将转入被交接人员!</p>
                    </div>
                </div>

                <form action="{:U('Op/change_op')}" method="post" name="myform" id="myform">

    				<input type="hidden" name="dosubmit" value="1" />
    				<input type="hidden" name="opid"    value="{$opid}" />
                    <div class="form-group box-float-12">
                        <label>接收人员</label>
                        <input type="text" name="info[create_user_name]" class="form-control" id="create_user_name" />
                        <input type="hidden" name="info[create_user]" class="form-control" id="create_user_id" />
                    </div>
                </form>

            </div>
        </section>
        

<include file="Index:footer" />
<script>
    $(document).ready(function(e){
        var keywords = <?php echo $userkey; ?>;
        $("#create_user_name").autocomplete(keywords, {
            matchContains: true,
            highlightItem: false,
            formatItem: function(row, i, max, term) {
                return '<span style=" display:none">'+row.pinyin+'</span>'+row.text;
            },
            formatResult: function(row) {
                return row.text;
            }
        }).result(function (event, item) {
            $("#create_user_id").val(item.id);
        });
    });

</script>