var box = new Array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16');
var images = new Array('1.jpg', '2.jpg');
var width = 800;
var speed = 1500 / box.length;
var effect_running = false;

function show(id, time){
    $(id).show(time);
}

function show1(id, time){
    $(id).slideDown(time);
}

function show2(id, time){
    $(id).fadeIn(time);
}

function setImage(image){
    $('#diashow_act_image').attr('src', image);
    $('#diashow_act_image').css('display' , 'block');
    $('#diashow_act_image').css('z-index' , '0');
    
    $('.diashow_box').css('display', 'none');
    $('.diashow_tbox').css('display', 'none');
    effect_running = false;
}

function effect1(image){
    effect_running = true;
    
    $('.diashow_box').css('display' , 'block');
    var step = width / box.length;
    var act = 0;
    var act_speed = speed;
    for(b in box){
        b = box[b];
        var obj = $('#box' + b);
        obj.css('left' , act + 'px');
        obj.css('background-image', 'url(' + image + ')');
        obj.css('background-position', '-' + act + 'px 0px');
        obj.css('display', 'none');
        act = act + step;
        setTimeout('show("#box' + b + '", 1000)', act_speed);
        act_speed = act_speed + speed;
    }
    setTimeout('setImage("' + image + '")', act_speed + 1000);
}

function effect2(image){
    effect_running = true;
    
    $('.diashow_box').css('display' , 'block');
    var step = width / box.length;
    var act = width - step;
    var act_speed = speed;
    for(b in box){
        b = box[b];
        var obj = $('#box' + b);
        obj.css('left' , act + 'px');
        obj.css('background-image', 'url(' + image + ')');
        obj.css('background-position', '-' + act + 'px 0px');
        obj.css('display', 'none');
        act = act - step;
        setTimeout('show("#box' + b + '", 1000)', act_speed);
        act_speed = act_speed + speed;
    }
    setTimeout('setImage("' + image + '")', act_speed + 1000);
}

function effect3(image){
    effect_running = true;
    
    $('.diashow_box').css('display' , 'block');
    var step = width / box.length;
    var act = 0;
    var act_speed = speed;
    for(b in box){
        b = box[b];
        var obj = $('#box' + b);
        obj.css('left' , act + 'px');
        obj.css('background-image', 'url(' + image + ')');
        obj.css('background-position', '-' + act + 'px 0px');
        obj.css('display', 'none');
        act = act + step;
        setTimeout('show1("#box' + b + '", 1000)', act_speed);
        act_speed = act_speed + speed;
    }
    setTimeout('setImage("' + image + '")', act_speed + 1000);
}
function effect4(image){
    effect_running = true;
    
    $('.diashow_box').css('display' , 'block');
    var step = width / box.length;
    var act = width - step;
    var act_speed = speed;
    for(b in box){
        b = box[b];
        var obj = $('#box' + b);
        obj.css('left' , act + 'px');
        obj.css('background-image', 'url(' + image + ')');
        obj.css('background-position', '-' + act + 'px 0px');
        obj.css('display', 'none');
        act = act - step;
        setTimeout('show1("#box' + b + '", 1000)', act_speed);
        act_speed = act_speed + speed;
    }
    setTimeout('setImage("' + image + '")', act_speed + 1000);
}

function effect5(image){
    effect_running = true;
    
    $('.diashow_box').css('display' , 'block');
    var step = width / box.length;
    var act = 0;
    var act_speed = speed;
    for(b in box){
        b = box[b];
        var obj = $('#box' + b);
        obj.css('left' , act + 'px');
        obj.css('background-image', 'url(' + image + ')');
        obj.css('background-position', '-' + act + 'px 0px');
        obj.css('display', 'none');
        act = act + step;
        setTimeout('show2("#box' + b + '", 1000)', act_speed);
        act_speed = act_speed + speed;
    }
    setTimeout('setImage("' + image + '")', act_speed + 1000);
}

function effect6(image){
    effect_running = true;
    
    $('.diashow_box').css('display' , 'block');
    var step = width / box.length;
    var act = width - step;
    var act_speed = speed;
    for(b in box){
        b = box[b];
        var obj = $('#box' + b);
        obj.css('left' , act + 'px');
        obj.css('background-image', 'url(' + image + ')');
        obj.css('background-position', '-' + act + 'px 0px');
        obj.css('display', 'none');
        act = act - step;
        setTimeout('show2("#box' + b + '", 1000)', act_speed);
        act_speed = act_speed + speed;
    }
    setTimeout('setImage("' + image + '")', act_speed + 1000);
}

