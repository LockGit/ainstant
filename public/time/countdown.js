var WINDOW_WIDTH = 1024; //canvas宽度
var WINDOW_HEIGHT = 600; //canvas高度
var RADIUS = 4;
var MARGIN_TOP = 60;
var MARGIN_LEFT = 30;

const endTime = new Date(2007,9,10,10,10,0);
var curShowTimeSeconds = 0

var balls = [];
const colors = ["#33B5E5","#0099CC","#AA66CC","#9933CC","#99CC00","#669900","#FFBB33","#FF8800","#FF4444","#CC0000"];

window.onload = function(){
    
    WINDOW_WIDTH = document.body.clientWidth;// 屏幕宽度
    WINDOW_HEIGHT = document.body.clientHeight; // 屏幕高度


    MARGIN_LEFT = Math.round(WINDOW_WIDTH /20)-10;
    RADIUS = Math.round(WINDOW_WIDTH * 9 / 10 / 228)-1;

    MARGIN_TOP = Math.round(WINDOW_HEIGHT /5);


    var canvas = document.getElementById("canvas");
    canvas.width = WINDOW_WIDTH;    //设定canvas宽度
    canvas.height = WINDOW_HEIGHT;    //设定canvas高度
    var context = canvas.getContext("2d"); //获取canvas

    //curShowTimeSeconds = getCurrentShowTimeSeconds();

    curShowTimeSecondsMs = getCurrentShowTimeSecondsMs();
    //alert(curShowTimeSeconds);
    //curShowTimeSeconds = 86400;

    setInterval(
        function(){
            render( context );
            update();
        }
        ,
        50
    );

}

// function getCurrentShowTimeSeconds() {
//     var curTime = new Date(); //    获取当前时间
//     //var ret = endTime.getTime() - curTime.getTime();//  截止时间-当前时间
//     //var ret = curTime.getTime() - endTime.getTime();//  截止时间-当前时间
//     //ret = Math.round( ret/100000 );
//     var theEndTime = endTime.getTime();
//     var theGetTime = curTime.getTime();
//     var ret = theEndTime - theGetTime;
//     ret = Math.round( ret/1000 );
    

//     return ret >= 0 ? ret : 0;
// }

function getCurrentShowTimeSecondsMs() {
    var curTime = new Date(); //    获取当前时间
    //var ret = endTime.getTime() - curTime.getTime();//  截止时间-当前时间
    //var ret = curTime.getTime() - endTime.getTime();//  截止时间-当前时间
    //ret = Math.round( ret/100000 );
    var theEndTime = endTime.getTime();
    var theGetTime = curTime.getTime();
    //var ret = theEndTime - theGetTime;
    var ret = theGetTime - theEndTime;
    //ret = Math.round( ret/1000 );
    

    return ret >= 0 ? ret : 0;
}

