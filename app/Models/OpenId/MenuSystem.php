<?php
/**
 * QuynhTM
 * 13/03/2020
 */

namespace App\Models\OpenId;

use App\Library\AdminFunction\CGlobal;
use App\Library\AdminFunction\Memcache;
use App\Services\ModelService;
use Illuminate\Support\Facades\Config;

class MenuSystem extends ModelService
{
    public $table = TABLE_SYS_MENU;
    private $primaryKey = 'MENU_CODE';

    public function searchMenuSystem($dataRequest = array())
    {
        try {
            $requestDefault = $this->dataRequestDefault;
            $requestDefault["p_Keyword"] = (isset($dataRequest['s_search']) && trim($dataRequest['s_search']) != '') ? $dataRequest['s_search'] : '';
            $requestDefault["p_Page"] = (isset($dataRequest['page_no'])) ? $dataRequest['page_no'] : STATUS_INT_MOT;
            $requestDefault["p_ProjectCode"] = (isset($dataRequest['s_project_code']) && trim($dataRequest['s_project_code']) != '') ? $dataRequest['s_project_code'] : DEFINE_ALL;
            $requestDefault["p_Limit"] = (isset($dataRequest['limit'])) ? $dataRequest['limit'] : CGlobal::number_show_500;
            return $this->searchDataCommon($requestDefault, ACTION_SEARCH_MENU);

        } catch (\PDOException $e) {
            return returnError($e->getMessage());
        }
    }

    /**
     * @param $dataInput
     * @param string $action
     * @return array
     */
    public function editMenuSystem($dataInput, $action = 'ADD')
    {
        $this->setUserAction();
        $item = $this->actionEditCommon($dataInput, $action, $this->table, ACTION_EDIT_MENU);
        $this->removeCache($dataInput);
        return $item;
    }

    /**
     * @param array $dataInput
     * @return array
     */
    public function deleteItem($dataInput = [])
    {
        if (!isset($dataInput[$this->primaryKey]))
            return $this->returnStatusError();
        $this->setUserAction();
        $delete = $this->deleteDataCommonByOneKey($dataInput[$this->primaryKey], ACTION_DELETE_MENU);
        $this->removeCache($dataInput);
        return $delete;
    }

    /**
     * @param int $menu_code
     * @return array
     */
    public function getItemById($code = '')
    {
        return $this->getDataCommonByOneKey($code, ACTION_GET_DATA_MENU, Memcache::CACHE_MENU_SYSTEM_BY_ID);
    }

    public function getAllMenuByProjectCode($projectCode = DEFINE_ALL)
    {
        if (trim($projectCode) == '')
            return false;
        try {
            $key_cache = Memcache::CACHE_MENU_SYSTEM_BY_PROJECT_CODE . $projectCode;
            $data = Memcache::getCache($key_cache);
            if (!$data) {
                $dataRequest['s_project_code'] = $projectCode;
                $menu = $this->searchMenuSystem($dataRequest);
                $data = isset($menu['Data']['data']) ? $menu['Data']['data'] : false;
                if ($data) {
                    Memcache::putCache($key_cache, $data);
                }
            }
            return $data;
        } catch (\PDOException $e) {
            return returnError($e->getMessage());
        }
    }

    public function removeCache($data)
    {
        if (isset($data[$this->primaryKey]) && (int)$data[$this->primaryKey] > 0)
            Memcache::forgetCache(Memcache::CACHE_MENU_SYSTEM_BY_ID . $data[$this->primaryKey],Config::get('config.DOMAINS_PROJECT'));
        if (isset($data['PROJECT_CODE'])) {
            Memcache::forgetCache(Memcache::CACHE_MENU_SYSTEM_BY_PROJECT_CODE . $data['PROJECT_CODE'],Config::get('config.DOMAINS_PROJECT'));
            Memcache::forgetCache(Memcache::CACHE_TREE_MENU_SYSTEM_BY_PROJECT_CODE . $data['PROJECT_CODE'],Config::get('config.DOMAINS_PROJECT'));
        }
        Memcache::forgetCache(Memcache::CACHE_MENU_SYSTEM_BY_PROJECT_CODE . DEFINE_ALL,Config::get('config.DOMAINS_PROJECT'));
    }

