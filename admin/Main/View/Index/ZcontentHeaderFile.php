<div class="page-title-box">
    <P class="page-title"><?php echo ACTION_NAME == 'public_nodeList' ? '流程节点' : (ACTION_NAME == 'public_status' ? '流程状态' :'新建流程'); ?>：{$list.title}</P>
    <P class="page-title-breadcrumb"><a href="{:U('Zprocess/public_form',array('id'=>$list['id']))}" class="<?php if (ACTION_NAME == 'public_form'){ echo "menu-font-color"; } ?>">流程表单</a> &nbsp;
        |&nbsp;<a href="{:U('Zprocess/public_nodeList',array('id'=>$list['id']))}" class="<?php if (ACTION_NAME == 'public_nodeList'){ echo "menu-font-color"; } ?>">流程节点</a>&nbsp;
        |&nbsp;<a href="{:U('Zprocess/public_status',array('id'=>$list['id']))}" class="<?php if (ACTION_NAME == 'public_status'){ echo "menu-font-color"; } ?>">流程状态</a></P>
</div>
