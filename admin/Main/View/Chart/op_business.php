<div class="col-md-12">                            
     <div class="box">
        <div class="box-header">
            <h3 class="box-title">{$year}年各业务类型收入统计</h3>
            <div class="box-tools pull-right chart_tab">
                 <a href="javascript:;" class="btn btn-huise btn-sm btn-info" onClick="tag_buiness(1);">京区校内</a>
                 <a href="javascript:;" class="btn btn-huise btn-sm" onClick="tag_buiness(2);">京区校外</a>
                 <a href="javascript:;" class="btn btn-huise btn-sm" onClick="tag_buiness(3);">京外业务</a>
            </div>
        </div>
        <div class="box-body no-padding">
            <div id="op_sr_1" class="chart_showbox" style="width:100%; height:380px;">1</div>
            <div id="op_sr_2" class="chart_showbox" style="width:100%; height:380px; display:none;">2</div>
            <div id="op_sr_3" class="chart_showbox" style="width:100%; height:380px; display:none;">3</div>
        </div>
    </div>
</div>
        
<script type="text/javascript">

//京外业务
function chart_sr_jw(){
	window.chart_sr_jw = new Highcharts.Chart({
		chart: {
			renderTo: 'op_sr_3'
		},
		title: {
			text: '<?php echo $year; ?>年京外业务收入统计'
		},
		xAxis: {
			categories: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月']
		},
		yAxis: {
			title: {
				text: '金额'
			}
		},
		tooltip: {
			formatter: function() {
				return ''+
					this.x +': '+ this.y+'元';
			}
		},
		plotOptions: {
			column: {
				pointPadding: 0.2,
				borderWidth: 0
			}
		},credits: {
			enabled: false
		},
		series: <?php echo $jwdata_sr; ?>
	})
}



//京区校内
function chart_sr_xn(){
	window.chart_sr_xn = new Highcharts.Chart({
		chart: {
			renderTo: 'op_sr_1'
		},
		title: {
			text: '<?php echo $year; ?>年京区校内收入统计'
		},
		xAxis: {
			categories: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月']
		},
		yAxis: {
			title: {
				text: '金额'
			}
		},
		tooltip: {
			formatter: function() {
				return ''+
					this.x +': '+ this.y+'元';
			}
		},
		plotOptions: {
			column: {
				pointPadding: 0.2,
				borderWidth: 0
			}
		},credits: {
			enabled: false
		},
		series: <?php echo $xndata_sr; ?>
	})
}


//京区校外
function chart_sr_xw(){
	window.chart_sr_xw = new Highcharts.Chart({
		chart: {
			renderTo: 'op_sr_2'
		},
		title: {
			text: '<?php echo $year; ?>年京区校外收入统计'
		},
		xAxis: {
			categories: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月']
		},
		yAxis: {
			title: {
				text: '金额'
			}
		},
		tooltip: {
			formatter: function() {
				return ''+
					this.x +': '+ this.y+'元';
			}
		},
		plotOptions: {
			column: {
				pointPadding: 0.2,
				borderWidth: 0
			}
		},credits: {
			enabled: false
		},
		series: <?php echo $xwdata_sr; ?>
	})
}

function tag_buiness(id){
	$('.chart_showbox').hide();
	$('#op_sr_'+id).show();
}

$(document).ready(function(e) {
	chart_sr_jw();
	chart_sr_xn();
	chart_sr_xw();
});

</script>
