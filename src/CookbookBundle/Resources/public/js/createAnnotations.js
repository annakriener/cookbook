/**
 * INSTRUCTIONS - STEPS and their annotations
 */

var $hideText = "hide";
var $showText = "show";
$( document ).ready(function() {

    $('#crossout').on('click', function(){
        var cname = $(this).attr('class');
        $('#preparation').off('mouseup');
        $('#preparation').on('mouseup', formatTxt(cname));
    });

    $('#yellow').on('click', function(){
        var cname = $(this).attr('class');
        $('#preparation').off('mouseup');
        $('#preparation').on('mouseup', formatTxt(cname));
    });

    $('#cyan').on('click', function(){
        var cname = $(this).attr('class');
        $('#preparation').off('mouseup');
        $('#preparation').on('mouseup', formatTxt(cname));
    });

    $('#pink').on('click', function(){
        var cname = $(this).attr('class');
        $('#preparation').off('mouseup');
        $('#preparation').on('mouseup', formatTxt(cname));
    });

    $('#takenote').on('click', function(){

        $('#preparation').off('mouseup');
        $('#preparation').on('mouseup', takeNote);
    });
    $('#save').on('click', function(){
        saveAnnotations();
    });

    $('#rmAnnotations').on('click', function(){
        removeAnnotations();
    });


    $('#hide').on('click', function(){
        if ($('#hide').text() == $showText) {
            $('#hide').text($hideText);
            $(".cb-an-f-off").show();
        } else {
            hideCrossed();
        }
    });

});

function hideCrossed(){
    $('#hide').text($showText);
    $(".cb-an-f-off").not("button").hide();
}


// hightlighting of text
function formatTxt(fClassName) {
    var txt = '';
    var selObj;
    if (window.getSelection)
    {
        selObj = window.getSelection(); // selObj ... Selection Object (https://developer.mozilla.org/en-US/docs/Web/API/Selection)
        txt = selObj.toString();

        if (selObj.anchorNode == selObj.focusNode && txt.length > 0 && txt != " ") { // is selection in same node? is at least one character selected?

            var selNode = selObj.anchorNode;

            if (selNode.nodeType == 3) {
                var parent = selNode.parentNode;
                if ($(parent).hasClass("cb-timer")) {return;}
                // indices
                var offset = selObj.anchorOffset;
                var endStartIndex = offset + txt.length;

                if (isBackwardsSelection(selObj)) { // if text was selected
                    endStartIndex = offset;
                    offset = offset - txt.length;
                }

                // strings
                var originalString = selNode.nodeValue;
                var startString = originalString.substring(0, offset);
                var middleString = originalString.substr(offset, txt.length);
                var endString = originalString.substr(endStartIndex);

                // Deal with blanks at beginning or end of selection. Uncommented for textHighlight, comment when text color only changed
                /*                if (middleString[0] == " ") {
                 startString += " ";
                 middleString = middleString.substr(1);
                 }

                 if (middleString[middleString.length-1] == " ") {
                 endString = " " + endString;
                 middleString = middleString.substr(0, middleString.length-1);
                 }*/


                // Create new Children from startString, middleString and endString and prepend them to selNode!
                if (startString.length > 0){
                    var startChild = document.createTextNode(startString);
                    $(selNode).before(startChild);
                }

                middleString = "<span class=\"" + fClassName + "\">" + middleString + "</span>";
                $(selNode).before(middleString);

                if (endString.length > 0){
                    var endChild = document.createTextNode(endString);
                    $(selNode).before(endChild);
                }

                // remove selNode, we don't need it any more
                parent.removeChild(selNode);
                combineEqualElements(parent);
            }
        }
    }
}

function isBackwardsSelection(selectionObject) {
    position = selectionObject.anchorNode.compareDocumentPosition(selectionObject.focusNode);
    backward = false;

    if (!position && selectionObject.anchorOffset > selectionObject.focusOffset || position === Node.DOCUMENT_POSITION_PRECEDING) {
        backward = true;
    }
    return backward;
}

function removeIfEmpty(){
    if (this.innerHTML == "" || this.firstChild == undefined) {
        var parent = this.parentNode;
        parent.removeChild(this);
        parent.normalize(); // glues separated textNodes back together - awesome!
        return true;
    }
    return false;
}

function isEqualElement(nodeA, nodeB) {
    if (nodeA == undefined || nodeB == undefined) {
        return false;
    }
    if (nodeA.nodeType != nodeB.nodeType) {
        return false;
    }
    return nodeA.className == nodeB.className;
}

function combineEqualElements(parent){
    var children = parent.childNodes;
    var index = 1;
    var length = children.length;

    while (index < length) {
        if (isEqualElement(children[index-1], children[index])){
            mergeNodes(children[index-1], children[index]);
            length = children.length; // update length of NodeList
        } else {
            index++;
        }
    }
}

function mergeNodes(nodeA,nodeB) { // Note: use with care, does not check for undefined!!
    nodeA.innerHTML += nodeB.innerHTML;
    nodeA.parentNode.removeChild(nodeB);
}

