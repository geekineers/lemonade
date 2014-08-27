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
        font-size:12px;
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
      <li>Payroll Period: 2014/08/18 - 2014/08/30</li>
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
           <th>Basic Salary</th>
           <th>Tax Status</th>
           <th>Allowance</th>
           <th>SSS Loans</th>

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
        <?php foreach ($payslip as $slip ) : ?>     
           <tr>
             <td><?php echo $slip->getEmployee()->getJobPosition(); ?></td>
             <td><?php echo $slip->getEmployee()->id; ?></td>
             <td><?php echo $slip->getEmployee()->getName(); ?></td>
             <td><?php echo $slip->getEmployee()->getBasicPay(); ?></td>
             <td><?php echo $slip->getEmployee()->getTotalAllowances(); ?></td>
             <td><?php echo $slip->getEmployee()->getGross(); ?></td>
             <td><?php echo number_format(isset($slip->sss) ? $slip->sss : 0 ,2); ?></td>
             <td><?php echo number_format($slip->pagibig,2); ?></td>
             <td><?php echo number_format($slip->philhealth,2); ?></td>
             <td><?php echo number_format($slip->getEmployee()->getTotalDeductions(),2); ?></td>
             <td><?php echo $slip->getEmployee()->getTax()['widthholding_tax']; ?></td>
             <td><?php echo $slip->getEmployee()->getTax()['total_deduc']; ?></td>
             <td><?php echo $slip->getEmployee()->getTax()['net']; ?></td>
           </tr>
        <?php endforeach;  ?>
        
       </tbody>
    </table>
  </div>
</body>
</html>