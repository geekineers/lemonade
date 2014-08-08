	
$(document).ready(function(){
	// if( $(this).is(':checked') ) {
		// 	$('.user-account-form').fadeIn();		
		// }
		// else{
		// 	$('.user-account-form').fadeOut();
		// }

	$('#create_user').on('click', function(event){
		// event.preventDefault();
		
		if( $(this).is(':checked') ) {
			$('.user-account-form').fadeIn();		
		}
		else{
			$('.user-account-form').fadeOut();
		}
	})
	$('.basic-information .edit-profile-btn').on('click', function(event){
		event.preventDefault();
		$('.basic-information .profile-value').fadeOut('fast');
		$('.basic-information .edit-input').fadeIn();
		$('.basic-information .save-cancel-btn').fadeIn();
	});
	$('.basic-information .btn-cancel').on('click', function(event){
		event.preventDefault();
		$('.basic-information .edit-input').fadeOut('fast');
		$('.basic-information .save-cancel-btn').fadeOut('fast');
		$('.basic-information .profile-value').fadeIn();
	});

	$('.employment-details .edit-profile-btn').on('click', function(event){
		event.preventDefault();
		$('.employment-details .profile-value').fadeOut('fast');
		$('.employment-details .edit-input').fadeIn();
		$('.employment-details .save-cancel-btn').fadeIn();
	});
	$('.employment-details .btn-cancel').on('click', function(event){
		event.preventDefault();
		$('.employment-details .edit-input').fadeOut('fast');
		$('.employment-details .save-cancel-btn').fadeOut('fast');
		$('.employment-details .profile-value').fadeIn();
	});

	$('.government-information .edit-profile-btn').on('click', function(event){
		event.preventDefault();
		$('.government-information .profile-value').fadeOut('fast');
		$('.government-information .edit-input').fadeIn();
		$('.government-information .save-cancel-btn').fadeIn();
	});
	$('.government-information .btn-cancel').on('click', function(event){
		event.preventDefault();
		$('.government-information .edit-input').fadeOut('fast');
		$('.government-information .save-cancel-btn').fadeOut('fast');
		$('.government-information .profile-value').fadeIn();
	});
});