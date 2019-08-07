<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>客户满意度</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Inspect/record')}"><i class="fa fa-gift"></i> 客户满意度</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                     <!-- right column -->
                    <?PHP if ($average['score_num']) { ?>
                    <div class="col-md-12">

                        <!--综合评分-->
                        <include file="score_mod1" />

                        <!--评分详情-->
                        <include file="score_mod2" />

                        <!--追责-->
                        <?php if( C('RBAC_SUPER_ADMIN')==cookie('username') || cookie('userid') == 11 || cookie('userid') == $op['create_user'] || cookie('userid') == 26 ){ ?>
                            <include file="score_mod_blame_edit" />
                        <?php }else{ ?>
                            <include file="score_mod_blame_read" />
                        <?php } ?>

                        <!--回访记录-->

                        <include file="return_visit_edit" />
                    </div>   <!-- /.row -->
                    <?php }else{ ?>
                        <include file="score_mod_noscore" />
                    <?php } ?>
                </section><!-- /.content -->
                
            </aside><!-- /.right-side -->
			
  </div>
</div>

<include file="Index:footer2" />

<script>
	$(document).ready(function(e) {
        var score_pro = <?php echo $score_pro; ?>;

        if (score_pro) {
            $('#zhuize').show();
            $('textarea[name="info[problem]"]').html(score_pro.problem);
            $('textarea[name="info[resolvent]"]').html(score_pro.resolvent);
            $('#problemcheckbox').find('ins').each(function(index,ele){
                if (score_pro.solve == 1){
                    $('input[name="info[solve]"][value="1"]').parent('div').addClass('checked');
                    $('input[name="info[solve]"][value="0"]').parent('div').removeClass('checked');
                }else{
                    $('input[name="info[solve]"][value="0"]').parent('div').addClass('checked');
                    $('input[name="info[solve]"][value="1"]').parent('div').removeClass('checked');
                }
            })
        }else{
            $('#zhuize').hide();
            $('input[name="is_blame_or_not"][value="0"]').parent('div').addClass('checked');
            $('input[name="is_blame_or_not"][value="1"]').parent('div').removeClass('checked');
        }

        $('#is_blame').find('ins').each(function (index,ele) {
            $(this).click(function () {
                var is_blame = $(this).prev('input[name="is_blame_or_not"]').val();
                if (is_blame == 0){
                    $('#zhuize').hide();
                }else{
                    $('#zhuize').show();
                    $('.issolvebox').hide();
                }
            })
        })

        $('#problemcheckbox').find('ins').each(function(index, element){
            $(this).click(function () {
                if(index==0){
                    $('.issolvebox').hide();
                }else{
                    $('.issolvebox').show();
                }
            })
        })

	});

    function show_form(confirm_id,score_id){
        $('#zhuize').show();
        $('.issolvebox').hide();
        $('input[name="confirm_id"]').val(confirm_id);
        $('input[name="score_id"]').val(score_id);

    }

	
</script>
		