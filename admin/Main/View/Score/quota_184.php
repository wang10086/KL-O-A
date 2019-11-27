<div class="contentAA">
    <input type="hidden" name="info[guide_id]" value="{$guide_id}">
    <input type="hidden" name="info[op_id]" value="{$opid}">
    <input type="hidden" name="info[dimension]" value="4"> <!--考核维度-->
    <input type="hidden" id="AA_num" name="info[AA]" value="" />
    <input type="hidden" id="BB_num" name="info[BB]" value="" />
    <input type="hidden" id="CC_num" name="info[CC]" value="" />
    <input type="hidden" id="DD_num" name="info[DD]" value="" />

    <div class="form-group col-md-12"></div>
    <div class="form-group col-md-12">
        <input type="hidden" name="info[AA_title]" value="讲座前沟通">
        <label>1、讲座前沟通：</label>
        <div class="demo score inline-block"><div id="AA"></div></div>
    </div>
    <div class="form-group col-md-12">
        <input type="hidden" name="info[BB_title]" value="接送安排">
        <label>2、接送安排：</label>
        <div class="demo score inline-block"><div id="BB"></div></div>
    </div>

    <div class="form-group col-md-12">
        <input type="hidden" name="info[CC_title]" value="现场安排">
        <label>3、现场安排：</label>
        <div class="demo score inline-block"><div id="CC"></div></div>
    </div>

    <div class="form-group col-md-12">
        <input type="hidden" name="info[DD_title]" value="费用支付">
        <label>4、费用支付：</label>
        <div class="demo score inline-block"><div id="DD"></div></div>
    </div>

    <div class="form-group col-md-12">
        <label>意见建议：</label>
        <textarea name="content" class="form-control"  rows="2" placeholder="请输入意见建议"></textarea>
    </div>
</div>