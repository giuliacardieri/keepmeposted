var msgList = [];

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

var changeForm = function changeForm(className) {
    $('input .'+className+', select .'+className).attr('required');
    if (className === 'swap-btn') {
        $('.received-attr').attr('data-parsley-required', 'false');
        $('.received-field').addClass('hidden');
        $('.swap-field').removeClass('hidden');
        $('#swap').attr('value', '1');
    } else {
        $('.received-attr').attr('data-parsley-required', 'true');
        $('.received-field').removeClass('hidden');
        $('.swap-field').addClass('hidden');
        $('#swap').attr('value', '0');
    }
}

var editPostcard = function editPostcard() {
    $('.show-postcard, .edit-btn').addClass('hidden');
    $('.edit-postcard, .edit-field, .save-btn, .edit-photo-btn, .img-edit').removeClass('hidden');
}

var savePostcard = function savePostcard() {
    $('.show-postcard, .edit-btn').removeClass('hidden');
    $('.edit-postcard, .edit-field, .save-btn, .img-edit, .edit-photo-btn').addClass('hidden');
    $.get( $(".save-btn").data("href"), function(data) {
      $( ".postcard-load" ).html(data);
    });
}

var showMsg = function showMsg(obj) {
    if (obj.type === 1)
        successMsg(obj.id);
    else
        errorMsg(obj.id);
}

var successMsg = function successMsg(msgId) {
    var id = ''
    , msg = ''
    , template = '';

    switch (msgId) {
        case 'fav': msg = 'Postcard added to favorites'; id = 'favOk'; break;
        case 'delete':  msg = 'Postcard deleted'; id = 'delOk'; break;
        case 'fav-remove':  msg = 'Postcard removed from favorites'; id = 'favRemoveOk'; break;
        case 'settings-edit':  msg = 'Settings saved'; id = 'settingsSaved'; break;
    }

    if(!checkMsgList(id)) {
        template = "<div id=" + id + "><div class='row'><div class='alert alert-success alert-dismissible' role='alert'>";
        template += "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>";
        template += "<span class='glyphicon glyphicon-ok'></span>" + msg + "</div></div></div>";

        $('.main').first().prepend(template);
        addMsgList(id);

        setTimeout(function (){
            removeMsgList(id);
        }, 2500);
    }
}

var addMsgList = function addMsgList(id) {
    msgList.push(id);
}

var removeMsgList = function removeMsgList(id) {
    for (var i=0; i<msgList.length; i++) {
        if (msgList[i] == id) {
            $('#'+id).remove();
            msgList.splice(i, 1);
        }
    }
}

var checkMsgList = function checkMsgList(id) {
    for (var i=0; i<msgList.length; i++) {
        if (msgList[i] === id) {
            return true;
        }
    }
    return false;
}

var addNewChip = function addNewChip(id) {
    var value = $('#new-chip').val()
    , template = '';
    $('#new-chip').val('');

    template += "<p data-input-ref='" + id + "' class='chip chip-" + id + "'>" + value +"<span class='close-option'>x</span></p>";
    template += "<input name='chip-" + id + "' class='chip-" + id + "' id=" + id + "' type='hidden' value='" +  value +"'/>";

    if (value) {
        $('.chip-wrapper').append(template);
    }
}

var saveProfile = function saveProfile() {
    $('.edit-profile-btn ').removeClass('hidden');
    $('.edit-item').addClass('hidden');
    $('.profile-info-wrapper ').removeClass('hidden');
    $.get( $(".save-profile-btn").data("href"), function( data ) {
      $( ".profile-load" ).html( data );
    });
}

var adjustVerticalPostcards = function adjustVerticalPostcards() {
  var width
  , height;

  width = $('.img-wrapper .img-responsive').width();
  height = $('.img-wrapper .img-responsive').height();
  if (width/height < 1) {
    $('.img-container').removeClass('col-md-7').addClass('col-md-4');
  }
}

