<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{$_action_}</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Rbac/index')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">

                            <include file="Customer:sale_navigate" />
                            <?php if ((!$pro_list || in_array($pro_list['audit_status'],array(0,2))) && in_array(cookie('userid'),array(1,$list['create_user_id']))){ ?>
                                <include file="sale_pro_edit" />
                            <?php }else{ ?>
                                <include file="sale_pro_read" />
                            <?php } ?>
                        </div>
                     </div>

                </section>
            </aside>

<include file="Index:footer2" />

<script type="text/javascript">
    $(document).ready(function(e) {
        cost_total();
    });

    //获取销售支持内容
    /*function get_customer_sale_data(sid) {
        if (sid){
            $.ajax({
                type:"POST",
                url:"{:U('Ajax/get_customer_sale_data')}",
                data:{sale_id:sid},
                success:function(data){
                    if (data){
                        $('#blame_name').val(data.blame_name);
                        $('#type').val(data.type);
                        $('#customer').val(data.customer);
                        $('#st_time').val(data.st_time);
                        $('#et_time').val(data.et_time);
                        $('#cost').val(data.cost);
                    }
                }
            })
        } else{
            art_show_msg('请选择正确的标题',2)
        }
    }*/

    //新增活动预算
    function add_costacc(){
        var i = parseInt($('#costacc_val').text())+1;

        var html = '<div class="userlist cost_expense" id="costacc_'+i+'">' +
            '<span class="title"></span>' +
            '<input type="text" class="form-control" name="costacc['+i+'][title]">' +
            '<input type="text"  class="form-control cost" name="costacc['+i+'][unitcost]"  value="0">' +
            '<input type="text" class="form-control amount" name="costacc['+i+'][amount]" value="1">' +
            '<input type="text" class="form-control totalval" name="costacc['+i+'][total]"  value="0">' +
            '<input type="text" class="form-control longinput" name="costacc['+i+'][remark]">' +
            '<a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox(\'costacc_'+i+'\')">删除</a>' +
            '</div>';
        $('#costacc').append(html);
        $('#costacc_val').html(i);
        orderno();
        cost_total();
    }

    //编号
    function orderno(){
        $('#costacc').find('.title').each(function(index, element) {
            $(this).text(parseInt(index)+1);
        });
    }

    //移除
    function delbox(obj){
        $('#'+obj).remove();
        orderno();
        cost_total();
    }

    //更新成本核算
    function cost_total(){
        var costaccsum      = get_costaccsum();

        $('#costaccsum').html('&yen; '+costaccsum.toFixed(2));
        $('#costaccsumval').val(costaccsum.toFixed(2));
    }

    function get_costaccsum() {
        var costaccsum          = 0;
        var untraffic_sum       = 0; //不含大交通合计
        $('.cost_expense').each(function(index, element) {
            $(this).find('.cost').blur(function(){
                var cost        = $(this).val();
                var amount      = $(this).parent().find('.amount').val();
                var ct          = accMul(cost,amount);
                $(this).parent().find('.totalval').val(ct.toFixed(2));
                cost_total();
            });
            $(this).find('.amount').blur(function(){
                var amount      = $(this).val();
                var cost        = $(this).parent().find('.cost').val();
                var ct          = accMul(cost,amount);
                $(this).parent().find('.totalval').val(ct.toFixed(2));
                cost_total();
            });
            $(this).find('.costaccType').change(function () {
                cost_total();
            })

            var costacctype     = $(this).find('.costaccType').val();
            var untraffictotalval = costacctype == 12 ? 0 : $(this).find('.totalval').val();
            untraffic_sum       += parseFloat(untraffictotalval);
        });
        $('#untraffic_sum').val(untraffic_sum.toFixed(2));
        $('.totalval').each(function(index, element) {
            costaccsum += parseFloat($(this).val());
        });
        return costaccsum;
    }
</script>