    public function getOptionMenuParent($projectCode = MENU_HDI_OPEN_API)
    {
        $dataAll = $this->getAllMenuByProjectCode($projectCode);
        $arrOption = [];
        if ($dataAll) {
            foreach ($dataAll as $ky => $item) {
                if ($item->CONTROL_NAME === '#' && $item->IS_LINK == STATUS_INT_KHONG) {
                    if($item->PARENT_CODE == 0){
                        $arrOption[$item->MENU_CODE] = $item->MENU_NAME;
                    }else{
                        $arrOption[$item->MENU_CODE] = '----'.$item->MENU_NAME;
                    }
                }
            }
        }
        return $arrOption;
    }

    public function getListMenuWithPermission($project_code = '')
    {
        $dataAll = $this->getAllMenuByProjectCode();
        $arrOption = [];
        if ($dataAll) {
            foreach ($dataAll as $ky => $item) {
                if(trim($project_code) != '' ){
                    if ($item->IS_ACTIVE == STATUS_INT_MOT && $item->MENU_PATH != '#' && $item->PROJECT_CODE == trim($project_code)) {
                        $arrOption[$item->MENU_CODE] = $item->MENU_NAME;
                    }
                }else{
                    if ($item->IS_ACTIVE == STATUS_INT_MOT && $item->MENU_PATH != '#') {
                        $arrOption[$item->MENU_CODE] = $item->MENU_NAME;
                    }
                }
            }
        }
        return $arrOption;
    }

    /**
     * Check page mà người dùng có thể đc phép vào
     * @param string $urlInput
     * @param array $arrTabPersonal
     * @return array|false
     */
    public function checkPageWithTab($urlInput = '',$arrTabProjectPersonal= [])
    {
        return true;
        if(trim($urlInput) == '' && empty($arrTabProjectPersonal))
            return false;
        $dataAll = $this->getAllMenuByProjectCode();
        if ($dataAll) {
            foreach ($dataAll as $ky => $item) {
                if ($item->IS_ACTIVE == STATUS_INT_MOT && trim($item->MENU_PATH) == trim($urlInput) && in_array($item->PROJECT_CODE,$arrTabProjectPersonal)) {
                    return true;
                }
            }
        }
        return false;
    }

    public function getLevelMenuById($menu_code = STATUS_INT_KHONG)
    {
        if ($menu_code == STATUS_INT_KHONG)
            return STATUS_INT_KHONG;

        $menu = $this->getItemById($menu_code);
        return (isset($menu->MENU_LEVEL)) ? $menu->MENU_LEVEL + 1 : STATUS_INT_KHONG;
    }

    /* build cây menu*/
    public function buildMenuAdmin($projectCode = MENU_HDI_OPEN_API)
    {
        $menuTree = Memcache::getCache(Memcache::CACHE_TREE_MENU_SYSTEM_BY_PROJECT_CODE . $projectCode);
        if (!$menuTree) {
            $data = $this->getAllMenuByProjectCode($projectCode);
            $menuTree = $this->buildTreeMenuAdmin($data);
            if (!empty($menuTree)) {
                Memcache::putCache(Memcache::CACHE_TREE_MENU_SYSTEM_BY_PROJECT_CODE . $projectCode, $menuTree);
            }
        }
        return $menuTree;
    }

