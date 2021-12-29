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
use App\Services\ServiceCommon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class SiteShopController extends BaseSiteController
{
    private $outDataCommon = [];
    private $commonService;
    private $partner = STATUS_INT_MOT;

    public function __construct()
    {
        parent::__construct();
        $this->commonService = new ServiceCommon();
    }

    public function index()
    {
        //30 sản phẩm mới nhất
        $arrProduct = $this->commonService->getSiteProduct(Products::productTypeNew, CGlobal::number_show_30, $this->partner);

        $arrProductNew = $arrProductBlock1 = $arrProductBlock2 = $arrProductBlock3 = [];
        if (!empty($arrProduct)) {
            foreach ($arrProduct as $key => $val) {
                if ($key < 10) {
                    $arrProductNew[] = $val;
                } elseif ($key >= 10 && $key < 16) {
                    $arrProductBlock1[] = $val;
                } elseif ($key >= 16 && $key < 22) {
                    $arrProductBlock2[] = $val;
                } elseif ($key >= 22 && $key < 28) {
                    $arrProductBlock3[] = $val;
                }
            }
        }

        //sản phẩm đặc biệt
        $arrProductAd = [
            1 => ['title' => 'Bán chạy', 'arrProduct' => $arrProductBlock1],
            2 => ['title' => 'Mới', 'arrProduct' => $arrProductBlock2],
            3 => ['title' => 'Khác', 'arrProduct' => $arrProductBlock3]
        ];

        //header
        $arrCategoryProduct = $this->commonService->getSiteCategoryProduct($this->partner);
        $arrBannerBig = $this->commonService->getSiteBannerHeaderBig($this->partner);
        $arrBannerSmall = $this->commonService->getSiteBannerHeaderSmall($this->partner);
        $arrBannerContent = $this->commonService->getSiteBannerContentProduct($this->partner);

        //tin tức
        $arrNewCommon = $this->commonService->getSiteNew(News::newsTypeCommon, CGlobal::number_show_4, $this->partner);
        $arrNewSite = $this->commonService->getSiteNew(News::newsTypeSite, CGlobal::number_show_4, $this->partner);

        return view('Frontend.Shop.Pages.home', array_merge([
            'arrProductNew' => $arrProductNew,
            'arrProductAd' => $arrProductAd,

            'arrBannerBig' => $arrBannerBig,
            'arrBannerSmall' => $arrBannerSmall,
            'arrBannerContent' => $arrBannerContent,
            'arrCategoryProduct' => $arrCategoryProduct,

            'arrNewCommon' => $arrNewCommon,
            'arrNewSite' => $arrNewSite,
        ], $this->outDataCommon));
    }

    //sản phẩm
    public function searchProduct()
    {
        return view('Frontend.Shop.Pages.listProduct', array_merge([
            'pageType' => STATUS_INT_HAI,
        ], $this->outDataCommon));
    }

    public function indexProduct()
    {
        return view('Frontend.Shop.Pages.listProduct', array_merge([
            'pageType' => STATUS_INT_MOT,
        ], $this->outDataCommon));
    }

    public function indexDetailProduct()
    {
        return view('Frontend.Shop.Pages.detailProduct');
    }

    public function indexProductCare()
    {
        return view('Frontend.Shop.Pages.productCare');
    }

    //tin tức
    public function indexNew()
    {
        return view('Frontend.Shop.Pages.listNews');
    }

    public function indexDetailNews($cat_id = 0, $new_id = 0, $new_name='tiêu đề')
    {
        if ($new_id <= 0) {
            return Redirect::route('site.home');
        }
        $inforNew = app(News::class)->getItemById($new_id);
        if (!isset($inforNew->id)) {
            return Redirect::route('site.home');
        }
        //seo
        $titleSearchName = env('PROJECT_NAME') . ' - ' . $inforNew->news_title;
        $meta_title = $titleSearchName;
        $meta_keywords = $titleSearchName;
        $meta_description = limit_text_word($inforNew->news_desc_sort);
        $meta_img = getLinkImageShow(FOLDER_NEWS.'/'.$inforNew->id,$inforNew->news_image);
        $url_detail = buildLinkDetailNew($inforNew->id, $inforNew->news_title, $inforNew->news_category);
        $this->commonService->getSeoSite($meta_img, $meta_title, $meta_keywords, $meta_description, $url_detail);

        return view('Frontend.Shop.Pages.detailNews', array_merge([
            'dataDetail' => $inforNew,
        ], $this->outDataCommon));
    }

    public function indexDetailFaq()
    {
        return view('Frontend.Shop.Pages.detailFAQ');
    }

    //Khác
    public function indexRecruitment()
    {
        return view('Frontend.Shop.Pages.ListRecruitment');
    }

    public function indexDetailRecruitment()
    {
        return view('Frontend.Shop.Pages.detailRecruitment');
    }

    public function indexContact()
    {
        return view('Frontend.Shop.Pages.contact');
    }

    public function indexLoginShop()
    {
        return view('Frontend.Shop.Pages.loginShop');
    }

    public function indexRegistrationShop()
    {
        return view('Frontend.Shop.Pages.registrationShop');
    }

    //giỏ hàng
    public function indexCart()
    {
        return view('Frontend.Shop.Pages.cart');
    }

    //đặt hàng
    public function indexCartOrder1()
    {
        return view('Frontend.Shop.Pages.cartOrder1');
    }

    //Xác nhận đơn hàng
    public function indexCartOrder2()
    {
        return view('Frontend.Shop.Pages.cartOrder2');
    }

    //thanh toán
    public function indexCartOrder3()
    {
        return view('Frontend.Shop.Pages.cartOrder3');
    }


    public function listProductNew()
    {
        $titleSearchName = env('PROJECT_NAME') . ' - Sản phẩm mới';
        $pageNo = (int)Request::get('page_no', 1);
        $limit = LIMIT_RECORD_40;
        $offset = ($pageNo - 1) * $limit;
        $search = $data = array();

        $search['field_order'] = 'product_id';
        $data = app(Product::class)->getProductForSite($search, $limit, $offset, false);
        $dataSearch = $data['data'];
        $paging = '';

        //seo
        $meta_title = $titleSearchName;
        $meta_keywords = $titleSearchName;
        $meta_description = $titleSearchName;
        $meta_img = '';
        $url_detail = URL::route('site.listProductNew');
        $this->commonService->getSeoSite($meta_img, $meta_title, $meta_keywords, $meta_description, $url_detail);

        $arrListCampaign = $this->commonService->getCampaignOnsite();
        FunctionLib::randomlyMergeData($arrListCampaign, $arrShowCampaign);

        return view('site.SiteShop.listProductWithDepart', array_merge([
            'paging' => $paging,
            'total' => $limit,
            'arrShowCampaign' => $arrShowCampaign,
            'is_category' => STATUS_INT_HAI,
            'titleSearchName' => 'Sản phẩm mới',
            'departName' => '',
            'departId' => 0,
            'dataSearch' => $dataSearch,
            'dataCateWithDepart' => []
        ], $this->outDataCommon));
    }

    /**
     * @param $cate_name
     * @param $pro_id
     * @param $pro_name
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detailProduct($cate_name, $pro_id, $pro_name)
    {
        if ($pro_id <= 0) {
            return Redirect::route('site.home');
        }
        $product = app(Product::class)->getItemById($pro_id);
        if (isset($product->product_id)) {
            //check sản phẩm lỗi
            if ((isset($product->product_status) && $product->product_status == STATUS_INT_KHONG) || (isset($product->is_block) && $product->is_block == STATUS_INT_KHONG)) {
                return Redirect::route('site.home');
            }
            //check hash tag null
            //check hash tag null
            if (empty($product->list_tag_id)) {
                $str_has_tag = app(Product::class)->getTagIdWithCate($product->category_id);
                if (trim($str_has_tag) != '') {
                    $dataSave['list_tag_id'] = $str_has_tag;
                    if (app(Product::class)->updateItem($product->product_id, $dataSave)) {
                        $product = app(Product::class)->getItemById($pro_id);
                    }
                }
            }
            //seo
            $titleSearchName = env('PROJECT_NAME') . ' - ' . $product->product_name;
            $meta_title = $titleSearchName;
            $meta_keywords = $titleSearchName;
            $meta_description = limit_text_word($product->product_sort_desc);

            $meta_img = ThumbImg::getImageThumb(FOLDER_PRODUCT, $product->product_id, $product->product_image);
            $url_detail = buildLinkDetailProduct($product->product_id, $product->product_name, $product->category_name);
            $this->commonService->getSeoSite($meta_img, $meta_title, $meta_keywords, $meta_description, $url_detail);

            //sản phẩm liên quan
            $arrRelatedProducts = $this->commonService->getRelatedProducts($product->toArray());

            //campaing
            $arrListCampaign = $this->commonService->getCampaignOnsite();
            FunctionLib::randomlyMergeData($arrListCampaign, $arrShowCampaign);

            $this->getCommonSite();
            $arrHashTag = app(Tag::class)->getOptionTag();
            return view('site.SiteShop.detailProduct', array_merge([
                'product' => $product,
                'arrHashTag' => $arrHashTag,
                'arrShowCampaign' => $arrShowCampaign,
                'arrRelatedProducts' => $arrRelatedProducts,
            ], $this->outDataCommon));
        }
        return Redirect::route('site.home');
    }

    /**
     * @param $depart_id
     * @param $name
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function listProductWithDepart($depart_id, $name)
    {
        if ($depart_id <= 0) {
            return Redirect::route('site.home');
        }
        if ($depart_id > 0) {
            $department = app(Department::class)->getItemById($depart_id);

            if (isset($department->department_id) && $department->department_id > 0 && isset($department->department_status) && $department->department_status == STATUS_INT_MOT) {
                $departName = $department->department_name;
                $pageNo = (int)Request::get('page_no', 1);
                $limit = LIMIT_RECORD_40;
                $offset = ($pageNo - 1) * $limit;
                $search = $data = array();

                $search['depart_id'] = (int)$department->department_id;
                $search['depart_name'] = strtolower(safe_title($department->department_name));
                $data = app(Product::class)->getProductForSite($search, $limit, $offset, true);
                $total = $data['total'];
                $dataSearch = $data['data'];
                $paging = $total > 0 ? Pagging::getNewPager(3, $pageNo, $total, $limit, $search) : '';

                //danh mục của sản phẩm theo departs
                $dataCateWithDepart = ($total > 0) ? app(Product::class)->getListCateByDepart($depart_id) : [];

                //seo
                $titleSearchName = env('PROJECT_NAME') . ' - ' . $department->department_name;
                $meta_title = $titleSearchName;
                $meta_keywords = $titleSearchName;
                $meta_description = $titleSearchName;
                $meta_img = '';
                $url_detail = buildLinkProductWithDepart($depart_id, $department->department_name);
                $this->commonService->getSeoSite($meta_img, $meta_title, $meta_keywords, $meta_description, $url_detail);

                $arrListCampaign = $this->commonService->getCampaignOnsite();
                FunctionLib::randomlyMergeData($arrListCampaign, $arrShowCampaign);

                $this->getCommonSite();
                return view('site.SiteShop.listProductWithDepart', array_merge([
                    'paging' => $paging,
                    'total' => $total,
                    'arrShowCampaign' => $arrShowCampaign,
                    'is_category' => STATUS_INT_KHONG,
                    'titleSearchName' => $departName,
                    'dataCateWithDepart' => convertToArray($dataCateWithDepart),
                    'dataSearch' => $dataSearch,
                ], $this->outDataCommon));
            }
        }
        return Redirect::route('site.home');
    }

    /**
     * @param $tag_id
     * @param $name
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function listProductWithTag($tag_id, $name)
    {
        if ($tag_id <= 0) {
            return Redirect::route('site.home');
        }
        if ($tag_id > 0 && trim($name) != '') {
            $arrTagCode = app(Tag::class)->getOptionTag(true);
            $arrTagName = app(Tag::class)->getOptionTag();
            $tagNameCheck = FunctionLib::stringtitle(trim($name));
            $tag_name = isset($arrTagCode[$tag_id]) ? $arrTagCode[$tag_id] : '';
            if (in_array($tagNameCheck, $arrTagCode) && strcmp(trim($tagNameCheck), trim($tag_name)) == 0) {
                $tagName = '#' . ((isset($arrTagName[$tag_id])) ? $arrTagName[$tag_id] : $name);
                $pageNo = (int)Request::get('page_no', 1);
                $limit = LIMIT_RECORD_40;
                $offset = ($pageNo - 1) * $limit;
                $search = $data = array();

                $search['tag_id'] = $tag_id;
                $data = app(Product::class)->searchWithProductTags($search, $limit, $offset, true);
                $total = $data['total'];
                $dataSearch = $data['data'];
                $paging = $total > 0 ? Pagging::getNewPager(3, $pageNo, $total, $limit, $search) : '';

                //seo
                $titleSearchName = env('PROJECT_NAME') . ' - ' . $tagName;
                $meta_title = $titleSearchName;
                $meta_keywords = $titleSearchName;
                $meta_description = $titleSearchName;
                $meta_img = '';
                $url_detail = buildLinkProductWithTag($tag_id, $name);
                $this->commonService->getSeoSite($meta_img, $meta_title, $meta_keywords, $meta_description, $url_detail);

                $arrListCampaign = $this->commonService->getCampaignOnsite();
                FunctionLib::randomlyMergeData($arrListCampaign, $arrShowCampaign);

                $this->getCommonSite();
                return view('site.SiteShop.listProductWithDepart', array_merge([
                    'paging' => $paging,
                    'total' => $total,
                    'arrShowCampaign' => $arrShowCampaign,
                    'is_category' => STATUS_INT_HAI,
                    'titleSearchName' => $tagName,
                    'departName' => '',
                    'departId' => 0,
                    'dataSearch' => $dataSearch,
                    'dataCateWithDepart' => []
                ], $this->outDataCommon));
            }
        }
        return Redirect::route('site.home');
    }

    /**
     * @param $tag_id
     * @param $name
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function listProductWithCampaign($camp_id, $name)
    {
        if ($camp_id <= 0) {
            return Redirect::route('site.home');
        }
        if ($camp_id > 0 && trim($name) != '') {
            $arrListCampaign = $this->commonService->getCampaignOnsite();
            $campNameCheck = FunctionLib::stringtitle(trim($name));
            $campName = isset($arrListCampaign[$camp_id]['campaign_name']) ? $arrListCampaign[$camp_id]['campaign_name'] : '';

            if (!empty($arrListCampaign) && in_array($camp_id, array_keys($arrListCampaign)) && strcmp(trim($campNameCheck), FunctionLib::stringtitle(strtolower(safe_title($campName)))) == 0) {
                $tagName = ((isset($arrListCampaign[$camp_id]['campaign_name'])) ? $arrListCampaign[$camp_id]['campaign_name'] : $name);

                $pageNo = (int)Request::get('page_no', 1);
                $limit = LIMIT_RECORD_40;
                $offset = ($pageNo - 1) * $limit;
                $search = $data = array();

                $search['tag_id'] = $camp_id;
                $dataSearch = app(Campaign::class)->getListProductCampaignById($camp_id);

                $total = count($dataSearch);
                $paging = '';

                //seo
                $titleSearchName = env('PROJECT_NAME') . ' - ' . $tagName;
                $meta_title = $titleSearchName;
                $meta_keywords = $titleSearchName;
                $meta_description = $titleSearchName;
                $meta_img = getLinkImage(FOLDER_CAMPAIGN . '/' . $arrListCampaign[$camp_id]['campaign_id'], $arrListCampaign[$camp_id]['campaign_image']);
                $url_detail = buildLinkProductWithCampaign($camp_id, $name);
                $this->commonService->getSeoSite($meta_img, $meta_title, $meta_keywords, $meta_description, $url_detail);


                $this->getCommonSite();
                return view('site.SiteShop.listProductWithDepart', array_merge([
                    'paging' => $paging,
                    'total' => $total,
                    'arrShowCampaign' => [],
                    'is_category' => STATUS_INT_HAI,
                    'titleSearchName' => $tagName,
                    'departName' => '',
                    'departId' => 0,
                    'dataSearch' => $dataSearch,
                    'dataCateWithDepart' => []
                ], $this->outDataCommon));
            }
        }
        return Redirect::route('site.home');
    }

    /**
     * @param $cate_id
     * @param $name
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function listProductWithCategory($cate_id, $name)
    {
        if ($cate_id <= 0) {
            return Redirect::route('site.home');
        }
        if ($cate_id > 0) {
            $category = app(Category::class)->getItemById($cate_id);
            if (isset($category->category_id) && $category->category_id > 0 && isset($category->category_status) && $category->category_status == STATUS_INT_MOT) {
                $categoryName = $category->category_name;
                $pageNo = (int)Request::get('page_no', 1);
                $limit = LIMIT_RECORD_40;
                $offset = ($pageNo - 1) * $limit;
                $search = $data = array();

                $search['category_id'] = (int)$category->category_id;
                $search['category_name'] = strtolower(safe_title($category->category_name));
                $data = app(Product::class)->getProductForSite($search, $limit, $offset, true);
                $total = $data['total'];
                $dataSearch = $data['data'];

                $departId = 0;
                if (!empty($dataSearch)) {
                    foreach ($dataSearch as $ite) {
                        $departId = $ite->depart_id;
                        break;
                    }
                }
                $department = app(Department::class)->getItemById($departId);
                $departName = isset($department->department_id) ? $department->department_name : '';
                $paging = $total > 0 ? Pagging::getNewPager(3, $pageNo, $total, $limit, $search) : '';

                //seo
                $titleSearchName = env('PROJECT_NAME') . ' - ' . $categoryName;
                $meta_title = $titleSearchName;
                $meta_keywords = $titleSearchName;
                $meta_description = $titleSearchName;
                $meta_img = '';
                $url_detail = buildLinkProductWithCategory($category->category_id, $category->category_name);
                $this->commonService->getSeoSite($meta_img, $meta_title, $meta_keywords, $meta_description, $url_detail);

                $arrListCampaign = $this->commonService->getCampaignOnsite();
                FunctionLib::randomlyMergeData($arrListCampaign, $arrShowCampaign);

                $this->getCommonSite();
                return view('site.SiteShop.listProductWithDepart', array_merge([
                    'paging' => $paging,
                    'total' => $total,
                    'arrShowCampaign' => $arrShowCampaign,
                    'is_category' => STATUS_INT_MOT,
                    'titleSearchName' => $categoryName,
                    'departName' => $departName,
                    'departId' => $departId,
                    'dataSearch' => $dataSearch,
                    'dataCateWithDepart' => []
                ], $this->outDataCommon));
            }
        }
        return Redirect::route('site.home');
    }

    /**
     * Search tìm kiếm theo tên sản phẩm
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function cartProduct()
    {
        $cartShop = Session::get(SESSION_SHOP_CART);
        if (empty($cartShop)) {
            return Redirect::route('site.home');
        }

        //cập nhật số lượng sản phẩm trong giỏ hàng
        if (!empty($_POST)) {
            $token = Request::get('_token', '');
            $quantity = Request::get('quantity', []);
            if (Session::token() === $token) {
                if (!empty($quantity)) {
                    foreach ($quantity as $pro_id => $number) {
                        if (isset($cartShop[$pro_id]) && $cartShop[$pro_id]['number'] != $number) {
                            $cartShop[$pro_id]['number'] = $number;
                        }
                    }
                    Session::put(SESSION_SHOP_CART, $cartShop, 60 * 24);
                    Session::save();
                }
            }
        }
        $this->getCommonSite();
        $this->commonService->getSeoSite();

        return view('site.SiteShop.cart', array_merge([
            'cartShop' => $cartShop,
        ], $this->outDataCommon));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function inforRepaymentsOrder()
    {
        $cartShop = Session::get(SESSION_SHOP_CART);
        if (empty($cartShop)) {
            return Redirect::route('site.home');
        }
        $this->getCommonSite();
        $this->commonService->getSeoSite();
        return view('site.SiteShop.inforRepaymentsOrder', array_merge([
            'cartShop' => $cartShop,
        ], $this->outDataCommon));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function thanksBuy()
    {
        $pageNo = (int)Request::get('page_no', 1);
        $limit = LIMIT_RECORD_8;
        $offset = ($pageNo - 1) * $limit;
        $search = $data = array();

        $search['field_order'] = 'product_id';
        $data = app(Product::class)->getProductForSite($search, $limit, $offset, false);
        $total = $data['total'];
        $dataSearch = $data['data'];
        $paging = '';

        //seo
        $titleSearchName = env('PROJECT_NAME') . ' - ' . ' Đặt hàng thành công';
        $meta_title = $titleSearchName;
        $meta_keywords = $titleSearchName;
        $meta_description = $titleSearchName;
        $meta_img = '';
        $url_detail = URL::route('site.thanksBuy');
        $this->commonService->getSeoSite($meta_img, $meta_title, $meta_keywords, $meta_description, $url_detail);

        $this->getCommonSite();
        return view('site.SiteShop.thankAfterBuy', array_merge([
            'paging' => $paging,
            'total' => $total,
            'is_category' => STATUS_INT_MOT,
            'titleSearchName' => 'Đặt hàng thành công',
            'departName' => '',
            'departId' => STATUS_INT_KHONG,
            'dataSearch' => $dataSearch,
            'dataCateWithDepart' => []
        ], $this->outDataCommon));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function contactShop222()
    {
        //seo
        $titleSearchName = env('PROJECT_NAME') . ' - ' . ' Liên hệ với shopcuatui';
        $meta_title = $titleSearchName;
        $meta_keywords = $titleSearchName;
        $meta_description = $titleSearchName;
        $meta_img = '';
        $url_detail = URL::route('site.contactShop');
        $this->commonService->getSeoSite($meta_img, $meta_title, $meta_keywords, $meta_description, $url_detail);
        $msg_succ = '';
        if (isset($_POST) && !empty($_POST)) {
            $token = Request::get('_token', '');
            if (Session::token() === $token) {
                $contact_user_name_send = Security::cleanText(addslashes(Request::get('contact_user_name_send', '')));
                $contact_phone_send = Security::cleanText(addslashes(Request::get('contact_phone_send', '')));
                $contact_email_send = Security::cleanText(addslashes(Request::get('contact_email_send', '')));
                $contact_title = Security::cleanText(addslashes(Request::get('contact_title', '')));
                $contact_content = Security::cleanText(addslashes(Request::get('contact_content', '')));
                if (trim($contact_user_name_send) != '' && trim($contact_phone_send) != '' && trim($contact_email_send) != '' && trim($contact_title) != '' && trim($contact_content) != '') {
                    $dataInsert = ['contact_title' => $contact_title,
                        'contact_content' => $contact_content,
                        'contact_user_name_send' => $contact_user_name_send,
                        'contact_phone_send' => $contact_phone_send,
                        'contact_time_creater' => time(),
                        'contact_email_send' => $contact_email_send];
                    if (self::checkDataContactInput($dataInsert)) {
                        if (app(Contact::class)->createItem($dataInsert)) {
                            $msg_succ = 'Liên hệ của bạn đã được gửi tới Shopcuatui <br> Shopcuatui sẽ liên hệ với bạn sớm nhất.<br> Cám ơn bạn đã quan tâm đến shopcuatui.';
                        }
                    }
                }
            }
        }
        $this->getCommonSite();
        return view('site.SiteShop.contact', array_merge([
            'data' => [],
            'msg_succ' => $msg_succ,
        ], $this->outDataCommon));
    }

    private function checkDataContactInput($dataInsert)
    {
        $isOk = true;
        if (!empty($dataInsert)) {
            if (strcmp($dataInsert['contact_phone_send'], $dataInsert['contact_user_name_send']) == 0 ||
                strcmp($dataInsert['contact_phone_send'], $dataInsert['contact_email_send']) == 0 ||
                strcmp($dataInsert['contact_email_send'], $dataInsert['contact_user_name_send']) == 0) {
                return false;
            }
            if (!FunctionLib::checkPhoneNumber($dataInsert['contact_phone_send'])) {
                return false;
            }
            if (!FunctionLib::checkRegexEmail($dataInsert['contact_email_send'])) {
                return false;
            }
        }
        return $isOk;
    }

    public function getCommonSite($action = STATUS_INT_KHONG)
    {
        $userAdmin = app(User::class)->user_login();
        return $this->outDataCommon = [
            'userAdmin' => !empty($userAdmin) ? $userAdmin : [],
            'header' => $this->header($action),
            'footer' => $this->footer($action),
        ];
    }

    public function actionRouter($catname, $catid)
    {

    }

    /***************************************************************************************************
     * Phần tin tức
     *****************************************************************************************************/
    public function detailNew($cat_id, $new_id, $new_name)
    {
        if ($new_id <= 0) {
            return Redirect::route('site.home');
        }
        $inforNew = app(News::class)->getItemById($new_id);
        if (isset($inforNew->news_id)) {
            //check sản phẩm lỗi
            if ((isset($inforNew->news_status) && $inforNew->news_status == STATUS_INT_KHONG)) {
                return Redirect::route('site.home');
            }

            //seo
            $titleSearchName = env('PROJECT_NAME') . ' - ' . $inforNew->news_title;
            $meta_title = $titleSearchName;
            $meta_keywords = $titleSearchName;
            $meta_description = limit_text_word($inforNew->news_desc_sort);

            $meta_img = ThumbImg::getImageThumb(FOLDER_NEWS, $inforNew->news_id, $inforNew->news_image);
            $url_detail = buildLinkDetailNew($inforNew->news_id, $inforNew->news_title, $inforNew->news_type);
            $this->commonService->getSeoSite($meta_img, $meta_title, $meta_keywords, $meta_description, $url_detail);

            //tin tức liên quan
            $pageNo = (int)Request::get('page_no', 1);
            $limit = LIMIT_RECORD_30;
            $offset = ($pageNo - 1) * $limit;
            $search = $data = array();
            $dataTop = $dataCenter = $dataLeft = array();

            $search['news_title'] = addslashes(Request::get('news_title', ''));
            $search['news_status'] = (int)Request::get('news_status', STATUS_DEFAULT);
            $search['news_type'] = (int)Request::get('news_type', STATUS_DEFAULT);
            $search['field_get'] = 'news_id,news_title,news_type,news_desc_sort,news_image';//cac truong can lay
            $data = app(News::class)->searchByCondition($search, $limit, $offset, true);
            if ($data['data']) {
                foreach ($data['data'] as $key => $news) {
                    if ($inforNew->news_id != $news->news_id) {
                        if ($key < 4) {
                            array_push($dataTop, $news);
                        } elseif ($key < 10) {
                            array_push($dataCenter, $news);
                        } elseif ($key < LIMIT_RECORD_30) {
                            array_push($dataLeft, $news);
                        } else {
                            break;
                        }
                    }

                }
            }

            //sản phẩm liên quan
            $arrProductNew = $this->commonService->getProductNew();
            $this->getCommonSite();
            return view('site.SiteShop.detailNews', array_merge([
                'inforNew' => $inforNew,
                'dataTop' => $dataTop,
                'dataCenter' => $dataCenter,
                'dataLeft' => $dataLeft,
                'arrProductNew' => $arrProductNew['pro_new'][0]['product'],
            ], $this->outDataCommon));
        }
        return Redirect::route('site.home');
    }
}
