<form method="post" action="{:U('Op/public_save')}" name="" id="">
    <input type="hidden" name="dosubmint" value="1">
    <input type="hidden" name="savetype" value="24">
    <input type="hidden" name="opid" value="{$op.op_id}">
    <input type="hidden" name="id" value="{$cneed_edit.id}">
    <div class="content" style="padding-bottom:20px;">

        <div style="width:100%; float:left;">
            <div class="form-group col-md-6">
                <label>申请人：</label>
                <input type="text" name="cneed[input_user_name]"  class="form-control" value="{:cookie('nickname')}" readonly />
                <input type="hidden" name="cneed[input_user_id]"  class="form-control" value="{:cookie('userid')}"  />
            </div>

            <div class="form-group col-md-6">
                <label>活动名称：</label>
                <input type="text" name="cneed[title]" class="form-control" value="{$cneed_edit['title'] ? $cneed_edit['title'] :$op['project']}" required />
            </div>

            <div class="form-group col-md-6">
                <label>实际出发时间：</label>
                <input type="text" name="cneed[dep_time]" class="form-control inputdate" value="<if condition="$cneed_edit['dep_time']">{$cneed_edit.dep_time|date='Y-m-d',###}</if>" required />
            </div>
            <div class="form-group col-md-6">
                <label>实际返回时间：</label>
                <input type="text" name="cneed[ret_time]" class="form-control inputdate" value="<if condition="$cneed_edit['ret_time']">{$cneed_edit.ret_time|date='Y-m-d',###}</if>" required />
            </div>

            <div class="form-group col-md-12">
                <label>说明原因：<font color="#999">含不可抗力改期、取消、人员增加、物料增加等</font></label>
                <textarea class="form-control"  name="cneed[why]" required>{$cneed_edit.why}</textarea>
            </div>

            <div class="form-group col-md-12">
                <label>变更后的影响：</label>
                <textarea class="form-control"  name="cneed[ffect]" required>{$cneed_edit.ffect}</textarea>
            </div>

            <div class="form-group col-md-12">
                <label>变更后的纠正措施：<font color="#999">（申请者提供各种可行性方案及每种方案的利弊，包含最佳方案的推荐，方便决策者作出判断）</font></label>
                <textarea class="form-control"  name="cneed[right]" required>{$cneed_edit.right}</textarea>
            </div>

            <div class="form-group col-md-12">
                <label>变更前要素：</label>
                <textarea class="form-control"  name="cneed[before]" required>{$cneed_edit.before}</textarea>
            </div>

            <div class="form-group col-md-12">
                <label>变更后要素：</label>
                <textarea class="form-control"  name="cneed[after]" required>{$cneed_edit.after}</textarea>
            </div>
        </div>
    </div>

    <div id="formsbtn" style="padding-bottom:10px;margin-top:0;">
        <div class="content" style="margin-top:0;">
            <button type="submit" class="btn btn-info btn-sm" style="">提交</button>
        </div>
    </div>
</form>