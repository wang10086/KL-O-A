<include file="Index:header_mini" />
		<script type="text/javascript">
        window.gosubmint= function(){
			$('#myform').submit();
		 }
        </script>

        <section class="content">
            <div class="row">
                <form action="{:U('Rights/audit_apply')}" method="post" name="myform" id="myform">

    				<input type="hidden" name="dosubmit" value="1" />
    				<input type="hidden" name="id"    value="{$id}" />
    				<input type="hidden" name="req_type" value="{$req_type}" />
                    <div class="form-group box-float-12">
                        <?php if ($return_money_stu && $return_money_stu == '-1'){ ?> <!--预算-->
                            <p class="red">回款计划不合规定,请您关注；请您根据实际情况,按尽早收回全款原则予以审批！</p>
                        <?php } ?>
                        <?php if ($gross_rate_warning){ ?>
                            <p class="red">当前毛利率低于该项目类型最低毛利率({$gross_rate})，本次审核通过后将由总经理复审！</p>
                        <?php } ?>
                        <input type="radio" name="info[dst_status]" value="<?php echo P::AUDIT_STATUS_PASS ;?>"> 审批通过 &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="info[dst_status]" value="<?php echo P::AUDIT_STATUS_NOT_PASS ;?>"> 审批不通过

                    </div>
                    <?php if ($req_type == P::REQ_TYPE_PRICE) { ?>
                    <div class="form-group box-float-12">
                        <label>修改团费单价为</label>
                        <input name="info[audit_param]" class="form-control" value="" />
                    </div>
                    <?php } elseif ($req_type == P::REQ_TYPE_PRODUCTED && $producted && !in_array($producted['auth_id'],$expertids)) { //106 新标准产品审核 非研发实施专家录入的标准化产品 ?>


                        <div class="form-group box-float-12" style="clear: both">
                            <input type="hidden" name="expert[producted_id]" value="{$req_id}">
                            <div style="display: inline-block; width: 45%; float: left;">
                                <label>是否研发部实施专家介入：</label>
                                <select  class="form-control"  name="expert[expert_uid]">
                                    <option value="">无研发部实施专家介入</option>
                                    <foreach name="expert" key="k" item="v">
                                        <option value="{$k}">{$v}</option>
                                    </foreach>
                                </select>
                            </div>

                            <div style="display: inline-block; width: 45%; float: right;">
                                <label>研发部实施专家介入权重<span class="red">(0-10)</span>：</label>
                                <input type="text" class="form-control" name="expert[expert_weight]" value="0" />
                            </div>
                        </div>


                    <?php } else { ?>
                         <input type="hidden" name="info[audit_param]" value="" />
                    <?php } ?>
                    <div class="form-group box-float-12">
                        <textarea class="form-control" name="info[audit_reason]" style="height:100px;" placeholder="审批意见"></textarea>
                    </div>
                </form>

            </div>
        </section>


<include file="Index:footer" />
