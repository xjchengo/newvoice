<!DOCTYPE html>
<html lang="ZH">
<head>
  <meta charset="utf-8">
  <title>新声-录音</title>
  <meta name="description" content="新声-听障儿童语言训练辅助工具">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
  <button id="test-btn">test</button>
  <script type="text/javascript">
    var SineWave = function (context) {
      this.x = 0;
      this.context = context;
      this.sampleRate = this.context.sampleRate;
      this.frequency = 700;
      this.amplitude = 2;
      this.playing = false;
      this.node = context.createJavaScriptNode(512, 0, 1);
      var that = this;
      this.node.onaudioprocess = function(e) { that.process(e) };
    }

    SineWave.prototype.process = function(e) {
      // Get a reference to the output buffer and fill it up.
      var data = e.outputBuffer.getChannelData(0);
      console.log(data.length);
      // We need to be careful about filling up the entire buffer and not
      // overflowing.
      for (var i = 0; i < data.length; ++i) {
        // data[i] = Math.sin(this.x++);
        data[i] = this.amplitude * Math.sin(this.x++ / (this.sampleRate / (2 * Math.PI * this.frequency)));
      }
    }

    SineWave.prototype.play = function() {
      // Plug the node into the output.
      this.node.connect(this.context.destination);
      this.playing = true;
    }

    SineWave.prototype.pause = function() {
      // Unplug the node.
      this.node.disconnect();
      this.playing = false;
    }

    var btn = document.getElementById('test-btn');
    console.log(btn);
    btn.onclick = function () {
      console.log('click it');
      while (1) {
        continue;
      }
    };


    var context = new webkitAudioContext();
    var sine = new SineWave(context);
    window.onload = function() {
      console.log(context);
      console.log(sine);

      // sine.play();
    };

    (function () {
      var str = '12312';
      window.str = str;
    })();
    console.log(str);
  </script>
</body>
</html>
