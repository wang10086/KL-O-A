<include file="Index:header_art" />

	<script type="text/javascript">
	window.gosubmint= function(){
		$('#gosub').submit();
	} 
	</script>
    
    <div class="box-body art_box-body">

        <div class="fromlist fromlistbrbr">
            <div class="formtexts">
            	<!--<h4>被评价人：{$list.account_name}</h4>-->
				<span class="fr">评价月份：{$list.monthly}</span>
				<span class="fr">联系方式：<?php echo in_array(cookie('userid'),array(11)) ? $list['mobile'] : $list['hide_mobile']; ?></span>
                <span class="fr">评分时间：{$list.create_time|date='Y-m-d H:i',###}</span>
            </div>
        </div>

        <div class="fromlist no-border"  style=" padding:15px 0 0 0;">
            <div class="form-group box-float-12 black" style="padding-left:0;">总平均分：{$list.average}&nbsp;</div>
            <?php if ($list['AA']){ ?> <div class="form-group box-float-6" style="padding-left:0;">{$list.AA_title}：{$list.AA}&nbsp;分</div> <?php } ?>
            <?php if ($list['BB']){ ?> <div class="form-group box-float-6" style="padding-left:0;">{$list.BB_title}：{$list.BB}&nbsp;分</div> <?php } ?>
            <?php if ($list['CC']){ ?> <div class="form-group box-float-6" style="padding-left:0;">{$list.CC_title}：{$list.CC}&nbsp;分</div> <?php } ?>
            <?php if ($list['DD']){ ?> <div class="form-group box-float-6" style="padding-left:0;">{$list.DD_title}：{$list.DD}&nbsp;分</div> <?php } ?>
            <?php if ($list['EE']){ ?> <div class="form-group box-float-6" style="padding-left:0;">{$list.EE_title}：{$list.EE}&nbsp;分</div> <?php } ?>
            <?php if ($list['FF']){ ?> <div class="form-group box-float-6" style="padding-left:0;">{$list.FF_title}：{$list.FF}&nbsp;分</div> <?php } ?>
        </div>

        <div class="fromlist">
            <div class="fromtitle">评价内容(全部人员)：</div>
                <div class="formtexts">{$list.content}</div>
        </div>

    </div>                  
    
    <include file="Index:footer" />
        
       