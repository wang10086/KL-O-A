<div class="col-md-12">                            
     <div class="box">
        <div class="box-header">
            <h3 class="box-title">{$year}年项目数量统计</h3>
            <div class="box-tools pull-right chart_tab">
                 <a href="javascript:;" class="btn btn-huise btn-sm btn-info" onClick="onsum(1);">新建</a>
                 <a href="javascript:;" class="btn btn-huise btn-sm" onClick="onsum(2);">成团</a>
                 <a href="javascript:;" class="btn btn-huise btn-sm" onClick="onsum(3);">完成</a>
            </div>
        </div>
        <div class="box-body no-padding">
            <div id="op_sum_chart" style="width:100%; height:380px;"></div>
        </div>
    </div>
</div>
        
<script type="text/javascript">

//项目数量
function chart_line(id){
	window.chart_line = new Highcharts.Chart({
		chart: {
			renderTo: id
		},
		title: {
			text: '<?php echo $year; ?>年项目数量统计'
		},
		xAxis: {
			categories: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月']
		},
		yAxis: {
			min: 0,
			title: {
				text: '数量'
			}
		},
		tooltip: {
			formatter: function() {
				return ''+
					this.x +': '+ this.y+'个项目';
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


function onsum(type){  
	//使用JQuery从后台获取JSON格式的数据  
	$.getJSON('<?php echo U('Chart/opsum') ?>',{type:type,year:<?php echo $year; ?>}, function(datas) {  
		//为图表设置值 
		$.each(datas,function(n,value) {   
			window.chart_line.series[n].setData(value.data); 
		});  
		window.chart_line.redraw();
	});  
}  


$(document).ready(function(e) {
	chart_line('op_sum_chart');
	onsum(1);
});
</script>