function effect7(image){
    effect_running = true;
    
    $('.diashow_tbox').css('display' , 'block');
    //$('.box').css('display' , 'none');
    //$('#act_image').css('display' , 'none');
    //$('#img_table').css('display' , 'block');
    var felder = new Array();
    while(felder.length < 48){
        var reihe = Math.round(Math.random() * (6 - 1)) + 1;
        var spalte = Math.round(Math.random() * (8 - 1)) + 1;
        var pos = '' + reihe + spalte;
        if(felder.join('|').indexOf(pos) == -1){
            felder.push(pos);
        }
    }
    var step = width / felder.length;
    var speed1 = 1500 / felder.length;
    var act_speed = speed1;
    for(i in felder){
        var pos = felder[i];
        var obj = $('#b' + pos);
        var pos_x = (pos.charAt(0) -1) * 100;
        var pos_y = (pos.charAt(1) -1) * 100;
        obj.css('background-image', 'url(' + image + ')');
        obj.css('background-position', '-' + pos_y + 'px -' + pos_x + 'px');
        obj.css('top', pos_x + 'px');
        obj.css('left', pos_y + 'px');
        obj.css('display', 'none');
        setTimeout('show("#b' + pos + '",300)', act_speed);
        act_speed = act_speed + speed1;
    }
    setTimeout('setImage("' + image + '")', act_speed + 1000);
}
function effect8(image){
    effect_running = true;
    
    $('.diashow_tbox').css('display' , 'block');
    //$('#img_table').css('display' , 'block');
    var felder = new Array();
    while(felder.length < 48){
        var reihe = Math.round(Math.random() * (6 - 1)) + 1;
        var spalte = Math.round(Math.random() * (8 - 1)) + 1;
        var pos = '' + reihe + spalte;
        if(felder.join('|').indexOf(pos) == -1){
            felder.push(pos);
        }
    }
    var step = width / felder.length;
    var speed1 = 1500 / felder.length;
    var act_speed = speed1;
    for(i in felder){
        var pos = felder[i];
        var obj = $('#b' + pos);
        var pos_x = (pos.charAt(0) -1) * 100;
        var pos_y = (pos.charAt(1) -1) * 100;
        obj.css('background-image', 'url(' + image + ')');
        obj.css('background-position', '-' + pos_y + 'px -' + pos_x + 'px');
        obj.css('top', pos_x + 'px');
        obj.css('left', pos_y + 'px');
        obj.css('display', 'none');
        setTimeout('show1("#b' + pos + '",300)', act_speed);
        act_speed = act_speed + speed1;
    }
    setTimeout('setImage("' + image + '")', act_speed + 1000);
    
}
function effect9(image){
    effect_running = true;
    
    $('.diashow_tbox').css('display' , 'block');
    //$('#img_table').css('display' , 'block');
    var felder = new Array();
    while(felder.length < 48){
        var reihe = Math.round(Math.random() * (6 - 1)) + 1;
        var spalte = Math.round(Math.random() * (8 - 1)) + 1;
        var pos = '' + reihe + spalte;
        if(felder.join('|').indexOf(pos) == -1){
            felder.push(pos);
        }
    }
    var step = width / felder.length;
    var speed1 = 1500 / felder.length;
    var act_speed = speed1;
    for(i in felder){
        var pos = felder[i];
        var obj = $('#b' + pos);
        var pos_x = (pos.charAt(0) -1) * 100;
        var pos_y = (pos.charAt(1) -1) * 100;
        obj.css('background-image', 'url(' + image + ')');
        obj.css('background-position', '-' + pos_y + 'px -' + pos_x + 'px');
        obj.css('top', pos_x + 'px');
        obj.css('left', pos_y + 'px');
        obj.css('display', 'none');
        setTimeout('show2("#b' + pos + '",300)', act_speed);
        act_speed = act_speed + speed1;
    }
    setTimeout('setImage("' + image + '")', act_speed + 1000);
}
function effect10(image, rev){
    effect_running = true;
    
    $('.diashow_tbox').css('display' , 'block');
    //$('#img_table').css('display' , 'block');
    var felder = new Array('11', '12', '21', '13', '22', '31', '14', '23', '32', '41', '15', '24', '33', '42', '51', '16', '25', '34', '43', '52', '61', '17', '26', '35', '44', '53', '62', '18', '27', '36', '45', '54', '63', '28', '37', '46', '55', '64', '38', '47', '56', '65', '48', '57', '66', '58', '67', '68');
    if(rev){
        felder.reverse();
    }
    var step = width / felder.length;
    var speed1 = 1500 / felder.length;
    var act_speed = speed1;
    for(i in felder){effect_running = true;
        var pos = felder[i];
        var obj = $('#b' + pos);
        var pos_x = (pos.charAt(0) -1) * 100;
        var pos_y = (pos.charAt(1) -1) * 100;
        obj.css('background-image', 'url(' + image + ')');
        obj.css('background-position', '-' + pos_y + 'px -' + pos_x + 'px');
        obj.css('top', pos_x + 'px');
        obj.css('left', pos_y + 'px');
        obj.css('display', 'none');
        setTimeout('show2("#b' + pos + '",300)', act_speed);
        act_speed = act_speed + speed1;
    }
    setTimeout('setImage("' + image + '")', act_speed + 1000);
}

