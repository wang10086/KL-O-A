<include file="Index:header2" />

        <aside class="right-side">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>{$_action_}</h1>
                <ol class="breadcrumb">
                    <li><a href="{:U('Zindex/index')}"><i class="fa fa-home"></i> 首页</a></li>
                    <li><a href="javascript:;"><i class="fa fa-gift"></i> {$_action_}</a></li>
                </ol>
            </section>

            <style>
                .border-bottom-gray{ border-bottom: lightgrey 2px solid; }
                .gray-a{ color: #cccccc; }
                .gray-b{ color: #7f7f7f; }
            </style>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                     <!-- right column -->
                    <div class="col-md-12" style="padding-bottom:200px;">
                        <div class="box box-success" style="margin-top:15px;">
                            <div class="box-header">
                                <h3 class="box-title">LTC主干流程<span class="gray-a">(100)</span></h3>
                                <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;"></h3>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <div class="content">
                                    <?php for ($i=0; $i<7; $i++){ ?>
                                        <div class="form-group col-md-3 viwe">
                                            <p class="black border-bottom-gray"><i class="fa fa-caret-right"></i>测试LTC流程{$i+1}{$op.showstatus} <span class="gray-a">({$i+100})</span></p>
                                            <a><a href="javascript:;" title="新建">AAAAAAAAAAAAAA</a></P>
                                            <a><a href="javascript:;" title="新建">BBBBBBBBBBBBBB</a></P>
                                            <a><a href="javascript:;" title="新建">CCCCCCCCCCCCCC</a></P>
                                            <a><a href="javascript:;" title="新建">DDDDDDDDDDDDDDDDDD</a></P>
                                            <a><a href="javascript:;" title="新建">EEEEEEEEEEEEE测试测试测试测试</a></P>
                                        </div>
                                    <?php } ?>
                                    <div class="form-group">&nbsp;</div>
                                </div>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->

                       <div class="box box-success">
                           <div class="box-header">
                               <h3 class="box-title">IPD主干流程<span style="color: #7f7f7f">(100)</span></h3>
                               <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;"></h3>
                           </div>

                           <div class="box-body">
                               <div class="content">
                                   <?php for ($i=0; $i<3; $i++){ ?>
                                       <div class="form-group col-md-3 viwe">
                                           <p class="black border-bottom-gray"><i class="fa fa-caret-right"></i>测试IPD流程{$i+1}{$op.showstatus} <span class="gray-a">({$i+100})</span></p>
                                           <a><a href="javascript:;" title="新建">AAAAAAAAAAAAAA</a></P>
                                           <a><a href="javascript:;" title="新建">BBBBBBBBBBBBBB</a></P>
                                           <a><a href="javascript:;" title="新建">CCCCCCCCCCCCCC</a></P>
                                           <a><a href="javascript:;" title="新建">DDDDDDDDDDDDDDDDDD</a></P>
                                           <a><a href="javascript:;" title="新建">EEEEEEEEEEEEE测试测试测试测试</a></P>
                                       </div>
                                   <?php } ?>
                               </div>
                               <div class="form-group">&nbsp;</div>
                           </div>
                       </div>
                    </div>
                </div>
            </section><!-- /.content -->
        </aside><!-- /.right-side -->
  </div>
</div>

<include file="Index:footer2" />





