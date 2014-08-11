<?php ?>
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
      <h3>Lemonade </h3>
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
          <td> <?php echo $employee->getBasicPay(); ?></td></td>
        </tr>
        <tr>
          <td>Allowance</td>
          <td>25,000</td>
        </tr>
        <tr>
          <td>SSS</td>
          <td>25,000</td>
        </tr>
        <tr>
          <td>Paghealth</td>
          <td>25,000</td>
        </tr>
        <tr>
          <td>Pag ibig</td>
          <td>25,000</td>
        </tr>
        <tr>
          <td>Gross Pay</td>
          <td>25,000</td>
        </tr>
        <tr >
          <td style="background-color:#E2FF3D !important">Net Pay</td>
          <td style="background-color:#E2FF3D !important">25,000</td>
        </tr>
      </table>
      
    <table class="bordered" style="margin-top:30px;background-color:#DBDBDB">
      <thead>
         <tr>
          <td>Payroll Date</td>
          <td>Prepared By</td>
        </tr>
        <tr>
          <td>2302-23-23</td>
          <td>Onardejsus</td>
        </tr>
      </thead>  
     
     </table
      
      
     
      
      
      

              
      
    </body>
</html>
