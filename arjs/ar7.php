<script src="js/three.min.js"></script>
<script src="https://raw.githack.com/webarkit/ARnft/master/dist/ARnft.js"></script>
<script>

  var nft = new ARnft(640, 480, 'config.json');

  nft.init("arjs/pinball", true);

  var mat = new THREE.MeshLambertMaterial({color: 0xff0000});
  var cubeGeom = new THREE.CubeGeometry(1,1,1);
  var cube = new THREE.Mesh(cubeGeom, mat);
  cube.position.z = 90;
  cube.position.x = 90;
  cube.position.y = 90;
  cube.scale.set(180,180,180);

  nft.add(cube);

</script>
