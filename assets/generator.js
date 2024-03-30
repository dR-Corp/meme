(function (window, document) {
    CanvasRenderingContext2D.prototype.drawBreakingText = function (str, x, y, w, lh, method) {
        // local variables and defaults
        var textSize = parseInt(this.font.replace(/\D/gi, ''));
        var textParts = [];
        var textPartsNo = 0;
        var words = [];
        var currLine = '';
        var testLine = '';
        str = str || '';
        x = x || 0;
        y = y || 0;
        w = w || this.canvas.width;
        lh = lh || 1;
        method = method || 'fill';

        textParts = str.split('\n');
        textPartsNo = textParts.length;

        for (var i = 0; i < textParts.length; i++) {
            words[i] = textParts[i].split(' ');
        }

        textParts = [];

        for (var i = 0; i < textPartsNo; i++) {

            currLine = '';

            for (var j = 0; j < words[i].length; j++) {
                testLine = currLine + words[i][j] + ' ';

                if (this.measureText(testLine).width > w && j > 0) {
                    textParts.push(currLine);
                    currLine = words[i][j] + ' ';
                } else {
                    currLine = testLine;
                }
            }
            
            textParts.push(currLine);
        }

        for (var i = 0; i < textParts.length; i++) {
            if (method === 'fill') {
                this.fillText(textParts[i].replace(/((\s*\S+)*)\s*/, '$1'), x, y+(textSize*lh*i));
            } else if (method === 'stroke') {
                this.strokeText(textParts[i].replace(/((\s*\S+)*)\s*/, '$1'), x, y+(textSize*lh*i));
            } else if (method === 'none') {
        return {'textParts': textParts, 'textHeight': textSize*lh*textParts.length};
            } else {
        console.warn('drawBreakingText: ' + method + 'Text() does not exist');
                return false;
            }
        }

        return {'textParts': textParts, 'textHeight': textSize*lh*textParts.length};
    };
}) (window, document);

var canvas = document.createElement('canvas');
var canvasWrapper = document.getElementById('canvasDiv');
canvasWrapper.appendChild(canvas);
canvas.width = 500;
canvas.height = 500;
var ctx = canvas.getContext('2d');
var padding = 15;
var textTop = 'Texte de haut';
var textBottom = 'Texte de bas';
var textSizeTop = 10;
var textSizeBottom = 10;
var image = document.createElement('img');
var source_image = "";

image.onload = function (ev) {
    // delete and recreate canvas do untaint it
    canvas.outerHTML = '';
    canvas = document.createElement('canvas');
    canvasWrapper.appendChild(canvas);
    ctx = canvas.getContext('2d');
    document.getElementById('trueSize').click();
    document.getElementById('trueSize').click();
    
    draw();
};
  
document.getElementById('imgFile').onchange = function(ev) {
    var reader = new FileReader();
    reader.onload = function(ev) {
      image.src = reader.result;
      source_image = image.src;
    //   console.log(image.src);
      // a ce niveau on doit 
      // - uploader sur le serveur, le fichier image original
      // - sauver le nom donné au fichier dans une variable
    };
    reader.readAsDataURL(this.files[0]);
};

document.getElementById('textTop').oninput = function(ev) {
    textTop = this.value;
    draw();
};
document.getElementById('textBottom').oninput = function(ev) {
    textBottom = this.value;
    draw();
};

document.getElementById('textSizeTop').oninput = function(ev) {
    textSizeTop = parseInt(this.value);
    draw();
    document.getElementById('textSizeTopOut').innerHTML = this.value;
};
document.getElementById('textSizeBottom').oninput = function(ev) {
    textSizeBottom = parseInt(this.value);
    draw();
    document.getElementById('textSizeBottomOut').innerHTML = this.value;
};

document.getElementById('trueSize').onchange = function(ev) {
    if (document.getElementById('trueSize').checked) {
      canvas.classList.remove('fullwidth');
    } else {
      canvas.classList.add('fullwidth');
    }
};

document.getElementById('export').onclick = function () {
    var img = canvas.toDataURL('image/png');
    var link = document.createElement("a");
    link.download = 'My Meme';
    link.href = img;
    link.click();
  
    var win = window.open('', '_blank');
    win.document.write('<img style="box-shadow: 0 0 1em 0 dimgrey;" src="' + img + '"/>');
    win.document.write('<h1 style="font-family: Helvetica; font-weight: 300">Si l\'enregistrement n\'a pas fonctionné :<h1>');
    win.document.write('<h1 style="font-family: Helvetica; font-weight: 300">clic droit > Puis enregistrer comme<h1>');
    win.document.body.style.padding = '1em';
};

document.getElementById('save').onclick = function () {
    var img = canvas.toDataURL('image/png');

    // a ce niveau on doit 
    // - uploader sur le serveur, le fichier image final
    // - lancer une requete ajax, vers le serveur
    // - envoyer les données à enregistrer dans la tables memes

    var data = {
        top_text: textTop,
        bottom_text: textBottom,
        top_size: textSizeTop,
        bottom_size: textSizeBottom,
        image: img,
        source_image: source_image
    }
    fetch("http://localhost/meme/controllers/addMeme.php", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(res => {
        if(res.ok)
            return res.json();
        console.log("An error occure !");
    })
    .then(data => {
        console.log(data);
        alert(data.message);
    })
    .catch(error => {
        console.log(error);
    })

};

function style(font, size, align, base) {
    ctx.font = size + 'px ' + font;
    ctx.textAlign = align;
    ctx.textBaseline = base;
}

function draw() {
    // uppercase the text
    var top = textTop.toUpperCase();
    var bottom = textBottom.toUpperCase();
    
    // set appropriate canvas size
    canvas.width = image.width;
    canvas.height = image.height;
    
    // draw the image
    ctx.drawImage(image, 0, 0, canvas.width, canvas.height);
    
    // styles
    ctx.fillStyle = '#fff';
    ctx.strokeStyle = '#000';
    ctx.lineWidth = canvas.width*0.004;
    
    var _textSizeTop = textSizeTop/100*canvas.width;
    var _textSizeBottom = textSizeBottom/100*canvas.width;
    
    // draw top text
    style('Impact', _textSizeTop, 'center', 'bottom');
    ctx.drawBreakingText(top, canvas.width/2, _textSizeTop+padding, null, 1, 'fill');
    ctx.drawBreakingText(top, canvas.width/2, _textSizeTop+padding, null, 1, 'stroke');
  
    // draw bottom text
    style('Impact', _textSizeBottom, 'center', 'top');
    var height = ctx.drawBreakingText(bottom, 0, 0, null, 1, 'none').textHeight;
    // console.log(ctx.drawBreakingText(bottom, 0, 0, null, 1, 'none'));
    ctx.drawBreakingText(bottom, canvas.width/2, canvas.height-padding-height, null, 1, 'fill');
    ctx.drawBreakingText(bottom, canvas.width/2, canvas.height-padding-height, null, 1, 'stroke');
}

image.src = 'https://content.imageresizer.com/images/memes/Computer-Guy-Facepalm-meme-cdl6.jpg';
document.getElementById('textTop').value = textTop;
document.getElementById('textBottom').value = textBottom;
document.getElementById('textSizeTop').value = textSizeTop;
document.getElementById('textSizeBottom').value = textSizeBottom;
document.getElementById('textSizeTopOut').innerHTML = textSizeTop;
document.getElementById('textSizeBottomOut').innerHTML = textSizeBottom;