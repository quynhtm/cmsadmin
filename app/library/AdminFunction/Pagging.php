<?php

namespace App\Library\AdminFunction;

use Illuminate\Support\Facades\Route;

class Pagging
{
    // phan trang dùng cho Boostrap
    public static function getNewPager($numPageShow = 10, $page = 1,$total = 1,$limit = 1,$dataSearch, $page_name = 'page_no'){
        $total_page = ceil($total/$limit);
        if($total_page == 1) return '';
        $next = '';
        $last = '';
        $prev = '';
        $first= '';
        $left_dot  = '';
        $right_dot = '';
        $from_page = $page - $numPageShow;
        $to_page = $page + $numPageShow;

        //get prev & first link
        if($page > 1){
            $prev = self::parseNewLink($page-1, '', "&lt; Trước", $page_name,$dataSearch);
            $first= self::parseNewLink(1, '', "&laquo; Đầu", $page_name,$dataSearch);
        }
        //get next & last link
        if($page < $total_page){
            $next = self::parseNewLink($page+1, '', "Sau &gt;", $page_name,$dataSearch);
            $last = self::parseNewLink($total_page, '', "Cuối &raquo;", $page_name,$dataSearch);
        }
        //get dots & from_page & to_page
        if($from_page > 0)	{
            $left_dot = ($from_page > 1) ? '<li><span>...</span></li>' : '';
        }else{
            $from_page = 1;
        }

        if($to_page < $total_page)	{
            $right_dot = '<li><span>...</span></li>';
        }else{
            $to_page = $total_page;
        }
        $pagerHtml = '';
        for($i=$from_page;$i<=$to_page;$i++){
            $pagerHtml .= self::parseNewLink($i, (($page == $i) ? 'active' : ''), $i, $page_name,$dataSearch);
        }
        return '<ul class="pagination">'.$first.$prev.$left_dot.$pagerHtml.$right_dot.$next.$last.'</ul>';
    }
    static function parseNewLink($page = 1, $class =" ", $title="", $page_name = 'page_no',$dataSearch){
        $param = $dataSearch;
        $action = self::getRouteAction();
        $param[$page_name] = $page;
        $class_page = 'paginate_button page-item ';
        if($class == 'active'){
            $class_page = $class_page.$class;
            return '<li class="'.$class_page.'"><a class="page-link" href="#" title="xem trang '.$title.'">'.$title.'</a></li>';
        }
        return '<li class="'.$class_page.'"><a class="page-link" href="'.action($action, $param).'" title="xem trang '.$title.'">'.$title.'</a></li>';
    }

