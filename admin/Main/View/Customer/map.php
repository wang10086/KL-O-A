<!--<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=EDGE">
  <title>ECharts China Map</title>
  <style>
    body {
        background:#fafafa;
    }
    .box {
        position:relative;
        width:800px;
        margin:0 auto;
        padding-top:60px;
    }
    #china-map {
        width:760px;
        height:660px;
        margin:auto;
    }
    #back {
        position:absolute;
        top:10px;
        left:0;
        cursor:pointer;
    }
    .hidden {
        display:none;
    }
  </style>
  <script src="http://www.jq22.com/jquery/jquery-1.10.2.js"></script>
  <script type="text/javascript" src="https://cdn.bootcss.com/echarts/4.2.0-rc.2/echarts.min.js"></script>
  <script type="text/javascript" src="./js/map/china.js"></script>
</head>

<body>
    <div class="box">
        <button id="back" class="hidden">返回全国</button>
        <div id="china-map"></div>
    </div>

    </body>

</html>-->

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
    // 金额转换万字单位 start
    /*function unitConvert(num) {
        if (num) {
            var moneyUnits = ["", "万"],
                dividend = 10000,
                curentNum = num, //转换数字
                curentUnit = moneyUnits[0]; //转换单位
            for (var i = 0; i < 2; i++) {
                curentUnit = moneyUnits[i];
                if (strNumSize(curentNum) < 5) {
                    return num;
                }
            }
            curentNum = curentNum / dividend;
            var m = {
                num: 0,
                unit: ""
            }
            m.num = curentNum.toFixed(2);
            m.unit = curentUnit;
            return m.num + m.unit;
        }
    }

    function strNumSize(tempNum) {
        var stringNum = tempNum.toString()
        var index = stringNum.indexOf(".")
        var newNum = stringNum
        if (index != -1) {
            newNum = stringNum.substring(0, index)
        }
        return newNum.length;
    }*/
    // 金额转换万字单位 end
    var myChart = echarts.init(document.getElementById('china-map'));
    var oBack = document.getElementById("back");

    const provinces = {$city_pinyin};
    const provincesText = {$citys};
    const seriesData = {$data};

    var max = Math.max.apply(Math, seriesData.map(function(o) {
            return o.value
        })),
        min = 0; // 侧边最大值最小值
    var maxSize4Pin = 40,
        minSize4Pin = 30;
    // 点击返回按钮
    oBack.onclick = function() {
        $('#back').addClass('hidden');
        mapName = '';
        initEcharts("china", "中国");
    };

    var mapName = '';

    function getGeoCoordMap(name) {
        name = name ? name : 'china';
        /*获取地图数据*/
        var geoCoordMap = {};
        myChart.showLoading(); // loading start
        var mapFeatures = echarts.getMap(name).geoJson.features;
        myChart.hideLoading(); // loading end
        mapFeatures.forEach(function(v) {
            var name = v.properties.name; // 地区名称
            geoCoordMap[name] = v.properties.cp; // 地区经纬度
        });
        return geoCoordMap;
    }

    function convertData(data) { // 转换数据
        var geoCoordMap = getGeoCoordMap(mapName);
        var res = [];
        for (var i = 0; i < data.length; i++) {
            var geoCoord = geoCoordMap[data[i].name]; // 数据的名字对应的经纬度
            if (geoCoord) { // 如果数据data对应上，
                res.push({
                    name: data[i].name,
                    value: geoCoord.concat(data[i].value),
                });
            }
        }
        return res;
    };
    // 初始化echarts-map
    initEcharts("china", "中国");

    function initEcharts(pName, Chinese_) {
        //var tmpSeriesData = pName === "china" ? seriesData : seriesDataPro;
        //var tmp = pName === "china" ?  toolTipData : provinceData;
        var tmpSeriesData = seriesData ;
        var tmp     = seriesData;
        var option = {
            title: {
                text: Chinese_ || pName,
                left: 'center'
            },
            tooltip: {
                trigger: 'item',
                formatter: function(params) { // 鼠标滑过显示的数据
                    var toolTiphtml = ''
                    for (var i = 0; i < tmp.length; i++) {
                        if (params.name == tmp[i].name) {
                            toolTiphtml += tmp[i].name + '<br>城市合伙人：' + tmp[i].value;
                        }
                    }
                    return toolTiphtml;
                }
            },
            visualMap: { //视觉映射组件
                show: true,
                min: min,
                max: max, // 侧边滑动的最大值，从数据中获取
                left: '5%',
                top: '96%',
                inverse: true, //是否反转 visualMap 组件
                // itemHeight:200,  //图形的高度，即长条的高度
                text: ['高', '低'], // 文本，默认为数值文本
                calculable: false, //是否显示拖拽用的手柄（手柄能拖拽调整选中范围）
                seriesIndex: 1, //指定取哪个系列的数据，即哪个系列的 series.data,默认取所有系列
                orient: "horizontal",
                inRange: {
                    color: ['#dbfefe', '#1066d5'] // 蓝绿
                }
            },
            geo: {
                show: true,
                map: pName,
                roam: false,
                label: {
                    normal: {
                        show: false
                    },
                    emphasis: {
                        show: false,
                    }
                },
                itemStyle: {
                    normal: {
                        areaColor: '#3c8dbc', // 没有值得时候颜色
                        borderColor: '#097bba',
                    },
                    emphasis: {
                        areaColor: '#fbd456', // 鼠标滑过选中的颜色
                    }
                }
            },
            series: [{
                    name: '散点',
                    type: 'scatter',
                    coordinateSystem: 'geo',
                    data: tmpSeriesData,
                    symbolSize: '1',
                    label: {
                        normal: {
                            show: true,
                            formatter: '{b}',
                            position: 'right'
                        },
                        emphasis: {
                            show: true
                        }
                    },
                    itemStyle: {
                        normal: {
                            color: '#895139' // 字体颜色
                        }
                    }
                },
                {
                    name: Chinese_ || pName,
                    type: 'map',
                    mapType: pName,
                    roam: false, //是否开启鼠标缩放和平移漫游
                    data: tmpSeriesData,
                    // top: "3%",//组件距离容器的距离
                    // geoIndex: 0,
                    // aspectScale: 0.75,       //长宽比
                    // showLegendSymbol: false, // 存在legend时显示
                    selectedMode: 'single',
                    label: {
                        normal: {
                            show: true, //显示省份标签
                            textStyle: {
                                color: "#895139"
                            } //省份标签字体颜色
                        },
                        emphasis: { //对应的鼠标悬浮效果
                            show: true,
                            textStyle: {
                                color: "#323232"
                            }
                        }
                    },
                    itemStyle: {
                        normal: {
                            borderWidth: .5, //区域边框宽度
                            borderColor: '#0550c3', //区域边框颜色
                            areaColor: "#0b7e9e", //区域颜色
                        },
                        emphasis: {
                            borderWidth: .5,
                            borderColor: '#4b0082',
                            areaColor: "#ece39e",
                        }
                    }
                },
                {
                    name: '点',
                    type: 'scatter',
                    coordinateSystem: 'geo',
                    symbol: 'pin', //气泡
                    symbolSize: function(val) {
                        var a = (maxSize4Pin - minSize4Pin) / (max - min);
                        var b = minSize4Pin - a * min;
                        b = maxSize4Pin - a * max;
                        return a * val[2] + b;
                    },
                    label: {
                        normal: {
                            show: true,
                            formatter: function(params) {
                                return params.data.value[2];
                            },
                            textStyle: {
                                color: '#fff',
                                fontSize: 9
                            }
                        }
                    },
                    itemStyle: {
                        normal: {
                            color: 'red' //标志颜色'#F62157'
                        }
                    },
                    zlevel: 6,
                    data: convertData(tmpSeriesData),
                },
            ]
        };
        // 针对海南放大
        if (pName == '海南') {
            option.series[1].center = [109.844902, 19.0392];
            option.series[1].layoutCenter = ['50%', '50%'];
            option.series[1].layoutSize = "300%";
        } else { //非显示海南时，将设置的参数恢复默认值
            option.series[1].center = undefined;
            option.series[1].layoutCenter = undefined;
            option.series[1].layoutSize = undefined;
        }
        myChart.setOption(option);
        /* 响应式 */
        $(window).resize(function() {
            myChart.resize();
        });

        myChart.off("click");

        if (pName === "china") { // 全国时，添加click 进入省级
            myChart.on('click', function(param) {
                if (param.data && param.data.pid == 0) {
                    var key = param.data.name;
                    $('#back').removeClass('hidden');
                    // 遍历取到provincesText 中的下标  去拿到对应的省js
                    for (var i = 0; i < provincesText.length; i++) {
                        if (param.name === provincesText[i]) {
                            mapName = provincesText[i];
                            //显示对应省份的方法
                            showProvince(provinces[i], provincesText[i]);
                            break;
                        }
                    }
                }
            });
        } else { // 省份，添加双击 回退到全国
            myChart.on("dblclick", function() {
                $('#back').addClass('hidden');
                mapName = '';
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
        if (script.readyState) { //IE
            script.onreadystatechange = function() {
                if (script.readyState === "loaded" || script.readyState === "complete") {
                    script.onreadystatechange = null;
                    callback();
                }
            };
        } else { // Others
            script.onload = function() {
                callback();
            };
        }
        script.src = url;
        script.id = scriptId;
        document.getElementsByTagName("head")[0].appendChild(script);
    };
  </script>
