<!--京区业务中心平面设计专员-->
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
        <input type="hidden" id="habit_num" name="sco[habit]" value="" />
        <input type="hidden" id="hot_num" name="sco[hot]" value="" />
        <div class="form-group col-md-4">
            <label>文字准确度：</label>
            <div class="demo score">
                <div id="text"></div>
            </div>
        </div>
        <div class="form-group col-md-4">
            <label>图片准确性：</label>
            <div class="demo score">
                <div id="pic"></div>
            </div>
        </div>
        <div class="form-group col-md-4">
            <label>文章要素完整性：</label>
            <div class="demo score">
                <div id="article"></div>
            </div>
        </div>
        <div class="form-group col-md-6">
            <label>设计考虑用户使用习惯、各类推广牵引效果、情感及体验感受：</label>
            <div class="demo score">
                <div id="habit"></div>
            </div>
        </div>
        <div class="form-group col-md-6">
            <label>即时掌握相关热点，匹配专题策划、 活动，提高客户成交率：</label>
            <div class="demo score">
                <div id="hot"></div>
            </div>
        </div>
        <textarea name="sco[content]" class="form-control" id="content"  rows="2" placeholder="请输入对该工单评价内容"></textarea>
    </div>
</div>