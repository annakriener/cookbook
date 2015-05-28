/**
 * INGREDIENTS - and their annotations
 */

// AMOUNT
$('span.cb-ingr-amount').on('mousedown', function(){
    if (!$(this).is("[contenteditable='true']")){
        // remember the original amount
        var amount = getTextContent(this);
        $(this).on('mouseup', function(){
            $(this).attr("contenteditable","true");
            $(this).focus();
            $(this).on('blur', {arg1: amount}, checkIfChanged);
        });
    }
});

function checkIfChanged(e) {
    var text = getTextContent(this);
    if (e.data.arg1 == text) { // unset contenteditable if amount has not changed
        $(this).attr("contenteditable","false");
    } else if (!isNumber(text)) {
        this.innerHTML = e.data.arg1;
        $(this).attr("contenteditable","false");
    } else {
        this.innerHTML = parseFloat(text);
    }
}

function isNumber(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}