<?php
/*
* @Created by: QuynhTM
* @Author    : manhquynh1984@gmail.com
* @Date      : 13/03/2020
* @Version   : 1.0
*/

namespace App\Services;


use Illuminate\Contracts\View\View;

/**
 * Class ExportExcelView
 * @package App\Services
 * Các function liên quan đến export excel with template
 */
class ExportExcelView {
    public function outExcel():View{
        return view('template_view',['dataView'=>[]]);
    }
}