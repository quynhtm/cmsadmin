<?php
/*
* @Created by: QuynhTM
* @Author    : manhquynh1984@gmail.com
* @Date      : 13/03/2020
* @Version   : 1.0
*/

namespace App\Services;

use App\Http\Models\OpenId\UserSystem;
use Illuminate\Support\Facades\Config;
//use Maatwebsite\Excel\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

use Excel;


/**
 * Class ActionExcel
 * @package App\Services
 * Các function liên quan đến ActionExcel
 */
class ActionExcel
{
    protected $objUser = [];

    //voucher
    const EXPORT_EXCEL_VOUCHER_DETAIL = 'VOUCHER_DETAIL';
    const EXPORT_EXCEL_CUSTOMER_VOUCHER = 'CUSTOMER_VOUCHER';
    const EXPORT_EXCEL_CUSTOMER_HEALTH = 'CUSTOMER_HEALTH';
    const EXPORT_EXCEL_VOUCHER_COMMON = 'VOUCHER_COMMON';

    const EXPORT_EXCEL_CLAIM_HDI = 'CLAIM_HDI';

    //insmart
    const EXPORT_EXCEL_INSMART = 'EXPORT_EXCEL_INSMART';

    //vietjet
    const EXPORT_PRODUCT_VIETJET = 'EXPORT_PRODUCT_VIETJET';
    //xe cơ giới
    const EXPORT_PRODUCT_XCG_TNDSBB = 'EXPORT_PRODUCT_XCG_TNDSBB';

    public function __construct()
    {
        $this->objUser = new UserSystem();
    }

    public function exportExcel($dataView, $type = '',$dataOther = [])
    {
        switch (strtoupper($type)) {
            //voucher
            case self::EXPORT_EXCEL_VOUCHER_DETAIL:
                $this->exportVoucherDetail($dataView);
                break;
            case self::EXPORT_EXCEL_CUSTOMER_VOUCHER:
                $this->exportCustomerVoucher($dataView,$dataOther);
                break;
            case self::EXPORT_EXCEL_CUSTOMER_HEALTH:
                $this->exportCustomerHealth($dataView,$dataOther);
                break;
            case self::EXPORT_EXCEL_VOUCHER_COMMON:
                $this->exportVoucherCommon($dataView,$dataOther);
                break;
            case self::EXPORT_EXCEL_INSMART:
                $this->exportInsmart($dataView,$dataOther);
                break;
            case self::EXPORT_EXCEL_CLAIM_HDI:
                $this->exportClaimHdi($dataView,$dataOther);
                break;
            case self::EXPORT_PRODUCT_VIETJET:
                $this->exportProductVietjet($dataView,$dataOther);
                break;
            case self::EXPORT_PRODUCT_XCG_TNDSBB:
                $this->exportProductXCG($dataView,$dataOther);
                break;
            default:
                $this->exportDefault($dataView);
                break;
        }
    }

