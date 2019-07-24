
<!--提成/奖金/补助-->
<div class="box box-warning">
    <div class="box-header">
        <div class="box-tools pull-left">
            <h3 style="color:blue"><b>&nbsp;&nbsp;&nbsp;五险一金</h3>
            <h4 style="margin:-1.8em 0em 0em 8em">操作事项</h4>

            <select name="some" class="btn btn-info btn-sm" style="margin:-3.5em 0em 0em 20em;width:10em;" id="salary_insurance" onchange="salary_insurance($(this).val())">
                <option value="0" <?php if($type=="" || $type==0 ){echo 'selected';}?>>选择操作</option>
                <option value="1" <?php if($type==8){echo 'selected';}?>>调整社保/医保基数</option>
                <option value="2" <?php if($type==9){echo 'selected';}?>>调整员工社保/公积金比例</option>
                <option value="3" <?php if($type==10){echo 'selected';}?>>调整员工医保比例</option>
                <option value="4" <?php if($type==11){echo 'selected';}?>>调整公司社保/公积金比例</option>
                <option value="5" <?php if($type==12){echo 'selected';}?>>调整公司医保比例</option>
                <option value="10" <?php if($type==17){echo 'selected';}?>>社保补缴</option>
            </select>

        </div>
    </div>
    <div class="box-body">
        <div class="content"><br>

                <!-- 调整社保/医保基数-->
            <div id="table_salary_insurance1" >
                <div style="float: left;margin-left: 2em;">
                    <label>选择人员：</label>
                    <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',700,180);autocomp('nickname');"><i class="fa fa-search"></i> 搜索</a> (提示: 选择不到人员或基本信息不完整、错误时，请在“员工管理”->"人员管理"页面添加或编辑信息)<br><br>
                    <table class="table table-bordered"  style="margin-top:10px;">
                        <tr role="row" class="orders">
                            <th class="sorting" data="op_id"  style="width:6em;">ID</th>
                            <th class="sorting" data="group_id" style="width:8em;">员工姓名</th>
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

                        <foreach name="lists" item="lst">
                            <tr>
                                <td class="salary_table_insurance">{$lst.aid}</td>
                                <td>{$lst.nickname}</td>
                                <td>{$lst.department}</td>
                                <td>{$lst.post_name}</td>
                                <td>{$lst.insurance.injury_base}</td>
                                <td><input type="text" style="float:left;" class="form-control salary_insurance_injury" value="{$lst.insurance.injury_base}" /></td>
                                <td>{$lst.insurance.pension_base}</td>
                                <td><input type="text" style="float:left;" class="form-control salary_insurance_pension" value="{$lst.insurance.pension_base}" /></td>
                                <td>{$lst.insurance.accumulation_fund_base}</td>
                                <td><input type="text" style="float:left;" class="form-control salary_insurance_ratio" value="{$lst.insurance.accumulation_fund_base}" /></td>
                                <input type="hidden" class="status" value="1">
                                <td> <input type="button" class="form-control salary_insurance_butt" value="添加" style="background-color:#00acd6;font-size:1em;" /></td>
                            </tr>
                        </foreach>
                    </table>
                    <div class="box-footer clearfix">
                        <div class="pagestyle">{$pages}</div>
                    </div>

                </div>
            </div>


            <!-- 调整员工社保/公积金比例-->
            <div id="table_salary_insurance2" style="display: none;">
                <div style="float: left;margin-left: 2em;">
                    <label>选择人员：</label>
                    <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',700,180);autocomp('nickname');"><i class="fa fa-search"></i> 搜索</a> (提示: 选择不到人员或基本信息不完整、错误时，请在“员工管理”->"人员管理"页面添加或编辑信息)<br><br>
                    <table class="table table-bordered"  style="margin-top:10px;">
                        <tr role="row" class="orders">
                            <th class="sorting" data="op_id"  style="width:6em;">ID</th>
                            <th class="sorting" data="group_id" style="width:8em;">员工姓名</th>
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

                        <foreach name="lists" item="lst">
                            <tr>
                                <td class="salary_table_insurance">{$lst.aid}</td>
                                <td>{$lst.nickname}</td>
                                <td>{$lst.department}</td>
                                <td>{$lst.post_name}</td>
                                <td>{$lst.insurance.pension_ratio}</td>
                                <td><input type="text" style="float:left;" class="form-control salary_insurance_injury" value="{$lst.insurance.pension_ratio}" /></td>
                                <td>{$lst.insurance.unemployment_ratio}</td>
                                <td><input type="text" style="float:left;" class="form-control salary_insurance_pension" value="{$lst.insurance.unemployment_rati}" /></td>
                                <td>{$lst.insurance.accumulation_fund_ratio}</td>
                                <td><input type="text" style="float:left;" class="form-control salary_insurance_ratio" value="{$lst.insurance.accumulation_fund_ratio}" /></td>
                                <input type="hidden" class="status" value="2">
                                <td> <input type="button" class="form-control salary_insurance_butt" value="添加" style="background-color:#00acd6;font-size:1em;" /></td>
                            </tr>
                        </foreach>
                    </table>
                    <div><h6 style="color:red;width:40em;"><b>医疗比例以百分比为标准; 例如: 0.03</b></h6></div>
                    <div class="box-footer clearfix">
                        <div class="pagestyle">{$pages}</div>
                    </div>

                </div>
            </div>

            <!-- 调整员工医保比例-->
            <div id="table_salary_insurance3" style="display: none;">
                <div style="float: left;margin-left: 2em;">
                    <label>选择人员：</label>
                    <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',700,180);autocomp('nickname');"><i class="fa fa-search"></i> 搜索</a> (提示: 选择不到人员或基本信息不完整、错误时，请在“员工管理”->"人员管理"页面添加或编辑信息)<br><br>
                    <table class="table table-bordered"  style="margin-top:10px;">
                        <tr role="row" class="orders">
                            <th class="sorting" data="op_id"  style="width:6em;">ID</th>
                            <th class="sorting" data="group_id" style="width:8em;">员工姓名</th>
                            <th class="sorting" data="group_id" style="width:8em;">员工部门</th>
                            <th class="sorting" data="project" style="width:8em;">员工岗位</th>
                            <th class="sorting" data="number" style="width:14em;">原医疗保险比例</th>
                            <th class="sorting" data="number" style="width:14em;">现医疗保险比例</th>
                            <th class="sorting" data="shouru" style="width:11em;">原大额医疗保险金额</th>
                            <th class="sorting" data="shouru" style="width:11em;">现大额医疗保险金额</th>
                            <th class="sorting" data="shouru" style="width:10em;">操作</th>
                        </tr>

                        <foreach name="lists" item="lst">
                            <tr>
                                <td class="salary_table_insurance">{$lst.aid}</td>
                                <td>{$lst.nickname}</td>
                                <td>{$lst.department}</td>
                                <td>{$lst.post_name}</td>
                                <td>{$lst.insurance.medical_care_ratio}</td>
                                <td><input type="text" style="float:left;" class="form-control salary_insurance_injury" value="{$lst.insurance.medical_care_ratio}" /></td>
                                <td>{$lst.insurance.big_price}</td>
                                <td><input type="text" style="float:left;" class="form-control salary_insurance_pension" value="{$lst.insurance.big_price}" /></td>
                                <input type="hidden" class="status" value="3">
                                <td> <input type="button" class="form-control salary_insurance_butt" value="添加" style="background-color:#00acd6;font-size:1em;" /></td>
                            </tr>
                        </foreach>
                    </table>
                    <div><h6 style="color:red;width:40em;"><b>医疗比例以百分比为标准; 例如: 0.03</b></h6></div>
                    <div class="box-footer clearfix">
                        <div class="pagestyle">{$pages}</div>
                    </div>

                </div>
            </div>

            <!-- 调整公司社保/公积金比例-->
            <div id="table_salary_insurance4" style="display: none;">
                <div style="float: left;margin-left: 2em;">
                    <label>选择人员：</label>
                    <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',700,180);autocomp('nickname');"><i class="fa fa-search"></i> 搜索</a> (提示: 选择不到人员或基本信息不完整、错误时，请在“员工管理”->"人员管理"页面添加或编辑信息)<br><br>
                    <table class="table table-bordered"  style="margin-top:10px;">
                        <tr role="row" class="orders">
                            <th class="sorting" data="op_id"  style="width:6em;">ID</th>
                            <th class="sorting" data="group_id" style="width:8em;">员工姓名</th>
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

                        <foreach name="lists" item="lst">
                            <tr>
                                <td class="salary_table_insurance">{$lst.aid}</td>
                                <td>{$lst.nickname}</td>
                                <td>{$lst.department}</td>
                                <td>{$lst.post_name}</td>
                                <td>{$lst.insurance.company_pension_ratio}</td>
                                <td><input type="text" style="float:left;" class="form-control salary_insurance_injury" value="{$lst.insurance.company_pension_ratio}" /></td>
                                <td>{$lst.insurance.company_unemployment_ratio}</td>
                                <td><input type="text" style="float:left;" class="form-control salary_insurance_pension" value="{$lst.insurance.company_unemployment_ratio}" /></td>
                                <td>{$lst.insurance.company_accumulation_fund_ratio}</td>
                                <td><input type="text" style="float:left;" class="form-control salary_insurance_ratio" value="{$lst.insurance.company_accumulation_fund_ratio}" /></td>
                                <input type="hidden" class="status" value="4">
                                <td> <input type="button" class="form-control salary_insurance_butt" value="添加" style="background-color:#00acd6;font-size:1em;" /></td>
                            </tr>
                        </foreach>
                    </table>
                    <div><h6 style="color:red;width:40em;"><b>医疗比例以百分比为标准; 例如: 0.03</b></h6></div>
                    <div class="box-footer clearfix">
                        <div class="pagestyle">{$pages}</div>
                    </div>

                </div>
            </div>

            <!-- 调整公司医保比例-->
            <div id="table_salary_insurance5" style="display: none;">
                <div style="float: left;margin-left: 2em;">
                    <label>选择人员：</label>
                    <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',700,180);autocomp('nickname');"><i class="fa fa-search"></i> 搜索</a> (提示: 选择不到人员或基本信息不完整、错误时，请在“员工管理”->"人员管理"页面添加或编辑信息)<br><br>
                    <table class="table table-bordered"  style="margin-top:10px;">
                        <tr role="row" class="orders">
                            <th class="sorting" data="op_id"  style="width:6em;">ID</th>
                            <th class="sorting" data="group_id" style="width:8em;">员工姓名</th>
                            <th class="sorting" data="group_id" style="width:8em;">员工部门</th>
                            <th class="sorting" data="project" style="width:8em;">员工岗位</th>
                            <th class="sorting" data="number" style="width:12em;">原医疗比例</th>
                            <th class="sorting" data="number" style="width:12em;">现医疗比例</th>
                            <th class="sorting" data="shouru" style="width:12em;">原生育比例</th>
                            <th class="sorting" data="shouru" style="width:12em;">现生育比例</th>
                            <th class="sorting" data="number" style="width:11em;">原工伤比例</th>
                            <th class="sorting" data="number" style="width:10em;">现工伤比例</th>
                            <th class="sorting" data="number" style="width:15em;">原大额医疗金额</th>
                            <th class="sorting" data="number" style="width:15em;">现大额医疗金额</th>
                            <th class="sorting" data="shouru" style="width:12em;">操作</th>
                        </tr>

                        <foreach name="lists" item="lst">
                            <tr>
                                <td class="salary_table_insurance">{$lst.aid}</td>
                                <td>{$lst.nickname}</td>
                                <td>{$lst.department}</td>
                                <td>{$lst.post_name}</td>
                                <td>{$lst.insurance.company_medical_care_ratio}</td>
                                <td><input type="text" style="float:left;" class="form-control salary_insurance_injury" value="{$lst.insurance.company_medical_care_ratio}" /></td>
                                <td>{$lst.insurance.company_birth_ratio}</td>
                                <td><input type="text" style="float:left;" class="form-control salary_insurance_pension" value="{$lst.insurance.company_birth_ratio}" /></td>
                                <td>{$lst.insurance.company_injury_ratio}</td>
                                <td><input type="text" style="float:left;" class="form-control salary_insurance_ratio" value="{$lst.insurance.company_injury_ratio}" /></td>
                                <td>{$lst.insurance.company_big_price}</td>
                                <td><input type="text" style="float:left;" class="form-control salary_insurance_price" value="{$lst.insurance.company_big_price}" /></td>
                                <input type="hidden" class="status" value="5">
                                <td> <input type="button" class="form-control salary_insurance_butt" value="添加" style="background-color:#00acd6;font-size:1em;" /></td>
                            </tr>
                        </foreach>
                    </table>
                    <div><h6 style="color:red;width:40em;"><b>医疗比例以百分比为标准; 例如: 0.03</b></h6></div>
                    <div class="box-footer clearfix">
                        <div class="pagestyle">{$pages}</div>
                    </div>

                </div>
            </div>

            <!--社保补缴-->
            <div id="table_salary_insurance10" style="display: none;">
                <div>
                    <label>选择人员：</label>
                    <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',700,180);autocomp('nickname');"><i class="fa fa-search"></i> 搜索</a> (提示: 选择不到人员或基本信息不完整、错误时，请在“员工管理”->"人员管理"页面添加或编辑信息)<br><br>
                    <table class="table table-bordered"  style="margin-top:10px;">
                        <tr role="row" class="orders">
                            <th class="taskOptions" width="80" rowspan="2">ID</th>
                            <th class="taskOptions" width="15%" rowspan="2">员工姓名</th>
                            <th class="taskOptions" width="15%" rowspan="2">员工部门</th>
                            <th class="taskOptions" width="15%" rowspan="2">员工岗位</th>
                            <th class="taskOptions" width="40%" colspan="2">社保补缴</th>
                            <th class="taskOptions" width="" rowspan="2">操作</th>
                        </tr>
                        <tr>
                            <th class="taskOptions">原数据</th>
                            <th class="taskOptions">现数据</th>
                        </tr>

                        <foreach name="lists" item="lst">
                            <tr>
                                <td class="salary_table_insurance">{$lst.aid}</td>
                                <td>{$lst.nickname}</td>
                                <td>{$lst.department}</td>
                                <td>{$lst.post_name}</td>
                                <td width="18%"></td>
                                <td width="22%"><input type="text" class="form-control" value="{$lst.insurance.aaa}" /></td>
                                <td> <input type="button" class="form-control" value="添加" onclick="art_show_msg('加班开发中...',2)" style="background-color:#00acd6;font-size:1em;" /></td>
                            </tr>
                        </foreach>
                    </table>
                    <!--<div><h6 style="color:red;width:40em;"><b>医疗比例以百分比为标准; 例如: 0.03</b></h6></div>-->
                    <div class="box-footer clearfix">
                        <div class="pagestyle">{$pages}</div>
                    </div>

                </div>
            </div>


        </div>
    </div>
</div>
