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
	
	
	
	relaydate();
	
});

//autocomplete
function autocomplete_id(username,userid,keywords){
	$("#"+username+"").autocomplete(keywords, {
		matchContains: true,
		highlightItem: false,
		formatItem: function(row, i, max, term) {
			return '<span style=" display:none">'+row.pinyin+'</span>'+row.text;
		},
		formatResult: function(row) {
			return row.text;
		}
	}).result(function (event, item) {
		$("#"+userid+"").val(item.id);
	});
}

/**
 * 自动模糊匹配
 * @param className
 * @param idName
 * @param keyWords
 */
function getUserKeyWords(className,idName,keyWords){
	$("."+className+"").autocomplete(keyWords, {
		matchContains: true,
		highlightItem: false,
		formatItem: function(row, i, max, term) {
			return '<span style=" display:none">'+row.pinyin+'</span>'+row.text;
		},
		formatResult: function(row) {
			return row.user_name;
		}
	}).result(function(event, item) {
		$('#'+idName+'').val(item.id);
	});
}

//全局日期时间插件
function relaydate(){
	$('.inputdate').each (function(idx, elm) {
		laydate.render({
			elem: elm
		});
	});
    //年份
    $('.yearly').each (function(idx, elm) {
        laydate.render({
            elem: elm,type: 'year',format: 'yyyy'
        });
    });


	//月份
	$('.monthly').each (function(idx, elm) {
		laydate.render({
			elem: elm,type: 'month',format: 'yyyyMM'
		});
	});
	
	//一天具体时间点
	$('.inputdatetime').each (function(idx, elm) {
		laydate.render({
			elem: elm,type: 'datetime'
		});
	});

	//某一天(同inputdate)
	$('.inputdate_a').each (function(idx, elm) {
		laydate.render({
			elem: elm
		});
	});

	//一天内某个时间段
	lay('.inputdate_b').each(function() {
		laydate.render({
			elem: this
			,type: 'time'
			,range: true
		});
	});

	//日期范围(某几天之间)
	lay('.between_day').each(function() {
		laydate.render({
			elem: this
			,range: true
		});
	});
}


function ConfirmDel(url,msg) {
	/*
	if (confirm("真的要删除吗？")){
		window.location.href=url;
	}else{
		return false;
	}
	*/
	
	if(!msg){
		var msg = '真的要删除吗？';	
	}
	
	art.dialog({
		title: '提示',
		width:400,
		height:100,
		lock:true,
		fixed: true,
		content: '<span style="width:100%; text-align:center; font-size:18px;float:left; clear:both;">'+msg+'</span>',
		ok: function () {
			window.location.href=url;
			//this.title('3秒后自动关闭').time(3);
			return false;
		},
		cancelVal: '取消',
		cancel: true //为true等价于function(){}
	});

}


