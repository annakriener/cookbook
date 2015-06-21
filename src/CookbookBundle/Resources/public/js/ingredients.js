/**
 * INGREDIENTS - and their annotations
 */
var $original_servingsize;

$( document ).ready(function() {

    $original_servingsize = $("#servings").attr("data-orig-servings");

    // handle user changes in ingredient amounts
    $('span.cb-ingr-amount').on('mousedown', function(){
        $(this).on('mouseup', function(){
            $(this).attr("contenteditable","true");
            $(this).focus();
            $(this).on('blur', checkIfChanged);
        });
    });

    // handle user changes in serving size !
    $("#servings").on('change', function(){

        var current = $("#servings").val();

        if (!isNumber(current) || parseFloat(current) < 1.0){
            current = $original_servingsize;
            $("#servings").val($original_servingsize);
        }

        var currentAmounts = $('span.cb-ingr-amount'); // list of the ingredients (their amounts)

        for (var i=0; i < currentAmounts.length; ++i){
            // first define values for computation for default case (no changes)
            var initalServings = $original_servingsize;
            var amount = $(currentAmounts[i]).attr("data-orig-amount");

            // deal with changes made by user, if there are any
            if ($(currentAmounts[i]).is("[contenteditable='true']")){ // if amount was changed, use the amount that was typed in by user
                amount = $(currentAmounts[i]).attr("data-an-amount");
                if ($(currentAmounts[i]).attr("data-an-servings")){ // if the amount was changed with non-default servingsize, use servingsize at time user changed amount
                    initalServings = $(currentAmounts[i]).attr("data-an-servings");
                }
            }
            // compute and assign the new amount that shall be displayed
            if (isNumber(amount)){
                currentAmounts[i].innerHTML = computeNewAmount(amount, current, initalServings);
            }        }
    });
});

function computeNewAmount(amount, currentServings, originalServings){
    var newAmount = parseFloat(amount)*parseFloat(currentServings);
    newAmount = newAmount/parseFloat(originalServings);

    return beautifyNumber(parseFloat(newAmount.toFixed(2)));
}


function checkIfChanged() {
    var text = getTextContent(this);
    var origAmount = $(this).attr("data-orig-amount");

    if (origAmount == text || !isNumber(text)) { // unset contenteditable if amount has not changed or is not numeric
        resetOriginal(this, origAmount);
    } else {
        this.innerHTML = parseFloat(text);
        var currentServings = $("#servings").val(); // remember the currentServing size to do conversions correctly
        $(this).attr("data-an-amount", parseFloat(text));
        if (currentServings != $original_servingsize) {
            $(this).attr("data-an-servings", currentServings);
        }
    }
}

function resetOriginal(amountNode, origAmount){
    amountNode.innerHTML = origAmount;
    $(amountNode).attr("contenteditable", "false");
    $(amountNode).removeAttr( "data-an-amount" );
    $(amountNode).removeAttr( "data-an-servings" );
}