/**
 * INSTRUCTIONS - STEPS and their annotations
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
    //testIt();
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
// http://stackoverflow.com/questions/8324976/serializing-array-of-objects

    var annotation_id = $("#an-tools").attr("title");
    var recipe_id = $("#recipe_container").attr("title");
    var user = 0; //TODO get current username or userid
    var instructions = $('#preparation').children("li");

    // serializedInstructions is an array with JSON objects
    var serializedInstructions = getSerializedChildren(instructions);
    console.log(JSON.stringify(serializedInstructions));
    var dataInstructions = { "data": serializedInstructions };//JSON.stringify(serializedInstructions); // use JSON.parse(dataInstructions); to undo stringify
    var serializedIngredients = [{"type":100}];// TODO fill array


    if (serializedInstructions != null) {
        console.log("not null");
    }

    $.post('/saveAnnotations', {
        annotation_id: annotation_id,
        recipe_id : recipe_id,
        user_id : user,
        instructions : serializedInstructions,//jQuery.param(dataInstructions),
        ingredients : serializedIngredients//jQuery.param(dataIngredients)
    }).done(function(data){ // data is the response
        $("#an-tools").attr("title", data); // NOTE: this may not be the best solution, probably need to check first if data is a number
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
        if ((child.parentNode).isContentEditable){
            var jsonObj = { "type": 1, "txt": child.nodeValue };
            return jsonObj; // JSON object mit Type:2, text: child.nodeValue;
        }
        else { // it's a recipe text
            var jsonObj = { "type": 0, "len": child.nodeValue.length };
            return jsonObj;
        }
    } else if (child.nodeType == 1) { // check if Element node to be on safe side

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
            var jsonObj = { "type": 3, "children": serializedChildren };
            return jsonObj;

        } else if ($(child).hasClass("cb-timer")) { // it's a timer! THIS IS ALSO A RECURSION BASE
            var jsonObj = { "type": 4, "h": 0, "m": 5, "s": 0 }; // TODO: use actual values derived from nodeValue
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

function renderInstructions(original, annoted, parentNode) {

    //TODO: check if there are Annotations for the instructions

    // first retrieve the instructions array from Database
    var stepsOriginal = original; // TODO
    var stepsAnnoted = annoted; //TODO

    var orderedList = $('<ol />');
    parentNode.append(orderedList);


    if (stepsOriginal.length == stepsAnnoted.length) {
        for (var step = 0; step < stepsOriginal.length; ++step) {
            var liNode = $('<li />');
            orderedList.append(liNode);

            var originalPs = stepsOriginal[step];
            var annotedPs = stepsAnnoted[step].children;

            for (var p = 0; p < originalPs.length; ++p) { // go through paragraphs per step
                var pNode = $('<p />');
                liNode.append(pNode);

                var contentOriginal = originalPs[p];
                var contentAnnoted = annotedPs[p].children;
                var an_index = 0;

                for (var c = 0; c < contentOriginal.length; ++c) {
                    if (contentOriginal[c].type == 1) { // text

                        var oC_index = 0;
                        while (oC_index < contentOriginal[c].txt.length && an_index < contentAnnoted.length) {
                            oC_index = r_appendChild(pNode, contentAnnoted[an_index], oC_index, contentOriginal[c].txt);
                            ++an_index;
                        }

                    } else if (contentOriginal[c].type == 4) { // timer
                        while (r_appendChild(pNode, contentAnnoted[an_index++], true, contentOriginal[c])){/*empty on purpose*/}
                    }
                }

                while (an_index < contentAnnoted.length) { // don't forget contenteditable spans at the very end of a paragraph
                    oC_index = r_appendChild(pNode, contentAnnoted[an_index], 0, "");
                    ++an_index;
                }
            }
        }
    }
}

function r_appendChild(parentNode, child, index, content){
    var s = child.type;
    switch (s) {
        case 0: // recursion base
            console.log("recursion base");
            var text = content.substr(index, child.len);
            var textnode = document.createTextNode(text);
            parentNode.append(textnode);
            return (index + child.len);

        case 1: // recursion base
            var textnode = document.createTextNode(child.txt);
            parentNode.append(textnode);
            return index;

        case 2: // span with class, not contenteditable
            var span = $('<span />').addClass(child.class);
            var children = child.children;

            for (var i=0; i < children.length; ++i) {
                index = r_appendChild(span, children[i], index, content);
            }
            parentNode.append(span);
            return index;
        case 3: // span with attribute contenteditable
            var span = $('<span />').attr("contenteditable", "true");
            var children = child.children;

            for (var i=0; i < children.length; ++i) {
                index = r_appendChild(span, children[i], index, content);
            }
            parentNode.append(span);
            return index;
        case 4: // timer
            // alternatively: get timer values from content param
            var span = $('<span />').addClass("cb-timer").html(child.h + ":" + child.m + ":" + child.s);
            parentNode.append(span);
            return false;
        default:
            return index;
    }
}


function testIt(){
    var db = [[
        [{"type":1,"txt": "Bake cake in oven for 40 minutes "},{"type":4,"h":0,"m":5,"s":0},
            {"type":1,"txt":" at 180 degrees Celsius. The ingredients above reflect 3 Servings, but the instructions reflect the as-posted 4 Servings. You may need to adjust the times, temperatures or quantities mentioned in the recipe below as needed."}],
        [{"type":1, "txt":"This is another paragraph. Just for testing purposes. Nothing important to read here."}]],
        [[{"type":1,"txt":"Sift dry ingredients. Blend together egg yolks and yogurt, mix well; add to dry ingredients, add margarine and mix together lightly. Add blueberries. Fold in egg whites. Bake on hot griddle until golden on both sides."}]
    ]];

    var annoted = saveAnnotations();
    var div = $('<div />').attr("id", "copy");
    $('#preparation').append(div);

    renderInstructions(db, annoted, div);
}
