<?php

require_once APPPATH . '/libraries/excel.php';

class ReportRepository extends BaseRepository
{

    public function __construct()
    {

    }

    public function generateXLS($data, $data_columns, $filename, $branch)
    {
        get_instance()->load->library('excel');
        $objPHPExcel = PHPExcel_IOFactory::load("xls_template/generator.xlsx");
        $objPHPExcel->setActiveSheetIndex(0);
        $row = 5;
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Branch Name:');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', $branch);

        $column = "A";
        foreach ($data_columns as $col) {
            $objPHPExcel->getActiveSheet()->getStyle(1)->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->SetCellValue($column . $row, $col);
            $column++;
        }
        $row++;

        foreach ($data as $item) {
            $column = "A"; 
            foreach ($item as $key => $value) {
                $objPHPExcel->getActiveSheet()->SetCellValue($column . $row, $value);
                $column++;
            }
            $row++;
        }
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $uid       = uniqid();
        $objWriter->save('excel_files/generated-' . $filename . '.xlsx');
        return 'excel_files/generated-' . $filename . '.xlsx';
    }

}
