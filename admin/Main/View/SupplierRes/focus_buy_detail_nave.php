<div class="btn-group" id="catfont">
    <foreach name="nave_lists" key="k" item="v">
        <a href="{:U('SupplierRes/public_focus_buy_detail',array('year'=>$year,'quarter'=>$quarter,'pin'=>$pin))}" class="btn <?php if($pin==$k){ echo 'btn-info';}else{ echo 'btn-default';} ?>">{$v.title}</a>
    </foreach>
</div>