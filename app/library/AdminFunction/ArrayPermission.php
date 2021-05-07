<?php
/**
 * Created by JetBrains PhpStorm.
 * User: QuynhTM
 */

namespace App\Library\AdminFunction;

class ArrayPermission
{
    public static $arrNewPermiss = array(
        100 => array(
            'group_permiss' => 'Quản trị site',
            'infor' => array(
                1 => array('code' => 'root', 'name' => 'Quản trị site '),
            ),
        ),
        101 => array(
            'group_permiss' => 'Tech code',
            'infor' => array(
                1 => array('code' => 'is_tech', 'name' => 'Tech code'),
            ),
        ),
        103 => array(
            'group_permiss' => 'Tài khoản Admin',
            'infor' => array(
                1 => array('code' => 'user_view', 'name' => 'Xem danh sách user'),
                2 => array('code' => 'user_create', 'name' => 'Tạo user'),
                3 => array('code' => 'user_edit', 'name' => 'Sửa user'),
                4 => array('code' => 'user_change_pass', 'name' => 'Đổi pass user'),
            ),
        ),
        104 => array(
            'group_permiss' => 'Nhóm quyền',
            'infor' => array(
                1 => array('code' => 'group_user_view', 'name' => 'Xem nhóm quyền'),
                2 => array('code' => 'group_user_create', 'name' => 'Tạo nhóm quyền'),
                3 => array('code' => 'group_user_edit', 'name' => 'Sửa nhóm quyền'),
            ),
        ),
        105 => array(
            'group_permiss' => 'Tạo quyền',
            'infor' => array(
                1 => array('code' => 'permission_full', 'name' => 'Full tạo quyền'),
                2 => array('code' => 'permission_create', 'name' => 'Tạo quyền'),
                3 => array('code' => 'permission_edit', 'name' => 'Sửa tạo quyền'),
            ),
        ),
        106 => array(
            'group_permiss' => 'Menu admin',
            'infor' => array(
                1 => array('code' => 'menu_full', 'name' => 'Full menu'),
                2 => array('code' => 'menu_view', 'name' => 'View menu'),
                3 => array('code' => 'menu_create', 'name' => 'Tạo menu'),
            ),
        ),
        107 => array(
            'group_permiss' => 'Quyền Role',
            'infor' => array(
                1 => array('code' => 'role_full', 'name' => 'Full role'),
                2 => array('code' => 'role_view', 'name' => 'View role'),
                3 => array('code' => 'role_create', 'name' => 'Tạo role'),
            ),
        ),
        108 => array(
            'group_permiss' => 'Phân quyền role',
            'infor' => array(
                2 => array('code' => 'role_permission_view', 'name' => 'View quyền role'),
                3 => array('code' => 'role_permission_create', 'name' => 'Tạo quyền role'),
                4 => array('code' => 'role_permission_edit', 'name' => 'Sửa quyền role'),
            ),
        ),

        9 => array(
            'group_permiss' => 'Quyền CS-Tiền mặt',
            'infor' => array(
                1 => array('code' => FULL_ALL_LINE.LINE_CS, 'name' => 'Full CS-Tiền mặt'),
                2 => array('code' => VIEW_ALL_LINE.LINE_CS, 'name' => 'Xem CS-Tiền mặt'),
                3 => array('code' => EDIT_ALL_LINE.LINE_CS, 'name' => 'Edit CS-Tiền mặt'),
                4 => array('code' => STAFF_FULL.LINE_CS, 'name' => 'Full Staff CS-Tiền mặt'),
                5 => array('code' => DEPART_FULL.LINE_CS, 'name' => 'Full Depart CS-Tiền mặt'),
            ),
        ),

        10 => array(
            'group_permiss' => 'Quyền IS-Trả góp',
            'infor' => array(
                1 => array('code' => FULL_ALL_LINE.LINE_IS, 'name' => 'Full IS-Trả góp'),
                2 => array('code' => VIEW_ALL_LINE.LINE_IS, 'name' => 'Xem IS-Trả góp'),
                3 => array('code' => EDIT_ALL_LINE.LINE_IS, 'name' => 'Edit IS-Trả góp'),
                4 => array('code' => STAFF_FULL.LINE_IS, 'name' => 'Full Staff IS-Trả góp'),
                5 => array('code' => DEPART_FULL.LINE_IS, 'name' => 'Full Depart IS-Trả góp'),
            ),
        ),

        11 => array(
            'group_permiss' => 'Quyền TS-Telesale',
            'infor' => array(
                1 => array('code' => FULL_ALL_LINE.LINE_TS, 'name' => 'Full TS-Telesale'),
                2 => array('code' => VIEW_ALL_LINE.LINE_TS, 'name' => 'Xem TS-Telesale'),
                3 => array('code' => EDIT_ALL_LINE.LINE_TS, 'name' => 'Edit TS-Telesale'),
                4 => array('code' => STAFF_FULL.LINE_TS, 'name' => 'Full Staff TS-Telesale'),
                5 => array('code' => DEPART_FULL.LINE_TS, 'name' => 'Full Depart TS-Telesale'),
            ),
        ),

        12 => array(
            'group_permiss' => 'Quyền TP-Third Party',
            'infor' => array(
                1 => array('code' => FULL_ALL_LINE.LINE_TP, 'name' => 'Full TP-Third Party'),
                2 => array('code' => VIEW_ALL_LINE.LINE_TP, 'name' => 'Xem TP-Third Party'),
                3 => array('code' => EDIT_ALL_LINE.LINE_TP, 'name' => 'Edit TP-Third Party'),
                4 => array('code' => STAFF_FULL.LINE_TP, 'name' => 'Full Staff TP-Third Party'),
                5 => array('code' => DEPART_FULL.LINE_TP, 'name' => 'Full Depart TP-Third Party'),
            ),
        ),
        27 => array(
            'group_permiss' => 'Quyền Card-Thẻ',
            'infor' => array(
                1 => array('code' => FULL_ALL_LINE.LINE_CARD, 'name' => 'Full Card-Thẻ'),
                2 => array('code' => VIEW_ALL_LINE.LINE_CARD, 'name' => 'Xem Card-Thẻ'),
                3 => array('code' => EDIT_ALL_LINE.LINE_CARD, 'name' => 'Edit Card-Thẻ'),
                4 => array('code' => STAFF_FULL.LINE_CARD, 'name' => 'Full Staff Card-Thẻ'),
                5 => array('code' => DEPART_FULL.LINE_CARD, 'name' => 'Full Depart Card-Thẻ'),
            ),
        ),
        28 => array(
            'group_permiss' => 'Quyền TH-Viettel',
            'infor' => array(
                1 => array('code' => FULL_ALL_LINE.LINE_VIETTEL, 'name' => 'Full TH-Viettel'),
                2 => array('code' => VIEW_ALL_LINE.LINE_VIETTEL, 'name' => 'Xem TH-Viettel'),
                3 => array('code' => EDIT_ALL_LINE.LINE_VIETTEL, 'name' => 'Edit TH-Viettel'),
                4 => array('code' => STAFF_FULL.LINE_VIETTEL, 'name' => 'Full Staff TH-Viettel'),
                5 => array('code' => DEPART_FULL.LINE_VIETTEL, 'name' => 'Full Depart TH-Viettel'),
            ),
        ),
        30 => array(
            'group_permiss' => 'Quyền Non-CA',
            'infor' => array(
                1 => array('code' => FULL_ALL_LINE.LINE_NCA, 'name' => 'Full Non-CA'),
                2 => array('code' => VIEW_ALL_LINE.LINE_NCA, 'name' => 'Xem Non-CA'),
                3 => array('code' => EDIT_ALL_LINE.LINE_NCA, 'name' => 'Edit Non-CA'),
                4 => array('code' => STAFF_FULL.LINE_NCA, 'name' => 'Full Staff Non-CA'),
                5 => array('code' => DEPART_FULL.LINE_NCA, 'name' => 'Full Depart Non-CA'),
            ),
        ),
        31 => array(
            'group_permiss' => 'Quyền Level AP-CS',
            'infor' => array(
                1 => array('code' => FULL_EXTEND_ALL_LINE.LINE_CS, 'name' => 'Full Level AP-CS'),
                2 => array('code' => VIEW_EXTEND_ALL_LINE.LINE_CS, 'name' => 'Xem Level AP-CS'),
                3 => array('code' => EDIT_EXTEND_ALL_LINE.LINE_CS, 'name' => 'Edit Level AP-CS'),
            ),
        ),
        32 => array(
            'group_permiss' => 'Quyền Đối tác PARTNER',
            'infor' => array(
                1 => array('code' => FULL_ALL_LINE.LINE_PARTNER, 'name' => 'Full Đối tác PARTNER'),
                2 => array('code' => VIEW_ALL_LINE.LINE_PARTNER, 'name' => 'Xem Đối tác PARTNER'),
                3 => array('code' => EDIT_ALL_LINE.LINE_PARTNER, 'name' => 'Edit Đối tác PARTNER'),
            ),
        ),

        13 => array(
            'group_permiss' => 'Quyền Staff CA',
            'infor' => array(
                1 => array('code' => STAFF_FULL.STAFF_CODE_CA, 'name' => 'Full quyền CA'),
                2 => array('code' => STAFF_VIEW.STAFF_CODE_CA, 'name' => 'Quyền xem CA'),
                3 => array('code' => STAFF_EDIT.STAFF_CODE_CA, 'name' => 'Edit CA'),
            ),
        ),
        14 => array(
            'group_permiss' => 'Quyền Staff DSA',
            'infor' => array(
                1 => array('code' => STAFF_FULL.STAFF_CODE_DSA, 'name' => 'Full quyền DSA'),
                2 => array('code' => STAFF_VIEW.STAFF_CODE_DSA, 'name' => 'Quyền xem DSA'),
                3 => array('code' => STAFF_EDIT.STAFF_CODE_DSA, 'name' => 'Edit DSA'),
            ),
        ),
        15 => array(
            'group_permiss' => 'Quyền Staff DE',
            'infor' => array(
                1 => array('code' => STAFF_FULL.STAFF_CODE_DE, 'name' => 'Full quyền DE'),
                2 => array('code' => STAFF_VIEW.STAFF_CODE_DE, 'name' => 'Quyền xem DE'),
                3 => array('code' => STAFF_EDIT.STAFF_CODE_DE, 'name' => 'Edit DE'),
            ),
        ),
        16 => array(
            'group_permiss' => 'Quyền Staff DES',
            'infor' => array(
                1 => array('code' => STAFF_FULL.STAFF_CODE_DES, 'name' => 'Full quyền DES'),
                2 => array('code' => STAFF_VIEW.STAFF_CODE_DES, 'name' => 'Quyền xem DES'),
                3 => array('code' => STAFF_EDIT.STAFF_CODE_DES, 'name' => 'Edit DES'),
            ),
        ),
        17 => array(
            'group_permiss' => 'Quyền Staff BDS',
            'infor' => array(
                1 => array('code' => STAFF_FULL.STAFF_CODE_BDS, 'name' => 'Full quyền BDS'),
                2 => array('code' => STAFF_VIEW.STAFF_CODE_BDS, 'name' => 'Quyền xem BDS'),
                3 => array('code' => STAFF_EDIT.STAFF_CODE_BDS, 'name' => 'Edit BDS'),
            ),
        ),
        18 => array(
            'group_permiss' => 'Quyền Staff ASM',
            'infor' => array(
                1 => array('code' => STAFF_FULL.STAFF_CODE_ASM, 'name' => 'Full quyền ASM'),
                2 => array('code' => STAFF_VIEW.STAFF_CODE_ASM, 'name' => 'Quyền xem ASM'),
                3 => array('code' => STAFF_EDIT.STAFF_CODE_ASM, 'name' => 'Edit ASM'),
            ),
        ),
        19 => array(
            'group_permiss' => 'Quyền Staff RSM',
            'infor' => array(
                1 => array('code' => STAFF_FULL.STAFF_CODE_RSM, 'name' => 'Full quyền RSM'),
                2 => array('code' => STAFF_VIEW.STAFF_CODE_RSM, 'name' => 'Quyền xem RSM'),
                3 => array('code' => STAFF_EDIT.STAFF_CODE_RSM, 'name' => 'Edit RSM'),
            ),
        ),
        20 => array(
            'group_permiss' => 'Quyền Staff TSA',
            'infor' => array(
                1 => array('code' => STAFF_FULL.STAFF_CODE_TSA, 'name' => 'Full quyền TSA'),
                2 => array('code' => STAFF_VIEW.STAFF_CODE_TSA, 'name' => 'Quyền xem TSA'),
                3 => array('code' => STAFF_EDIT.STAFF_CODE_TSA, 'name' => 'Edit TSA'),
            ),
        ),
        21 => array(
            'group_permiss' => 'Quyền Staff TC',
            'infor' => array(
                1 => array('code' => STAFF_FULL.STAFF_CODE_TC, 'name' => 'Full quyền TC'),
                2 => array('code' => STAFF_VIEW.STAFF_CODE_TC, 'name' => 'Quyền xem TC'),
                3 => array('code' => STAFF_EDIT.STAFF_CODE_TC, 'name' => 'Edit TC'),
            ),
        ),
        22 => array(
            'group_permiss' => 'Quyền Department HUB/KIOSK',
            'infor' => array(
                1 => array('code' => DEPART_FULL.DEPART_CODE_HUB_KIOSK, 'name' => 'Full quyền HUB/KIOSK'),
                2 => array('code' => DEPART_VIEW.DEPART_CODE_HUB_KIOSK, 'name' => 'Quyền xem HUB/KIOSK'),
                3 => array('code' => DEPART_EDIT.DEPART_CODE_HUB_KIOSK, 'name' => 'Edit HUB/KIOSK'),
            ),
        ),
        23 => array(
            'group_permiss' => 'Quyền Department BATCH',
            'infor' => array(
                1 => array('code' => DEPART_FULL.DEPART_CODE_BATCH, 'name' => 'Full quyền BATCH'),
                2 => array('code' => DEPART_VIEW.DEPART_CODE_BATCH, 'name' => 'Quyền xem BATCH'),
                3 => array('code' => DEPART_EDIT.DEPART_CODE_BATCH, 'name' => 'Edit BATCH'),
            ),
        ),
        24 => array(
            'group_permiss' => 'Quyền Department AREA',
            'infor' => array(
                1 => array('code' => DEPART_FULL.DEPART_CODE_AREA, 'name' => 'Full quyền AREA'),
                2 => array('code' => DEPART_VIEW.DEPART_CODE_AREA, 'name' => 'Quyền xem AREA'),
                3 => array('code' => DEPART_EDIT.DEPART_CODE_AREA, 'name' => 'Edit AREA'),
            ),
        ),
        25 => array(
            'group_permiss' => 'Quyền Department REGION',
            'infor' => array(
                1 => array('code' => DEPART_FULL.DEPART_CODE_REGION, 'name' => 'Full quyền REGION'),
                2 => array('code' => DEPART_VIEW.DEPART_CODE_REGION, 'name' => 'Quyền xem REGION'),
                3 => array('code' => DEPART_EDIT.DEPART_CODE_REGION, 'name' => 'Edit REGION'),
            ),
        ),
        26 => array(
            'group_permiss' => 'Quyền Department SIP/POS',
            'infor' => array(
                1 => array('code' => DEPART_FULL.DEPART_CODE_SIP_POS, 'name' => 'Full quyền SIP/POS'),
                2 => array('code' => DEPART_VIEW.DEPART_CODE_SIP_POS, 'name' => 'Quyền xem SIP/POS'),
                3 => array('code' => DEPART_EDIT.DEPART_CODE_SIP_POS, 'name' => 'Edit SIP/POS'),
            ),
        ),
        29 => array(
            'group_permiss' => 'Quyền Config BPM',
            'infor' => array(
                1 => array('code' => PERMISS_CONFIG_FULL, 'name' => 'Full Config BPM'),
                2 => array('code' => PERMISS_CONFIG_VIEW, 'name' => 'Xem Config BPM'),
                3 => array('code' => PERMISS_CONFIG_CREATE, 'name' => 'Edit Config BPM'),
            ),
        ),
        33 => array(
            'group_permiss' => 'Quyền Define',
            'infor' => array(
                1 => array('code' => PERMISS_DEFINE_FULL, 'name' => 'Full Define'),
                2 => array('code' => PERMISS_DEFINE_VIEW, 'name' => 'Xem Define'),
                3 => array('code' => PERMISS_DEFINE_CREATE, 'name' => 'Edit Define'),
            ),
        ),
    );

}