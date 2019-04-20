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
        <input type="hidden" name="info[year]" value="{$year}">
        <input type="hidden" name="info[cycle]" value="{$row.cycle}">
        <input type="hidden" id="remainder_weight" value="{$remainder_weight}">
        <input type="hidden" name="id" value="{$row.id}">

        <div class="form-group box-float-6">
            <label>被考核人员 </label>
            <input type="text" name="info[user_name]" id="user_name" value="{$row.user_name}"  class="form-control" />
        </div>

        <div class="form-group box-float-6" id="get_cycle_month">
            <label>考核周期</label>
            <select class="form-control" name="info[month]" onchange="get_crux_remainder_weight($(this).val())">
                <?php if ($row['cycle'] == 1){ ?>
                    <option value="<?php echo  $year.'01'; ?>" <?php if ($row['month'] == $year.'01') echo 'selected'; ?>>一月</option>
                    <option value="<?php echo  $year.'02'; ?>" <?php if ($row['month'] == $year.'02') echo 'selected'; ?>>二月</option>
                    <option value="<?php echo  $year.'03'; ?>" <?php if ($row['month'] == $year.'03') echo 'selected'; ?>>三月</option>
                    <option value="<?php echo  $year.'04'; ?>" <?php if ($row['month'] == $year.'04') echo 'selected'; ?>>四月</option>
                    <option value="<?php echo  $year.'05'; ?>" <?php if ($row['month'] == $year.'05') echo 'selected'; ?>>五月</option>
                    <option value="<?php echo  $year.'06'; ?>" <?php if ($row['month'] == $year.'06') echo 'selected'; ?>>六月</option>
                    <option value="<?php echo  $year.'07'; ?>" <?php if ($row['month'] == $year.'07') echo 'selected'; ?>>七月</option>
                    <option value="<?php echo  $year.'08'; ?>" <?php if ($row['month'] == $year.'08') echo 'selected'; ?>>八月</option>
                    <option value="<?php echo  $year.'09'; ?>" <?php if ($row['month'] == $year.'09') echo 'selected'; ?>>九月</option>
                    <option value="<?php echo  $year.'10'; ?>" <?php if ($row['month'] == $year.'10') echo 'selected'; ?>>十月</option>
                    <option value="<?php echo  $year.'11'; ?>" <?php if ($row['month'] == $year.'11') echo 'selected'; ?>>十一月</option>
                    <option value="<?php echo  $year.'12'; ?>" <?php if ($row['month'] == $year.'12') echo 'selected'; ?>>十二月</option>
                <?php }elseif($row['cycle']==2){ ?>
                    <option value="<?php echo $year.'01,'.$year.'02,'.$year.'03'; ?>" <?php if ($row['month'] == $year.'01,'.$year.'02,'.$year.'03') echo "selected"; ?>>一季度</option>
                    <option value="<?php echo $year.'04,'.$year.'05,'.$year.'06'; ?>" <?php if ($row['month'] == $year.'04,'.$year.'05,'.$year.'06') echo "selected"; ?>>二季度</option>
                    <option value="<?php echo $year.'07,'.$year.'08,'.$year.'09'; ?>" <?php if ($row['month'] == $year.'07,'.$year.'08,'.$year.'09') echo "selected"; ?>>三季度</option>
                    <option value="<?php echo $year.'10,'.$year.'11,'.$year.'12'; ?>" <?php if ($row['month'] == $year.'10,'.$year.'11,'.$year.'12') echo "selected"; ?>>四季度</option>
                <?php }else{ ?>
                    <option value="" disabled>请选择被考核人员</option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group box-float-12">
            <label>关键事项</label>
            <input type="text" name="info[title]" value="{$row.title}"  class="form-control" />
        </div>

        <div class="form-group box-float-6">
            <label>考核标准 </label>
            <input type="text" name="info[standard]" value="{$row.standard}"  class="form-control" />
        </div>

        <div class="form-group box-float-6">
            <label>权重 （<font color="#999">剩余权重：<font color="red"><span id="remainder_weight_html">{$remainder_weight}</span>%</font></font>）</label>
            <input type="text" name="info[weight]" value="{$row.weight}"  class="form-control" />
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

    function get_crux_remainder_weight(month) {
        let user_id         = $('#user_id').val();
        let id              = <?php echo $row['id']?$row['id']:0; ?>;
        $.ajax({
            type: 'POST',
            url : "{:U('Ajax/get_crux_remainder_weight')}",
            dataType: 'JSON',
            data: {user_id:user_id,month:month,id:id},
            success:function (msg) {
                alert(msg);
                $('#remainder_weight').val(msg);
                $('#remainder_weight_html').html(msg);
            }
        })
        return false;
    }

</script>