<include file="Index:header2" />

    <aside class="right-side">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>合同详情 <small>{$_action_}</small></h1>
            <ol class="breadcrumb">
                <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                <li><a href="{:U('Contract/index')}"><i class="fa fa-gift"></i> 合同管理</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
        
            <div class="row">
                 <!-- right column -->
                <div class="col-md-12">
                     
                     
                     
                     <div class="box box-warning" style="margin-top:15px;">
                        <div class="box-header">
                            <h3 class="box-title">{$_action_}</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="content">
                            	<div class="form-group col-md-12">
                                    <h2 class="brh3">模板名称：<span class="black">{$list.title}</span></h2>
                                </div>
                                <div class="form-group col-md-12">{:html_entity_decode($list['content'], ENT_QUOTES, 'UTF-8')}</div>
                                
                                <div class="form-group col-md-12">
                                    <h2 class="brh3">模板文件</h2>
                                </div>
                                <div class="form-group col-md-12">
                                	<div id="showimglist">
                                        <foreach name="files" key="k" item="v">
											<?php if(isimg($v['filepath'])){ ?>
                                            <a href="{$v.filepath}" target="_blank"><div class="fileext"><?php echo isimg($v['filepath']); ?></div></a>
                                            <?php }else{ ?>
											<a href="{$v.filepath}" target="_blank"><img src="{:thumb($v['filepath'],100,100)}" style="margin-right:15px; margin-top:15px;"></a>
											<?php } ?>
                                        </foreach>
                                    </div>
                                </div>
                            </div>
                            
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div><!--/.col (right) -->
            </div>   <!-- /.row -->

        </section><!-- /.content -->
        
    </aside><!-- /.right-side -->
			
  </div>
</div>

<include file="Index:footer2" />

