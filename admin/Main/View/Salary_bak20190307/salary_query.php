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
                        <div class="col-md-12">

                            <div class="btn-group" id="catfont">
                                <a href="{:U('Salary/salary_query',array('pin'=>0))}" class="btn <?php if($pin==0){ echo 'btn-info';}else{ echo 'btn-default';} ?>">岗位薪酬变动</a>
                                <a href="{:U('Salary/salary_query',array('pin'=>1))}" class="btn <?php if($pin==1){ echo 'btn-info';}else{ echo 'btn-default';} ?>">提成/补助/奖金</a>
                                <a href="{:U('Salary/salary_query',array('pin'=>2))}" class="btn <?php if($pin==2){ echo 'btn-info';}else{ echo 'btn-default';} ?>">五险一金</a>
                                <a href="{:U('Salary/salary_query',array('pin'=>3))}" class="btn <?php if($pin==3){ echo 'btn-info';}else{ echo 'btn-default';} ?>">代扣代缴</a>
                                <a href="{:U('Salary/salary_query',array('pin'=>4))}" class="btn <?php if($pin==4){ echo 'btn-info';}else{ echo 'btn-default';} ?>">专项附加扣除</a>
                            </div>

                            <!--岗位薪酬变动 -->
                            <?php if($pin == 0){ ?>
                                <div class="salary_search_extract" id="salary_add_backcolor"><br>
                                    <include file="post_salary_change" />
                                </div>
                            <?php } ?>


                            <!--提成/奖金/补助-->
                            <?php if($pin == 1){ ?>
                                <div class="salary_search_extract mt20">
                                    <include file="Salary:salary_extract_bonus" />
                                </div>
                            <?php } ?>


                            <!--五险一金-->
                            <?php if($pin == 2){ ?>
                                <div class="salary_search_extract mt20" >
                                    <include file="Salary:salary_insurance" />
                                </div>
                            <?php } ?>


                            <!--代扣代缴-->
                            <?php if($pin == 3){ ?>
                                <div class="salary_search_extract mt20" >
                                    <include file="Salary:salary_withholding" />
                                </div>
                            <?php } ?>

                            <!--专项附加扣除-->
                            <?php if($pin == 4){ ?>
                                <div class="salary_search_extract mt20" >
                                    <include file="Salary:salary_specialDeduction" />
                                </div>
                            <?php } ?>

                            <!--   操作历史 -->
                            <div id="salary_history_page1">

                            </div>


                        </div><!-- /.col -->
                     </div>

                    <!--搜索弹框-->
                    <div class = "salary_search_popup1" style="display: none;">
                        <include file="Salary:salary_popup" />
                    </div>

                </section><!-- /.content -->

            </aside><!-- /.right-side -->


<include file="Index:footer2" />
<script src="__HTML__/js/salary.js" type="text/javascript"></script>
