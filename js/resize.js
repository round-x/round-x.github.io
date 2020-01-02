$(function() {
    $(".chat, .loga, .scroll-table").on("mousewheel DOMMouseScroll", function(c) {
        c.preventDefault();
            var a = $(this).scrollTop(),
                a = a + (0 <= c.originalEvent.wheelDelta ? -20 : 20);
            $(this).scrollTop(a)

    })
	$(window).resize(function() {
		var height = $(this).height();
		$("[data-h]").each(function(indx, el){
			var h = $(el).data("h")
			$(this).height(height - h)
        });
	})
    $(window).load(function () {
        $(window).resize();
    });
    useOverlay();
});




function scrollChat(){
	$(".chat").scrollTop(50000);
}

function scrollLog(){
	$(".loga").scrollTop(0);
}

function scrollUpgrader(){
    $("#upgraderMyBets").scrollTop(0);
    //$("#liveUpgr").scrollTop(0);
    //$("#upgraderLive").scrollTop(0);
}


function resizeWindow(){
	$(window).resize();
}