    //voucher
    public function exportVoucherDetail($data)
    {
        if (empty($data))
            return;
        $user = $this->objUser->userLogin();

        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()->setCreator('HD Insurance')
            ->setLastModifiedBy('HD Insurance')
            ->setTitle('Office 2007 XLSX Document')
            ->setSubject('Office 2007 XLSX Document')
            ->setDescription('Export HD Insurance' )
            ->setKeywords('office 2007 openxml php');
        $dataOne = $data[0];
        $fileName = 'Danh Sách Mã Voucher' ;
        $spreadsheet->getActiveSheet()->mergeCells('A1:B1');
        $spreadsheet->getActiveSheet()->setCellValue('A1', $fileName)->getStyle('A1:B1')->applyFromArray(array(
            'font' => array(
                'size' => 11,
                'bold' => true,
                'name' => 'Calibri',
                'color' => array('rgb' => '000000'),
            ),
            'alignment' => array(
                'horizontal' => 'center',
                'vertical' => 'center'
            )
        ));

        $spreadsheet->getActiveSheet()->mergeCells('A3:B3');
        $spreadsheet->getActiveSheet()->setCellValue('A3', 'Người xuất: '.$user['user_full_name'])->getColumnDimension('A')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->mergeCells('A4:B4');
        $spreadsheet->getActiveSheet()->setCellValue('A4', 'Thời gian xuất file: '.date('d-m-Y'))->getColumnDimension('A')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->mergeCells('A5:B5');
        $spreadsheet->getActiveSheet()->setCellValue('A5', 'Đối tác: '.$dataOne->ORG_NAME)->getColumnDimension('A')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->mergeCells('A6:B6');
        $spreadsheet->getActiveSheet()->setCellValue('A6', 'Chiến dịch: '.$dataOne->CAMPAIGN_NAME)->getColumnDimension('A')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->mergeCells('A7:B7');
        $spreadsheet->getActiveSheet()->setCellValue('A7', 'Sản phẩm: '.$dataOne->PRODUCT_NAME)->getColumnDimension('A')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->mergeCells('A8:B8');
        $spreadsheet->getActiveSheet()->setCellValue('A8', 'Gói: '.$dataOne->PACK_NAME)->getColumnDimension('A')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->mergeCells('A9:B9');
        $spreadsheet->getActiveSheet()->setCellValue('A9', 'Mã block: '.$dataOne->BLOCK_CODE)->getColumnDimension('A')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->mergeCells('A10:B10');
        $spreadsheet->getActiveSheet()->setCellValue('A10', 'Số lượng cấp phát: '.$dataOne->AMOUNT_ALLOCATE)->getColumnDimension('A')->setAutoSize(true);

        //title
        $spreadsheet->getActiveSheet()->setCellValue('A12', "STT")->getColumnDimension('A')->setWidth(5);
        $spreadsheet->getActiveSheet()->getStyle('A12')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->setCellValue('B12', "Mã Voucher")->getColumnDimension('B')->setWidth(50);
        $spreadsheet->getActiveSheet()->getStyle('A12:B12')->applyFromArray(array(
            'font' => array(
                'size' => 11,
                'bold' => true,
                'name' => 'Calibri',
                'color' => array('rgb' => '000000'),
            ),
            'alignment' => array(
                'horizontal' => 'center',
                'vertical' => 'center'
            )
        ));

        //fill data
        $i = 13;
        if(!empty($data)){
            foreach ($data as $k => $item) {
                $spreadsheet->getActiveSheet()->setCellValue('A' . $i, $k+1)->getStyle('A' . $i)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $spreadsheet->getActiveSheet()->setCellValue('B' . $i, $item->ACTIVATION_CODE)->getStyle('B' . $i)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $i++;
            }
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="danh_sach_voucher_.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    public function exportCustomerVoucher($dataInput = [], $dataOther = [])
    {
        $data = isset($dataInput['data'])? $dataInput['data']: [];
        $total_staff = isset($dataInput['total'])? $dataInput['total']: 0;
        if (empty($data))
            return;

        $spreadsheet = new Spreadsheet();

        // Set document properties
        $fileName = 'Danh Sách Khách hàng đăng ký Voucher ';
        $spreadsheet->getProperties()->setCreator('HDI')
            ->setLastModifiedBy('HDI')
            ->setTitle('Office 2007 XLSX Document')
            ->setSubject('Office 2007 XLSX Document')
            ->setDescription('Export '.$fileName )
            ->setKeywords('office 2007 openxml php');

        $spreadsheet->getActiveSheet()->mergeCells('A1:M2');
        $spreadsheet->getActiveSheet()->setCellValue('A1', $fileName)->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getStyle('A1:M2')->applyFromArray(array(
            'font' => array(
                'size' => 14,
                'bold' => true,
                'name' => 'Calibri',
                'color' => array('rgb' => '47aa5e'),
            ),
            'alignment' => array(
                'horizontal' => 'center',
                'vertical' => 'center'
            )
        ));
        $i = 3;
        $spreadsheet->getActiveSheet()->setCellValue('A'.$i, "#")->getColumnDimension('A')->setWidth(5);
        $spreadsheet->getActiveSheet()->setCellValue('B'.$i, "Đối tác")->getColumnDimension('B')->setWidth(30);
        $spreadsheet->getActiveSheet()->setCellValue('C'.$i, "Chương trình")->getColumnDimension('C')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setCellValue('D'.$i, "Tên khách hàng")->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('E'.$i, "Email")->getColumnDimension('E')->setWidth(30);
        $spreadsheet->getActiveSheet()->setCellValue('F'.$i, "Phone")->getColumnDimension('F')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('G'.$i, "CMT")->getColumnDimension('G')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('H'.$i, "Ngày sinh")->getColumnDimension('H')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('I'.$i, "Địa chỉ")->getColumnDimension('I')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('J'.$i, "Tài khoản ngân hàng")->getColumnDimension('J')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setCellValue('K'.$i, "Gói")->getColumnDimension('K')->setAutoSize(10);
        $spreadsheet->getActiveSheet()->setCellValue('L'.$i, "Mã")->getColumnDimension('L')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('M'.$i, "Số hiệu")->getColumnDimension('M')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('N'.$i, "Ngày đăng ký")->getColumnDimension('N')->setWidth(20);
        $spreadsheet->getActiveSheet()->getStyle('A'.$i.':N'.$i)->getFill()->setFillType('solid')->getStartColor()->setARGB('47aa5e');

        // style header cell of table
        $spreadsheet->getActiveSheet()->getStyle('A'.$i.':N'.$i)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('4472C4');
        $spreadsheet->getActiveSheet()->getStyle('A'.$i.':N'.$i)->applyFromArray(array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                )
            ),
            'font' => array(
                'size' => 11,
                'bold' => true,
                'name' => 'Calibri',
                'color' => array('rgb' => 'FFFFFF'),
            ),
            'alignment' => array(
                'horizontal' => 'center',
                'vertical' => 'center'
            )
        ));

