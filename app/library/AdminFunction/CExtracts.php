<?php
/*
* @Created by: QuynhTM
* @Author	 : manhquynh1984@gmail.com
* @Date 	 : 04/2019
* @Version	 : 1.0
*/
namespace App\Library\AdminFunction;

use PhpOffice\PhpWord\IOFactory;

class CExtracts{
    static $arrTypeQuestion = ['NB.'=>STATUS_INT_MOT, 'TH.'=>STATUS_INT_HAI, 'VD.'=>STATUS_INT_BA, 'VDC.'=>STATUS_INT_BON];
    static $arrTypeQuestionText = [STATUS_INT_MOT=>'Nhận biết', STATUS_INT_HAI=>'Thông hiểu', STATUS_INT_BA=>'Vận dụng', STATUS_INT_BON=>'Vận dụng cao'];
    static $typeQuestionDefault = 1;
    /*
     A.Tệp có định dạng: .docx

     B.Quy định dữ liệu Mẫu câu hỏi:
     1.Ký hiệu câu hỏi:
        - Câu hỏi mức độ kiến thức nhận biết: <NB>
        - Câu hỏi mức độ kiến thức thông hiểu: <TH>
        - Câu hỏi mức độ kiến thức vận dụng: <VD>
        - Câu hỏi mức độ kiến thức vận dụng cao: <VDC>
        - Câu hỏi tự luận: <@>
     2.Ký hiệu các đáp án: <#>
     3.Ký hiệu đáp án Đúng: <#><$>
    */

    /*
     pathFile: Đường dẫn file
     return: Misc data
    */
    public static function extractsText($pathFile=''){
        if(is_file($pathFile)){
            $phpWord = IOFactory::load($pathFile);
            if(sizeof($phpWord) > 0){
                $sections = $phpWord->getSections();
                if(!empty($sections)){
                    $arrText = [];
                    foreach($sections as $s) {
                        $els = $s->getElements();
                        if(!empty($els)){
                            foreach ($els as $elementKey => $elementValue) {
                                if($elementValue instanceof \PhpOffice\PhpWord\Element\TextRun) {
                                    $secondSectionElement = $elementValue->getElements();
                                    $text = '';
                                    foreach($secondSectionElement as $secondSectionElementKey => $secondSectionElementValue) {
                                        if($secondSectionElementValue instanceof \PhpOffice\PhpWord\Element\Text) {
                                            $text .= $secondSectionElementValue->getText();
                                        }
                                    }
                                    $arrText[] = $text;
                                }
                            }
                        }
                    }
                    return $arrText;
                }else{
                    die('Tệp nội dung chưa đúng định dạng!');
                }
            }else{
                die('Không load được nội dung tệp!');
            }
        }
        die('Đường dẫn tệp không tồn tại!');
    }
    //$arrCheck: NB., TH., VD., VDC.
    public static function extractsQuestions($arrText=array(), $arrCheck=array()){
        $result = array();
        if(is_array($arrText) && !empty($arrText)){
            $i = 0;
            foreach($arrText as $k=>$item){
                $item = trim($item);
                if(!empty($arrCheck)){
                    foreach($arrCheck as $check){
                        $arrX = explode($check, $item);
                        if(count($arrX) == 2){
                            $i++;
                            $result[$i]['CH'] = trim(str_replace($check, '', $item));
                            $result[$i]['type'] = $check;
                        }else{
                            //True
                            $arrX = explode('#$.', $item);
                            if(count($arrX) == 2){
                                $result[$i]['TL'] =  trim(str_replace('#$.', '', $item));
                            }
                            //False
                            $arrX = explode('#.', $item);
                            if(count($arrX) == 2){
                                $result[$i][$k] =  trim(str_replace('#.', '', $item));
                            }
                        }
                    }
                }
            }
        }
        return $result;
    }
    public static function extractsCreateOneQuestions($data=array(), $dataSearch=array()){
        $listData = array();
        if(!empty($data)){
            foreach($data as $k => $item){
                $tmp = [];
                $i = 0;
                if(isset($item['type'])){
                    $tmp['question_type'] = isset(CExtracts::$arrTypeQuestion[$item['type']]) ? CExtracts::$arrTypeQuestion[$item['type']] : CExtracts::$typeQuestionDefault;
                    unset($item['type']);
                }
                foreach($item as $_k => $v){
                    if($_k == 'CH'){
                        $tmp['question_name'] = $item['CH'];
                    }else{
                        $i++;
                        if($_k == 'TL'){
                            $tmp['correct_answer'] = $i;

                        }
                        $tmp['answer_'.$i] = $v;

                    }
                }
                $tmp['created_at'] = date('Y-m-d H:i:s', time());
                $tmp['question_school_block'] = isset($dataSearch['question_school_block']) ? $dataSearch['question_school_block'] : 0;
                $tmp['question_subject'] = isset($dataSearch['question_subject']) ? $dataSearch['question_subject'] : 0;
                $tmp['question_thematic'] = isset($dataSearch['question_thematic']) ? $dataSearch['question_thematic'] : 0;
                $listData[] = $tmp;
            }
        }
        return $listData;
    }
}