<?php
namespace App\Library;

require_once (dirname(__FILE__) . '/PHPExcel/PHPExcel.php');

class Excel {
    public static function evaluation($data) {
        $objPHPExcel = new \PHPExcel();
        $aryStyleExcel = self::sExcel();
        $style_header = $aryStyleExcel['style_header'];
        $style_header['fill']['color']['name'] = 'arial';
        $style_header['font']['color']['rgb'] = '222222';
        $style_header['font']['bold'] = true;
        $style_header['font']['size'] = 12;

        $ary_cell_attr = $aryStyleExcel['ary_cell_attr'];
        $ary_cell_attr['font']['size'] = 14;
        $ary_cell_attr['font']['bold'] = true;
        $ary_cell_attr['font']['name'] = 'arial';

        $start = 1;
        $sheetDesc = array('col_start' => 'A', 'col_end' => 'K');
        $ary_cell_attr['alignment']['horizontal'] = \PHPExcel_Style_Alignment::HORIZONTAL_LEFT;
        $objPHPExcel->getActiveSheet()->getStyle("{$sheetDesc['col_start']}$start:{$sheetDesc['col_end']}4")->applyFromArray(array('alignment' => $ary_cell_attr['alignment']));

        $ary_cell = array(
            'A' => array('w' => 15, 'val' => 'No'),
            'B' => array('w' => 25, 'val' => 'HAN ID'),
            'C' => array('w' => 15, 'val' => 'Intern’s Full-name'),
            'D' => array('w' => 15, 'val' => 'Class'),
            'E' => array('w' => 15, 'val' => 'Employer’s name'),
            'F' => array('w' => 15, 'val' => 'Employer’s position'),
            'G' => array('w' => 15, 'val' => 'Supervisor’s name'),
            'H' => array('w' => 15, 'val' => 'Supervisor’s Position'),
            'I' => array('w' => 15, 'val' => 'Internship period (mm/yyyy)'),
            'J' => array('w' => 15, 'val' => 'Type of internship (Full/Part-time)'),
            'K' => array('w' => 15, 'val' => 'Created on'),
        );

        $start = 1;
        foreach ($ary_cell as $col => $attr) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setWidth($attr['w']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue("$col{$start}", $attr['val']);
            $objPHPExcel->getActiveSheet()->getStyle($col)->getAlignment()->setWrapText(true);
        }
        $ary_cell_attr['alignment']['horizontal'] = \PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
        $objPHPExcel->getActiveSheet()->getStyle("A$start:K$start")->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()
            ->getStyle("A$start:K$start")
            ->applyFromArray(
                array(
                    'fill' => array(
                        'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '219af0')
                    )
                )
            );
        $objPHPExcel->getActiveSheet()->getStyle("A$start:S$start")->getAlignment()->setWrapText(true);
        $offset = $start = 2;

        foreach ($data as $k => $v) {
            $ary_col_merge = array(
                'A' => array('w' => 15, 'val' => $k+1),
                'B' => array('w' => 25, 'val' => $v->code),
                'C' => array('w' => 15, 'val' => $v->name),
                'D' => array('w' => 15, 'val' => $v->class),
                'E' => array('w' => 15, 'val' => $v->org),
                'F' => array('w' => 15, 'val' => $v->position),
                'G' => array('w' => 15, 'val' => $v->suppervisor),
                'H' => array('w' => 15, 'val' => $v->supervisor_pos),
                'I' => array('w' => 15, 'val' => $v->period),
                'J' => array('w' => 15, 'val' => isset(\cglobal::$type_of_internship[$v->type_of_internship]) ? \cglobal::$type_of_internship[$v->type_of_internship] : ''),
                'K' => array('w' => 15, 'val' => date('H:i d/m/Y', $v->date_c)),
            );

            foreach ($ary_col_merge as $col => $val) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue("$col$offset", $val['val']);
                $objPHPExcel->getActiveSheet()->getStyle("$col$offset")->applyFromArray(array(
                    'font' => array(
                        'name' => 'arial'
                    )
                ));
            }

            $objPHPExcel->getActiveSheet()->getStyle("A".($start-1).":K$offset")->applyFromArray(
                array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => \PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('rgb' => '333333')
                        )
                    )
                )
            );
            unset($data[$k]);
            $offset++;
        }

//        $filename = ('Report ' . date('d-m-Y H:i') . '.xlsx');
//        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//        header('Content-Disposition: attachment;filename="'.$filename.'"');
//        header('Cache-Control: max-age=0');
//        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//        ob_end_clean();
//        $objWriter->save('php://output');
//        exit;


        $filename = ('Internship Evaluation From' . date('d-m-Y H:i') . '.xls');
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename={$filename}");
        header("Cache-Control: max-age=0");
//        ob_clean();
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save("php://output");
        exit;
    }

    private static function sExcel(){
        $aryStyleExcel = array();
        $aryStyleExcel['default_border'] = $default_border = array(
            'style' => \PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '000000')
        );
        $aryStyleExcel['style_header'] = array(
            'borders' => array(
                'bottom' => $default_border,
                'left' => $default_border,
                'top' => $default_border,
                'right' => $default_border,
            ),
            'fill' => array(
                'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '33CCCC'),
            ),
            'font' => array(
                'bold' => true,
            )
        );
        $aryStyleExcel['ary_cell_attr'] = array(
            'font' => array(
                'italic' => false,
                'size' => 12
            ),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'wrap' => true
            )
        );
    }

}
