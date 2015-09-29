// when button menu-btn is clicked
var menu = function menu() {
    if ($("#menu-btn").hasClass("menu-hidden"))
        showMenu();
    else
        hideMenu();
}

var showMenu = function showMenu() {
    $("nav").animate({
        "left": "0px"
    });
    $(".content").animate({
        "padding-left": "+=10%"
    });
    if ($(window).width() > 767) {
        $("#menu-btn").css("left", "12%").removeClass("menu-hidden");
    } else {
        $("#menu-btn").css("left", "10%").removeClass("menu-hidden");
        $("h1").animate({
            "padding-left": "+=20px"
        });
    }
}

var hideMenu = function hideMenu() {
    $(".content").animate({
        "padding-left": "-=10%"
    });
    if ($(window).width() > 767) {
        $("#menu-btn").css("left", "20px").addClass("menu-hidden");
    } else {;
        $("#menu-btn").css("left", "0px").addClass("menu-hidden");
        $("h1").animate({
            "padding-left": "-=20px"
        });
    }
    $("nav").animate({
        "left": "-170px"
    })
}

var validate = function validate() {
    var description = validField('description'),
        category = validField('category'),
        sender = validField('sender'),
        state = validField('state'),
        postcrossing_id = $('#postcrossing-id').val(),
        type = validField('type'),
        date = validField('date'),
        country = validField('country'),
        favorite = $('#favorite').val(),
        proceed = true;

    if (!description || !category || !sender || !state || !type || !date || !country)
        proceed = false;

    if ($('#photo').hasClass('required')) {
        var file_ext = $('#photo').val().split('.').pop().toLowerCase();
        if ((file_ext != "png") && (file_ext != "jpg") && (file_ext != "jpeg")) {
            $('#photo').css('border-bottom-color', '#A62929');
            proceed = false;
            $('.photo-error').removeClass('hidden');
        } else {
            $('#photo').css('border-bottom-color', '#CC3748');
            $('.photo-error').addClass('hidden');
        }
    }

    if (!proceed) {
        $('.form-field').css('height', '120px');
        $('label').css('bottom', '55%');
    } else
        $('.form-field').css('height', '');
    return proceed;
}

var validField = function validField(name) {
    var ok = true;
    var elemento = $('#' + name);
    if (elemento.val().length == 0 || elemento.val() == " " || elemento.val() == "null") {
        elemento.css('border-color', '#A62929');
        ok = false;
        $('.' + name + '-error').removeClass('hidden');
    } else {
        elemento.css('border-color', '#CC3748');
        $('.' + name + '-error').addClass('hidden');
    }
    return ok;
}

var validateSearch = function validateSearch() {
    var category = validField('field');
    var search = validField('search');
    if (category && search)
        return true;
    return false;
}

$(function() {
    $(".form-group input, .form-group select").focus(function() {
        var ele = $(this).attr("id");
        $("." + ele).removeClass("hidden").css("opacity", 1).animate({
            top: "-25%"
        }, 500);
        $(this).attr("placeholder", "");
    });

    $("#menu-btn").on('click', function() {
        menu();
    });

    $('.add-form').on('submit', function(e) {
        if (!validate())
            (e).preventDefault();
    });


    $('.search-form').on('submit', function(e) {
        if (!validateSearch())
            (e).preventDefault();
    });

    $(".back").on('click', function() {
        parent.history.back();
        return false;
    });

    $(".search").on('click', function() {
        if (validateSearch()) {
            var field = $("#search").val(),
                query = $("#field").val();

            $(".search").data("href", "result.php?field=" + field + "&query=" + query);
            window.document.location = $(this).data("href");
        }
    });

    $(".showPostcard, .category, .edit-btn, .tags, .remove").on('click', function() {
        window.document.location = $(this).data("href");
    });

    $(".fav").on('click', function() {
        window.document.location.href = 'favorites.php';
    });

    $("input").focus(function() {
        var id = $(this).attr("id")
        , label = "." + id + "-label";
        
        $(label).animate({
            top: "5%"
        }, 500);
        $(label).addClass('label-selected');
        if (id === 'date' || id === 'photo') {
            $('input#' + id).css('padding-left', 0);
        }
    });
    
    $(".select-postcard-option button").on('click', function(){
        $('.select-postcard-option button').removeClass('clicked');
        $(this).addClass('clicked');
        $('.received-field').toggleClass('hidden');
        $('.swap').toggleClass('hidden');
    });

});