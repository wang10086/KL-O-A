<include file="Index:header_art" />

	<script type="text/javascript">
	window.gosubmint= function(){
		$('#gosub').submit();
	} 
	</script>
    
    <div class="box-body art_box-body">
        
        <div class="fromlist fromlistbrbr">
            <div class="formtexts">
            	<h4>评分月份：{$list.monthly}</h4>
				<span class="fr">评价人：{$list.account_name}</span>
                <span class="fr">评价时间：{$list.create_time|date='Y-m-d H:i',###}</span>
                <!--<span class="fr" style="border:none;">处理结果：{$row.status}</span>-->
            </div>
        </div>
        
        <div class="fromlist "  style=" padding:15px 0 0 0;">
            <?php if ($has_rd == 1){ ?>
                <div class="form-group box-float-4" style="padding-left:0;">培训：{$list.timely}&nbsp;分</div>
                <div class="form-group box-float-4" style="padding-left:0;">标准化：{$list.accord}&nbsp;分</div>
                <div class="form-group box-float-4" style="padding-left:0;">支持、指导：{$list.cost}&nbsp;分</div>
                <div class="form-group box-float-4" style="padding-left:0;">及时性：{$list.train}&nbsp;分</div>
                <div class="form-group box-float-4" style="padding-left:0;">工作态度：{$list.service}&nbsp;分</div>
            <?php }else{ ?>
                <div class="form-group box-float-4" style="padding-left:0;">及时性：{$list.timely}&nbsp;分</div>
                <div class="form-group box-float-4" style="padding-left:0;">符合性：{$list.accord}&nbsp;分</div>
                <div class="form-group box-float-4" style="padding-left:0;">成本控制：{$list.cost}&nbsp;分</div>
                <div class="form-group box-float-4" style="padding-left:0;">培训：{$list.train}&nbsp;分</div>
                <div class="form-group box-float-4" style="padding-left:0;">服务态度：{$list.service}&nbsp;分</div>
            <?php } ?>
            </if>

             <div class="form-group box-float-12" style="padding-left:0;">意见建议：{$list.content}</div>
        </div>
                             
    </div>                  
    
    <include file="Index:footer" />
        
       