<include file="Index:header2" />


        <aside class="right-side">
            <section class="content-header">
                <h1>{$_action_}</h1>
                <ol class="breadcrumb">
                    <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                    <li><a href="javascript:;"><i class="fa fa-gift"></i>{$_action_} </a></li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <include file="Product:pro_navigate" />
                <include file="scheme_public_view" /><!--基本信息-->

                <?php if (!$scheme_list || in_array($scheme_list['audit_status'],array(0,2))){ ?>
                    <include file="scheme_edit" />
                <?php }else{ ?>
                    <include file="scheme_read" />
                <?php } ?>
            </section><!-- /.content -->

        </aside><!-- /.right-side -->
  </div>
</div>

<include file="Index:footer2" />




