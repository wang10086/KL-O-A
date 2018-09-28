<include file="Index:header_art" />

	<script type="text/javascript">
	window.gosubmint= function(){
		$('#gosub').submit();
	} 
	</script>
    
    <div class="box-body art_box-body">
        
        <div class="fromlist fromlistbrbr">
            <div class="formtexts">
            	<h4>{$row.project}</h4>
				<span class="fr">联系方式：{$row.mobile}</span>
                <span class="fr">投票时间：{$row.input_time|date='Y-m-d H:i',###}</span>
                <!--<span class="fr" style="border:none;">处理结果：{$row.status}</span>-->
            </div>
        </div>
        
        <div class="fromlist fromlistbrbr"  style=" padding:15px 0 0 0;">
            <if condition="$kind eq 1">
                <div class="form-group box-float-4" style="padding-left:0;">房：{$score_stu.$row[stay]}</div>
                <div class="form-group box-float-4" style="padding-left:0;">餐：{$score_stu.$row[food]}</div>
                <div class="form-group box-float-4" style="padding-left:0;">车：{$score_stu.$row[bus]}</div>
                <div class="form-group box-float-4" style="padding-left:0;">行程安排：{$score_stu.$row[travel]}</div>
                <div class="form-group box-float-4" style="padding-left:0;">活动内容：{$score_stu.$row[content]}</div>
                <div class="form-group box-float-4" style="padding-left:0;">司机：{$score_stu.$row[driver]}</div>
                <div class="form-group box-float-4" style="padding-left:0;">辅导员/领队：{$score_stu.$row[guide]}</div>
                <div class="form-group box-float-4" style="padding-left:0;">教师/专家：{$score_stu.$row[teacher]}</div>
                <div class="form-group box-float-4" style="padding-left:0;"></div>
            <else />
                <div class="form-group box-float-4" style="padding-left:0;">课程深度：{$score_stu.$row[depth]}</div>
                <div class="form-group box-float-4" style="padding-left:0;">课程专业性：{$score_stu.$row[major]}</div>
                <div class="form-group box-float-4" style="padding-left:0;">课程趣味性：{$score_stu.$row[interest]}</div>
                <div class="form-group box-float-4" style="padding-left:0;">专家/讲师：{$score_stu.$row[teacher]}</div>
                <div class="form-group box-float-4" style="padding-left:0;">辅导员：{$score_stu.$row[guide]}</div>
                <div class="form-group box-float-4" style="padding-left:0;">材料及设备：{$score_stu.$row[material]}</div>
            </if>

             <div class="form-group box-float-12" style="padding-left:0;">意见建议：{$row.suggest}</div>
        </div>
        
        <!--<div class="fromlist nobor" style="margin-top:10px;">
            <div class="formtexts">
                <span class="fr">处理人员：{$row.nickname}</span>
                <if condition="$row['solve_time']">
                    <span class="fr">投票时间：{$row.solve_time|date='Y-m-d H:i',###}</span>
                </if>
                <span class="fr" style="border:none;">处理结果：{$row.status}</span>
            </div>
        </div>-->

        <div class="fromlist">
            <div class="fromtitle">原因分析：</div>
            <div class="formtexts">{$row.problem}</div>
        </div>
        
        <div class="fromlist ">
            <div class="fromtitle">解决方案：</div>
            <div class="formtexts">{$row.resolvent}</div>
        </div>
        
        <!--<div id="qaqclist" style="margin:15px; ">
        	<table class="table" style="border-top:2px solid #f39c12; " >
                <tr>
                    <th width="15%">人员</th>
                    <th width="15%">类型</th>
                    <th width="15%">分数</th>
                    <th>备注</th>
                </tr>
                
            	<foreach name="userlist" key="k" item="v">
            	<tr>
                    <td style="padding:8px; line-height:24px;">{$v.user_name}</td>
                    <td style="padding:8px; line-height:24px;"><?php /*if($v['type']==0){ echo '惩罚';}else{ echo '奖励';} */?></td>
                    <td style="padding:8px; line-height:24px;"><?php /*if($v['type']==0){ echo '-';}else{ echo '+';} */?>{$v.score}分</td>
                    <td style="padding:8px; line-height:24px;">{$v.remark}</td>
                </tr>
            	</foreach>
            </table>
        </div>-->
                             
    </div>                  
    
    <include file="Index:footer" />
        
       