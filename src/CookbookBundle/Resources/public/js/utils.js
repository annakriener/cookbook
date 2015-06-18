function getTextContent(elementNode){ // innerText is not supported by Firefox (uses textContent instead)
    var hasInnerText = (elementNode.innerText != undefined) ? true : false;

    if(!hasInnerText){ return elementNode.textContent; }
    else { return elementNode.innerText; }
}

function isNumber(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}

function beautifyNumber(number) {

    if (number < 1.0) { // leave small numbers as they are
        return number;
    }
    else if (number < 10.0) { // round to number in 0.5 steps
        number = roundByFive(number*10);
        return (parseFloat(number))*0.1;
    }
    else if (number < 100.0) { // round to integer
        return Math.round(number);
    } else {
        return roundByFive(number); // use 5.0 steps for large values
    }
}

function roundByFive (n) {
    var rest = n%10;
    if (rest < 3.0) {
        n = n- rest;
    } else if (rest < 8.0) {
        n = n + (5 - rest);

    } else {
        n  = n + (10 - rest);
    }
    return parseInt(n);
}
