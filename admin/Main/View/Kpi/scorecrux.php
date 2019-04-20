<include file="Index:header_art" />
<script type="text/javascript">
    window.gosubmint= function(){
        $('#gosub').submit();
    }
</script>
    
    <div class="box-body art_box-body">
        
        <div class="fromlist fromlistbrbr">
            <div class="formtexts">
            	<h4>{$list.title}</h4>
                <!--<span class="fr">姓名：{$list.user_name}</span>
				<span class="fr">考核周期：{$list.cycle_stu}</span>
                <span class="fr">相关月份：{$list.month}</span>-->
            </div>
        </div>

        <div class="fromlist fromlistbrbr"  style=" padding:15px 0 0 0;">
            <div class="form-group box-float-6" style="padding-left:0;">姓名：{$list.user_name}</div>
            <div class="form-group box-float-6" style="padding-left:0;">考核周期：{$list.cycle_stu}</div>
            <div class="form-group box-float-6" style="padding-left:0;">相关月份：{$list.month}</div>
            <div class="form-group box-float-6" style="padding-left:0;">权重：{$list.weight}%</div>
            <div class="form-group box-float-6" style="padding-left:0;">考核标准：{$list.standard}</div>
            <div class="form-group box-float-6" style="padding-left:0;">考核得分：{$list.score_stu}</div>
        </div>
        
        <div class="fromlist fromlistbrbr " style="margin-top:10px;">
            <div class="fromtitle">考核内容：</div>
            <div class="formtexts">{$list.content}</div>
        </div>

        <div class="fromlist nobor">
            <form method="post" action="{:U('Kpi/public_save')}" name="myform" id="gosub">
                <input type="hidden" name="dosubmint" value="1">
                <input type="hidden" name="savetype" value="2">
                <input type="hidden" name="id" value="{$list.id}">

                <div class="form-group box-float-6" style="margin-top:15px;">
                    <label>权重</label>
                    <input type="text" value="{$list.weight}"  class="form-control" readonly />
                </div>

                <div class="form-group box-float-6" style="margin-top:15px;">
                    <label>评分 <font color="#999999">建议评分不大于权重分</font></label>
                    <input type="text" name="info[score]" id="title" value="{$list.score}"  class="form-control" />
                </div>


                <div class="form-group box-float-12">
                    <label>评分人意见</label>
                    <textarea class="form-control" style="height:90px;" name="info[audit_suggest]">{$list.audit_suggest}</textarea>
                </div>

            </form>
        </div>
                             
    </div>                  
    
    <include file="Index:footer" />
        
       