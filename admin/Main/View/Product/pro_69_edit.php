<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">详细信息</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="content">

            <form method="post" action="{:U('Product/public_save')}" name="myform" id="detailForm">
                <input type="hidden" name="dosubmit" value="1">
                <input type="hidden" name="savetype" value="13">
                <!--<input type="hidden" name="need_id" value="{$list.id}">-->
                <input type="hidden" name="id" value="{$detail.id}">
                <input type="hidden" name="opid" value="{$list.op_id}">

                <!--是否标准化-->
                <include file="is_standard" />

                <P class="border-bottom-line"> 业务基本信息</P>
                <div class="form-group col-md-12">
                    <label>活动主题：</label>
                    <input type="text" name="data[title]"  value="{$detail.title}" class="form-control"  />
                </div>

                <div class="form-group col-md-6">
                    <label>主办单位名称：</label>
                    <input type="text" name="data[company]"  value="{$detail.company}" class="form-control"  />
                </div>

                <div class="form-group col-md-6">
                    <label>承办单位名称：</label>
                    <input type="text" name="data[company1]"  value="{$detail.company1}" class="form-control"  />
                </div>

                <div class="form-group col-md-6">
                    <label>申请活动时间：<font color="#999">(可多项)</font></label>
                    <input type="text" name="data[time]"  value="{$detail.time}" class="form-control"  />
                </div>

                <div class="form-group col-md-6">
                    <label>申请活动地点：<font color="#999">(可多项)</font></label>
                    <input type="text" name="data[addr]"  value="{$detail.addr}" class="form-control"  />
                </div>

                <div class="form-group col-md-6">
                    <p><label>布展条件</label></p>
                    <input type="radio" name="data[condition]" value="室内" <?php if ($detail['condition'] == '室内') echo "checked"; ?>> &#8194;室内 &#12288;
                    <input type="radio" name="data[condition]" value="室外" <?php if ($detail['condition'] == '室外') echo "checked"; ?>> &#8194;室外
                </div>

                <div class="form-group col-md-6">
                    <label>可布展面积：</label>
                    <input type="text" name="data[area]"  value="{$detail.area}" class="form-control"  />
                </div>

                <div class="form-group col-md-12">
                    <label>巡展自带项目需求：</label>
                    <input type="checkbox" name="selfOpNeed[]" value="模型展品" <?php if (in_array('模型展品',$selfOpNeeds)) echo "checked"; ?>> &#8194;模型展品 &#12288;
                    <input type="checkbox" name="selfOpNeed[]" value="互动展品" <?php if (in_array('互动展品',$selfOpNeeds)) echo "checked"; ?>> &#8194;互动展品 &#12288;
                    <input type="checkbox" name="selfOpNeed[]" value="球幕影院" <?php if (in_array('球幕影院',$selfOpNeeds)) echo "checked"; ?>> &#8194;球幕影院 &#12288;
                </div>

                <div class="form-group col-md-12">
                    <label>附加项目需求：</label>
                    <input type="checkbox" name="addOpNeed[]" value="科学家讲座" <?php if (in_array('科学家讲座',$addOpNeeds)) echo "checked"; ?>> &#8194;科学家讲座 &#12288;
                    <input type="checkbox" name="addOpNeed[]" value="校园科技节" <?php if (in_array('校园科技节',$addOpNeeds)) echo "checked"; ?>> &#8194;校园科技节 &#12288;
                    <input type="checkbox" name="addOpNeed[]" value="科学实验秀" <?php if (in_array('科学实验秀',$addOpNeeds)) echo "checked"; ?>> &#8194;科学实验秀 &#12288;
                </div>

                <P class="border-bottom-line"> 申请单位联系方式</P>
                <div class="form-group col-md-6">
                    <label>姓名：</label>
                    <input type="text" name="data[name]"  value="{$detail.name}" class="form-control"  />
                </div>

                <div class="form-group col-md-6">
                    <label>办公电话：</label>
                    <input type="text" name="data[tel]"  value="{$detail.tel}" class="form-control"  />
                </div>

                <div class="form-group col-md-6">
                    <label>职称/职务：</label>
                    <input type="text" name="data[post]"  value="{$detail.post}" class="form-control"  />
                </div>

                <div class="form-group col-md-6">
                    <label>手机：</label>
                    <input type="text" name="data[mobile]"  value="{$detail.mobile}" class="form-control"  />
                </div>

                <div class="form-group col-md-6">
                    <label>传真：</label>
                    <input type="text" name="data[fax]"  value="{$detail.fax}" class="form-control"  />
                </div>

                <div class="form-group col-md-6">
                    <label>电子邮箱：</label>
                    <input type="text" name="data[email]"  value="{$detail.email}" class="form-control"  />
                </div>

                <div class="form-group col-md-12">
                    <label>附件 ：<font color="#999">（关于活动简介）</font></label>
                    <textarea class="form-control"  name="data[content]">{$detail.content}</textarea>
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