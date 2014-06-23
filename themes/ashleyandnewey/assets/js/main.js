var aurl = "/wp-content/themes/ashleyandnewey/assets/ajax/";
$(document).ready(function() {
    $(".container").css("height", $(window).height() + "px");
    $(window).resize(function() {
        $(".container").css("height", $(window).height() + "px");
    });

    $('#img-slider').fadeIn();

    //placeholder
    $.Placeholder.init({
        color: 'rgb(255, 255, 255)'
    });
    var placep = $('.login #password');
    placep.attr('type', 'text');
    placep.focus(function() {
        if (placep.val() == "") {
            placep.attr('type', 'password');
        }
        placep.blur(function() {
            if (placep.val() == "PASSWORD") {
                placep.attr('type', 'text');
            }
        });
    });
    var placeu = $('.login #username');
    $(".login #username").focus(function() {
        if (placeu.val() == "") {
            placeu.css({
                "font-weight": "bold"
            });
        }
        $(".login #username").blur(function() {
            if (placeu.val() == "USER NAME") {
                placeu.css({
                    "font-weight": "normal"
                });
            }
        });
    });

    //login menu
    $('.leftbar .login nav ul li:first').after("<em></em>");

    //login
    $(".login #ok").live('click',function() {
        var values = $('.login').serialize();
        $(".login #ok").addClass('active');
        setTimeout('removea(".login #ok");', 1000);
        $.ajax({
            type: "POST",
            url: aurl + "login.php",
            data: values,
            cache: false,
            success: function(msg) {
                msg = msg.replace(/^(\s*)|(\s*)$/g, '').replace(/\s+/g, ' ');
                if (msg == "ok") {
                    window.location = "tours";
                } else {
                    $(".leftbar .message").html(msg);
                }
            }
        });
        return false;
    });

    //request
    $(".request #send").live('click',function() {
        var values = $('.request').serialize();
        $(".request #send").addClass('active');
        setTimeout('removea(".request #send");', 1000);
        $.ajax({
            type: "POST",
            url: aurl + "request.php",
            data: values,
            cache: false,
            success: function(msg) {
                $(".basic-content #content").html(msg);
            }
        });
        return false;
    });

    //forgot
    $(".forgot #send").live('click',function() {
        var values = $('.forgot').serialize();
        $(".forgot #send").addClass('active');
        setTimeout('removea(".forgot #send");', 1000);
        $.ajax({
            type: "POST",
            url: aurl + "forgot.php",
            data: values,
            cache: false,
            success: function(msg) {
                $(".basic-content #content").html(msg);
            }
        });
        return false;
    });

    //change
    $(".change #save").live('click',function() {
        var values = $('.change').serialize();
        $(".change #save").addClass('active');
        setTimeout('removea(".change #save");', 1000);
        $.ajax({
            type: "POST",
            url: aurl + "change.php",
            data: values,
            cache: false,
            success: function(msg) {
                $(".basic-content #content").html(msg);
            }
        });
        return false;
    });

    //logout
    $(".menu-log-out a").live('click',function() {
        $.ajax({
            url: aurl + "logout.php",
            cache: false,
            success: function() {
                window.location.href = "/about-us/";
            }
        });
        return false;
    });

    //change account
    $(".account-change .button").live('click',function() {
        var values = $('.account-change').serialize();
        $(".account-change .button").addClass('active');
        setTimeout('removea(".account-change .button");', 1000);
        $.ajax({
            type: "POST",
            url: aurl + "change.php",
            data: values,
            cache: false,
            success: function(msg) {
                $("#account-page .message").html(msg);
            }
        });
        return false;
    });

    //tours
    $.browser.safari = ($.browser.webkit && !(/chrome/.test(navigator.userAgent.toLowerCase())));
    if ($.cookies.get('viewCookie')) {
        $(".all-tour .tour").removeClass("tour-norm");
        $(".all-tour .tour").removeClass("tour-list");
        $(".all-tour .tour").addClass($.cookies.get('viewCookie'));
        if ($.cookies.get('viewCookie') == "tour-list") {
            $(".triangle").css('bottom', '-4px !important');
        }
    }
    $(".button-norm").live('click',function() {
        $(".all-tour .tour").removeClass("tour-norm");
        $(".all-tour .tour").addClass("tour-norm");
        $(".all-tour .tour").removeClass("tour-list");
        $.cookies.set('viewCookie', "tour-norm");

        if ($.browser.safari) {
            $(".triangle").css('bottom', '0px !important');
        }
    });
    $(".button-list").live('click',function() {
        $(".all-tour .tour").removeClass("tour-list");
        $(".all-tour .tour").addClass("tour-list");
        $(".all-tour .tour").removeClass("tour-norm");
        $.cookies.set('viewCookie', "tour-list");

        if ($.browser.safari) {
            $(".triangle").css('bottom', '-4px !important');
        }
    });

    $(".holiday-content .warrow").live('click',function() {
        dropd($("#holiday-drop"));
        if ($("#season-drop").is(":visible")) {
        	$("#season-drop").fadeOut("fast");
        }
        esc($("#holiday-drop"));
    });
    $(".seasons-content .warrow").live('click',function() {
        dropd($("#season-drop"));
        if ($("#holiday-drop").is(":visible")) {
        	$("#holiday-drop").fadeOut("fast");
        }
        esc($("#season-drop"));
    });
    $('body').live('click',function() {
        $('#season-drop, #holiday-drop').fadeOut("fast");
    });
    $('.tours-drop, .warrow').live('click',function(event) {
        event.stopPropagation();
    });

    searchtext = $.cookies.get('searchtextCookie');
    if (searchtext) {
	    $('#searchtextform').val(searchtext);
    }else{
	    $('#searchtextform').val("Search");
    }
    
	$('#searchtextform').focus(function(e) {
		if ($('#searchtextform').val() == "Search") {
			$('#searchtextform').val("");
		}
	});

	$('#searchtextform').keydown(function(e) {
		if (e.keyCode == 13) {
		myDate = new Date();
		myDate.setMinutes(myDate.getMinutes()+10);
            $.cookies.del('holidayCookie');
            $.cookies.del('seasonCookie');
			$.cookies.set('searchtextCookie', $(this).val(), {expiresAt:myDate});
            window.location.href="/tours/";
		}
	});

    $('#searchSubmit').click(function(e) {
		myDate = new Date();
		myDate.setMinutes(myDate.getMinutes()+10);
            $.cookies.del('holidayCookie');
            $.cookies.del('seasonCookie');
			$.cookies.set('searchtextCookie', $("#searchtextform").val(), {expiresAt:myDate});
            window.location.href="/tours/";
	});

    seasonactid = $.cookies.get('seasonCookie');
    if (seasonactid)
    {$('#tours-header #season-drop ul li p[data-id="'+seasonactid+'"]').addClass('active');}

    $('#tours-header #season-drop ul li p').live('click',function() {
        var id = ($(this).data('id'));
        $.cookies.del('searchtextCookie');
        
        
        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
            $.cookies.del('seasonCookie', 0);
            window.location.href="/tours/";
        } else {
            $(this).parent().parent().children().children().removeClass('active');
            $(this).addClass('active');
			myDate = new Date();
			myDate.setMinutes(myDate.getMinutes()+10);
            $.cookies.set('seasonCookie', id, {expiresAt:myDate});
            window.location.href="/tours/";
        }
    });

    holidayactid = $.cookies.get('holidayCookie');
    if (holidayactid)
    {$('#tours-header #holiday-drop ul li p[data-id="'+holidayactid+'"]').addClass('active');}

    $('#tours-header #holiday-drop ul li p').live('click',function() {
        var id = ($(this).data('id'));
        $.cookies.del('searchtextCookie');
        
        
        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
            $.cookies.del('holidayCookie');
            window.location.href="/tours/";
        } else {
            $(this).parent().parent().children().children().removeClass('active');
            $(this).addClass('active');
			myDate = new Date();
			myDate.setMinutes(myDate.getMinutes()+10);
            $.cookies.set('holidayCookie', id, {expiresAt:myDate});
            window.location.href="/tours/";
        }
    });

	odd();

    $('.tour .arrow').live('click',function() {
        var id = $(this).parent().parent().data('id');
        if ($('.tour-content[data-id="' + id + '"]').hasClass('hidden')) {
            $('.tour-content, .triangle').slideUp('slow').addClass('hidden');
            $('.arrow').removeClass('active').attr('title', 'Open');
            $('.tour-content[data-id="' + id + '"], .triangle[data-id="' + id + '"]').slideDown('slow').removeClass('hidden');
            $(this).addClass('active').attr('title', 'Close');
            $('.tour-list .excerpt[data-id="' + id + '"], .tour-list .thumbnail[data-id="' + id + '"]').slideDown('slow');
            $('#sb' + id).children().remove();
            $('#sc' + id).swiper({
                slidesPerSlide: 4,
                onlyExternal: true,
                scrollbar: {
                    container: '#sb' + id,
                    hide: false,
                    draggable: true,
                    snapOnRelease: false
                }
            });
        } else {
            $('.tour-content[data-id="' + id + '"], .triangle[data-id="' + id + '"]').slideUp('slow').addClass('hidden');
            $(this).removeClass('active').attr('title', 'Open');
            $('.tour-list .excerpt[data-id="' + id + '"], .tour-list .thumbnail[data-id="' + id + '"]').slideUp('slow');
        }
    });

    $('.tour .bell').live('click',function() {
        var id = $(this).parent().parent().data('id');
        var popup = $(this).parent().parent().children('.dates-popup');
        dropd(popup);
        esc(popup);
    });
    $('body').live('click',function() {
        $('.dates-popup').fadeOut("fast");
    });
    $('.tour .bell, .dates-popup').live('click',function(event) {
        event.stopPropagation();
    });

    $('.documents .selector a').live('click',function(e) {
        e.preventDefault();
        $(this).parent().children().removeClass('active');
        $(this).addClass('active');
        var url = $(this).data('url');
        if ($(this).hasClass('bstatus')) {
            $(this).parent().parent().children(':last').addClass('bstatus');
        } else {
            $(this).parent().parent().children(':last').data('url', url).removeClass('bstatus');
        }
    });
    $('.documents .icons .open').live('click',function() {
        if ($(this).parent().hasClass('bstatus')) {
            var url = $(this).parent().parent().prev().children(':last').html();
            window.open(aurl + "xls-download.php?url=" + url);
        } else {
            var url = 'www.ashleynewey.co.uk/assets/' + $(this).parent().data('url');
            window.open('http://docs.google.com/viewer?url=' + url, '_blank');
        //            window.open(url, '_blank');
        }
    });
    $('.documents .icons .download').live('click',function() {
        if ($(this).parent().hasClass('bstatus')) {
            var url = $(this).parent().parent().prev().children(':last').html();
            window.open(aurl + "xls-download.php?url=" + url);
            var values = 'url=' + url;
            $.ajax({
                type: "POST",
                url: aurl + "xls-download-stat.php",
                data: values,
                cache: false
            });
        } else {
            var url = $(this).parent().data('url');
            window.open(aurl + "download.php?url=" + url);
            var values = 'url=' + url;
            $.ajax({
                type: "POST",
                url: aurl + "download-stat.php",
                data: values,
                cache: false
            });
        }
    });
    $('.documents .icons .email').live('click',function() {
        if ($(this).parent().hasClass('bstatus')) {
            var url = $(this).parent().parent().prev().children(':last').html();
            $.get(aurl + "xls-mail.php?url=" + url);
            $('.documents').append('<p>We sent you a document.</p>');
            $('.documents p').html("We sent you a document.").slideDown().delay(1000).slideUp();
            setTimeout(function() {
                $('.documents p').remove();
            }, 2000);
            return false;
        } else {
            var url = $(this).parent().data('url');
            var values = 'url=' + url;
            $.ajax({
                type: "POST",
                url: aurl + "mail.php",
                data: values,
                cache: false,
                success: function() {
                    $('.documents').append('<p>We sent you a document.</p>');
                    $('.documents p').html("We sent you a document.").slideDown().delay(1000).slideUp();
                    setTimeout(function() {
                        $('.documents p').remove();
                    }, 2000);
                }
            });
        }
    });

    $('.photos .download').live('click',function() {
        var url = $(this).data('url');
        window.open(aurl + "download.php?url=" + url);
    });

    $('#tours-page .tour-content .dates table td .bell').live('click',function() {
        var selector = $(this);
        $('#popup_content').html('<p>Please confirm your reservation.</p><button type="button" class="confirm">Confirm</button><div class="separator"></div><button type="button" class="cancel">Cancel</button><br>');
        loadPopup();

        //audio play
        var audioElement = document.createElement('audio');
        audioElement.setAttribute('src', aurl + 'belltimer.mp3');
        $.get();
        audioElement.addEventListener("load", function() {
            audioElement.play();
        }, true);
        audioElement.play();

        $('#popup_content .confirm').die('click');

        $('#popup_content .confirm').live('click',function() {
            disablePopup();
            var thise = selector;
            var date = selector.data('date');
            var dateid = selector.data('dateid');
            var id = selector.data('id');
            var values = {
                id: id, 
                date: date, 
                dateid: dateid
            };

            $.ajax({
                type: "POST",
                url: aurl + "reserve.php",
                data: values,
                cache: false,
                success: function(msg) {
                    msg = msg.replace(/^(\s*)|(\s*)$/g, '').replace(/\s+/g, ' ');
                    if (msg != "reserved") {
                        $(thise).closest('td').next('td').next('td').html(msg);
                        var row = $(thise).closest("tr")[0].rowIndex;
                        $(thise).parent().parent().parent().parent().parent().find('.xlsData tr:eq(' + row + ') td:last').html(msg);
                        if (msg != "free") {
                            $('#popup_content').html('<p>Thank you for your request,</p><br><p>we will confirm it within 48 hours.</p><br><p>Any queries please call us.</p>');
                            loadPopup();
                        }
                    } else {
                        $('#popup_content').html('<p>Sorry,</p><br><p>this date is already reserved,</p><br><p>please select another date.</p>');
                        loadPopup();
                    }
                }
            });
        });
        $('#popup_content .cancel').live('click',function() {
            disablePopup();
        });
    });

    $(this).keyup(function(event) {
        if (event.which == 27) {
            disablePopup();
        }
    });
    $("div#backgroundPopup").live('click',function() {
        disablePopup();
    });

    if ($('#tours-page').length > 0) {
        pajinate(get_tours_item_number());
    }

    $('.fancybox').fancybox({});
});

