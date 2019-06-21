<?php?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="js/echarts.min.js"></script>
<!--    <script src="js/jquery-3.4.1.min.js"></script>-->
    <script src="js/data.js"></script>
    <style>
        *{
            margin: 0;
            padding: 0;
            list-style: none;
        }
        .main{
            width: 800px;
            height: 500px;
            background-color: #e0e0e0;
            margin: 0 auto;
        }
        .main1{
            width: 800px;
            height: 600px;
            background-color: #e0e0e0;
            margin: 50px auto;

        }
    </style>
</head>
<body>
<body>
<div class="main"></div>
<div class="main1"></div>
<script>

    let op = echarts.init(document.querySelector('.main'));
    option = {
        title : {
            text: '豆瓣电影TOP250',
            x:'center',
            top: 50,
            textStyle: {
                fontsize: 40,
            }
        },
        tooltip : {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        legend: {
            orient: 'vertical',
            left: 'left',
            data: categories,
            itemGap: 8
        },
        series : [
            {
                name: '访问来源',
                type: 'pie',
                radius : '55%',
                center: ['50%', '60%'],
                itemStyle: {
                    emphasis: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
            }
        ]
    };



let arr=[];
for (let i=0;i<categories.length;i++){
    if (i === 0){continue;}
    let name = categories[i];
    let value = data.filter(ele=>ele[4].includes(name)).length;
    arr.push({name,value});
}
    // console.log(arr);
    option.series[0].data=arr;

    op.setOption(option);

    let op1 = echarts.init(document.querySelector('.main1'));
    let selected={};
    let Arr = [];
    categories.forEach(cat=>{
        if (cat==='全部'){
            selected[cat] = true;
        }else{
            selected[cat] = false;
        }
        let movies=data.filter(ele=>ele[4].includes(cat));
        let obj ={
            name: cat,
            data: cat==='全部' ? data :movies,
            center: ['50%', '50%'],
            type: 'scatter',
            symbolSize: function (data) {
                return Math.ceil(data[2]/10)
            },
            label: {
                emphasis: {
                    show: true,
                    formatter: function (param) {
                        return param.data[3];
                    },
                    position: 'top'
                }
            },
            itemStyle: {
                normal: {
                    shadowBlur: 10,
                    shadowColor: 'rgba(120, 36, 50, 0.5)',
                    shadowOffsetY: 5,
                    color: new echarts.graphic.RadialGradient(0.4, 0.3, 1, [{
                        offset: 0,
                        color: 'rgb(251, 118, 123)'
                    }, {
                        offset: 1,
                        color: 'rgb(204, 46, 72)'
                    }])
                }
            }
        }
        Arr.push(obj);
    });
  // console.log(selected);
  // console.log(Arr);
  option = {
        backgroundColor: new echarts.graphic.RadialGradient(0.3, 0.3, 0.8, [{
            offset: 0,
            color: '#f7f8fa'
        }, {
            offset: 1,
            color: '#cdd0d5'
        }]),
        title: {
            text: '豆瓣电影TOP250评分/品论次数散点图',
            x: 'center',
        },
        legend: {
            top: 10,
            right: 10,
            data: categories,
            selected: selected,
            selectedMode: 'single',
        },
        xAxis: {
            text: '评分',
            splitLine: {
                lineStyle: {
                    type: 'dashed'
                }
            }
        },
        yAxis: {
            text: '评论次数',
            splitLine: {
                lineStyle: {
                    type: 'dashed'
                }
            },
            scale: true
        },
      tooltip : {
          trigger: 'item',
          formatter: function (params) {
              let text = params.data;
              // console.log(text);
              return `
                名字: ${text[3]}<br>
                类型: ${text[4]}<br>
                评分: ${text[1]}<br>
              `
          }
      },
        series: Arr,

    };
    op1.setOption(option);
</script>
</body>
</body>
</html>
