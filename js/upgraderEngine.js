var upgraderEngine = null;
function initUpgrader() {
    window.dispatchEvent(new Event('changebalance'));
    var inputBet = $('#upgraderInput');
    if (upgraderEngine == null) {
        upgraderEngine = new UpgraderEngine();
    }
    function selectElement(element) {
        $('li .setKoeff').each(function(i,elem) {
            $(elem).removeClass( "selected" );
        });
        upgraderEngine.selectedType = $(element).attr('data-name');
        var rowType = fGameTable[upgraderEngine.selectedType];
        $('#winChance').text(rowType.chanceText);
        $(element).addClass( "selected" );
    };
    $('.setKoeff').click(function(){
        selectElement(this);
    });

    $('#upgraderButton').click(function () {
        var amount = parseInt(inputBet.val()) * 100;//toDub
        inputBet.val('');
        if (upgraderEngine.isReady && amount >= 1000) {
            upgraderEngine.tryUpgrade(amount, parseInt(upgraderEngine.selectedType));
        }
    })
}

function onUpgraderLoad(upgaderInfo,username){
    initUpgrader();

    upgraderEngine.liveBets = upgaderInfo.live;
    upgraderEngine.myBets = upgaderInfo.user_history;
    if (username) {
        upgraderEngine.username = username;
    }
    upgraderEngine.trigger('connected');
}

var maxLiveElements = 3;
var maxBetsElements = 12;

var fGameTable = {
    1: {chance: 64, koeff: 150, chanceText: 'ОЧЕНЬ ВЫСОКИЙ',},
    2: {chance: 44, koeff: 200, chanceText: 'ВЫСОКИЙ',},
    3: {chance: 18, koeff: 500, chanceText: 'СРЕДНИЙ',},
    4: {chance: 9, koeff: 1000, chanceText: 'НИЗКИЙ',},
    5: {chance: 5, koeff: 2000, chanceText: 'ТЫ ТОЧНО ЭТОГО ХОЧЕШЬ?',},
}

function getRowByChance(winChance) {
    for (var key in fGameTable){
        if (fGameTable[key].chance == winChance)
            return fGameTable[key];
    }
}

function UpgraderEngine() {
    var self = this;
    //var connectUrl = window.document.location.host + ':' + constants.PORT;

    //system
    self.ws = getConnectWs();
    self.isConnected = false;
    self.username = null;
    self.selectedType = 1;
    self.liveBets = null;
    self.myBets = null;
    self.isReady = true;

/*
    self.ws.on('connect', function () {

        requestOtt(function (err, ott) {
            if (err) {
                /!* If the error is 401 means the user is not logged in
                 * Todo: This will be fixed in the near future
                 *!/
                if (err != 401) {
                    console.error('request ott error:', err);
                    if (confirm("An error, click to reload the page: " + err))
                        location.reload();
                    return;
                }
            }

            self.ws.emit('join', {ott: ott},
                function (err, resp) {
                    if (err) {
                        console.error('Error when joining the game...', err);
                        return;
                    }
                    self.liveBets = resp.upgrader.live;
                    self.myBets = resp.upgrader.user_history;
                    if (resp.username) {
                        self.username = resp.username;
                    }
                    self.trigger('connected');
                }
            );
        });
    });
*/


    self.ws.on('onTryUpgrade', function (data) {
        self.trigger('onTryUpgrade', data);
    });
}

UpgraderEngine.prototype.tryUpgrade = function (amount, upgradeType) {
    var self = this;
    self.ws.emit('upgrade', {amount: amount, upgradeType: upgradeType}, function (err) {
        if (err) {
            console.warn('place_bet error: ', err);
            return;
        }
    });
}


UpgraderEngine.prototype.trigger = function (event, data) {
    switch (event) {
        case 'connected':
            updateAllInfoUpgrader(this);
            break;
        case 'onTryUpgrade':
            tryUpgradeHandler(data, this);
    }
}

function tryUpgradeHandler(betInfo, engine) {
    if (engine.username != betInfo.username) {
        if (betInfo.result == true) {
            addNewRow(betInfo, false);
        }
        return;
    }
    changebalance(-betInfo.bet);
    $('#babBet').html(getMoneyStack(betInfo.bet/100));
    setGameState(false, engine);
    playSound('loading.mp3');
    var magicTime = 3000;
    var afterMagicTime = 2000;
    magicStick(magicTime, betInfo.result,function () {
        addNewRow(betInfo,true);
        $('#babWin').html(getMoneyStack(betInfo.win/100));
        if (betInfo.result){
            playSound('won.mp3');
            addNewRow(betInfo,false);
        }else{
            playSound('lose.mp3');
        }
        changebalance(betInfo.win);
        setTimeout(function () {
            setGameState(true, engine);
        },afterMagicTime);
    });
}

