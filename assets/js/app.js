var reg = new RegExp("^[7]{1}([0-3]{1}[0-9]{1})?[0-9]{3}?[0-9]{3}$");

var codeReg = new RegExp("^[0-9]{1,6}$");

var windowSize;

$(window).on('load', function() {
    $(".pre-loader").fadeOut("slow", function() {
    });
    animateEntry($(".logo"), "slideInLeft");
    animateEntry($(".action-container h1"), "slideInRight");
    animateEntry($(".form-container"), "bounceInUp");

});

$(document).ready(function() {
    windowSize = $(window).width();
});

function animateEntry(element, animation) {
    element.addClass('animated ' + animation);
    //wait for animation to finish before removing classes
    window.setTimeout( function(){
        element.removeClass('animated ' + animation);
    }, 2000);
}

//when main form is submitted
$(document).on("submit", "#default-form", function(e) {
    if(reg.test($("#phone").val())) {
        performAjax("./register.php", $("#default-form").serialize());
    } else {
        $(".lab span").animate({opacity:0}, "fast", function() {
            $(this).text("Please enter your mobile number in the correct format e.g 7123456");
            $(this).animate({opacity:1}, "fast");
        });
    }
    e.preventDefault();
});




//when verify form is submitted
$(document).on("submit", ".form-container #verify-form", function(e) {
    if(codeReg.test($("#code").val()) && $("#phone").val() != "") {
        performAjax("./verify.php", $("#verify-form").serialize());
    } else {
        $(".lab span").animate({opacity:0}, "fast", function() {
            $(this).text("Please enter the correct verification code");
            $(this).animate({opacity:1}, "fast");
        });
    }
    e.preventDefault();
});

//when resend sms is submitted
$(document).on("submit", ".form-container #resend-sms", function(e) {
    if($("#phone-resend").val() != "") {
        performAjax("./verify.php", $("#resend-sms").serialize())
    } else {
        $(".content").html("");
        $(".content").html("wrong phone pattern");
    }
    e.preventDefault();
});

//performAjax requests
function performAjax(url, data) {
    console.log(data)
    $.ajax({
        type: 'POST',
        url : url, // the script where you handle the form input.
        data: data, // serializes the form's elements.
        beforeSend:function(){
            $(".form-container").html("<div class='loader'>Loading...</div>");
        },
        success:function(data){
            if(windowSize < 992) {
                $(".hero-text").fadeOut('slow', function() {
                    $(".form-container").hide();
                    $(".form-container").html("");
                    $(".form-container").html(data);
                    $(".form-container").fadeIn("slow");
                });
            } else {
                $(".form-container").hide();
                $(".form-container").html("");
                $(".form-container").html(data);
                $(".form-container").fadeIn("slow");
            }
        },
        error:function(){
            $(".form-container").html("error");
        }
    });
}
