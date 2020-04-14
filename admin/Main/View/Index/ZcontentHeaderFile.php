<div class="page-title-box">
    <P class="page-title"><?php echo ACTION_NAME == 'public_nodeList' ? '流程节点' : (ACTION_NAME == 'public_status' ? '流程状态' :'新建流程'); ?>：{$list.title}</P>
    <P class="page-title-breadcrumb">
        <?php if ($list['form_url']){ ?>
            <a href="{:U(''.$list[form_url].'',array('process_id'=>$list['id']))}" target="_blank" class="<?php if (ACTION_NAME == 'public_form'){ echo "menu-font-color"; } ?>">流程表单</a> &nbsp;
        <?php }else{ ?>
            <a href="{:U('Zprocess/public_form',array('process_id'=>$list['id']))}" class="<?php if (ACTION_NAME == 'public_form'){ echo "menu-font-color"; } ?>">流程表单</a> &nbsp;
        <?php } ?>
        |&nbsp;<a href="{:U('Zprocess/public_nodeList',array('process_id'=>$list['id']))}" class="<?php if (ACTION_NAME == 'public_nodeList'){ echo "menu-font-color"; } ?>">流程节点</a>&nbsp;
        |&nbsp;<a href="{:U('Zprocess/public_status',array('process_id'=>$list['id']))}" class="<?php if (ACTION_NAME == 'public_status'){ echo "menu-font-color"; } ?>">流程状态</a></P>
</div>
