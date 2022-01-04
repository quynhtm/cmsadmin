<?php
/*
* @Created by: QuynhTM
* @Date      : 09/2019
* @Version   : 1.0
*/

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseSiteController;
use App\Library\AdminFunction\CGlobal;
use App\Library\AdminFunction\FunctionLib;
use App\Library\AdminFunction\Pagging;
use App\Library\AdminFunction\Security;

use App\Models\Shop\Products;
use App\Models\Web\News;
use App\Models\Web\Reviews;
use App\Services\ServiceCommon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class AjaxActionShopController extends BaseSiteController
{
    private $outDataCommon = [];
    private $commonService;
    private $partner = STATUS_INT_MOT;
    private $sessionCart = SESSION_SHOP_CART;

    public function __construct()
    {
        parent::__construct();
        $this->commonService = new ServiceCommon();
    }

    public function ajaxAddCart()
    {
        //Session::forget($this->sessionCart);
        $result = ['intIsOK' => 0, 'msg' => 'Thêm giỏ hàng thất bại'];
        if (empty($_POST)) {
            return Response::json($result);
        }
        $pid = Request::get('pro_id');
        $number = (int)Request::get('number');
        $data = array();
        $product_id = getStrVar($pid);
        if ($product_id > 0 && $number > 0) {
            $product = app(Products::class)->getItemById($product_id);
            if (!isset($product->id)) {
                $result = ['intIsOK' => STATUS_INT_KHONG, 'msg' => 'Không tồn tại sản phẩm!'];
                return Response::json($result);
            }
            //Tam Het Hang
            /*if($product->is_sale != STATUS_INT_MOT){
                $result = ['intIsOK'=>STATUS_INT_KHONG,'msg'=>'Tạm hết hàng'];
                return Response::json($result);
            }*/
            if ($product->is_block == STATUS_INT_KHONG || $product->product_status == STATUS_INT_KHONG) {
                $result = ['intIsOK' => STATUS_INT_KHONG, 'msg' => 'Sản phẩm đang bị khóa!'];
                return Response::json($result);
            }
            if (Session::has($this->sessionCart)) {
                $data = Session::get($this->sessionCart);
                if (isset($data[$product_id])) {
                    $data[$product_id]['number'] += $number;
                    if ($data[$product_id]['number'] > LIMIT_RECORD_50) {
                        $data[$product_id]['number'] = LIMIT_RECORD_50;
                    }
                } else {
                    $data[$product_id] = [
                        'number' => $number,
                        'product_name' => $product->product_name,
                        'product_id' => $product->id,
                        'product_image' => $product->product_image,
                        'category_id' => $product->category_id,
                        'category_name' => $product->category_name,
                        'product_price_sell' => $product->product_price_sell
                    ];
                }
            } else {
                $data[$product_id] = [
                    'number' => $number,
                    'product_name' => $product->product_name,
                    'product_id' => $product->id,
                    'product_image' => $product->product_image,
                    'category_id' => $product->category_id,
                    'category_name' => $product->category_name,
                    'product_price_sell' => $product->product_price_sell
                ];
            }

            Session::put($this->sessionCart, $data, 60 * 24);
            Session::save();
            $totalCart = 0;
            $dataCart = Session::get($this->sessionCart);
            foreach ($dataCart as $pro => $v) {
                if (isset($v['number']) && $v['number'] > 0) {
                    $totalCart += $v['number'];
                }
            }
            $result = ['intIsOK' => STATUS_INT_MOT, 'totalCart' => $totalCart, 'msg' => 'Thêm giỏ hàng thành công'];
            return Response::json($result);
        }
        return Response::json($result);
    }

    public function deleteOneItemInCart()
    {
        $result = ['intIsOK' => 0, 'msg' => 'Xóa sản phẩm khỏi giỏ hàng không thành công.'];
        $pid = Request::get('pro_id');
        $product_id = getStrVar($pid);
        if ($product_id > 0) {
            if (Session::has($this->sessionCart)) {
                $data = Session::get($this->sessionCart);
                if (isset($data[$product_id])) {
                    unset($data[$product_id]);
                }
                Session::put($this->sessionCart, $data, 60 * 24);
                Session::save();
                $result = ['intIsOK' => STATUS_INT_MOT, 'msg' => 'Bỏ sản phẩm ra giỏ hàng thành công'];
            }
        }
        return Response::json($result);
    }

    public function sendOrderToCart()
    {
        $meta_title = $meta_keywords = $meta_description = 'Gửi thông tin đơn hàng';
        $meta_img = '';
        $this->commonService->getSeoSite($meta_img, $meta_title, $meta_keywords, $meta_description);

        $dataCart = $arrId = $search = $dataItem = array();
        if (Session::has($this->sessionCart)) {
            $dataCart = Session::get($this->sessionCart);
        }
        if (empty($dataCart)) {
            return Redirect::route('site.home');
        }

        if (!empty($dataCart)) {
            $arrId = array_keys($dataCart);
            if (!empty($arrId)) {
                $search['str_product_id'] = join(',', $arrId);
                //$dataItem = app(Product::class)->getProductForSite($search, count($arrId), 0, false);
            }
        }

        if (!empty($_POST) && !empty($arrId)) {
            $token = Request::get('_token', '');
            if (Session::token() === $token) {
                $txtName = Security::cleanText(addslashes(Request::get('firstname', '')));
                $txtMobile = Security::cleanText(addslashes(Request::get('telephone', '')));
                $txtEmail = Security::cleanText(addslashes(Request::get('email', '')));
                $txtAddress = Security::cleanText(addslashes(Request::get('address', '')));
                $txtMessage = Security::cleanText(addslashes(Request::get('comment', '')));

                //Check Mail Regex
                $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
                if (!preg_match($regex, $txtEmail)) {
                    $txtEmail = '';
                }

                if ($txtName != '' && $txtMobile != '' && $txtAddress != '') {
                    $arrOrderProductId = $arrId;
                    $total_money = $total_product = 0;
                    $productOrder = $dataOrder = array();
                    if (!empty($arrOrderProductId)) {
                        $arrProductId = array();
                        if (!empty($arrOrderProductId)) {
                            foreach ($arrOrderProductId as $pro) {
                                $arrProductId[] = (int)trim($pro);
                            }
                        }
                        if (!empty($arrProductId)) {
                            $search2['str_product_id'] = join(',', $arrProductId);
                            $inforProduct = app(Product::class)->getProductForSite($search2, count($arrId), 0, false);

                            if (!empty($inforProduct['data'])) {
                                foreach ($inforProduct['data'] as $k1 => $pro1) {
                                    $number_buy1 = isset($dataCart[$pro1->product_id]) ? (int)$dataCart[$pro1->product_id] : 0;
                                    $total_product += $number_buy1;
                                    $total_money += $number_buy1 * $pro1->product_price_sell;
                                }
                                //them vào bảng đơn hàng
                                $dataUserOrder = array(
                                    'order_customer_name' => $txtName,
                                    'order_customer_phone' => $txtMobile,
                                    'order_customer_email' => $txtEmail,
                                    'order_customer_address' => $txtAddress,
                                    'order_customer_note' => $txtMessage,
                                    'order_product_id' => implode(',', $arrId),
                                    'order_total_buy' => $total_product,
                                    'order_total_money' => $total_money,
                                    'order_type' => STATUS_INT_KHONG,
                                    'order_time_creater' => time(),
                                    'order_status' => STATUS_INT_MOT,
                                );
                                $order_id = app(Order::class)->createItem($dataUserOrder);

                                foreach ($inforProduct['data'] as $k => $pro) {
                                    $number_buy = isset($dataCart[$pro->product_id]) ? (int)$dataCart[$pro->product_id] : 0;
                                    $productOrder[$pro->product_id] = array(
                                        'product_id' => $pro->product_id,
                                        'product_name' => $pro->product_name,
                                        'product_price_sell' => $pro->product_price_sell,
                                        'product_price_input' => $pro->product_price_input,
                                        'product_category_id' => $pro->product_category_id,
                                        'product_category_name' => $pro->product_category_name,
                                        'product_type_price' => $pro->product_type_price,
                                        'number_buy' => $number_buy,
                                        'order_id' => $order_id,
                                        'product_image' => $pro->product_image,
                                    );
                                }
                                if (!empty($productOrder)) {
                                    app(OrderItem::class)->insertMultiple($productOrder);
                                }
                            }
                        }

                    }

                    //Gui Mail cho Khach Mua Hang
                    if (!empty($productOrder)) {
                        $emailCustomer = ($txtEmail != '') ? $txtEmail : CGlobal::emailAdmin;
                        $dataCustomer = array(
                            'txtName' => $txtName,
                            'txtMobile' => $txtMobile,
                            'txtEmail' => $emailCustomer,
                            'txtAddress' => $txtAddress,
                            'txtMessage' => $txtMessage,
                            'dataItem' => $productOrder,

                            'subjectMail' => 'Bạn đã đặt mua sản phẩm ngày' . date('d/m/Y h:i', time()),
                            'templateMail' => 'SendOrderToMailCustomer',
                        );

                        $emailsCustomerShop = [$emailCustomer];
                        $this->commonService->sendEmailCommon($emailsCustomerShop, $dataCustomer);
                    }

                    if (Session::has($this->sessionCart)) {
                        Session::forget($this->sessionCart);
                        return Redirect::route('site.thanksBuy');
                    }
                }
            }
        }
        return Redirect::route('site.inforRepaymentsOrder');
    }
}