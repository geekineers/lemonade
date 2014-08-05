$('#create_user').on('click', function(){
	if( $(this).is(':checked') ) {
		$('.user-account-form').fadeIn();		
	}
	else{
		$('.user-account-form').fadeOut();
	}
});