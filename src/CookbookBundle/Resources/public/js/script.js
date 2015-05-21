/**
 *
 */
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


$('#hide').on('click', function(){
    if ($('#hide').text() == "show") {
        $('#hide').text("hide");
        $(".cb-an-f-off").show();
    } else {
        $('#hide').text("show");
        $(".cb-an-f-off").not("button").hide();
    }
});

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
    else if (document.getSelection)
    {
        txt = document.getSelection();
    }
    else if (document.selection)
    {
        txt = document.selection.createRange().text;
    }
    else return;
    document.aform.selectedtext.value =  txt;
};

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

function saveAnnotations(){

    // 1. save contenteditable notes
    // 2. save formattings (highlight, crossed, underlined,..)

    // per step? per instructions? jetzt erstmal testweise den preparation div als gesamtes in JSON übersetzen.
    var paragraphs = $('#preparation').children("p");
    //$(children).css("background-color", "blue"); // nur testweise - funktionniert genau wie gewollt, juhu!

    var serializedParagraphs = [];
    for(var i=0; i < paragraphs.length; ++i){
        var sP = getSerializedChildren(paragraphs[i]);
        serializedParagraphs.push(sP);
    }
    // TODO: save in JSON object

}

function r_serializeChild(child) {

    console.log("node type: " + child.nodeType + " node name: " + child.nodeName);


    /*
    * Node Types:
    * 0: indexNode, refers to part of original text, contains length of the part (startIndex = summation of lengths of preceding indexNodes)
    * 1: textNode, is a text written by user
    * 2: nestedNode, is a not contenteditable span with 1 or more child nodes that may have children themselves
    * 3: noteNode, is a contenteditable span with 1 or more child nodes that may have children themselves
    * 4: timerNode, is a not contenteditable span with a time value
    * */


    if (child.nodeType == 3){ // RECURSION BASE ! ( check if its a textnode )
        if ($(child.parentNode).is("[contenteditable='true']")) {
            var jsonObj = { "type": 1, "txt": child.nodeValue };
            return jsonObj; // JSON object mit Type:2, text: child.nodeValue;
        }
        else { // it's a recipe text
            var jsonObj = { "type": 0, "length": child.nodeValue.length };
            return jsonObj;
        }
    } else if (child.nodeType == 1) { // check if Element node to be on safe side

        if(child.hasAttribute("contenteditable")) { // contenteditable span


            var serializedChildren = getSerializedChildren(child);
            var jsonObj = { "type": 3, "children": serializedChildren };
            return jsonObj;

        } else if ($(child).hasClass("cb-timer")) { // it's a timer!

            var jsonObj = { "type": 4, "h": 0, "m": 5, "s": 0 }; // TODO: use actual values derived from nodeValue
            return jsonObj;

        } else {
            var serializedChildren = getSerializedChildren(child);
            var classname = $(child).attr('class');
            var jsonObj = { "type": 2, "children": serializedChildren, "class": classname };
            return jsonObj;

        }
    }
}

function getSerializedChildren(parent) {

    var serializedChildren = [];

    var children = parent.childNodes;
    // check if child itself has children - do this with a recursive function
    for(var j=0; j < children.length; ++j) {
        var serializedChild = r_serializeChild(children[j]);
        if (serializedChild != null || serializedChild != undefined)
            serializedChildren.push(serializedChild);
    }

    return serializedChildren;
}
