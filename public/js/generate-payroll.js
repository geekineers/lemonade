(function($){

	var from,
		to, 
		alerttpl;

	alerttpl = '<div class="alert alert-info alert-dismissable loading">  '+
                        '<i class="fa fa-refresh fa-spin"></i> '+
                        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+
                        '<b></b> Loading...'+
                   '</div>'; 

/*
   	Object Controller
   	for Payroll
*/
	var payrollGenerationEvents = {

		 getEndMidDate : function (from,to) {

			var date = moment([new Date().getFullYear(), 0, to]).add('months', from).format('YYYY-MM-DD');

			return date;

		 },

		 onBranchChange : function(  ) {
		
			var $this = this, group_string = "";

			$( '#generate-modal .modal-body' ).loading( true );

			$.get( '/payroll/rest-payroll-group' ,{ id: $( $this ).val() } , function( res  ) {

				group_string = '<option value="none" data-period="none">--Select Payroll Group --</option>';
				
				$.each(res,function(i,s,a){

					group_string+= '<option value='+s.id+' data-period='+s.period+'>'+s.group_name+'</option>';
				
				});

				$('#generate-modal .modal-body').loading(false);
				
				$('#group_name').html(group_string);
			
			}); 

			// $.get('/api/employees', {branch : $( $this ).val() }, function(res){

			// 	options = '<option value="none" data-period="none">--Select Employee --</option>';
				
			// 	res.forEach(function(element, index, array) {
   // 								var row_temp = '<option value="id">name</option>';

   // 								row_temp = row_temp.replace('id', element.id, 'gi');
   // 								row_temp = row_temp.replace('name', element.name, 'gi');

   // 								options += row_temp;
   // 							});


			// 	$('#employee_name').html(options);
			// });

			return true;
		},

		onGroupNameChange : function(elem){
		
			var $this = this;
			from = null,to  = null;
			if($( $this ).find('option:selected').data('period')=='Semi-monthly')
			{
				$('.daily').addClass('hide');
				$('.semi').removeClass('hide');
				var date_string = "";
				
				for( var number_month = 0 ; number_month < 12 ; number_month++ ) {
					date_string += '<option value='+payrollGenerationEvents.getEndMidDate(number_month,15)+' data-from="'+payrollGenerationEvents.getEndMidDate(number_month,1)+'" data-to="'+payrollGenerationEvents.getEndMidDate(number_month,15)+'" >'+ payrollGenerationEvents.getEndMidDate(number_month,15)+'</option>'+
								   '<option value='+payrollGenerationEvents.getEndMidDate(number_month,31)+' data-from="'+payrollGenerationEvents.getEndMidDate(number_month,16)+'" data-to="'+payrollGenerationEvents.getEndMidDate(number_month,31)+'">'+ payrollGenerationEvents.getEndMidDate(number_month,31)+'</option>';
				}

				$('#daterange').html(date_string);

			}else if( $($this).find('option:selected').data('period')=='Monthly'){
				$('.daily').addClass('hide');
				$('.semi').removeClass('hide');
				var date_string = "";
				
				
				for( var number_month = 0 ; number_month < 12 ; number_month++ ) {
					date_string += '<option value='+payrollGenerationEvents.getEndMidDate(number_month,31)+' data-from="'+payrollGenerationEvents.getEndMidDate(number_month,1)+'" data-to="'+payrollGenerationEvents.getEndMidDate(number_month,31)+'">'+payrollGenerationEvents.getEndMidDate(number_month,31)+'</option>';
				}
			
				$('#daterange').html(date_string);
			
			}else if($($this).find('option:selected').data('period')=='Daily'){
				$('.semi').addClass('hide');
				$('.daily').removeClass('hide');
			}
		},

		generatePayroll : function(){
			from = $('#daterange').find('option:selected').data('from') || from;
			to = $('#daterange').find('option:selected').data('to') || to;
			var start = moment(from).format('YYYY-MM-DD'),
				  end = moment(to).format('YYYY-MM-DD');
			
			var group_name = $('#group_name').val();
			var employee_name = $('#employee_name').val();
			var data = {
				'group_name' : group_name,
				'employee_name' : employee_name,
				'from' : start,
				'to'   : end
			};
			
			$('#generate-modal .modal-body').prepend(alerttpl);
			$('#generate-payroll').html('Generating ....')
								  .attr('disabled', true);

			$('#generate-close').html('Close')
								  .attr('disabled', true);
								  
					  

			$.post('/payroll/payslip/generate',data,function(res){
				console.log(res);
				var res = JSON.parse(res);
					$('#generate-payroll').html('Generate')
								  .attr('disabled', false);

					$('#generate-close').html('Close')
								  .attr('disabled', false);


				if(res.status == 'fail'){
					$.notify('Generation failed there is an existing data of payroll found','error');
					$('#generate-modal').modal('hide')

				


					$('.loading').remove();
				}else if(res.status=='success'){
					$.notify('Payroll generated','success');
					window.location.reload();
				}
				
			})
		},

		delete : function(){
			$id = $(this).data('id');
			$confirm = confirm('this will delete all payslips. are you sure?');
			if($confirm){
				$.post('/payroll/payslip/delete',{id:$id},function(res){
				
						$.notify('This group of payslip has been deleted','success');
						window.location.reload();
					
				});
			}
		}

	}


	/*
		Events
		Identifyers
	*/

	$( '#branch' ).change( payrollGenerationEvents.onBranchChange );
	// $('#group_name').change( payrollGenerationEvents.onGroupNameChange );
	$('#generate-payroll').on('click',function(){
		var branch = $('#branch').val();
		var group_name = $('#group_name').val();
		var payrolltime = $('#payrolltime').val();
		
		if(branch=="Select Branch" || branch == "" || group_name == "Select Group" || group_name == "" || payrolltime== ""){
			alert('Fill up all fields');
			return null;
		}

		payrollGenerationEvents.generatePayroll(); 
	});
	
	$('.delete').on('click',payrollGenerationEvents.delete );
	

	$('#payrolltime').daterangepicker({format: 'YYYY-MM-DD'}, function(start, end, label){
		from = start;
		to = end;
	});
	
	$('#group').dataTable({
        "bPaginate": true,
        "bFilter": true,
        "bSort": true,
        "bInfo": true,
        "bAutoWidth": false
    });

})(jQuery);


