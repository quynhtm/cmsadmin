<?php
Route::get('/', array('as' => 'site.home','uses' => DIR_PRO_FRONTEND.'\SiteShopController@index'));

Route::get('/san-pham.html', array('as' => 'site.indexProduct','uses' => DIR_PRO_FRONTEND.'\SiteShopController@indexProduct'));
Route::get('/tim-kiem-san-pham.html', array('as' => 'site.searchProduct','uses' => DIR_PRO_FRONTEND.'\SiteShopController@searchProduct'));
Route::get('chi-tiet-san-pham.html',array('as' => 'site.indexDetailProduct','uses' =>DIR_PRO_FRONTEND.'\SiteShopController@indexDetailProduct'));
Route::get('san-pham-quan-tam.html',array('as' => 'site.indexProductCare','uses' =>DIR_PRO_FRONTEND.'\SiteShopController@indexProductCare'));

Route::get('tin-tuc.html',array('as' => 'site.indexNew','uses' =>DIR_PRO_FRONTEND.'\SiteShopController@indexNew'));
Route::get('tin-tuc/c{cat_id}/{new_id}-{new_name}.html',array('as' => 'site.indexDetailNews','uses' =>DIR_PRO_FRONTEND.'\SiteShopController@indexDetailNews'));
//Route::get('tin-tuc/c{cat_id}/{new_id}-{new_name}.html',array('as' => 'site.detailNew','uses' =>DIR_PRO_FRONTEND.'\SiteShopController@detailNew'))->where('cat_id', '[0-9]+')->where('new_id', '[0-9]+');
Route::get('thong-tin-faq.html',array('as' => 'site.indexDetailFaq','uses' =>DIR_PRO_FRONTEND.'\SiteShopController@indexDetailFaq'));

Route::get('tuyen-dung.html',array('as' => 'site.indexRecruitment','uses' =>DIR_PRO_FRONTEND.'\SiteShopController@indexRecruitment'));
Route::get('chi-tiet-tuyen-dung.html',array('as' => 'site.indexDetailRecruitment','uses' =>DIR_PRO_FRONTEND.'\SiteShopController@indexDetailRecruitment'));

Route::get('dang-nhap.html',array('as' => 'site.indexLoginShop','uses' =>DIR_PRO_FRONTEND.'\SiteShopController@indexLoginShop'));
Route::get('dang-ky.html',array('as' => 'site.indexRegistrationShop','uses' =>DIR_PRO_FRONTEND.'\SiteShopController@indexRegistrationShop'));

Route::get('/lien-he.html', array('as' => 'site.contactShop','uses' => DIR_PRO_FRONTEND.'\SiteShopController@indexContact'));
Route::post('/lien-he.html', array('as' => 'site.contactShop','uses' => DIR_PRO_FRONTEND.'\SiteShopController@indexContact'));





Route::get('/{cat}/{id}-{name}.html',array('as' => 'site.detailProduct','uses' =>DIR_PRO_FRONTEND.'\SiteShopController@detailProduct'));//chi tiết sản phẩm
Route::get('/depart/nhapkhau-{depart_id}/{depart_name}.html',array('as' => 'site.listProductWithDepart','uses' =>DIR_PRO_FRONTEND.'\SiteShopController@listProductWithDepart'));//list sản phẩm theo depart
Route::get('/hang-nhap-khau/c-{category_id}/{category_name}.html',array('as' => 'site.listProductWithCategory','uses' =>DIR_PRO_FRONTEND.'\SiteShopController@listProductWithCategory'));//list sản phẩm theo danh mục
Route::get('/san-pham-moi.html', array('as' => 'site.listProductNew','uses' => DIR_PRO_FRONTEND.'\SiteShopController@listProductNew'));

Route::get('/hashtag/tag-{tag_id}/{tag_name}.html',array('as' => 'site.listProductWithTag','uses' =>DIR_PRO_FRONTEND.'\SiteShopController@listProductWithTag'));//list sản phẩm theo hashtag
Route::get('/campaign/c{camp_id}/{camp_name}.html',array('as' => 'site.listProductWithCampaign','uses' =>DIR_PRO_FRONTEND.'\SiteShopController@listProductWithCampaign'));//list sản phẩm theo campagn



//Gio hang
Route::get('/gio-hang.html', array('as' => 'site.cartProduct','uses' => DIR_PRO_FRONTEND.'\SiteShopController@indexCart'));
Route::get('/dat-hang.html', array('as' => 'site.indexCartOrder1','uses' => DIR_PRO_FRONTEND.'\SiteShopController@indexCartOrder1'));
Route::get('/xac-nhan-dat-hang.html', array('as' => 'site.indexCartOrder2','uses' => DIR_PRO_FRONTEND.'\SiteShopController@indexCartOrder2'));
Route::get('/thanh-toan.html', array('as' => 'site.indexCartOrder3','uses' => DIR_PRO_FRONTEND.'\SiteShopController@indexCartOrder3'));

Route::post('/ajaxAddCart', array('as' => 'site.ajaxAddCart','uses' => DIR_PRO_FRONTEND.'\ShopCartController@ajaxAddCart'));
//Route::post('/gio-hang.html', array('as' => 'site.cartProduct','uses' => DIR_PRO_FRONTEND.'\SiteShopController@cartProduct'));
//Route::post('/deleteOneProductInCart', array('as' => 'site.deleteOneItemInCart','uses' => DIR_PRO_FRONTEND.'\ShopCartController@deleteOneItemInCart'));
//Route::get('/thong-tin-thanh-toan.html', array('as' => 'site.inforRepaymentsOrder','uses' => DIR_PRO_FRONTEND.'\SiteShopController@inforRepaymentsOrder'));
//Route::post('/sendOrderToCart',array('as' => 'site.sendOrderToCart','uses' =>DIR_PRO_FRONTEND.'\ShopCartController@sendOrderToCart'));
//Route::get('/dat-hang-thanh-cong.html',array('as' => 'site.thanksBuy','uses' =>DIR_PRO_FRONTEND.'\SiteShopController@thanksBuy'));

//Route::get('n-{id}/{name}.html',array('as' => 'site.listNewSearch','uses' =>'SiteHomeController@listNewSearch'))->where('id', '[0-9]+');


