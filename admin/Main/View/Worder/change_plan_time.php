<include file="Index:header_art" />
		<script type="text/javascript">
        window.gosubmint= function(){
			$('#myform').submit();
		 } 
        </script>
       
        <section class="content">
            <div class="row">
                <div class="form-group col-md-12">
                    <div class="callout callout-danger">
                        <h4>提示！</h4>
                        <p>1、工单执行时间将直接影响到工单执行人的KPI得分，修改该数据前请一定和工单执行人沟通！</p>
                        <p>2、该数据只能修改一次！</p>
                    </div>
                </div>

                <form action="{:U('Worder/public_change_plan_time')}" method="post" name="myform" id="myform">

    				<input type="hidden" name="dosubmint" value="1" />
    				<input type="hidden" name="id"    value="{$list.id}" />
                    <input type="hidden" name="oldTime" value="{$list.plan_complete_time}">
                    <div class="form-group box-float-12">
                        <label>计划完成时间</label>
                        <input type="text" name="plan_complete_time" class="form-control inputdate" value="{$list.plan_complete_time|date='Y-m-d',###}" />
                    </div>
                </form>
            </div>
        </section>
        

<include file="Index:footer" />

<script type="text/javascript">
    var newjs   = "__HTML__/js/public.js";
    console.log(newjs);
    reload_jsFile(newjs,'reload_public'); //重新加载public.js文件
</script>
