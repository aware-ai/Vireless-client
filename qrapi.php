<!DOCTYPE html>
<html>
<head>
	<script src="qrcode.js"></script>
	<script src="jspdf.js"></script>
	<script src="FileSaver.min.js"></script>
</head>
<body onload="genqr()">

<script>
var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9\+\/\=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/\r\n/g,"\n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}};
</script>

<script>
function rSqr(str) {
    var nS = "";
    for (var i = str.length - 1; i >= 0; i--) {
        nS += str[i];
    }
    return nS;
}
	
function genqr(){
	var guest = {
        n: "<?php echo $_GET["name"]; ?>",
        s: "<?php echo $_GET["street"]; ?>",
        z: "<?php echo $_GET["zip"]; ?>",
        c: "<?php echo $_GET["city"]; ?>",
        t: "<?php echo $_GET["phone"]; ?>",
        e: "<?php echo $_GET["mail"]; ?>"
    };
    var guestString = rSqr(Base64.encode(JSON.stringify(guest)));
    var full_name = "<?php echo $_GET["name"]; ?>";
    qr_generate([full_name, full_name, full_name, full_name], [guestString, guestString, guestString, guestString], 2);
}
	
function qr_generate(titles, codes, columns, scale, paper_width, paper_height, margin_left, margin_top) {
    columns = columns || 9;
    scale = scale || 0.9;
    paper_width = paper_width || 210.0;
    paper_height = paper_height || 297.0;
    margin_left = margin_left || 10.0;
    margin_top = margin_top || 10.0;
    var doc = new jsPDF();
    //QR CODE GENERATOR - DO NOT CHANGE ANY PARAMETERS EXCEPT columns
    //--------------------------------------------------------------------------
    var ratio = 8.0 / parseFloat(columns);
    var x_0 = 3.125 * ratio, y_0 = 3.125 * ratio, dx = 6.25 * ratio, dy = 6.25 * ratio;
    qr_width = 20.0 * ratio;
    var code_margin_top = 5.15 * ratio, code_margin_between = 1.0 * ratio;
    var font_size_1 = 3.0 * ratio,
        font_size_2 = 2.0 * ratio;
    x_0 *= scale;
    y_0 *= scale;
    dx *= scale;
    dy *= scale;
    qr_width *= scale;
    code_margin_top *= scale;
    code_margin_between *= scale;
    font_size_1 *= scale;
    font_size_2 *= scale;
    x_0 += margin_left;
    y_0 += margin_top;
    var codes_per_page = columns * columns;
    var red_square_width_ratio = 0.13;
    options = {
        render: "canvas",
        width: qr_width,
        height: qr_width,
        typeNumber: -1,
        correctLevel: QRErrorCorrectLevel.H,
        background: "#ffffff",
        foreground: "#000000"
    };
    var red_square_width = options.width * (red_square_width_ratio);
    for (var k = 0; k < codes.length; k++) {
        var title = titles[k];
        var code_name = codes[k];
        if (k != 0 && k % codes_per_page == 0) {
            doc.addPage();
        }
        /*
        if (k % codes_per_page == 0) {
            for (var i = 0; i < columns + 1; i++) {
                doc.setDrawColor(200, 200, 200); // draw red lines
                doc.setLineWidth(0.2);
                doc.line(margin_left + scale * paper_width / columns * i, margin_top, margin_left + scale * paper_width / columns * i, margin_top + scale * paper_height); // vertical line
            }
            for (var i = 0; i < columns + 1; i++) {
                doc.setDrawColor(200, 200, 200); // draw red lines
                doc.setLineWidth(0.2);
                doc.line(margin_left, margin_top + scale * paper_height / columns * i, margin_left + scale * paper_width, margin_top + scale * paper_height / columns * i); // horizontal line
            }
        }
         */
        var x = x_0 + (k % columns) * (options.width + dx)
        var y_1 = y_0 + ((k % codes_per_page - k % columns) / columns) * (options.height + code_margin_top + code_margin_between + (parseFloat(font_size_1) + parseFloat(font_size_2)) / 17.0 * 4.0 + dy)
        // create the qrcode itself
        var qrcode = new QRCode(options.typeNumber, options.correctLevel);
        qrcode.addData(code_name);
        qrcode.make();
        // compute tileW/tileH based on options.width/options.height
        var tileW = options.width / qrcode.getModuleCount();
        var tileH = options.height / qrcode.getModuleCount();
        // draw in the canvas
        var black_line = 0;
        doc.setDrawColor(0);
        doc.setFillColor(0, 0, 0);
        for (var row = 0; row < qrcode.getModuleCount(); row++) {
            black_line = 0;
            for (var col = 0; col < qrcode.getModuleCount(); col++) {
                //QR CODE (v3) using SQUARES OPTIMIZED
                if (qrcode.isDark(row, col)) {
                    black_line = black_line + 1;
                    if (col == qrcode.getModuleCount() - 1) {
                        doc.rect(x + tileW * (col - black_line + 1), y_1 + tileH * row, tileW * black_line, tileH, 'F');
                    }
                } else {
                    if (black_line != 0) {
                        doc.rect(x + tileW * (col - black_line), y_1 + tileH * row, tileW * black_line, tileH, 'F');
                        black_line = 0;
                    }
                }
            }
        }
        var y_text_line_1 = y_1 + options.height + parseFloat(font_size_1) / 17.0 * 4.0 + code_margin_top;
        var y_text_line_2 = y_text_line_1 + parseFloat(font_size_2) / 17.0 * 4.0 + code_margin_between;
        doc.setFontSize(font_size_1);
        doc.text(x, y_text_line_1, title);
        doc.setFontSize(font_size_2);
        doc.text(x, y_text_line_2, 'Vireless.eu');
    }
    doc.output('save', 'qr_codes.pdf');
}
</script>


</body>
</html>