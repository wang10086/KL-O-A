<!--京区业务中心微信运营专员-->
<label class="lit-title" style="width: 98%;margin: 0 1%">请对工单完成质量评价
    <span style="float: right;clear: both;font-weight: normal;">工单执行人：<?php echo $info['assign_name']?$info['assign_name']:$info['exe_user_name']; ?></span>
</label>
<div class="content mt20" id="guidelist" style="display:block;">
    <input type="hidden" name="sco[account_id]" value="<?php echo $info['assign_id']?$info['assign_id']:$info['exe_user_id']; ?>" />
    <input type="hidden" name="sco[account_name]" value="<?php echo $info['assign_name']?$info['assign_name']:$info['exe_user_name']; ?>" />
    <div style="width:100%;float:left;">
        <input type="hidden" id="AA_num" name="sco[AA]" value="" />
        <input type="hidden" id="BB_num" name="sco[BB]" value="" />
        <input type="hidden" id="CC_num" name="sco[CC]" value="" />
        <input type="hidden" id="DD_num" name="sco[DD]" value="" />
        <input type="hidden" name="sco[dimension]" value="4">
        <div class="form-group col-md-6">
            <input type="hidden" name="data[AA]" value="文字准确度" />
            <label>文字准确度：</label>
            <div class="demo score">
                <div id="AA"></div>
            </div>
        </div>
        <div class="form-group col-md-6">
            <input type="hidden" name="data[BB]" value="图片准确性" />
            <label>图片准确性：</label>
            <div class="demo score">
                <div id="BB"></div>
            </div>
        </div>
        <div class="form-group col-md-6">
            <input type="hidden" name="data[CC]" value="文章要素完整性" />
            <label>文章要素完整性：</label>
            <div class="demo score">
                <div id="CC"></div>
            </div>
        </div>
        <div class="form-group col-md-6">
            <input type="hidden" name="data[DD]" value="文章选题有创意、策划有亮点、符合客户需求" />
            <label>文章选题有创意、策划有亮点、符合客户需求：</label>
            <div class="demo score">
                <div id="DD"></div>
            </div>
        </div>
        <textarea name="sco[content]" class="form-control" id="content"  rows="2" placeholder="请输入对该工单评价内容"></textarea>
    </div>
</div>