$(document).ready(function(){
	
	var approve = function(){
		var $this = $(this).parent().parent();
		var data = {
			'id' : $this.attr('id'),
			'sequence' : $this.children().data('sq'),
			'status' : $this.children().data('status'),
			'leave_id': $this.children().data('leave')	
		}
		$.get('/notification/form-approve',data,function(res){
			$.notify('approve','success');
			window.location.reload();	
		});
	}
	$.get('/notification/form-notification',function(res) {
		var notification = $('.notifications-menu');

		notification.find('.number').text(res.length);

		$.each(res,function(i,e){
			parent = $('<li/>',{class:'menu',id:e.id});
			parent.append(' <a href="/forms" data-leave="'+e.leave_id+'" data-status="'+e.status+'" data-sq="'+e.leave_type_approval_sequence +'"><i class="ion ion-ios7-people info"></i> '+e.employee_name+ ' is requesting ' + e.leave_type_name + '<span class="btn btn-sm btn-default approve" style="position:absolute;right:0">approve</span> </a>' );
				

			notification.find('.menu').append(parent);
			notification.find('.menu li .approve').click(approve);	
		});
		// <li>
	 //        <a href="#">
	 //            <i class="ion ion-ios7-people info"></i> 5 new members joined today
	 //        </a>
	 //    </li>
	})

	$('#holiday_select').on('change', function (){
		// alert($(this).val());
		if($(this).val() == "others"){
			$('#holiday_input').val('').fadeIn();
		}
		else{
			$('#holiday_input').val('').fadeOut();
		}
	});

	$('.announcement-modal').on('click',function(){
		$('#view-announcment').modal('show');
		$('#view-announcment .box').loading(true);
		var id = $(this).data('id');
		$elem = $(this);
		$.get('dashboard/announcement-rest',{id:id},function(res){
			$('#view-announcment .box').loading(false);	
			$('#view-announcment').find('.word').text(res.content);
			$('#view-announcment').find('.title').text(res.title);
		});
	});
	
	$('.announcement .delete').on('click',function(){
		var conf = confirm('delete this announcement');
		var elem = $(this).parent().parent();
		var id = $(this).data('id');
			
		if(conf){
			$.post('dashboard/delete-announcement',{'id': id},function(res){
				if(res.status=="ok"){
					$.notify('announcement deleted','success');
					elem.remove();
				}else{
					$.notify('error in deleting contact your administrator','error');
				}
			});
		}
	});
	$('.memo .delete').on('click',function(){
		var conf = confirm('delete this memo');
		var elem = $(this).parent().parent();
		var id = $(this).data('id');console.log(id);
		if(conf){
			$.post('dashboard/delete-memo',{'id': id},function(res){
				if(res.status=="ok"){
					$.notify('memo deleted','success');
					elem.remove();
				}else{
					$.notify('error in deleting contact your administrator','error');
				}
			});
		}
	});

	// Search 
	$('.search').on('keyup', function(){
		var data = $(this).val();
		var url = $(this).attr('data-url');
		$.get(url, {search : data}, function(response){
			$('table').html(response);
		});

	});	

	$('.select_all').on('click', function(event){
		// event.preventDefault();
		
		if( $(this).is(':checked') ) {
			$('.flat-red').attr('checked', true);		
		}
		else{
			$('.flat-red').attr('checked', false);		
		}
	});

	$('#create_user').on('click', function(event){
		// event.preventDefault();
		
		if( $(this).is(':checked') ) {
			$('.user-account-form').fadeIn();		
		}
		else{
			$('.user-account-form').fadeOut();
		}
	});

	$('.datepicker').datepicker({
		format: 'yyyy-mm-dd'
	});

	$('select.employee-sched').change(function(){
       var selected = $(this).find('option:selected');
       var timestart = selected.data('timestart'); 
       var timeend = selected.data('timeend'); 
       // alert(timeend);
	   $('#timestart').val(timestart);
	   $('#timeend').val(timeend);
	 });
	
	$('.combobox').combobox({bsVersion: '3'});


	$.fn.loading = function(options){
		option = typeof options == "undefined" ? true : options;
	
		if(option){
			$(this).append($('<div/>',{class:'loading-img'})).append($('<div/>',{class:'overlay'}));
			return option;
		}else{
			$('.overlay,.loading-img').remove();
			return false;
		}
	};
	$('.change-profile-picture').on('click', function(){
		$('#changeProfilePic').modal('show');
	});
	$('.profile-photo').mouseenter(function(){

		$('.change-profile-picture').fadeIn();
	}).mouseleave(function(){

		$('.change-profile-picture').fadeOut();
	});
	
	    $('.timepicker').timepicker();

        $('.contact-info .edit-profile-btn').on('click', function(event) {
	        event.preventDefault();
	        $('.contact-info .profile-value').fadeOut('fast');
	        $('.contact-info .edit-input').fadeIn();
	        $('.contact-info .save-cancel-btn').fadeIn();
	    });


	    $('.contact-info .btn-cancel').on('click', function(event) {
	        event.preventDefault();
	        $('.contact-info .edit-input').fadeOut('fast');
	        $('.contact-info .save-cancel-btn').fadeOut('fast');
	        $('.contact-info .profile-value').fadeIn();
	    });

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


	    $('.form-contributions .edit-profile-btn').on('click', function(event) {
	        event.preventDefault();
	        $('.form-contributions .profile-value').fadeOut('fast');
	        $('.form-contributions .edit-input').fadeIn();
	        $('.form-contributions .save-cancel-btn').fadeIn();
	    });
	     $('.form-contributions .btn-cancel').on('click', function(event) {
	        event.preventDefault();
	        $('.form-contributions .edit-input').fadeOut('fast');
	        $('.form-contributions .save-cancel-btn').fadeOut('fast');
	        $('.form-contributions .profile-value').fadeIn();
	    });

	    $('.credits .btn-cancel').on('click', function(event) {
	        event.preventDefault();
	        $('.credits .edit-input').fadeOut('fast');
	        $('.credits .save-cancel-btn').fadeOut('fast');
	        $('.credits .profile-value').fadeIn();
	    });
	     $('.credits .btn-cancel').on('click', function(event) {
	        event.preventDefault();
	        $('.credits .edit-input').fadeOut('fast');
	        $('.credits .save-cancel-btn').fadeOut('fast');
	        $('.credits .profile-value').fadeIn();
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

	      $('.edit-btn').on('click', function(event) {
	        event.preventDefault();
	        $(this).fadeOut('fast');
	        $('.profile-value').fadeOut('fast');
	        $('.edit-input').fadeIn();
	        $('.edit-time').css({
	            "visibility": "visible"
	        });
	        $('.save-cancel-btn').fadeIn();
	    });

	    $('.employee_batch').on('click', function(){
			$('#batchUpload').modal('show');
		});

	$('.view-training').on('click', function(){
		var name = $(this).attr('data-name');
		var description = $(this).attr('data-description');
		var status = $(this).attr('data-status');
		var from = $(this).attr('data-from');
		var to = $(this).attr('data-to');

		$('#training-name').html(name);
		$('#training-description').html(description);
		$('#training-from').html(from);
		$('#training-to').html(to);
		if(status == 'scheduled'){
			$('#training-status-scheduled').css({display : 'blocked'});			
			$('#training-status-completed').css({display : 'none'});
		
		}
		else{
			$('#training-status-completed').css({display : 'blocked'});
			$('#training-status-scheduled').css({display : 'none'});
		}

		$('#viewTraining').modal('show');

	});

});
