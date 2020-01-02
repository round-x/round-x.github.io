 function histor() {
	 if(window.location.hash == "#tab4")
{
        // выводим сообщения в блок #messages
        $.ajax({
            url: '/action/history_auction.php',
            timeout: 10000, // время ожидания загрузки сообщений 10 секунд (или 10000 миллисекунд)
            success: function(data) {
                $('#last_game').html(data);
            },
            error: function() {
            }
        });
}
    }
	

   
    var interval = 1000; // количество миллисекунд для авто-обновления сообщений (1 секунда = 1000 миллисекунд)
    
    histor();
    
    setInterval('histor()', interval);
	function aucbet(){
		$.ajax({
        type: "POST",
        url: "/action/check_of_bet_auction.php"
    }).done(function( result14 )
        {
			$('#status').show();
			$("#status").html(result14);
        });
		var tipe = "balance";
	 $.ajax({
        type: "POST",
        url: "..//game/double/balance.php"
    }).done(function( result )
        {
$('#balance').html(result);
        });
}
function upinfo(){
	if(window.location.hash == "#tab4")
{
	$.ajax({
        type: "POST",
        url: "/action/up_info_auction.php",
    }).done(function(resultup)
        {
		    var json = resultup;
            var data = JSON.parse( json );
			$("#bank").html('Банк: ' + data.bank + ' <img src="img/coins16.png">');
			$("#summbet").html('Сделать ставку: ' + data.betsum + ' <img src="img/coins16.png">');
			if(data.stavka == "yes")
			{
				$('#stavka').hide();
				$("#userstavka").html('Последняя ставка: '+data.namebet+'</a>');
				$('#userstavka').show();
				$("#timer1").html(data.timer);
				$('#timer1').show();
			}
			else
			{
				$('#stavka').show();
				$('#timer1').hide();
				$('#userstavka').hide();
			}
        });
}
}
function messinterval(){	
$('#status').hide();
}

setInterval("upinfo();",500);
setInterval("messinterval();",5000);