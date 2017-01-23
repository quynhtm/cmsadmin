<?php
/*
* @Created by: DUYNX
* @Author    : nguyenduypt86@gmail.com
* @Date      : 11/2016
* @Version   : 1.0
*/

//Home
Route::any('/', array('as' => 'site.home','uses' => 'SiteHomeController@index'));
Route::get('404.html',array('as' => 'site.page404','uses' =>'SiteHomeController@page404'));
Route::get('tim-kiem.html',array('as' => 'site.searchItems','uses' =>'SiteHomeController@searchItems'));
Route::match(['GET','POST'],'lien-he.html',array('as' => 'site.pageContact','uses' =>'SiteHomeController@pageContact'));

//List Post Category
Route::get('{name}-{id}.html',array('as' => 'Site.pageCategory','uses' =>'SiteHomeController@pageCategory'))->where('name', '[A-Z0-9a-z_\-]+')->where('id', '[0-9]+');
Route::get('{catname}/{news_title}-{new_id}.html',array('as' => 'Site.pageDetailNew','uses' =>'SiteHomeController@pageDetailNew'))->where('catname', '[A-Z0-9a-z_\-]+')->where('news_title', '[A-Z0-9a-z_\-]+')->where('new_id', '[0-9]+');
Route::match(['GET','POST'],'tim-kiem.html',array('as' => 'site.pageSearch','uses' =>'SiteHomeController@pageSearch'));

//Partner, Video, Library
Route::match(['GET','POST'],'khach-hang.html',array('as' => 'site.pageCustomer','uses' =>'SiteHomeController@pageCustomer'));
Route::match(['GET','POST'],'video.html',array('as' => 'site.pageVideo','uses' =>'SiteHomeController@pageVideo'));
Route::match(['GET','POST'],'thu-vien-video/chi-tiet/{video_title}-{video_id}.html',array('as' => 'site.pageVideoDetail','uses' =>'SiteHomeController@pageVideoDetail'))->where('video_title', '[A-Z0-9a-z_\-]+')->where('video_id', '[0-9]+');

Route::match(['GET','POST'],'thu-vien-anh.html',array('as' => 'site.pageLibrary','uses' =>'SiteHomeController@pageLibrary'));
Route::match(['GET','POST'],'thu-vien-anh/chi-tiet/{image_title}-{image_id}.html',array('as' => 'site.pageLibraryDetail','uses' =>'SiteHomeController@pageLibraryDetail'))->where('image_title', '[A-Z0-9a-z_\-]+')->where('image_id', '[0-9]+');