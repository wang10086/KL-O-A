<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">详细信息</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="content">
            <div class="form-group col-md-12">
                <P class="border-bottom-line"> 业务基本信息</P>
                <div class="form-group col-md-6">
                    <label>主办单位名称： {$detail.company}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>承办单位名称：{$detail.company1}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>活动主题：{$detail.title}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>申请活动时间：{$detail.time}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>申请活动地点：{$detail.addr}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>布展条件：{$detail.condition}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>布展面积：{$detail.area}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>巡展自带项目需求：{$detail.selfOpNeed}</label>
                </div>

                <div class="form-group col-md-12">
                    <label>附加项目需求：{$detail.addOpNeed}</label>
                </div>

                <P class="border-bottom-line"> 申请单位联系方式</P>
                <div class="form-group col-md-6">
                    <label>姓名：{$detail.name}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>办公电话：{$detail.tel}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>职称/职务：{$detail.post}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>手机：{$detail.mobile}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>传真：{$detail.fax}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>电子邮箱：{$detail.email}</label>
                </div>

                <div class="form-group col-md-12">
                    <label>附件(关于活动简介)：{$detail.content}</label>
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