function effect(image, number, way){
    //way: 1= next, 2= back
    if(number == 1){
        if(way === 1){
            effect1(image);
        }else{
            effect2(image);
        }
    }else if(number == 2){
        if(way === 1){
            effect3(image);
        }else{
            effect4(image);
        }
    }else if(number == 3){
        if(way === 1){
            effect5(image);
        }else{
            effect6(image);
        }
    }else if(number == 4){
        effect7(image);
        
    }else if(number == 5){
        effect8(image);
        
    }else if(number == 6){
        effect9(image);
        
    }else if(number == 7){
        if(way === 1){
            effect10(image, false);
        }else{
            effect10(image, true);
        }
    }
}

function diashow_init(id, image){
    var html = "<div id='diashow_image_box'><img id='diashow_act_image' src='" + image + "' /><div class='diashow_tbox' id='b11'></div><div class='diashow_tbox' id='b12'></div><div class='diashow_tbox' id='b13'></div><div class='diashow_tbox' id='b14'></div><div class='diashow_tbox' id='b15'></div><div class='diashow_tbox' id='b16'></div><div class='diashow_tbox' id='b17'></div><div class='diashow_tbox' id='b18'></div><div class='diashow_tbox' id='b21'></div><div class='diashow_tbox' id='b22'></div><div class='diashow_tbox' id='b23'></div><div class='diashow_tbox' id='b24'></div><div class='diashow_tbox' id='b25'></div><div class='diashow_tbox' id='b26'></div><div class='diashow_tbox' id='b27'></div><div class='diashow_tbox' id='b28'></div><div class='diashow_tbox' id='b31'></div><div class='diashow_tbox' id='b32'></div><div class='diashow_tbox' id='b33'></div><div class='diashow_tbox' id='b34'></div><div class='diashow_tbox' id='b35'></div><div class='diashow_tbox' id='b36'></div><div class='diashow_tbox' id='b37'></div><div class='diashow_tbox' id='b38'></div><div class='diashow_tbox' id='b41'></div><div class='diashow_tbox' id='b42'></div><div class='diashow_tbox' id='b43'></div><div class='diashow_tbox' id='b44'></div><div class='diashow_tbox' id='b45'></div><div class='diashow_tbox' id='b46'></div><div class='diashow_tbox' id='b47'></div><div class='diashow_tbox' id='b48'></div><div class='diashow_tbox' id='b51'></div><div class='diashow_tbox' id='b52'></div><div class='diashow_tbox' id='b53'></div><div class='diashow_tbox' id='b54'></div><div class='diashow_tbox' id='b55'></div><div class='diashow_tbox' id='b56'></div><div class='diashow_tbox' id='b57'></div><div class='diashow_tbox' id='b58'></div><div class='diashow_tbox' id='b61'></div><div class='diashow_tbox' id='b62'></div><div class='diashow_tbox' id='b63'></div><div class='diashow_tbox' id='b64'></div><div class='diashow_tbox' id='b65'></div><div class='diashow_tbox' id='b66'></div><div class='diashow_tbox' id='b67'></div><div class='diashow_tbox' id='b68'></div><div class='diashow_box' id='box1'></div><div class='diashow_box' id='box2'></div><div class='diashow_box' id='box3'></div><div class='diashow_box' id='box4'></div><div class='diashow_box' id='box5'></div><div class='diashow_box' id='box6'></div><div class='diashow_box' id='box7'></div><div class='diashow_box' id='box8'></div><div class='diashow_box' id='box9'></div><div class='diashow_box' id='box10'></div><div class='diashow_box' id='box11'></div><div class='diashow_box' id='box12'></div><div class='diashow_box' id='box13'></div><div class='diashow_box' id='box14'></div><div class='diashow_box' id='box15'></div><div class='diashow_box' id='box16'></div>  </div>";
    $('#' + id).html(html);
}