        // style content
        $i = $i+1;
        $col_next = $total_staff + 3;
        $spreadsheet->getActiveSheet()->getStyle('A' . $i . ':N' . $col_next)->applyFromArray(array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                )
            ),
            'font' => array(
                'size' => 10,
                'bold' => false,
                'name' => 'Calibri',
                'color' => array('rgb' => '000000'),
            ),
            'alignment' => array(
                'horizontal' => 'center',
                'vertical' => 'center'
            )
        ));
        // auto filter
        //$spreadsheet->getActiveSheet()->setAutoFilter('B3' . ':L' . $col_next);
        foreach ($data as $k => $staff) {
            $spreadsheet->getActiveSheet()->setCellValue('A' . $i, $i - 3);// index column
            $spreadsheet->getActiveSheet()->setCellValue('B' . $i, $staff->ORG_NAME);
            $spreadsheet->getActiveSheet()->setCellValue('C' . $i, $staff->CAMPAIGN_NAME);

            $spreadsheet->getActiveSheet()->setCellValue('D' . $i, $staff->CUS_NAME);
            $spreadsheet->getActiveSheet()->setCellValue('E' . $i, $staff->EMAIL);
            $spreadsheet->getActiveSheet()->setCellValue('F' . $i, $staff->PHONE);
            $spreadsheet->getActiveSheet()->setCellValue('G' . $i, $staff->IDCARD);
            $spreadsheet->getActiveSheet()->setCellValue('H' . $i, convertDateDMY($staff->DOB));
            $spreadsheet->getActiveSheet()->setCellValue('I' . $i, $staff->ADDRESS);
            $spreadsheet->getActiveSheet()->setCellValue('J' . $i, $staff->BANK_ACCOUNT_NUM);

            $spreadsheet->getActiveSheet()->setCellValue('K' . $i, $staff->PACK_NAME);
            $spreadsheet->getActiveSheet()->setCellValue('L' . $i, $staff->GIFT_CODE);
            $spreadsheet->getActiveSheet()->setCellValue('M' . $i, $staff->SERY_NO);
            $spreadsheet->getActiveSheet()->setCellValue('N' . $i, date('d/m/Y H:i', strtotime($staff->CREATE_DATE)));
            $i++;
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    public function exportCustomerHealth($dataInput = [], $dataOther = [])
    {
        $data = isset($dataInput['data'])? $dataInput['data']: [];
        $total_staff = isset($dataInput['total'])? $dataInput['total']: 0;
        if (empty($data))
            return;
        $spreadsheet = new Spreadsheet();
        // Set document properties
        $fileName = 'Danh Sách Khách hàng đăng ký Sức khỏe ';
        $spreadsheet->getProperties()->setCreator('HDI')
            ->setLastModifiedBy('HDI')
            ->setTitle('Office 2007 XLSX Document')
            ->setSubject('Office 2007 XLSX Document')
            ->setDescription('Export '.$fileName )
            ->setKeywords('office 2007 openxml php');

        $spreadsheet->getActiveSheet()->mergeCells('A1:O2');
        $spreadsheet->getActiveSheet()->setCellValue('A1', $fileName)->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getStyle('A1:O2')->applyFromArray(array(
            'font' => array(
                'size' => 14,
                'bold' => true,
                'name' => 'Calibri',
                'color' => array('rgb' => '47aa5e'),
            ),
            'alignment' => array(
                'horizontal' => 'center',
                'vertical' => 'center'
            )
        ));
        $i = 3;
        $spreadsheet->getActiveSheet()->setCellValue('A'.$i, "#")->getColumnDimension('A')->setWidth(5);
        $spreadsheet->getActiveSheet()->setCellValue('B'.$i, "Đối tác")->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('C'.$i, "Chương trình")->getColumnDimension('C')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setCellValue('D'.$i, "Tên khách hàng")->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('E'.$i, "Người mua bảo hiểm")->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('F'.$i, "Đối tượng bảo hiểm")->getColumnDimension('F')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('G'.$i, "Email")->getColumnDimension('G')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('H'.$i, "Phone")->getColumnDimension('H')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('I'.$i, "Mã NV")->getColumnDimension('I')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setCellValue('J'.$i, "CMND")->getColumnDimension('J')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('K'.$i, "Ngày sinh")->getColumnDimension('K')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('L'.$i, "Địa chỉ")->getColumnDimension('L')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('M'.$i, "Tài khoản ngân hàng")->getColumnDimension('M')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('N'.$i, "Gói")->getColumnDimension('N')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('O'.$i, "Mã")->getColumnDimension('O')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('P'.$i, "Số tiền")->getColumnDimension('P')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('Q'.$i, "Số hiệu")->getColumnDimension('Q')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('R'.$i, "Ngày đăng ký")->getColumnDimension('R')->setWidth(20);

        $spreadsheet->getActiveSheet()->getStyle('A'.$i.':R'.$i)->getFill()->setFillType('solid')->getStartColor()->setARGB('47aa5e');
        // style header cell of table
        $spreadsheet->getActiveSheet()->getStyle('A'.$i.':R'.$i)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('4472C4');
        $spreadsheet->getActiveSheet()->getStyle('A'.$i.':R'.$i)->applyFromArray(array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                )
            ),
            'font' => array(
                'size' => 11,
                'bold' => true,
                'name' => 'Calibri',
                'color' => array('rgb' => 'FFFFFF'),
            ),
            'alignment' => array(
                'horizontal' => 'center',
                'vertical' => 'center'
            )
        ));

        // style content
        $i = $i+1;
        $col_next = $total_staff + 3;
        $spreadsheet->getActiveSheet()->getStyle('A' . $i . ':R' . $col_next)->applyFromArray(array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                )
            ),
            'font' => array(
                'size' => 10,
                'bold' => false,
                'name' => 'Calibri',
                'color' => array('rgb' => '000000'),
            ),
            'alignment' => array(
                'horizontal' => 'center',
                'vertical' => 'center'
            )
        ));
        // auto filter
        //$spreadsheet->getActiveSheet()->setAutoFilter('B3' . ':M' . $col_next);
        foreach ($data as $k => $staff) {
            $spreadsheet->getActiveSheet()->setCellValue('A' . $i, $i - 3);// index column
            $spreadsheet->getActiveSheet()->setCellValue('B' . $i, $staff->ORG_CODE);//đối tác
            $spreadsheet->getActiveSheet()->setCellValue('C' . $i, $staff->CAMPAIGN_NAME);//chương trình

            $spreadsheet->getActiveSheet()->setCellValue('D' . $i, $staff->CUS_NAME);//tên khách hàng
            $spreadsheet->getActiveSheet()->setCellValue('E' . $i, $staff->STAFF_NAME);//người mua bảo hiểm
            $spreadsheet->getActiveSheet()->setCellValue('F' . $i, $staff->RELATIONSHIP);//đối tượng bảo hiểm
            $spreadsheet->getActiveSheet()->setCellValue('G' . $i, $staff->EMAIL);//email
            $spreadsheet->getActiveSheet()->setCellValue('H' . $i, $staff->PHONE);//phone
            $spreadsheet->getActiveSheet()->setCellValue('I' . $i, $staff->STAFF_CODE);//mã nhân viên

            $spreadsheet->getActiveSheet()->setCellValue('J' . $i, $staff->IDCARD);//CMND
            $spreadsheet->getActiveSheet()->setCellValue('K' . $i, convertDateDMY($staff->DOB));//ngày sinh
            $spreadsheet->getActiveSheet()->setCellValue('L' . $i, $staff->ADDRESS);//địa chỉ
            $spreadsheet->getActiveSheet()->setCellValue('M' . $i, $staff->BANK_ACCOUNT_NUM);//tài khoản ngân hàng
            $spreadsheet->getActiveSheet()->setCellValue('N' . $i, $staff->PACK_NAME);//gói
            $spreadsheet->getActiveSheet()->setCellValue('O' . $i, $staff->GIFT_CODE);//mã
            $spreadsheet->getActiveSheet()->setCellValue('P' . $i, numberFormat($staff->AMOUNT));//số tiền
            $spreadsheet->getActiveSheet()->setCellValue('Q' . $i, $staff->SERY_NO);//số hiệu
            $spreadsheet->getActiveSheet()->setCellValue('R' . $i, date('d/m/Y H:i', strtotime($staff->CREATE_DATE)));//ngày đăng ký
            $i++;
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    public function exportVoucherCommon($dataInput = [], $dataOther = [])
    {
        $data = isset($dataInput['data'])? $dataInput['data']: [];
        $total_staff = count($data);
        if (empty($data))
            return;
        $spreadsheet = new Spreadsheet();

        // Set document properties
        $fileName = 'Danh sách báo cáo tổng hợp ';
        $spreadsheet->getProperties()->setCreator('HDI')
            ->setLastModifiedBy('HDI')
            ->setTitle('Office 2007 XLSX Document')
            ->setSubject('Office 2007 XLSX Document')
            ->setDescription('Export '.$fileName )
            ->setKeywords('office 2007 openxml php');

        $spreadsheet->getActiveSheet()->mergeCells('A1:I2');
        $spreadsheet->getActiveSheet()->setCellValue('A1', $fileName)->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getStyle('A1:I2')->applyFromArray(array(
            'font' => array(
                'size' => 14,
                'bold' => true,
                'name' => 'Calibri',
                'color' => array('rgb' => '47aa5e'),
            ),
            'alignment' => array(
                'horizontal' => 'center',
                'vertical' => 'center'
            )
        ));
        $i = 3;
        // style header cell of table
        $spreadsheet->getActiveSheet()->setCellValue('A'.$i, "#")->getColumnDimension('A')->setWidth(5);
        $spreadsheet->getActiveSheet()->setCellValue('B'.$i, "Đối tác")->getColumnDimension('B')->setWidth(30);
        $spreadsheet->getActiveSheet()->setCellValue('C'.$i, "Chương trình")->getColumnDimension('C')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setCellValue('D'.$i, "Sản phẩm")->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('E'.$i, "Gói")->getColumnDimension('E')->setWidth(30);
        $spreadsheet->getActiveSheet()->setCellValue('F'.$i, "Mã")->getColumnDimension('F')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setCellValue('G'.$i, "Tổng kích hoạt")->getColumnDimension('G')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('H'.$i, "Tổng cấp phát")->getColumnDimension('H')->setAutoSize(10);
        $spreadsheet->getActiveSheet()->setCellValue('I'.$i, "Doanh thu")->getColumnDimension('I')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->getStyle('A'.$i.':I'.$i)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('4472C4');
        $spreadsheet->getActiveSheet()->getStyle('A'.$i.':I'.$i)->applyFromArray(array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                )
            ),
            'font' => array(
                'size' => 11,
                'bold' => true,
                'name' => 'Calibri',
                'color' => array('rgb' => 'FFFFFF'),
            ),
            'alignment' => array(
                'horizontal' => 'center',
                'vertical' => 'center'
            )
        ));

        // style content
        $i = $i+1;
        $col_next = $total_staff + 3;
        $spreadsheet->getActiveSheet()->getStyle('A' . $i . ':I' . $col_next)->applyFromArray(array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                )
            ),
            'font' => array(
                'size' => 10,
                'bold' => false,
                'name' => 'Calibri',
                'color' => array('rgb' => '000000'),
            ),
            'alignment' => array(
                'horizontal' => 'center',
                'vertical' => 'center'
            )
        ));
        // auto filter
        //$spreadsheet->getActiveSheet()->setAutoFilter('B3' . ':I' . $col_next);
        foreach ($data as $k => $staff) {
            $spreadsheet->getActiveSheet()->setCellValue('A' . $i, $i - 3);// index column
            $spreadsheet->getActiveSheet()->setCellValue('B' . $i, $staff->ORG_NAME);
            $spreadsheet->getActiveSheet()->setCellValue('C' . $i, $staff->CAMPAIGN_NAME);

            $spreadsheet->getActiveSheet()->setCellValue('D' . $i, $staff->PRODUCT_NAME);
            $spreadsheet->getActiveSheet()->setCellValue('E' . $i, $staff->PACK_NAME);
            $spreadsheet->getActiveSheet()->setCellValue('F' . $i, $staff->REF_CODE);

            $spreadsheet->getActiveSheet()->setCellValue('G' . $i, numberFormat($staff->NUM_OF_ACTIVE));
            $spreadsheet->getActiveSheet()->setCellValue('H' . $i, numberFormat($staff->AMOUNT_ALLOCATE));
            $spreadsheet->getActiveSheet()->setCellValue('I' . $i, numberFormat($staff->REVENUE));

            $i++;
        }
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    //save file and move file excel
    public function exportInsmart($data = [], $dataOther = [])
    {
        $total_staff = array_key_last($data);
        if (empty($data))
            return;
        $spreadsheet = new Spreadsheet();
        $fileName = $dataOther['fileName'];
        $spreadsheet->getProperties()->setCreator('HDI')
            ->setLastModifiedBy('HDI')
            ->setTitle('Office 2007 XLSX Document')
            ->setSubject('Office 2007 XLSX Document')
            ->setDescription('Export '.$fileName )
            ->setKeywords('office 2007 openxml php');
        //tên file excel
        $spreadsheet->getActiveSheet()->mergeCells('A1:P2');
        $spreadsheet->getActiveSheet()->setCellValue('A1', $fileName.' - Ngày '.date('d-m-Y H:i'))->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getStyle('A1:P2')->applyFromArray(array(
            'font' => array(
                'size' => 14,
                'bold' => true,
                'name' => 'Calibri',
                'color' => array('rgb' => '47aa5e'),
            ),
            'alignment' => array(
                'horizontal' => 'center',
                'vertical' => 'center'
            )
        ));
        $total_staff = $total_staff+1;
        $i = 3;
        //header 1
        $spreadsheet->getActiveSheet()->getStyle('A'.$i)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('4472C4');
        $spreadsheet->getActiveSheet()->mergeCells('B'.$i.':G'.$i);
        $spreadsheet->getActiveSheet()->setCellValue('B'.$i, 'Thông tin Hợp đồng bảo hiểm')->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getStyle('B'.$i.':G'.$i)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('A7C538');

        $spreadsheet->getActiveSheet()->mergeCells('H'.$i.':O'.$i);
        $spreadsheet->getActiveSheet()->setCellValue('H'.$i, 'Thông tin Người được bảo hiểm')->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getStyle('H'.$i.':O'.$i)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('4E943C');

        $spreadsheet->getActiveSheet()->getStyle('P'.$i)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('4472C4');
        $spreadsheet->getActiveSheet()->getStyle('A'.$i.':P'.$i)->applyFromArray(array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                )
            ),
            'font' => array(
                'size' => 11,
                'bold' => true,
                'name' => 'Calibri',
                'color' => array('rgb' => 'FFFFFF'),
            ),
            'alignment' => array(
                'horizontal' => 'center',
                'vertical' => 'center'
            )
        ));
        $i = $i+1;
        //header 2
        //header title table excel
        $spreadsheet->getActiveSheet()->setCellValue('A'.$i, "STT")->getColumnDimension('A')->setWidth(5);
        $spreadsheet->getActiveSheet()->setCellValue('B'.$i, "Ngày hiệu lực")->getColumnDimension('B')->setWidth(20);
        $spreadsheet->getActiveSheet()->setCellValue('C'.$i, "Ngày kết thúc")->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('D'.$i, "Số hợp đồng")->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('E'.$i, "Gói bảo hiểm")->getColumnDimension('E')->setWidth(30);
        $spreadsheet->getActiveSheet()->setCellValue('F'.$i, "Phí bảo hiểm")->getColumnDimension('F')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('G'.$i, "Ngày đóng phí")->getColumnDimension('G')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setCellValue('H'.$i, "Tên người bảo hiểm")->getColumnDimension('H')->setAutoSize(10);
        $spreadsheet->getActiveSheet()->setCellValue('I'.$i, "DOB")->getColumnDimension('I')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('J'.$i, "Số CMND/ Căn cước")->getColumnDimension('J')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('K'.$i, "Giới tính")->getColumnDimension('K')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('L'.$i, "Địa chỉ")->getColumnDimension('L')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('M'.$i, "Email")->getColumnDimension('M')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('N'.$i, "Số điện thoại")->getColumnDimension('N')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('O'.$i, "Ghi chú đặc biệt nếu có")->getColumnDimension('O')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setCellValue('P'.$i, "Link GCN")->getColumnDimension('P')->setAutoSize(true);
        // style header cell of table
        $spreadsheet->getActiveSheet()->getStyle('A'.$i.':P'.$i)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('4472C4');
        $spreadsheet->getActiveSheet()->getStyle('A'.$i.':P'.$i)->applyFromArray(array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                )
            ),
            'font' => array(
                'size' => 11,
                'bold' => true,
                'name' => 'Calibri',
                'color' => array('rgb' => 'FFFFFF'),
            ),
            'alignment' => array(
                'horizontal' => 'center',
                'vertical' => 'center'
            )
        ));

        // style content
        $col_next = $total_staff + $i;
        $i = $i+1;
        $spreadsheet->getActiveSheet()->getStyle('A' . $i . ':P' . $col_next)->applyFromArray(array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                )
            ),
            'font' => array(
                'size' => 10,
                'bold' => false,
                'name' => 'Calibri',
                'color' => array('rgb' => '000000'),
            ),
            'alignment' => array(
                'horizontal' => 'center',
                'vertical' => 'center'
            )
        ));
        // auto filter
        //$spreadsheet->getActiveSheet()->setAutoFilter('B3' . ':I' . $col_next);
        if(!empty($data)){
            foreach ($data as $k => $staff) {
                $spreadsheet->getActiveSheet()->setCellValue('A' . $i, $k+1);// index column
                $spreadsheet->getActiveSheet()->setCellValue('B' . $i, convertDateDMY($staff->EFFECTIVE_DATE));//ngày hiệu lực
                $spreadsheet->getActiveSheet()->setCellValue('C' . $i, convertDateDMY($staff->EXPIRATION_DATE));//ngày kết thúc
                $spreadsheet->getActiveSheet()->setCellValue('D' . $i, $staff->CONTRACT_NO);//số hợp đồng
                $spreadsheet->getActiveSheet()->setCellValue('E' . $i, $staff->PACK_NAME);//gói BH
                $spreadsheet->getActiveSheet()->setCellValue('F' . $i, numberFormat($staff->FEES));//phí
                $spreadsheet->getActiveSheet()->setCellValue('G' . $i, ($staff->PAID == STATUS_INT_MOT)?'Đã đóng phí': 'Chưa đóng phí');//ngày đóng phí

                $spreadsheet->getActiveSheet()->setCellValue('H' . $i, $staff->CUS_NAME);//tên KH
                $spreadsheet->getActiveSheet()->setCellValue('I' . $i, convertDateDMY($staff->DOB));//ngày sinh
                $spreadsheet->getActiveSheet()->setCellValue('J' . $i, $staff->IDCARD);//số CMND
                $spreadsheet->getActiveSheet()->setCellValue('K' . $i, ($staff->GENDER == GIOI_TINH_NAM)?'Nam':'Nữ');//giới tính
                $spreadsheet->getActiveSheet()->setCellValue('L' . $i, $staff->ADDRESS);//địa chỉ
                $spreadsheet->getActiveSheet()->setCellValue('M' . $i, $staff->EMAIL);//email
                $spreadsheet->getActiveSheet()->setCellValue('N' . $i, $staff->PHONE);//sdt
                $spreadsheet->getActiveSheet()->setCellValue('O' . $i, '');//ghi chú
                $spreadsheet->getActiveSheet()->setCellValue('P' . $i, $staff->LINK_INSMART);//link

                $i++;
            }
        }

        //xóa file tồn tại
        $path_folder_upload = Config::get('config.DIR_ROOT');
        $url_file = $path_folder_upload.'/'.$fileName.'.xlsx';
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($url_file);
        return $url_file;
    }

    //excel bồi thường
    public function exportClaimHdi($dataInput = [], $dataOther = [])
    {
        $data = isset($dataInput['data'])? $dataInput['data']: [];
        $total_staff = count($data);
        if (empty($data))
            return;
        $spreadsheet = new Spreadsheet();

        // Set document properties
        $fileName = 'Danh sách báo cáo bồi thường ';
        $spreadsheet->getProperties()->setCreator('HDI')
            ->setLastModifiedBy('HDI')
            ->setTitle('Office 2007 XLSX Document')
            ->setSubject('Office 2007 XLSX Document')
            ->setDescription('Export '.$fileName )
            ->setKeywords('office 2007 openxml php');

        $spreadsheet->getActiveSheet()->mergeCells('A1:I2');
        $spreadsheet->getActiveSheet()->setCellValue('A1', $fileName)->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getStyle('A1:I2')->applyFromArray(array(
            'font' => array(
                'size' => 14,
                'bold' => true,
                'name' => 'Calibri',
                'color' => array('rgb' => '47aa5e'),
            ),
            'alignment' => array(
                'horizontal' => 'center',
                'vertical' => 'center'
            )
        ));
        $i = 3;
        // style header cell of table
        $spreadsheet->getActiveSheet()->setCellValue('A'.$i, "#")->getColumnDimension('A')->setWidth(5);
        $spreadsheet->getActiveSheet()->setCellValue('B'.$i, "Sản phẩm")->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('C'.$i, "Hợp đồng bảo hiểm")->getColumnDimension('C')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setCellValue('D'.$i, "Khách hàng")->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('E'.$i, "Số tiền bồi thường")->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('F'.$i, "Kênh tiếp nhận")->getColumnDimension('F')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setCellValue('G'.$i, "Ngày yêu cầu")->getColumnDimension('G')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('H'.$i, "Người xử lý")->getColumnDimension('H')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('I'.$i, "Trạng thái")->getColumnDimension('I')->setAutoSize(true);

        //style content
        $spreadsheet->getActiveSheet()->getStyle('A'.$i.':I'.$i)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('4472C4');
        $spreadsheet->getActiveSheet()->getStyle('A'.$i.':I'.$i)->applyFromArray(array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                )
            ),
            'font' => array(
                'size' => 11,
                'bold' => true,
                'name' => 'Calibri',
                'color' => array('rgb' => 'FFFFFF'),
            ),
            'alignment' => array(
                'horizontal' => 'center',
                'vertical' => 'center'
            )
        ));
        $i = $i+1;
        $col_next = $total_staff + 3;
        $spreadsheet->getActiveSheet()->getStyle('A' . $i . ':I' . $col_next)->applyFromArray(array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                )
            ),
            'font' => array(
                'size' => 10,
                'bold' => false,
                'name' => 'Calibri',
                'color' => array('rgb' => '000000'),
            ),
            'alignment' => array(
                'horizontal' => 'center',
                'vertical' => 'center'
            )
        ));

        // auto filter
        //$spreadsheet->getActiveSheet()->setAutoFilter('B3' . ':I' . $col_next);
        foreach ($data as $k => $staff) {
            $spreadsheet->getActiveSheet()->setCellValue('A' . $i, $i - 3);// index column
            $spreadsheet->getActiveSheet()->setCellValue('B' . $i, $staff->PRODUCT_NAME);
            $spreadsheet->getActiveSheet()->setCellValue('C' . $i, $staff->CONTRACT_NO);

            $spreadsheet->getActiveSheet()->setCellValue('D' . $i, $staff->NAME);
            $spreadsheet->getActiveSheet()->setCellValue('E' . $i, numberFormat($staff->REQUIRED_AMOUNT));
            $spreadsheet->getActiveSheet()->setCellValue('F' . $i, $staff->CHANNEL);

            $spreadsheet->getActiveSheet()->setCellValue('G' . $i, $staff->CLAIM_DATE);
            $spreadsheet->getActiveSheet()->setCellValue('H' . $i, $staff->STAFF_NAME);
            $spreadsheet->getActiveSheet()->setCellValue('I' . $i, $staff->STATUS_NAME);

            $i++;
        }
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    //product Vietjet
    public function exportProductVietjet($dataInput = [], $dataOther = [])
    {
        $data = isset($dataInput['data'])? $dataInput['data']: [];
        $total_staff = count($data);
        if (empty($data))
            return;
        $spreadsheet = new Spreadsheet();

        // Set document properties
        $fileName = 'Danh sách báo cáo VietJet ';
        $spreadsheet->getProperties()->setCreator('HDI')
            ->setLastModifiedBy('HDI')
            ->setTitle('Office 2007 XLSX Document')
            ->setSubject('Office 2007 XLSX Document')
            ->setDescription('Export '.$fileName )
            ->setKeywords('office 2007 openxml php');

        $spreadsheet->getActiveSheet()->mergeCells('A1:F2');
        $spreadsheet->getActiveSheet()->setCellValue('A1', $fileName)->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getStyle('A1:F2')->applyFromArray(array(
            'font' => array(
                'size' => 14,
                'bold' => true,
                'name' => 'Calibri',
                'color' => array('rgb' => '47aa5e'),
            ),
            'alignment' => array(
                'horizontal' => 'center',
                'vertical' => 'center'
            )
        ));
        $i = 3;
        // style header cell of table
        $spreadsheet->getActiveSheet()->setCellValue('A'.$i, "#")->getColumnDimension('A')->setWidth(5);
        $spreadsheet->getActiveSheet()->setCellValue('B'.$i, "Đơn vị")->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('C'.$i, "Thông tin sản phẩm")->getColumnDimension('C')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setCellValue('D'.$i, "Ngày áp dụng")->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('E'.$i, "Số hợp đồng")->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('F'.$i, "Doanh thu")->getColumnDimension('F')->setAutoSize(true);

        //style content
        $spreadsheet->getActiveSheet()->getStyle('A'.$i.':F'.$i)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('4472C4');
        $spreadsheet->getActiveSheet()->getStyle('A'.$i.':F'.$i)->applyFromArray(array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                )
            ),
            'font' => array(
                'size' => 11,
                'bold' => true,
                'name' => 'Calibri',
                'color' => array('rgb' => 'FFFFFF'),
            ),
            'alignment' => array(
                'horizontal' => 'center',
                'vertical' => 'center'
            )
        ));
        $i = $i+1;
        $col_next = $total_staff + 3;
        $spreadsheet->getActiveSheet()->getStyle('A' . $i . ':F' . $col_next)->applyFromArray(array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                )
            ),
            'font' => array(
                'size' => 10,
                'bold' => false,
                'name' => 'Calibri',
                'color' => array('rgb' => '000000'),
            ),
            'alignment' => array(
                'horizontal' => 'center',
                'vertical' => 'center'
            )
        ));

        // auto filter
        //$spreadsheet->getActiveSheet()->setAutoFilter('B3' . ':I' . $col_next);
        foreach ($data as $k => $item) {
            $spreadsheet->getActiveSheet()->setCellValue('A' . $i, $i - 3);// index column
            $spreadsheet->getActiveSheet()->setCellValue('B' . $i, isset($item->ORG_NAME) ? $item->ORG_NAME:'');
            $spreadsheet->getActiveSheet()->setCellValue('C' . $i, isset($item->PRODUCT_NAME) ? $item->PRODUCT_NAME:'');

            $spreadsheet->getActiveSheet()->setCellValue('D' . $i, isset($item->EFFECTIVE_DATE) ? $item->EFFECTIVE_DATE:'');
            $spreadsheet->getActiveSheet()->setCellValue('E' . $i, isset($item->NUM_OF_CONTRACT) ? $item->NUM_OF_CONTRACT:'');
            $spreadsheet->getActiveSheet()->setCellValue('F' . $i, isset($item->TOTAL_AMOUNT) ? numberFormat($item->TOTAL_AMOUNT):'');
            $i++;
        }
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    //product xe cơ giới
    public function exportProductXCG($dataInput = [], $dataOther = [])
    {
        $data = isset($dataInput['data'])? $dataInput['data']: [];
        $total_staff = count($data);
        if (empty($data))
            return;
        $spreadsheet = new Spreadsheet();

        // Set document properties
        $fileName = 'Danh sách báo cáo Trách nhiệm dân sự xe cơ giới ';
        $spreadsheet->getProperties()->setCreator('HDI')
            ->setLastModifiedBy('HDI')
            ->setTitle('Office 2007 XLSX Document')
            ->setSubject('Office 2007 XLSX Document')
            ->setDescription('Export '.$fileName )
            ->setKeywords('office 2007 openxml php');

        $spreadsheet->getActiveSheet()->mergeCells('A1:H2');
        $spreadsheet->getActiveSheet()->setCellValue('A1', $fileName)->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getStyle('A1:H2')->applyFromArray(array(
            'font' => array(
                'size' => 14,
                'bold' => true,
                'name' => 'Calibri',
                'color' => array('rgb' => '47aa5e'),
            ),
            'alignment' => array(
                'horizontal' => 'center',
                'vertical' => 'center'
            )
        ));
        $i = 3;
        // style header cell of table
        $spreadsheet->getActiveSheet()->setCellValue('A'.$i, "#")->getColumnDimension('A')->setWidth(5);
        $spreadsheet->getActiveSheet()->setCellValue('B'.$i, "Loại xe")->getColumnDimension('B')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setCellValue('C'.$i, "SL đầu kỳ")->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('D'.$i, "SL phát sinh")->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('E'.$i, "SL cuối kỳ")->getColumnDimension('E')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setCellValue('F'.$i, "Phí đầu kỳ")->getColumnDimension('F')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('G'.$i, "Phí phát sinh")->getColumnDimension('G')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('H'.$i, "Phí cuối kỳ")->getColumnDimension('H')->setAutoSize(true);

        //style content
        $spreadsheet->getActiveSheet()->getStyle('A'.$i.':H'.$i)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('4472C4');
        $spreadsheet->getActiveSheet()->getStyle('A'.$i.':H'.$i)->applyFromArray(array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                )
            ),
            'font' => array(
                'size' => 11,
                'bold' => true,
                'name' => 'Calibri',
                'color' => array('rgb' => 'FFFFFF'),
            ),
            'alignment' => array(
                'horizontal' => 'center',
                'vertical' => 'center'
            )
        ));
        $i = $i+1;
        $col_next = $total_staff + 3;
        $spreadsheet->getActiveSheet()->getStyle('A' . $i . ':H' . $col_next)->applyFromArray(array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                )
            ),
            'font' => array(
                'size' => 10,
                'bold' => false,
                'name' => 'Calibri',
                'color' => array('rgb' => '000000'),
            ),
            'alignment' => array(
                'horizontal' => 'left',
                'vertical' => 'left'
            )
        ));

        // auto filter
        //$spreadsheet->getActiveSheet()->setAutoFilter('B3' . ':I' . $col_next);
        foreach ($data as $k => $item) {
            $spreadsheet->getActiveSheet()->setCellValue('A' . $i, $i - 3);// index column
            $spreadsheet->getActiveSheet()->setCellValue('B' . $i, isset($item->VH_TYPE) ? $item->VH_TYPE:'');

            $spreadsheet->getActiveSheet()->setCellValue('C' . $i, isset($item->DK_NUM_OF_VEH) ? numberFormat($item->DK_NUM_OF_VEH):'');
            $spreadsheet->getActiveSheet()->setCellValue('D' . $i, isset($item->PS_NUM_OF_VEH) ? numberFormat($item->PS_NUM_OF_VEH):'');
            $spreadsheet->getActiveSheet()->setCellValue('E' . $i, isset($item->EOT_NUM_OF_VEH) ? numberFormat($item->EOT_NUM_OF_VEH):'');

            $spreadsheet->getActiveSheet()->setCellValue('F' . $i, isset($item->DK_TOTAL_AMOUNT) ? numberFormat($item->DK_TOTAL_AMOUNT):'');
            $spreadsheet->getActiveSheet()->setCellValue('G' . $i, isset($item->PS_TOTAL_AMOUNT) ? numberFormat($item->PS_TOTAL_AMOUNT):'');
            $spreadsheet->getActiveSheet()->setCellValue('H' . $i, isset($item->EOT_TOTAL_AMOUNT) ? numberFormat($item->EOT_TOTAL_AMOUNT):'');
            $i++;
        }
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    public function exportDefault($dataInput)
    {
        $data = $dataInput['data'] ?? [];
        /*if (empty($data))
            return;*/
        $total_staff = 10;
        $spreadsheet = new Spreadsheet();

        // Set document properties
        $spreadsheet->getProperties()->setCreator('HD Insurance')
            ->setLastModifiedBy('HD Insurance')
            ->setTitle('Office 2007 XLSX Document')
            ->setSubject('Office 2007 XLSX Document')
            ->setDescription('Export Danh Sách Mã Voucher ' )
            ->setKeywords('office 2007 openxml php');

        $fileName = 'Danh Sách Mã Voucher ' ;
        $spreadsheet->getActiveSheet()->mergeCells('A1:B2');
        $spreadsheet->getActiveSheet()->setCellValue('A1', $fileName)->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getStyle('A1:B2')->applyFromArray(array(
            'font' => array(
                'size' => 14,
                'bold' => true,
                'name' => 'Calibri',
                'color' => array('rgb' => '47aa5e'),
            ),
            'alignment' => array(
                'horizontal' => 'center',
                'vertical' => 'center'
            )
        ));

        $spreadsheet->getActiveSheet()->setCellValue('A9', "STT")->getColumnDimension('A')->setWidth(5);
        $spreadsheet->getActiveSheet()->setCellValue('B9', "Mã Voucher")->getColumnDimension('C')->setAutoSize(50);

        // style header cell of table
        $spreadsheet->getActiveSheet()->getStyle('A3:F3')->applyFromArray(array(
            'font' => array(
                'size' => 11,
                'bold' => true,
                'name' => 'Calibri',
                'color' => array('rgb' => '000000'),
            ),
            'alignment' => array(
                'horizontal' => 'center',
                'vertical' => 'center'
            )
        ));

        // style content
        $i = 4;
        $col_next = $total_staff + 3;
        $spreadsheet->getActiveSheet()->getStyle('A' . $i . ':F' . $col_next)->applyFromArray(array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                )
            ),
            'font' => array(
                'size' => 10,
                'bold' => false,
                'name' => 'Calibri',
                'color' => array('rgb' => '000000'),
            ),
            'alignment' => array(
                'horizontal' => 'center',
                'vertical' => 'center'
            )
        ));
        // auto filter
        $spreadsheet->getActiveSheet()->setAutoFilter('B3' . ':M' . $col_next);
        if(!empty($data)){
            foreach ($data as $k => $staff) {
                $spreadsheet->getActiveSheet()->setCellValue('A' . $i, $i - 3);// index column
                $spreadsheet->getActiveSheet()->setCellValue('B' . $i, $staff->STAFF_NAME);
                $spreadsheet->getActiveSheet()->setCellValue('C' . $i, $staff->STAFF_CODE);
                $spreadsheet->getActiveSheet()->setCellValue('D' . $i, $staff->DEPARTMENT_CODE);
                $spreadsheet->getActiveSheet()->setCellValue('E' . $i, $staff->BDS_NAME);
                $spreadsheet->getActiveSheet()->setCellValue('F' . $i, $staff->BDS_CODE);
                $spreadsheet->getActiveSheet()->setCellValue('G' . $i, $staff->ASM_CODE);
                $spreadsheet->getActiveSheet()->setCellValue('H' . $i, $staff->RSM_CODE);
                $spreadsheet->getActiveSheet()->setCellValue('I' . $i, ($staff->ON_BOARD_DATE) ? substr($staff->ON_BOARD_DATE, 0, 10) : '');
                $spreadsheet->getActiveSheet()->setCellValue('J' . $i, ($staff->REACTIVE_DATE) ? substr($staff->REACTIVE_DATE, 0, 10) : '');
                $spreadsheet->getActiveSheet()->setCellValue('K' . $i, (!$staff->LEAVE_DATE && $staff->DEACTIVE_DATE) ? substr($staff->DEACTIVE_DATE, 0, 10) : '');
                $spreadsheet->getActiveSheet()->setCellValue('L' . $i, ($staff->LEAVE_DATE) ? substr($staff->LEAVE_DATE, 0, 10) : '');
                $spreadsheet->getActiveSheet()->setCellValue('M' . $i, $staff->STATUS ? 'Active' : 'Deactive');
                $i++;
            }
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="danh_sach_nhan_vien_.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }
}