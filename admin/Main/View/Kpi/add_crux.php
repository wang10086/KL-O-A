<include file="Index:header_art" />

	<script type="text/javascript">
	window.gosubmint= function(){
        let user_id           = $('#user_id').val();
        let month             = $('select[name="info[month]"]').val(); //考核周期
        let standard          = $('input[name="info[standard]"]').val(); //考核标准
        let weight            = $('input[name="info[weight]"]').val(); //权重
        let title             = $('input[name="info[title]"]').val(); //关键事项名称
        let remainder_weight  = $('#remainder_weight').val(); //剩余权重
        if(!user_id){   art_show_msg('用户信息有误'); return false; }
        if(!month){     art_show_msg('考核周期不能为空'); return false; }
        if(!standard){  art_show_msg('考核标准不能为空'); return false; }
        if(!weight){    art_show_msg('权重不能为空'); return false; }
        if(!title){     art_show_msg('关键事项名称不能为空'); return false; }
        if(parseInt(weight) > parseInt(remainder_weight)){ art_show_msg('权重总分不能超过100分'); return false; }

		$('#gosub').submit();
	} 
	</script>
    
    <div class="box-body art_box-body">
        <form method="post" action="{:U('Kpi/public_save')}" name="myform" id="gosub">
        <input type="hidden" name="dosubmint" value="1">
        <input type="hidden" name="savetype" value="1">
        <input type="hidden" name="info[user_id]" id="user_id" value="{$row.user_id}">
        <input type="hidden" name="info[year]" value="<?php echo $row['year']?$row['year']:$year; ?>">
        <input type="hidden" name="info[cycle]" value="{$row.cycle}">
        <input type="hidden" id="remainder_weight" value="{$remainder_weight}">

        <div class="form-group box-float-6">
            <label>被考核人员 </label>
            <input type="text" name="info[user_name]" id="user_name" value="{$row.user_name}"  class="form-control" />
        </div>

        <div class="form-group box-float-6" id="get_cycle_month">
            <label>考核周期</label>
            <select class="form-control" name="info[month]">
                <option value="" disabled>请选择被考核人员</option>
            </select>
        </div>

        <div class="form-group box-float-6">
            <label>考核标准 </label>
            <input type="text" name="info[standard]" value="{$row.standard}"  class="form-control" />
        </div>

        <div class="form-group box-float-6">
            <label>权重 <font color="#999">剩余权重分：<font color="red">{$remainder_weight}分</font></font></label>
            <input type="text" name="info[weight]" value="{$row.weight}"  class="form-control" />
        </div>
        
        <div class="form-group box-float-12">
            <label>关键事项</label>
            <input type="text" name="info[title]" value="{$row.title}"  class="form-control" />
        </div>
        
        <div class="form-group box-float-12">
            <label>考核内容</label>
            <textarea class="form-control" style="height:90px;" name="info[content]">{$row.content}</textarea>
        </div>
        </form>
        
                             
    </div>                  
    
    <include file="Index:footer" />

<script type="text/javascript">
    let keywords    = <?php echo $userkey; ?>;
    $(function () {
        autocomplete_id('user_name','user_id',keywords);
    })

    $('#user_name').blur(function () {
        let user_id = $('#user_id').val();
        let year    = {$year};
        if (user_id){
            $.ajax({
               type: 'POST',
                url: "{:U('Ajax/get_crux_kpi_cycle')}",
                dataType: 'JSON',
                data:{user_id:user_id,year:year},
                success:function (msg) {
                    $("input[name='info[cycle]']").val(msg.cycle);
                    $('#get_cycle_month').html(msg.select);
                },
            });
        }else{
            let c_title     = '<label>考核周期</label>';
            let c_content   = '<select class="form-control" name="info[month]"> <option value="" disabled>请选择被考核人员</option> </select>';
            let html        = c_title + c_content;
            $('#get_cycle_month').html(html);
        }
        return false;
    })


</script>