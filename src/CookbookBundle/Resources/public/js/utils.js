function getTextContent(elementNode){ // innerText is not supported by Firefox (uses textContent instead)
    var hasInnerText = (elementNode.innerText != undefined) ? true : false;

    if(!hasInnerText){ return elementNode.textContent; }
    else { return elementNode.innerText; }
}