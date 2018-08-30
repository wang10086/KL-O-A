
<!--提成/奖金/补助-->
<div class="box">
    <div class="box-header">
        <div class="box-tools pull-left">
            <h3 style="color:blue"><b>&nbsp;&nbsp;&nbsp;五险一金</h3>
            <h4 style="margin:-1.8em 0em 0em 8em">操作事项</h4>
            <select name="some" class="btn btn-info" style="margin:-3em 0em 0em 17em;width:10em;" id="salary_insurance">
                <option value="0" <?php if($type=="" || $type==0 ){echo 'selected';}?>>选择操作</option>
                <option value="1" onclick="salary_insurance(1)" <?php if($type==8){echo 'selected';}?>>调整社保/医保基数</option>
                <option value="2" onclick="salary_insurance(2)" <?php if($type==9){echo 'selected';}?>>调整员工社保/公积金比例</option>
                <option value="3" onclick="salary_insurance(3)" <?php if($type==10){echo 'selected';}?>>调整员工医保比例</option>
                <option value="4" onclick="salary_insurance(4)" <?php if($type==11){echo 'selected';}?>>调整公司社保/公积金比例</option>
                <option value="5" onclick="salary_insurance(5)" <?php if($type==12){echo 'selected';}?>>调整公司医保比例</option>
            </select>
        </div>
    </div>
    <div class="box-body">
        <div class="btn-group"><br>

            <div id="table_salary_insurance" >
                <div style="float: left;margin-left: 2em;">
                    <label>选择人员：</label>
                    <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext_2',700,160);"><i class="fa fa-search"></i> 搜索</a> (提示: 选择不到人员或基本信息不完整、错误时，请在“员工管理”->"人员管理"页面添加或编辑信息)<br><br>
                    <table class="table table-bordered"  style="margin-top:10px;">
                        <tr role="row" class="orders">
                            <th class="sorting" data="op_id"  style="width:6em;">ID</th>
                            <th class="sorting" data="group_id" style="width:8em;">员工姓名</th>
                            <th class="sorting" data="group_id" style="width:8em;">档案所属</th>
                            <th class="sorting" data="group_id" style="width:8em;">员工部门</th>
                            <th class="sorting" data="project" style="width:8em;">员工岗位</th>
                            <th class="sorting" data="number" style="width:14em;">生育/工伤/医疗原基数</th>
                            <th class="sorting" data="number" style="width:14em;">生育/工伤/医疗现基数</th>
                            <th class="sorting" data="shouru" style="width:11em;">养老/失业原基数</th>
                            <th class="sorting" data="shouru" style="width:11em;">养老/失业现基数</th>
                            <th class="sorting" data="number" style="width:11em;">公积金原基数</th>
                            <th class="sorting" data="number" style="width:10em;">公积金现基数</th>
                            <th class="sorting" data="shouru" style="width:10em;">操作</th>
                        </tr>

                        <foreach name="rows" item="lst">
                            <tr>
                                <td class="salary_table_extract">{$lst.aid}</td>
                                <td>{$lst.nickname}</td>
                                <td><?php if($lst['archives']==1){echo "中心";}elseif($lst['archives']==2){echo "科旅";}elseif($lst['archives']==3){echo "科行";}?></td>
                                <td>{$lst.department}</td>
                                <td>{$lst.post_name}</td>
                                <td>{$lst.post_name}</td>
                                <td><input type="text" style="float:left;" class="form-control salary_bonus_extract" value="{$lst.extract}" /></td>
                                <td>{$lst.post_name}</td>
                                <td><input type="text" style="float:left;" class="form-control salary_bonus_bonus" value="{$lst.bonus}" /></td>
                                <td>{$lst.post_name}</td>
                                <td><input type="text" style="float:left;" class="form-control salary_bonus_yearend" value="{$lst.annual_bonus}" /></td>
                                <td> <input type="button" class="form-control salary_bonus_butt1" value="添加" style="background-color:#00acd6;font-size:1em;" /></td>
                            </tr>
                        </foreach>
                    </table>
                    <div class="box-footer clearfix">
                        <div class="pagestyle">{$page2}</div>
                    </div>

                </div>
            </div>



            <div id="table_salary_insurance2" >
                <div style="float: left;margin-left: 2em;">
                    <label>选择人员：</label>
                    <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext_2',700,160);"><i class="fa fa-search"></i> 搜索</a> (提示: 选择不到人员或基本信息不完整、错误时，请在“员工管理”->"人员管理"页面添加或编辑信息)<br><br>
                    <table class="table table-bordered"  style="margin-top:10px;">
                        <tr role="row" class="orders">
                            <th class="sorting" data="op_id"  style="width:6em;">ID</th>
                            <th class="sorting" data="group_id" style="width:8em;">员工姓名</th>
                            <th class="sorting" data="group_id" style="width:8em;">档案所属</th>
                            <th class="sorting" data="group_id" style="width:8em;">员工部门</th>
                            <th class="sorting" data="project" style="width:8em;">员工岗位</th>
                            <th class="sorting" data="number" style="width:14em;">原养老保险比例</th>
                            <th class="sorting" data="number" style="width:14em;">现养老保险比例</th>
                            <th class="sorting" data="shouru" style="width:11em;">原失业保险比例</th>
                            <th class="sorting" data="shouru" style="width:11em;">现失业保险比例</th>
                            <th class="sorting" data="number" style="width:11em;">原公积金比例</th>
                            <th class="sorting" data="number" style="width:10em;">现公积金比例</th>
                            <th class="sorting" data="shouru" style="width:10em;">操作</th>
                        </tr>

                        <foreach name="rows" item="lst">
                            <tr>
                                <td class="salary_table_extract">{$lst.aid}</td>
                                <td>{$lst.nickname}</td>
                                <td><?php if($lst['archives']==1){echo "中心";}elseif($lst['archives']==2){echo "科旅";}elseif($lst['archives']==3){echo "科行";}?></td>
                                <td>{$lst.department}</td>
                                <td>{$lst.post_name}</td>
                                <td>{$lst.post_name}</td>
                                <td><input type="text" style="float:left;" class="form-control salary_bonus_extract" value="{$lst.extract}" /></td>
                                <td>{$lst.post_name}</td>
                                <td><input type="text" style="float:left;" class="form-control salary_bonus_bonus" value="{$lst.bonus}" /></td>
                                <td>{$lst.post_name}</td>
                                <td><input type="text" style="float:left;" class="form-control salary_bonus_yearend" value="{$lst.annual_bonus}" /></td>
                                <td> <input type="button" class="form-control salary_bonus_butt1" value="添加" style="background-color:#00acd6;font-size:1em;" /></td>
                            </tr>
                        </foreach>
                    </table>
                    <div class="box-footer clearfix">
                        <div class="pagestyle">{$page2}</div>
                    </div>

                </div>
            </div>


            <div id="table_salary_insurance3" >
                <div style="float: left;margin-left: 2em;">
                    <label>选择人员：</label>
                    <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext_2',700,160);"><i class="fa fa-search"></i> 搜索</a> (提示: 选择不到人员或基本信息不完整、错误时，请在“员工管理”->"人员管理"页面添加或编辑信息)<br><br>
                    <table class="table table-bordered"  style="margin-top:10px;">
                        <tr role="row" class="orders">
                            <th class="sorting" data="op_id"  style="width:6em;">ID</th>
                            <th class="sorting" data="group_id" style="width:8em;">员工姓名</th>
                            <th class="sorting" data="group_id" style="width:8em;">档案所属</th>
                            <th class="sorting" data="group_id" style="width:8em;">员工部门</th>
                            <th class="sorting" data="project" style="width:8em;">员工岗位</th>
                            <th class="sorting" data="number" style="width:14em;">原医疗保险比例</th>
                            <th class="sorting" data="number" style="width:14em;">现医疗保险比例</th>
                            <th class="sorting" data="shouru" style="width:11em;">原大额医疗保险比例</th>
                            <th class="sorting" data="shouru" style="width:11em;">现大额医疗保险比例</th>
                            <th class="sorting" data="shouru" style="width:10em;">操作</th>
                        </tr>

                        <foreach name="rows" item="lst">
                            <tr>
                                <td class="salary_table_extract">{$lst.aid}</td>
                                <td>{$lst.nickname}</td>
                                <td><?php if($lst['archives']==1){echo "中心";}elseif($lst['archives']==2){echo "科旅";}elseif($lst['archives']==3){echo "科行";}?></td>
                                <td>{$lst.department}</td>
                                <td>{$lst.post_name}</td>
                                <td>{$lst.post_name}</td>
                                <td><input type="text" style="float:left;" class="form-control salary_bonus_bonus" value="{$lst.bonus}" /></td>
                                <td>{$lst.post_name}</td>
                                <td><input type="text" style="float:left;" class="form-control salary_bonus_yearend" value="{$lst.annual_bonus}" /></td>
                                <td> <input type="button" class="form-control salary_bonus_butt1" value="添加" style="background-color:#00acd6;font-size:1em;" /></td>
                            </tr>
                        </foreach>
                    </table>
                    <div class="box-footer clearfix">
                        <div class="pagestyle">{$page2}</div>
                    </div>

                </div>
            </div>


            <div id="table_salary_insurance2" >
                <div style="float: left;margin-left: 2em;">
                    <label>选择人员：</label>
                    <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext_2',700,160);"><i class="fa fa-search"></i> 搜索</a> (提示: 选择不到人员或基本信息不完整、错误时，请在“员工管理”->"人员管理"页面添加或编辑信息)<br><br>
                    <table class="table table-bordered"  style="margin-top:10px;">
                        <tr role="row" class="orders">
                            <th class="sorting" data="op_id"  style="width:6em;">ID</th>
                            <th class="sorting" data="group_id" style="width:8em;">员工姓名</th>
                            <th class="sorting" data="group_id" style="width:8em;">档案所属</th>
                            <th class="sorting" data="group_id" style="width:8em;">员工部门</th>
                            <th class="sorting" data="project" style="width:8em;">员工岗位</th>
                            <th class="sorting" data="number" style="width:14em;">原养老保险比例</th>
                            <th class="sorting" data="number" style="width:14em;">现养老保险比例</th>
                            <th class="sorting" data="shouru" style="width:11em;">原失业保险比例</th>
                            <th class="sorting" data="shouru" style="width:11em;">现失业保险比例</th>
                            <th class="sorting" data="number" style="width:11em;">原公积金比例</th>
                            <th class="sorting" data="number" style="width:10em;">现公积金比例</th>
                            <th class="sorting" data="shouru" style="width:10em;">操作</th>
                        </tr>

                        <foreach name="rows" item="lst">
                            <tr>
                                <td class="salary_table_extract">{$lst.aid}</td>
                                <td>{$lst.nickname}</td>
                                <td><?php if($lst['archives']==1){echo "中心";}elseif($lst['archives']==2){echo "科旅";}elseif($lst['archives']==3){echo "科行";}?></td>
                                <td>{$lst.department}</td>
                                <td>{$lst.post_name}</td>
                                <td>{$lst.post_name}</td>
                                <td><input type="text" style="float:left;" class="form-control salary_bonus_extract" value="{$lst.extract}" /></td>
                                <td>{$lst.post_name}</td>
                                <td><input type="text" style="float:left;" class="form-control salary_bonus_bonus" value="{$lst.bonus}" /></td>
                                <td>{$lst.post_name}</td>
                                <td><input type="text" style="float:left;" class="form-control salary_bonus_yearend" value="{$lst.annual_bonus}" /></td>
                                <td> <input type="button" class="form-control salary_bonus_butt1" value="添加" style="background-color:#00acd6;font-size:1em;" /></td>
                            </tr>
                        </foreach>
                    </table>
                    <div class="box-footer clearfix">
                        <div class="pagestyle">{$page2}</div>
                    </div>

                </div>
            </div>


            <div id="table_salary_insurance5" >
                <div style="float: left;margin-left: 2em;">
                    <label>选择人员：</label>
                    <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext_2',700,160);"><i class="fa fa-search"></i> 搜索</a> (提示: 选择不到人员或基本信息不完整、错误时，请在“员工管理”->"人员管理"页面添加或编辑信息)<br><br>
                    <table class="table table-bordered"  style="margin-top:10px;">
                        <tr role="row" class="orders">
                            <th class="sorting" data="op_id"  style="width:6em;">ID</th>
                            <th class="sorting" data="group_id" style="width:8em;">员工姓名</th>
                            <th class="sorting" data="group_id" style="width:8em;">档案所属</th>
                            <th class="sorting" data="group_id" style="width:8em;">员工部门</th>
                            <th class="sorting" data="project" style="width:8em;">员工岗位</th>
                            <th class="sorting" data="number" style="width:12em;">原医疗比例</th>
                            <th class="sorting" data="number" style="width:12em;">现医疗比例</th>
                            <th class="sorting" data="shouru" style="width:12em;">原生育比例</th>
                            <th class="sorting" data="shouru" style="width:12em;">现生育比例</th>
                            <th class="sorting" data="number" style="width:11em;">原工伤比例</th>
                            <th class="sorting" data="number" style="width:10em;">现工伤比例</th>
                            <th class="sorting" data="number" style="width:15em;">原大额医疗比例</th>
                            <th class="sorting" data="number" style="width:15em;">现大额医疗比例</th>
                            <th class="sorting" data="shouru" style="width:12em;">操作</th>
                        </tr>

                        <foreach name="rows" item="lst">
                            <tr>
                                <td class="salary_table_extract">{$lst.aid}</td>
                                <td>{$lst.nickname}</td>
                                <td><?php if($lst['archives']==1){echo "中心";}elseif($lst['archives']==2){echo "科旅";}elseif($lst['archives']==3){echo "科行";}?></td>
                                <td>{$lst.department}</td>
                                <td>{$lst.post_name}</td>
                                <td>{$lst.post_name}</td>
                                <td><input type="text" style="float:left;" class="form-control salary_bonus_extract" value="{$lst.extract}" /></td>
                                <td>{$lst.post_name}</td>
                                <td><input type="text" style="float:left;" class="form-control salary_bonus_bonus" value="{$lst.bonus}" /></td>
                                <td>{$lst.post_name}</td>
                                <td><input type="text" style="float:left;" class="form-control salary_bonus_yearend" value="{$lst.annual_bonus}" /></td>
                                <td>{$lst.post_name}</td>
                                <td><input type="text" style="float:left;" class="form-control salary_bonus_yearend" value="{$lst.annual_bonus}" /></td>
                                <td> <input type="button" class="form-control salary_bonus_butt1" value="添加" style="background-color:#00acd6;font-size:1em;" /></td>
                            </tr>
                        </foreach>
                    </table>
                    <div class="box-footer clearfix">
                        <div class="pagestyle">{$page2}</div>
                    </div>

                </div>
            </div>



        </div>
    </div>
</div>