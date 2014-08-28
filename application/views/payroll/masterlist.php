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
  <img src="img/logo.png" alt="">
  <span class="masterlist">Employee's Masterlist</span>
  <div>
    <ul>
      <li>Payroll Period: <?php echo $from .'-'.$to ?></li>
      <li>Payroll Date: 08/09/2013</li>
      <li>Payroll Mode: Monthly </li>
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
           <th>Total Allowances</th>
           <th>SSS</th>
           <th>PHILHEALTH</th>
           <th>Pag-ibig</th>
           <th>Absent</th>
           <th>Late</th>
           <th>Tax</th>
           <th>Total</th>
        </tr>
       </thead>
       <tbody>
        <?php foreach ($payslips as $payslip ) : ?>     
           <tr>
             <td><?php echo $payslip->getEmployee()->getJobPosition(); ?></td>
             <td><?php echo $payslip->getEmployee()->id; ?></td>
             <td><?php echo $payslip->getEmployee()->getName(); ?></td>
             <td><?php echo $payslip->getEmployee()->getMonthlyRate(); ?></td>
             <td><?php echo $payslip->getEmployee()->getSemiMonthlyRate(); ?></td>
             <td><?php echo $payslip->getEmployee()->getDailyRate(); ?></td>
              <td><?php echo $payslip->getEmployee()->getTaxStatus(); ?></td>
             <td><?php echo $payslip->getEmployee()->getTotalAllowances(); ?></td>
             <td><?php echo $payslip->getEmployee()->getGross(); ?></td>
             <td><?php echo number_format(isset($payslip->sss) ? $payslip->sss : 0 ,2); ?></td>
             <td><?php echo number_format($payslip->philhealth,2); ?></td>
             <td><?php echo number_format($payslip->pagibig,2); ?></td>
             <td><?php echo number_format($payslip->getEmployee()->getAbsentDeduction($payslip->from, $payslip->to),2); ?></td>
             <td><?php echo $payslip->getEmployee()->getLateDeduction($payslip->from, $payslip->to, 'minute'); ?></td>
             <td><?php echo $payslip->getEmployee()->getSalaryComputations($payslip->from, $payslip->to)['widthholding_tax']; ?></td>
             <td><?php echo $payslip->getEmployee()->getSalaryComputations($payslip->from, $payslip->to)['net']; ?></td>
           </tr>
        <?php endforeach;  ?>
        
       </tbody>
    </table>
  </div>
</body>
</html>