    public function buildTreeMenuAdmin($data){
        $menuTree = $arrMenu2 = [];
        if (!empty($data)) {
            foreach ((array)$data as $ky => $menu) {
                $menu = (array)$menu;
                //menu cấp 2 có menu con
                if ($menu['PARENT_CODE'] > STATUS_INT_KHONG && $menu['IS_LINK'] == STATUS_INT_KHONG){
                    $arrMenu2[$menu[$this->primaryKey]] = $menu;
                }
                //menu hiển thị
                if ($menu['IS_ACTIVE'] == STATUS_INT_MOT) {
                    if ($menu['PARENT_CODE'] == STATUS_INT_KHONG && $menu['IS_LINK'] == STATUS_INT_KHONG) {
                        //menu cha có menu con
                        $menuTree[$menu[$this->primaryKey]] = array(
                            'parent_id' => $menu['PARENT_CODE'],
                            'menu_type' => $menu['IS_LINK'],
                            'menu_id' => $menu[$this->primaryKey],
                            'name' => $menu['MENU_NAME'],
                            'name_en' => $menu['MENU_NAME'],
                            'show_menu' => STATUS_INT_MOT,
                            'menu_tab_top_id' => isset(CGlobal::$projectMenuWithTabTop[$menu['PROJECT_CODE']]) ? CGlobal::$projectMenuWithTabTop[$menu['PROJECT_CODE']] : CGlobal::dms_portal,
                            'link' => 'javascript:void(0)',
                            'icon' => $menu['ICON'],
                            'arr_link_sub' => [],
                            'arr_link_chirld' => [],
                            'sub' => [],
                        );
                    } elseif ($menu['PARENT_CODE'] == STATUS_INT_KHONG && $menu['IS_LINK'] == STATUS_INT_MOT) {
                        //menu cha có link
                        $menuTree[$menu[$this->primaryKey]] = array(
                            'parent_id' => $menu['PARENT_CODE'],
                            'menu_type' => $menu['IS_LINK'],
                            'menu_id' => $menu[$this->primaryKey],
                            'name' => $menu['MENU_NAME'],
                            'name_en' => $menu['MENU_NAME'],
                            'show_menu' => STATUS_INT_MOT,
                            'menu_tab_top_id' => isset(CGlobal::$projectMenuWithTabTop[$menu['PROJECT_CODE']]) ? CGlobal::$projectMenuWithTabTop[$menu['PROJECT_CODE']] : CGlobal::dms_portal,
                            'link' => 'javascript:void(0)',
                            'icon' => $menu['ICON'],
                            'RouteName' => $menu['MENU_PATH'],
                            'showcontent' => STATUS_INT_MOT
                        );
                    }else {
                        $arr_link_chirld = explode('/', $menu['MENU_PATH']);
                        $url_chirld = [];
                        if (!empty($arr_link_chirld)) {
                            foreach ($arr_link_chirld as $key => $val_url) {
                                if (trim($val_url) != '')
                                    $url_chirld[$val_url] = $menu['MENU_PATH'];
                            }
                        }

                        $arrInforSub = array(
                            'menu_id' => $menu[$this->primaryKey],
                            'parent_id' => $menu['PARENT_CODE'],
                            'show_menu' => STATUS_INT_MOT,
                            'menu_type' => $menu['IS_LINK'],
                            'name' => $menu['MENU_NAME'],
                            'menu_tab_top_id' => STATUS_INT_MOT,
                            'name_en' => $menu['MENU_NAME'],
                            'RouteName' => $menu['MENU_PATH'],
                            'url_chirld' => $url_chirld,
                            'icon' => $menu['ICON'],
                            'showcontent' => STATUS_INT_MOT,
                            'permission' => '');

                        if (isset($menuTree[$menu['PARENT_CODE']]['arr_link_sub'])) {
                            $tempLink = $menuTree[$menu['PARENT_CODE']]['arr_link_sub'];
                            array_push($tempLink, $menu['MENU_PATH']);
                            $menuTree[$menu['PARENT_CODE']]['arr_link_sub'] = $tempLink;

                            //sub
                            $tempSub = $menuTree[$menu['PARENT_CODE']]['sub'];
                            array_push($tempSub, $arrInforSub);
                            $menuTree[$menu['PARENT_CODE']]['sub'] = $tempSub;

                            //chirld
                            $tempLinkChirld = $menuTree[$menu['PARENT_CODE']]['arr_link_chirld'];
                            if (!empty($url_chirld)) {
                                foreach ($url_chirld as $url_sub => $val_url_chirld) {
                                    if (!in_array($url_sub, $tempLinkChirld)) {
                                        $tempLinkChirld[] = $url_sub;
                                    }
                                }
                            }
                            $menuTree[$menu['PARENT_CODE']]['arr_link_chirld'] = $tempLinkChirld;
                        } else {
                            $menuTree[$menu['PARENT_CODE']]['arr_link_sub'] = array($menu['MENU_PATH']);
                            $menuTree[$menu['PARENT_CODE']]['arr_link_chirld'] = $arr_link_chirld;
                            $menuTree[$menu['PARENT_CODE']]['sub'] = array($arrInforSub);
                        }
                    }
                }
            }
        }
        //lấy menu con của menu cấp 2
        if(!empty($arrMenu2)){
            foreach ($menuTree as $ky=> &$me){
                if(isset($me['sub']) && !empty($me['sub'])){
                    foreach ($me['sub'] as $kk => &$ms){
                        if($ms['menu_id'] > 0 && in_array($ms['menu_id'],array_keys($arrMenu2))){
                            $ms['arr_link_sub'] = $menuTree[$ms['menu_id']]['arr_link_sub'];
                            $ms['arr_link_chirld'] = $menuTree[$ms['menu_id']]['arr_link_chirld'];
                            $ms['sub'] = $menuTree[$ms['menu_id']]['sub'];

                            //add vào cha
                            $me['arr_link_sub'] = array_merge($me['arr_link_sub'],$menuTree[$ms['menu_id']]['arr_link_sub']);
                            $me['arr_link_chirld'] = array_merge($me['arr_link_chirld'],$menuTree[$ms['menu_id']]['arr_link_chirld']);
                            foreach ($menuTree[$ms['menu_id']]['arr_link_sub'] as $url_child_2){
                                $ms['url_chirld'][$url_child_2] = $url_child_2;
                            }
                            unset($menuTree[$ms['menu_id']]);
                        }
                    }
                }
            }
        }
        return $menuTree;
    }
    public function getTreeMenu($data)
    {
        $max = STATUS_INT_MOT;
        $aryCategoryProduct = $arrCategory = array();
        if (!empty($data)) {
            foreach ($data as $k => $value) {
                $max = ($max < $value->PARENT_CODE) ? $value->PARENT_CODE : $max;
                $arrCategory[$value->MENU_CODE] = array(
                    'menu_id' => $value->MENU_CODE,
                    'parent_id' => $value->PARENT_CODE,
                    'project_code' => $value->PROJECT_CODE,
                    'menu_type' => $value->IS_LINK,
                    'ordering' => $value->SORT_ORDER,
                    'menu_icons' => $value->ICON,
                    'menu_level' => $value->MENU_LEVEL,
                    'menu_url' => $value->MENU_PATH,
                    'menu_url_chirld' => $value->MENU_PARAM,
                    'active' => $value->IS_ACTIVE,
                    'menu_name_en' => $value->MENU_NAME,
                    'menu_name' => $value->MENU_NAME,
                    'object_menu' => $value,
                );
            }
        }
        if ($max > STATUS_INT_KHONG) {
            $aryCategoryProduct = self::showMenu($max, $arrCategory);
        }
        return $aryCategoryProduct;
    }

