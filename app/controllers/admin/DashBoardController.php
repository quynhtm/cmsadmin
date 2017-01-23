<?php
/**
 * Created by PhpStorm.
 * User: Tuan
 * Date: 29/05/2015
 * Time: 8:24 CH
 */

class DashBoardController extends BaseAdminController{
    private $error = array();
    public function __construct()
    {
        parent::__construct();
    }

    public function dashboard()
    {
        $error = Request::get('error',0);
        if($error == 1){
            $this->error[] = 'Bạn không có quyền truy cập.';
        }
        $this->layout->content = View::make('admin.DashBoard.index')->with('error',$this->error);
    }

}