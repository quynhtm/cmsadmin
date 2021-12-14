<?php
/**
 * Created by PhpStorm.
 * User: QuynhTM
 * Date: 10/17/2016
 * Time: 2:06 PM
 */

define('URL_IMAGE','https://demo.vn');

define('ERROR_PERMISSION',1);
define('MSG_ERROR','Có lỗi thao tác! Hãy thử lại.');
define('MSG_DATA_ERROR','Dữ liệu đầu vào không đúng.');
define('MSG_PERMISSION_ERROR','Bạn không có quyền thao tác.');

define('IMAGE_DIRECTORY','uploads');
define('AUDIO_DIRECTORY','demo');

define('ES_TYPE', '_doc');
define('LIMIT_ES_MAX', 100);
define('PAGE_SCROLL', 3);
define('LIMIT_RECORD_8', 8);
define('LIMIT_RECORD_10', 10);
define('LIMIT_RECORD_12', 12);
define('LIMIT_RECORD_15', 15);
define('LIMIT_RECORD_20', 20);
define('LIMIT_RECORD_24', 24);
define('LIMIT_RECORD_30', 30);
define('LIMIT_RECORD_40', 40);
define('LIMIT_RECORD_50', 50);
define('LIMIT_RECORD_100', 100);
define('LIMIT_RECORD_200', 200);
define('LIMIT_RECORD_300', 300);
define('LIMIT_RECORD_400', 400);
define('LIMIT_RECORD_500', 500);
define('LIMIT_RECORD_1000', 1000);
define('LIMIT_RECORD_2000', 2000);
define('LIMIT_RECORD_3000', 3000);
define('LIMIT_RECORD_4000', 4000);
define('LIMIT_RECORD_5000', 5000);
define('LIMIT_RECORD_10000', 10000);

define('TOTAL_DAY', 360);
define('NGAY', 'ngay');
define('THANG', 'thang');

define('VIETNAM_LANGUAGE', 1);
define('ENGLISH_LANGUAGE', 2);

define('STATUS_HIDE', 0);
define('STATUS_SHOW', 1);
define('STATUS_DEFAULT', -1);
define('STATUS_BLOCK', -2);
define('STATUS_NEW', 0);
define('STATUS_STOP', 2);
define('STATUS_DELETE', -3);

define('HA_NOI', 22);
define('TP_HCM', 29);

define('STATUS_MOI', 'moi');
define('STATUS_HOAT_DONG', 'hoat_dong');
define('STATUS_KHOA', 'khoa');
define('STATUS_KHOA_VINH_VIEN', 'khoa_vinh_vien');
define('DATA_SEARCH_NULL', 'DATA_SEARCH_NULL');

define('STATUS_INT_AM_HAI', -2);
define('STATUS_INT_AM_MOT', -1);
define('STATUS_INT_KHONG',  0);
define('STATUS_INT_MOT',    1);
define('STATUS_INT_HAI',    2);
define('STATUS_INT_BA',     3);
define('STATUS_INT_BON',    4);
define('STATUS_INT_NAM',    5);
define('STATUS_INT_SAU',    6);
define('STATUS_INT_BAY',    7);
define('STATUS_INT_TAM',    8);
define('STATUS_INT_CHIN',   9);
define('STATUS_INT_MUOI',   10);
define('STATUS_INT_MUOI_MOT',   11);
define('STATUS_INT_MUOI_HAI',   12);
define('STATUS_INT_MUOI_BA',   13);

define('CACHE_FIVE_MINUTE', 300);
define('CACHE_TEN_MINUTE', 600);
define('CACHE_THIRTY_MINUTE', 1800);
define('CACHE_ONE_HOUR', 3600);
define('CACHE_SIX_HOUR', 21600);
define('CACHE_ONE_DAY', 86400);
define('CACHE_TWO_DAY', 172800);
define('CACHE_THREE_DAY', 259200);
define('CACHE_SIX_DAY', 518400);
define('CACHE_ONE_WEEK', 604800);
define('CACHE_ONE_MONTH', 2592000);
define('CACHE_THREE_MONTH', 7776000);
define('CACHE_ONE_YEAR', 31104000);
define('CACHE_FIVE_YEAR', 155520000);

