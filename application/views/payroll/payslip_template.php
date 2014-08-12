
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
      </style>
    </head>
    <body >
      <h3><img src="img/logo.png"> </h3>
      <table style="font-size:12px">
        <thead>
          <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Middle Name</th>
          </tr>
        </thead>
        
        <tr>
          <td><?php echo $employee->id; ?></td>
          <td><?php echo $employee->first_name; ?></td>
          <td><?php echo $employee->last_name; ?></td>
          <td><?php echo $employee->middle_name; ?></td>
        </tr>
     
        <thead>
          <tr>
            <th>Status</th>
            <th>Position</th>
            <th>Department</th>
            <th>Branch</th>
          </tr>  
        </thead>
        
        <tr>
          <td> <?php echo $employee->marital_status; ?></td>
          <td><?php echo $employee->getJobPosition(); ?></td>
          <td><?php echo $employee->getDepartment(); ?></td>
          <td><?php echo $employee->getBranch(); ?></td>
        </tr>
     
        <thead>
          <tr>
            <th>TIN</th>
            <th>SSS</th>
            <th>HDMF</th>
            <th>PHILHEALTH</th>
          </tr>  
        </thead>
        
        <tr>
          <td> <?php echo $employee->tin_number; ?></td>
          <td><?php echo $employee->sss_number; ?></td>
          <td><?php echo $employee->pagibig_number; ?></td>
          <td><?php echo $employee->philhealth_number==null ? 'n/a' : $employee->philhealth_number; ?></td>
        </tr>
      </table>
      <div style="height: 30px;"></div>
      <table class="bordered">
        <tr>
          <td>Basic Salary</td>
          <td> <?php echo $employee->getBasicPay(); ?></td>
        </tr>
        <tr>
          <td>Allowance</td>
          <td><?php echo $employee->getAllowance(); ?> </td>
        </tr>
        <tr>
          <td>SSS</td>
          <td><?php echo $payslip->sss; ?></td>
        </tr>
        <tr>
          <td>Philhealth</td>
          <td><?php echo $payslip->philhealth; ?></td>
        </tr>
        <tr>
          <td>Pag ibig</td>
          <td><?php echo $payslip->pagibig; ?></td>
        </tr>
        <tr>
          <td>Gross Pay</td>
          <td><?php echo $payslip->gross; ?></td>
        </tr>
         <tr>
          <td>Withholding Tax</td>
          <td><?php echo $payslip->widthholding_tax; ?></td>
        </tr>
        <tr >
          <td style="background-color:#E2FF3D !important">Net Pay</td>
          <td style="background-color:#E2FF3D !important"><?php echo $payslip->net; ?></td>
        </tr>
      </table>
      
    <table class="bordered" style="margin-top:30px;background-color:#DBDBDB">
      <thead>
         <tr>
          <td>Payroll Date</td>
          <td>Prepared By</td>
        </tr>
        <tr>
          <td><?php echo $payslip->getPayrollDate(); ?></td>
          <td><?php echo $payslip->getPreparedBy(); ?></td>
        </tr>
      </thead>  
     
     </table
      
      
     
      
      
      

              
      
    </body>
</html>
