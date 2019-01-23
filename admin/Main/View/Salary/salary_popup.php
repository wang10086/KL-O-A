<!--岗位薪酬变动搜索弹框-->
<!--提成/补助/奖金 搜索弹框-->
<!--五险一金 搜索弹框-->
<!--专项附加扣除-->
<div id="searchtext">
    <form action="{:U('Salary/salary_query')}" method="post" id="searchBoxForm">
        <input type="hidden" name="pin" value="{$pin}">
        <div class="form-group col-md-12 mt10"></div>
        <div class="form-group col-md-6">
            <input type="text" class="form-control nickname" name="nickname" placeholder="员工姓名">
        </div>
        <div class="form-group col-md-6">
            <input type="text" class="form-control" name="id" placeholder="ID编号">
        </div>
        <div class="form-group col-md-6">
            <select class="form-control" name="department_id">
                <option value="">==请选择部门==</option>
                <foreach name="departments" key="k" item="v">
                    <option value="{$k}">{$v}</option>
                </foreach>
            </select>
        </div>
        <div class="form-group col-md-6">
            <select class="form-control" name="post_id">
                <option value="">==请选择岗位==</option>
                <foreach name="posts" item="v">
                    <option value="{$v['id']}">{$v['post_name']}</option>
                </foreach>
            </select>
        </div>
    </form>
</div>

<!--代扣代缴-->
<div id="searchtext_withholding">
    <form action="{:U('Salary/salary_query')}" method="post" id="salary_withholding_num">
        <input type="hidden" name="pin" value="{$pin}">
        <input type="hidden" name="withholding_type" value="1">
        <div class="form-group col-md-12">
            <input type="text" class="form-control nickname" name="nickname" placeholder="员工姓名">
        </div>
        <div class="form-group col-md-12">
            <input type="text" class="form-control" name="id" placeholder="ID编号">
        </div>
    </form>
</div>

<script>
    function autocomp(username){
        var keywords = <?php echo $userkey; ?>;
        $("."+username+"").autocomplete(keywords, {
         matchContains: true,
         highlightItem: false,
         formatItem: function(row, i, max, term) {
         return '<span style=" display:none">'+row.pinyin+'</span>'+row.text;
         },
         formatResult: function(row) {
         return row.text;
         }
         });
        /*.result(function (event, item) {
         $("#"+userid+"").val(item.id);
         });*/
    }

</script>