function ConfirmSub(obj,msg) {
	if(!msg){
		var msg = '您确定保存该信息吗？';	
	}
	
	art.dialog({
		title: '提示',
		width:400,
		height:100,
		lock:true,
		fixed: true,
		content: '<span style="width:100%; text-align:center; font-size:18px;float:left; clear:both;">'+msg+'</span>',
		ok: function () {
			//window.location.href=url;
			//this.title('3秒后自动关闭').time(3);
			$('#'+obj).submit();
			return false;
		},
		cancelVal: '取消',
		cancel: true //为true等价于function(){}
	});

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

function opencontent(cont){
		art.dialog({
			width:600,
			height:300,
			title: '详情',
			content: '<div class="opencontent">'+cont+'</div>',
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

function open_resure (obj) {
	art.dialog.open(obj, {
		lock:true,
		id:'audit_win',
		title: '确认工单执行情况',
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

function open_field (obj) {
	art.dialog.open(obj, {
		lock:true,
		title: '录入学科领域',
		width:800,
		height:400,
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

/*function open_price (obj) {
	art.dialog.open(obj, {
		lock:true,
		title: '导游辅导员管理',
		width:800,
		//height:400,
		okValue: '提交',
		ok: function () {
			this.iframe.contentWindow.gosubmint();
			return false;
		},
		cancelValue:'取消',
		cancel: function () {
		}
	});
}*/

function open_priceKind (obj) {
	art.dialog.open(obj, {
		lock:true,
		title: '导游辅导员管理',
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

function open_edit_tcs_need (obj) {
	art.dialog.open(obj, {
		lock:true,
		title: '导游辅导员需求管理',
		width:900,
		height:600,
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

function open_type (obj) {
	art.dialog.open(obj, {
		lock:true,
		title: '录入学科分类',
		width:800,
		height:400,
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

function open_cost (obj) {
	art.dialog.open(obj, {
		lock:true,
		title: '修改实际所得金额',
		width:800,
		height:400,
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

function open_sign (obj) {
	art.dialog.open(obj, {
		lock:true,
		id: 'signAdd',
		title: '增加签字信息',
		width:800,
		height:600,
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


function show_notice(id){
	art.dialog.open('index.php?m=Main&c=Message&a=noticeinfo&id='+id,{
		lock:true,
		title: '公告',
		width:900,
		height:500,
		cancelValue:'关闭',
		cancel: function () {
		}
	});	
}

function msg_info(id){
	art.dialog.open('index.php?m=Main&c=Message&a=msginfo&id='+id,{
		lock:true,
		title: '消息',
		width:900,
		height:500,
		cancelValue:'关闭',
		cancel: function () {
		}
	});	
}


function upload_multi_file(id,cont,showbox,formname,filename){
	
	
	var uploader = new plupload.Uploader({
		runtimes : 'html5,flash,silverlight,html4',
		browse_button : id, //'pickupfile', // you can pass in id...
		container: document.getElementById(cont), // ... or DOM Element itself
		url : "index.php?m=Main&c=Attachment&a=upload_file", //"{:U('Attachment/upload_file')}",
		//flash_swf_url : '__HTML__/comm/plupload/Moxie.swf',
		//silverlight_xap_url : '__HTML__/comm/plupload/Moxie.xap',
		multiple_queues:false,
		multipart_params: {
			 catid: 1
		},
		
		filters : {
			max_file_size : '100mb',
			/*
			mime_types: [
				{title : "Files", extensions : "jpg,jpeg,png,zip,rar,7z,doc,docx,ppt,pptx,xls,xlsx,txt,pdf,pdfx"}
			]
			*/
		},

		init: {
			PostInit: function() {
				//$('div.moxie-shim').width(104).height(67);
			},

			FilesAdded: function(up, files) {
				plupload.each(files, function(file) {
					var time = new Date();
					var month = time.getMonth() +1;
					if (month < 10) month = "0" + month;
					
					var t = time.getFullYear()+ "/"+ month + "/" + time.getDate()+ " "+time.getHours()+ ":"+ time.getMinutes() + ":" +time.getSeconds();
					$('#'+showbox).append(
							'<div class="form-group col-md-3" id="' + file.id + '" >'
                            + '<div class="uploadlist">'
                            + '<a class="openfile" target="_blank"><div class="upimg"></div></a>'
                            + '<input type="text" name="'+formname+'[filename][]" placeholder="'+filename+'" value="" class="form-control" />'
                            + '<a class="openfile" target="_blank"><div class="ext"></div></a>'
							+ '<div class="size">' + plupload.formatSize(file.size) +'</div>'
                            + '<div class="jindu"><div class="progress sm"><div class="progress-bar progress-bar-aqua" rel="'+ file.id +'"  role="progressbar"  aria-valuemin="0" aria-valuemax="100"></div></div></div>'
                            + '<span class="dels" onclick="removeThisFile(\''+ file.id +'\');">X</span>'
                            + '</div>'
                            + '</div>'
						);

				});

				uploader.start();
				
			},

			FileUploaded: function(up, file, res) {
				var rs = eval('(' + res.response +')');
				if (rs.rs ==  'ok') {
					if(rs.ext=='JPG' || rs.ext=='PNG' || rs.ext=='GIF'){
						$('#'+file.id).find('.upimg').attr('style','background-image:url('+rs.thumb+')');
					}else{
						$('#'+file.id).find('.upimg').attr('style','background-color:#00a65a;'); 
						$('#'+file.id).find('.ext').text(rs.ext);
					}
					$('#'+file.id).find('.openfile').attr('href',rs.fileurl);
					$('#'+file.id).append('<input type="hidden" name="'+formname+'[id][]" value="' + rs.aid + '" /><input type="hidden" name="'+formname+'[filepath][]" value="' + rs.fileurl + '" />');
				} else {
					alert('上传文件失败，请重试');
				}

			},

			UploadProgress: function(up, file) {
				$('div[rel=' + file.id + ']').css('width', file.percent + '%');
			},

			Error: function(up, err) {
				alert(err.code + ": " + err.message);
			}
		}
	});

	uploader.init();	
}

function removeThisFile(fid) {
	if (confirm('确定要删除此附件吗？')) {
		$('#' + fid).empty().remove();
		$('input[rel=' + fid +']').remove();
	}
}

//打印部分页面
function print_view(id){
	document.body.innerHTML=document.getElementById(''+id+'').innerHTML;
	window.print();
}

/**
 * 重新加载js文件[重新加载public.js文件(header2表头)]
 * @param file 文件名(全路径)
 * @param className 类名(header头加载时添加类名)
 */
function reload_jsFile(file,className) {
	var head = $("head").remove("script[role='"+className+"']");
	$("<scri"+"pt>"+"</scr"+"ipt>").attr({
		role:className,src:file,type:'text/javascript'}).appendTo(head);
}

//将汉字字符串转化为utf-8
function toUtf8(str) {
	var out, i, len, c;
	out = "";
	len = str.length;
	for(i = 0; i < len; i++) {
		c = str.charCodeAt(i);
		if ((c >= 0x0001) && (c <= 0x007F)) {
			out += str.charAt(i);
		} else if (c > 0x07FF) {
			out += String.fromCharCode(0xE0 | ((c >> 12) & 0x0F));
			out += String.fromCharCode(0x80 | ((c >> 6) & 0x3F));
			out += String.fromCharCode(0x80 | ((c >> 0) & 0x3F));
		} else {
			out += String.fromCharCode(0xC0 | ((c >> 6) & 0x1F));
			out += String.fromCharCode(0x80 | ((c >> 0) & 0x3F));
		}
	}
	return out;
}

//js生成二维码
function qrcode_js(text,width,height) {
	var width 	= width?width:150;
	var height 	= height?height:150;

	$("#code").qrcode({
		render: "canvas", //table方式
		width: width, //宽度
		height: height, //高度
		text: text //任意内容
	});
}

