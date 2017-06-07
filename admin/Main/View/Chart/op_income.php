<div class="col-md-12">                            
     <div class="box">
        <div class="box-header">
            <h3 class="box-title">{$year}年收入与毛利统计（含已成团未结算数据）</h3>
            <div class="box-tools pull-right chart_tab">
                 <a href="javascript:;" class="btn btn-huise btn-sm btn-info" onClick="onincome(1);">收入</a>
                 <a href="javascript:;" class="btn btn-huise btn-sm" onClick="onincome(2);">毛利</a>
            </div>
        </div>
        <div class="box-body no-padding">
            <div id="op_income_chart" style="width:100%; height:380px;"></div>
        </div>
    </div>
</div>
        
<script type="text/javascript">

//项目数量
function chart_income(id){
	window.chart_income = new Highcharts.Chart({
		chart: {
			renderTo: id
			/*
			renderTo: id,
			type: 'column'
			*/
		},
		title: {
			text: '<?php echo $year; ?>年收入与毛利统计'
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
		series: [{
			name: '京区校内',
			data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]

		}, {
			name: '京区校外',
			data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]

		}, {
			name: '京外业务',
			data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]

		}, {
			name: '常规旅游',
			data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]

		}, {
			name: '总计',
			data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
			visible: false

		}]
	})
}


function onincome(type){  
	//使用JQuery从后台获取JSON格式的数据  
	$.getJSON('<?php echo U('Chart/opincome') ?>',{type:type,year:<?php echo $year; ?>}, function(datas) {  
		//为图表设置值 
		$.each(datas,function(n,value) {   
			window.chart_income.series[n].setData(value.data); 
		});  
		window.chart_income.redraw();
	});  
}  


$(document).ready(function(e) {
	chart_income('op_income_chart');
	onincome(1);
});
</script>
