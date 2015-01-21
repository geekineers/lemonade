  
<html >
    <head>
        <meta charset="UTF-8">
        <title>Payslip </title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
      <style>
        table {
  width:100%;

}
table thead {
  background-color:#DBDBDB;
  text-align:left;
}
table tr td {
  font-family:'calibri';
  padding-left: 20px;
  line-height: 20px;
}
table.bordered {
  width: 100%;
  /*float:right;*/
}
table.bordered thead {
  background-color:#DBDBDB
}
table tr{
  padding: 0;
  margin:0;
}
table.bordered tr td{
background-color:#F2F2F2;
  margin:0;
   padding-left: 20px;
}
        .address {
          max-width: 300px;
          float:right;
          font-size: 12px
        }
        .address p {
          text-align:right;

        }
        .slip{
          max-width: 600px;
        }
      </style>
    </head>
    <body >
    <div class="slip">
      <span style="position:absolute;right:0;">
        Employee's Copy
      </span>
      <table>
        <tr>
          <td>
            <h3><img src="../uploads/<?php echo $company->company_logo;?>" style="height:70px;"> </h3>
          </td>
          <td>
            <div class="address">
              <p>
<?php echo $company->company_address;?>
</p>
            </div>

          </td>
        </tr>
      </table>
<?php
$from = $payslip->getPayslipsGroup()->from;

$to = $payslip->getPayslipsGroup()->to;
?>
      <table style="font-size:12px">


        <tr>
          <td>EMP #</td>
          <td><?php echo $employee->employee_number;?></td>
          <td>PAYROLL PERIOD</td>
          <td><?php echo date('Y/m/d', strtotime($payslip->getPayslipsGroup()->from)); ?>-<?php echo date('Y/m/d', strtotime($payslip->getPayslipsGroup()->to)); ?></td>

        </tr>
        <tr>
          <td>NAME: </td>
          <td><?php echo $employee->first_name;
?> <?php echo $employee->last_name;
?> <?php echo $employee->middle_name;
?></td>
          <td>PAYROLL DATE</td>
          <td><?php echo $payslip->created_at?></td>
        </tr>
        <tr>
          <td>DESIGNATION</td>
          <td><?php echo $employee->getJobPosition();?></td>
          <td>PAYMENT MODE</td>
          <td><?php echo $payslip->getPayslipsGroup()->getPayrollGroup()->period?></td>
        </tr>

      </table>

      <div style="height: 10px; margin:10px 0px; background-color:black"></div>

<div style="width:49%;display: inline-block;">
   <table class="bordered" >
      <thead>
          <tr>
            <td  colspan="2">INCOME</td>
          </tr>
      </thead>



        <!-- foreach -->
          <tr>
            <td>&nbsp;&nbsp;Basic Salary <br><?php if($employee->getPayrollPeriod(false) == "Daily") { echo "PHP" . number_format($payslip->base_pay, 2) . " x " . $payslip->in_attendance . " days";  } ?></td>
            <td style="text-align:right;"><?php echo number_format($payslip->basic_pay, 2); ?></td>
          </tr>
          <?php if($payslip->sunday_attended_hours): ?>
            <tr>
            <td >&nbsp;&nbsp;Sunday(<?php echo $payslip->sunday_attended_hours; ?>hour(s))</td>
            <td style="text-align:right;">
              <?php echo number_format($payslip->sunday_pay, 2); ?>
            </td>
          </tr>
          <?php endif; ?>
          <?php if($payslip->overtime_hours): ?>
           <tr>
            <td >&nbsp;&nbsp;Overtime(<?php echo $payslip->overtime_hours; ?>hrs)</td>
            <td style="text-align:right;">
              <?php echo number_format($payslip->overtime_pay, 2); ?>
            </td>
          </tr>
          <?php endif; ?>

          <?php if($payslip->night_differential_hours){ ?> 
             <tr>
            <td >&nbsp;&nbsp;Night Differential Pay(<?php echo $payslip->night_differential_hours; ?> hrs)</td>
            <td style="text-align:right;">
              <?php echo number_format($payslip->night_differential_pay, 2); ?>
            </td>
          </tr>
          <?php } ?>
          <?php if($payslip->regular_holiday_count) { ?> 
             <tr>
            <td >&nbsp;&nbsp;Regular Holiday Pay(<?php echo $payslip->regular_holiday_count; ?> hour(s)) 
            <?php if($employee->getPayrollPeriod(false) == "Daily") { ?> + PHP<?php echo $employee->getCompany()->company_cola; ?> COLA(<?php echo $employee->getColaCount($from, $to); ?>) <?php } ?>
            </td>
            <td style="text-align:right;">
              <?php echo number_format($payslip->regular_holiday_pay, 2); ?>
            </td>
          </tr>
          <?php } ?>
          <?php if($payslip->special_holiday_count) { ?> 
             <tr>
            <td >&nbsp;&nbsp;Special Holiday Pay(<?php echo $payslip->special_holiday_count; ?> hour(s))</td>
            <td style="text-align:right;">
              <?php echo number_format($payslip->special_holiday_pay, 2); ?>
            </td>
          </tr>
          <?php } ?>
          <?php if($employee->getPayrollPeriod(false) == "Daily") { ?>
            <tr>
              <td style="text-align: right;">COLA x <?php echo $employee->getColaCount($from, $to, "normal_day"); ?></td>
              <td><?php echo $employee->getColaPay($from, $to, "normal_day"); ?></td>
            </tr>
            <tr>
              <td style="text-align: right;">SEA x <?php echo $employee->getSEACount($from, $to); ?></td>
              <td><?php echo $employee->getSEAPay($from, $to); ?></td>
            </tr>
          <?php } ?>
          <?php if($employee->getRestDayAttendance($from, $to, 'not_holiday') > 0) : ?>
          <tr>
            <td >&nbsp;&nbsp;Rest Day Pay(<?php echo $employee->getRestDayAttendance($from, $to, 'not_holiday'); ?> day(s))</td>
            <td style="text-align:right;">
              <?php echo number_format($employee->getRestDayPay($from, $to)['not_holiday'], 2); ?>
            </td>
          </tr>           
          <?php endif; ?>
       <?php if (count($payslip->getAllowances())) {?>

	<tr>
																								                        <td>Allowances</td>
																								                        <td></td>
																								                      </tr>
	<?php }?>
