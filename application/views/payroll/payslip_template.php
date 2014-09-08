
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
            <h3><img src="../uploads/<?php echo $company_logo; ?>" style="height:70px;"> </h3>
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
      <?php
        $from = $payslip->getPayslipsGroup()->from;

        $to = $payslip->getPayslipsGroup()->to;
      ?>
      <table style="font-size:12px">
      
        
        <tr>
          <td>EMP #</td>
          <td><?php echo $employee->id; ?></td>
          <td>PAYROLL PERIOD</td>
          <td><?php echo $payslip->getPayslipsGroup()->from.'-'.$payslip->getPayslipsGroup()->to; ?></td>

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
          <td><?php echo $payslip->getPayslipsGroup()->getPayrollGroup()->period ?></td>
        </tr>
        
      </table>

      <div style="height: 10px; margin:10px 0px; background-color:yellow"></div>



<div style="max-width:49%;position:absolute;left:300px">
  <table class="bordered">
     <thead>
        <tr >
          <td  colspan="2">DEDUCTION</td>
        </tr>
      </thead>

      <!-- foreach -->
        <?php foreach ($employee->getDeductions() as $deduction) { ?>
          <tr>
            <td><?php echo $deduction->getName(); ?></td>
            <td><?php echo $deduction->getAmount(); ?></td>
          </tr>
        <?php } ?>

        <tr>
          <td>Late Deduction</td>
          <td><?php echo $employee->getLateDeduction($from, $to, 'minute'); ?></td>
        </tr>

         <tr>
          <td>Absent</td>
          <td><?php echo $employee->getAbsentDeduction($from, $to,false,true); ?></td>
        </tr>
        <tr>
          <td>SSS</td>
          <td><?php echo $employee->getSSSValue()?></td>
        </tr>
        <tr>
          <td>HDMF</td>
          <td><?php echo number_format($payslip->pagibig,2) ?></td>
        </tr>
        <tr>
          <td>Philhealth</td>
          <td><?php echo number_format($payslip->philhealth,2) ?></td>
        </tr>
        <tr>
          <td>Withholding Tax</td>
          <td><?php echo $employee->getWithholdingTax($from, $to)?></td>
        </tr>
        <tr>
          <td><b style="padding:15px ;">Total Deduction</b></td>
          
          <td><?php echo $employee->getAllandTotalDeduction($from, $to)?></td> 
        </tr>
        

      <!-- end -->
  </table>

</div>
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
            <td><?php echo $employee->getBasicPay(); ?></td>
          </tr>

         <?php foreach ($employee->getAllowances() as $allowance) { ?>
            <tr>
              <td><?php echo $allowance->getName(); ?></td>
              <td><?php echo $allowance->getAmount(); ?></td>
            </tr>
             
         
         <?php } ?>
          <tr>
            <td >Overtime</td>
            <td>
              <?php echo $employee->getOvertime($from,$to)  ?>
            </td>
          </tr>

         
          
          <tr>
            <td>Total Allowances</td>
            <td>
              <?php echo $employee->getTotalAllowances() ?>
            </td>
          </tr>
          <tr><td>&nbsp;</td><td>&nbsp;</td></tr>

          <tr><td>&nbsp;</td><td>&nbsp;</td></tr>

          <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
          <tr>
            <td ><b style="padding:15px ;">Gross Pay</b></td>
            <td>
              <?php echo  $payslip->getEmployee()->getGross($from,$to,true) ?>
            </td>
          </tr>
        <!-- endforeach -->
   </table>
</div>

    <table style="width:100%;position:absolute;top:500px;">
      <tr>
        <td style="background-color:yellow">NET</td>
        <td style="background-color:yellow"><?php echo $employee->getNet($from, $to)?></td>
      </tr>
    </table>

       <!--  <tr >
          <td style="background-color:#E2FF3D !important" colspan="2">Net Pay</td>
          <td style="background-color:#E2FF3D !important" colspan="2"><?php  //echo $payslip->net; ?></td>
        </tr> -->
    <table class="bordered" style="margin-top:30px;background-color:#DBDBDB;position:absolute;bottom:200px;">
      <thead>
         <tr>        
           <td>Prepared By</td>
        </tr>
        <tr>
          <td><?php echo $payslip->getPayslipsGroup()->getPreparedBy(); ?></td>
        </tr>
      </thead>  
     
     </table
      
      
     
      
      
      

              
  </div>
    </body>
</html>
