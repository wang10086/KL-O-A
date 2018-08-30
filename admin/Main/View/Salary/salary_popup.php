<!--岗位薪酬变动搜索弹框-->
<div id="searchtext">
    <script src="__HTML__/js/public.js?v=1.0.6" type="text/javascript"></script>

    <form action="{:U('Salary/salary_query')}" method="post" id="searchform">

        <div class="form-group col-md-3">
            <input type="text" class="form-control" name="id" placeholder="ID编号">
        </div>
        <div class="form-group col-md-3">
            <input type="text" class="form-control" name="employee_member" placeholder="员工编号">
        </div>

        <div class="form-group col-md-3">
            <input type="text" class="form-control" name="nickname" placeholder="员工姓名">
        </div>
        <div class="form-group col-md-3">
            <input type="text" class="form-control" name="departmen" placeholder="部门">
        </div>
        <div class="form-group col-md-3">
            <input type="text" class="form-control" name="posts" placeholder="岗位">
        </div>
        <input type="hidden" name="status" value="1">
        <div class="form-group col-md-3">
            <input type="text" class="form-control" name="all" placeholder="输入'所有' 查询所有">
        </div>

    </form>
</div>


<!--提成/补助/奖金 搜索弹框-->
<div id="searchtext_1">
    <script src="__HTML__/js/public.js?v=1.0.6" type="text/javascript"></script>

    <form action="{:U('Salary/salary_query')}" method="post" id="searchform1">

        <div class="form-group col-md-3">
            <input type="text" class="form-control" name="id" placeholder="ID编号">
        </div>
        <div class="form-group col-md-3">
            <input type="text" class="form-control" name="employee_member" placeholder="员工编号">
        </div>

        <div class="form-group col-md-3">
            <input type="text" class="form-control" name="nickname" placeholder="员工姓名">
        </div>
        <div class="form-group col-md-3">
            <input type="text" class="form-control" name="departmen" placeholder="部门">
        </div>
        <div class="form-group col-md-3">
            <input type="text" class="form-control" name="posts" placeholder="岗位">
        </div>
        <input type="hidden" name="status" value="2">
        <div class="form-group col-md-3">
            <input type="text" class="form-control" name="all" placeholder="输入'所有' 查询所有">
        </div>

    </form>
</div>

<!--补贴 搜索弹框-->
<div id="searchtext_2">
    <script src="__HTML__/js/public.js?v=1.0.6" type="text/javascript"></script>

    <form action="{:U('Salary/salary_query')}" method="post" id="searchform2">

        <div class="form-group col-md-3">
            <input type="text" class="form-control" name="id" placeholder="ID编号">
        </div>
        <div class="form-group col-md-3">
            <input type="text" class="form-control" name="employee_member" placeholder="员工编号">
        </div>

        <div class="form-group col-md-3">
            <input type="text" class="form-control" name="nickname" placeholder="员工姓名">
        </div>
        <div class="form-group col-md-3">
            <input type="text" class="form-control" name="departmen" placeholder="部门">
        </div>
        <div class="form-group col-md-3">
            <input type="text" class="form-control" name="posts" placeholder="岗位">
        </div>
        <input type="hidden" name="status" value="3">
        <div class="form-group col-md-3">
            <input type="text" class="form-control" name="all" placeholder="输入'所有' 查询所有">
        </div>

    </form>
</div>