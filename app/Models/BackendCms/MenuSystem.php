<?php
/**
 * QuynhTM
 */

namespace App\Models\BackendCms;

use App\Models\BaseModel;
use App\Library\AdminFunction\CGlobal;
use App\Library\AdminFunction\Memcache;


class MenuSystem extends BaseModel
{
    protected $table = TABLE_MENU_SYSTEM;
    protected $primaryKey = 'menu_id';
    public $timestamps = false;

    public function searchByCondition($dataSearch = array(), $limit = STATUS_INT_MUOI, $offset = STATUS_INT_KHONG, $is_total = true)
    {
        try {
            $query = MenuSystem::where($this->primaryKey, '>', STATUS_INT_KHONG);
            if (isset($dataSearch['menu_name']) && $dataSearch['menu_name'] != '') {
                $query->where('menu_name', 'LIKE', '%' . $dataSearch['menu_name'] . '%');
            }
            if (isset($dataSearch['project_code']) && $dataSearch['project_code'] > STATUS_DEFAULT) {
                $query->where('project_code', $dataSearch['project_code']);
            }
            if (isset($dataSearch['menu_parent']) && $dataSearch['menu_parent'] > STATUS_DEFAULT) {
                $query->where('menu_parent', $dataSearch['menu_parent']);
            }
            if (isset($dataSearch['is_active']) && $dataSearch['is_active'] > STATUS_DEFAULT) {
                $query->where('is_active', $dataSearch['is_active']);
            }
            $total = ($is_total) ? $query->count() : STATUS_INT_KHONG;
            $query->orderBy('menu_order', 'asc');

            //get field can lay du lieu
            $fields = (isset($dataSearch['field_get']) && trim($dataSearch['field_get']) != '') ? explode(',', trim($dataSearch['field_get'])) : array();
            if (!empty($fields)) {
                $result = $query->take($limit)->skip($offset)->get($fields);
            } else {
                $result = $query->take($limit)->skip($offset)->get();
            }
            return ['data' => $result, 'total' => $total];
        } catch (PDOException $e) {
            throw $e->getMessage();
        }
    }

    public function editItem($data, $id = 0)
    {
        try {
            $fieldInput = $this->checkFieldInTable($data);
            if (is_array($fieldInput) && count($fieldInput) > STATUS_INT_KHONG) {
                $item = ($id <= STATUS_INT_KHONG) ? new MenuSystem() : self::getItemById($id);
                if (is_array($fieldInput) && count($fieldInput) > STATUS_INT_KHONG) {
                    foreach ($fieldInput as $k => $v) {
                        $item->$k = $v;
                    }
                }
                if ($id <= STATUS_INT_KHONG) {
                    $item->created_id = $this->getUserId();
                    $item->created_name = $this->getUserName();
                    $item->save();
                    $id = $item->menu_id;
                } else {
                    $item->updated_id = $this->getUserId();
                    $item->updated_name = $this->getUserName();
                    $item->update();
                }
                self::removeCache($id, $item);
                return $id;
            }
            return STATUS_INT_KHONG;
        } catch (PDOException $e) {
            throw $e->getMessage();
        }
    }

    public function getItemById($id)
    {
        $data = Memcache::getCache(Memcache::CACHE_MENU_BY_ID . $id);
        if (!$data) {
            $data = MenuSystem::find($id);
            if ($data) {
                Memcache::putCache(Memcache::CACHE_MENU_BY_ID . $id, $data);
            }
        }
        return $data;
    }

    public function deleteItem($id)
    {
        if ($id <= STATUS_INT_KHONG) return false;
        try {
            $item = $dataOld = self::getItemById($id);;
            if ($item) {
                $item->delete();
                self::removeCache($item->menu_id, $dataOld);
            }
            return true;
        } catch (PDOException $e) {
            throw $e->getMessage();
        }
    }

    public function removeCache($id = STATUS_INT_KHONG, $data)
    {
        Memcache::forgetCache(Memcache::CACHE_MENU_BY_ID . $id);
        Memcache::forgetCache(Memcache::CACHE_LIST_MENU_PERMISSION);
        Memcache::forgetCache(Memcache::CACHE_ALL_PARENT_MENU);
        Memcache::forgetCache(Memcache::CACHE_TREE_MENU);
        Memcache::forgetCache(Memcache::CACHE_ALL_MENU);
        if ($data) {
            Memcache::forgetCache(Memcache::CACHE_MENU_BY_TAB_ID . $data->project_code);
        }
    }

