var msgList = []
    , unsaved = false;

// when button menu-btn is clicked
var menu = function menu() {
    if ($("#menu-btn").hasClass("menu-showing"))
        hideMenu();
    else
        showMenu();
}

var showMenu = function showMenu() {
    $("nav").css('display', 'block').animate({
        "left": "0px"
    });
    $("#menu-btn").addClass("menu-showing");
}

var hideMenu = function hideMenu() {
    $("#menu-btn").removeClass("menu-showing");
    setTimeout(function(){
        $('nav').css('display', 'none');
    }, 500);
    $("nav").animate({
        "left": "-50%"
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

var showStats = function showStats(data, type, options) {
    var chart, pie_chart;
    chart = $("#" + type + "Chart").get(0).getContext("2d");
    pie_chart = new Chart(chart).Pie(data, options);
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
        if ($(window).width() < 992) 
            menu();
    });

    $(".main").on('click', function() {
        if ($(window).width() < 992 && $('#menu-btn').hasClass('menu-showing')) 
            hideMenu();
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
      success: function() {
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

    $(".showPostcard, .btn-postcard, .delete, .settings-profile-btn, .postcard, .fav-category-btn, .favorite-categories-wrapper .glyphicon-pencil").on('click', function() {
        window.document.location = $(this).data("href");
    });

    $(".profile-content-wrapper, .results-inner-wrapper, .postcards-wrapper").on('click', '.postcard' ,function() {
        window.document.location = $(this).data("href");
    });

    $('.results-inner-wrapper').on('click', '.user-item, .btn-postcard' ,function(){
        window.document.location = $(this).data("href");
    });

    $(".select-postcard-option button").on('click', function(){
        $('.select-postcard-option button').removeClass('clicked');
        changeForm($(this).attr('class'));
        $(this).addClass('clicked');
    });

    $(".header-img-wrapper").on("click", function(){
        if ($(this).hasClass('showing')) {
            $(".user-info").addClass("hidden").animate({
                "top": "42px"
            }, 250);
            $(this).removeClass('showing');
        } else {
            $(".user-info").removeClass("hidden").animate({
                "top": "62px"
            }, 250);
            $(this).addClass('showing');
        }
    });

    $(".header-img-wrapper.showing").on("click", function(){
        $(".user-info").addClass("hidden").animate({
            "top": "45px"
        }, 250);
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

    $(".profile-content-wrapper, .results-inner-wrapper, .postcards-wrapper, .postcards-wrapper-smaller, .popular-postcard-wrapper").on('mouseenter mouseleave', '.postcard, .postcards-wrapper-smaller .postcard', function(e){
        e.stopPropagation();
        if ($(window).width() > 991)
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
        $.get( $(this).attr('data-href'), function(data) {
          $( ".postcards-wrapper-smaller" ).html( data );
        });
        if ($(this).hasClass('stats')) {
            $('.search-row').addClass('hidden');
            setTimeout(function (){
                $.get($('.countries-chart-wrapper').attr('data-href'), function(data){
                    showStats(JSON.parse(data), 'countries', pieOptions);
                });
                $.get($('.categories-chart-wrapper').attr('data-href'), function(data){
                    showStats(JSON.parse(data), 'categories', pieOptions);
                });
            }, 100);
        } else
            $('.search-row').removeClass('hidden');
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
      success: function() {
          saveProfile();
          console.log('sucesso');
      }
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
                unsaved = false;
            }
        });
        window.scrollTo(0,0);
      }
    });

    $('.search-btn').on('click', function(e){
        e.preventDefault();
        if (($('#search-field').val()).trim().length > 0 && !unsaved)
            $('.search-form').submit();
    });

    $('.search-btn-mobile').on('click', function(e){
      e.preventDefault();
      if (($('#search-field-mobile').val()).trim().length > 0)
        $('.search-form-mobile').submit();
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
      console.log(url);
      $.ajax({
          type: "POST",
          url: url,
          data: $('#filters-form').serialize(),
          success: function(data) {
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

    $('.table-wrapper').on('click', 'th', function(){
        var classe = $(this).attr('class')
        , tipo;
        if (classe === 'default' || classe === 'desc')
            tipo = 'asc';
        else
            tipo = 'desc';
        $(this).attr('class', tipo);

        $.get( $(this).attr('data-href') + '/' + tipo, function( data ) {
         $('.table-wrapper').html(data);
        });
    });

    var pieOptions = {
        //Boolean - Whether we should show a stroke on each segment
        segmentShowStroke : true,

        //String - The colour of each segment stroke
        segmentStrokeColor : "#424242",

        //Number - The width of each segment stroke
        segmentStrokeWidth : 1,
    };

    setTimeout(function (){
        $.get($('.countries-chart-wrapper').attr('data-href'), function(data){
            showStats(JSON.parse(data), 'countries', pieOptions);
            console.log(data);
        });
        $.get($('.categories-chart-wrapper').attr('data-href'), function(data){
            showStats(JSON.parse(data), 'categories', pieOptions);
            console.log(data);
        });
    }, 100);

    $('.btn-more').on('click', function(){
        var $btnWrapper = $(this).parents('.main').find('.postcards-extra');
        if ($btnWrapper.hasClass('hidden'))
            $(this).html('See Less');
        else
            $(this).html('See More');
        $btnWrapper.toggleClass('hidden');
    });

    $('.user-li').on('click', function(){
        $('.main-nav li').toggleClass('hidden');
        $('.user-li').removeClass('hidden');
    });

    $('.search-btn-mobile').on('click', function(){
        $('.search-field-wrapper').removeClass('hidden');
        $('.main-header').addClass('hidden');
        $('.menu-btn-span').addClass('hidden');
        $('.glyphicon-chevron-left').removeClass('hidden');
        $('.search-field-mobile').removeClass('hidden');
    });

    $('.glyphicon-chevron-left').on('click', function(e){
        e.stopPropagation();
        $('.search-field-wrapper').addClass('hidden');
        $('.main-header').removeClass('hidden');
        $('.menu-btn-span').removeClass('hidden');
        $('.glyphicon-chevron-left').addClass('hidden');
        $('.search-field-mobile').addClass('hidden');
    });

    $('.show-filters-btn').on('click', function(){
        $('#filters-form').removeClass('hidden-xs hidden-sm');
        $('.hide-filters-btn').removeClass('hidden');
        $('.show-filters-btn').addClass('hidden');
    });

    $('.hide-filters-btn').on('click', function(){
        $('#filters-form').addClass('hidden-xs hidden-sm');
        $('.show-filters-btn').removeClass('hidden');
        $('.hide-filters-btn').addClass('hidden');
    });

    $('.delete-account-btn').on('click', function(e){
        e.preventDefault();
    });

    $('.categories-wrapper .chip-wrapper').on('click', '.chip .close-option', function(){
        unsaved = true;
    });

    $('.settings-form').on('change', function(){
        unsaved = true;
    });

    $('nav, a, .search-btn').on('click', function(e){
        if (unsaved) {
            e.preventDefault();
            e.stopPropagation();
            $('#unsavedModal').modal('show');
            href = this;
        }
    });

    $('.btn-ignore').on('click', function(){
        if ($(href).attr("href"))
            window.document.location = $(href).attr("href");
        else {
            unsaved = false;
            $('.search-btn').click();
        }
    });
});
