<include file="Index:header2" />
<script src="__HTML__/js/public.js?v=1.0.6" type="text/javascript"></script>
<aside class="right-side">
<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">添加部门</h3>
    </div>
    <div class="box-body">
        <div class="content" style="padding:10px 30px;">
            <form action="{:U('Salary/salary_add_department')}" method="post">
                <p>添加部门: <input type="text" name="department" /></p>
                <p>添加字母: <input type="text" name="letter" /></p>
                <input type="submit" value="提交" />
            </form>
        </div>
    </div>
</div>
</aside>
<include file="Index:footer2" />