define('DEFINE_TYPE_DEPART_MEETING',2);
define('DEFINE_PASSWORD_DEFAULT','DangNhapCms@2022@');

define('SESSION_ADMIN_LOGIN','UserAdminLogin');
define('SESSION_PROJECT_MENU','SessionProjectMenu');
define('USER_ROOT','ROOT');

define('USER_CHANNEL_WEB_B2B','WEB_B2B');
define('USER_CHANNEL_SDK_LO','SDK_LO');

//đối tác
define('ORG_VIETJET_VN','VIETJET_VN');
define('ORG_HDI','HDI');

//Mã sản phẩm
define('PRODUCT_CODE_CSSK_NV','CSSK_NV');//Sức Khỏe cho nhân viên và người thân
define('PRODUCT_CODE_CSVX','CSVX');//Chiến Sĩ Vắc Xin
define('PRODUCT_CODE_XCG_TNDSBB','XCG_TNDSBB');//Trách nhiệm dân sự bắt buộc
define('PRODUCT_CODE_BAY_AT','BAY_AT');//Bay an toàn
define('PRODUCT_CODE_LOST_BAGGAGE','LOST_BAGGAGE');//Bảo hiểm mất hành lý
define('PRODUCT_CODE_ATTD','ATTD');
define('PRODUCT_CODE_ATTD_NEW','ATTD_NEW');//Bình An Cá Nhân
define('PRODUCT_CODE_XCG_TNDS','XCG_TNDSBB');
define('PRODUCT_CODE_XCG_VCX','XCG_VCX_NEW');//vật chất xe
define('PRODUCT_CODE_VISA_CARE','VISA_CARE');
define('PRODUCT_CODE_VNAT','VNAT');
define('PRODUCT_CODE_TRAU','TRAU');
define('PRODUCT_CODE_TCB','TCB');
define('PRODUCT_CODE_HCB','HCB');
define('PRODUCT_CODE_SUCKHOE365','SUCKHOE365');//SUCKHOE365
define('PRODUCT_CODE_TAINAN365','TAINAN365');//TAINAN365
define('PRODUCT_CODE_NHA365','NHA365');//NHA365

//Danh mục sản phẩm
define('CATEGORY_SUCKHOE365','CN.02');//SUCKHOE365
define('CATEGORY_TAINAN365','CN.03');//TAINAN365 - CN.03
define('CATEGORY_NHA365','TS10');//NHA365 - TS10
define('CATEGORY_ATTD','CN.04');
define('CATEGORY_XCG','XE');
define('CATEGORY_XCG_2','XE');
define('CATEGORY_VISA_CARE','VISA_CARE');
define('CATEGORY_VNAT','CN.05');
define('CATEGORY_TRAU','CN.06');
define('CATEGORY_TCB','CN.08');
define('CATEGORY_HCB','CN.09');

//Channel
define('CHANNEL_SELLING','SDK_SELLING');//selling
define('CHANNEL_NHA365','SDK_HOUSE_SELL');//NHA365
define('CHANNEL_SUCKHOE365','SDK_HEALTH_SELL');//SUCKHOE365
define('CHANNEL_TAINAN365','SDK_HEALTH_SELL');//TAINAN365

define('RELATIONSHIP_BAN_THAN','BAN_THAN');

define('MONEY_VND','VNĐ');
define('MONEY_DONG','đ');

