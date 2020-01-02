var moneys = [
    5000, 1000, 500, 100, 50, 10, 5, 1,
];
var bankNotesR = [
    'money5000r', 'money1000r', 'money500r', 'money100r', 'money50r', 'money10r', 'money5r', 'money1r',
];

var bankNotes = [
    'money5000', 'money1000', 'money500', 'money100', 'money50', 'money10', 'money5', 'money1',
];



function divCeloe(val1, val2) {
    var result = val1 / val2;
    result = result - (result % 1);
    return result;
}


function getBanknotesBySumm(money) {
    var result = [];
    var temp = money;
    for (var key in moneys) {
        if (temp == 0) {
            break;
        }
        /*if (moneys[key] == 1) {
            result.push(1);
            break;
        }*/
        var bankNoteCount = divCeloe(temp, moneys[key]);
        temp -= bankNoteCount * moneys[key];
        result.push(bankNoteCount);
    }
    return result;
}

function getBanknotesClasses (money) {
    var array = getBanknotesBySumm(money);
    var result = [];
    for (var key in array) {
        var amountBanknotes = array[key];
        for (var i = 0; i < amountBanknotes; ++i) {
            result.push(bankNotes[key]);
        }
    }
    return result;
}

function playSound(name) {
    var audio = new Audio();
    audio.src = getResDir()+"sounds/"+name;
    audio.autoplay = true;
}

function changebalance(delta) {
    $(window).trigger("changebalance",[delta]);
}