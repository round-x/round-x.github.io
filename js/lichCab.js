var version = 0;
$(function() {
    $('#changePasswordButton').click(function() {
        var formData = $('#changePasswordForm').serialize();
        $.ajax({
            url: "/changePassword",
            method: 'post',
            data: formData,
            success: function(data) {
                $('#changePasswordMessage').text(data.message);
            }
        });
    });
    $('#vkl3').click(function() {
        $.ajax({
            url: "/freeBieInfo",
            success: function(data) {
                var json = data;
                var data = JSON.parse(data);
                $('#freeBieLevel').html(data.currentLevel);
                $('#freeBieExp').html(data.currentDeposit + '/' + data.nextLevelDeposit);
                $('#freeBieBonus').html(data.currentBonus);
                $('#cabLvl').html(data.currentLevel);
            }
        });
    });
    //Referals
    $('#vkl2').click(function() {
        $.ajax({
            url: "/getReferalsInfo",
            success: function(data) {
                var json = data;
                var data = JSON.parse(data);
                if (data.success == true) {
                    $('#referalsCount').html(data.referalsCount);
                    $('#referalsProfit').html(data.earnedByReferals / 100);
                }
            }
        });
    })
    $('#getFreeBie').click(function() {
        $.ajax({
            url: "/freeBie",
            success: function(data) {
                var json = data;
                var data = JSON.parse(data);
                //var className = data.success ? 'goodKoef' : 'badKoef';
                //$('#message-output').attr('class', className);
                $('#message-output').html(data.message);
                $('#balance').html(data.balance);
            }
        })
    });
    $('#loadAvatarButton').click(function() {
        $('#loadAvatar').click();
    });
    $('#loadAvatar').on('change', function() {
        var file = document.getElementById('loadAvatar').files[0]; //$('#loadAvatar')[0];//.files[0];
        var data = new FormData();
        data.append('file', file);
        axios.post('/uploadAvatar', data).then(function(response) {
            var data = response.data;
            $('#avatarMessage').text('');
            if (data.result == false) {
                $('#avatarMessage').text(data.message);
            } else {
                version++;
                $('#myAvatar').attr('src', '/' + data.file + '?ver=' + version);
            }
            document.getElementById('loadAvatar').files = [];
        }).catch(function(error) {
            console.log(error);
        });
    });
    var minOutput = 150;
    var maxOutput = 15000;
    $('#outputLeftPlus').click(function() {
        var currentVal = parseInt($('#outAmount').val());
        if (currentVal > minOutput) {
            currentVal--;
            $('#outAmount').val(currentVal);
        }
    });
    $('#outputRightPlus').click(function() {
        var currentVal = parseInt($('#outAmount').val());
        if (currentVal < maxOutput) {
            currentVal++;
            $('#outAmount').val(currentVal);
        }
    });
    var minInput = 10;
    var maxInput = 15000;
    $('#inputLeftPlus').click(function() {
        var currentVal = parseInt($('#inAmount').val());
        if (currentVal > minInput) {
            currentVal--;
            $('#inAmount').val(currentVal);
        }
    });
    $('#inputRightPlus').click(function() {
        var currentVal = parseInt($('#inAmount').val());
        if (currentVal < maxInput) {
            currentVal++;
            $('#inAmount').val(currentVal);
        }
    });
    setOutPutType('qiwiRu');
});

function setOutPutType(type) {
    function resetActiveRows() {
        $('#qiwiRu').removeAttr('class');
    }
    resetActiveRows();
    switch (type) {
        case "qiwiRu":
            $('#qiwiRu').attr('class', 'modalActiveRow');
            $('#typeOutputContainer').val('qiwi');
            $('#dest').mask("+7(999) 999-99-99");
            break;
    }
}

function outputMoney() {
    $.ajax({
        type: 'POST',
        url: '/outputMoney',
        data: {
            money: $('#outAmount').val(),
            num: $('#dest').val(),
            pass: $('#passw').val(),
        },
        success: function(data) {
            var obj = jQuery.parseJSON(data);
            if (obj.success == "success") {
                $('#messgaout').html(obj.mess);
                $('#balance').html(obj.balance);
                var outSumms = '<div class="dopdub">' + $('#outAmount').val() + ' DUB</div>';
                var outDests = '<div class="doprek">' + $('#dest').val() + '</div>';
                var outTimes = '<div class="dopdata">' + obj.time + '</div>';
                var outStatuses = '<div class="dopsta">В пути 24ч</div>';
                $('#outNum').html($('#outNum').html() + '<div class="dopdub">***</div>');
                $('#outSumm').html($('#outSumm').html() + outSumms);
                $('#outDest').html($('#outDest').html() + outDests);
                $('#outTime').html($('#outTime').html() + outTimes);
                $('#outStatus').html($('#outStatus').html() + outStatuses);
            } else {
                $('#messgaout').html(obj.mess);
            }
        }
    });
}

function playSound(name) {
    var audio = new Audio();
    audio.src = getResDir() + "sounds/" + name;
    audio.autoplay = true;
}
$(document).ready(function() {
    $('#upgraderButton').click(function() {
        $('#babWin').html('');
        $('#babBet').html('');
            $.ajax({
                type: 'POST',
                url: '/upgraderEngine',
                beforeSend: function() {
                    $('#babBet').html('');
                    $('#babWin').html('');
                    $('.commonMagicStick').css('content', 'url("..//img/posh.png")');
                },
                data: {
                    val: $('#upgraderInput').val(),
                    ch: $('.selected').attr('data-name')
                },
                success: function(data) {
					upgraderHistory();
						  upgraderLive();
						  
                    var json = data;
                    var obj = JSON.parse(json);
                    if (obj.success == "success") {
                        $('#babWin').html('');
                        $('#babBet').html('<img src="..//img/5000.png" />');
                        if (obj.go == "win") {
                            playSound('won.mp3');
                           
                                    $('#babWin').html('<img src="..//img/5000.png" />');
                                    $('.commonMagicStick').css('content', 'url("..//img/posh1.png")');
                           
                        } else {
                            playSound('lose.mp3');
                          
                                    $('#babWin').html('<img src="..//img/noboom.png" />');
                                    $('.commonMagicStick').css('content', 'url("..//img/posh.png")');
                             
                            
                        }
$('#balance').html(obj.balance);
                    } else {
                        alert(obj.messages)
                    }
balancecheck();
                }
            });
    });
});

function balancecheck() {
    $.ajax({
        type: "POST",
        url: "..//game/double/balance.php"
    }).done(function(result) {
        $('#balance').html(result);
    });
};
function upgraderHistory() {
	 $.ajax({
        type: "POST",
        url: "/upgraderHistory"
    }).done(function( result )
        {
$('#upgraderMyBets').html(result);
        });
}
function upgraderLive() {
 $.ajax({
        type: "POST",
        url: "/upgraderLive"
    }).done(function( result )
        {
$('#upgraderLive').html(result);
        });

		
}