//trạng thái bồi thường
define('STATUS_CLAIM_TMBT','TMBT');//chờ tiếp nhận
define('STATUS_CLAIM_XLHS','XLHS');//đang xử lý
define('STATUS_CLAIM_YCBS','YCBS');//chờ bổ xung giấy tờ
define('STATUS_CLAIM_DYKH','DYKH');//đồng ý bồi thường chờ xác nhận
define('STATUS_CLAIM_TCKH','TCKH');//từ chối bồi thường chờ xác nhận
define('STATUS_CLAIM_KHDY','KHDY');//KH đồng ý bồi thường
define('STATUS_CLAIM_KHTC','KHTC');//Khách hành không đồng ý bồi thường
define('STATUS_CLAIM_TTBT','TTBT');//đã chi trả bồi thường
define('STATUS_CLAIM_TCBT','TCBT');//Từ chối bồi thường

/**************************************************************************************************************
 * Định nghĩa ORG_STRUCT
 **************************************************************************************************************/
define('STRUCT_DEPARTMENT','DEPARTMENT');
define('STRUCT_GRADE_LEVEL','GRADE_LEVEL');
define('STRUCT_GROUP','GROUP');
define('STRUCT_ROOM','ROOM');
define('STRUCT_STORE','STORE');
define('STRUCT_WAREHOUSE','WAREHOUSE');

/**************************************************************************************************************
 * Định nghĩa Common
 **************************************************************************************************************/
define('DEFINE_LANGUAGE_VN','VN');
define('DEFINE_NULL','');
define('DEFINE_ALL','ALL');
define('DEFINE_TRUE_FALSE','TRUE_FALSE');
define('DEFINE_TYPE_MENU','TYPE_MENU');
define('DEFINE_GIOI_TINH','GIOI_TINH');
define('DEFINE_USER_TYPE','USER_TYPE');
define('DEFINE_CHUC_VU','CHUC_VU');
define('DEFINE_NHAN_VIEN','NHAN_VIEN');
define('DEFINE_TRANG_THAI','TRANG_THAI');
define('DEFINE_IMAGE_BANNER','IMAGE_BANNER');
define('DEFINE_TRANG_THAI_TIN','TRANG_THAI_TIN');
define('DEFINE_VI_TRI_TUYEN_DUNG','VI_TRI_TUYEN_DUNG');
define('DEFINE_PERMISSION_ACTION','PERMISSION_ACTION');




define('DEFINE_PORTAL','PORTAL');
define('DEFINE_GENDER','GENDER');//giới tính
define('DEFINE_ORG_TYPE','ORG_TYPE');
define('DEFINE_ORG_MODE','ORG_MODE');
define('DEFINE_STATUS','STATUS');
define('DEFINE_PAY_STATUS','PAY_STATUS');
define('DEFINE_CLAIM_STATUS','CLAIM_STATUS');
define('DEFINE_VEHICLE_INSPECTION_STATUS','VEHICLE_INSPECTION_STATUS');
define('DEFINE_CHANNEL_HDI','CHANNEL_HDI');
define('DEFINE_CONTRACT_STATUS','CONTRACT_STATUS');
define('DEFINE_VOUCHER_STATUS','VOUCHER_STATUS');
define('DEFINE_VOUCHER_VALUE_STATUS','VOUCHER_VALUE_STATUS');
define('DEFINE_STATUS_VERSION','VERSION_STATUS');
define('DEFINE_USER_TYPE','USER_TYPE');
define('DEFINE_AUT_TYPE','AUT_TYPE');
define('DEFINE_ACTION_TYPE_API','ACTION_TYPE_API');
define('DEFINE_YES_OR_NO','YES_OR_NO');
define('DEFINE_TYPE_GENERATE','TYPE_GENERATE');
define('DEFINE_CURRENCY','CURRENCY');
define('DEFINE_VOUCHER_GIFT_TYPE','VOUCHER_GIFT_TYPE');
define('DEFINE_VOUCHER_DISCOUNT_UNIT','VOUCHER_DISCOUNT_UNIT');
define('DEFINE_DANH_XUNG','DANH_XUNG');
define('DEFINE_DON_VI_THOI_GIAN','DURATION_UNIT');
define('DEFINE_HINH_THUC_THANH_TOAN','DURATION_PAYMENT');
define('DEFINE_PHAM_VI_DIA_LY','REGION');
define('DEFINE_LOAI_CAP_DON','LO_TYPE');

