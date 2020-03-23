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

            <style>
                .gray-a{ color: #cccccc; }
                .gray-b{ color: #7f7f7f; }
            </style>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                     <!-- right column -->
                    <div class="col-md-12" style="padding-bottom:200px;">
                        <!--<div class="box box-success" style="margin-top:15px;">
                            <div class="box-header">
                                <h3 class="box-title">LTC主干流程<span class="gray-a">(6)</span></h3>
                                <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;"></h3>
                            </div>
                            <div class="box-body">
                                <div class="content">
                                    <?php /*for ($i=1; $i<7; $i++){ */?>
                                        <div class="form-group col-md-3 viwe" style="display: inline-block;">
                                            <i class="fa fa-caret-right"></i> &nbsp; <a href="javascript:;" title="新建">测试数据测试数据</a>
                                        </div>
                                    <?php /*} */?>
                                    <div class="form-group">&nbsp;</div>
                                </div>
                            </div>
                        </div>

                       <div class="box box-success">
                           <div class="box-header">
                               <h3 class="box-title">IPD主干流程<span style="color: #7f7f7f">(3)</span></h3>
                               <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;"></h3>
                           </div>

                           <div class="box-body">
                               <div class="content">
                                   <?php /*for ($i=1; $i<4; $i++){ */?>
                                       <div class="form-group col-md-3 viwe" style="display: inline-block;">
                                           <i class="fa fa-caret-right"></i> &nbsp; <a href="javascript:;" title="新建">测试数据测试数据</a>
                                       </div>
                                   <?php /*} */?>
                                   <div class="form-group">&nbsp;</div>
                               </div>
                           </div>
                       </div>-->
                        <foreach name="lists" key="k" item="v">
                            <div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title">{$v.title}<span style="color: #7f7f7f">({$v.pro_num})</span></h3>
                                    <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;"></h3>
                                </div>

                                <div class="box-body">
                                    <div class="content">
                                        <?php foreach ($v['lists'] as $value){ ?>
                                        <div class="form-group col-md-3 viwe" style="display: inline-block;">
                                            <i class="fa fa-caret-right"></i> &nbsp; <a href="javascript:;" title="新建">{$value.title}</a>
                                        </div>
                                        <?php } ?>
                                        <div class="form-group">&nbsp;</div>
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





