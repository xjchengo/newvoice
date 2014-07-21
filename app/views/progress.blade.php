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
  <style type="text/css">
    td.lecture {
      padding: 5px;
      margin: 10px;
    }
    .pass-lecture {
      background-color: #efb554;
    }
    .no-pass-lecture {
      background-color: #755f47;
    }
    .lecture a {
      color: #FFF;
    }
  </style>
</head>

<body>
  <div id="content">
    <div id="container" style="width: 1200px;height: 500px;margin-left:auto;margin-right:auto;">
      
    </div>
  </div>
  <div id="count">
    <div id="count_class">{{ $allLecturesNum }}课</div>
    <div id="count_day">{{ $dayNum }}天</div>
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
    var lectures = {{ $lectures }};
    var passL = {{ $passL }};
    var wholeL = {{ $wholeL }};
    $(function () {
      
      $('#container').highcharts({
        chart: {
          type: 'area',
          backgroundColor: null,
        },
        title: {
          text: '学习课程数',
          align: 'left',
        },
        subtitle: {
          text: '棕色代表未掌握课程数 黄色代表已掌握课程数',
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
          categories: {{ $categories }},
          tickmarkPlacement: 'off',
          title: {
            enabled: false
          },
          lineColor: '#FFFFFF',
          lineWidth: 5,
        },
        yAxis: {
          max: 15,
          gridLineWidth: 1,
          gridLineDashStyle: 'dot',
          gridLineColor: '#FFFFFF',
          lineColor: '#FFFFFF',
          lineWidth: 5,
          tickPosition: 'inside',
          tickWidth: 2,
          tickInterval: 1,
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
          shared: true,
          enabled: true,
          useHTML: true,
          positioner: function(boxWidth, boxHeight, point) {
            // Set up the variables
            var chart = this.chart,
                plotLeft = chart.plotLeft,
                plotTop = chart.plotTop,
                plotWidth = chart.plotWidth,
                plotHeight = chart.plotHeight,
                distance = 10, 
                pointX = point.plotX,
                pointY = point.plotY,
                x = pointX + plotLeft + (chart.inverted ? distance : -boxWidth - distance),
                y = pointY - boxHeight + plotTop + 15, // 15 means the point is 15 pixels up from the bottom of the tooltip
                alignedRight;

            // It is too far to the left, adjust it
            if (x < 7) {
                x = plotLeft + pointX + distance;
            }

            // Test to see if the tooltip is too far to the right,
            // if it is, move it back to be inside and then up to not cover the point.
            if ((x + boxWidth) > (plotLeft + plotWidth)) {
                x -= (x + boxWidth) - (plotLeft + plotWidth);
                y = pointY - boxHeight + plotTop - distance;
                alignedRight = true;
            }

            // If it is now above the plot area, align it to the top of the plot area
            if (y < plotTop + 5) {
                y = plotTop + 5;

                // If the tooltip is still covering the point, move it below instead
                if (alignedRight && pointY >= y && pointY <= (y + boxHeight)) {
                    y = pointY + plotTop + distance; // below
                }
            } 

            // Now if the tooltip is below the chart, move it up. It's better to cover the
            // point than to disappear outside the chart. #834.
            if (y + boxHeight > plotTop + plotHeight) {
                y = mathMax(plotTop, plotTop + plotHeight - boxHeight - distance); // below
            }
            x = x+10;
            y = y-10;

            return {x: x, y: y};
          },
          formatter: function () {
            var $str = '';
            var index = this.x;
            var len = wholeL[index].length;
            var i = 0;
            var j = 0;
            var name;
            $str += '<table>';
            while (i < len) {
              $str += '<tr>';
              j = 0;
              while (j < 2) {
                if ( i < len) {
                  name = lectures[wholeL[index][i]]['name'];
                  classValue = getClass(wholeL[index][i], passL[index]);
                  $str += '<td class="'+classValue+'"><a href="/history/'+wholeL[index][i]+'">'+name+'</a></td>';
                }
                i += 1;
                j += 1;
              }
              $str += '</tr>';
            }
            $str += '</table>';
            console.log($str);
            return $str;
          }
        },
        plotOptions: {
          area: {
            stacking: 'normal',
            lineColor: '#666666',
            lineWidth: 1,
            marker: {
              lineWidth: 1,
              lineColor: '#666666'
            },
            dataLabels: {
              enabled: true,
              y: 25,
              color: '#FFFFFF',
              useHTML: true,
              formatter: function() {
/*                console.log(this.series);
                console.log(this.series.name);*/
                if (this.series.name == '未掌握') {
                  return '<img src="/img/progress/tree.png" title="" alt="" border="0" height="65" width="38">'+'<div style="margin-top:15px;text-align: center;">'+this.total+'</div>';
                }
                
              },
            },
          }
        },
        series: [{
          name: '未掌握',
          data: {{ $noPassNumEveryday }},
          color: '#755f47',
        }, {
          name: '已掌握',
          data: {{ $passNumEveryday }},
          color: '#efb554',
        }]
      });
    });
    function getClass(lecture_id, lecture_array)
    {
      if ($.inArray(lecture_id, lecture_array)) {
        return 'lecture pass-lecture';
      } else {
        return 'lecture no-pass-lecture';
      }
    }
  </script>
</body>
</html>