<script src="/echarts/echarts.min.js"></script>
<script src="/echarts/theme/macarons.js"></script>
<body>
<div class="col-md-12">
    <div id="main3" class="card" style="width: 100%;height:300px;padding: 16px"></div>
</div>
</body>
<script type="text/javascript">
    var myChart3 = echarts.init(document.getElementById('main3'));
    var series_data = {!! $series_data !!};
    var xAxis_data = {!! $xAxis_data !!};
    var bt_series_data = {!! $bt_series_data !!};

    option3 = {
        title: {
            text: '报表任务状态',
            subtext: '',
            left: 'center',
            link: '/admin/Baobiao/StmtPlan',
            target: 'self',
            textStyle: {
                color: '#333',//主标题文字的颜色
                fontStyle: 'normal',//主标题文字字体的风格。'normal''italic''oblique'
                fontWeight: 'bolder',//主标题文字字体的粗细 'normal''bold''bolder''lighter'
                fontSize: '16',
                // 阴影的大小
                shadowBlur: 200,
                // 阴影水平方向上的偏移
                shadowOffsetX: 0,
                // 阴影垂直方向上的偏移
                shadowOffsetY: 0,
                // 阴影颜色
                shadowColor: 'rgba(0, 0, 0, 0.5)'
            }
        },
        tooltip: {
            trigger: 'item',
            formatter: '{a} <br/>{b} : {c} ({d}%)'
        },
        toolbox: {
            show: true,
            feature: {
                dataView: {readOnly: false},
                restore: {},
                saveAsImage: {}
            }
        },
        legend: {
            orient: 'vertical',
            left: 'auto',
            top: 'auto',
            padding: [5, 10],//图例内边距
            itemGap: 10, //图例每项之间的间隔
            data: xAxis_data
        },
        series: [
            {
                name: '报表任务状态',
                type: 'pie',
                radius: '55%',
                center: ['50%', '60%'],
                stillShowZeroSum: true,
                data: bt_series_data,
                label: {
                    normal: {
                        show: true,
                        color: '#ea5455',
                        formatter: '{b}: {c}({d}%)'
                    }
                },
                emphasis: {
                    itemStyle: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
            }
        ]
    };

    // 使用刚指定的配置项和数据显示图表。
    myChart3.setOption(option3);
    // 自适应配置
    window.addEventListener("resize", function () {
        myChart3.resize();
    });
    // 跳转
    myChart3.on('click', function () {
        window.open('/admin/Baobiao/StmtPlan', '_self');
    })
</script>


