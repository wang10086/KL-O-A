<!--研发部实施专家-->
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
        <input type="hidden" id="EE_num" name="sco[EE]" value="" />
        <input type="hidden" name="sco[dimension]" value="5">
        <div class="form-group col-md-4">
            <input type="hidden" name="data[AA]" value="顾客需求匹配度" />
            <label>顾客需求匹配度：</label>
            <div class="demo score">
                <div id="AA"></div>
            </div>
        </div>
        <div class="form-group col-md-4">
            <input type="hidden" name="data[BB]" value="产品创新性（含特色和亮点）" />
            <label>产品创新性（含特色和亮点）：</label>
            <div class="demo score">
                <div id="BB"></div>
            </div>
        </div>
        <div class="form-group col-md-4">
            <input type="hidden" name="data[CC]" value="产品成本控制" />
            <label>产品成本控制：</label>
            <div class="demo score">
                <div id="CC"></div>
            </div>
        </div>
        <div class="form-group col-md-4">
            <input type="hidden" name="data[DD]" value="产品可行性及安全性" />
            <label>产品可行性及安全性：</label>
            <div class="demo score">
                <div id="DD"></div>
            </div>
        </div>
        <div class="form-group col-md-4">
            <input type="hidden" name="data[EE]" value="工单内容完成度（含材料单、手册、任务卡、折页等）" />
            <label>工单内容完成度（含材料单、手册、任务卡、折页等）：</label>
            <div class="demo score">
                <div id="EE"></div>
            </div>
        </div>
        <textarea name="sco[content]" class="form-control" id="content"  rows="2" placeholder="请输入对该工单评价内容"></textarea>
    </div>
</div>