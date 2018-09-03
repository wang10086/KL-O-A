<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        数据录入
                    </h1>

                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Salary/salaryindex')}"><i class="fa fa-gift"></i> 人力资源</a></li>
                        <li class="active">岗位薪酬变动</li>
                    </ol>

                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">


                            <!--岗位薪酬变动 -->
                            <div class="btn-group salary_search_extract" id="salary_add_backcolor"><br>

                                <include file="post_salary_change" />

                            </div>


                            <!--提成/奖金/补助-->
                            <div class="salary_search_extract">

                                <include file="Salary:salary_extract_bonus" />

                            </div>

                            <!--五险一金-->
                            <div class="salary_search_extract" >

                                <include file="Salary:salary_insurance" />

                            </div>

                            <!--代扣代缴-->
                            <div class="salary_search_extract" >

                                <include file="Salary:salary_withholding" />

                            </div>

                        </div><!-- /.col -->
                     </div>

                    <!--搜索弹框-->
                    <div class = "salary_search_popup1" style="display: none;">
                        <include file="Salary:salary_popup" />
                    </div>

                </section><!-- /.content -->
                <!--   操作历史 -->
                <div id="salary_history_page1">

                </div>

            </aside><!-- /.right-side -->


<include file="Index:footer2" />
<script src="__HTML__/js/salary.js" type="text/javascript"></script>
<script>


</script>