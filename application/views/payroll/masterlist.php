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
   <?php  $total_it = 0; ?>
    <?php foreach ($payslips as $index => $payslip ): ?>
        <h1>Department: <?php echo $payslip['name']; ?></h1>
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
          <?php $total_per_dep = 0; ?>
          <?php foreach ($payslip['items'] as $key => $item) : ?>

          <?php $a = 0; ?>
          <?php $b = 0; ?>
          <?php $c = 0; ?>
          <?php $d = 0; ?>
          <?php $e = 0; ?>
          <?php $f = 0; ?>
          <?php $a += (float)  $item->getEmployee()->getAbsentDeduction($from, $to, false); ?>
          <?php $b += (float)  $item->getEmployee()->getLateDeduction($from, $to, 'minute'); ?>
          <?php $c += (float)  $item->getEmployee()->getUnderTimeDeduction($from, $to, 'minute'); ?>
          <?php $d += (float)  $item->getEmployee()->getTotalDeductions($from, $to, 'minute'); ?>
          <?php $e += (float)  $item->getEmployee()->getWithholdingTax($from,$to); ?>
          <?php $f  = (float)  str_replace(',', "", $item->getEmployee()->getNet($from, $to)); ?>
                
            <?php $total_per_dep += (float) $f; ?>
            <tr>
              <td><?php echo $item->getEmployee()->getJobPosition(); ?></td>
              <td><?php echo $item->getEmployee()->id; ?></td>
              <td><?php echo $item->getEmployee()->getName(); ?></td>
              <td><?php echo $item->getEmployee()->getMonthlyRate(true); ?></td>
              <td><?php echo $item->getEmployee()->getSemiMonthlyRate(true); ?></td>
              <td><?php echo $item->getEmployee()->getDailyRate(); ?></td>
              <td><?php echo $item->getEmployee()->getTaxStatus(); ?></td>
              <td><?php echo $item->getEmployee()->getTotalAllowances($from,$to); ?></td>
              <td><?php echo $item->getEmployee()->getGross($from, $to); ?></td>
              <td><?php echo $item->getEmployee()->getSSSValue(true); ?></td>
              <td><?php echo $item->getEmployee()->getPhilhealthValue(true);?></td>
              <td><?php echo $item->getEmployee()->getHDMFValue(true); ?></td>
              <td><?php echo $item->getEmployee()->getInAttendance($from, $to, false); ?></td>
              <td><?php echo $item->getEmployee()->getAbsentDeduction($from, $to, false, true); ?></td>
              <td><?php echo $item->getEmployee()->getLateDeduction($from, $to, 'minute', true);?></td>
              <td><?php echo $item->getEmployee()->getUnderTimeDeduction($from, $to, 'minute', true);?></td>
              <td><?php echo $item->getEmployee()->getTotalDeductions($from, $to, 'minute'); ?></td>
              <td><?php echo $item->getEmployee()->getWithholdingTax($from,$to,true); ?></td>
              <td><?php echo $f; ?></td>   
            </tr>
        <?php endforeach; ?>      
     <!--        <tr>
              <td colspan="1"> </td>
              <td colspan="1"> </td>
              <td colspan="1"> </td>
              <td colspan="1"> </td>
              <td colspan="1"> </td>
              <td colspan="1"> </td>
              <td colspan="1"> </td>
              <td colspan="1"> </td>
              <td colspan="1"> </td>
              <td colspan="1"> </td>
              <td colspan="1"> </td>
              <td colspan="1"> </td>
              <td colspan="1"> </td>
              <td colspan="1"> </td>
              <td colspan="1"> </td>
              <td colspan="1"> </td>
              <td colspan="1"> </td>
              <td colspan="1"> </td>
            </tr> -->
            <tr>
              <td style="font-weight: bold">Total:</td>
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
              <td style="font-weight: bold"><?php echo number_format($a, 2); ?></td>
              <td style="font-weight: bold"><?php echo number_format($b, 2); ?></td>
              <td style="font-weight: bold"><?php echo number_format($c, 2); ?></td>
              <td style="font-weight: bold"><?php echo number_format($d, 2); ?></td>
              <td style="font-weight: bold"><?php echo number_format($e, 2); ?></td>
              <td style="font-weight: bold"><?php echo number_format($total_per_dep, 2); ?></td>
            </tr>        
         </tbody>
        </table>
        <br>
        <br>  
      <?php $total_it += $total_per_dep; ?>
    <?php endforeach;  ?>
    <br>
    <br>
    <br>
      <?php $overallTotal = $total_it; ?>
    <h1>Overall Total: <?php echo $overallTotal; ?></h1>

  </div>
</body>
</html>