define('LO_TYPE_TOTAL','TOTAL');//Tổng hoạn mức
define('LO_TYPE_DISBUR','DISBUR');//theo khế ước nhận nợ
define('LO_TYPE_DECREASE','DECREASE');//Ngân hàng mua tặng KH

//menu theo project
define('DEFINE_MENU_SYSTEM','MENU_SYSTEM');//type define menu
define('MENU_HDI_OPEN_ID','MENU_HDI_OPEN_ID');
define('MENU_HDI_OPEN_API','MENU_HDI_OPEN_API');
define('MENU_HDI_SELLING','MENU_HDI_SELLING');

//user cấp đơn BH
define('PARTNER_ID_INSURANCE_POLICY','SELLING');

define('DEFINE_CRUD_LIMIT','CRUD_LIMIT');
define('DEFINE_ACTION_EXECUTE','ACTION_EXECUTE');

//thư mục dự án chính
define('DIR_PRO_BACKEND','BackendCms');
define('DIR_PRO_FRONTEND','Frontend');
define('DIR_PRO_WEB','Web');
define('DIR_PRO_SHOP','Shop');

define('DIR_PRO_CORE_HDI','CoreHdi');
define('DIR_PRO_SYSTEM','Systems');
define('DIR_PRO_SELLING','Sellings');
define('DIR_PRO_REPORT','Report');

// thư mục module
define('DIR_MODULE_OPENID','OpenId');//System
define('DIR_MODULE_OPENAPI','OpenApi');//System
//page Selling
define('DIR_MODULE_VOUCHERS','Vouchers');//Selling
define('DIR_MODULE_EXTEN_ACTION_HDI','ExtenActionHdi');//Selling
define('DIR_MODULE_INSURANCE_POLICY','InsurancePolicy');//Selling cấp đơn
define('DIR_MODULE_PAYMENT_CONTRACT','PaymentContract');//Selling thanh toán
define('DIR_MODULE_CLAIM_INDEMNIFY','ClaimIndemnify');//Selling bồi thường
define('DIR_MODULE_INSPECTION','Inspection');//Selling Giám định
define('DIR_MODULE_CAMERA_RECORD','CameraRecord');//Selling quay video giám định

//trạng thái STATUS VOUCHER
define('STATUS_VOUCHER_APPROVE','APPROVE');//Duyet
define('STATUS_VOUCHER_WAIT','WAIT');//Chờ duyệt - default
define('STATUS_VOUCHER_CANCEL','CANCEL');//Hủy
define('STATUS_VOUCHER_REFUSE','REFUSE');//Từ chối
define('STATUS_VOUCHER_USED','USED');//Đã sử dụng

/**************************************************************************************************************
 * Định nghĩa thư mục chứa file ảnh
 **************************************************************************************************************/
define('FOLDER_BANNER','folder_banner');

define('FOLDER_FILE_LOG_COMMON','LogCommon');
define('FOLDER_FILE_DEFAULT','default');
define('FOLDER_FILE_USER_ADMIN','user_admin');
define('FOLDER_FILE_CREATE_ORDER','file_create_order');
define('FOLDER_FILE_PRODUCT','product');
define('FOLDER_FILE_CRONJOB','Cronjob');
define('FOLDER_NEWS',  'news');
define('FOLDER_PRODUCT',  'product');
define('IMAGE_ERROR',  133);

define('GIOI_TINH_NAM',  'M');
define('GIOI_TINH_NU',  'F');

define('FOLDER_FILE_ORG_CONTRACTS','orgContracts');
define('FOLDER_FILE_USER_ABOUT','userAbout');
define('FOLDER_FILE_DIGITALLY_SIGNED','digitallySigned');


