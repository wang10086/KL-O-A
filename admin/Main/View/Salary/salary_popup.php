<!--岗位薪酬变动搜索弹框-->
<div id="searchtext">
    <script src="__HTML__/js/public.js?v=1.0.6" type="text/javascript"></script>

    <form action="{:U('Salary/salary_query')}" method="post" id="searchform">
        <input type="hidden" name="pin" value="{$pin}">
        <div class="form-group col-md-6">
            <input type="text" class="form-control" name="id" placeholder="ID编号">
        </div>
        <div class="form-group col-md-6">
            <input type="text" class="form-control" name="employee_member" placeholder="员工编号">
        </div>

        <div class="form-group col-md-6">
            <input type="text" class="form-control" name="nickname" placeholder="员工姓名">
        </div>
        <div class="form-group col-md-6">
            <input type="text" class="form-control" name="departmen" placeholder="部门">
        </div>
        <div class="form-group col-md-6">
            <input type="text" class="form-control" name="posts" placeholder="岗位">
        </div>
        <input type="hidden" name="status" value="1">
        <div class="form-group col-md-6">
            <input type="text" class="form-control" name="all" placeholder="输入'所有' 查询所有">
        </div>

    </form>
</div>


<!--提成/补助/奖金 搜索弹框-->
<div id="searchtext_1">
    <script src="__HTML__/js/public.js?v=1.0.6" type="text/javascript"></script>

    <form action="{:U('Salary/salary_query')}" method="post" id="searchform1">
        <input type="hidden" name="pin" value="{$pin}">
        <div class="form-group col-md-6">
            <input type="text" class="form-control" name="id" placeholder="ID编号">
        </div>
        <div class="form-group col-md-6">
            <input type="text" class="form-control" name="employee_member" placeholder="员工编号">
        </div>

        <div class="form-group col-md-6">
            <input type="text" class="form-control" name="nickname" placeholder="员工姓名">
        </div>
        <div class="form-group col-md-6">
            <input type="text" class="form-control" name="departmen" placeholder="部门">
        </div>
        <div class="form-group col-md-6">
            <input type="text" class="form-control" name="posts" placeholder="岗位">
        </div>
        <input type="hidden" name="status" value="2">
        <div class="form-group col-md-6">
            <input type="text" class="form-control" name="all" placeholder="输入'所有' 查询所有">
        </div>

    </form>
</div>

<!--五险一金 搜索弹框-->
<div id="searchtext_2">
    <script src="__HTML__/js/public.js?v=1.0.6" type="text/javascript"></script>

    <form action="{:U('Salary/salary_query')}" method="post" id="searchform2">
        <input type="hidden" name="pin" value="{$pin}">
        <div class="form-group col-md-6">
            <input type="text" class="form-control" name="id" placeholder="ID编号">
        </div>
        <div class="form-group col-md-6">
            <input type="text" class="form-control" name="employee_member" placeholder="员工编号">
        </div>

        <div class="form-group col-md-6">
            <input type="text" class="form-control" name="nickname" placeholder="员工姓名">
        </div>
        <div class="form-group col-md-6">
            <input type="text" class="form-control" name="departmen" placeholder="部门">
        </div>
        <div class="form-group col-md-6">
            <input type="text" class="form-control" name="posts" placeholder="岗位">
        </div>
        <input type="hidden" name="status" value="3">
        <div class="form-group col-md-6">
            <input type="text" class="form-control" name="all" placeholder="输入'所有' 查询所有">
        </div>
        <br><br><br>
    </form>
</div>

<!--代扣代缴-->
<div id="searchtext_3">
    <script src="__HTML__/js/public.js?v=1.0.6" type="text/javascript"></script>

    <form action="{:U('Salary/salary_query')}" method="post" id="salary_withholding_num">
        <input type="hidden" name="pin" value="{$pin}">
        <div class="form-group col-md-12">
            <input type="text" class="form-control" name="id" placeholder="ID编号">
        </div>
        <div class="form-group col-md-12">
            <input type="text" class="form-control" name="employee_member" placeholder="员工编号">
        </div>

        <div class="form-group col-md-12">
            <input type="text" class="form-control" name="nickname" placeholder="员工姓名">
        </div>
        <input type="hidden" name="status" value="4">

    </form>
</div>

<!--工会会费-->
<div id="searchtext_4">
    <script src="__HTML__/js/public.js?v=1.0.6" type="text/javascript"></script>

    <form action="{:U('Salary/salary_query')}" method="post" id="salary_withholding_num">
        <input type="hidden" name="pin" value="{$pin}">
        <div class="form-group col-md-12">
            <input type="text" class="form-control" name="id" placeholder="ID编号">
        </div>
        <div class="form-group col-md-12">
            <input type="text" class="form-control" name="employee_member" placeholder="员工编号">
        </div>

        <div class="form-group col-md-12">
            <input type="text" class="form-control" name="nickname" placeholder="员工姓名">
        </div>
        <input type="hidden" name="status" value="5">

    </form>
</div>

<!--专项附加扣除-->
<div id="searchBox">
    <form action="{:U('Salary/salary_query')}" method="post" id="searchBoxForm">
        <input type="hidden" name="pin" value="{$pin}">
        <div class="form-group col-md-6">
            <input type="text" class="form-control" id="nickname" name="nickname" placeholder="员工姓名">
        </div>
        <div class="form-group col-md-6">
            <input type="text" class="form-control" name="id" placeholder="ID编号">
        </div>
        <div class="form-group col-md-6">
            <input type="text" class="form-control" name="employee_member" placeholder="员工编号">
        </div>
        <div class="form-group col-md-6">
            <input type="text" class="form-control" name="departmen" placeholder="部门">
        </div>
        <div class="form-group col-md-6">
            <input type="text" class="form-control" name="posts" placeholder="岗位">
        </div>
        <input type="hidden" name="status" value="1">
        <div class="form-group col-md-6">
            <input type="text" class="form-control" name="all" placeholder="输入'所有' 查询所有">
        </div>
    </form>
</div>

<script>
    function autocomp(username){
        var keywords = <?php echo $userkey; ?>;
        $("#"+username+"").autocomplete(keywords, {
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