    public function getOptionMenuParent($projectCode = MENU_HDI_OPEN_API)
    {
        $dataMenu = MenuSystem::where('menu_id', '>', STATUS_INT_KHONG)
            ->where('project_code', '=', $projectCode)
            ->where('controller_name', '=', '#')
            ->where('is_link', '=', STATUS_INT_KHONG)
            ->where('is_active', '=', STATUS_INT_MOT)
            ->orderBy('menu_order', 'asc')->get();
        $arrOption = [];
        if ($dataMenu) {
            foreach ($dataMenu as $item) {
                if ($item->menu_lever == 0) {
                    $arrOption[$item->menu_id] = $item->menu_name;
                } else {
                    $arrOption[$item->menu_id] = '----' . $item->menu_name;
                }
            }
        }
        return $arrOption;
    }

    public function getMenuByTab($project_code)
    {
        $data = Memcache::getCache(Memcache::CACHE_MENU_BY_TAB_ID . $project_code);
        if (!$data || sizeof($data) == STATUS_INT_KHONG) {
            $dataMenu = MenuSystem::where('menu_id', '>', STATUS_INT_KHONG)
                ->where('project_code', '=', $project_code)
                ->where('menu_parent', '=', STATUS_INT_KHONG)
                ->where('menu_type', '=', STATUS_INT_KHONG)
                ->where('is_active', '=', STATUS_SHOW)
                ->orderBy('menu_order', 'asc')->get();
            foreach ($dataMenu as $itm) {
                $data[$itm['menu_id']] = $itm['menu_name'];
            }
            if (!empty($data) && Memcache::CACHE_ON) {
                Memcache::putCache(Memcache::CACHE_MENU_BY_TAB_ID . $project_code, $data);
            }
        }
        return $data;
    }

    public function getMenuByArrId($arrId = [])
    {
        if (empty($arrId))
            return [];
        $data = MenuSystem::where('menu_id', '>', STATUS_INT_KHONG)
            ->whereIn('menu_id', $arrId)
            ->orderBy('menu_order', 'asc')->get();
        return $data;
    }

    public function getAllMenu()
    {
        $data = Memcache::getCache(Memcache::CACHE_ALL_MENU);
        if (!$data) {
            $data = MenuSystem::where('menu_id', '>', STATUS_INT_KHONG)->orderBy('menu_order', 'asc')->get();
            if ($data) {
                Memcache::putCache(Memcache::CACHE_ALL_MENU, $data);
            }
        }
        return $data;
    }

    public function getAllParentMenu()
    {
        $data = Memcache::getCache(Memcache::CACHE_ALL_PARENT_MENU);
        if (!$data || sizeof($data) == STATUS_INT_KHONG) {
            $menu = MenuSystem::where('menu_id', '>', STATUS_INT_KHONG)
                ->where('menu_parent', STATUS_INT_KHONG)
                ->where('is_active', STATUS_SHOW)
                ->where('project_code', CGlobal::dms_portal)
                ->orderBy('menu_order', 'asc')->get();
            if ($menu) {
                foreach ($menu as $itm) {
                    $data[$itm['menu_id']] = $itm['menu_name'];
                }
            }
            if (!empty($data)) {
                Memcache::putCache(Memcache::CACHE_ALL_PARENT_MENU, $data);
            }
        }
        return $data;
    }

