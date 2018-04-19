<script type="text/javascript">
    $(document).ready(function() {
        $("#res_need_table").hide();
    })
</script>

<div class="box-body" id="res_need_table" >

    <div class="form-group col-md-12" style="align: center;">
    <table style="width: 100%; margin-top: 20px;">
        <tr>
            <td class="td_title" colspan="6">
                <div class="form-group col-md-12">
                    <h4>资源需求单(项目编号:{$resource.op_id})</h4>
                </div>
            </td>
        </tr>
        <tr>
            <td class="td_title td">需求部门</td>
            <td colspan="2" class="td_con td">{$resource.department}</td>
            <td class="td_title td">客户单位</td>
            <td colspan="2" class="td_con td">{$resource.client}</td>
        </tr>
        <tr>
            <td class="td_title td">业务人员</td>
            <td colspan="2" class="td_con td">{$resource.service_name}</td>
            <td class="td_title td">实施对象</td>
            <td colspan="2" class="td_con td">{$resource.imp_obj}</td>
        </tr>
        <tr>
            <td class="td_title td">需求时间、周期</td>
            <td colspan="2" class="td_con td">{$resource.use_time}</td>
            <td class="td_title td">专业领域</td>
            <td colspan="2" class="td_con td">{$resource.major}</td>
        </tr>
        <tr>
            <td class="td_title td">活动人数</td>
            <td colspan="2" class="td_con td">{$resource.number}</td>
            <td class="td_title td">参考费用</td>
            <td colspan="2" class="td_con td">{$resource.money}</td>
        </tr>
        <tr>
            <td class="td_title td">提交人员</td>
            <td colspan="2" class="td_con td">{$resource.ini_user_name}</td>
            <td class="td_title td">提交时间</td>
            <td colspan="2" class="td_con td">{$resource.ini_time|date='Y-m-d H:i:s',###}</td>
        </tr>
        <tr>
            <td class="td_title td">接收人员</td>
            <td colspan="2" class="td_con td">{$resource.exe_user_name}</td>
            <td class="td_title td">接收时间</td>
            <td colspan="2" class="td_con td">{$resource.exe_user_time|date='Y-m-d H:i:s',###}</td>
        </tr>
        <tr>
            <td colspan="6" class="td_title td"> <strong>需求描述</strong></td>
        </tr>
        <tr>
            <td class="td_title td">业务类型</td>
            <td colspan="5" class="td_con td">
                <foreach name="service_type" key="k" item="v">
                    <span class="checkboxs_212"><input type="checkbox" name="service_type[]" <?php if(in_array($v,$service_types)){ echo 'checked';} ?>  value="{$v}" >&nbsp; {$v}</span>&#12288;&#12288;
                </foreach>
            </td>
        </tr>
        <tr>
            <td  rowspan="3" class="td_title td">院所、场馆、场地</td>
            <td colspan="5" class="td_con td">
                <div class="form-group col-md-12">
                    <label>资源需求：</label><span ><input class="act_input_500" type="text" name="info[res_need]" value="{$resource['res_need']}" class="form-control" readonly /></span>
                    <div>
                        <label>活动需求：</label>
                        <foreach name="act_need" key="k" item="v">
                            <span class="checkboxs_100"><input type="checkbox" name="act_need[]" <?php if(in_array($v,$act_needs)){ echo 'checked';} ?>  value="{$v}">&nbsp; {$v}</span>&#12288;
                        </foreach>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="5" class="td_con td">
                <div class="form-group col-md-12">
                    <label>特殊需求描述：</label><textarea class="form-control no-border-textarea" value="{$resource['res_special_need']}"  name="info[res_special_need]" readonly>{$resource['res_special_need']}</textarea>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="5" class="td_con td">
                <div class="form-group col-md-12">
                    <label>资源配置反馈：</label><textarea class="form-control no-border-textarea" value="{$resource['res_back_need']}"  name="info[res_back_need]" readonly>{$resource['res_back_need']}</textarea>
                </div>
            </td>
        </tr>
        <tr>
            <td  rowspan="3" class="td_title td">专家、教师</td>
            <td colspan="5" class="td_con td">
                <div class="form-group col-md-12">
                    <div>需求:</div>
                    <foreach name="job_name" key="k" item="v">
                        <!--<span class="checkboxs_400"><input type="checkbox" name="data[{$k}][job_name]" <?php /*if(in_array($v,$job_names)){ echo 'checked';} */?>  value="{$v}">&nbsp; {$v} &#12288;-->
                        <span class="checkboxs_400"><input type="checkbox" name="data[{$k}][job_name]" <?php if($v != null){ echo 'checked';} ?>  value="{$k}">&nbsp; {$k} &#12288;
                                    费用 :&nbsp;<input class="act_input_100" name="data[{$k}][job_money]" value="{$v}" type="text" />
                                </span>&#12288;&#12288;
                    </foreach>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="5" class="td_con td">
                <div class="form-group col-md-12">
                    <label>特殊需求描述（专业、职称、上课时间、学历、性别、实施活动等）：</label><textarea class="form-control no-border-textarea"  name="info[zj_special_need]" readonly>{$resource['zj_special_need']}</textarea>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="5" class="td_con td">
                <div class="form-group col-md-12">
                    <label>资源配置反馈：</label><textarea class="form-control no-border-textarea" value="{$resource['zj_back_need']}"  name="info[zj_back_need]" readonly>{$resource['zj_back_need']}</textarea>
                </div>
            </td>
        </tr>
        <tr>
            <td  rowspan="3" class="td_title td">辅导员</td>
            <td colspan="5" class="td_con td">
                <div class="form-group col-md-12">
                    <label class="inline-block">人数：</label><span class="inline-block" ><input type="text" name="info[cou_num]" value="{$resource['cou_num']}" class="form-control act_input_200" /></span>
                    <label class="inline-block ml20">业务时间：</label><span class="inline-block" ><input type="text" name="info[cou_time]" value="{$resource['cou_time']}" class="form-control act_input_200" /></span>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="5" class="td_con td">
                <div class="form-group col-md-12">
                    <label>特殊需求描述（具体活动如科技节项目数量、学趣班班次、夏令营营期等）：</label><textarea class="form-control no-border-textarea"  name="info[cou_special_need]" readonly>{$resource['cou_special_need']}</textarea>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="5" class="td_con td">
                <div class="form-group col-md-12">
                    <label>资源配置反馈：</label><textarea class="form-control no-border-textarea" value="{$resource['cou_back_need']}"  name="info[cou_back_need]" readonly>{$resource['cou_back_need']}</textarea>
                </div>
            </td>
        </tr>



        <tr>
            <td  rowspan="5" class="td_title td">课程、活动</td>
            <td colspan="5" class="td_con td">
                <div class="form-group col-md-12">
                    <div>课程领域</div>
                    <foreach name="les_field" key="k" item="v">
                        <span class="checkboxs_212"><input type="checkbox" name="les_field[]" <?php if(in_array($v,$les_fields)){ echo 'checked';} ?>  value="{$v}">&nbsp; {$v}</span>&#12288;&#12288;
                    </foreach>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="5" class="td_con td">
                <div class="form-group col-md-12">
                    <div>活动类型</div>
                    <foreach name="act_field" key="k" item="v">
                        <span class="checkboxs_212"><input type="checkbox" name="act_field[]" <?php if(in_array($v,$act_fields)){ echo 'checked';} ?>  value="{$v}">&nbsp; {$v}</span>&#12288;&#12288;
                    </foreach>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="5" class="td_con td">
                <div class="form-group col-md-12">
                    <label>学科（如动物、植物、微生物、天文、地质等）：</label><span ><input class="act_input_500" type="text" name="info[les_name]" value="{$resource['les_name']}" class="form-control" readonly /></span>
                </div>
                <div class="form-group col-md-12">
                    <label>时间要求（每周几、几点至几点、多少周）：&#12288;&#12288;</label><span ><input class="act_input_500" type="text" name="info[les_time]" value="{$resource['les_time']}" class="form-control" readonly /></span>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="5" class="td_con td">
                <div class="form-group col-md-12">
                    <label>特殊需求描述：</label><textarea class="form-control no-border-textarea"  name="info[act_special_need]" readonly>{$resource['act_special_need']}</textarea>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="5" class="td_con td">
                <div class="form-group col-md-12">
                    <label>资源配置反馈：</label><textarea class="form-control no-border-textarea" value="{$resource['act_back_need']}"  name="info[act_back_need]" readonly>{$resource['act_back_need']}</textarea>
                </div>
            </td>
        </tr>
    </table>
    </div>

    <div class="content no-print">
        <!--<button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> 打印</button>-->
        <button class="btn btn-default" onclick="print_part();"><i class="fa fa-print"></i> 打印</button>
        <!--<a href="{:U('Export/member',array('opid'=>$op['op_id']))}" class="btn btn-default"><i class="fa fa-arrow-circle-down"></i> 导出</a>-->
    </div>
</div>


<script type="text/javascript">
    function print_part(){
        /*document.body.innerHTML=document.getElementById('print_1').innerHTML+'<br/>'+document.getElementById('print_2').innerHTML;*/
        document.body.innerHTML=document.getElementById('res_need_table').innerHTML;
        window.print();
    }
</script>