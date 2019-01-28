<include file="Index:header_art" />

	<script type="text/javascript">
	window.gosubmint= function(){
		$('#gosub').submit();
	} 
	</script>
    
    <div class="box-body art_box-body">
        <div class="content">
            <form method="post" action="{:U('Op/sale_config_edit')}" name="myform" id="gosub">
                <input type="hidden" name="dosubmint" value="1">
                <input type="hidden" name="department_id" value="{$department.id}">
                <input type="hidden" name="info[department]" value="{$department.department}">
                <input type="hidden" name="year" value="{$year}">
                <div class="form-group box-float-12">
                    <b><label>部门名称</label>：{$department.department}</b>
                </div>
                <div class="form-group box-float-4">
                    <label>一月</label>
                    <input type="text" name="info[January]" value="{$list.January}"  class="form-control" />
                </div>
                <div class="form-group box-float-4">
                    <label>二月</label>
                    <input type="text" name="info[February]" value="{$list.February}"  class="form-control" />
                </div>
                <div class="form-group box-float-4">
                    <label>三月</label>
                    <input type="text" name="info[March]" value="{$list.March}"  class="form-control" />
                </div>
                <div class="form-group box-float-4">
                    <label>四月</label>
                    <input type="text" name="info[April]" value="{$list.April}"  class="form-control" />
                </div>
                <div class="form-group box-float-4">
                    <label>五月</label>
                    <input type="text" name="info[May]" value="{$list.May}"  class="form-control" />
                </div>
                <div class="form-group box-float-4">
                    <label>六月</label>
                    <input type="text" name="info[June]" value="{$list.June}"  class="form-control" />
                </div>
                <div class="form-group box-float-4">
                    <label>七月</label>
                    <input type="text" name="info[July]" value="{$list.July}"  class="form-control" />
                </div>
                <div class="form-group box-float-4">
                    <label>八月</label>
                    <input type="text" name="info[August]" value="{$list.August}"  class="form-control" />
                </div>
                <div class="form-group box-float-4">
                    <label>九月</label>
                    <input type="text" name="info[September]" value="{$list.September}"  class="form-control" />
                </div>
                <div class="form-group box-float-4">
                    <label>十月</label>
                    <input type="text" name="info[October]" value="{$list.October}"  class="form-control" />
                </div>
                <div class="form-group box-float-4">
                    <label>十一月</label>
                    <input type="text" name="info[November]" value="{$list.November}"  class="form-control" />
                </div>
                <div class="form-group box-float-4">
                    <label>十二月</label>
                    <input type="text" name="info[December]" value="{$list.December}"  class="form-control" />
                </div>
            </form>
        </div>
    </div>                  
    
    <include file="Index:footer" />
