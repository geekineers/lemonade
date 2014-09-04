<div class="box box-primary ob">
    <div class="box-header">
        <h3 class="box-title">Undertime Form</h3>
    </div><!-- /.box-header -->
    <div class="box-body">    
            <form action="/settings/forms" method="post" class="ob_form">
                  Remaining Credits: <?php echo $remaining;?>
                    <div class="form-group row">
                        <div class="col-md-2 ">
                            <label>Date  </label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control dates">
                            </div>
                        </div>
                        <div class="col-md-2 ">
                            <label>Start time </label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control timepicker start_time">
                            </div>
                        </div>
                        <div class="col-md-2 ">
                            <label>Ends time </label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control timepicker end_time">
                            </div>
                        </div>
                       <div class="col-md-5">
                            <label>Reason: </label>
                            <input type="text" class="form-control reason" placeholder="example: Juan Dela Cruz">
                          
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
<script src="/js/bootstrap-datepicker.js" type="text/javascript"></script>
<script src="/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
<script type="text/javascript"  src="/js/plugins/daterangepicker/daterangepicker.js" ></script>
<script type="text/javascript">
  // (function(){
     $('#employee_name').parent().removeClass('has-error');
    var from = moment().format("YYYY-MM-DD HH:mm:ss"),
        to = moment().format("YYYY-MM-DD HH:mm:ss"),
        total_hrs = 0;
    $('input').inputmask(); 
    $('.timepicker').timepicker({
                    showInputs: true
                });
    $('.dates').datepicker();

    $('.start_time').on('change',function(){
        $start = $(this).val();
        
        from = moment(moment($('.dates'),'MM/DD/YYYY').format("YYYY-MM-DD") + ' ' +  $start ,"YYYY-MM-DD HH:mm A").format("YYYY-MM-DD HH:mm:ss");
    });
    $('.end_time').on('change',function(){
        $end = $(this).val();
        to = moment(moment($('.dates'),'MM/DD/YYYY').format("YYYY-MM-DD") + ' ' +  $end ,"YYYY-MM-DD HH:mm A").format("YYYY-MM-DD HH:mm:ss");
    });
    // $('.time').daterangepicker({datePicker:false,timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'},function(start,end,label){
    //     var second = 1000, minute = 60 * second, hour = 60 * minute, day = 24 * hour;

    //     var seconds = new Date(end.format("YYYY-MM-DD HH:mm:ss")).getTime() - new Date(start.format("YYYY-MM-DD HH:mm:ss")).getTime();
    //     var hours = Math.floor(seconds / hour);
    //     total_hrs = hours;
    //     from = start.format("YYYY-MM-DD HH:mm:ss");
    //     to = end.format("YYYY-MM-DD HH:mm:ss");
    //     $('.total_hrs').val(hours);
    // });
  
    $('form.ob_form').submit(function(e){
        e.preventDefault();
        $('.ob').loading();
           var data = {
                    'employee_id' : $('#employee_name').val(),
                    'date' : moment().format('YYYY-MM-DD'),
                    'from' : from,
                    'to'  : to ,
                    'form_type' : 'undertime',
                    'form_data' : {
                      reason : $('.reason').val(),
                      remarks : $('.remarks').val()
                }
            };
            // console.log(data);
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
  // })();
</script>