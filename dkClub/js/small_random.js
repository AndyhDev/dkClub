var img_prefix = 'schmal_zufall/';

var img_loaded = -1;
var document_ready = false;
var loaded_images = new Array();

function load_images(){      
  for (var i = 0; i < images.length; i++){
      var img = new Image();
      img.src = img_prefix + images[i];
      $(img).load(check_ok);
      loaded_images.push(img);
  }
}
function check_ok(){
  img_loaded++;
  if(document_ready && img_loaded == images.length){
      rotate_start(rotate_id);
  }
}

load_images();

function ev1(img, id){
if($('#' + id + ' .overlay1').css('display') == 'none'){
  var layer = 1;
  var o_layer = 2;
}else{
  var layer = 2;
  var o_layer = 1;
}
  $('#' + id + ' .overlay' + o_layer).css({'z-index' : '1'});
  $('#' + id + ' .overlay' + layer).css({'z-index' : '99', 'left' : '250px', 'background-image' : 'url(' + img + ')', 'display' : 'block'});
  $('#' + id + ' .overlay' + layer).animate({'left' : '0px'}, 2500, function(){
    $('#' + id + ' .overlay' + o_layer).css({'display' : 'none'});
  });
}
function ev2(img, id){
if($('#' + id + ' .overlay1').css('display') == 'none'){
  var layer = 1;
  var o_layer = 2;
}else{
  var layer = 2;
  var o_layer = 1;
}
  $('#' + id + ' .overlay' + o_layer).css({'z-index' : '1'});
  $('#' + id + ' .overlay' + layer).css({'z-index' : '99', 'left' : '-250px', 'background-image' : 'url(' + img + ')', 'display' : 'block'});
  $('#' + id + ' .overlay' + layer).animate({'left' : '0px'}, 2500, function(){
    $('#' + id + ' .overlay' + o_layer).css({'display' : 'none'});
  });
}
function ev3(img, id){
if($('#' + id + ' .overlay1').css('display') == 'none'){
  var layer = 1;
  var o_layer = 2;
}else{
  var layer = 2;
  var o_layer = 1;
}
  $('#' + id + ' .overlay' + o_layer).css({'z-index' : '1'});
  $('#' + id + ' .overlay' + layer).css({'z-index' : '99', 'top' : '-600px', 'background-image' : 'url(' + img + ')', 'display' : 'block'});
  $('#' + id + ' .overlay' + layer).animate({'top' : '0px'}, 2500, function(){
    $('#' + id + ' .overlay' + o_layer).css({'display' : 'none'});
  });
}
function ev4(img, id){
if($('#' + id + ' .overlay1').css('display') == 'none'){
  var layer = 1;
  var o_layer = 2;
}else{
  var layer = 2;
  var o_layer = 1;
}
  $('#' + id + ' .overlay' + o_layer).css({'z-index' : '1'});
  $('#' + id + ' .overlay' + layer).css({'z-index' : '99', 'top' : '600px', 'background-image' : 'url(' + img + ')', 'display' : 'block'});
  $('#' + id + ' .overlay' + layer).animate({'top' : '0px'}, 2500, function(){
    $('#' + id + ' .overlay' + o_layer).css({'display' : 'none'});
  });
}
function rotate(id){
  var minz = 0;
  var maxz = images.length -1;
  var cur_img = Math.floor(Math.random() * (maxz - minz + 1)) + minz;
  var img = img_prefix + images[cur_img];

  var minz = 1;
  var maxz = 4;
  var x = Math.floor(Math.random() * (maxz - minz + 1)) + minz;
  setTimeout("ev" + x + "('" + img + "', '" + id + "')", 100);
  setTimeout("rotate('" + id + "')", 5000)
}
function rotate_start(id){
  var minz = 0;
  var maxz = images.length -1;
  var cur_img = Math.floor(Math.random() * (maxz - minz + 1)) + minz;
  var img = img_prefix + images[cur_img];
  $('#' + id+ ' .overlay1').css({'background-image' : 'url(' + img + ')'});
  setTimeout("rotate('" + id + "')", 5000)
}
