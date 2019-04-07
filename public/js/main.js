$(document).ready(function () {
    // sidebar menu slowly slide on mobile
    $(window).resize(function () {
        if ($(window).width() > 767) {
            $(".sidebar-container > .sidebar").css("display", "block");
        }
    });
    $(".sidebar-menu-header").on("click", function () {
        $(".sidebar-container > .sidebar").slideToggle("slow", function () {
            // Animation complete.
        });
    });

    // accordition toggle class on open/close
    $('.panel-title .collapsed').on("click", function () {
        $('.panel-title .closed').removeClass("closed").addClass("open");
		    $(this).toggleClass("open closed");
		    if ($(this).attr("aria-expanded") == 'true')
		    {
            $('.panel-title .closed').removeClass("closed").addClass("open");
		    }
    });

    $( "#scheduleGame" ).click(function() {
        var date =  $("#bookingDate").val();
        var venueId = $("#venueId").val();
        var fields = date.split('-');
        var currentLink = window.location.href.split('/');
        var redirectLink = "http://" + currentLink[2] + "/appointment/book?venue="+ venueId + "&date=" + fields[0] + "-" + fields[1] + "-" + fields[2];
        window.location.href = redirectLink;
    });

});

