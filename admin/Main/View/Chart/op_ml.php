<div class="col-md-12">                            
     <div class="box">
        <div class="box-header">
            <h3 class="box-title">{$year}年各业务类型毛利统计（含已成团未结算数据）</h3>
            <div class="box-tools pull-right chart_tab">
                 <a href="javascript:;" class="btn btn-huise btn-sm btn-info" onClick="tag_ml(1);">京区校内</a>
                 <a href="javascript:;" class="btn btn-huise btn-sm" onClick="tag_ml(2);">京区校外</a>
                 <a href="javascript:;" class="btn btn-huise btn-sm" onClick="tag_ml(3);">京外业务</a>
            </div>
        </div>
        <div class="box-body no-padding">
            <div id="op_ml_1" class="chart_showbox_ml" style="width:100%; height:380px;">1</div>
            <div id="op_ml_2" class="chart_showbox_ml" style="width:100%; height:380px; display:none;">2</div>
            <div id="op_ml_3" class="chart_showbox_ml" style="width:100%; height:380px; display:none;">3</div>
        </div>
    </div>
</div>
        
<script type="text/javascript">

//京外业务
function chart_ml_jw(){
	window.chart_ml_jw = new Highcharts.Chart({
		chart: {
			renderTo: 'op_ml_3'
		},
		title: {
			text: '<?php echo $year; ?>年京外业务毛利统计'
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
		series: <?php echo $jwdata_ml; ?>
	})
}



//京区校内
function chart_ml_xn(){
	window.chart_ml_xn = new Highcharts.Chart({
		chart: {
			renderTo: 'op_ml_1'
		},
		title: {
			text: '<?php echo $year; ?>年京区校内毛利统计'
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
		series: <?php echo $xndata_ml; ?>
	})
}


//京区校外
function chart_ml_xw(){
	window.chart_ml_xw = new Highcharts.Chart({
		chart: {
			renderTo: 'op_ml_2'
		},
		title: {
			text: '<?php echo $year; ?>年京区校外毛利统计'
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
		series: <?php echo $xwdata_ml; ?>
	})
}

function tag_ml(id){
	$('.chart_showbox_ml').hide();
	$('#op_ml_'+id).show();
}

$(document).ready(function(e) {
	chart_ml_jw();
	chart_ml_xn();
	chart_ml_xw();
});

</script>
