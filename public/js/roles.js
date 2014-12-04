// roles function 
var roles = (function($){

	// scope variable
	var positionList = [];
	var rolesController = {
		 /*
		 	@selectAddToList  'will select and add the position to list'
		 	var position (string)
		 	var list ( dom instance )
		 */
		selectAddToList : function(){
	
			var position = $('.select_position').find('option:selected');

			var list = $( '.select_position_list' );

			var element = $('<li/>').text( position.text() ).val( position.val() ) ;

			positionList.push( element );
			// remove all item in dom
		
			window.positionList = positionList;
	
				// append element to $( '.select_position_list' );
			list.append(element);
			// append element delete to li dom
			element.append(  $('<i/>',{ class : 'fa fa-trash-o delete_role_list'}) );
			element.find('i').click( roles.deleteInList );
		
			// return [object]
			return positionList; 
		},

		deleteInList : function(){

			var $this = $(this).parent();

			$this.remove();
		},

		getList : function(){

			var list = $( '.select_position_list' ).find('li');
			
			var  array = [];

			$.each(list, function( i , e ) {

				array[i] = e.value;
			
			});

			return array;
		
		},
		submitList : function(e){


			e.preventDefault();
			var data = {
				'leave_type_name' : $('#leave_type_name').val() , 
				'leave_type_approval_sequence' :  $('#leave_type_approval_sequence').val()  ,
				'leave_type_required_approval' : roles.getList() ,
				'leave_type_base_points' : $('#leave_type_base_points').val() ,
				'leave_type_points_earning'  :  $('#leave_type_points_earning').val() 
			};

			$.post('/settings/leave-types/submit',data,function(res){
				if(res.status == 'success'){
					$.notify('successfully added' ,'success');
					window.location.reload();
				}else if(res.status == 'error'){
					$.notify('error encountered while posting your request' ,'error');
				}
			}).fail(function() {
			    $.notify('error encountered while posting your request' ,'error');
			});
		}

	
	};
	return rolesController;
})(jQuery);

/*
	Event must be added here
*/
$('.submit').on('click', roles.submitList );
$( '.select_position_add' ).on('click', roles.selectAddToList );
