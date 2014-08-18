
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
        .address {
          max-width: 300px;
          float:right;
          font-size: 12px
        }
        .address p {
          text-align:right;
        }
      </style>
    </head>
    <body >
      <span style="position:absolute;right:0;">
        Employee's Copy
      </span>
      <table>
        <tr>
          <td>
            <h3><img src="img/logo.png" style="height:70px;width:300px;"> </h3>
          </td>
          <td>
            <div class="address">
              <p>
                Barangangay bagbag sany jose delmonthsdsds
                sdsadsdasdasdasdsadasdsadadasd
              </p>
            </div>
            
          </td>
        </tr>
      </table>
      
      <table style="font-size:12px">
      
        
        <tr>
          <td>EMP #</td>
          <td><?php echo $employee->id; ?></td>
          <td>PAYROLL PERIOD</td>
          <td><?php echo $payslip->getPayrollDate(); ?></td>

        </tr>
        <tr>
          <td>NAME: </td>
          <td><?php echo $employee->first_name; ?> <?php echo $employee->last_name; ?> <?php echo $employee->middle_name; ?></td>
          <td>PAYROLL DATE</td>
          <td><?php echo $payslip->created_at?></td>
        </tr>
        <tr>
          <td>DESIGNATION</td>
          <td><?php echo $employee->getJobPosition(); ?></td>
          <td>PAYMENT MODE</td>
          <td><?php echo $employee->payroll_period; ?></td>
        </tr>
        
      </table>

      <div style="height: 10px; margin:10px 0px; background-color:yellow"></div>

      <table class="bordered">
        <thead>
          <tr >
            <td  colspan="2">INCOME</td>
            <td  colspan="2">DEDUCTION</td>
          </tr>
        </thead>
        <tr>

          <td>Basic Salary</td>
          <td> <?php echo $employee->getBasicPay(); ?></td>

          <td>Absent</td>
          <td> <?php echo $employee->getBasicPay(); ?></td>
        </tr>
        <tr>
          <td>Allowance</td>
          <td><?php echo $employee->getAllowance(); ?> </td>

           <td>Undertime</td>
          <td><?php echo '0' ?> </td>
        </tr>
        <tr>
          <td></td>
          <td></td>

          <td>SSS</td>
          <td><?php echo $payslip->sss; ?></td>
        </tr>
        <tr>
          <td></td>
          <td></td>

          <td>Philhealth</td>
          <td><?php echo $payslip->philhealth; ?></td>
        </tr>
        <tr>
          <td></td>
          <td></td>

          <td>Pag ibig</td>
          <td><?php echo $payslip->pagibig; ?></td>
        </tr>
        
         <tr>
          <td></td>
          <td></td>

          <td>Withholding Tax</td>
          <td><?php echo $payslip->widthholding_tax; ?></td>
        </tr>
        <tr>

          <td>Gross Pay</td>
          <td><?php echo $payslip->gross; ?></td>
          
          <td>Total Deductions</td>
          <td></td>
        </tr>
        <tr >
          <td style="background-color:#E2FF3D !important" colspan="2">Net Pay</td>
          <td style="background-color:#E2FF3D !important" colspan="2"><?php echo $payslip->net; ?></td>
        </tr>
      </table>
      
    <table class="bordered" style="margin-top:30px;background-color:#DBDBDB">
      <thead>
         <tr>        
           <td>Prepared By</td>
        </tr>
        <tr>
          <td><?php echo $payslip->getPreparedBy(); ?></td>
        </tr>
      </thead>  
     
     </table
      
      
     
      
      
      

              
      
    </body>
</html>
