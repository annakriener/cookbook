// RENDER ANNOTATIONS

function renderInstructions(original, annoted, hide) {

    var parentNode = $('#preparation');
    // first retrieve the instructions array from Database
    var stepsOriginal = original.data; // TODO
    var stepsAnnoted = annoted.data; //TODO

    var orderedList = $('#preparation');

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
            console.log("recursion base");
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
        default:
            return index;
    }
}

