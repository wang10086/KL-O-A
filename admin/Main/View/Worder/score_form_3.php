<!--研发部实施专家-->
<label class="lit-title" style="width: 98%;margin: 0 1%">请对工单完成质量评价
    <span style="float: right;clear: both;font-weight: normal;">工单执行人：<?php echo $info['assign_name']?$info['assign_name']:$info['exe_user_name']; ?></span>
</label>
<div class="content mt20" id="guidelist" style="display:block;">
    <input type="hidden" name="sco[bpfr_id]" value="<?php echo $info['assign_id']?$info['assign_id']:$info['exe_user_id']; ?>" />
    <input type="hidden" name="sco[bpfr_name]" value="<?php echo $info['assign_name']?$info['assign_name']:$info['exe_user_name']; ?>" />
    <div style="width:100%;float:left;">
        <input type="hidden" id="text_num" name="sco[text]" value="" />
        <input type="hidden" id="pic_num" name="sco[pic]" value="" />
        <input type="hidden" id="article_num" name="sco[article]" value="" />
        <div class="form-group col-md-4">
            <label>定制产品专业质量：</label>
            <div class="demo score">
                <div id="text"></div>
            </div>
        </div>
        <div class="form-group col-md-4">
            <label>及时性：</label>
            <div class="demo score">
                <div id="pic"></div>
            </div>
        </div>
        <div class="form-group col-md-4">
            <label>服务态度：</label>
            <div class="demo score">
                <div id="article"></div>
            </div>
        </div>
        <textarea name="sco[content]" class="form-control" id="content"  rows="2" placeholder="请输入对该工单评价内容"></textarea>
    </div>
</div>