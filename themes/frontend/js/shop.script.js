var $body = $("body");
$(function() {
    $body.on("click", "#register-tab-trigger", function(){
        $("#login-modal .modal-title").text("ثبت نام");
    });

    $body.on("click", "#login-tab-trigger", function(){
        $("#login-modal .modal-title").text("ورود به پنل کاربری");
    });

    $body.on("click",".address-list .address-item",function(e){
        if(!$(e.target).hasClass("edit-link") && !$(e.target).hasClass("remove-link")) {
            $(".address-list .address-item").removeClass("selected");
            $(this).addClass("selected");
            $(this).find("input[type='radio']").prop("checked", true);
        }
    });

    $body.on("click", ".shipping-methods-list .shipping-method-item", function(){
        $(".shipping-methods-list .shipping-method-item").removeClass("selected");
        $(this).addClass("selected");
        $(this).find("input[type='radio']").prop("checked", true);
    });
});