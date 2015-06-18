// RENDER ANNOTATIONS

function renderInstructions(original, annoted, hide) {
    var parentNode = $('#preparation');
    // first retrieve the instructions arrays from Database
    var stepsOriginal = original.data; // TODO
    var stepsAnnoted = annoted.data; //TODO

    if (stepsOriginal.length == stepsAnnoted.length) {
        for (var step = 0; step < stepsOriginal.length; ++step) {
            var liNode = $('<li />');
            parentNode.append(liNode);

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

                while (contentAnnoted != undefined && an_index < contentAnnoted.length) { // don't forget contenteditable spans at the very end of a paragraph
                    oC_index = r_appendChild(pNode, contentAnnoted[an_index], 0, "");
                    ++an_index;
                }
            }
        }
    }

    if (hide) {
        hideCrossed();
    }
}

function r_appendChild(parentNode, child, index, content){
    var s = parseInt(child.type);
    switch (s) {
        case 0: // recursion base
            var len = parseInt(child.len); // necessary since encoding the JSON objects turns integers to strings
            var text = content.substr(index, len);
            var textnode = document.createTextNode(text);
            parentNode.append(textnode);
            return (index + len);

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
        case 7: //checkbox
            var checkbox = $('<input />').attr("type", "checkbox").addClass("cb-ingr-checkbox");
            if (child.check != "0") {
                $(checkbox).prop("checked", true);
            }
            parentNode.append(checkbox);
        default:
            return index;
    }
}


function renderIngredients(annoted) {

    var originalChildren = $('#ingredients').children("li");
    var ingrAnnoted = annoted.data;

    var li=0;
    for (; li < ingrAnnoted.length; ++li) { // use ingrAnnoted because there might be additional ingredients // TODO: make safe
        var originalP = $(originalChildren[li]).children("p")[0];
        var annotedP = ingrAnnoted[li].children[0];

        var contentOriginal = originalP.childNodes;
        var contentAnnoted = annotedP.children;
        var an_index = 0;

// 1. checkbox node
        if (contentAnnoted[0].check == "true") {
            contentOriginal[0].checked = true;
        }
// 2. amount span
        if (contentAnnoted[1].children[0].type == "3") {
            var valueAmount = contentAnnoted[1].children[0].children[0].txt;
            contentOriginal[1].childNodes[0].innerHTML = valueAmount;
            $(contentOriginal[1].childNodes[0]).attr("contenteditable", "true");

            if (contentAnnoted[1].children[0].servings){
                $(contentOriginal[1].childNodes[0]).attr("data-an-servings", contentAnnoted[1].children[0].servings);
                $(contentOriginal[1].childNodes[0]).attr("data-an-amount", parseFloat(valueAmount));
            }
        }

// 3. ingredienttext (textnode)
        var originalTxt = contentOriginal[1].childNodes[1].nodeValue;

        if (contentAnnoted[1].children[1].type == "0" && parseInt(contentAnnoted[1].children[1].len) == originalTxt.length) {/*no annotations*/}
        else {

            var an_index = 1;
            var oC_index = 0;
            while (oC_index < originalTxt.length && an_index < contentAnnoted[1].children.length) {
                oC_index = r_appendChild($(contentOriginal[1]), contentAnnoted[1].children[an_index], oC_index, originalTxt);
                ++an_index;
            }
            $(contentOriginal[1].childNodes[1]).remove(); // remove the original textnode (without annotations)
        }
    }
}