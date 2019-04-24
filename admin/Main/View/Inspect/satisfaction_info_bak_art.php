<include file="Index:header_art" />

	<script type="text/javascript">
	window.gosubmint= function(){
		$('#gosub').submit();
	} 
	</script>
    
    <div class="box-body art_box-body">
        
        <div class="fromlist fromlistbrbr">
            <div class="formtexts">
                <h4>被评价人：{$list.account_name}</h4>
                <span class="fr">评价月份：{$list.monthly}</span>
                <span class="fr">评价人：{$list.score_account_name}</span>
            </div>
        </div>
        
        <div class="fromlist "  style=" padding:15px 0 0 0;">
            <?php if ($list['AA']){ ?> <div class="form-group box-float-4" style="padding-left:0;">{$list.aa}：{$list.AA}&nbsp;分</div> <?php } ?>
            <?php if ($list['BB']){ ?> <div class="form-group box-float-4" style="padding-left:0;">{$list.bb}：{$list.BB}&nbsp;分</div> <?php } ?>
            <?php if ($list['CC']){ ?> <div class="form-group box-float-4" style="padding-left:0;">{$list.cc}：{$list.CC}&nbsp;分</div> <?php } ?>
            <?php if ($list['DD']){ ?> <div class="form-group box-float-4" style="padding-left:0;">{$list.dd}：{$list.DD}&nbsp;分</div> <?php } ?>
            <?php if ($list['EE']){ ?> <div class="form-group box-float-4" style="padding-left:0;">{$list.ee}：{$list.EE}&nbsp;分</div> <?php } ?>

             <div class="form-group box-float-12" style="padding-left:0;">意见建议：{$list.content}</div>
        </div>
                             
    </div>                  
    
    <include file="Index:footer" />
        
       