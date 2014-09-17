<div class="box box-primary ob">
    <div class="box-header">
        <h3 class="box-title">Leave Form</h3>
    </div><!-- /.box-header -->
    <div class="box-body">    
        <?php if($remaining<=0) { ?>
            
            no credits remaining

        <?php } else { ?>
       
            <form action="/settings/forms" method="post" class="ob_form">
                     Remaining Credits: <?php echo $remaining;?>
                    <div class="form-group row">
                        <div class="col-md-10 ">
                            <label>Start / End Date: </label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                                <input type="text" class="form-control pull-right time" >
                            </div>
                        </div>
                        <div class="col-md-2 ">
                            <label>No of Days: </label>
                            <input type="number" class="form-control no_of_days" class="total-hours" placeholder="" value="0">
                        </div>
                        <div class="col-md-12 ">
                            <label>Reason: </label>
                            <input type="text" class="form-control reason" placeholder="example:heavy rain etc">
                        </div>
                        <div class="col-md-2 ">
                            <label>Type of leave: </label>
                            <select required name="department" class="form-control type_of_leave"  placeholder="">
                                <option value="" disabled selected>select type of leave</option>
                                <option value="vl">Vacation Leave</option>
                                <option value="sl">Sick Leave</option>
                                <option value="ab">Absent</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Remaning credits: </label>
                            <input type="number" class="form-control remaining" placeholder="example: 7">
                          
                        </div>


                    </div>

                    <div class="form-group row">
                          <div class="col-md-12">
                            <button class="btn btn-success .submit">Submit</button>
                          </div>
                    </div>
            </form>
         <?php } ?>
        </div>
    </div>

<script src="/js/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
<script src="/js/plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
<script src="/js/plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>
<script type="text/javascript"  src="/js/plugins/daterangepicker/daterangepicker.js" ></script>
<script type="text/javascript">
  (function(){
    var from,to,total_hrs;
    $('input').inputmask();
    $('.time').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'},function(start,end,label){
        var second = 1000, minute = 60 * second, hour = 60 * minute, day = 24 * hour;
        var seconds = new Date(end.format("YYYY-MM-DD HH:mm:ss")).getTime() - new Date(start.format("YYYY-MM-DD HH:mm:ss")).getTime();
        var hours = Math.floor(seconds/ hour);
        total_hrs = hours;
        from = start.format("YYYY-MM-DD HH:mm:ss");
        to = end.format("YYYY-MM-DD HH:mm:ss");
        $('.no_of_days').val(hours/24);
    });

    $('form.ob_form').submit(function(e){
      e.preventDefault();
      $('.ob').loading();
      var data = {
        'employee_id' : $('#employee_name').val(),
        'date' : moment().format("YYYY-MM-DD"),
        'from' : from,
        'to'  : to ,
        'form_type' : 'leave',
        'form_data' : {
            reason : $('.reason').val(), 
            type_of_leave : $('.type_of_leave').val(),
            no_of_days : $('.no_of_days').val(),
            remaining_credits : $('.remaining').val(), 
        }
      };
      if($('#employee_name').val()=="" || $('#employee_name').val()==null){
                  $('#employee_name').parent().addClass('has-error');
                   $('.ob').loading(false);
        }else{
            $('#employee_name').parent().removeClass('has-error');
          $.post('/forms/save-form',data,function(response){
             $('.ob').loading(false);
            if(response.status==0){
                $.notify('Cannot be summited. contact your hr','error');
            }
            else if(response.status==1){
                $.notify('Form Submitted','success');
                 window.location.href = "/forms/application";
            }
          });
        }
    });
  })();
</script>