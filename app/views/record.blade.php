<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>record</title>
  {{ HTML::style('css/record.css') }} 
  {{ HTML::script('js/jquery-2.1.1.js') }} 
  <script src="//www.WebRTC-Experiment.com/RecordRTC.js"></script>
  <style type="text/css">
    video {
      z-index: 0;
    }
  </style>
</head>


<body>
  <div class="content_left">
    <div class="record_top">
      <div class="record_time">00:00</div>
    </div>
    <video id="record_video">
      Your browser does not support the <code>video</code> element.
    </video>
    <div class="record_foot" id="start">
      <a class="btn_left btn_back " href="/home"></a>
      <button class="btn_mid btn_start"></button>
    </div>
    <div class="record_foot" id="pause">
      <button class="btn_mid btn_recordPause"></button>
    </div>
    <div class="record_foot" id="finish">
      <button class="btn_left btn_cancel"></button>
      <button class="btn_mid btn_replay"></button>
      <button class="btn_right btn_confirm"></button>
    </div>
    <div class="record_foot" id="return-finish">
      <button class="btn_mid btn_pause"></button>
    </div>
  </div>
  <div class="content_right">
    <div class="stone"></div>
    <div class="tree"></div>
    <div class="line"></div>
    <div class="word_bg">
      <img src="/img/record/Recordpage_Pic_Grape.png" class="word_pic" />
    </div>
    <div class="word_pinyin">{{ $lecture->pinyin }}</div>
    <div class="word">{{ $lecture->name }}</div>
  </div>
  <script type="text/javascript">
    var video = document.querySelector('video');
    var canvas = document.createElement('canvas');
    var localMedia;
    var webmBlob;
    var elapsed_time;
    var mediaRecorder;
    var voice_start;
    var voice_end;

    video.width = 600; //video.clientWidth;
    video.height = 450;
    canvas.width = video.width;
    canvas.height = video.height;
    navigator.getUserMedia = (navigator.getUserMedia ||
      navigator.webkitGetUserMedia ||
      navigator.mozGetUserMedia ||
      navigator.msGetUserMedia);

    if (navigator.getUserMedia) {
      navigator.getUserMedia(
        {
        // constraints
          video: {
            mandatory: {
              minWidth: video.width,
              minHeight: video.height
            }
          },
          audio: true,
        },

        // successCallback
        function (localMediaStream) {
          console.log(localMediaStream);
          console.log('v');
          console.log('v:'+localMediaStream.getVideoTracks());
          var videoTrack = localMediaStream.getVideoTracks();
          var video = document.querySelector('video');
          window.recordRTC = RecordRTC(localMediaStream);
          video.src = window.URL.createObjectURL(localMediaStream);
          video.muted = true;
          localMedia = video.src;
          // Do something with the video here, e.g. video.play()
/*          mediaRecorder.ondataavailable = function(e) {
            console.log("data available");
            webmBlob = e.data;
            foreceDownload(e.data, 'test.webm');
            video_url = window.URL.createObjectURL(e.data);
            video.src = video_url;
          }*/
        },

        // errorCallback
        function (err) {
          console.log("The following error occured: " + err);
        }
      );
    } else {
      console.log("getUserMedia not supported");
    }
    var btn_start = document.querySelector(".btn_start");
    var btn_pause = document.querySelector(".btn_recordPause");
    var btn_replay = document.querySelector(".btn_replay");
    var btn_return_finish = document.querySelector(".btn_pause");
    var btn_confirm = document.querySelector(".btn_confirm");
    var btn_cancel = document.querySelector(".btn_cancel");
    var record_time = document.querySelector(".record_time");
    var startTime;
    btn_start.onclick = function () {
      startTime = Date.now();
      video.src = localMedia;
      video.play();
      display(2);
      recordRTC.startRecording();
      console.log("recorder started");
      function drawVideoTime(time) {
        rafId = requestAnimationFrame(drawVideoTime);
        var et = parseInt((Date.now() - startTime) / 1000);
        elapsed_time = et;
        var minutes = parseInt(et / 60);
        var seconds = parseInt(et % 60);
        record_time.innerHTML = pad(minutes, 2) + ':' + pad(seconds, 2);
      };
      rafId = requestAnimationFrame(drawVideoTime);
    };

    btn_pause.onclick = function () {
      cancelAnimationFrame(rafId);
      video.pause();
      display(3);
      recordRTC.stopRecording(function (audioVideoWebMURL) {
        // window.open(audioVideoWebMURL);
        webmBlob = recordRTC.getBlob();
        video.src = audioVideoWebMURL;
        video.muted = false;

      });
      // console.log(mediaRecorder.state);
      console.log("recorder stopped");
      endTime = Date.now();
      console.log('frames captured: ' + frames.length + ' => ' +
        ((endTime - startTime) / 1000) + 's video');
    };



    btn_replay.onclick = function () {
      
      video.play();
      display(4);
      startTime = Date.now();
      function drawVideoTime(time) {
        rafId = requestAnimationFrame(drawVideoTime);
        var et = parseInt((Date.now() - startTime) / 1000);
        var minutes = parseInt(et / 60);
        var seconds = parseInt(et % 60);
        record_time.innerHTML = pad(minutes, 2) + ':' + pad(seconds, 2);
      };
      rafId = requestAnimationFrame(drawVideoTime);
      console.log(elapsed_time);
      timeoutId = setTimeout(function () {
        display(3);
        cancelAnimationFrame(rafId);
      },elapsed_time*1000);
    };

    btn_return_finish.onclick = function () {
      video.pause();
      display(3);
      cancelAnimationFrame(rafId);
      clearTimeout(timeoutId);
    }

    btn_confirm.onclick = function () {
      upload(webmBlob);
      insertTime();
      alert('upload');
    };

    btn_cancel.onclick = function () {
      display(1);
    }


    var start_foot = document.querySelector("#start");
    var pause_foot = document.querySelector("#pause");
    var finish_foot = document.querySelector("#finish");
    var return_finish = document.querySelector("#return-finish");
    display(1);

    function display(which) {
      start_foot.style.display = "none";
      pause_foot.style.display = "none";
      finish_foot.style.display = "none";
      return_finish.style.display = "none";
      if (which == 1) {
        start_foot.style.display = "block";
      } else if (which == 2) {
        pause_foot.style.display = "block";
      } else if (which == 3) {
        finish_foot.style.display = "block";
      } else if (which == 4) {
        return_finish.style.display = "block";
      }
    }

    function upload(blob) {
      var xhr = new XMLHttpRequest();
      var ret;
      xhr.onload = function (e) {
        if (this.readyState === 4) {
          ret = $.parseJSON(e.target.responseText);
          alert('upload successfully');
          console.log("Server returned: ", e.target.responseText);
          window.location = '/learn/{{ $lecture->id }}';
        }
      };
      var fd = new FormData();
      fd.append("webm", blob);
      xhr.open("POST", "/uploadWebm/{{ $lecture->id }}", true);
      xhr.send(fd);
    }

    function insertTime() {
      if (!voice_start) {
        console.log('voice_start null');
        return false;
      } else if (!voice_end) {
        console.log('voice_end null');
        return false;
      }
      $.post('/insert-voice-time/{{ $lecture->id }}',
        {voice_start:voice_start,voice_end:voice_end}
      );
    }

    function pad(num, size) {
        var s = num+"";
        while (s.length < size) s = "0" + s;
        return s;
    }
    function foreceDownload(blob, filename){
      var url = (window.URL || window.webkitURL).createObjectURL(blob);
      var link = window.document.createElement('a');
      link.href = url;
      link.download = filename || 'output.wav';
      var click = document.createEvent("Event");
      click.initEvent("click", true, true);
      link.dispatchEvent(click);
    }

    $('html').keydown(function(event){
      // console.log(event.which);

      if (event.which == 32 && startTime && !voice_start) {
        var nowTime = Date.now();
        voice_start = nowTime - startTime;
        console.log(voice_start);
      }
    });
    $('html').keyup(function(event){
      // console.log(event.which);
      if (event.which == 32 && startTime && !voice_end) {
        var nowTime = Date.now();
        voice_end = nowTime - startTime;
        console.log(startTime);
        console.log(nowTime);
        console.log(voice_end);
      }
    });
  </script>
</body>

</html>