function update(){

    // var nextShowTimeSeconds = getCurrentShowTimeSeconds();

    // var nextHours = parseInt( nextShowTimeSeconds / 3600);
    // var nextMinutes = parseInt( (nextShowTimeSeconds - nextHours * 3600)/60 );
    // var nextSeconds = nextShowTimeSeconds % 60;

    // var curHours = parseInt( curShowTimeSeconds / 3600);
    // var curMinutes = parseInt( (curShowTimeSeconds - curHours * 3600)/60 );
    // var curSeconds = curShowTimeSeconds % 60;
    var nextShowTimeSecondsMs = getCurrentShowTimeSecondsMs();

    var nextTime = new Date(nextShowTimeSecondsMs);

    var nextYears = nextTime.getFullYear() - 1970;
    var nextMonths = nextTime.getMonth();
    var nextDates = nextTime.getDate();

    var nextHours = nextTime.getHours();   
    var nextMinutes = nextTime.getMinutes();
    var nextSeconds = nextTime.getSeconds();

    var currentTime = new Date(curShowTimeSecondsMs);

    var curYears = currentTime.getFullYear() - 1970;
    var curMonths = currentTime.getMonth();
    var curDates = currentTime.getDate();

    var curHours = currentTime.getHours();   
    var curMinutes = currentTime.getMinutes();
    var curSeconds = currentTime.getSeconds();



    if( nextSeconds != curSeconds ){
        if( parseInt(curYears/10) != parseInt(nextYears/10) ){
            addBalls( MARGIN_LEFT + 0 , MARGIN_TOP , parseInt(curHours/10) );
        }
        if( parseInt(curYears%10) != parseInt(nextYears%10) ){
            addBalls( MARGIN_LEFT + 15*(RADIUS+1) , MARGIN_TOP , parseInt(curHours/10) );
        }

        if( parseInt(curMonths/10) != parseInt(nextMonths/10) ){
            addBalls( MARGIN_LEFT + 39*(RADIUS+1) , MARGIN_TOP , parseInt(curMinutes/10) );
        }
        if( parseInt(curMonths%10) != parseInt(nextMonths%10) ){
            addBalls( MARGIN_LEFT + 54*(RADIUS+1) , MARGIN_TOP , parseInt(curMinutes%10) );
        }

        if( parseInt(curDates/10) != parseInt(nextDates/10) ){
            addBalls( MARGIN_LEFT + 78*(RADIUS+1) , MARGIN_TOP , parseInt(curSeconds/10) );
        }
        if( parseInt(curDates%10) != parseInt(nextDates%10) ){
            addBalls( MARGIN_LEFT + 93*(RADIUS+1) , MARGIN_TOP , parseInt(nextSeconds%10) );
        }


        if( parseInt(curHours/10) != parseInt(nextHours/10) ){
            addBalls( MARGIN_LEFT + 120 , MARGIN_TOP , parseInt(curHours/10) );
        }
        if( parseInt(curHours%10) != parseInt(nextHours%10) ){
            addBalls( MARGIN_LEFT + 135*(RADIUS+1) , MARGIN_TOP , parseInt(curHours/10) );
        }

        if( parseInt(curMinutes/10) != parseInt(nextMinutes/10) ){
            addBalls( MARGIN_LEFT + 159*(RADIUS+1) , MARGIN_TOP , parseInt(curMinutes/10) );
        }
        if( parseInt(curMinutes%10) != parseInt(nextMinutes%10) ){
            addBalls( MARGIN_LEFT + 174*(RADIUS+1) , MARGIN_TOP , parseInt(curMinutes%10) );
        }

        if( parseInt(curSeconds/10) != parseInt(nextSeconds/10) ){
            addBalls( MARGIN_LEFT + 198*(RADIUS+1) , MARGIN_TOP , parseInt(curSeconds/10) );
        }
        if( parseInt(curSeconds%10) != parseInt(nextSeconds%10) ){
            addBalls( MARGIN_LEFT + 213*(RADIUS+1) , MARGIN_TOP , parseInt(nextSeconds%10) );
        }

        curShowTimeSecondsMs = nextShowTimeSecondsMs;
    }

    updateBalls();

    console.log( balls.length);
}

function updateBalls(){

    for( var i = 0 ; i < balls.length ; i ++ ){

        balls[i].x += balls[i].vx;
        balls[i].y += balls[i].vy;
        balls[i].vy += balls[i].g;

        if( balls[i].y >= WINDOW_HEIGHT-RADIUS ){
            balls[i].y = WINDOW_HEIGHT-RADIUS;
            balls[i].vy = - balls[i].vy*0.75;
        }
    }

    var cnt = 0
    for( var i = 0 ; i < balls.length ; i ++ )
        if( balls[i].x + RADIUS > 0 && balls[i].x -RADIUS < WINDOW_WIDTH )
            balls[cnt++] = balls[i]

    //while( balls.length > cnt ){
    while( balls.length > Math.min(400,cnt) ){
        balls.pop();
    }
}

function addBalls( x , y , num ){

    for( var i = 0  ; i < digit[num].length ; i ++ )
        for( var j = 0  ; j < digit[num][i].length ; j ++ )
            if( digit[num][i][j] == 1 ){
                var aBall = {
                    x:x+j*2*(RADIUS+1)+(RADIUS+1),
                    y:y+i*2*(RADIUS+1)+(RADIUS+1),
                    g:1.5+Math.random(),
                    vx:Math.pow( -1 , Math.ceil( Math.random()*1000 ) ) * 4,
                    vy:-5,
                    color: colors[ Math.floor( Math.random()*colors.length ) ]
                }

                balls.push( aBall );
            }
}

