/**
 * Created by Tuan on 03/06/2015.
 */
var e;
var number = {
    numberFormatNew : function( number ,textId , cursor_position ,vMax ,vMin, decimals, dec_point, thousands_sep){
        //cursor_position : cho phép xác định vị trí con trỏ chuột , 0 : ko cần định vị , 1 : định vị
        var cursor =(typeof cursor_position == "undefined") ? 0 : cursor_position;
        var n = number, prec = decimals;
        var max = (typeof vMax == "undefined") ? 1000000000 : vMax;
        var min = (typeof vMin == "undefined") ? 0 : vMin;
        n = !isFinite(+n) ? 0 : +n;
        if(n > max)
            n = max;
        if(n < min)
            n = min;
        prec = !isFinite(+prec) ? 0 : Math.abs(prec);
        var sep = (typeof thousands_sep == "undefined") ? '.' : thousands_sep;
        var dec = (typeof dec_point == "undefined") ? ',' : dec_point;
        var s = (prec > 0) ? n.toFixed(prec) : Math.round(n).toFixed(prec); //fix for IE parseFloat(0.55).toFixed(0) = 0;
        var abs = Math.abs(n).toFixed(prec);
        if(cursor == 1){
            var no = doGetCaretPosition(document.getElementById(textId));
            var _, i;
            if(abs >=1000){
                _ = abs.split(/\D/);
                i = _[0].length % 3 || 3;
                if(i == 1){
                    jQuery("#"+textId).keydown(function(event){
                        e = eventByKey(event);
                    });
                    //37,39 control left ,right
                    if(e != 37 && e != 39){
                        no += 1;
                    }
                }
            }
        }
        var s = numberFormat( abs, s , dec, sep , n );
        if(s != 0)
        jQuery("#"+textId).val(s);
        else
        jQuery("#"+textId).val('');
        if(cursor == 1)
            setCaretPosition(document.getElementById(textId),no);
    }
};

function numberFormat( abs, s ,dec , sep ,n){
    var _, i;
    if (abs >= 1000) {
        _ = abs.split(/\D/);
        i = _[0].length % 3 || 3;
        _[0] = s.slice(0,i + (n < 0)) +
        _[0].slice(i).replace(/(\d{3})/g, sep+'$1');
        s = _.join(dec);
    } else {
        s = s.replace(',', dec);
    }

    return s;
}



function formatNumber(number)
{
    var number = number.toFixed(0) + '';
    var x = number.split('.');
    var x1 = x[0];
    var x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + '.' + '$2');
    }
    return x1 + x2;
}



function doGetCaretPosition (ctrl) {
    var CaretPos = 0;
    // IE Support
    if (document.selection) {

        ctrl.focus ();
        var Sel = document.selection.createRange ();

        Sel.moveStart ('character', -ctrl.value.length);

        CaretPos = Sel.text.length;
    }
    // Firefox support
    else if (ctrl.selectionStart || ctrl.selectionStart == '0')
        CaretPos = ctrl.selectionStart;

    return (CaretPos);

}


function setCaretPosition(ctrl, pos)
{

    if(ctrl.setSelectionRange)
    {
        ctrl.focus();
        ctrl.setSelectionRange(pos,pos);
    }
    else if (ctrl.createTextRange) {
        var range = ctrl.createTextRange();
        range.collapse(true);
        range.moveEnd('character', pos);
        range.moveStart('character', pos);
        range.select();
    }
}

function eventByKey(e){
    var keyNumber = (e.keycode) ? e.keycode : e.which;
    return keyNumber;
}