<?php

function _snakeToCamel($val) 
{
    return str_replace(' ', '', ucwords(str_replace('_', ' ', $val)));
}

function _snakeToTitle($val)
{
    return ucwords(str_replace('_', ' ', $val));
}

function toTitleCase($val)
{
    return ucwords(strtolower($val));
}

function ciAppPath($path = null)
{
    return APPPATH . $path;
}

function recursiveRemoveDirectory($directory)
{
    foreach (glob("{$directory}/*") as $file) {
        if (is_dir($file)) {
            recursiveRemoveDirectory($file);
        } else {
            unlink($file);
        }
    }
}

function sendJSON($data)
{
    try
    {
        return $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
     catch (Exception $e) {
        dd($e);
    }
}

function pdfCreate($html, $filename = 's', $stream = true, $landscape = false)
{

    require_once (APPPATH . "helpers/dompdf/dompdf/dompdf_config.inc.php");

    $dompdf = new DOMPDF();

    $dompdf->load_html($html);

    if ($landscape) {
        $dompdf->set_paper('a4', 'landscape');
        $dompdf->render();
    } else {
        $dompdf->render();
    }

    if ($stream) {

        $dompdf->stream($filename . ".pdf");

    } else {

        header("Content-Type: application/pdf");

        return $dompdf->output();

    }
}

function toInt($number)
{
    return intval(str_replace(',', '', $number));
}

/* SSS Contribution 2014 updated
 * conv'ER'ted http://shancart'ER'.github.io/mr-data-converter/
 * Legend
 * ER = Emplyer Rate
 * EE = Employee Rate
 * TC = total contrib (EE+ER)
 * TTC = total contrilb se/vm
 */
function getSSS($basic_salary)
{
    $sss_range = array(
        array('range' => 1249.99, 'ER' => 83.70, 'EE' => 36.30, 'TC' => 120.00, 'TTC' => 110.00),
        array('range' => 1749.99, 'ER' => 120.50, 'EE' => 54.50, 'TC' => 175.00, 'TTC' => 165.00),
        array('range' => 2249.99, 'ER' => 157.30, 'EE' => 72.70, 'TC' => 230.00, 'TTC' => 220.00),
        array('range' => 2749.99, 'ER' => 194.20, 'EE' => 90.80, 'TC' => 285.00, 'TTC' => 275.00),
        array('range' => 3249.99, 'ER' => 231.00, 'EE' => 109.00, 'TC' => 340.00, 'TTC' => 330.00),
        array('range' => 3749.99, 'ER' => 267.80, 'EE' => 127.20, 'TC' => 395.00, 'TTC' => 385.00),
        array('range' => 4249.99, 'ER' => 304.70, 'EE' => 145.30, 'TC' => 450.00, 'TTC' => 440.00),
        array('range' => 4749.99, 'ER' => 341.50, 'EE' => 163.50, 'TC' => 505.00, 'TTC' => 495.00),
        array('range' => 5249.99, 'ER' => 378.30, 'EE' => 181.70, 'TC' => 560.00, 'TTC' => 550.00),
        array('range' => 5749.99, 'ER' => 415.20, 'EE' => 199.80, 'TC' => 615.00, 'TTC' => 605.00),
        array('range' => 6249.99, 'ER' => 452.00, 'EE' => 218.00, 'TC' => 670.00, 'TTC' => 660.00),
        array('range' => 6749.99, 'ER' => 488.80, 'EE' => 236.20, 'TC' => 725.00, 'TTC' => 715.00),
        array('range' => 7249.99, 'ER' => 525.70, 'EE' => 254.30, 'TC' => 780.00, 'TTC' => 770.00),
        array('range' => 7749.99, 'ER' => 562.50, 'EE' => 272.50, 'TC' => 835.00, 'TTC' => 825.00),
        array('range' => 8249.99, 'ER' => 599.30, 'EE' => 290.70, 'TC' => 890.00, 'TTC' => 880.00),
        array('range' => 8749.99, 'ER' => 636.20, 'EE' => 308.80, 'TC' => 945.00, 'TTC' => 935.00),
        array('range' => 9249.99, 'ER' => 673.00, 'EE' => 327.00, 'TC' => 1000.00, 'TTC' => 990.00),
        array('range' => 9749.99, 'ER' => 709.80, 'EE' => 345.20, 'TC' => 1055.00, 'TTC' => 1045.00),
        array('range' => 10249.99, 'ER' => 746.70, 'EE' => 363.30, 'TC' => 1110.00, 'TTC' => 1100.00),
        array('range' => 10749.99, 'ER' => 783.50, 'EE' => 381.50, 'TC' => 1165.00, 'TTC' => 1155.00),
        array('range' => 11249.99, 'ER' => 820.30, 'EE' => 399.70, 'TC' => 1220.00, 'TTC' => 1210.00),
        array('range' => 11749.99, 'ER' => 857.20, 'EE' => 417.80, 'TC' => 1275.00, 'TTC' => 1265.00),
        array('range' => 12249.99, 'ER' => 894.00, 'EE' => 436.00, 'TC' => 1330.00, 'TTC' => 1320.00),
        array('range' => 12749.99, 'ER' => 930.80, 'EE' => 454.20, 'TC' => 1385.00, 'TTC' => 1375.00),
        array('range' => 13249.99, 'ER' => 967.70, 'EE' => 472.30, 'TC' => 1440.00, 'TTC' => 1430.00),
        array('range' => 13749.99, 'ER' => 1004.50, 'EE' => 490.50, 'TC' => 1495.00, 'TTC' => 1485.00),
        array('range' => 14249.99, 'ER' => 1041.30, 'EE' => 508.70, 'TC' => 1550.00, 'TTC' => 1540.00),
        array('range' => 14749.99, 'ER' => 1078.20, 'EE' => 526.80, 'TC' => 1605.00, 'TTC' => 1595.00),
        array('range' => 15249.99, 'ER' => 1135.00, 'EE' => 545.00, 'TC' => 1680.00, 'TTC' => 1650.00),
        array('range' => 15749.99, 'ER' => 1171.80, 'EE' => 563.20, 'TC' => 1735.00, 'TTC' => 1705.00),
        array('range' => 16000.99, 'ER' => 1208.70, 'EE' => 581.30, 'TC' => 1790.00, 'TTC' => 1760.00)
    );

    $sss_val = array();
    foreach ($sss_range as $sss => $val) {
        if ($basic_salary <= $sss_range[$sss]['range']) {
            $sss_val = array(
                'range' => $sss_range[$sss]['range'],
                'ER'    => $sss_range[$sss]['ER'],
                'EE'    => $sss_range[$sss]['EE'],
                'TC'    => $sss_range[$sss]['TC'],
                'TTC'   => $sss_range[$sss]['TTC'],
            );
            break;
        } else if ($basic_salary > $sss_range[count($sss_range) - 1]['range']) {
            $sss_val = array(
                'range' => $sss_range[count($sss_range) - 1]['range'],
                'ER'    => $sss_range[count($sss_range) - 1]['ER'],
                'EE'    => $sss_range[count($sss_range) - 1]['EE'],
                'TC'    => $sss_range[count($sss_range) - 1]['TC'],
                'TTC'   => $sss_range[count($sss_range) - 1]['TTC'],
            );
            break;
        }
    }

    return $sss_val;
}

// philhealth
// http://www.philhealth.gov.ph/members/employed/contri_tbl.html

function getPH($basic_salary)
{
    $ph_range = array(
        array("Salary_Bracket" => 1, "Salary_Range" => 8999.99, "Salary_Base" => 8000.00, "Total_Monthly_Premium" => 200.00, "Employee_Share" => 100.00, "Employer_Share" => 100.00),
        array("Salary_Bracket" => 2, "Salary_Range" => 9999.99, "Salary_Base" => 9000.00, "Total_Monthly_Premium" => 225.00, "Employee_Share" => 112.50, "Employer_Share" => 112.50),
        array("Salary_Bracket" => 3, "Salary_Range" => 10999.99, "Salary_Base" => 10000.00, "Total_Monthly_Premium" => 250.00, "Employee_Share" => 125.00, "Employer_Share" => 125.00),
        array("Salary_Bracket" => 4, "Salary_Range" => 11999.99, "Salary_Base" => 11000.00, "Total_Monthly_Premium" => 275.00, "Employee_Share" => 137.50, "Employer_Share" => 137.50),
        array("Salary_Bracket" => 5, "Salary_Range" => 12999.99, "Salary_Base" => 12000.00, "Total_Monthly_Premium" => 300.00, "Employee_Share" => 150.00, "Employer_Share" => 150.00),
        array("Salary_Bracket" => 6, "Salary_Range" => 13999.99, "Salary_Base" => 13000.00, "Total_Monthly_Premium" => 325.00, "Employee_Share" => 162.50, "Employer_Share" => 162.50),
        array("Salary_Bracket" => 7, "Salary_Range" => 14999.99, "Salary_Base" => 14000.00, "Total_Monthly_Premium" => 350.00, "Employee_Share" => 175.00, "Employer_Share" => 175.00),
        array("Salary_Bracket" => 8, "Salary_Range" => 15999.99, "Salary_Base" => 15000.00, "Total_Monthly_Premium" => 375.00, "Employee_Share" => 187.50, "Employer_Share" => 187.50),
        array("Salary_Bracket" => 9, "Salary_Range" => 16999.99, "Salary_Base" => 16000.00, "Total_Monthly_Premium" => 400.00, "Employee_Share" => 200.00, "Employer_Share" => 200.00),
        array("Salary_Bracket" => 10, "Salary_Range" => 17999.99, "Salary_Base" => 17000.00, "Total_Monthly_Premium" => 425.00, "Employee_Share" => 212.50, "Employer_Share" => 212.50),
        array("Salary_Bracket" => 11, "Salary_Range" => 18999.99, "Salary_Base" => 18000.00, "Total_Monthly_Premium" => 450.00, "Employee_Share" => 225.00, "Employer_Share" => 225.00),
        array("Salary_Bracket" => 12, "Salary_Range" => 19999.99, "Salary_Base" => 19000.00, "Total_Monthly_Premium" => 475.00, "Employee_Share" => 237.50, "Employer_Share" => 237.50),
        array("Salary_Bracket" => 13, "Salary_Range" => 20999.99, "Salary_Base" => 20000.00, "Total_Monthly_Premium" => 500.00, "Employee_Share" => 250.00, "Employer_Share" => 250.00),
        array("Salary_Bracket" => 14, "Salary_Range" => 21999.99, "Salary_Base" => 21000.00, "Total_Monthly_Premium" => 525.00, "Employee_Share" => 262.50, "Employer_Share" => 262.50),
        array("Salary_Bracket" => 15, "Salary_Range" => 22999.99, "Salary_Base" => 22000.00, "Total_Monthly_Premium" => 550.00, "Employee_Share" => 275.00, "Employer_Share" => 275.00),
        array("Salary_Bracket" => 16, "Salary_Range" => 23999.99, "Salary_Base" => 23000.00, "Total_Monthly_Premium" => 575.00, "Employee_Share" => 287.50, "Employer_Share" => 287.50),
        array("Salary_Bracket" => 17, "Salary_Range" => 24999.99, "Salary_Base" => 24000.00, "Total_Monthly_Premium" => 600.00, "Employee_Share" => 300.00, "Employer_Share" => 300.00),
        array("Salary_Bracket" => 18, "Salary_Range" => 25999.99, "Salary_Base" => 25000.00, "Total_Monthly_Premium" => 625.00, "Employee_Share" => 312.50, "Employer_Share" => 312.50),
        array("Salary_Bracket" => 19, "Salary_Range" => 26999.99, "Salary_Base" => 26000.00, "Total_Monthly_Premium" => 650.00, "Employee_Share" => 325.00, "Employer_Share" => 325.00),
        array("Salary_Bracket" => 20, "Salary_Range" => 27999.99, "Salary_Base" => 27000.00, "Total_Monthly_Premium" => 675.00, "Employee_Share" => 337.50, "Employer_Share" => 337.50),
        array("Salary_Bracket" => 21, "Salary_Range" => 28999.99, "Salary_Base" => 28000.00, "Total_Monthly_Premium" => 700.00, "Employee_Share" => 350.00, "Employer_Share" => 350.00),
        array("Salary_Bracket" => 22, "Salary_Range" => 29999.99, "Salary_Base" => 29000.00, "Total_Monthly_Premium" => 725.00, "Employee_Share" => 362.50, "Employer_Share" => 362.50),
        array("Salary_Bracket" => 23, "Salary_Range" => 30999.99, "Salary_Base" => 30000.00, "Total_Monthly_Premium" => 750.00, "Employee_Share" => 375.00, "Employer_Share" => 375.00),
        array("Salary_Bracket" => 24, "Salary_Range" => 31999.99, "Salary_Base" => 31000.00, "Total_Monthly_Premium" => 775.00, "Employee_Share" => 387.50, "Employer_Share" => 387.50),
        array("Salary_Bracket" => 25, "Salary_Range" => 32999.99, "Salary_Base" => 32000.00, "Total_Monthly_Premium" => 800.00, "Employee_Share" => 400.00, "Employer_Share" => 400.00),
        array("Salary_Bracket" => 26, "Salary_Range" => 33999.99, "Salary_Base" => 33000.00, "Total_Monthly_Premium" => 825.00, "Employee_Share" => 412.50, "Employer_Share" => 412.50),
        array("Salary_Bracket" => 27, "Salary_Range" => 34999.99, "Salary_Base" => 34000.00, "Total_Monthly_Premium" => 850.00, "Employee_Share" => 425.00, "Employer_Share" => 425.00),
        array("Salary_Bracket" => 28, "Salary_Range" => 35000.00, "Salary_Base" => 35000.00, "Total_Monthly_Premium" => 875.00, "Employee_Share" => 437.50, "Employer_Share" => 437.50)
    );

    $ph_val = array();
    foreach ($ph_range as $ph => $val) {
        if ($basic_salary <= $ph_range[$ph]['Salary_Range']) {
            $ph_val = array(
                'range'                 => $ph_range[$ph]['Salary_Range'],
                'Total_Monthly_Premium' => $ph_range[$ph]['Total_Monthly_Premium'],
                'Employee_Share'        => $ph_range[$ph]['Employee_Share'],
                'Employer_Share'        => $ph_range[$ph]['Employer_Share'],
                'Salary_Base'           => $ph_range[$ph]['Salary_Base'],
            );
            break;
        } else if ($basic_salary > $ph_range[count($ph_range) - 1]['Salary_Range']) {
            $ph_val = array(
                'range'                 => $ph_range[count($ph_range) - 1]['Salary_Range'],
                'Total_Monthly_Premium' => $ph_range[count($ph_range) - 1]['Total_Monthly_Premium'],
                'Employee_Share'        => $ph_range[count($ph_range) - 1]['Employee_Share'],
                'Employer_Share'        => $ph_range[count($ph_range) - 1]['Employer_Share'],
                'Salary_Base'           => $ph_range[count($ph_range) - 1]['Salary_Base'],
            );
            break;
        }
    }

    return $ph_val;
}

// withholding tax
function taxlist()
{
    $wtax_list = array(
        'daily' => array(
            'exemption_status' => array(
                array(0.00, 0),
                array(0.00, 0.05),
                array(1.65, 0.10),
                array(8.25, 0.15),
                array(28.05, 0.20),
                array(74.26, 0.25),
                array(165.02, 0.30),
                array(412.54, 0.32)
            ),
            'employees_without_qualified_dependent' => array(
                'Z' => array(1, 0, 33, 99, 231, 462, 825, 1650),
                'SME' => array(1, 165, 198, 264, 396, 627, 990, 1815)
            ),
            'employees_with_qualified_dependent' => array(
                array(1, 6250, 7083, 8750, 12083, 17917, 27083, 47917),
                array(1, 8333, 9167, 10833, 14167, 20000, 29167, 50000),
                array(1, 10417, 11250, 12917, 16250, 22083, 31250, 52083),
                array(1, 12500, 13333, 15000, 18333, 24167, 33333, 54167)
            )
        ),
        'weekly' => array(
            'exemption_status' => array(
                array(0.00, 0),
                array(0.00, 0.05),
                array(9.62, 0.10),
                array(48.08, 0.15),
                array(163.46, 0.20),
                array(432.69, 0.25),
                array(961.54, 0.30),
                array(2403.85, 0.32)
            ),
            'employees_without_qualified_dependent' => array(
                'Z' => array(1, 0, 192, 577, 1346, 2692, 4808, 9615),
                'SME' => array(1, 962, 1154, 1538, 2308, 3654, 5769, 10577)
            ),
            'employees_with_qualified_dependent' => array(
                array(1, 6250, 7083, 8750, 12083, 17917, 27083, 47917),
                array(1, 8333, 9167, 10833, 14167, 20000, 29167, 50000),
                array(1, 10417, 11250, 12917, 16250, 22083, 31250, 52083),
                array(1, 12500, 13333, 15000, 18333, 24167, 33333, 54167)
            )
        ),
        'semi-monthly' => array(
            'exemption_status' => array(
                array(0.00, 0),
                array(0.00, 0.05),
                array(9.62, 0.10),
                array(48.08, 0.15),
                array(163.46, 0.20),
                array(432.69, 0.25),
                array(961.54, 0.30),
                array(2403.85, 0.32)
            ),
            'employees_without_qualified_dependent' => array(
                'Z' => array(1, 0, 192, 577, 1346, 2692, 4808, 9615),
                'SME' => array(1, 962, 1154, 1538, 2308, 3654, 5769, 10577)
            ),
            'employees_with_qualified_dependent' => array(
                array(1, 6250, 7083, 8750, 12083, 17917, 27083, 47917),
                array(1, 8333, 9167, 10833, 14167, 20000, 29167, 50000),
                array(1, 10417, 11250, 12917, 16250, 22083, 31250, 52083),
                array(1, 12500, 13333, 15000, 18333, 24167, 33333, 54167)
            )
        ),

        'monthly' => array(
            'exemption_status' => array(
                array(0.00, 0), // 1
                array(0.00, 0.05), // 2
                array(41.67, 0.10), // 3
                array(208.33, 0.15), // 4
                array(708.33, 0.20), // 5
                array(1875.00, 0.25), // 6
                array(4166.67, 0.30), // 7
                array(10416.67, 0.32)// 8
            ),
            'employees_without_qualified_dependent' => array(

                'Z' => array(
                    1, // 1
                    0, // 2
                    833, // 3
                    25000, // 4
                    5833, // 5
                    11667, // 6
                    20833, // 7
                    41667// 8
                ),
                'SME' => array(
                    1, // 1
                    4167, //2
                    5000, //3
                    6667, //4
                    10000, //5
                    15833, //6
                    25000, //7
                    45883)//8
            ),
            'employees_with_qualified_dependent' => array(
                array(1, 6250, 7083, 8750, 12083, 17917, 27083, 47917),
                array(1, 8333, 9167, 10833, 14167, 20000, 29167, 50000),
                array(1, 10417, 11250, 12917, 16250, 22083, 31250, 52083),
                array(1, 12500, 13333, 15000, 18333, 24167, 33333, 54167)
            )
        )
    );
    return $wtax_list;
}
function getWTax($basic_salary = 0, $period = 'monthly', $dependents = 0)
{
    $resultArray = array();
    $wtax_list   = array(
        'daily' => array(
            'exemption_status' => array(
                array(0.00, 0),
                array(0.00, 0.05),
                array(1.65, 0.10),
                array(8.25, 0.15),
                array(28.05, 0.20),
                array(74.26, 0.25),
                array(165.02, 0.30),
                array(412.54, 0.32)
            ),
            'employees_without_qualified_dependent' => array(
                'Z' => array(1, 0, 33, 99, 231, 462, 825, 1650),
                'SME' => array(1, 165, 198, 264, 396, 627, 990, 1815)
            ),
            'employees_with_qualified_dependent' => array(
                array(1, 6250, 7083, 8750, 12083, 17917, 27083, 47917),
                array(1, 8333, 9167, 10833, 14167, 20000, 29167, 50000),
                array(1, 10417, 11250, 12917, 16250, 22083, 31250, 52083),
                array(1, 12500, 13333, 15000, 18333, 24167, 33333, 54167)
            )
        ),
        'weekly' => array(
            'exemption_status' => array(
                array(0.00, 0),
                array(0.00, 0.05),
                array(9.62, 0.10),
                array(48.08, 0.15),
                array(163.46, 0.20),
                array(432.69, 0.25),
                array(961.54, 0.30),
                array(2403.85, 0.32)
            ),
            'employees_without_qualified_dependent' => array(
                'Z' => array(1, 0, 192, 577, 1346, 2692, 4808, 9615),
                'SME' => array(1, 962, 1154, 1538, 2308, 3654, 5769, 10577)
            ),
            'employees_with_qualified_dependent' => array(
                array(1, 6250, 7083, 8750, 12083, 17917, 27083, 47917),
                array(1, 8333, 9167, 10833, 14167, 20000, 29167, 50000),
                array(1, 10417, 11250, 12917, 16250, 22083, 31250, 52083),
                array(1, 12500, 13333, 15000, 18333, 24167, 33333, 54167)
            )
        ),
        'semi-monthly' => array(
            'exemption_status' => array(
                array(0.00, 0),
                array(0.00, 0.05),
                array(20.83, 0.10),
                array(104.17, 0.15),
                array(354.17, 0.20),
                array(937.50, 0.25),
                array(2083.33, 0.30),
                array(5208.33, 0.32)
            ),
            'employees_without_qualified_dependent' => array(
                'Z' => array(1, 0, 417, 1250, 2917, 5833, 10417, 20833),
                'SME' => array(1, 2083, 2500, 3333, 5000, 7917, 12500, 22917)
            ),
            'employees_with_qualified_dependent' => array(
                array(1, 3125, 3542, 4375, 6042, 8958, 13542, 23958),
                array(1, 4167, 4583, 5417, 7083, 10000, 14583, 25000),
                array(1, 5208, 5625, 6458, 8125, 11042, 15625, 26042),
                array(1, 6250, 6667, 7500, 9167, 12083, 16667, 27083)
            )
        ),

        'monthly' => array(
            'exemption_status' => array(
                array(0.00, 0), // 1
                array(0.00, 0.05), // 2
                array(41.67, 0.10), // 3
                array(208.33, 0.15), // 4
                array(708.33, 0.20), // 5
                array(1875.00, 0.25), // 6
                array(4166.67, 0.30), // 7
                array(10416.67, 0.32)// 8
            ),
            'employees_without_qualified_dependent' => array(

                'Z' => array(
                    1, // 1
                    0, // 2
                    833, // 3
                    25000, // 4
                    5833, // 5
                    11667, // 6
                    20833, // 7
                    41667// 8
                ),
                'SME' => array(
                    1, // 1
                    4167, //2
                    5000, //3
                    6667, //4
                    10000, //5
                    15833, //6
                    25000, //7
                    45883)//8
            ),
            'employees_with_qualified_dependent' => array(
                array(1, 6250, 7083, 8750, 12083, 17917, 27083, 47917),
                array(1, 8333, 9167, 10833, 14167, 20000, 29167, 50000),
                array(1, 10417, 11250, 12917, 16250, 22083, 31250, 52083),
                array(1, 12500, 13333, 15000, 18333, 24167, 33333, 54167)
            )
        )
    );
    // formula
    // Withholding Tax = ( ([Taxable Income] - [Bracket or Exemption] ) x [%over] ) + [Bracket Tax or Base Tax]

    $period = isset($period) || $period != null ? $period : 'monthly';
    $period = strtolower($period);

    // single or married
    $tax = $dependents <= 0 ? $wtax_list[$period]['employees_without_qualified_dependent']['SME'] : $wtax_list[$period]['employees_with_qualified_dependent'][$dependents - 1];

    // exemtion status
    $es = $wtax_list[$period]['exemption_status'];

    // iterate
    $wt = 0;

    foreach ($tax as $key => $value) {

        if ($basic_salary < $tax[$key] && $basic_salary > 238) {
            // $tax_income

            $key = $key - 1;

            $wt = (($basic_salary - $tax[$key]) * $es[$key][1]) + $es[$key][0];

            $resultArray = array(
                'bsalary' => $basic_salary,
                'bracket' => $tax[$key],
                'over'    => $es[$key][1],
                'base'    => $es[$key][0],
                'tw'      => $wt,
            );

            $wt = (($basic_salary - $tax[$key]) * $es[$key][1]) + $es[$key][0];

            break;
        } else if ($basic_salary > $tax[7] && $basic_salary > 238) {
            $key         = 7;
            $wt          = (($basic_salary - $tax[$key]) * $es[$key][1]) + $es[$key][0];
            $resultArray = array(
                'bsalary' => $basic_salary,
                'bracket' => $tax[$key],
                'over'    => $es[$key][1],
                'base'    => $es[$key][0],
                'wt'      => $wt,
            );

            break;
        } else {
            $wt = 0;
        }
    }

    return $wt;
}

// get total withholdong tax
//getWithholdingTax($salary,null,1,null,null,null);
