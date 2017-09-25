<include file="Index:header_art" />

	<script type="text/javascript">
	window.gosubmint= function(){
		$('#gosub').submit();
	} 
	</script>
    
    <div class="box-body art_box-body">
        
        <div class="fromlist fromlistbrbr">
            <div class="formtexts">
            	<h4>{$row.title}</h4>
                <span class="fr">执行月份：{$row.month}</span>
				<span class="fr">发布者：{$row.inc_user_name}</span>
                <span class="fr">发布时间：{$row.create_time|date='Y-m-d H:i',###}</span>
                <span class="fr" style="border:none;">状态：{$row.statusstr}</span>
            </div>
        </div>
        
        <div class="fromlist fromlistbrbr"  style=" padding:15px 0 0 0;">
            <div class="form-group box-float-4" style="padding-left:0;">责任人员：{$row.rp_user_name}</div>
            <div class="form-group box-float-4" style="padding-left:0;">所在部门：{$row.rp_post}</div>
            <div class="form-group box-float-4" style="padding-left:0;">直接领导：{$row.ld_user_name}</div>
            <div class="form-group box-float-4" style="padding-left:0;">发现人员：{$row.fd_user_name}</div>
            <div class="form-group box-float-4" style="padding-left:0;">发现时间：{$row.fd_date}</div>
            <div class="form-group box-float-4" style="padding-left:0;">陪同人员：{$row.ac_user_name}</div>
        </div>
        
        <div class="fromlist nobor" style="margin-top:10px;">
            <div class="fromtitle">不合格事实陈述及违反规定条款：</div> 
            <div class="formtexts">{$row.chen}</div>
        </div>
        
        <div class="fromlist">
            <div class="fromtitle">原因分析：</div>
            <div class="formtexts">{$row.reason}</div>
        </div>
        
        <div class="fromlist">
            <div class="fromtitle">纠正措施的验证：</div>
            <div class="formtexts">{$row.verif}</div>
        </div>
                             
    </div>                  
    
    <include file="Index:footer" />
        
       