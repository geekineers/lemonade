
$(document).ready(function(){
	
	// Search 
	$('.search').on('keyup', function(){
		var data = $(this).val();
		var url = $(this).attr('data-url');
		$.get(url, {search : data}, function(response){
			$('tbody').html(response);
		});

	});	

	
	$.fn.loading = function(options){
		option = typeof options == "undefined" ? true : options;
	
		if(option){
			$(this).append($('<div/>',{class:'overlay'})).append($('<div/>',{class:'loading-img'}))
			return option;
		}else{
			$('.overlay,.loading-img').remove();
			return false;
		}
	};

	

	    $('.timepicker').timepicker();

	    $('.earnings .edit-profile-btn').on('click', function(event) {
	        event.preventDefault();
	        $('.earnings .profile-value').fadeOut('fast');
	        $('.earnings .edit-input').fadeIn();
	        $('.earnings .save-cancel-btn').fadeIn();
	    });
	    $('.earnings .btn-cancel').on('click', function(event) {
	        event.preventDefault();
	        $('.earnings .edit-input').fadeOut('fast');
	        $('.earnings .save-cancel-btn').fadeOut('fast');
	        $('.earnings .profile-value').fadeIn();
	    });


	    $('.basic-information .edit-profile-btn').on('click', function(event) {
	        event.preventDefault();
	        $('.basic-information .profile-value').fadeOut('fast');
	        $('.basic-information .edit-input').fadeIn();
	        $('.basic-information .save-cancel-btn').fadeIn();
	    });
	    $('.basic-information .btn-cancel').on('click', function(event) {
	        event.preventDefault();
	        $('.basic-information .edit-input').fadeOut('fast');
	        $('.basic-information .save-cancel-btn').fadeOut('fast');
	        $('.basic-information .profile-value').fadeIn();
	    });

	    $('.employment-details .edit-profile-btn').on('click', function(event) {
	        event.preventDefault();
	        $('.employment-details .profile-value').fadeOut('fast');
	        $('.employment-details .edit-input').fadeIn();
	        $('.employment-details .edit-time').css({
	            "visibility": "visible"
	        });
	        $('.employment-details .save-cancel-btn').fadeIn();
	    });
	    $('.employment-details .btn-cancel').on('click', function(event) {
	        event.preventDefault();
	        $('.employment-details .edit-time').css({
	            "visibility": "hidden"
	        });
	        $('.employment-details .edit-input').fadeOut('fast');
	        $('.employment-details .save-cancel-btn').fadeOut('fast');
	        $('.employment-details .profile-value').fadeIn();
	    });

	    $('.government-information .edit-profile-btn').on('click', function(event) {
	        event.preventDefault();
	        $('.government-information .profile-value').fadeOut('fast');
	        $('.government-information .edit-input').fadeIn();
	        $('.government-information .save-cancel-btn').fadeIn();
	    });
	    $('.government-information .btn-cancel').on('click', function(event) {
	        event.preventDefault();
	        $('.government-information .edit-input').fadeOut('fast');
	        $('.government-information .save-cancel-btn').fadeOut('fast');
	        $('.government-information .profile-value').fadeIn();
	    });

	    $('.send-memo').on('click', function() {
	        var value = $(this).attr('data-value');
	        var name = $(this).attr('data-name');

	        $('#memo-to').attr('data-value', value);
	        $('#memo-to').val(name);


	        $('#createMemo').modal('show');
	    });

	    $('.sched-evaluation-btn').on('click', function() {
	        var value = $(this).attr('data-value');
	        var name = $(this).attr('data-name');

	        $('#evaluation-employee-id').attr('data-value', value);
	        $('#evaluation-employee-id').val(name);


	        $('#schedEvaluation').modal('show');
	    });

	    $('#sched-evaluation-create').on('click', function() {
	    	var name = $('#evaluation-to').val();
	        var data = {
	            employee_id: $('#evaluation-employee-id').attr('data-value'),
	            evaluation_name: $('#evaluation-name').val(),
	            evaluation_description: $('#evaluation-description').val(),
	            evaluation_from: $('#evaluation-from').val(),
	            evaluation_to: $('#evaluation-to').val()

	        }
	        $.post('/evaluations/save', data, function(res) {
	            $('#createMemo').modal('hide');
	            $.notify('Successfully scheduled '+ name+ '!', 'success');
	        });
	    });

	    $('#memo-create').on('click', function() {
	        var data = {
	            to: $('#memo-to').attr('data-value'),
	            message: $('#memo-message').val()
	        }
	        $.post('/memo/add', data, function(res) {
	            $('#createMemo').modal('hide');
	            $.notify('Memo Successfully Sent!', 'success');
	        });
	    });



	});
