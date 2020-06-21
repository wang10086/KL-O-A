<include file="Index:header_art" />

<script type="text/javascript">
    window.gosubmint= function(){
        $('#audit_form').submit();
    }
</script>

        <section class="content">
            <div class="form-group col-md-12">
                <div class="form-group col-md-4">
                    <label>申请时间：{$list['day'] ? ($list.day|date='Y-m-d',###) : ''}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>申请人：{$list.create_user_name}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>合同编号：{$list.contract_num}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>是否首次申请：<?php echo $list['first']==1 ? '是' : '否'; ?></label>
                </div>

                <div class="form-group col-md-4">
                    <label>是否有欠款：<?php echo $list['is_debt']==1 ? '是, &nbsp;'.$list['debt'].'&nbsp;元' : '否'; ?></label>
                </div>

                <div class="form-group col-md-4">
                    <label>开票类型：{$list.type}</label>
                </div>

                <div class="form-group col-md-8">
                    <label>开票主体：{$companys[$list['company']]}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>开票金额：{$list.money}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>公司名称：{$list.name}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>纳税人识别号：{$list.num}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>地址：{$list.addr}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>电话：{$list.mobile}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>开户银行：{$list.bank_name}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>账号：{$list.bank_num}</label>
                </div>

                <div class="form-group col-md-12">
                    <label>备注：{$list.remark}</label>
                </div>

                <div class="form-group col-md-12">
                    <label>审核状态：{$ticket_status[$list['audit_status']]}</label>
                </div>

                <div class="form-group col-md-12">
                    <label>审核备注：{$list.audit_remark}</label>
                </div>
            </div>

            <?php if (in_array(cookie('userid'),array(1,$list['audit_uid'])) && $list['audit_status']==0){ ?>
            <div class="form-group col-md-12">
                <P class="border-bottom-line"> 审核</P>
                <form method="post" action="{:U('Finance/public_save_ticket')}" id="audit_form">
                    <input type="hidden" name="dosubmint" value="1">
                    <input type="hidden" name="savetype" value="1">
                    <input type="hidden" name="id" value="{$list.id}">

                    <div class="form-group box-float-12">
                        <label class="">审核意见：</label>
                        <input type="radio" name="audit_status" value="1" checked /> &#8194;审核通过 &#12288;&#12288;&#12288;
                        <input type="radio" name="audit_status" value="2" /> &#8194;审核不通过
                    </div>

                    <div class="form-group box-float-12">
                        <label>备注</label>
                        <textarea class="form-control" name="audit_remark"></textarea>
                    </div>
                </form>
            </div>
            <?php } ?>
        </section>


        <include file="Index:footer" />