// add notes to existing text
function takeNote() {
    var selObj;
    if (window.getSelection) {
        selObj = window.getSelection(); // selObj ... Selection Object (https://developer.mozilla.org/en-US/docs/Web/API/Selection)

        if (selObj.anchorNode == selObj.focusNode) { // is selection in same node? is at least one character selected?

            var selNode = selObj.anchorNode;

            var parent = selNode.parentNode;
            if ($(parent).hasClass("cb-timer")) {return;}
            var isNote = parent.getAttribute("contenteditable");
            // TODO: check here if somehow possible if there is a contenteditable span away by +/-1 offset? and then jump into this one?

            if (selNode.nodeType == 3 && !isNote) { // in javascript null == false, so that's ok
                if (isNote) { selNode.focus(); return; }
                var noteStartIndex = selObj.anchorOffset;
                var originalString = selNode.nodeValue;
                var startString = originalString.substring(0, noteStartIndex);

                var noteNode = $(document.createElement('span'));
                $(noteNode).attr("contenteditable","true");

                var endString = originalString.substr(noteStartIndex);

                $(selNode).before(startString, noteNode, endString);

                // remove selNode, we don't need it any more
                selNode.parentNode.removeChild(selNode);

                noteNode.on('blur', removeIfEmpty); // remove note node, if nothing was added
                noteNode.focus(); // focus on the editable span, so we can start writing right away
            }
        }
    }
};

// SAVE ANNOTATIONS into DB via AJAX
function saveAnnotations(){

    var annotation_id = $("#an-tools").attr("data-annotation-id");
    var recipe_id = $("#recipe_container").attr("data-recipe-id");
    var instructions = $('#preparation').children("li");
    var ingredients = $('#ingredients').children("li");

    // serializedInstructions is an array with JSON objects
    var serializedInstructions = getSerializedChildren(instructions);
    //console.log(JSON.stringify(serializedInstructions));

    var hideCrossed = !($('#hide').text() == $hideText);
    var serializedIngredients = getSerializedChildren(ingredients);

    $.post('/saveAnnotations', {
        annotation_id: annotation_id,
        recipe_id : recipe_id,
        instructions : serializedInstructions,
        ingredients : serializedIngredients,
        hideCrossed: hideCrossed
    }).done(function(data){ // data is the response
        $("#an-tools").attr("data-annotation-id", data); // NOTE: this may not be the best solution, probably need to check first if data is a number
    });
}

// REMOVE ANNOTATIONS from DB via AJAX
function removeAnnotations(){

    var annotation_id = $("#an-tools").attr("data-annotation-id");
    // var recipe_id = $("#recipe_container").attr("data-recipe-id");

    $.post('/removeAnnotations', {
        annotation_id: annotation_id
    }).done(function(){ // data is the response
        document.location.reload(true);
    });
}

function r_serializeChild(child) {
    /*
     * Node Types:
     * 0: indexNode, refers to part of original text, contains length of the part (startIndex = summation of lengths of preceding indexNodes)
     * 1: textNode, is a text written by user
     * 2: nestedNode, is a not contenteditable span with 1 or more child nodes that may have children themselves
     * 3: noteNode, is a contenteditable span with 1 or more child nodes that may have children themselves
     * 4: timerNode, is a not contenteditable span with a time value
     * 5: pNode, is a paragraph
     * 6: stepNode (li)
     * */

    if (child.nodeType == 3){ // RECURSION BASE ! ( check if its a textnode )
        if (!child.nodeValue.length) { return { type: -1}; }

        if ((child.parentNode).isContentEditable){
            var jsonObj = { "type": 1, "txt": child.nodeValue };
            return jsonObj; // JSON object mit Type:2, text: child.nodeValue;
        }
        else { // it's a recipe text
            var jsonObj = { "type": 0, "len": child.nodeValue.length };
            return jsonObj;
        }
    } else if (child.nodeType == 1) { // check if Element node to be on safe side


        if (!child.childNodes.length && !$(child).is("input")){
            return { type: -1};
        }

        if ($(child).is("p")) {
            var serializedChildren = getSerializedChildren(child.childNodes);
            var jsonObj = { "type": 5, "children": serializedChildren };
            return jsonObj;
        }

        else if ($(child).is("li")) {
            var serializedChildren = getSerializedChildren($(child).children("p"));
            var jsonObj = { "type": 6, "children": serializedChildren };
            return jsonObj;
        }

        else if ($(child).is("[contenteditable='true']")){
            var serializedChildren = getSerializedChildren(child.childNodes);
            var classname = $(child).attr('class');
            var servingsData = $(child).attr('data-an-servings');

            var amount = $(child).attr('data-an-amount');
            if (amount) {
                serializedChildren = [{ "type": 1, "txt": amount }];
            }

            var jsonObj = { "type": 3, "children": serializedChildren, "class": classname, "servings": servingsData };
            return jsonObj;

        } else if ($(child).hasClass("cb-timer")) { // it's a timer! THIS IS ALSO A RECURSION BASE
            var jsonObj = {"type": 4, "h": 0, "m": 5, "s": 0}; // TODO: use actual values derived from nodeValue
            return jsonObj;

        } else if ($(child).is("input")){
            var isChecked = child.checked;
            var jsonObj = {"type": 7, "check": isChecked};
            return jsonObj;

        } else {
            var serializedChildren = getSerializedChildren(child.childNodes);
            var classname = $(child).attr('class');
            var jsonObj = { "type": 2, "children": serializedChildren, "class": classname };
            return jsonObj;
        }
    }
}

function getSerializedChildren(children) {

    if (children == undefined || children == null) {
        return null;
    }
    var serializedChildren = [];

    // check if child itself has children - do this with a recursive function
    for(var j=0; j < children.length; ++j) {
        var serializedChild = r_serializeChild(children[j]);
        if (serializedChild != null || serializedChild != undefined)
            serializedChildren.push(serializedChild);
    }

    return serializedChildren;
}