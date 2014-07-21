<!DOCTYPE html>
<html lang="ZH">

<head>
  <meta charset="utf-8">
  <title>新声-课程列表</title>
  <meta name="description" content="新声-听障儿童语言训练辅助工具">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  {{ HTML::style('css/home.css') }}
  <script type="text/javascript" src="/js/jquery-1.8.2.min.js"></script>
  <script src="http://code.highcharts.com/highcharts.js"></script>
  <link rel="shortcut icon" href="webpage tablogo _321-img2ico.net.ico" >
</head>

<body>
  <div id="content">
    <div id="container" style="width: 800px;height: 500px;margin-left:auto;margin-right:auto;">
      
    </div>
  </div>
  
  <div id="learn_history">
      <div id="learn_class">{{ $lecture->name }}</div>
      <div id="learn_day">{{ $wholeday }}天</div>
      <div id="accurate_rate">{{ $lastAccuracy }}%</div>
   </div>
  
  <div id="foot">
    <div id="chapterList">
      <a href="/home" class="link_chapterList">课程列表</a>
    </div>
    <div id="history">
      <a href="/progress" class="link_history">学习进度</a>
    </div>
    <div id="bbs">
      <a href="/bbs" class="link_bbs">交流论坛</a>
    </div>
    <div id="userCenter">
      <a href="#" class="link_userCenter">个人中心</a>
    </div>
  </div>
  <script type="text/javascript">
    $(function () {
      $('#container').highcharts({
        chart: {
          type: 'line',
          backgroundColor: null,
        },
        title: {
          text: '准确率',
          align: 'left',
        },
        subtitle: {
          text: '获得三星次数/总次数',
          align: 'left',
        },
        legend: {
          enabled: false,
        },
        credits: {
          enabled: false,
        },
        xAxis: {
          gridLineWidth: 1,
          gridLineDashStyle: 'dot',
          gridLineColor: '#FFFFFF',
          categories: {{ $timeSeries }},
          tickmarkPlacement: 'off',
          title: {
            enabled: false
          },
          lineColor: '#FFFFFF',
          lineWidth: 5,
        },
        yAxis: {
          max: 100,
          min: 0,
          tickInterval: 10,
          gridLineWidth: 1,
          gridLineDashStyle: 'dot',
          gridLineColor: '#FFFFFF',
          lineColor: '#FFFFFF',
          lineWidth: 5,
          tickPosition: 'inside',
          tickWidth: 2,
          tickColor: '#FFFFFF',
          title: {
            enabled: false
          },
          labels: {
            enabled: false
          },
          startOnTick: false,
        },
        tooltip: {
          shared: false,
          enabled: false,
        },
        plotOptions: {
          line: {
            dataLabels: {
              enabled: true,
              format: '{y}%',
            },
          },
        },
        series: [{
          data: {{ $accuracy }},
        }]
      });
    });
  </script>
</body>
</html>