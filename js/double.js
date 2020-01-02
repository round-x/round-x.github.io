window.onerror = null;
var st = 0;
function sea()
{
if(window.location.hash == "#tab2")
{
	if(st == 0)
	{

	$.ajax({
        type: "POST",
        url: "..//game/double/double.php"
    }).done(function(resultup)
        {
		    var json = resultup;
            var data = JSON.parse(json);
			$("#doubletimer").html(data.timer);
			$("#game_doubles").html(data.progresdouble);
			 
        });
		var tipe = "duoble";
		
	var tipe = "duoble";
	$.ajax({
        type: "POST",
        url: "..//game/double/double_story.php",
    }).done(function(resultup)
        {
			$("#historys").html(resultup);			 
        });
			var tipe = "stavki";
	$.ajax({
        type: "POST",
        url: "..//game/double/double_stat.php",
    }).done(function(resultup)
        {
			var json = resultup;
            var data = JSON.parse(json);
			$("#betLogdo").html(data.bet);
			$("#betusdo").html(data.usr);
			$("#betsumdo").html(data.sum);	 
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
}
}
function betdouble(types)
{
	st = 1;
	var sum = $("#bet-size").val();
	 $.ajax({
        type: "POST",
        url: "..//game/double/bet_double.php",
        data: {sum:sum, types:types}
    }).done(function( result )
        {
			st = 0;
alert(result);
        });
}
setInterval("sea();",50);