<include file="Index:header_art" />

	<script type="text/javascript">
	window.gosubmint= function(){
		$('#gosub').submit();
	} 
	</script>

<style>
    .username_div{ margin-top:20px;}
    .username_box{display: inline-block; width:10rem; float: left;}
    .box_close{width: 1rem; background:#ff3300; color:#ffffff; float: left; height: 34px; line-height: 34px; text-align: center;}
    .box_close:hover{ color:#ffffff;}
    .border-line-label{ border-bottom: solid 1px #A8A8A8;}
</style>
    
    <div class="box-body art_box-body">
        <div class="content">
            <form method="post" action="{:U('Inspect/public_save_satisfaction_config')}" name="myform" id="gosub">
                <input type="hidden" name="dosubmint" value="1">
                <input type="hidden" name="info[userid]" value="{$userid}">
                <input type="hidden" name="info[year]" value="{$year}">
                <div class="form-group box-float-6">
                    <label>被评分人姓名</label>：
                    <input type="text" name="info[user_name]" value="{$username}" class="form-control" readonly />
                </div>
                <div class="form-group box-float-6">
                    <label>评分月份</label>：
                    <input type="text" name="info[month]" value="{$month}" class="form-control monthly" onblur="reSetYear($(this).val())" />
                </div>

                <div class="form-group box-float-12 mt20" id="satisfaction_box">
                    <p class="black border-line-label">已选定评分人</p>

                    <foreach name="lists" key="k" item="v">
                        <div class="col-md-3 username_div" id="username_div_{$v.score_user_id}">
                            <input type="hidden" name="data[888{$k}][resid]" value="{$v.id}" />
                            <input type="hidden" name="data[888{$k}][score_user_id]" value="{$v.score_user_id}">
                            <input type="text" class="form-control username_box" name="data[888{$k}][score_user_name]" value="{$v.score_user_name}" />
                            <a class="box_close" href="javascript:;" onClick="del_timu({$v.score_user_id})">X</a>
                        </div>
                    </foreach>
                </div>
            </form>

            <div class="form-group box-float-12 mt50">&emsp;</div>
            <div class="form-group box-float-12 mt50">&emsp;</div>
            <div class="form-group box-float-12 mt50">
                <div class="form-group box-float-6" id="write_user_div">
                    <input type="hidden" name="userid" id="userid" />
                    <input type="text" name="username" id="username" style=" height: 32px; width: 230px; display: inline-block;" />
                    <input type="submit" class="btn btn-info btn-sm" style="margin-top: -3px" value="添加" onclick="sure_userinfo($('#userid').val(),$('#username').val())" />
                </div>
                <a href="javascript:;" class="btn btn-success btn-sm" onClick="add_write_user_div()" id="add_btn"><i class="fa fa-fw fa-plus"></i> 新增评分人</a>
            </div>
        </div>
    </div>                  
    
    <include file="Index:footer" />

<script type="text/javascript">
    var keywords = <?php echo $userkey; ?>;
    $(function () {
        $('#write_user_div').hide();
        autocomplete_id('username','userid',keywords);
    })

    function del_timu(sid) {
        $('#username_div_'+sid).remove();
    }

    function add_write_user_div(){
        $('#write_user_div').show();
        $('#add_btn').hide();
    }

    function sure_userinfo(userid,username){
        var myDate  = new Date();
        var m       = myDate.getMinutes(); //分
        var s       = myDate.getSeconds(); //秒
        var round   = m.toString() + s.toString();
        if (userid){
            var html  = '<div class="col-md-3 username_div" id="username_div_'+round+'">'+
                '<input type="hidden" name="data['+round+'][score_user_id]" value="'+userid+'">'+
                '<input type="text" class="form-control username_box" name="data['+round+'][score_user_name]" value="'+username+'" />'+
                '<a class="box_close" href="javascript:;" onClick="del_timu('+round+')">X</a>'+
                '</div>';
            $('#satisfaction_box').append(html);
            init_write_user_div();
            $('#write_user_div').hide();
            $('#add_btn').show();
        }
    }

    function init_write_user_div() {
        var init_html = '<input type="hidden" name="userid" id="userid" />'+
            '<input type="text" name="username" id="username" style=" height: 32px; width: 230px; display: inline-block;" />'+
            '<input type="submit" class="btn btn-info btn-sm" style="margin-top: -3px" value="添加" onclick="sure_userinfo($(`#userid`).val(),$(`#username`).val())" />';
        $('#write_user_div').html(init_html);
        autocomplete_id('username','userid',keywords);
    }

    function reSetYear(yearMonth) {
        let year = yearMonth.substr(0,4);
        $('input[name="info[year]"]').val(year)
    }
</script>
