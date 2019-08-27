<div class="btn-group" id="catfont" style="padding-bottom:5px;">
    <a href="{:U('SupplierRes/chart',array('pin'=>1,'year'=>$year,'month'=>$month))}" class="btn <?php if($pin == 1){ echo "btn-info"; }else{ echo 'btn-default'; } ?>" style="padding:8px 18px;">全部资源</a>
    <a href="{:U('SupplierRes/chart',array('pin'=>2,'year'=>$year,'month'=>$month))}" class="btn <?php if($pin == 2){ echo "btn-info"; }else{ echo 'btn-default'; } ?>" style="padding:8px 18px;">科普资源</a>
    <a href="{:U('SupplierRes/chart_supplier',array('year'=>$year,'month'=>$month))}" class="btn <?php if(ACTION_NAME == 'chart_supplier'){ echo "btn-info"; }else{ echo 'btn-default'; } ?>" style="padding:8px 18px;">供方</a>
    <a href="{:U('SupplierRes/chart',array('pin'=>3,'year'=>$year,'month'=>$month))}" class="btn <?php if($pin == 3){ echo "btn-info"; }else{ echo 'btn-default'; } ?>" style="padding:8px 18px;">导游辅导员</a>
</div>