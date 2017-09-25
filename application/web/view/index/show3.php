<?php ?>
<!DOCTYPE html>
<html lang="zh-cn" ng-app="app">
  <head>
    <title>Welcome to the darkcastle</title>
    <meta charset="utf-8">
    <!--/* 字体特效 */-->
    {load href="/static/assets/css/animations.css" /}
<style type="text/css">
body {
  background-color: #326696;
  margin: 0px;
  overflow: hidden;
  font-family: Monospace;
  font-size: 13px;
  text-align: center;
  font-weight: bold;
  text-align: center;
}

a {
  color: #0078ff;
}


.is-animate.style > div { animation-name: style1; }

.is-animate > div {
  font-size: 50px;
  display: inline-block;
  margin: 1px;
  color: deepskyblue;
  padding: 12px;
  border-radius: 4px;
  animation-duration: 1s;
  animation-fill-mode: both;
  animation-iteration-count: infinite;
}

/*字体动画*/
.is-animate > div:nth-child(1) { animation-delay: 0.0s }
.is-animate > div:nth-child(2) { animation-delay: 0.2s }
.is-animate > div:nth-child(3) { animation-delay: 0.4s }
.is-animate > div:nth-child(4) { animation-delay: 0.6s }
.is-animate > div:nth-child(5) { animation-delay: 0.8s }
.is-animate > div:nth-child(6) { animation-delay: 1.0s }
.is-animate > div:nth-child(7) { animation-delay: 1.2s }
.is-animate > div:nth-child(8) { animation-delay: 1.4s }
.is-animate > div:nth-child(9) { animation-delay: 1.6s }
.is-animate > div:nth-child(10) { animation-delay: 1.8s }
.is-animate > div:nth-child(11) { animation-delay: 2.0s }
.is-animate > div:nth-child(12) { animation-delay: 2.2s }
.is-animate > div:nth-child(13) { animation-delay: 0.0s }
.is-animate > div:nth-child(14) { animation-delay: 0.2s }
.is-animate > div:nth-child(15) { animation-delay: 0.4s }
.is-animate > div:nth-child(16) { animation-delay: 0.6s }
.is-animate > div:nth-child(17) { animation-delay: 0.8s }
.is-animate > div:nth-child(18) { animation-delay: 1.0s }
.is-animate > div:nth-child(19) { animation-delay: 1.2s }
.is-animate > div:nth-child(20) { animation-delay: 1.4s }
.is-animate > div:nth-child(21) { animation-delay: 1.6s }
.is-animate > div:nth-child(22) { animation-delay: 1.8s }
.is-animate > div:nth-child(23) { animation-delay: 2.0s }
.is-animate > div:nth-child(24) { animation-delay: 2.2s }
.is-animate > div:nth-child(25) { animation-delay: 2.4s }
.is-animate > div:nth-child(26) { animation-delay: 2.6s }

</style>
  </head>
  <body>
    {load href="/static/assets/js/three.min.js" /}
    {load href="/static/assets/js/Detector.js" /}
    <script id="vs" type="x-shader/x-vertex">
      varying vec2 vUv;
      void main() {
      vUv = uv;
      gl_Position = projectionMatrix * modelViewMatrix * vec4( position, 1.0 );
      }

    </script>
    <script id="fs" type="x-shader/x-fragment">

      uniform sampler2D map;

      uniform vec3 fogColor;
      uniform float fogNear;
      uniform float fogFar;

      varying vec2 vUv;

      void main() {
      float depth = gl_FragCoord.z / gl_FragCoord.w;
      float fogFactor = smoothstep( fogNear, fogFar, depth );

      gl_FragColor = texture2D( map, vUv );
      gl_FragColor.w *= pow( gl_FragCoord.z, 20.0 );
      gl_FragColor = mix( gl_FragColor, vec4( fogColor, gl_FragColor.w ), fogFactor );
      }

    </script>

    {load href="/static/assets/js/jquery.min.js" /}
    {load href="/static/assets/js/cloud.js" /}
    {load href="/static/assets/js/all.js" /}
  </body>
</html>
