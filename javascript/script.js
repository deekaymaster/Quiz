//CANVAS DIAGRAM KOŁOWY
var myCanvas = document.getElementById("myCanvas")

var ctx = myCanvas.getContext("2d");

var g = parseInt(document.getElementById("good").innerHTML)
var b = parseInt(document.getElementById("bad").innerHTML)
console.log("dobrych: ", g)
console.log("złych: ", b)

var scores = {
    "good": g,
    "bad": b
};

function rysujFragment(ctx,centerX, centerY, radius, startAngle, endAngle, color ){
    ctx.fillStyle = color;
    ctx.beginPath();
    ctx.moveTo(centerX,centerY);
    ctx.arc(centerX, centerY, radius, startAngle, endAngle);
    ctx.closePath();
    ctx.fill();
}

var Wykres = function(options){
    this.options = options;
    this.canvas = options.canvas;
    this.ctx = this.canvas.getContext("2d");
    this.colors = options.colors;
 
    this.draw = function(){
        var total_value = 0;
        var color_index = 0;
        for (var categ in this.options.data){
            var val = this.options.data[categ];
            total_value += val;
        }
 
        var start_angle = 0;
        for (categ in this.options.data){
            val = this.options.data[categ];
            var slice_angle = 2 * Math.PI * val / total_value;
 
            rysujFragment(
                this.ctx,
                this.canvas.width/2,
                this.canvas.height/2,
                Math.min(this.canvas.width/2,this.canvas.height/2),
                start_angle,
                start_angle+slice_angle,
                this.colors[color_index%this.colors.length]
            );
 
            start_angle += slice_angle;
            color_index++;
        }
 
    }
}

var mojWykres = new Wykres(
    {
        canvas: myCanvas,
        data: scores,
        colors: ["green","red"]
    }
);
mojWykres.draw();