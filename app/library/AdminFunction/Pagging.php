<?php
/**
 * Created by JetBrains PhpStorm.
 * User: TuanNguyenAnh
 * Date: 6/23/14
 * Time: 3:50 PM
 * To change this template use File | Settings | File Templates.
 */
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
    static function parseNewLink($page = 1, $class="", $title="", $page_name = 'page_no',$dataSearch){
        $param = $dataSearch;
        $action = Route::currentRouteAction();
        $param[$page_name] = $page;
        if($class == 'active'){
            return '<li class="'.$class.'"><a href="#" title="xem trang '.$title.'">'.$title.'</a></li>';
        }
        return '<li class="'.$class.'"><a href="'.action($action, $param).'" title="xem trang '.$title.'">'.$title.'</a></li>';
    }

    // phan trang tren site

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
        $action = Route::currentRouteAction();
        $param[$page_name] = $page;
        if($class == 'active' || $class == "first disabled"){
            return '<a class="'.$class.'"  title="xem trang '.$title.'">'.$title.'</a> ';
        }
        return '<a class="'.$class.'" href="'.action($action, $param).'" title="xem trang '.$title.'">'.$title.'</a> ';
    }
}
