<?php
/*
* @Created by: QuynhTM
* @Author    : manhquynh1984@gmail.com
* @Date      : 13/03/2020
* @Version   : 1.0
*/

namespace App\Services;

use App\Models\OpenId\UserSystem;
use Illuminate\Support\Facades\Config;
//use Maatwebsite\Excel\Excel;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

use Excel;


/**
 * Class ImportExcel
 * @package App\Services
 * Các function liên quan đến ImportExcel
 */
class ImportExcel{
    public function importOrderInBatches($request, $files)
    {
        try {
            if (!isset($files['import']) || !$files['import']['name']) {
                throw new \PDOException('Bad Request: Please select file to import', 406);
            }
            $mimeType = mime_content_type($files['import']['tmp_name']);
            allowedImportMimeType($mimeType);

            $objPHPExcel = \PhpOffice\PhpSpreadsheet\IOFactory::load($files['import']['tmp_name']);
            $objPHPExcel->setActiveSheetIndex(0);
            $rowsExcel = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            unset($rowsExcel[1]);//mảng tiêu đề

            //col A->E
            $dataInput = $listCodes = $errors = [];
            if (!empty($rowsExcel)) {
                foreach ($rowsExcel as $kr => $valRow) {
                    $code = strtoupper(trim($valRow['A']));
                    if ($code != '' || trim($valRow['B']) != '' || trim($valRow['C']) != '' || trim($valRow['D']) != '' ) {
                        $listCodes[] = strtoupper(trim($code));
                        $dataInput[$kr] = [
                            'STAFF_CODE' => $code,//A
                            'STAFF_NAME' => trim($valRow['B']),
                            'DEACTIVE_DATE' => trim($valRow['C']),
                            'DEPARTMENT_CODE' => trim($valRow['D']),//batch-code
                            'positionId' => 0,
                        ];
                    }else{
                        break;
                    }
                }
            }

            //check dữ liệu
            if (!empty($dataInput)) {
                foreach ($dataInput as $num_row => &$value) {
                    try {
                        //validate đầu vào không đc null
                        if ( trim($value['STAFF_CODE']) == '') {
                            throw new \PDOException('Không được bỏ trống => <strong> STAFF_CODE </strong>');
                        }

                    } catch (\PDOException $e) {
                        $errors[] = "<span class=\"col-sm-2\">DÒNG " . ($num_row) . "</span> <span class=\"col-sm-10\">{$e->getMessage()}</span>";
                    }
                }
                if (!empty($errors)) {
                    throw new \PDOException(implode('<br />', $errors));
                }
                return  $dataInput;
            } else {
                throw new \PDOException('Dữ liệu đầu vào không đúng.', 406);
            }
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }
}