function dropd(drop) {
    if (drop.is(":visible")) {
        drop.fadeOut("fast");
    } else {
        drop.fadeIn("fast");
    }
}

function odd() {
    $('.tour, .tour-content').removeClass('odd');
    $('.tour:visible:odd').addClass('odd');
}

function removea(varc) {
    $(varc).removeClass('active');
}

function get_tours_item_number() {
    var size = $('#tours-page .content li .tour').not('.hiddenimp').size();
    return size;
}

function pajinate(it) {
    $('#tours-page').pajinate({
        items_per_page: 15,
        num_page_links_to_display: 6,
        nav_label_prev: 'Previous',
        nav_label_next: 'Next',
        own_items: it
    });
}

function esc(element) {
    $(document).keydown(function(e) {
        if (e.keyCode === 27) {
            element.fadeOut("fast");
        }
    });
}

var popupStatus = 0;
function loadPopup() {
    if (popupStatus == 0) {
        $("#toPopup").fadeIn(0500);
        $("#backgroundPopup").css("opacity", "0");
        $("#backgroundPopup").fadeIn(0001);
        popupStatus = 1;
    }
}
function disablePopup() {
    if (popupStatus == 1) {
        $("#toPopup").fadeOut("normal");
        $("#backgroundPopup").fadeOut("normal");
        popupStatus = 0;
    }
}




