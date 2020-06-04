<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">详细信息</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="content">
            <div class="form-group col-md-12">
                <P class="border-bottom-line"> 业务基本信息</P>
                <div class="form-group col-md-6">
                    <label>主办单位名称： {$need['company'] ? $need['company'] : $detail['company']}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>承办单位名称：{$need['company1'] ? $need['company1'] : $detail['company1']}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>活动主题：{$need['title'] ? $need['title'] : $detail['title']}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>申请活动时间：{$need['time'] ? $need['time'] : $detail['time']}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>申请活动地点：{$need['addr'] ? $need['addr'] : $detail['addr']}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>布展条件：{$need['condition'] ? $need['condition'] : $detail['condition']}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>布展面积：{$need['area'] ? $need['area'] : $detail['area']}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>巡展自带项目需求：{$need['selfOpNeed'] ? $need['selfOpNeed'] : $detail['selfOpNeed']}</label>
                </div>

                <div class="form-group col-md-12">
                    <label>附加项目需求：{$need['addOpNeed'] ? $need['addOpNeed'] : $detail['addOpNeed']}</label>
                </div>

                <P class="border-bottom-line"> 申请单位联系方式</P>
                <div class="form-group col-md-6">
                    <label>姓名：{$need['name'] ? $need['name'] : $detail['name']}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>办公电话：{$need['tel'] ? $need['tel'] : $detail['tel']}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>职称/职务：{$need['post'] ? $need['post'] : $detail['post']}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>手机：{$need['mobile'] ? $need['mobile'] : $detail['mobile']}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>传真：{$need['fax'] ? $need['fax'] : $detail['fax']}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>电子邮箱：{$need['email'] ? $need['email'] : $detail['email']}</label>
                </div>

                <div class="form-group col-md-12">
                    <label>附件(关于活动简介)：{$need['content'] ? $need['content'] : $detail['content']}</label>
                </div>
            </div>

            <!--打印页面-->
            <include file="pro_69_print_table" />

            <div class="no-print">
                <button style="float: right" class="btn btn-default" onclick="print_part('print_table');"><i class="fa fa-print"></i> 打印</button>
            </div>
        </div>
    </div><!-- /.box-body -->
</div>

<script type="text/javascript">
    function print_part(id){
        $('#'+id).css({"width":"90%"});
        document.body.innerHTML=document.getElementById(id).innerHTML;
        window.print();
    }
</script>