function render( cxt ){

    cxt.clearRect(0,0,WINDOW_WIDTH, WINDOW_HEIGHT);
    // var hours = 12;
    // var minutes = 34;
    // var seconds = 56;

    var newTime = new Date(curShowTimeSecondsMs); //就得到普通的时间了 
    var years = newTime.getFullYear() - 1970;
    var months = newTime.getMonth();
    var dates = newTime.getDate();

    var hours = newTime.getHours();    
    var minutes = newTime.getMinutes();
    var seconds = newTime.getSeconds();

    //alert(hours); 
    
    //var hours = parseInt( curShowTimeSeconds / 3600);
    //var minutes = parseInt( (curShowTimeSeconds - hours * 3600)/60 );
    //var seconds = curShowTimeSeconds % 60;

    

    renderDigit( MARGIN_LEFT , MARGIN_TOP , parseInt(years/10) , cxt );
    renderDigit( MARGIN_LEFT + 15*(RADIUS+1) , MARGIN_TOP , parseInt(years%10) , cxt );
    renderDigit( MARGIN_LEFT + 30*(RADIUS+1) , MARGIN_TOP , 11 , cxt );
    renderDigit( MARGIN_LEFT + 39*(RADIUS+1) , MARGIN_TOP , parseInt(months/10) , cxt);
    renderDigit( MARGIN_LEFT + 54*(RADIUS+1) , MARGIN_TOP , parseInt(months%10) , cxt);
    renderDigit( MARGIN_LEFT + 69*(RADIUS+1) , MARGIN_TOP , 11 , cxt);
    renderDigit( MARGIN_LEFT + 78*(RADIUS+1) , MARGIN_TOP , parseInt(dates/10) , cxt);
    renderDigit( MARGIN_LEFT + 93*(RADIUS+1) , MARGIN_TOP , parseInt(dates%10) , cxt);


    renderDigit( MARGIN_LEFT + 120*(RADIUS+1), MARGIN_TOP , parseInt(hours/10) , cxt );
    renderDigit( MARGIN_LEFT + 135*(RADIUS+1) , MARGIN_TOP , parseInt(hours%10) , cxt );
    renderDigit( MARGIN_LEFT + 150*(RADIUS+1) , MARGIN_TOP , 10 , cxt );
    renderDigit( MARGIN_LEFT + 159*(RADIUS+1) , MARGIN_TOP , parseInt(minutes/10) , cxt);
    renderDigit( MARGIN_LEFT + 174*(RADIUS+1) , MARGIN_TOP , parseInt(minutes%10) , cxt);
    renderDigit( MARGIN_LEFT + 189*(RADIUS+1) , MARGIN_TOP , 10 , cxt);
    renderDigit( MARGIN_LEFT + 198*(RADIUS+1) , MARGIN_TOP , parseInt(seconds/10) , cxt);
    renderDigit( MARGIN_LEFT + 213*(RADIUS+1) , MARGIN_TOP , parseInt(seconds%10) , cxt);

    for( var i = 0 ; i < balls.length ; i ++ ){
        cxt.fillStyle=balls[i].color;

        cxt.beginPath();
        cxt.arc( balls[i].x , balls[i].y , RADIUS , 0 , 2*Math.PI , true );
        cxt.closePath();

        cxt.fill();
    }

    
    cxt.font = "bold 40px Arial";

    cxt.fillStyle = "#058";
    //cxt.beginPath();
    cxt.fillText("与你一起走过",MARGIN_LEFT,MARGIN_TOP*3);

}

function renderDigit( x , y , num , cxt ){

    //cxt.fillStyle = "rgb(0,102,153)";
    cxt.fillStyle = "#ff6600";

    for( var i = 0 ; i < digit[num].length ; i ++ )
        for(var j = 0 ; j < digit[num][i].length ; j ++ )
            if( digit[num][i][j] == 1 ){
                cxt.beginPath();
                cxt.arc( x+j*2*(RADIUS+1)+(RADIUS+1) , y+i*2*(RADIUS+1)+(RADIUS+1) , RADIUS , 0 , 2*Math.PI );
                cxt.closePath();

                cxt.fill();
            }
}
