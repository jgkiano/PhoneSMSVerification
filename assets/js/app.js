//this javascript will be all in one file..it is here to reduce the number of files you have to open
var reg = new RegExp("^[7]{1}([0-3]{1}[0-9]{1})?[0-9]{3}?[0-9]{3}$");

var codeReg = new RegExp("^[0-9]{1,6}$");

//when main form is submitted
$(document).on("submit", "#main-form", function(e) {
    if(reg.test($("#phone").val())) {
        performAjax("./register.php", $("#main-form").serialize());
    } else {
        $(".msg").html("<p>Please enter the correct mobile pattern e.g 712345678</p>");
    }
    e.preventDefault();
});

//when verify form is submitted
$(document).on("submit", "#code-verify", function(e) {
    if(codeReg.test($("#code").val()) && $("#phone").val() != "") {
        performAjax("./verify.php", $("#code-verify").serialize());
    } else {
        $(".content").html("");
        $(".content").html("wrong phone pattern");
    }
    e.preventDefault();
});

//when resend sms is submitted
$(document).on("submit", "#resend-sms", function(e) {
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
    $.ajax({
        type: 'POST',
        url : url, // the script where you handle the form input.
        data: data, // serializes the form's elements.
        beforeSend:function(){
            $(".content").html("submitting form");
        },
        success:function(data){
            $(".content").html("");
            $(".content").html(data);
        },
        error:function(){
            $(".content").html("something went wrong");
        }
    });
}
