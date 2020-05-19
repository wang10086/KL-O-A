
    <div class="box-body">
        <div class="row"><!-- right column -->

        <div class="form-group col-md-12" id="print_table" style="align: center; display: none">
            <div class="form-group col-md-12">
                <table style="width: 100%; margin-top: 20px;">
                    <tr>
                        <td class="td_title" colspan="6">
                            <div class="form-group col-md-12">
                                <h4>科学快车业务需求表</h4>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6" class="td_title td black">业务基本信息</td>
                    </tr>
                    <tr>
                        <td class="td_title td">主办单位名称</td>
                        <td colspan="5" class="td_con td">{$detail.company}</td>
                    </tr>
                    <tr>
                        <td class="td_title td">承办单位名称</td>
                        <td colspan="5" class="td_con td">{$detail.company1}</td>
                    </tr>
                    <tr>
                        <td class="td_title td">活动主题</td>
                        <td colspan="5" class="td_con td">{$detail.title}</td>
                    </tr>
                    <tr>
                        <td class="td_title td">申请活动时间(可多项)</td>
                        <td colspan="5" class="td_con td">{$detail.time}</td>
                    </tr>
                    <tr>
                        <td class="td_title td">申请活动地点(可多项)</td>
                        <td colspan="5" class="td_con td">{$detail.addr}</td>
                    </tr>
                    <tr>
                        <td class="td_title td">布展条件</td>
                        <td colspan="2" class="td_con td">{$detail.condition}</td>
                        <td class="td_title td">可布展面积</td>
                        <td colspan="2" class="td_con td">{$detail.area}</td>
                    </tr>
                    <tr>
                        <td class="td_title td">巡展自带项目需求</td>
                        <td colspan="5" class="td_con td">
                            <input type="checkbox" name="selfOpNeed[]" value="模型展品" <?php if (in_array('模型展品',$selfOpNeeds)) echo "checked"; ?>> &#8194;<?php if (in_array('模型展品',$selfOpNeeds)) echo "√&nbsp;"; ?>模型展品 &#12288;
                            <input type="checkbox" name="selfOpNeed[]" value="互动展品" <?php if (in_array('互动展品',$selfOpNeeds)) echo "checked"; ?>> &#8194;<?php if (in_array('互动展品',$selfOpNeeds)) echo "√&nbsp;"; ?>互动展品 &#12288;
                            <input type="checkbox" name="selfOpNeed[]" value="球幕影院" <?php if (in_array('球幕影院',$selfOpNeeds)) echo "checked"; ?>> &#8194;<?php if (in_array('球幕影院',$selfOpNeeds)) echo "√&nbsp;"; ?>球幕影院 &#12288;
                        </td>
                    </tr>
                    <tr>
                        <td class="td_title td">附加项目需求</td>
                        <td colspan="5" class="td_con td">
                            <input type="checkbox" name="addOpNeed[]" value="科学家讲座" <?php if (in_array('科学家讲座',$addOpNeeds)) echo "checked"; ?>> &#8194;<?php if (in_array('科学家讲座',$addOpNeeds)) echo "√&nbsp;"; ?>科学家讲座 &#12288;
                            <input type="checkbox" name="addOpNeed[]" value="校园科技节" <?php if (in_array('校园科技节',$addOpNeeds)) echo "checked"; ?>> &#8194;<?php if (in_array('校园科技节',$addOpNeeds)) echo "√&nbsp;"; ?>校园科技节 &#12288;
                            <input type="checkbox" name="addOpNeed[]" value="科学实验秀" <?php if (in_array('科学实验秀',$addOpNeeds)) echo "checked"; ?>> &#8194;<?php if (in_array('科学实验秀',$addOpNeeds)) echo "√&nbsp;"; ?>科学实验秀 &#12288;
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6" class="td_title td black">申请单位联系方式</td>
                    </tr>
                    <tr>
                        <td class="td_title td">姓名</td>
                        <td colspan="2" class="td_con td">{$detail.name}</td>
                        <td class="td_title td">办公电话</td>
                        <td colspan="2" class="td_con td">{$detail.tel}</td>
                    </tr>
                    <tr>
                        <td class="td_title td">职称/职务</td>
                        <td colspan="2" class="td_con td">{$detail.post}</td>
                        <td class="td_title td">手机</td>
                        <td colspan="2" class="td_con td">{$detail.mobile}</td>
                    </tr>
                    <tr>
                        <td class="td_title td">传真</td>
                        <td colspan="2" class="td_con td">{$detail.fax}</td>
                        <td class="td_title td">电子邮箱</td>
                        <td colspan="2" class="td_con td">{$detail.email}</td>
                    </tr>
                    <tr>
                        <td class="td_title td">附件(关于活动简介)</td>
                        <td colspan="5" class="td_con td"> {$detail.content} </td>
                    </tr>
                    <tr>
                        <td class="td_con td" colspan="6">填完此表,市场部下载后可送给科学文化传播处kxwhcb@caseab.ac.cn，联系人：010-82613356  </td>
                    </tr>
                </table>
            </div>
        </div>
        <!--<div class="content no-print">
            <button class="btn btn-default" onclick="print_part();"><i class="fa fa-print"></i> 打印</button>
        </div>-->
        </div><!--/.col (right) -->
    </div>
    <!--<div class="content" style="padding-top:40px;">  暂未填写物资需求单!</div>-->
