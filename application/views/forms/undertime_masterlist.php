<html>
<head>
  <meta charset="utf-8">
  <title>Application</title> 
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
  <h2 style="text-align: center"><?php echo $forms->getFormType(); ?> Form</h2>

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
        <td colspan="3" class="background border">Effective Date:</td>
        <td colspan="7" class="border"><?php echo $forms->effective_date; ?></td>
      </tr> 
      
      <tr>
        <td colspan="3" class="background border">Reason:</td>
        <td colspan="7" class="border"><?php echo $forms->getFormData()->reason; ?></td>
      </tr>
   
      
  <!--     <tr>
        <td colspan="10" class="background border"><span style="margin-left: 400px">Remaining Credits <span style="font-style: italic">(to be filled up by HR)</span></span></td>
      </tr>
       -->
      <tr>
        <td colspan="4" class="border">Remarks:</td>
        <td colspan="6" class="border"><?php echo $forms->getFormData()->remarks; ?></td>
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
        <td colspan="4">Approved by: <?php echo $forms->getApprovedBy()->full_name; ?></td>
        <td colspan="6">Date: <?php echo $forms->updated_at; ?></td>
      </tr>
    </tbody> 
  </table>
</body>
</html>