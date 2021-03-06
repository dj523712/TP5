if(!Detector.webgl) Detector.addGetWebGLMessage();

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

  var $container = $('<div class="snow-container"/>');
  var container = $container[0];
  $('body').append($container);

  var $canvas = $('<canvas/>');
  var canvas1 = $canvas[0];
  $canvas.attr({
    width: 32,
    height: window.innerHeight,
    id: 'mycanvas'
  });
  $canvas.addClass('myCanvas');
  $container.append($canvas);
  console.log($container);
  console.log($canvas);

  var context = canvas1.getContext('2d');

  var gradient = context.createLinearGradient(0, 0, 0, canvas1.height);
  gradient.addColorStop(0, "#1e4877");
  gradient.addColorStop(0.5, "#4584b4");

  context.fillStyle = gradient;
  context.fillRect(0, 0, canvas1.width, canvas1.height);

  container.style.background = 'url(' + canvas1.toDataURL('image/png') + ')';
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

};
