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
                <span class="fr">已评价人：{$list.score_account_name}</span>
                <!--<span class="fr">未评分人：{$list.unscore_users}</span>-->
            </div>
        </div>
        
        <div class="fromlist "  style=" padding:15px 0 0 0;">
            <div class="form-group box-float-12 black" style="padding-left:0;">总平均分：{$list.sum_average}&nbsp;分</div>
            <?php if ($list['average_AA']){ ?> <div class="form-group box-float-6" style="padding-left:0;">{$list.AA}：{$list.average_AA}&nbsp;分</div> <?php } ?>
            <?php if ($list['average_BB']){ ?> <div class="form-group box-float-6" style="padding-left:0;">{$list.BB}：{$list.average_BB}&nbsp;分</div> <?php } ?>
            <?php if ($list['average_CC']){ ?> <div class="form-group box-float-6" style="padding-left:0;">{$list.CC}：{$list.average_CC}&nbsp;分</div> <?php } ?>
            <?php if ($list['average_DD']){ ?> <div class="form-group box-float-6" style="padding-left:0;">{$list.DD}：{$list.average_DD}&nbsp;分</div> <?php } ?>
            <?php if ($list['average_EE']){ ?> <div class="form-group box-float-6" style="padding-left:0;">{$list.EE}：{$list.average_EE}&nbsp;分</div> <?php } ?>
            <?php if ($list['average_FF']){ ?> <div class="form-group box-float-6" style="padding-left:0;">{$list.FF}：{$list.average_FF}&nbsp;分</div> <?php } ?>
        </div>

        <div class="fromlist">
            <div class="fromtitle">评价内容(全部人员)：</div>
            <foreach name="contents" key="k" item="v">
                <div class="formtexts">● <b>相关问题</b> &nbsp;{$v.problem}</div>
                <div class="formtexts">&emsp; <b>意见建议</b> &nbsp;{$v.content}</div>
            </foreach>
        </div>

    </div>                  
    
    <include file="Index:footer" />
        
       