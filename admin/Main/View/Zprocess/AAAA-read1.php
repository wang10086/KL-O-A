<include file="Index:header2" />

<style>

</style>

            <aside class="right-side">
                <section class="content-header" style="padding: 5px">
                    <include file="Index:ZcontentHeaderFile" />
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="zpage-title">
                        {$list.title}
                    </div>
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                            <div class="zbox">
                                <!--<div class="box-header">
                                    <h3 class="box-title">基本信息</h3>
                                </div>-->

                                <div class="content">

                                    <div class="form-group col-md-4 viwe">
                                        <p>11111</p>
                                    </div>

                                    <div class="form-group col-md-4 viwe">
                                        <p>22222</p>
                                    </div>

                                    <div class="form-group col-md-4 viwe">
                                        <p>33333 </p>
                                    </div>
                                </div>

                                <div>
                                    <div class="box-header">
                                        <h3 class="box-title">一 、测试排版</h3>
                                    </div><!-- /.box-header --><br>
                                    <div class="content">
                                        <div class="form-group col-md-4 viwe">
                                            <p>111</p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p>222</p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p>333</p>
                                        </div>


                                        <!--<table class="table table-bordered dataTable fontmini">
                                            <tr role="row" class="orders" >
                                                <th class="sorting" data="op_id">考勤/扣款</th>
                                                <th class="sorting" data="op_id">迟到/早退（15分钟以内）</th>
                                                <th class="sorting" data="group_id">迟到/早退（15分钟~2小时）</th>
                                                <th class="sorting" data="group_id">事假</th>
                                                <th class="sorting" data="project">病假</th>
                                                <th class="sorting" class="project">旷工</th>
                                                <th class="sorting" class="project">缺勤天数</th>

                                            </tr>

                                                <tr>
                                                    <td>次数</td>
                                                    <td><?php /*echo  round($attendance_list['late1'],2);*/?></td>
                                                    <td><?php /*echo  round($attendance_list['late2'],2);*/?></td>
                                                    <td><?php /*echo  round($attendance_list['leave_absence'],2);*/?></td>
                                                    <td><?php /*echo  round($attendance_list['sick_leave'],2);*/?></td>
                                                    <td><?php /*echo  round($attendance_list['absenteeism'],2);*/?></td>
                                                    <td><?php /*echo  round($attendance_list['entry_data'],2);*/?></td>
                                                </tr>

                                            <tr>
                                                <td>扣款</td>
                                                <td>{$attendance_list['late1']*10}</td>
                                                <td>{$attendance_list['late2']*30}</td>
                                                <td><?php /*echo  round($wages_list['basic_salary']/21.75*$attendance_list['leave_absence'],2);*/?></td>
                                                <td><?php /*echo  round(($wages_list['basic_salary']-($attendance_list['lowest_wage']*0.8))/21.75*$attendance_list['sick_leave'],2);*/?></td>
                                                <td><?php /*echo  round($wages_list['basic_salary']/21.75*$attendance_list['absenteeism']*2,2);*/?></td>
                                                <td><?php /*echo round($wages_list['standard']/21.75*$attendance_list['entry_data'],2);*/?></td>
                                            </tr>

                                        </table><br />
                                        <div class="form-group col-md-4 viwe">
                                            <p>绩效增减：{$wages_list['Achievements_withdrawing']} (元)</p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p >应发绩效工资：{$wages_list['performance_salary']+$wages_list['Achievements_withdrawing']} (元)</p>
                                        </div>-->
                                    </div>

                                </div>
                            </div><!-- /.box -->


                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                </section><!-- /.content -->
            </aside><!-- /.right-side -->

  </div>
</div>

<script type="text/javascript">

</script>

<include file="Index:footer2" />