    public function buildMenuAdmin()
    {
        $data = $menuTree = array();
        $menuTree = Memcache::getCache(Memcache::CACHE_TREE_MENU);
        if (!$menuTree) {
            $search['is_active'] = STATUS_SHOW;
            $dataSearch = app(MenuSystem::class)->searchByCondition($search, LIMIT_RECORD_500, STATUS_INT_KHONG, false);
            if (!empty($dataSearch['data'])) {
                $data = MenuSystem::getTreeMenu($dataSearch['data']);
                $data = !empty($data) ? $data : $dataSearch['data'];
            }
            if (!empty($data)) {
                foreach ($data as $menu) {
                    if ($menu['menu_parent'] == STATUS_INT_KHONG && $menu['is_link'] == STATUS_INT_KHONG) {
                        $menuTree[$menu['menu_id']] = array(
                            'menu_parent' => $menu['menu_parent'],
                            'menu_id' => $menu['menu_id'],
                            'name' => $menu['menu_name'],
                            'name_en' => $menu['menu_name_en'],
                            'show_menu' => $menu['show_menu'],
                            'project_code' => $menu['project_code'],
                            'is_link' => $menu['is_link'],
                            'link' => 'javascript:void(0)',
                            'icon' => $menu['menu_icons']
                        );
                    } elseif ($menu['menu_parent'] == STATUS_INT_KHONG && $menu['is_link'] == STATUS_SHOW) {
                        $menuTree[$menu['menu_id']] = array(
                            'menu_parent' => $menu['menu_parent'],
                            'menu_id' => $menu['menu_id'],
                            'name' => $menu['menu_name'],
                            'name_en' => $menu['menu_name_en'],
                            'show_menu' => $menu['show_menu'],
                            'project_code' => $menu['project_code'],
                            'is_link' => $menu['is_link'],
                            'link' => 'javascript:void(0)',
                            'icon' => $menu['menu_icons'],
                            'RouteName' => $menu['router_name'],
                        );
                    } else {
                        $arrInforSub = array(
                            'menu_id' => $menu['menu_id'],
                            'menu_parent' => $menu['menu_parent'],
                            'show_menu' => $menu['show_menu'],
                            'name' => $menu['menu_name'],
                            'project_code' => $menu['project_code'],
                            'name_en' => $menu['menu_name_en'],
                            'RouteName' => $menu['router_name'],
                            'icon' => $menu['menu_icons'] . ' icon-4x', 'permission' => '');

                        if (isset($menuTree[$menu['menu_parent']]['arr_link_sub'])) {
                            $tempLink = $menuTree[$menu['menu_parent']]['arr_link_sub'];
                            array_push($tempLink, $menu['router_name']);
                            $menuTree[$menu['menu_parent']]['arr_link_sub'] = $tempLink;

                            //sub
                            $tempSub = $menuTree[$menu['menu_parent']]['sub'];
                            array_push($tempSub, $arrInforSub);
                            $menuTree[$menu['menu_parent']]['sub'] = $tempSub;

                        } else {
                            $menuTree[$menu['menu_parent']]['arr_link_sub'] = array($menu['router_name']);
                            $menuTree[$menu['menu_parent']]['sub'] = array($arrInforSub);
                        }
                    }
                }
            }
            if (!empty($menuTree)) {
                Memcache::putCache(Memcache::CACHE_TREE_MENU, $menuTree);
            }
        }
        return $menuTree;
    }

    public function getTreeMenu($data)
    {
        $max = STATUS_INT_KHONG;
        $aryCategoryProduct = $arrCategory = array();
        if (!empty($data)) {
            foreach ($data as $k => $value) {
                $max = ($max < $value->menu_parent) ? $value->menu_parent : $max;
                $arrCategory[$value->menu_id] = array(
                    'menu_id' => $value->menu_id,
                    'menu_parent' => $value->menu_parent,
                    'menu_lever' => $value->menu_lever,
                    'menu_url' => $value->menu_url,
                    'router_name' => $value->router_name,
                    'controller_name' => $value->controller_name,
                    'project_code' => $value->project_code,
                    'menu_order' => $value->menu_order,
                    'menu_icons' => $value->menu_icon,
                    'show_permission' => $value->show_permission,
                    'show_menu' => 1,//$value->show_menu,
                    'is_active' => $value->is_active,
                    'is_link' => $value->is_link,
                    'menu_name_en' => $value->menu_name,
                    'menu_name' => $value->menu_name);
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
                if ((int)$val['menu_parent'] == STATUS_INT_KHONG) {
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
                if ($chval['menu_parent'] == $cat_id) {
                    $chval['padding_left'] = '--- ';
                    $chval['menu_name_parent'] = $cat_name;
                    $chval['menu_name_parent_en'] = $cat_name_en;
                    $aryData[] = $chval;
                    self::showSubMenu($chval['menu_id'], $chval['menu_name'], $chval['menu_name_en'], $max, $aryDataInput, $aryData);
                }
            }
        }
    }

    public function getDataPermission()
    {
        $data = Memcache::getCache(Memcache::CACHE_LIST_MENU_PERMISSION);
        if (!$data) {
            $data = MenuSystem::where('menu_id', '>', STATUS_INT_KHONG)
                ->where('is_active', STATUS_SHOW)
                ->where('show_permission', STATUS_SHOW)
                ->orderBy('menu_parent', 'asc')->orderBy('menu_order', 'asc')->get();
            if ($data) {
                Memcache::putCache(Memcache::CACHE_LIST_MENU_PERMISSION, $data);
            }
        }
        return $data;
    }

    public function getListMenuPermission()
    {
        $data = self::getDataPermission();
        $result = [];
        if ($data) {
            foreach ($data as $k => $val) {
                $result[$val->project_code][$val->menu_id] = ['menu_id' => $val->menu_id, 'menu_name' => $val->menu_name, 'menu_name_en' => $val->menu_name_en];
            }
        }
        return $result;
    }
}