<?php foreach ($payslip->getAllowances() as $item) {
  // dd($item->amount);
      $allowance = Allowance::find($item->allowance_id);
      // if(count($allowance)) {continue;}
  ?>
      <tr>
        <?php if($allowance->frequency == "daily" && $from != null){ ?>
        <td style="text-align: right;">
              <?php echo $allowance->allowance_name . " X " . $payslip->in_attendance; ?></td>
        <td style="text-align: right;">
        <?php 
            $in_attendance = $payslip->in_attendance;
            $amount = (float) $item->amount * (int) $in_attendance; 
            echo number_format($amount, 2);
          ?>
        </td>
        <?php }
        else{
         ?>
         <td style="text-align: right;">
          <?php echo $allowance->allowance_name; ?>
         </td>
         <td style="text-align: right;">
          <?php echo number_format($item->amount, 2); ?>
         </td>
        <?php } ?>
      </tr>


	<?php }?>
<tr><td>&nbsp;
</td><td>&nbsp;
</td></tr>

          <tr><td>&nbsp;
</td><td>&nbsp;
</td></tr>

          <tr><td>&nbsp;
</td><td>&nbsp;
</td></tr>
          <tr>
            <td ><b style="padding:15px ;">Gross Pay</b></td>
            <td style="text-align:right;">
              <?php echo number_format($payslip->gross, 2); ?>
            </td>
          </tr>
        <!-- endforeach -->
   </table>
</div>

<div style="width:49%; display: inline-block; left:300px">
  <table class="bordered">
     <thead>
        <tr >
          <td  colspan="2">DEDUCTION</td>
        </tr>
      </thead>
         <tr>
          <td>Withholding Tax</td>
          <td style="text-align:right;"><?php echo number_format($payslip->withholding_tax, 2); ?></td>
        </tr>



        <tr>
          <td>SSS</td>
          <td style="text-align:right;"><?php echo number_format($payslip->sss, 2); ?></td>
        </tr>
        <tr>
          <td>HDMF</td>
          <td style="text-align:right;"><?php echo number_format($payslip->pagibig, 2); ?></td>
        </tr>
        <tr>
          <td>Philhealth</td>
          <td style="text-align:right;"><?php echo number_format($payslip->philhealth, 2)?></td>
        </tr>

         <tr>
          <td>Absent(<?php echo $employee->getAbsent($from, $to) . " days"; ?>)</td>
          <td style="text-align:right;"><?php echo $employee->getAbsentDeduction($from, $to, false, true);
?></td>
        </tr>
         <tr>
          <td>Late Deduction(<?php echo $employee->getLateDeduction($from, $to, 'hour').'hrs'; ?>)</td>
          <td style="text-align:right;" ><?php echo $employee->getUnderTimeAndLateDeduction($from, $to, 'minute', true);
?></td>
        </tr>


             <!-- foreach -->
<?php if (count($employee->getDeductions())) {?>
	<tr>
																																	          <td>Others</td>
																																	          <td></td>
																																	        </tr>
	<?php }?>
<?php foreach ($employee->getDeductions($from, $to) as $deduction) {?>
																																										          <tr>
																																										            <td style="text-align:right;" ><?php echo $deduction->getName();
	?></td>
																																										            <td style="text-align:right;" ><?php echo $deduction->getAmount(true);
	?></td>
																																										          </tr>
	<?php }?>

          <tr>
          <td><b style="padding:15px ;">Total Deduction</b></td>

          <td style="text-align:right;"><?php echo number_format($payslip->total_deduction_pay,2); ?></td>
        </tr>

      <!-- end -->
  </table>

</div>


    <table style="width:100%;top:250px;">
      <tr>
        <td style="background-color:black; color:white;">NET</td>
        <td style="background-color:black; color:white; font-size:18px; text-align:right;" ><?php echo number_format($payslip->net, 2); ?></td>
      </tr>
    </table>

    <table class="bordered" style="margin-top:30px;background-color:#DBDBDB;bottom:200px;">
      <thead>
         <tr>
           <td>Prepared By</td>
        </tr>
        <tr>
          <td><?php echo $payslip->getPayslipsGroup()->getPreparedBy();?></td>
        </tr>
      </thead>

     </table








  </div>
    </body>
</html>
