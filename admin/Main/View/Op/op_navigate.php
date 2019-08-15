<div class="btn-group" id="catfont">
    <if condition="rolemenu(array('Op/plans_follow'))"><a href="{:U('Op/plans_follow',array('opid'=>$op['op_id']))}" class="btn <?php if (ACTION_NAME == 'plans_follow'){ echo "btn-info"; }else{ echo "btn-default"; } ?>">项目跟进</a></if>
    <if condition="rolemenu(array('Finance/costacc'))"><a href="{:U('Finance/costacc',array('opid'=>$op['op_id']))}" class="btn <?php if (ACTION_NAME == 'costacc'){ echo "btn-info"; }else{ echo "btn-default"; } ?>">成本核算</a></if>
    <if condition="rolemenu(array('Op/confirm'))"><a href="{:U('Op/confirm',array('opid'=>$op['op_id']))}" class="btn <?php if (ACTION_NAME == 'confirm'){ echo "btn-info"; }else{ echo "btn-default"; } ?>">成团确认</a></if>
    <if condition="rolemenu(array('Finance/op'))"><a href="{:U('Finance/op',array('opid'=>$op['op_id']))}" class="btn <?php if (ACTION_NAME == 'op'){ echo "btn-info"; }else{ echo "btn-default"; } ?>">项目预算</a></if>
    <if condition="rolemenu(array('Op/app_materials'))"><a href="{:U('Op/app_materials',array('opid'=>$op['op_id']))}" class="btn <?php if (ACTION_NAME == 'app_materials'){ echo "btn-info"; }else{ echo "btn-default"; } ?>">申请物资</a></if>

    <!--
    <if condition="rolemenu(array('Sale/goods'))"><a href="{:U('Sale/goods',array('opid'=>$op['op_id']))}" class="btn <?php if (ACTION_NAME == 'goods'){ echo "btn-info"; }else{ echo "btn-default"; } ?>">项目销售</a></if>
    -->
    <if condition="rolemenu(array('Finance/settlement'))"><a href="{:U('Finance/settlement',array('opid'=>$op['op_id']))}" class="btn <?php if (ACTION_NAME == 'settlement'){ echo "btn-info"; }else{ echo "btn-default"; } ?>">项目结算</a></if>
    <if condition="rolemenu(array('Finance/huikuan'))"><a href="{:U('Finance/huikuan',array('opid'=>$op['op_id']))}" class="btn <?php if (ACTION_NAME == 'huikuan'){ echo "btn-info"; }else{ echo "btn-default"; } ?>">项目回款</a></if>
    <if condition="rolemenu(array('Contract/index'))"><a href="{:U('Contract/index',array('opid'=>$op['op_id']))}" class="btn <?php if (ACTION_NAME == 'index'){ echo "btn-info"; }else{ echo "btn-default"; } ?>">合同管理</a></if>
    <if condition="rolemenu(array('Op/evaluate'))"><a href="{:U('Op/evaluate',array('opid'=>$op['op_id']))}" class="btn <?php if (ACTION_NAME == 'evaluate'){ echo "btn-info"; }else{ echo "btn-default"; } ?>">项目评价</a></if>
</div>