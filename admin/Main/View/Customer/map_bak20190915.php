<include file="Index:header2" />
<script src="__HTML__/echarts-china-map/js/map/echarts-all-3.js"></script>
<script src="__HTML__/echarts-china-map/js/map/china.js"></script>

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{$_action_}</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Customer/partner')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                    <div class="box-tools pull-right"></div>
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                    <div class="map_dis">
                                        <div class="mapbox">
                                            <button id="back">返回全国</button>
                                            <div id="china-map" style="height:800px; width: 100%; margin:auto"></div>
                                        </div>
                                    </div>

                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

                        </div><!-- /.col -->
                     </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
            
            
			<include file="Index:footer2" />

<script>
    var myChart = echarts.init(document.getElementById('china-map'));
    var oBack = document.getElementById("back");

    var provinces = {$city_pinyin};
    var provincesText = {$citys};
    var seriesData = {$data};

    oBack.onclick = function () {
        initEcharts("china", "中国");
    };

    initEcharts("china", "中国");

    // 初始化echarts
    function initEcharts(pName, Chinese_) {
        //var tmpSeriesData = pName === "china" ? seriesData : [];
        var tmpSeriesData =  seriesData ;

        var option = {
            title: {
                text: Chinese_ || pName,
                left: 'center'
            },
            /*tooltip: {
                trigger: 'item',
                formatter: '{b}<br/>{c} (个)'
            },*/
            tooltip: {
                trigger: 'item',
                formatter: function (params) {
                    return params.name + ' : ' + params.value + ' 个';
                }
            },
            series: [
                {
                    name: Chinese_ || pName,
                    type: 'map',
                    mapType: pName,
                    roam: false, //是否开启鼠标缩放和平移漫游
                    data: tmpSeriesData,
                    top: "3%", //组件距离容器的距离
                    zoom:1.1,
                    selectedMode : 'single',

                    label: {
                        normal: {
                            show: true, //显示省份标签
                            textStyle:{color:"#fbfdfe"} //省份标签字体颜色
                        },
                        emphasis: { //对应的鼠标悬浮效果
                            show: true,
                            textStyle:{color:"#323232"}
                        }
                    },
                    itemStyle: {
                        normal: {
                            borderWidth: .5,//区域边框宽度
                            borderColor: '#0550c3',//区域边框颜色
                            areaColor:"#4ea397",//区域颜色

                        },

                        emphasis: {
                            borderWidth: .5,
                            borderColor: '#4b0082',
                            areaColor:"#ece39e",
                        }
                    },
                }
            ]

        };

        myChart.setOption(option);

        myChart.off("click");

        if (pName === "china") { // 全国时，添加click 进入省级
            myChart.on('click', function (param) {
                // 遍历取到provincesText 中的下标  去拿到对应的省js
                for (var i = 0; i < provincesText.length; i++) {
                    if (param.name === provincesText[i]) {
                        //显示对应省份的方法
                        showProvince(provinces[i], provincesText[i]);
                        break;
                    }
                }
                if (param.componentType === 'series') {
                    var provinceName =param.name;
                    $('#box').css('display','block');
                    $("#box-title").html(provinceName);

                }
            });
        } else { // 省份，添加双击 回退到全国
            myChart.on("dblclick", function () {
                initEcharts("china", "中国");
            });
        }
    }

    // 展示对应的省
    function showProvince(pName, Chinese_) {
        //这写省份的js都是通过在线构建工具生成的，保存在本地，需要时加载使用即可，最好不要一开始全部直接引入。
        loadBdScript('$' + pName + 'JS', '__HTML__/echarts-china-map/js/map/province/' + pName + '.js', function () {
            initEcharts(Chinese_);
        });
    }

    // 加载对应的JS
    function loadBdScript(scriptId, url, callback) {
        var script = document.createElement("script");
        script.type = "text/javascript";
        if (script.readyState) {  //IE
            script.onreadystatechange = function () {
                if (script.readyState === "loaded" || script.readyState === "complete") {
                    script.onreadystatechange = null;
                    callback();
                }
            };
        } else {  // Others
            script.onload = function () {
                callback();
            };
        }
        script.src = url;
        script.id = scriptId;
        document.getElementsByTagName("head")[0].appendChild(script);
    };
</script>