    public function showMenu($max, $aryDataInput)
    {
        $aryData = array();
        if (is_array($aryDataInput) && count($aryDataInput) > STATUS_INT_KHONG) {
            foreach ($aryDataInput as $k => $val) {
                if ((int)$val['parent_id'] == STATUS_INT_KHONG) {
                    $val['padding_left'] = '';
                    $val['menu_name_parent'] = '';
                    $val['menu_name_parent_en'] = '';
                    $aryData[] = $val;
                    self::showSubMenu($val['menu_id'], $val['menu_name'], $val['menu_name_en'], $max, $aryDataInput, $aryData);
                }
            }
        }
        return $aryData;
    }

    public function showSubMenu($cat_id, $cat_name, $cat_name_en, $max, $aryDataInput, &$aryData)
    {
        if ($cat_id <= $max) {
            foreach ($aryDataInput as $chk => $chval) {
                if ($chval['parent_id'] == $cat_id) {
                    $chval['padding_left'] = ($chval['menu_level'] == 1)? '--- ':'--- --- ';
                    $chval['menu_name_parent'] = $cat_name;
                    $chval['menu_name_parent_en'] = $cat_name_en;
                    $aryData[] = $chval;
                    self::showSubMenu($chval['menu_id'], $chval['menu_name'], $chval['menu_name_en'], $max, $aryDataInput, $aryData);
                }
            }
        }
    }
    /* build cây menu*/
}
