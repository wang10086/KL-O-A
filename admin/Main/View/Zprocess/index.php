<include file="Index:header2" />

        <aside class="right-side">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>{$_action_}</h1>
                <ol class="breadcrumb">
                    <li><a href="{:U('Zprocess/public_index')}"><i class="fa fa-home"></i> 首页</a></li>
                    <li><a href="javascript:;"><i class="fa fa-gift"></i> {$_action_}</a></li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                     <!-- right column -->
                    <div class="col-md-12" style="padding-bottom:200px;">
                        <foreach name="lists" key="k" item="v">
                            <div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title">{$v.title}<span style="color: #7f7f7f">({$v.pro_num})</span></h3>
                                    <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;"></h3>
                                </div>

                                <div class="box-body" style="padding: 0;">
                                    <div class="content">
                                        <?php foreach ($v['lists'] as $value){ ?>
                                        <div class="form-group col-md-3 viwe" style="display: inline-block;">
                                            <?php if (in_array($value['id'],$ids)){ ?>
                                                <i class="fa fa-caret-right"></i> &nbsp; <a href="{:U('Zprocess/public_form',array('id'=>$value['id']))}" title="新建">{$value.title}</a> &nbsp;&nbsp;
                                            <?php }else{ ?>
                                                <i class="fa fa-caret-right"></i> &nbsp; <a href="javascript:;" onclick="art_show_msg('开发中...',3)" title="新建">{$value.title}</a> &nbsp;&nbsp;
                                            <?php } ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </foreach>
                    </div>
                </div>
            </section><!-- /.content -->
        </aside><!-- /.right-side -->
  </div>
</div>

<include file="Index:footer2" />





