<include file="Index:header_art" />
    
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
        
        <div class="fromlist nobor" style="margin-top:10px;">
            <div class="fromtitle">考核内容：</div>
            <div class="formtexts">{$list.content}</div>
        </div>

        <!--<div class="fromlist">
            <div class="fromtitle">原因分析：</div>
            <div class="formtexts">{$list.reason}</div>
        </div>-->
        
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
        
       