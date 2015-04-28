// when button menu-btn is clicked
function menu(){
	if($("#menu-btn").hasClass("menu-hidden"))
		showMenu();
	else
		hideMenu();
}

function showMenu(){
	$("nav").animate({"left": "0px"});
    $(".content").animate({"padding-left": "+=10%"});
    if ($(window).width() > 767){
	 $("#menu-btn").css("left", "12%").removeClass("menu-hidden");
    }
    else{
	 $("#menu-btn").css("left", "10%").removeClass("menu-hidden");
	 $("h1").animate({"padding-left": "+=20px"});
    }
}

function hideMenu(){
    $(".content").animate({"padding-left": "-=10%"});
    if ($(window).width() > 767){
	 $("#menu-btn").css("left", "20px").addClass("menu-hidden");
    }
    else{;
	 $("#menu-btn").css("left", "0px").addClass("menu-hidden");
	 $("h1").animate({"padding-left": "-=20px"});
    }
	$("nav").animate({"left": "-170px"})
}

function validate(){
    var description = validField('description');
    var category = validField('category');
    var sender = validField('sender');
    var state = validField('state');
    var postcrossing_id = $('#postcrossing-id').val();
    var type = validField('type');
    var date = validField('date');
    var country = validField('country');
    var favorite = $('#favorite').val();
    var proceed = true;
  
    if (!description || !category || !sender || !state || !type || !date || !country)
        proceed = false;
    
	if ($('#photo').hasClass('required')){
		var file_ext = $('#photo').val().split('.').pop().toLowerCase();
		if ((file_ext != "png") && (file_ext != "jpg") && (file_ext != "jpeg")){
			$('#photo').css('border-bottom-color', '#A62929');
			proceed = false;
			$('.photoError').removeClass('hidden');
		}
		else {
			$('#photo').css('border-bottom-color', '#CC3748');
			$('.photoError').addClass('hidden');
		}
	}

    if (!proceed){
      $('.form-field').css('height', '120px');
      $('label').css('bottom', '55%');
    }
    else 
      $('.form-field').css('height', '');
    return proceed;
}

function validField(name){
    var ok = true;
    var elemento =  $('#'+name);
    if(elemento.val().length == 0 || elemento.val() == " " || elemento.val() == "null"){
        elemento.css('border-color', '#A62929');
        ok = false;
        $('.'+name+'Error').removeClass('hidden');
    } 
    else {
        elemento.css('border-color', '#CC3748');
        $('.'+name+'Error').addClass('hidden');
    }
    return ok;
}

function validateSearch(){
    var category = validField('field');
    var search = validField('search');
	if (category && search)
		return true;
	return false;
}

$(function(){
 	$("#menu-btn").click(function(){
		menu();
	});
  
    $('.add_form').submit(function(e) {
        if (!validate())
          (e).preventDefault();
	});
	
	
    $('.search-form').submit(function(e) {
		if (!validateSearch())
    	   (e).preventDefault();
	});
  
   $(".back").click(function() {
        parent.history.back();
        return false;
    });
  
    $(".search").click(function() {
		if (validateSearch()){
			var field = $("#search").val();
			var query = $("#field").val();
			$(".search").data("href", "result.php?field="+field+"&query="+query);
			window.document.location = $(this).data("href");
		}
    });
  
   $(".showPostcard, .category, .edit-btn, .tags, .remove, .start").click(function() {
        window.document.location = $(this).data("href");
    });
  
  $(".fav").click(function(){
      window.document.location.href ='favorites.php';
  });
});