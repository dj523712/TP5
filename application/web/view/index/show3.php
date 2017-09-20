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

    <script type="text/javascript">if(!Detector.webgl) Detector.addGetWebGLMessage();

var container;
var camera, scene, renderer;
var mesh, geometry, material;

var mouseX = 0,
  mouseY = 0;
var start_time = Date.now();

var windowHalfX = window.innerWidth / 2;
var windowHalfY = window.innerHeight / 2;

init();

function init() {

  container = document.createElement('div');
  document.body.appendChild(container);

  // Bg gradient

  var canvas = document.createElement('canvas');
  canvas.width = 32;
  canvas.height = window.innerHeight;

  var context = canvas.getContext('2d');

  var gradient = context.createLinearGradient(0, 0, 0, canvas.height);
  gradient.addColorStop(0, "#1e4877");
  gradient.addColorStop(0.5, "#4584b4");

  context.fillStyle = gradient;
  context.fillRect(0, 0, canvas.width, canvas.height);

  container.style.background = 'url(' + canvas.toDataURL('image/png') + ')';
  container.style.backgroundSize = '32px 100%';

  //

  camera = new THREE.PerspectiveCamera(30, window.innerWidth / window.innerHeight, 1, 3000);
  camera.position.z = 6000;

  scene = new THREE.Scene();

  geometry = new THREE.Geometry();

  var texture = THREE.ImageUtils.loadTexture('/static/assets/images/cloud10.png', null, animate);
  texture.magFilter = THREE.LinearMipMapLinearFilter;
  texture.minFilter = THREE.LinearMipMapLinearFilter;

  var fog = new THREE.Fog(0x4584b4, -100, 3000);

  material = new THREE.ShaderMaterial({

    uniforms: {

      "map": {
        type: "t",
        value: texture
      },
      "fogColor": {
        type: "c",
        value: fog.color
      },
      "fogNear": {
        type: "f",
        value: fog.near
      },
      "fogFar": {
        type: "f",
        value: fog.far
      },

    },
    vertexShader: document.getElementById('vs').textContent,
    fragmentShader: document.getElementById('fs').textContent,
    depthWrite: false,
    depthTest: false,
    transparent: true

  });

  var plane = new THREE.Mesh(new THREE.PlaneGeometry(64, 64));

  for(var i = 0; i < 8000; i++) {

    plane.position.x = Math.random() * 1000 - 500;
    plane.position.y = -Math.random() * Math.random() * 200 - 15;
    plane.position.z = i;
    plane.rotation.z = Math.random() * Math.PI;
    plane.scale.x = plane.scale.y = Math.random() * Math.random() * 1.5 + 0.5;

    THREE.GeometryUtils.merge(geometry, plane);

  }

  mesh = new THREE.Mesh(geometry, material);
  scene.add(mesh);

  mesh = new THREE.Mesh(geometry, material);
  mesh.position.z = -8000;
  scene.add(mesh);

  renderer = new THREE.WebGLRenderer({
    antialias: false
  });
  renderer.setSize(window.innerWidth, window.innerHeight);
  container.appendChild(renderer.domElement);

  front = document.createElement('div');
  front.innerHTML = '<div style="position: fixed;top:30%;width: 100%;text-align: center;line-height: 120px;" class="is-animate style"><div>W</div><div>e</div><div>l</div><div>c</div><div>o</div><div>m</div><div>e</div><div> </div><div>t</div><div>o</div><div> </div><br><div>t</div><div>h</div><div>e</div><div> </div><div>d</div><div>a</div><div>r</div><div>k</div><div>c</div><div>a</div><div>s</div><div>t</div><div>l</div><div>e</div></div>';
  container.appendChild(front);
  
  document.addEventListener('mousemove', onDocumentMouseMove, false);
  window.addEventListener('resize', onWindowResize, false);

}

function onDocumentMouseMove(event) {

  mouseX = (event.clientX - windowHalfX) * 0.25;
  mouseY = (event.clientY - windowHalfY) * 0.15;

}

function onWindowResize(event) {

  camera.aspect = window.innerWidth / window.innerHeight;
  camera.updateProjectionMatrix();

  renderer.setSize(window.innerWidth, window.innerHeight);

}

function animate() {

  requestAnimationFrame(animate);

  position = ((Date.now() - start_time) * 0.03) % 8000;

  camera.position.x += (mouseX - camera.position.x) * 0.01;
  camera.position.y += (-mouseY - camera.position.y) * 0.01;
  camera.position.z = -position + 8000;

  renderer.render(scene, camera);

}</script>
    {load href="/static/assets/js/jquery.min.js" /}
  </body>
</html>
