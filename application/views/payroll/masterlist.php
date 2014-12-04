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
    <ul>
      <li>Payroll Period: <?php echo $from .'-'.$to ?></li>
      <li>Payroll Date: <?php echo $date;?></li>
      <li>Payroll Mode:  <?php echo $period->getPayrollGroup()->period ?>  </li>
    </ul>
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
           <th>Absent</th>
           <th>Late</th>
           <th>Under Time</th>
           <th>Misc Deductions</th>
           <th>Tax</th>
           <th>Net</th>
        </tr>
       </thead>
       <tbody>
        <?php foreach ($payslips as $payslip ) : ?>     
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
             <td><?php echo $payslip->getEmployee()->getAbsentDeduction($from, $to, false, true); ?></td>
             <td><?php echo $payslip->getEmployee()->getLateDeduction($from, $to, 'minute', true);?></td>
             <td><?php echo $payslip->getEmployee()->getUnderTimeDeduction($from, $to, 'minute', true);?></td>
             <td><?php echo $payslip->getEmployee()->getTotalDeductions($from, $to, 'minute'); ?></td>
             <td><?php echo $payslip->getEmployee()->getWithholdingTax($from,$to,true); ?></td>
             <td><?php echo $payslip->getEmployee()->getNet($from, $to); ?></td>
           </tr>
        <?php endforeach;  ?>
        
       </tbody>
    </table>
  </div>
</body>
</html>