/**
 *
 */
$('#highlight').on('click', function(){
    console.log("highlight funktion assigned");
    $('#preparation').off('mouseup');
    $('#preparation').on('mouseup', highlightTxt);
});

$('#takenote').on('click', function(){
    console.log("takenote funktion assigned");
    $('#preparation').off('mouseup');
    $('#preparation').on('mouseup', takeNote);
});

// hightlighting of text
function highlightTxt() {
    var txt = '';
    var selObj;
    if (window.getSelection)
    {
        selObj = window.getSelection(); // selObj ... Selection Object (https://developer.mozilla.org/en-US/docs/Web/API/Selection)
        txt = selObj.toString();

        if (selObj.anchorNode == selObj.focusNode && txt.length > 0 && txt != " ") { // is selection in same node? is at least one character selected?

            var selNode = selObj.anchorNode;

            if (selNode.nodeType == 3) {

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

                middleString = "<span class=\"cb-an-f-highlight\">" + middleString + "</span>";
                $(selNode).before(middleString);

                if (endString.length > 0){
                    var endChild = document.createTextNode(endString);
                    $(selNode).before(endChild);
                }

                // remove selNode, we don't need it any more
                var parent = selNode.parentNode;
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

function removeFormatting(){
    // 1. check range
}

function saveAnnotations(){
    // 1. save contenteditable notes
    // 2. save formattings (highlight, crossed, underlined,..)

}
