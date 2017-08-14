$(document).ready(function(e) {
    $('.datamore').css('width',($('#tablelist').width()+2)+'px');
	
	$('#tablelist').find('tbody tr').each(function(index, element) {
       	$(this).hover(function(){
			$(this).css('background-color','#fafafa');	
			$(this).find('.datamore').show();
			$(this).css('cursor','pointer');
			$(this).find('.datamore').hover(function(){$(this).hide();})
		},function(){
			$(this).removeAttr('style');
			$(this).find('.datamore').hide();
			
		}) 
    });
	
	//全局日期时间插件
	$('.inputdate').datepicker();
	$('.inputdatetime').datetimepicker();
	
});

function ConfirmDel(url) {
	if (confirm("真的要删除吗？")){
		window.location.href=url;
	}else{
		return false;
	}
}



function opensearch(obj,w,h,title){
	//var elem = document.getElementById(obj);
	if(!title){
		var title = '搜索';	
	}
	art.dialog({
		content:$('#'+obj).html(),
		lock:true,
		title: title,
		width:w,
		height:h,
		okValue: '确定',
		ok: function () {
			$('.aui_content').find('input').filter(function(index) {
                return $(this).val() == '';
            }).remove();
			$('.aui_content').find('form').submit();	
		},
		cancelValue:'取消',
		cancel: function () {
		}
	}).show();	
}


function init_order()
{
	var type = $.cookie(order_page + '_otype');
	var field = $.cookie(order_page + '_ofield');
	if (typeof field == undefined || field == '' || field == undefined) {  
	
	}else{
		$('.orders .sorting[data=' + field.replace('.','\\\.') + ']').addClass(type);
	}
	
	
	$('.orders .sorting').each(function(index,el) {
		$(this).click(function(e){
			var field = $(this).attr('data');
			var type  = $.cookie(order_page + '_otype');
			if (typeof type == undefined || type == '' || type == 'asc') {
				type = 'desc';
			} else {
				type = 'asc';
			}
			
			$.cookie(order_page + '_otype', type);
			$.cookie(order_page + '_ofield', field);
			location.reload();
		});
	});
	
	
}


function openimg(url){
		art.dialog({
			padding: 0,
			title: '预览大图',
			content: '<img src="'+url+'"  height="400" />',
			lock: true
		});	
  }


function open_audit (obj) {
		art.dialog.open(obj, {
			lock:true,
			id:'audit_win',
			title: '审批',
			width:600,
			height:300,
			okValue: '提交',
			ok: function () {
				this.iframe.contentWindow.gosubmint();
				return false;
			},
			cancelValue:'取消',
			cancel: function () {
			}
		});	
} 


function open_req (obj) {
	art.dialog.open(obj, {
		lock:true,
		id:'audit_win',
		title: '申请权限',
		width:600,
		height:300,
		okValue: '提交',
		ok: function () {
			this.iframe.contentWindow.gosubmint();
			return false;
		},
		cancelValue:'取消',
		cancel: function () {
		}
	});	
}


/**
 ** 乘法函数，用来得到精确的乘法结果
 ** 说明：javascript的乘法结果会有误差，在两个浮点数相乘的时候会比较明显。这个函数返回较为精确的乘法结果。
 ** 调用：accMul(arg1,arg2)
 ** 返回值：arg1乘以 arg2的精确结果
 **/
function accMul(arg1, arg2) {
    var m = 0, s1 = arg1.toString(), s2 = arg2.toString();
    try {
        m += s1.split(".")[1].length;
    }
    catch (e) {
    }
    try {
        m += s2.split(".")[1].length;
    }
    catch (e) {
    }
	
	var sum = Number(s1.replace(".", "")) * Number(s2.replace(".", "")) / Math.pow(10, m);
	if(sum!='NaN'){
    	return sum;
	}
}

//返回值：arg1加上arg2的精确结果   
function accAdd(arg1,arg2){  
    var r1,r2,m;  
    try{r1=arg1.toString().split(".")[1].length}catch(e){r1=0}  
    try{r2=arg2.toString().split(".")[1].length}catch(e){r2=0}  
    m=Math.pow(10,Math.max(r1,r2))  
    return (arg1*m+arg2*m)/m  
}

//返回值：arg1减上arg2的精确结果   
function accSub(arg1,arg2){      
    return accAdd(arg1,-arg2);  
}


//返回值：arg1除以arg2的精确结果   
function accDiv(arg1,arg2){  
    var t1=0,t2=0,r1,r2;  
    try{t1=arg1.toString().split(".")[1].length}catch(e){}  
    try{t2=arg2.toString().split(".")[1].length}catch(e){}  
    with(Math){  
        r1=Number(arg1.toString().replace(".",""))  
        r2=Number(arg2.toString().replace(".",""))  
        return (r1/r2)*pow(10,t2-t1);  
    }  
}


function art_show_msg(msg,time) {
	art.dialog({
		title: '提示',
		width:400,
		height:100,
		fixed: true,
		time: time,
		lock:true,
		content: '<span style="width:100%; text-align:center; font-size:18px;float:left; clear:both;">'+msg+'</span>',
		
	});
}