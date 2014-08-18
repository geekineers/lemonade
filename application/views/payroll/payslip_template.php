
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
                Address
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



<div style="max-width:49%;left:0">
   <table class="bordered" >
        <thead>
          <tr >
            <td  colspan="2">INCOME</td>
          </tr>
        </thead>

        <!-- foreach -->
          <tr>
            <td>Basic Salary</td>
            <td></td>
          </tr>
        <!-- endforeach -->
   </table>
</div>
<div style="max-width:49%;position:absolute;right:0;top:163">
  <table class="bordered">
     <thead>
        <tr >
          <td  colspan="2">DEDUCTION</td>
        </tr>
      </thead>

      <!-- foreach -->
        <tr>
          <td>SSS</td>
          <td>Value</td>
        </tr>
      <!-- end -->
  </table>
</div>



       <!--  <tr >
          <td style="background-color:#E2FF3D !important" colspan="2">Net Pay</td>
          <td style="background-color:#E2FF3D !important" colspan="2"><?php echo $payslip->net; ?></td>
        </tr> -->
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
