<?php

/**
 * Created by PhpStorm.
 * User: QuynhTM
 */
class CronjobsController extends BaseSiteController
{
    private  $sizeImageShowUpload = CGlobal::sizeImage_100;
	//cronjobs/runJobs?action=0
    function runJobs() {
        $action = Request::get('action', 0);//kiểu chạy joib
        switch( $action ){
            case 1://cập nhật link ảnh trong sản phẩm
			case 2://cập nhật link ảnh trong tin tức
                $this->updateLinkInContent($action);
                break;
			case 3://cập nhật email NCC
                $this->convertEmailProvider();
                break;
            default:
                break;
        }
        echo 'Bạn chưa chọn kiểu action';
    }

    public function updateLinkInContent($type = 0){
    	$total = 0;
    	switch( $type ){
        		case 1://cập nhật link ảnh trong sản phẩm
        			$dataSearch['field_get'] = 'item_id,item_content';
        			$data = Items::searchByCondition($dataSearch,500,0,$total);
        			if($data){
        				foreach($data as $k=>$product){
        					$content = stripcslashes($product->item_content);
        					
        					$url_old = '600x600';
        					$content = str_replace($url_old, '500x300',$content);
        					
        					$dataUpdate['item_content'] = $content;
        					Items::updateData($product->item_id,$dataUpdate);
        				}
        			}
        			break;
        		case 2://cập nhật link ảnh trong tin tức
        				$dataSearch['field_get'] = 'news_id,news_content';
        				$data = News::searchByCondition($dataSearch,1000,0,$total);
        				
        				if($data){
        					foreach($data as $k=>$product){
        						$content = stripcslashes($product->news_content);
        						 
        						$url_old1 = 'http://www.shopcuatui.com.vn/image.php?type_dir=news&amp;id='.$product->news_id.'&amp;width=700&amp;height=700&amp;image=';
        						$content1 = str_replace($url_old1, '',$content);
        						 
        						$url_old2 = 'http://shopcuatui.com.vn/image.php?type_dir=news&amp;id='.$product->news_id.'&amp;width=700&amp;height=700&amp;image=';
        						$content2 = str_replace($url_old2, '',$content1);
        						$dataUpdate['news_content'] = $content2;
        						 
        						News::updateData($product->news_id,$dataUpdate);
        					}
        				}
        				break;
        		default:
        			break;
        	}
            echo 'đã cập nhật xong';
        }

	public function convertEmailProvider(){
		die('dã chạy thêm dữ liệu');
		$total = 0;
		$dataSearch['field_get'] = 'provider_id,provider_name,provider_phone,provider_email';
		$dataProvider = ProviderEmail::searchByCondition($dataSearch,1000,0,$total);
		$total_insert = 0;
		if($dataProvider){
			foreach($dataProvider as $k=>$valu){
				if($valu->provider_email != ''){
					$insert = array('supplier_created'=>time(),
						'supplier_name'=>$valu->provider_name,
						'supplier_phone'=>$valu->provider_phone,
						'supplier_email'=>trim(str_replace(' ','',$valu->provider_email)));
					Supplier::addData($insert);
					$total_insert ++;
				}
			}
		}
		echo 'Tong ban dau: '.$total.'--- Tong them: '.$total_insert;
		//FunctionLib::debug($provider);
	}

}