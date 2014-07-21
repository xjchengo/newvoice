<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>learning</title>
  {{ HTML::style('css/learn.css') }}
  {{ HTML::script('js/jquery-2.1.1.js') }} 
  {{ HTML::script('recorder.js') }}

</head>

<body>
  <div class="content_left">
    <video id="mom"  width="600px" height="450px">
      <source src="{{ $lecture->video_path }}" type='video/ogg' />
    </video>
    <!-- <video id="mom" class="video-js vjs-default-skin" loop controls width="600" height="450" poster="http://video-js.zencoder.com/oceans-clip.png" data-setup='{"preload":"auto"}'>
      <source src="{{ $lecture->video_path }}" type='video/webm' />
      <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
    </video> -->
    <div class="btn_play">
    </div>
  </div>
  <div class="content_right">
    <video id="child"  autoplay muted></video>
  </div>
  <div id="foot">
    <button id="btn_toolBar"></button>
    <div id="cloud_word">
      <div class="word">   {{ $lecture->name }}</div>
      <img class="pic_word" src="{{ $lecture->yes_pic_path }}" />
    </div>
    <div class="tongue_bg"><div class="tongue" style="background-image:url({{ $tongueImg }}) "></div></div>
    <div id="cloud_pinyin">
      <?php $pinyin = explode('|', $lecture->pinyin); ?>
      <div class="pinyin">
      @foreach ($pinyin as $p)
        {{ $p }}
      @endforeach
      </div>
      <img class="pic_pinyin"  src="/img/learning/star0.gif"/>
    </div>
    <!--滑动效果出现-->
    <div id="tool_bar" style="display:none">
      <a href="/home" class="link_chapterList" >课程列表</a>
      <a href="/progress" class="link_wordHistory" >学习记录</a>
      <a href="/record/{{ $lecture->id }}" class="link_record" >重录视频</a>
      <button id="btn_toolBar_back"></button>
    </div>
  </div>
  <script type="text/javascript">
  var windowWidth = $(window).width();
  $('#tool_bar').css('left', -windowWidth);
  $('#tool_bar').show();
  var video = document.querySelector('#child');
  var momVideo = document.querySelector('#mom');
  var isRecord = false;
  video.width = 600; //video.clientWidth;
  video.height = 450;
  var recorder;

  navigator.getUserMedia = (navigator.getUserMedia ||
    navigator.webkitGetUserMedia ||
    navigator.mozGetUserMedia ||
    navigator.msGetUserMedia);
  window.AudioContext = window.AudioContext || window.webkitAudioContext;
  if (navigator.getUserMedia) {
    navigator.getUserMedia(
        // constraints
        {
          video: true,
          audio: true,
        },

        // successCallback
        function (localMediaStream) {
          video.src = window.URL.createObjectURL(localMediaStream);
          var context = new window.AudioContext();
          var mediaStreamSource = context.createMediaStreamSource(localMediaStream);
          console.log(mediaStreamSource.context);
          console.log(mediaStreamSource.context.createScriptProcessor);
          hasGetUserMedia = true;
          recorder = new Recorder(mediaStreamSource);
          // console.log(recorder);
          // Do something with the video here, e.g. video.play()
        },

        // errorCallback
        function (err) {
          console.log("The following error occured: " + err);
        }
        );
  } else {
    console.log("getUserMedia not supported");
  }


  function startRecording() {
    isRecord = true;
    recorder.record();
  }

  function stopRecording() {
    isRecord = false;
    recorder.stop();
    recorder.exportWAV(function(s) {
        // Recorder.forceDownload(s);
        upload(s);
      });
    recorder.clear();

  }
  function upload(blob) { 
    var xhr=new XMLHttpRequest(); 
    var ret;
    xhr.onload=function(e) { 
      if(this.readyState === 4) { 
        ret = $.parseJSON(e.target.responseText);
        if (ret.success) {
          if (ret.pinyin) {
/*            $.post("{{ url('try', array($lecture->id)) }}",
              {path:ret.path,pinyin:ret.pinyin}
              );*/
            var pJson = $.parseJSON(ret.pinyin);
            var str = '';
            var pLen = pJson.length;
            var i = 0;
/*            while (i < pLen) {
              pJson[i]
            }*/
            $(pJson).each(function(index, element) {
              console.log(element);
              $(element).each(function(i2, e2) {
                console.log(e2);
                if (e2['right'] == 1) {
                  str += e2.pinyin;
                } else {
                  str += '<span class="pinyin_wrong">'+e2.pinyin+'</span>';
                }
              });
            })
            $('#cloud_pinyin .pinyin').html(str);
            var score = ret.score;
            var imgGif = $('.pic_pinyin');
            imgGif.attr('src', '/img/learning/star'+score+'.gif');
          }
        } else {
          alert("识别失败");
        }

        console.log(e.target.responseText);

      }
    }; 
    var fd=new FormData();
    fd.append("wav",blob); 
    xhr.open("POST","/upload-voice/{{ $lecture->id }}",true); 
    xhr.send(fd);
  }

  $("html").keydown(function( event ) {
    if (event.which == 32 && isRecord == false) {
      startRecording();
      console.log('down:'+event.which);
    }
  });
  $("html").keyup(function( event ) {
    if (event.which == 32 && isRecord == true) {
      stopRecording();
      console.log('up:'+event.which);
    }
  });
  $("#btn_toolBar").click(function(){
    console.log('click');
    var cssProperties = { left: '0' }
    $('#cloud_word,.tongue_bg,#cloud_pinyin').slideUp();
    $('#tool_bar').delay(100).animate(cssProperties);
  });
  $("#btn_toolBar_back").click(function(){
    console.log('click back');
    var cssProperties = { left: -windowWidth };
    $('#tool_bar').animate(cssProperties);
    $('#cloud_word,.tongue_bg,#cloud_pinyin').delay(100).slideDown();
  });
  $('.btn_play').click(function() {
    $(this).hide();
    console.log('play');
    $.post('/video_start/{{ $lecture->id }}');
    // myPlayer.play();
    momVideo.play();
  });
  $("#mom").bind('ended', function(){ 
    console.log('ended');
    // location.reload();
    momVideo.play();
    $.post('/video_start/{{ $lecture->id }}');
    }); 


</script>
</body>
</html>
