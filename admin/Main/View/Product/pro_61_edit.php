<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">详细信息</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="content">

            <form method="post" action="{:U('Product/public_save')}" name="myform" id="detailForm">
                <input type="hidden" name="dosubmit" value="1">
                <input type="hidden" name="savetype" value="15">
                <!--<input type="hidden" name="need_id" value="{$list.id}">-->
                <input type="hidden" name="id" value="{$detail.id}">
                <input type="hidden" name="opid" value="{$list.op_id}">

                <!--是否标准化-->
                <include file="is_standard" />

                <P class="border-bottom-line"> 基本信息</P>
                <div class="form-group col-md-4">
                    <label>客户单位：</label><input type="text" name="data[customer]"  value="{$detail.customer}" class="form-control"  required />
                </div>

                <div class="form-group col-md-4">
                    <label>参与人数(1-3人)：</label><input type="text" name="data[num]"  value="{$detail.num}" class="form-control"  required />
                </div>

                <div class="form-group col-md-4">
                    <label>活动时间：<font color="#999">(注明开题/结题时间)</font> </label>
                    <!--<input type="text" name="in_time"  value="<?php /*echo $detail['st_time'] ? date('H:i:s',$detail['st_time']).' - '.date('H:i:s',$detail['et_time']) : ''; */?>" class="form-control inputdate_b"  required />-->
                    <input type="text" name="data[in_time]"  value="{$detail.in_time}" class="form-control"  required />
                </div>

                <div class="form-group col-md-4">
                    <label>所在年级：</label><input type="text" name="data[grade]"  value="{$detail.grade}" class="form-control"  />
                </div>

                <div class="form-group col-md-4">
                    <label>选定的课题研究方向：</label><input type="text" name="data[field]"  value="{$detail.field}" class="form-control"  />
                </div>

                <div class="form-group col-md-4">
                    <label>涉及学科：</label><input type="text" name="data[subject]"  value="{$detail.subject}" class="form-control"  />
                </div>

                <div class="form-group col-md-12">
                    <label>课题类型：</label>
                    <input type="checkbox" name="pro_type[]" value="观察探究类" <?php if (in_array('观察探究类',explode(',',$detail['pro_type']))) echo "checked"; ?>> &#8194;观察探究类 &#12288;
                    <input type="checkbox" name="pro_type[]" value="社会调查类" <?php if (in_array('社会调查类',explode(',',$detail['pro_type']))) echo "checked"; ?>> &#8194;社会调查类 &#12288;
                    <input type="checkbox" name="pro_type[]" value="技术发明类" <?php if (in_array('技术发明类',explode(',',$detail['pro_type']))) echo "checked"; ?>> &#8194;技术发明类 &#12288;
                    <input type="checkbox" name="pro_type[]" value="其它" <?php if (in_array('其它',explode(',',$detail['pro_type']))) echo "checked"; ?>> &#8194;其它 &#12288;
                </div>

                <div class="form-group col-md-12">
                    <label>活动地点：</label>
                    <input type="checkbox" name="pro_addr[]" value="中科院实验室" <?php if (in_array('中科院实验室',explode(',',$detail['pro_addr']))) echo "checked"; ?>> &#8194;中科院实验室 &#12288;
                    <input type="checkbox" name="pro_addr[]" value="学校科学教室" <?php if (in_array('学校科学教室',explode(',',$detail['pro_addr']))) echo "checked"; ?>> &#8194;学校科学教室 &#12288;
                    <input type="checkbox" name="pro_addr[]" value="其它" <?php if (in_array('其它',explode(',',$detail['pro_addr']))) echo "checked"; ?>> &#8194;其它 &#12288;
                </div>

                <P class="border-bottom-line"> 专家资源信息</P>
                <div class="form-group col-md-12">
                    <label>所需专家级别：</label>
                    <input type="checkbox" name="expert_level[]" value="院士、研究员" <?php if (in_array('院士、研究员',explode(',',$detail['expert_level']))) echo "checked"; ?>> &#8194;院士、研究员 &#12288;
                    <input type="checkbox" name="expert_level[]" value="副研、青年博物及科普专家" <?php if (in_array('副研、青年博物及科普专家',explode(',',$detail['expert_level']))) echo "checked"; ?>> &#8194;副研、青年博物及科普专家 &#12288;
                    <input type="checkbox" name="expert_level[]" value="兼职骨干教师（硕士/博士研究生）" <?php if (in_array('兼职骨干教师（硕士/博士研究生）',explode(',',$detail['expert_level']))) echo "checked"; ?>> &#8194;兼职骨干教师（硕士/博士研究生） &#12288;
                </div>

                <P class="border-bottom-line"> 专家资源信息</P>
                <div class="form-group col-md-12">
                    <label>成果形式：</label>
                    <input type="checkbox" name="resulted[]" value="院士、研究员" <?php if (in_array('院士、研究员',explode(',',$detail['resulted']))) echo "checked"; ?>> &#8194;院士、研究员 &#12288;
                    <input type="checkbox" name="resulted[]" value="副研、青年博物及科普专家" <?php if (in_array('副研、青年博物及科普专家',explode(',',$detail['resulted']))) echo "checked"; ?>> &#8194;副研、青年博物及科普专家 &#12288;
                    <input type="checkbox" name="resulted[]" value="兼职骨干教师（硕士/博士研究生）" <?php if (in_array('兼职骨干教师（硕士/博士研究生）',explode(',',$detail['resulted']))) echo "checked"; ?>> &#8194;兼职骨干教师（硕士/博士研究生） &#12288;
                </div>

                <div class="form-group col-md-12">
                    <label>是否参加科技竞赛：</label>
                    <input type="checkbox" name="match[]" value="不参加比赛" <?php if (in_array('不参加比赛',explode(',',$detail['match']))) echo "checked"; ?>> &nbsp;不参加比赛 &#12288;
                    <input type="checkbox" name="match[]" value="参加青少年科技创新大赛" <?php if (in_array('参加青少年科技创新大赛',explode(',',$detail['match']))) echo "checked"; ?>> &nbsp;参加青少年科技创新大赛 &#12288;
                    <input type="checkbox" name="match[]" value="参加金鹏科技论坛" <?php if (in_array('参加金鹏科技论坛',explode(',',$detail['match']))) echo "checked"; ?>> &nbsp;参加金鹏科技论坛 &#12288;
                    <input type="checkbox" name="match[]" value="参加机器人比赛" <?php if (in_array('参加机器人比赛',explode(',',$detail['match']))) echo "checked"; ?>> &nbsp;参加机器人比赛 &#12288;
                    <input type="checkbox" name="match[]" value="参加其它比赛" <?php if (in_array('参加其它比赛',explode(',',$detail['match']))) echo "checked"; ?>> &nbsp;参加其它比赛 &#12288;
                    如：<input type="text" name="data[other_match]" value="{$detail['other_match']}" style="border: none; border-bottom: solid 1px; width: 100px;" >
                </div>

                <div class="form-group col-md-12">
                    <label>其他相关需求</label>
                    <textarea class="form-control"  name="data[other_condition]">{$detail.other_condition}</textarea>
                </div>
            </form>

            <form method="post" action="{:U('Product/public_save')}" name="myform" id="submitForm">
                <input type="hidden" name="dosubmit" value="1">
                <input type="hidden" name="savetype" value="7">
                <input type="hidden" name="id" value="{$list.id}">
            </form>

            <!--保存 提交按钮-->
            <include file="pro_submit_btns" />

            <!--<div id="formsbtn">
                <button type="button" class="btn btn-info btn-sm" onclick="$('#detailForm').submit()">保存</button>
                <?php /*if ($detail['id'] && $list['process'] == 0){ */?>
                    <button type="button" class="btn btn-warning btn-sm" onclick="$('#submitForm').submit()" >提交</button>
                <?php /*} */?>
            </div>-->
        </div>
    </div><!-- /.box-body -->
</div>