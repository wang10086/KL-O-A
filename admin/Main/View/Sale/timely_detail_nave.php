<div class="btn-group" id="catfont">
    <foreach name="timely" item="v">
        <if condition="$v eq '报账及时性'">
            <a href="{:U('Sale/public_reimbursement_detail',array('year'=>$year,'month'=>$month,'tit'=>$v,'uid'=>$uid))}" class="btn <?php if($title==$v){ echo 'btn-info';}else{ echo 'btn-default';} ?>">{$v}</a>
            <else />
            <a href="{:U('Sale/public_timely_detail',array('year'=>$year,'month'=>$month,'tit'=>$v,'uid'=>$uid))}" class="btn <?php if($title==$v){ echo 'btn-info';}else{ echo 'btn-default';} ?>">{$v}</a>
        </if>
    </foreach>
</div>