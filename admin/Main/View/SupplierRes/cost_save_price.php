<include file="Index:header_art" />
		<script type="text/javascript">
        window.gosubmint= function(){
			$('#myform').submit();
		 } 
        </script>
       
        <section class="content">
            <div class="row">

                <div class="fromlist fromlistbrbr">
                    <div class="formtexts">
                        <h4>采购事项：{$list.quota_title}</h4>
                    </div>
                </div>
                <div class="form-group col-md-12"></div>
                <div class="form-group box-float-12">集中采购方：{$list['supplier_name']}</div>
                <div class="form-group box-float-6">集采年份：{$list['year']} 年</div>
                <div class="form-group box-float-6">集采季：{$list.cycle_stu}</div>
                <div class="form-group box-float-6">所属分类：{$list.type}</div>
                <div class="form-group box-float-6">计价规则：{$list.rule}</div>
                <div class="form-group box-float-6">计价单位：{$list.unit}</div>
                <div class="form-group box-float-6">集采价：{$list.unitcost}</div>

                <form action="{:U('SupplierRes/public_save')}" method="post" name="myform" id="myform">
    				<input type="hidden" name="dosubmint" value="1" />
                    <input type="hidden" name="savetype" value="4">
    				<input type="hidden" name="id"    value="{$list.id}" />
                    <div class="form-group box-float-12">
                        <label>录入市场基准价</label>
                        <input type="text" name="info[business_unitcost]" class="form-control" id="cm_name" />
                    </div>
                </form>

            </div>
        </section>
        

<include file="Index:footer" />
