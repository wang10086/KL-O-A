<include file="Index:header2" />

        <aside class="right-side">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>{$_action_}</h1>
                <ol class="breadcrumb">
                    <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                    <li><a href="javascript:;"><i class="fa fa-gift"></i> {$_action_}</a></li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
            <form method="post" action="{:U('Aaaprint/testB')}" name="myform" id="save_plans">
            <input type="hidden" name="dosubmint" value="1">
                <div class="row">
                     <!-- right column -->
                    <div class="col-md-12">


                        <div class="box box-warning">
                            <div class="box-header">
                                <h3 class="box-title">{$_action_}</h3>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <div class="content">

                                    <div class="form-group col-md-6">
                                        <label>开始时间：</label><input type="text" name="st" class="form-control inputdate" required />
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>结束时间：</label><input type="text" name="et" class="form-control inputdate" required />
                                    </div>
                                </div>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->

                        <div style="width:100%; text-align:center;">
                            <button type="submit" class="btn btn-info btn-lg" id="lrpd">导出</button>
                        </div>

                    </div><!--/.col (right) -->
                </div>   <!-- /.row -->
                </form>
            </section><!-- /.content -->

        </aside><!-- /.right-side -->
			
  </div>
</div>

<include file="Index:footer2" />
    <script type="text/javascript">
        laydate.render({
            elem: '.inputdate',theme: '#0099CC',type: 'datetime'
        });

        $(function () {
            $('#dijie_name').hide();
            $('#wonder_department').hide();

            var keywords = <?php echo $userkey; ?>;
            $(".userkeywords").autocomplete(keywords, {
                matchContains: true,
                highlightItem: false,
                formatItem: function(row, i, max, term) {
                    return '<span style=" display:none">'+row.pinyin+'</span>'+row.text;
                },
                formatResult: function(row) {
                    return row.user_name;
                }
            }).result(function(event, item) {
                $('#exe_user').val(item.id);
            });


            $('#is_or_not_worder').find('ins').each(function (index,ele) {
                $(this).click(function () {
                    var is_worder   = $(this).prev('input[name="need_worder_or_not"]').val();
                    if (is_worder == 1){    //需要下工单
                        $('#wonder_department').show();
                    }else{
                        $('#wonder_department').hide();
                        $('input[name="exe_user_id[]"]').parent('div').removeClass('checked');
                    }
                })
            })

        })

       function is_or_not_dijie(){
           var dj = $('#dijie').val();
           if (dj == 1){
               var HTML = '';
               HTML += '<label>地接单位名称</label>'+
                    '<select  name="info[dijie_name]" class="form-control" required>'+
                    '<option value="" selected disabled>--请选择--</option>'+
                    '<foreach name="dijie_names" key="k" item="v">'+
                    '<option value="{$k}">{$v}</option>'+
                    '</foreach>'+
                    '</select>';
               $('#dijie_name').html(HTML);
               $('#sale').hide();
               $('#dijie_name').show();
           }else{
               $('#dijie_name').hide();
               $('#dijie_name').html('');
               $('#sale').show();
           }
       }

        function autocom(e) {
            var keywords = <?php echo $linelist; ?>;

            $("#lineName").autocomplete(keywords, {
                matchContains: true,
                highlightItem: false,
                formatItem: function(row, i, max, term) {
                    return '<span style=" display:none">'+row.pinyin+'</span>'+row.title;
                },
                formatResult: function(row) {
                    return row.title;
                }
            }).result(function(event, item) {
                $('#lineName').val(item.title);
                $('#line_id').val(item.id);
            });

        }

        $('#kind').on('change',function () {
            var kind    = $(this).val();
            if (kind == 54 || kind == 84){
                $('#dijie').children('option[value="2"]').attr('selected',true);
                $('#dijie').attr('disabled',true);
            }else if(kind == 83){
                $('#dijie').children('option[value="1"]').attr('selected',true);
                $('#dijie').attr('disabled',true);
                $('#dijie_name').show();
            }else {
                $('#dijie').find('option[value="1"]').attr('selected',false);
                $('#dijie').find('option[value="2"]').attr('selected',false);
                $('#dijie').children('option:first-child').attr('selected',true).attr('disabled',true);
                $('#dijie').removeAttr('disabled');
            }
            is_or_not_dijie();
        })

    </script>