    // phan trang tren site
    public static function pagingFrontend($numPageShow = 10, $page = 1,$total = 1,$limit = 1,$dataSearch, $page_name = 'page_no'){
        /*<ul class="uk-pagination uk-flex-center pagination" uk-margin>
            <li><a href="#"><span uk-pagination-previous></span></a></li>
            <li><a href="#">1</a></li>
            <li class="uk-disabled"><span>...</span></li>
            <li><a href="#">5</a></li>
            <li><a href="#">6</a></li>
            <li class="uk-active"><span>7</span></li>
            <li><a href="#">8</a></li>
            <li><a href="#"><span uk-pagination-next></span></a></li>
        </ul>*/

        $total_page = ceil($total/$limit);
        if($total_page == 1) return '';
        $next = '';
        $last = '';
        $prev = '';
        $first= '';
        $left_dot  = '';
        $right_dot = '';
        $from_page = $page - $numPageShow;
        $to_page = $page + $numPageShow;

        //get prev & first link
        if($page > 1){
            $prev = self::parseFrontendLink($page-1, '', 'Trước',"<span uk-pagination-previous></span>", $page_name,$dataSearch);
            $first= self::parseFrontendLink(1, '', 'Đầu',"<span uk-pagination-previous></span> <span uk-pagination-previous></span>", $page_name,$dataSearch);
        }
        //get next & last link
        if($page < $total_page){
            $next = self::parseFrontendLink($page+1, '', "Sau","<span uk-pagination-next></span>", $page_name,$dataSearch);
            $last = self::parseFrontendLink($total_page, '', "Cuối","<span uk-pagination-next></span> <span uk-pagination-next></span>", $page_name,$dataSearch);
        }
        //get dots & from_page & to_page
        if($from_page > 0)	{
            $left_dot = ($from_page > 1) ? '<li class="uk-disabled"><span>...</span></li>' : '';
        }else{
            $from_page = 1;
        }

        if($to_page < $total_page)	{
            $right_dot = '<li class="uk-disabled"><span>...</span></li>';
        }else{
            $to_page = $total_page;
        }
        $pagerHtml = '';
        for($i=$from_page;$i<=$to_page;$i++){
            $pagerHtml .= self::parseFrontendLink($i, (($page == $i) ? 'active' : ''), $i, $i, $page_name,$dataSearch);
        }
        return '<ul class="uk-pagination uk-flex-center pagination" uk-margin> '.$first.$prev.$left_dot.$pagerHtml.$right_dot.$next.$last.'</ul>';
    }
    static function parseFrontendLink($page = 1, $class =" ", $title="", $icons="", $page_name = 'page_no',$dataSearch){
        $param = $dataSearch;
        $action = self::getRouteAction();
        $param[$page_name] = $page;
        $class_page = '';
        if($class == 'active'){
            $class_page = $class_page.$class;
            return '<li class="uk-active"><a class="page-link" href="#" title="xem trang '.$title.'">'.$icons.'</a></li>';
        }
        return '<li class="'.$class_page.'"><a class="page-link" href="'.action($action, $param).'" title="xem trang '.$title.'">'.$icons.'</a></li>';
    }


    public static function getPagerSite($numPageShow = 4, $page = 1,$total = 1,$limit = 1,$page_name = 'page_no',$param){
        $total_page = ceil($total/$limit);
        if($total_page <= 1) return '';
        $next = '';
        //$last = '';
        $prev = '';
        //$first= '';
        $left_dot  = '';
        $right_dot = '';
        $from_page = $page - $numPageShow;
        $to_page = $page + $numPageShow;

        //get prev & first link
        if($page > 1){
            $prev = self::parseLinkSite($page-1, 'first', "<i class='fa fa-angle-double-left'></i>", $page_name,$param);
            //$first= self::parseNewLink(1, '', "&laquo; Đầu", $page_name);
        }else{
            $prev = self::parseLinkSite($page-1, 'first disabled', "<i class='fa fa-angle-double-left'></i>", $page_name,$param);
        }
        //get next & last link
        if($page < $total_page){
            $next = self::parseLinkSite($page+1, 'first', "<i class='fa fa-angle-double-right'></i>", $page_name,$param);
            //$last = self::parseNewLink($total_page, '', "Cuối &raquo;", $page_name);
        }else{
            $next = self::parseLinkSite($page+1, 'first disabled', "<i class='fa fa-angle-double-right'></i>", $page_name,$param);
        }
        //get dots & from_page & to_page
        if($from_page <= 0)	{
            $from_page = 1;
        }
//
        if($to_page >= $total_page)	{
            $to_page = $total_page;
        }
        $pagerHtml = '';
        for($i=$from_page;$i<=$to_page;$i++){
            $pagerHtml .= self::parseLinkSite($i, (($page == $i) ? 'active' : ''), $i, $page_name,$param);
        }
        return '<div class="pager">'.$prev.$pagerHtml.$next.'</div>';
    }
    static function parseLinkSite($page = 1, $class="", $title="", $page_name = 'page_no',$param=array()){
        $action = self::getRouteAction();
        $param[$page_name] = $page;
        if($class == 'active' || $class == "first disabled"){
            return '<a class="'.$class.'"  title="xem trang '.$title.'">'.$title.'</a> ';
        }
        return '<a class="'.$class.'" href="'.action($action, $param).'" title="xem trang '.$title.'">'.$title.'</a> ';
    }

    static function getRouteAction(){
        $action = Route::currentRouteAction();
        $pos1 = strrpos($action, 'Controllers');//9
        $action = substr($action, $pos1+12, strlen($action));
        return $action;
    }
}

