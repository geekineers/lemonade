<html>
<head>
  <meta charset="utf-8">
  <title>Master List</title>
  <style>
   body{
      font-family:'Source Sans Pro', sans-serif;
    } 
    .masterlist{
          position:absolute;
          right:0;
      }
    .container {
        margin: 0 auto;
        font-size:10px;
    }
    .container table{
      border-collapse: collapse;
    }
    .container table thead{
       margin:0;
      

    }
    .container table thead th {
      text-align:center;
      padding: 0px 10px;
      margin:0;
      font-family:'Source Sans Pro', sans-serif;
    }
    .container table tr td {
      padding: 0px 5px;
    }
    .container table tbody tr:nth-child(odd){
      background-color:#DBDBDB;
    }
  </style>
</head>
<body>
  <img width="150"src="../uploads/<?php echo $company_logo; ?>" alt="">
  <span class="masterlist">Employee's Masterlist</span>
  <div>
    <center>
      <h2><?php echo date('M d Y', strtotime($from)) .' to '. date('M d Y', strtotime($to)) ?></h2>
      <span><?php echo $period->getPayrollGroup()->period ?> </span>
    </center>

  </div>
  <div class="container">
    <table>
       <thead>
        <tr>
           <th>Position</th>
           <th>Emp. No. </th>
           <th>Employee Name </th>
           <th>Monthly Salary</th>
           <th>Semi-Monthly Salary</th>
           <th>Daily Rate</th>
           <th>Tax Status</th>
           <th>Allowance</th>
           <th>Gross</th>
           <th>SSS</th>
           <th>PHILHEALTH</th>
           <th>Pag-ibig</th>
           <th>In Attendance</th>
           <th>Absent</th>
           <th>Late</th>
           <th>Under Time</th>
           <th>Misc Deductions</th>
           <th>Tax</th>
           <th>Net</th>
        </tr>
       </thead>
       <tbody>
       <?php $a = 0; ?>
       <?php $b = 0; ?>
       <?php $c = 0; ?>
       <?php $d = 0; ?>
       <?php $e = 0; ?>
       <?php $f = 0; ?>
        <?php foreach ($payslips as $payslip ) : ?>
          <?php $a += (float)  $payslip->getEmployee()->getAbsentDeduction($from, $to, false); ?>
          <?php $b += (float)  $payslip->getEmployee()->getLateDeduction($from, $to, 'minute'); ?>
          <?php $c += (float)  $payslip->getEmployee()->getUnderTimeDeduction($from, $to, 'minute'); ?>
          <?php $d += (float)  $payslip->getEmployee()->getTotalDeductions($from, $to, 'minute'); ?>
          <?php $e += (float)  $payslip->getEmployee()->getWithholdingTax($from,$to); ?>
          <?php $f += (float)  str_replace(',', $payslip->getEmployee()->getNet($from, $to)); ?>
           <tr>
             <td><?php echo $payslip->getEmployee()->getJobPosition(); ?></td>
             <td><?php echo $payslip->getEmployee()->id; ?></td>
             <td><?php echo $payslip->getEmployee()->getName(); ?></td>
             <td><?php echo $payslip->getEmployee()->getMonthlyRate(true); ?></td>
             <td><?php echo $payslip->getEmployee()->getSemiMonthlyRate(true); ?></td>
             <td><?php echo $payslip->getEmployee()->getDailyRate(); ?></td>
             <td><?php echo $payslip->getEmployee()->getTaxStatus(); ?></td>
             <td><?php echo $payslip->getEmployee()->getTotalAllowances($from,$to); ?></td>
             <td><?php echo $payslip->getEmployee()->getGross($from, $to); ?></td>
             <td><?php echo $payslip->getEmployee()->getSSSValue(true); ?></td>
             <td><?php echo $payslip->getEmployee()->getPhilhealthValue(true);?></td>
             <td><?php echo $payslip->getEmployee()->getHDMFValue(true); ?></td>
             <td><?php echo $payslip->getEmployee()->getInAttendance($from, $to, false); ?></td>
             <td><?php echo $payslip->getEmployee()->getAbsentDeduction($from, $to, false, true); ?></td>
             <td><?php echo $payslip->getEmployee()->getLateDeduction($from, $to, 'minute', true);?></td>
             <td><?php echo $payslip->getEmployee()->getUnderTimeDeduction($from, $to, 'minute', true);?></td>
             <td><?php echo $payslip->getEmployee()->getTotalDeductions($from, $to, 'minute'); ?></td>
             <td><?php echo $payslip->getEmployee()->getWithholdingTax($from,$to,true); ?></td>
             <td><?php echo $payslip->getEmployee()->getNet($from, $to); ?></td>
           </tr>
        <?php endforeach;  ?>
           <tr>
            <td colspan="1"></td>
             <td colspan="1"></td>
             <td colspan="1"></td>
             <td colspan="1"></td>
             <td colspan="1"></td>
             <td colspan="1"></td>
             <td colspan="1"></td>
              <td colspan="1"></td>
             <td colspan="1"></td>
             <td colspan="1"></td>
             <td colspan="1"></td>
             <td colspan="1"></td>
             <td colspan="1"></td>
             <td><?php echo number_format($a, 2); ?></td>
             <td><?php echo number_format($b, 2); ?></td>
             <td><?php echo number_format($c, 2); ?></td>
             <td><?php echo number_format($d, 2); ?></td>
             <td><?php echo number_format($e, 2); ?></td>
             <td><?php echo number_format($f, 2); ?></td>
           </tr>        
       </tbody>
    </table>
  </div>
</body>
</html>