$(function() {
    $(".form-group input, .form-group select").focus(function() {
        var ele = $(this).attr("id");
        $("." + ele).removeClass("hidden").css("opacity", "0.5").animate({
            top: "10px"
        }, 500);
        $(this).attr("placeholder", "").css("padding", "35px 2% 15px 2%");
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

    $("#menu-btn").on('click', function() {
        menu();
    });

    $( "#datepicker-add" ).datepicker();

    $(".back").on('click', function() {
        parent.history.back();
        return false;
    });

    $('.edit-btn').on('click', function(e){
        e.preventDefault();
        editPostcard();
    });

    $('.save-btn').on('click', function(){
        if ($("#postcard-update").parsley().isValid()) {
          $("#postcard-update").submit();
        }
    });

    $('#postcard-update').ajaxForm({
      success: function()
      {
        savePostcard();
      },
    });

    $('.add-favorite').on('click', function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: $(this).data("href"),
            data: '',
            success: function(o) {
                $('.add-favorite').addClass('hidden');
                $('.remove-favorite').removeClass('hidden');
                showMsg({
                    'type': 1,
                    'id': 'fav'
                });
            }
        });
    });

    $('.remove-favorite').on('click', function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: $(this).data("href"),
            data: '',
            success: function(o) {
                $('.remove-favorite').addClass('hidden');
                $('.add-favorite').removeClass('hidden');
                showMsg({
                    'type': 1,
                    'id': 'fav-remove'
                });
            }
        });
    });

    $(".showPostcard, .category-btn, .delete, .settings-profile-btn, .postcard").on('click', function() {
        window.document.location = $(this).data("href");
    });

    $(".profile-content-wrapper, .results-inner-wrapper").on('click', '.postcard' ,function() {
        window.document.location = $(this).data("href");
    });

    $('.results-inner-wrapper').on('click', '.user-item' ,function(){
        window.document.location = $(this).data("href");
    });

    $(".select-postcard-option button").on('click', function(){
        $('.select-postcard-option button').removeClass('clicked');
        changeForm($(this).attr('class'));
        $(this).addClass('clicked');
    });

    $(".header-img-wrapper").on("click", function(){
        $(".user-info").toggleClass("hidden");
    });

    $(".signup-btn").on("click", function(){
        if ($(".signup-form").parsley().isValid())
            $(this).attr("data-dismiss", "modal");
        $(".signup-form").submit();
    });

    $(".login-btn").on("click", function(){
        if ($(".login-form").parsley().isValid())
            $(this).attr("data-dismiss", "modal");
       $(".login-form").submit();
    });

    $(".add-submit").on("click", function(e){
       (".add-form").parsley();
    });

    $(".profile-content-wrapper, .results-inner-wrapper, .postcards-wrapper, .postcards-wrapper-smaller").on('mouseenter mouseleave', '.postcard', function(){
        $(this).find(".postcard-extra").toggleClass("hidden");
    });

    $(".profile-content-wrapper .postcard, .results-inner-wrapper .postcard").on('mouseenter mouseleave', function(){
        $(this).find(".postcard-extra").toggleClass("hidden");
    });

    $('.error-tooltip').tooltip({
        'trigger' : 'manual;'
    });

    window.Parsley.on('field:error', function(instance) {
        var $ele = this.$element
        , id = $ele.attr('id')
        , errorMsg;

        $ele.addClass('field-error');
        $('label.'+id).addClass('field-error');
        errorMsg = ParsleyUI.getErrorsMessages(instance);
        if ($ele.hasClass('error-tooltip')) {
            $ele.attr('title', errorMsg).tooltip('fixTitle');
            $ele.tooltip('show');
        } else {
            $('.'+id+'.field-error').removeClass('hidden');
        }
    });

    $('.chip-wrapper').on('click', '.chip .close-option', function(){
        if ($('.chip').length < 6)
            $('.chip-helper').removeClass('hidden');
        var parentClass = ($(this).parent().attr('class')).split(' ')
        , tagsValue = ''
        , id = $(this).parent().attr('data-input-ref')
        , tags
        , i;
        if ($('#tags-value').length > 0) {
          tags = ($('#tags-value').attr('value')).split(',');
          for (i = 0; i < tags.length; i++) {
            if (tags[i] !== id && tags[i].trim()) {
              tagsValue += tags[i] + ',';
            }
          }
          $('#tags-value').attr('value', tagsValue);
        }

        $('.'+parentClass[1]).remove();
    });

    $('.chip-helper').on('click', function(){
        $('.new-chip').removeClass('hidden');
        $(this).addClass('hidden');
    });

    $('.btn-add-chip').on('click', function(e){
        e.preventDefault();
        var id = ''
        , values = ''
        , tagsValue = $('#tags-value').attr('value');

        values = tagsValue.split(',');
        id = tagsValue ? values[values.length - 2]*1 + 1 : '0';
        $('#tags-value').attr('value', tagsValue + id + ',');

        if ($('#new-chip').val().trim()) {
          addNewChip(id);
          $('.new-chip').addClass('hidden');
          if ($('.chip').length < 5)
              $('.chip-helper').removeClass('hidden');
        }
    });


    $('.btn-add-chip-select').on('click', function(e){
        e.preventDefault();
        var id = $('select#new-chip option:selected').attr('class');
          addNewChip(id);
          $('.new-chip').addClass('hidden');
          if ($('.chip').length < 3)
              $('.chip-helper').removeClass('hidden');
    });

    $('.profile-nav li a').on('click', function(e){
        e.preventDefault();
        $('.profile-nav li a').removeClass('active');
        $(this).addClass('active');
        $.get( $(this).attr('data-href'), function( data ) {
          $( ".postcards-wrapper-smaller" ).html( data );
        });
    });

    $('.edit-profile-btn').on('click', function(e){
        e.preventDefault();
        $(this).addClass('hidden');
        $('.edit-item').removeClass('hidden');
        $('.profile-info-wrapper ').addClass('hidden');
    });

    $('.save-profile-btn').on('click', function(){
        if ($("#form-profile").parsley().isValid()) {;
          $("#form-profile").submit();
        }
    });

    $('#form-profile').ajaxForm({
      success: function()
      {
          saveProfile();
      },
    });

    $('.favorite-icon').on('click', function(e){
      e.stopPropagation();
      var $el =  $(this);
        $.ajax({
            type: "POST",
            url: $(this).attr('data-href'),
            data: '',
            success: function() {
              if ($el.hasClass('add'))
                $el.siblings('.favorite-icon.remove').removeClass('hidden');
              else
                $el.siblings('.favorite-icon.add').removeClass('hidden');
              $el.addClass('hidden')

            }
        });
    });

    $('.settings-form').on('submit', function(e){
      e.preventDefault();
      if ($('.settings-form').parsley().isValid()) {
        $.ajax({
            type: "POST",
            url: $('.settings-form').data("href"),
            data: $('.settings-form').serialize(),
            success: function() {
                showMsg({
                    'type': 1,
                    'id': 'settings-edit'
                });
            }
        });
        window.scrollTo(0,0);
      }
    });

    $('.search-btn').on('click', function(e){
      e.preventDefault();
      if ($('#search-field').val().length > 0)
        $('.search-form').submit();
    });

    $('.results-nav li a').on('click', function(e){
      e.preventDefault();
      $('.results-nav li a').removeClass('active');
      $(this).addClass('active');
      if ($(this).html() === 'People' || $(this).html() === 'Tags')
        $('.search-row').addClass('hidden');
      else
        $('.search-row').removeClass('hidden');
      $.ajax({
          type: "POST",
          url: $(this).data("href"),
          data: $('#filters-form').serialize(),
          success: function(data) {
            $('.results-inner-wrapper').html(data);
          }
      });
    });

    $('#type, #filter-type, #order-by').on('change', function(){
      var url = ($('.results-nav li a.active').length > 0) ? $('.results-nav li a.active').data("href") : $('#filters-form').data("href");
      url = ($('.profile-nav li a.active').length > 0)  ? url + '/' + $('.profile-nav li a.active').html() : url;
      $.ajax({
          type: "POST",
          url: url,
          data: $('#filters-form').serialize(),
          success: function(data) {
            console.log(data);
            $('.results-inner-wrapper').html(data);
            $('.postcards-wrapper').html(data);
            $('.postcards-wrapper-smaller').html(data);
          }
      });
    });

    $('#filter').on('change', function(){
        if ($('#filter').val() !== 'a')
          $.get( $("#filter").data("href") + '/' + $('#filter').val(), function(data) {
            $("#filter-type").removeClass('hidden').html(data);
            $('.search-row .multiple-selects select').addClass('double');
          });
        else {
          $('#filter-type').trigger('change');
          $("#filter-type").addClass('hidden');
          $('.search-row .multiple-selects select').removeClass('double');
        }
    });

    adjustVerticalPostcards();
    $('.img-wrapper .img-responsive').on('load', function(){
        adjustVerticalPostcards();
    });

    $('.add-tags').on('click', function(){
      addTag();
    });
});
