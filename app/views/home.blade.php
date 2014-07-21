<!DOCTYPE html>
<html lang="ZH">

<head>
  <meta charset="utf-8">
  <title>新声-课程列表</title>
  <meta name="description" content="新声-听障儿童语言训练辅助工具">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  {{ HTML::style('css/home.css') }}
  <link rel="shortcut icon" href="webpage tablogo _321-img2ico.net.ico" >
</head>

<body>
  <div id="apDiv26">
    <img src="img/home/Homepage_Stone_3.png" width="110" height="56" />
  </div>
  <div id="apDiv27">
    <img src="img/home/Homepage_Stone_2.png" width="69" height="62" />
  </div>
  <div id="apDiv29">
    <img src="img/home/Homepage_Trees_1.png" width="97" height="109" />
  </div>
  <div id="apDiv30">
    <img src="img/home/Homepage_Trees_3.png" width="63" height="85" />
  </div>
  <div id="apDiv31">
    <img src="img/home/Homepage_Trees_1.png" width="97" height="116" />
  </div>
  <div id="apDiv32">
    <img src="img/home/Homepage_Trees_2.png" width="84" height="116" />
  </div>
  <div id="apDiv33">
    <img src="img/home/Homepage_Stone_1.png" width="106" height="83" />
  </div>
  <div id="apDiv34">
    <img src="img/home/Homepage_Trees_3.png" width="63" height="85" />
  </div>
  <div id="apDiv36">
    <img src="img/home/Homepage_Trees_1.png" width="97" height="109" />
  </div>
  <div id="apDiv37">
    <img src="img/home/Homepage_Trees_2.png" width="84" height="116" />
  </div>
  <div id="apDiv38">
    <img src="img/home/Homepage_Trees_3.png" width="63" height="85" />
  </div>
  <div id="apDiv39">
    <img src="img/home/Homepage_Stone_2.png" width="69" height="62" />
  </div>
  <div id="apDiv56">
    <img src="img/home/Homepage_Trees_1.png" width="97" height="109" />
  </div>
  <div id="apDiv57">
    <img src="img/home/Homepage_Stone_3.png" width="110" height="56" />
  </div>
  <div id="apDiv58">
    <img src="img/home/Homepage_Stone_1.png" width="106" height="83" />
  </div>
  <div id="apDiv59">
    <img src="img/home/Homepage_Trees_3.png" width="63" height="85" />
  </div>
  <div id="apDiv60">
    <img src="img/home/Homepage_Trees_1.png" width="97" height="109" />
  </div>
  <div id="apDiv61">
    <img src="img/home/Homepage_Trees_4.png" width="74" height="100" />
  </div>
  <div id="apDiv62">
    <img src="img/home/Homepage_Stone_2.png" width="69" height="62" />
  </div>
  <div id="apDiv63">
    <img src="img/home/Homepage_Trees_2.png" width="84" height="116" />
  </div>


  <div id="path1">
    <img src="img/home/Homepage_Line_3(From Start).png" width="156" height="63" />
  </div>

  <div id="apDiv1">
    <a class="line4" href="#"></a>
  </div>
  <div id="apDiv3">
    <a class="line5" href="#"></a>
  </div>
  <div id="apDiv5">
    <a class="line6" href="#"></a>
  </div>
  <div id="apDiv7">
    <a class="line1" href="#"></a>
  </div>
  <div id="apDiv9">
    <a class="line5" href="#"></a>
  </div>
  <div id="apDiv13">
    <a class="line4" href="#"></a>
  </div>
  <div id="apDiv15">
    <a class="line5" href="#"></a>
  </div>
  <div id="apDiv17">
    <a class="line2" href="#"></a>
  </div>
  <div id="apDiv20">
    <a class="line4" href="#"></a>
  </div>
  <div id="apDiv22">
    <a class="line5" href="#"></a>
  </div>
  <div id="apDiv24">
    <a class="line6" href="#"></a>
  </div>
  <div id="apDiv28">
    <a class="line1" href="#"></a>
  </div>
  <div id="apDiv41">
    <a class="line5" href="#"></a>
  </div>
  <div id="apDiv43">
    <a class="line2" href="#"></a>
  </div>
  <div id="apDiv44">
    <a class="line4" href="#"></a>
  </div>
  <div id="apDiv46">
    <a class="line5" href="#"></a>
  </div>
  <div id="apDiv51">
    <a class="line4" href="#"></a>
  </div>
  <div id="apDiv52">
    <a class="line5" href="#"></a>
  </div>
  <div id="apDiv54">
    <a class="line6" href="#"></a>
  </div>

  <div id="content">
    <img id="startNode" src="img/home/Homepage_Start.png" />
    <?php $i = 1; ?>
    @foreach ($lectures as $key=>$lecture)
      <?php $i += 1; ?>
    
      @if (empty($lecture->video_path))
      <div id="class{{ $key+1 }}" class="pic_bg_grey">
        <a href="{{ url('record', array($lecture->id)) }}">
          <div class="pic_bg"><img src="{{ $lecture->no_pic_path }}" class="pic"></div>
          <p class="title">{{ $lecture->name }}</p>
        </a>
      @else
      <div id="class{{ $key+1 }}" class="pic_bg_orange">
      <a href="{{ url('learn', array($lecture->id)) }}">
        <div class="pic_bg"><img src="{{ $lecture->yes_pic_path }}" class="pic"></div>
        @if ($lecture->star == 0)
          <img class="star" src="img/home/zerostar.png">
        @elseif ($lecture->star == 1)
          <img class="star" src="img/home/onestar.png">
        @elseif ($lecture->star == 2)
          <img class="star" src="img/home/twostars.png">
        @elseif ($lecture->star == 3)
          <img class="star" src="img/home/threestars.png">
        @endif
        <p class="title">{{ $lecture->name }}</p>
      </a>
      @endif

    </div>
    @endforeach

    @while ($i < 21) 
      
      <div id="class{{ $i }}" class="pic_bg_grey">
        <a href="#">
          <div class="pic_bg">
          <img src="img/home/fruits_unrecorded.png" class="pic" />
          </div>
        </a>
      </div>
      <?php $i += 1; ?>
    @endwhile


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
</body>
</html>