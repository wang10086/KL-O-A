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
                    <div class="col-md-12">

                        <!--综合评分-->
                        <include file="score_mod1" />

                        <!--评分详情-->
                        <include file="score_mod2" />


                    </div>   <!-- /.row -->
                </section><!-- /.content -->
                
            </aside><!-- /.right-side -->
			
  </div>
</div>

<include file="Index:footer2" />

<script>
	$(document).ready(function(e) {
		$('#zhuize').hide();

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
		