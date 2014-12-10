<html>
<head>
  <meta charset="utf-8">
  <title>Master List</title> 
  <style type="text/css">
    @media print{@page {size: landscape}}
    body {
      font-family: 'Arial';
      font-size: 19px;
    }
    .border {
      border: 1px solid black;
      margin: 0;
    }
    .background {
      background-color: #D3D3D3;
    }
  </style> 
</head>
<body>
  <h2 style="text-align: center">LEAVE FORM</h2>
  <!-- upper part -->
  <table width="100%">
     <tbody> 
      <tr>
        <td colspan="1">Name: <span style="text-decoration: underline"><?php echo $forms->getEmployeeNames(); ?></span></td>
        <td colspan="1">Date Prepared: <span style="text-decoration: underline"><?php echo $forms->created_at ?></span></td>
      </tr>

      <tr>
        <td colspan="1">Department: <span style="text-decoration: underline"><?php echo $forms->getDepartment(); ?></span></td>
        <td colspan="1">Position: <span style="text-decoration: underline"><?php echo $forms->getEmployee()->getJobPosition(); ?></span></td>
      </tr>
    </tbody> 
  </table>
  <h2 style="text-align: left">Details of Request</h2>
  <!--middle part -->
  <table width="100%" class="">
    <tbody>
      <tr>
        <td colspan="3" class="background border">Start Date:</td>
        <td colspan="1" class="border">&nbsp;</td>
        <td colspan="1" class="background border">End Date:</td>
        <td colspan="1" class="border">&nbsp;</td>
        <td colspan="1" class="background border">No. of Day:</td>
        <td colspan="1" class="border">&nbsp;</td>     
      </tr>
      
      <tr>
        <td colspan="3" class="background border">Reason:</td>
        <td colspan="7" class="border">&nbsp;</td>
      </tr>
      
      <tr>
        <td colspan="10" class="background border"><span style="margin-left: 400px">Type of Leave</span></td>
      </tr>
      
      <tr>
        <td colspan="3" class="background border">Vacation Leave:</td>
        <td colspan="1" class="border">&nbsp;</td>
        <td colspan="1" class="background border">Sick Leave:</td>
        <td colspan="1" class="border">&nbsp;</td>
        <td colspan="1" class="background border">Absent:</td>
        <td colspan="1" class="border">&nbsp;</td>
      </tr>
      
      <tr>
        <td colspan="10" class="background border"><span style="margin-left: 400px">Remaining Credits <span style="font-style: italic">(to be filled up by HR)</span></span></td>
      </tr>
      
      <tr>
        <td colspan="4" class="border">&nbsp;</td>
        <td colspan="6" class="border">&nbsp;</td>
      </tr>

    </tbody>
  </table>
  <!-- bottom part -->
  <br>
  <br>
  <br>
  <br>
  <table width="100%">
     <tbody> 
      <tr>
        <td colspan="4">Requested by:<span style="margin-left: 150px; display: block; width: 150px; border: 1px solid black"></span></td>
        <td colspan="6">Date:<span style="margin-left: 50px; display: block; width: 150px; border: 1px solid black"></span></td>
      </tr>

      <tr>
        <td colspan="4">Checked by:<span style="margin-left: 150px; display: block; width: 150px; border: 1px solid black"></span></td>
        <td colspan="6">Date:<span style="margin-left: 50px; display: block; width: 150px; border: 1px solid black"></span></td>
      </tr>

      <tr>
        <td colspan="4">Approved by:<span style="margin-left: 150px; display: block; width: 150px; border: 1px solid black"></span></td>
        <td colspan="6">Date:<span style="margin-left: 50px; display: block; width: 150px; border: 1px solid black"></span></td>
      </tr>
    </tbody> 
  </table>
</body>
</html>