function getMoneyStack(money) {
    var top = 60;
    var left = 0;
    var babItems = [];
    var outBanknotes = 5;

    var bankNotes = getBanknotesClasses(parseFloat(money).toFixed(0));
    if (money == 0){
        bankNotes = [];
    }
    var i = 1;
    for (var key in bankNotes) {
        //babItems.push(D.div({className:'money-mob '+ bankNotes[key] + 'b', style: {top: top + 'px', left: left + 'px'}}));
        babItems.push('<div class="'+bankNotes[key]+'b" style="top:'+top+'px;left:'+left+'px;"></div>');
        left += 10;
        top -= 15;
        if (i == outBanknotes) {
            break;
        }
        ++i;
    }
    babItems.reverse();
    return babItems;
}

function addNewRow(betInfo, isBetRow) {
    if (isBetRow) {
        $('#upgraderMyBets').prepend(getOneBetRow(betInfo));
        if ($('#upgraderMyBets').children().length > maxBetsElements){
            $('#upgraderMyBets').children().last().remove();
        }
    } else {
        $('#upgraderLive').prepend(getOneLiveRow(betInfo));
        if ($('#upgraderLive').children().length > maxLiveElements){
            $('#upgraderLive').children().last().remove();
        }
    }
    scrollUpgrader();
}

function magicStick(time, result,callback) {
    function doIt(time, callback) {
        var flag = false;
        $("#magicStick").attr("class", "badMagicStick");
        $("#magicStick").attr("class", "badMagicStick");
        var shiningLoop = setInterval(function () {
            $("#magicStick").attr("class", flag ? "badMagicStick" : "goodMagicStick");
            flag = !flag;
        }, 72);
        setTimeout(function () {
            clearInterval(shiningLoop);
            callback();
        },time);
    }

    doIt(time, function () {
        $("#magicStick").attr("class", result ? "goodMagicStick" : "badMagicStick");
        callback();
    });
}

function setGameState(isReady, engine) {
    engine.isReady = isReady;
    $("#magicStick").attr("class", "commonMagicStick");
    if (isReady) {
        $('#babBet').html('');
        $('#babWin').html('');
        $('#upgraderButton').show();
        $('#upgraderInput').show();
    } else {
        $('#upgraderButton').hide();
        $('#upgraderInput').hide();
    }
}

function updateAllInfoUpgrader(engine) {
    $('#upgraderMyBets').html('');
    $('#upgraderLive').html('');

    function updateLive(liveBets) {
        var i = 0;
        liveBets.forEach(function (element) {
            if (element.result) {
                if (i >= maxLiveElements)
                    return;
                $('#upgraderLive').append(getOneLiveRow(element));
                ++i;
            }
        });
    }

    function updateMyBets(myBets) {
        var i = 0;
        myBets.forEach(function (element) {
            if (i >= maxBetsElements)
                return;
            $('#upgraderMyBets').append(getOneBetRow(element));
            ++i;
        })
    }

    updateLive(engine.liveBets);
    updateMyBets(engine.myBets);
}


function getOneLiveRow(betInfo) {
    var result = '';
    result += '<div class="bubalex">';
    result += '<div class="bbll1t" align="center">';
    result += '<div class="nikogo">';
    result += '<div class="logonik"><img src="" alt=""/></div>';
    result += '<div class="niklogo">' + betInfo.username + '</div>';
    result += '</div>';
    result += '<div style="clear:both;"></div>';

    result += '<div class="denr">';
    result += getLiveMoneyBlock(betInfo.bet / 100, true);
    result += '</div>';

    result += '<div class="bott"></div>';

    result += '<div class="denrbot">';
    result += getLiveMoneyBlock(betInfo.win / 100, false);
    result += '</div>';

    result += '<div style="clear:both;"></div>';
    result += '<div class="ulr">Шанс: ' + getRowByChance(betInfo.chance).chanceText + '</div>';
    result += '</div>';
    result += '</div>';
    return result;
}

