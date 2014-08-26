<div class="box box-primary ob">
    <div class="box-header">
        <h3 class="box-title">Overtime Form</h3>
    </div><!-- /.box-header -->
    <div class="box-body">    
            <form action="/settings/forms" method="post" class="ob_form">
                
                    <div class="form-group row">
                        <div class="col-md-2 ">
                            <label>Effective Date: </label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label>Reason: </label>
                            <input type="text" class="form-control reason" placeholder="example: Juan Dela Cruz">
                          
                        </div>
                        <div class="col-md-4 ">
                            <label>Overtime: </label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                                <input type="text" class="form-control pull-right time" >
                            </div>
                        </div>
                    </div>
                     <div class="form-group row">
                        <div class="col-md-2 ">
                            <label>Overtime Total hrs: </label>
                            <input type="text" class="form-control total_hrs" class="total-hours" placeholder="" value="0">
                        </div>
                        <div class="col-md-2 ">
                            <label>Remarks: </label>
                            <input type="text" class="form-control remarks" placeholder="example: Juan Dela Cruz">
                        </div>


                    </div>

                    <div class="form-group row">
                          <div class="col-md-12">
                            <button class="btn btn-success .submit">Submit</button>
                          </div>
                    </div>
            </form>
        </div>
    </div>

<script src="/js/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
<script src="/js/plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
<script src="/js/plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>
<script type="text/javascript"  src="/js/plugins/daterangepicker/daterangepicker.js" ></script>
<script type="text/javascript">
  (function(){
     $('#employee_name').parent().removeClass('has-error');
    var from,to,total_hrs;
    $('input').inputmask(); 
    $('.time').daterangepicker({datePicker:false,timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'},function(start,end,label){
        var second = 1000, minute = 60 * second, hour = 60 * minute, day = 24 * hour;

        var seconds = new Date(end.format("YYYY-MM-DD HH:mm:ss")).getTime() - new Date(start.format("YYYY-MM-DD HH:mm:ss")).getTime();
        var hours = Math.floor(seconds/ hour);
        total_hrs = hours;
        from = start.format("YYYY-MM-DD HH:mm:ss");
        to = end.format("YYYY-MM-DD HH:mm:ss");
        $('.total_hrs').val(hours);
    });

    $('form.ob_form').submit(function(e){
      e.preventDefault();
      $('.ob').loading();
      var data = {
        'employee_id' : $('#employee_name').val(),
        'date' : moment($('.date').val(),"YYYY-MM-DD").format('YYYY-MM-DD'),
        'from' : from,
        'to'  : to ,
        'form_type' : 'ot',
        'form_data' : {
            reason: $('.reason').val(),
            total_hrs :  $('.total_hrs').val(),
            remarks : $('.remarks').val()
        }
      };
    
    if($('#employee_name').val()=="" || $('#employee_name').val()==null){
            $('#employee_name').parent().addClass('has-error');
             $('.ob').loading(false);
        }else{
            $('#employee_name').parent().removeClass('has-error');
          $.post('forms/save-form',data,function(response){
            $('.ob').loading(false);
            console.log(response);
            
            window.location.href = "hr";
          });
        }
    });
  })();
</script>