function getOneBetRow(betInfo) {
    function getWinRow(betInfo) {
        var result = '';
        result += '<div class="loggg">';

        result += '<div class="ava5">';
        result += '<img src="' + getResDir() + 'img/pal2.png" alt=""/>';
        result += '</div>';
        result += '<div class="textava">';
        result += '<div class="textava13">Вы смогли улучшить <b>' + betInfo.bet / 100 + ' DUB до ' + betInfo.win / 100 + ' DUB</b></div>';
        result += '<div class="textava23">Шанс: ' + getRowByChance(betInfo.chance).chanceText + '</div>';
        result += '</div>';

        result += '<div class="den2new" align="right">';
        result += getMyMoneyBlock(betInfo.win / 100);

        result += '</div>';
        result += '<div style="clear:both;"></div>';
        result += '</div>';
        return result;
    }

    function getLoseRow(betInfo) {
        var result = '';
        result += '<div class="loggg1">';

        result += '<div class="ava5">';
        result += '<img src="' + getResDir() + 'img/pal1.png" alt=""/>';
        result += '</div>';
        result += '<div class="textava">';
        result += '<div class="textava13">Вы не смогли улучшить <b>' + betInfo.bet / 100 + ' DUB</b></div>';
        result += '<div class="textava23">Шанс: ' + getRowByChance(betInfo.chance).chanceText + '</div>';
        result += '</div>';

        result += '<div class="den2new" align="right">';

        result += '<div class="noboom"><img src="' + getResDir() + 'img/noboom.png" alt=""/></div>';

        result += '</div>';
        result += '<div style="clear:both;"></div>';
        result += '</div>';
        return result;
    }

    if (betInfo.result == false) {
        return getLoseRow(betInfo);
    } else {
        return getWinRow(betInfo);
    }
}

function getMyMoneyBlock(amount) {
    var result = '';

    function deleteMn(note) {
        return note.replace(/^money/, '');
    }

    var styles = [
        'top:0px;right:20px;',
        'top:0px;right:10px;',
        'top:0px;right:0px',
    ]
    var result = '';
    var notes = getBanknotesClasses(parseInt(amount));
    var i = 0;
    for (var key in notes) {
        if (i > 2)
            break;
        result = '<div class="' + notes[key] + 'bAd"><img style="' + styles[i] + '"src="' + getResDir() + 'img/' + deleteMn(notes[key]) + 'b.png" alt=""></img></div>' + result;
        i++;
    }
    return result;
}

function getLiveMoneyBlock(amount, isBet) {
    var result = '';
    var styles = [
        'top:0px;right:30px;',
        'top:0px;right:15px;',
        'top:0px;right:0px;',
    ]
    var notes = getBanknotesClasses(parseInt(amount));
    var i = 0;
    if (isBet) {
        for (var key in notes) {
            if (i == 0) {
                result += '<div class="' + notes[key] + 'r" style="' + styles[i] + '">';
                result += '<div class="denc2t"><span>' + amount + ' DUB</span></div></div>';
                i++;
                continue;
            }
            if (i > 2)
                break;
            result = '<div class="' + notes[key] + 'r" style="' + styles[i] + '"></div>' + result;
            i++;
        }
    } else {
        for (var key in notes) {
            if (i == 0) {
                result += '<div class="' + notes[key] + 'r" style="' + styles[i] + '">';
                result += '<div class="denc2tblue"><span>' + amount + ' DUB</span></div></div>';
                i++;
                continue;
            }
            if (i > 2)
                break;
            result = '<div class="' + notes[key] + 'r" style="' + styles[i] + '"></div>' + result;
            i++;
        }
    }
    return result;
}


/*$(window).load(function () {
    window.dispatchEvent(new Event('changebalance'));
    var inputBet = $('#upgraderInput');
    var engine = new UpgraderEngine();
    upgraderEngine = engine;
    function selectElement(element) {
        $('li .setKoeff').each(function(i,elem) {
            $(elem).removeClass( "selected" );
        });
        engine.selectedType = $(element).attr('data-name');
        var rowType = fGameTable[engine.selectedType];
        $('#winChance').text(rowType.chanceText);
        $(element).addClass( "selected" );
    };
    $('.setKoeff').click(function(){
        selectElement(this);
    });

    $('#upgraderButton').click(function () {
        var amount = parseInt(inputBet.val()) * 100;//toDub
        inputBet.val('');
        if (engine.isReady && amount >= 1000) {
            engine.tryUpgrade(amount, parseInt(engine.selectedType));
        }
    })
});*/

function getRandomArbitary(min, max) {
    return Math.random() * (max - min) + min;
}

