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

    //bồi thường
    const EXPORT_EXCEL_CLAIM_HDI = 'CLAIM_HDI';
    const EXPORT_EXCEL_CLAIM_VIETJET = 'CLAIM_VIETJET';

    //insmart
    const EXPORT_EXCEL_INSMART = 'EXPORT_EXCEL_INSMART';

    //Excel product
    const EXPORT_PRODUCT_REPORT = 'EXPORT_PRODUCT_REPORT';

    //Cấp đơn theo lô
    const EXPORT_ORDERS_IN_BATCHES = 'EXPORT_ORDERS_IN_BATCHES';//rút gọn
    const EXPORT_ORDERS_IN_BATCHES_DETAIL = 'EXPORT_ORDERS_IN_BATCHES_DETAIL';//chi tiết

    //Excel detail product
    const EXPORT_PRODUCT_DETAIL_XCG_TNDSBB = 'EXPORT_PRODUCT_DETAIL_XCG_TNDSBB';
    const EXPORT_PRODUCT_DETAIL_XCG_VCX_NEW = 'EXPORT_PRODUCT_DETAIL_XCG_VCX_NEW';
    const EXPORT_PRODUCT_DETAIL_BAY_AT = 'EXPORT_PRODUCT_DETAIL_BAY_AT';
    const EXPORT_PRODUCT_DETAIL_LOST_BAGGAGE = 'EXPORT_PRODUCT_DETAIL_LOST_BAGGAGE';
    const EXPORT_PRODUCT_DETAIL_ATTD_NEW = 'EXPORT_PRODUCT_DETAIL_ATTD_NEW';
    const EXPORT_PRODUCT_DETAIL_COMMON = 'EXPORT_PRODUCT_DETAIL_COMMON';

    //Account: đối soát bảo hiểm hành lý
    const EXPORT_ACCOUNTANT_LOST_BAGGAGE = 'EXPORT_ACCOUNTANT_LOST_BAGGAGE';

    //Excel Đối soát
    const EXPORT_RECONCILIATION_BAY_AT = 'EXPORT_RECONCILIATION_BAY_AT';

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
            case self::EXPORT_PRODUCT_DETAIL_ATTD_NEW://Bình an cá nhân
                $this->exportAttdNew($dataView,$dataOther);
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
            //bồi thường
            case self::EXPORT_EXCEL_CLAIM_HDI:
                $this->exportClaimHdi($dataView,$dataOther);
                break;
            case self::EXPORT_EXCEL_CLAIM_VIETJET:
                $this->exportClaimVietJet($dataView,$dataOther);
                break;
            //sản phẩm
            case self::EXPORT_PRODUCT_REPORT:
                $this->exportProductVietjet($dataView,$dataOther);
                break;
            //chi tiết sản phẩm
            case self::EXPORT_PRODUCT_DETAIL_COMMON:
                $this->exportProductDetail($dataView,$dataOther);
                break;
            case self::EXPORT_PRODUCT_DETAIL_XCG_TNDSBB:
                $this->exportProductDetailXCG($dataView,$dataOther);
                break;
            case self::EXPORT_PRODUCT_DETAIL_XCG_VCX_NEW:
                $this->exportProductDetailVCX_NEW($dataView,$dataOther);
                break;
            case self::EXPORT_PRODUCT_DETAIL_BAY_AT:
                $this->exportProductDetailBayAT($dataView,$dataOther);
                break;
            case self::EXPORT_PRODUCT_DETAIL_LOST_BAGGAGE:
                $this->exportProductDetailLOST_BAGGAGE($dataView,$dataOther);
                break;
            //đối soát kế toán: bảo hiểm hành lý
            case self::EXPORT_ACCOUNTANT_LOST_BAGGAGE:
                $this->exportAccountantLOST_BAGGAGE($dataView,$dataOther);
                break;
            //Cấp đơn theo lô
            case self::EXPORT_ORDERS_IN_BATCHES:
                $this->exportOrdersInBatches($dataView,$dataOther);
                break;
            case self::EXPORT_ORDERS_IN_BATCHES_DETAIL:
                $this->exportOrdersInBatchesDetail($dataView,$dataOther);
                break;
            //đối soát
            case self::EXPORT_RECONCILIATION_BAY_AT:
                $this->exportReconciliationBayAT($dataView,$dataOther);
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
        $fileName = strtoupper(isset($dataInput['file_name'])? $dataInput['file_name']: 'Danh sách báo cáo ngày '.getCurrentDateDMY());
        if (empty($data))
            return;

        $spreadsheet = new Spreadsheet();

        // Set document properties
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
        foreach ($data as $k => $item) {
            $spreadsheet->getActiveSheet()->setCellValue('A' . $i, $i - 3);// index column
            $spreadsheet->getActiveSheet()->setCellValue('B' . $i, isset($item->ORG_NAME) ? $item->ORG_NAME:'' );
            $spreadsheet->getActiveSheet()->setCellValue('C' . $i, isset($item->CAMPAIGN_NAME) ? $item->CAMPAIGN_NAME:'' );

            $spreadsheet->getActiveSheet()->setCellValue('D' . $i, isset($item->CUS_NAME) ? $item->CUS_NAME:'');
            $spreadsheet->getActiveSheet()->setCellValue('E' . $i, isset($item->EMAIL) ? $item->EMAIL:'' );
            $spreadsheet->getActiveSheet()->setCellValue('F' . $i, isset($item->PHONE) ? $item->PHONE:'');
            $spreadsheet->getActiveSheet()->setCellValue('G' . $i, isset($item->IDCARD) ? $item->IDCARD:'');
            $spreadsheet->getActiveSheet()->setCellValue('H' . $i, isset($item->DOB) ? convertDateDMY($item->DOB):'' );
            $spreadsheet->getActiveSheet()->setCellValue('I' . $i, isset($item->ADDRESS) ? $item->ADDRESS:'');
            $spreadsheet->getActiveSheet()->setCellValue('J' . $i, isset($item->BANK_ACCOUNT_NUM) ? $item->BANK_ACCOUNT_NUM:'');

            $spreadsheet->getActiveSheet()->setCellValue('K' . $i, isset($item->PACK_NAME) ? $item->PACK_NAME:'');
            $spreadsheet->getActiveSheet()->setCellValue('L' . $i, isset($item->GIFT_CODE) ? $item->GIFT_CODE:'');
            $spreadsheet->getActiveSheet()->setCellValue('M' . $i, isset($item->SERY_NO) ? $item->SERY_NO:'');
            $spreadsheet->getActiveSheet()->setCellValue('N' . $i, isset($item->CREATE_DATE) ?  date('d/m/Y H:i', strtotime($item->CREATE_DATE)):'');
            $i++;
        }

        return $this->_saveFileExcel($spreadsheet,$fileName);
    }

    public function exportProductDetail($dataInput = [], $dataOther = [])
    {
        $data = isset($dataInput['data'])? $dataInput['data']: [];
        $total_staff = isset($dataInput['total'])? $dataInput['total']: 0;
        $fileName = strtoupper(isset($dataInput['file_name'])? $dataInput['file_name']: 'Danh sách báo cáo ngày '.getCurrentDateDMY());
        if (empty($data))
            return;

        $spreadsheet = new Spreadsheet();

        // Set document properties
        $spreadsheet->getProperties()->setCreator('HDI')
            ->setLastModifiedBy('HDI')
            ->setTitle('Office 2007 XLSX Document')
            ->setSubject('Office 2007 XLSX Document')
            ->setDescription('Export '.$fileName )
            ->setKeywords('office 2007 openxml php');

        $spreadsheet->getActiveSheet()->mergeCells('A1:W2');
        $spreadsheet->getActiveSheet()->setCellValue('A1', $fileName)->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getStyle('A1:W2')->applyFromArray(array(
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

        $spreadsheet->getActiveSheet()->setCellValue('O'.$i, "Số GCN")->getColumnDimension('O')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('P'.$i, "Số serial")->getColumnDimension('P')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('Q'.$i, "Phí bảo hiểm (chưa VAT)")->getColumnDimension('Q')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('R'.$i, "VAT của phí bảo hiểm")->getColumnDimension('R')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('S'.$i, "Phí dịch vụ bổ trợ (chưa VAT)")->getColumnDimension('S')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('T'.$i, "VAT của phí dịch vụ bổ trợ")->getColumnDimension('T')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('U'.$i, "Tổng tiền (đã gồm VAT)")->getColumnDimension('U')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('V'.$i, "Số tiền bảo hiểm")->getColumnDimension('V')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('W'.$i, "Thời hạn bảo hiểm")->getColumnDimension('W')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->getStyle('A'.$i.':W'.$i)->getFill()->setFillType('solid')->getStartColor()->setARGB('47aa5e');

        // style header cell of table
        $spreadsheet->getActiveSheet()->getStyle('A'.$i.':W'.$i)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('4472C4');
        $spreadsheet->getActiveSheet()->getStyle('A'.$i.':W'.$i)->applyFromArray(array(
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
        $spreadsheet->getActiveSheet()->getStyle('A' . $i . ':W' . $col_next)->applyFromArray(array(
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
        foreach ($data as $k => $item) {
            $spreadsheet->getActiveSheet()->setCellValue('A' . $i, $i - 3);// index column
            $spreadsheet->getActiveSheet()->setCellValue('B' . $i, isset($item->ORG_NAME) ? $item->ORG_NAME:'' );
            $spreadsheet->getActiveSheet()->setCellValue('C' . $i, isset($item->CAMPAIGN_NAME) ? $item->CAMPAIGN_NAME:'' );

            $spreadsheet->getActiveSheet()->setCellValue('D' . $i, isset($item->CUS_NAME) ? $item->CUS_NAME:'');
            $spreadsheet->getActiveSheet()->setCellValue('E' . $i, isset($item->EMAIL) ? $item->EMAIL:'' );
            $spreadsheet->getActiveSheet()->setCellValue('F' . $i, isset($item->PHONE) ? $item->PHONE:'');
            $spreadsheet->getActiveSheet()->setCellValue('G' . $i, isset($item->IDCARD) ? $item->IDCARD:'');
            $spreadsheet->getActiveSheet()->setCellValue('H' . $i, isset($item->DOB) ? convertDateDMY($item->DOB):'' );
            $spreadsheet->getActiveSheet()->setCellValue('I' . $i, isset($item->ADDRESS) ? $item->ADDRESS:'');
            $spreadsheet->getActiveSheet()->setCellValue('J' . $i, isset($item->BANK_ACCOUNT_NUM) ? $item->BANK_ACCOUNT_NUM:'');

            $spreadsheet->getActiveSheet()->setCellValue('K' . $i, isset($item->PACK_NAME) ? $item->PACK_NAME:'');
            $spreadsheet->getActiveSheet()->setCellValue('L' . $i, isset($item->GIFT_CODE) ? $item->GIFT_CODE:'');
            $spreadsheet->getActiveSheet()->setCellValue('M' . $i, isset($item->SERY_NO) ? $item->SERY_NO:'');
            $spreadsheet->getActiveSheet()->setCellValue('N' . $i, isset($item->CREATE_DATE) ?  date('d/m/Y H:i', strtotime($item->CREATE_DATE)):'');

            $spreadsheet->getActiveSheet()->setCellValue('O' . $i, isset($item->CERTIFICATE_NO) ? $item->CERTIFICATE_NO:'');//số GCN
            $spreadsheet->getActiveSheet()->setCellValue('P' . $i, isset($item->SERIAL) ? $item->SERIAL:'');//serial
            $spreadsheet->getActiveSheet()->setCellValue('Q' . $i, isset($item->FEES) ? $item->FEES:'');//Phí bảo hiểm (chưa VAT)
            $spreadsheet->getActiveSheet()->setCellValue('R' . $i, isset($item->VAT) ? $item->VAT:'');//VAT của phí bảo hiểm
            $spreadsheet->getActiveSheet()->setCellValue('S' . $i, '');//Phí dịch vụ bổ trợ (chưa VAT)
            $spreadsheet->getActiveSheet()->setCellValue('T' . $i, '');//VAT của phí dịch vụ bổ trợ
            $spreadsheet->getActiveSheet()->setCellValue('U' . $i, isset($item->TOTAL_AMOUNT) ? $item->TOTAL_AMOUNT:'');//Tổng tiền (đã gồm VAT)
            $spreadsheet->getActiveSheet()->setCellValue('V' . $i, isset($item->INSUR_AMOUNT) ? $item->INSUR_AMOUNT:'');//Số tiền bảo hiểm
            $spreadsheet->getActiveSheet()->setCellValue('W' . $i, isset($item->INSUR_TIME) ? $item->INSUR_TIME:'');//Ngày hiệu lực bảo hiểm
            $i++;
        }

        return $this->_saveFileExcel($spreadsheet,$fileName);
    }

    //bình an cá nhân
    public function exportAttdNew($dataInput = [], $dataOther = [])
    {
        $data = isset($dataInput['data'])? $dataInput['data']: [];
        $total_staff = isset($dataInput['total'])? $dataInput['total']: 0;
        $fileName = strtoupper(isset($dataInput['file_name'])? $dataInput['file_name']: 'Danh sách báo cáo ngày '.getCurrentDateDMY());
        if (empty($data))
            return;

        $spreadsheet = new Spreadsheet();

        // Set document properties
        $spreadsheet->getProperties()->setCreator('HDI')
            ->setLastModifiedBy('HDI')
            ->setTitle('Office 2007 XLSX Document')
            ->setSubject('Office 2007 XLSX Document')
            ->setDescription('Export '.$fileName )
            ->setKeywords('office 2007 openxml php');

        $spreadsheet->getActiveSheet()->mergeCells('A1:W2');
        $spreadsheet->getActiveSheet()->setCellValue('A1', $fileName)->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getStyle('A1:W2')->applyFromArray(array(
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

        $spreadsheet->getActiveSheet()->setCellValue('O'.$i, "Số GCN")->getColumnDimension('O')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('P'.$i, "Số serial")->getColumnDimension('P')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('Q'.$i, "Phí bảo hiểm (chưa VAT)")->getColumnDimension('Q')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('R'.$i, "VAT của phí bảo hiểm")->getColumnDimension('R')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('S'.$i, "Phí dịch vụ bổ trợ (chưa VAT)")->getColumnDimension('S')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('T'.$i, "VAT của phí dịch vụ bổ trợ")->getColumnDimension('T')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('U'.$i, "Tổng tiền (đã gồm VAT)")->getColumnDimension('U')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('V'.$i, "Số tiền bảo hiểm")->getColumnDimension('V')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('W'.$i, "Thời hạn bảo hiểm")->getColumnDimension('W')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->getStyle('A'.$i.':W'.$i)->getFill()->setFillType('solid')->getStartColor()->setARGB('47aa5e');

        // style header cell of table
        $spreadsheet->getActiveSheet()->getStyle('A'.$i.':W'.$i)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('4472C4');
        $spreadsheet->getActiveSheet()->getStyle('A'.$i.':W'.$i)->applyFromArray(array(
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
        $spreadsheet->getActiveSheet()->getStyle('A' . $i . ':W' . $col_next)->applyFromArray(array(
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
        foreach ($data as $k => $item) {
            $spreadsheet->getActiveSheet()->setCellValue('A' . $i, $i - 3);// index column
            $spreadsheet->getActiveSheet()->setCellValue('B' . $i, isset($item->ORG_NAME) ? $item->ORG_NAME:'' );
            $spreadsheet->getActiveSheet()->setCellValue('C' . $i, isset($item->CAMPAIGN_NAME) ? $item->CAMPAIGN_NAME:'' );

            $spreadsheet->getActiveSheet()->setCellValue('D' . $i, isset($item->CUS_NAME) ? $item->CUS_NAME:'');
            $spreadsheet->getActiveSheet()->setCellValue('E' . $i, isset($item->EMAIL) ? $item->EMAIL:'' );
            $spreadsheet->getActiveSheet()->setCellValue('F' . $i, isset($item->PHONE) ? $item->PHONE:'');
            $spreadsheet->getActiveSheet()->setCellValue('G' . $i, isset($item->IDCARD) ? $item->IDCARD:'');
            $spreadsheet->getActiveSheet()->setCellValue('H' . $i, isset($item->DOB) ? convertDateDMY($item->DOB):'' );
            $spreadsheet->getActiveSheet()->setCellValue('I' . $i, isset($item->ADDRESS) ? $item->ADDRESS:'');
            $spreadsheet->getActiveSheet()->setCellValue('J' . $i, isset($item->BANK_ACCOUNT_NUM) ? $item->BANK_ACCOUNT_NUM:'');

            $spreadsheet->getActiveSheet()->setCellValue('K' . $i, isset($item->PACK_NAME) ? $item->PACK_NAME:'');
            $spreadsheet->getActiveSheet()->setCellValue('L' . $i, isset($item->GIFT_CODE) ? $item->GIFT_CODE:'');
            $spreadsheet->getActiveSheet()->setCellValue('M' . $i, isset($item->SERY_NO) ? $item->SERY_NO:'');
            $spreadsheet->getActiveSheet()->setCellValue('N' . $i, isset($item->CREATE_DATE) ?  date('d/m/Y H:i', strtotime($item->CREATE_DATE)):'');

            $spreadsheet->getActiveSheet()->setCellValue('O' . $i, isset($item->CERTIFICATE_NO) ? $item->CERTIFICATE_NO:'');//số GCN
            $spreadsheet->getActiveSheet()->setCellValue('P' . $i, isset($item->SERIAL) ? $item->SERIAL:'');//serial
            $spreadsheet->getActiveSheet()->setCellValue('Q' . $i, isset($item->FEES) ? $item->FEES:'');//Phí bảo hiểm (chưa VAT)
            $spreadsheet->getActiveSheet()->setCellValue('R' . $i, isset($item->VAT) ? $item->VAT:'');//VAT của phí bảo hiểm
            $spreadsheet->getActiveSheet()->setCellValue('S' . $i, '');//Phí dịch vụ bổ trợ (chưa VAT)
            $spreadsheet->getActiveSheet()->setCellValue('T' . $i, '');//VAT của phí dịch vụ bổ trợ
            $spreadsheet->getActiveSheet()->setCellValue('U' . $i, isset($item->TOTAL_AMOUNT) ? $item->TOTAL_AMOUNT:'');//Tổng tiền (đã gồm VAT)
            $spreadsheet->getActiveSheet()->setCellValue('V' . $i, isset($item->INSUR_AMOUNT) ? $item->INSUR_AMOUNT:'');//Số tiền bảo hiểm
            $spreadsheet->getActiveSheet()->setCellValue('W' . $i, isset($item->INSUR_TIME) ? $item->INSUR_TIME:'');//Ngày hiệu lực bảo hiểm
            $i++;
        }

        return $this->_saveFileExcel($spreadsheet,$fileName);
    }

    public function exportCustomerHealth($dataInput = [], $dataOther = [])
    {
        $data = isset($dataInput['data'])? $dataInput['data']: [];
        $total_staff = isset($dataInput['total'])? $dataInput['total']: 0;
        $fileName = strtoupper(isset($dataInput['file_name'])? $dataInput['file_name']: 'Danh sách báo cáo ngày '.getCurrentDateDMY());
        if (empty($data))
            return;
        $spreadsheet = new Spreadsheet();
        // Set document properties
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
        foreach ($data as $k => $item) {
            $spreadsheet->getActiveSheet()->setCellValue('A' . $i, $i - 3);// index column
            $spreadsheet->getActiveSheet()->setCellValue('B' . $i, isset($item->ORG_CODE) ? $item->ORG_CODE:'');//đối tác
            $spreadsheet->getActiveSheet()->setCellValue('C' . $i, isset($item->CAMPAIGN_NAME) ? $item->CAMPAIGN_NAME:'' );//chương trình

            $spreadsheet->getActiveSheet()->setCellValue('D' . $i, isset($item->CUS_NAME) ? $item->CUS_NAME:'' );//tên khách hàng
            $spreadsheet->getActiveSheet()->setCellValue('E' . $i, isset($item->STAFF_NAME) ? $item->STAFF_NAME:'');//người mua bảo hiểm
            $spreadsheet->getActiveSheet()->setCellValue('F' . $i, isset($item->RELATIONSHIP) ? $item->RELATIONSHIP:''  );//đối tượng bảo hiểm
            $spreadsheet->getActiveSheet()->setCellValue('G' . $i, isset($item->EMAIL) ? $item->EMAIL:'' );//email
            $spreadsheet->getActiveSheet()->setCellValue('H' . $i, isset($item->PHONE) ? $item->PHONE:'' );//phone
            $spreadsheet->getActiveSheet()->setCellValue('I' . $i, isset($item->STAFF_CODE) ? $item->STAFF_CODE:'');//mã nhân viên

            $spreadsheet->getActiveSheet()->setCellValue('J' . $i, isset($item->IDCARD) ? $item->IDCARD:'' );//CMND
            $spreadsheet->getActiveSheet()->setCellValue('K' . $i, isset($item->DOB) ? convertDateDMY($item->DOB):'' );//ngày sinh
            $spreadsheet->getActiveSheet()->setCellValue('L' . $i, isset($item->ADDRESS) ? $item->ADDRESS:'');//địa chỉ
            $spreadsheet->getActiveSheet()->setCellValue('M' . $i, isset($item->BANK_ACCOUNT_NUM) ? $item->BANK_ACCOUNT_NUM:'');//tài khoản ngân hàng
            $spreadsheet->getActiveSheet()->setCellValue('N' . $i, isset($item->PACK_NAME) ? $item->PACK_NAME:'');//gói
            $spreadsheet->getActiveSheet()->setCellValue('O' . $i, isset($item->GIFT_CODE) ? $item->GIFT_CODE:'' );//mã
            $spreadsheet->getActiveSheet()->setCellValue('P' . $i, isset($item->AMOUNT) ? $item->AMOUNT:'');//số tiền
            $spreadsheet->getActiveSheet()->setCellValue('Q' . $i, isset($item->SERY_NO) ? $item->SERY_NO:'');//số hiệu
            $spreadsheet->getActiveSheet()->setCellValue('R' . $i, isset($item->CREATE_DATE) ? date('d/m/Y H:i', strtotime($item->CREATE_DATE)):'' );//ngày đăng ký
            $i++;
        }

        return $this->_saveFileExcel($spreadsheet,$fileName);
    }

    public function exportVoucherCommon($dataInput = [], $dataOther = [])
    {
        $data = isset($dataInput['data'])? $dataInput['data']: [];
        $total_staff = count($data);
        $fileName = strtoupper(isset($dataInput['file_name'])? $dataInput['file_name']: 'Danh sách báo cáo ngày '.getCurrentDateDMY());
        if (empty($data))
            return;
        $spreadsheet = new Spreadsheet();

        // Set document properties
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
        foreach ($data as $k => $item) {
            $spreadsheet->getActiveSheet()->setCellValue('A' . $i, $i - 3);// index column
            $spreadsheet->getActiveSheet()->setCellValue('B' . $i, isset($item->ORG_NAME) ? $item->ORG_NAME:'');
            $spreadsheet->getActiveSheet()->setCellValue('C' . $i, isset($item->CAMPAIGN_NAME) ? $item->CAMPAIGN_NAME:'');

            $spreadsheet->getActiveSheet()->setCellValue('D' . $i, isset($item->PRODUCT_NAME) ? $item->PRODUCT_NAME:'');
            $spreadsheet->getActiveSheet()->setCellValue('E' . $i, isset($item->PACK_NAME) ? $item->PACK_NAME:'');
            $spreadsheet->getActiveSheet()->setCellValue('F' . $i, isset($item->REF_CODE) ? $item->REF_CODE:'');

            $spreadsheet->getActiveSheet()->setCellValue('G' . $i, isset($item->NUM_OF_ACTIVE) ? $item->NUM_OF_ACTIVE:'');
            $spreadsheet->getActiveSheet()->setCellValue('H' . $i, isset($item->AMOUNT_ALLOCATE) ? $item->AMOUNT_ALLOCATE:'');
            $spreadsheet->getActiveSheet()->setCellValue('I' . $i, isset($item->REVENUE) ? $item->REVENUE:'');

            $i++;
        }
        return $this->_saveFileExcel($spreadsheet,$fileName);
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
                $spreadsheet->getActiveSheet()->setCellValue('B' . $i, isset($staff->EFFECTIVE_DATE) ? convertDateDMY($staff->EFFECTIVE_DATE):'');//ngày hiệu lực
                $spreadsheet->getActiveSheet()->setCellValue('C' . $i, isset($staff->EXPIRATION_DATE) ?convertDateDMY($staff->EXPIRATION_DATE):'');//ngày kết thúc
                $spreadsheet->getActiveSheet()->setCellValue('D' . $i, isset($staff->CONTRACT_NO) ?$staff->CONTRACT_NO:'');//số hợp đồng
                $spreadsheet->getActiveSheet()->setCellValue('E' . $i, isset($staff->PACK_NAME) ?$staff->PACK_NAME:'');//gói BH
                $spreadsheet->getActiveSheet()->setCellValue('F' . $i, isset($staff->FEES) ?$staff->FEES:'');//phí
                $spreadsheet->getActiveSheet()->setCellValue('G' . $i, isset($staff->PAID) ? (($staff->PAID == STATUS_INT_MOT)?'Đã đóng phí': 'Chưa đóng phí') :'');//ngày đóng phí

                $spreadsheet->getActiveSheet()->setCellValue('H' . $i, isset($staff->CUS_NAME) ?$staff->CUS_NAME:'');//tên KH
                $spreadsheet->getActiveSheet()->setCellValue('I' . $i, isset($staff->DOB) ?convertDateDMY($staff->DOB):'');//ngày sinh
                $spreadsheet->getActiveSheet()->setCellValue('J' . $i, isset($staff->IDCARD) ?$staff->IDCARD:'');//số CMND
                $spreadsheet->getActiveSheet()->setCellValue('K' . $i, isset($staff->GENDER) ?(($staff->GENDER == GIOI_TINH_NAM)?'Nam':'Nữ'):'');//giới tính
                $spreadsheet->getActiveSheet()->setCellValue('L' . $i, isset($staff->ADDRESS) ?$staff->ADDRESS:'');//địa chỉ
                $spreadsheet->getActiveSheet()->setCellValue('M' . $i, isset($staff->EMAIL) ?$staff->EMAIL:'');//email
                $spreadsheet->getActiveSheet()->setCellValue('N' . $i, isset($staff->PHONE) ?$staff->PHONE:'');//sdt
                $spreadsheet->getActiveSheet()->setCellValue('O' . $i, '');//ghi chú
                $spreadsheet->getActiveSheet()->setCellValue('P' . $i,isset($staff->LINK_INSMART) ? $staff->LINK_INSMART:'');//link

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
        $fileName = strtoupper(isset($dataInput['file_name'])? $dataInput['file_name']: 'Danh sách báo cáo ngày '.getCurrentDateDMY());
        if (empty($data))
            return;
        $spreadsheet = new Spreadsheet();

        // Set document properties
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
            $spreadsheet->getActiveSheet()->setCellValue('B' . $i, isset($staff->PRODUCT_NAME) ?$staff->PRODUCT_NAME:'');
            $spreadsheet->getActiveSheet()->setCellValue('C' . $i, isset($staff->CONTRACT_NO) ?$staff->CONTRACT_NO:'');

            $spreadsheet->getActiveSheet()->setCellValue('D' . $i, isset($staff->NAME) ?$staff->NAME:'');
            $spreadsheet->getActiveSheet()->setCellValue('E' . $i, isset($staff->REQUIRED_AMOUNT) ?$staff->REQUIRED_AMOUNT:'');
            $spreadsheet->getActiveSheet()->setCellValue('F' . $i, isset($staff->CHANNEL) ?$staff->CHANNEL:'');

            $spreadsheet->getActiveSheet()->setCellValue('G' . $i, isset($staff->CLAIM_DATE) ?$staff->CLAIM_DATE:'');
            $spreadsheet->getActiveSheet()->setCellValue('H' . $i, isset($staff->STAFF_NAME) ?$staff->STAFF_NAME:'');
            $spreadsheet->getActiveSheet()->setCellValue('I' . $i, isset($staff->STATUS_NAME) ?$staff->STATUS_NAME:'');

            $i++;
        }
        return $this->_saveFileExcel($spreadsheet,$fileName);
    }

    public function exportClaimVietJet($dataInput = [], $dataOther = [])
    {
        $data = isset($dataInput['data'])? $dataInput['data']: [];
        $total_staff = count($data);
        $fileName = strtoupper(isset($dataInput['file_name'])? $dataInput['file_name']: 'Danh sách báo cáo ngày '.getCurrentDateDMY());
        if (empty($data))
            return;
        $spreadsheet = new Spreadsheet();

        // Set document properties
        $spreadsheet->getProperties()->setCreator('HDI')
            ->setLastModifiedBy('HDI')
            ->setTitle('Office 2007 XLSX Document')
            ->setSubject('Office 2007 XLSX Document')
            ->setDescription('Export '.$fileName )
            ->setKeywords('office 2007 openxml php');

        $spreadsheet->getActiveSheet()->mergeCells('A1:R2');
        $spreadsheet->getActiveSheet()->setCellValue('A1', $fileName)->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getStyle('A1:R2')->applyFromArray(array(
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
        $spreadsheet->getActiveSheet()->setCellValue('B'.$i, "Số hiệu chuyến bay")->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('C'.$i, "Mã đặt chỗ")->getColumnDimension('C')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setCellValue('D'.$i, "Số ghế")->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('E'.$i, "Tên khách hàng")->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('F'.$i, "CMND/CCCD/Hộ chiếu")->getColumnDimension('F')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setCellValue('G'.$i, "Số điện thoại")->getColumnDimension('G')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('H'.$i, "Email")->getColumnDimension('H')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('I'.$i, "Ngày mua bảo hiểm")->getColumnDimension('I')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setCellValue('J'.$i, "Sản phẩm bảo hiểm")->getColumnDimension('J')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('K'.$i, "Số giấy chứng nhận")->getColumnDimension('K')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('L'.$i, "Ngày yêu cầu bồi thường")->getColumnDimension('L')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setCellValue('M'.$i, "Ngày HDI nhận hồ sơ")->getColumnDimension('M')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('N'.$i, "Ngày HDI bồi thường")->getColumnDimension('N')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('O'.$i, "Số tiền yêu cầu bồi thường")->getColumnDimension('O')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setCellValue('P'.$i, "Số tiền HDI bồi thường")->getColumnDimension('P')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('Q'.$i, "Trạng thái bồi thường")->getColumnDimension('Q')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('R'.$i, "Ghi chú")->getColumnDimension('R')->setAutoSize(true);

        //style content
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
                'horizontal' => 'left',
                'vertical' => 'left'
            )
        ));

        // auto filter
        //$spreadsheet->getActiveSheet()->setAutoFilter('B3' . ':I' . $col_next);
        foreach ($data as $k => $item) {
            $spreadsheet->getActiveSheet()->setCellValue('A' . $i, $i - 3);// index column
            $spreadsheet->getActiveSheet()->setCellValue('B' . $i, isset($item->FLIGHT_NO) ? $item->FLIGHT_NO:'');
            $spreadsheet->getActiveSheet()->setCellValue('C' . $i, isset($item->BOOKING_ID) ? $item->BOOKING_ID:'');

            $spreadsheet->getActiveSheet()->setCellValue('D' . $i, isset($item->SEAT) ? $item->SEAT:'');
            $spreadsheet->getActiveSheet()->setCellValue('E' . $i, isset($item->NAME) ? $item->NAME:'');
            $spreadsheet->getActiveSheet()->setCellValue('F' . $i, isset($item->IDCARD) ? $item->IDCARD:'');

            $spreadsheet->getActiveSheet()->setCellValue('G' . $i, isset($item->PHONE) ? $item->PHONE:'');
            $spreadsheet->getActiveSheet()->setCellValue('H' . $i, isset($item->EMAIL) ? $item->EMAIL:'');
            $spreadsheet->getActiveSheet()->setCellValue('I' . $i, isset($item->EFFECTIVE_DATE) ? $item->EFFECTIVE_DATE:'');//NGÀY MUA

            $spreadsheet->getActiveSheet()->setCellValue('J' . $i, isset($item->PRODUCT_NAME) ? $item->PRODUCT_NAME:'');
            $spreadsheet->getActiveSheet()->setCellValue('K' . $i, isset($item->CERTIFICATE_NO) ? $item->CERTIFICATE_NO:'');
            $spreadsheet->getActiveSheet()->setCellValue('L' . $i, isset($item->CLAIM_DATE) ? $item->CLAIM_DATE:'');
            $spreadsheet->getActiveSheet()->setCellValue('M' . $i, isset($item->PROCESS_DATE) ? $item->PROCESS_DATE:'');//ngày HDI nhận

            $spreadsheet->getActiveSheet()->setCellValue('N' . $i, isset($item->PAY_DATE) ? $item->PAY_DATE:'');
            $spreadsheet->getActiveSheet()->setCellValue('O' . $i, isset($item->REQUIRED_AMOUNT) ? $item->REQUIRED_AMOUNT:'');//số tiền yêu cầu
            $spreadsheet->getActiveSheet()->setCellValue('P' . $i, isset($item->AMOUNT) ? $item->AMOUNT:'');//số tiền bồi thường

            $spreadsheet->getActiveSheet()->setCellValue('Q' . $i, isset($item->TYPE_NAME) ? $item->TYPE_NAME:'');
            $spreadsheet->getActiveSheet()->setCellValue('R' . $i, isset($item->CONTENT) ? $item->CONTENT:'');

            $i++;
        }
        return $this->_saveFileExcel($spreadsheet,$fileName);
    }

    //product Vietjet
    public function exportProductVietjet($dataInput = [], $dataOther = [])
    {
        $data = isset($dataInput['data'])? $dataInput['data']: [];
        $total_staff = count($data);
        $fileName = strtoupper(isset($dataInput['file_name'])? $dataInput['file_name']: 'Danh sách báo cáo ngày '.getCurrentDateDMY());
        if (empty($data))
            return;
        $spreadsheet = new Spreadsheet();

        // Set document properties
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
            $spreadsheet->getActiveSheet()->setCellValue('F' . $i, isset($item->TOTAL_AMOUNT) ? $item->TOTAL_AMOUNT:'');
            $i++;
        }
        return $this->_saveFileExcel($spreadsheet,$fileName);
    }

    //product detail xe cơ giới
    public function exportProductDetailXCG($dataInput = [], $dataOther = [])
    {
        $data = isset($dataInput['data'])? $dataInput['data']: [];
        $total_staff = count($data);
        $fileName = strtoupper(isset($dataInput['file_name'])? $dataInput['file_name']: 'Danh sách báo cáo ngày '.getCurrentDateDMY());
        if (empty($data))
            return;
        $spreadsheet = new Spreadsheet();

        // Set document properties
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
        $spreadsheet->getActiveSheet()->getStyle('A' . $i . ':B' . $col_next)->applyFromArray(array(
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
        $spreadsheet->getActiveSheet()->getStyle('C' . $i . ':H' . $col_next)->applyFromArray(array(
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
                'horizontal' => 'right',
                'vertical' => 'right'
            )
        ));
        // auto filter
        //$spreadsheet->getActiveSheet()->setAutoFilter('B3' . ':I' . $col_next);
        $total_C = $total_D = $total_E = $total_F = $total_G = $total_H = 0;
        foreach ($data as $k => $item) {
            if($item->GROUPING == 1) {
                if (isset($item->DK_NUM_OF_VEH)) {
                    $total_C = (int)($total_C + $item->DK_NUM_OF_VEH);
                }
                if (isset($item->PS_NUM_OF_VEH)) {
                    $total_D = (int)($total_D + $item->PS_NUM_OF_VEH);
                }
                if (isset($item->EOT_NUM_OF_VEH)) {
                    $total_E = (int)($total_E + $item->EOT_NUM_OF_VEH);
                }

                if (isset($item->DK_TOTAL_AMOUNT)) {
                    $total_F = (int)($total_F + $item->DK_TOTAL_AMOUNT);
                }
                if (isset($item->PS_TOTAL_AMOUNT)) {
                    $total_G = (int)($total_G + $item->PS_TOTAL_AMOUNT);
                }
                if (isset($item->EOT_TOTAL_AMOUNT)) {
                    $total_H = (int)($total_H + $item->EOT_TOTAL_AMOUNT);
                }
            }

            $spreadsheet->getActiveSheet()->setCellValue('A' . $i, $i - 3);// index column
            $spreadsheet->getActiveSheet()->setCellValue('B' . $i, isset($item->VH_TYPE) ? $item->VH_TYPE:'');

            $spreadsheet->getActiveSheet()->setCellValue('C' . $i, isset($item->DK_NUM_OF_VEH) ? $item->DK_NUM_OF_VEH:'');
            $spreadsheet->getActiveSheet()->setCellValue('D' . $i, isset($item->PS_NUM_OF_VEH) ? $item->PS_NUM_OF_VEH:'');
            $spreadsheet->getActiveSheet()->setCellValue('E' . $i, isset($item->EOT_NUM_OF_VEH) ? $item->EOT_NUM_OF_VEH:'');

            $spreadsheet->getActiveSheet()->setCellValue('F' . $i, isset($item->DK_TOTAL_AMOUNT) ? $item->DK_TOTAL_AMOUNT:'');
            $spreadsheet->getActiveSheet()->setCellValue('G' . $i, isset($item->PS_TOTAL_AMOUNT) ? $item->PS_TOTAL_AMOUNT:'');
            $spreadsheet->getActiveSheet()->setCellValue('H' . $i, isset($item->EOT_TOTAL_AMOUNT) ? $item->EOT_TOTAL_AMOUNT:'');
            $i++;
        }
        $spreadsheet->getActiveSheet()->getStyle('A' . $i . ':H' . ($col_next+1))->applyFromArray(array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                )
            ),
            'font' => array(
                'size' => 10,
                'bold' => true,
                'name' => 'Calibri',
                'color' => array('rgb' => 'FE2E2E'),
            ),
            'alignment' => array(
                'horizontal' => 'right',
                'vertical' => 'right'
            )
        ));
        //tổng
        $spreadsheet->getActiveSheet()->setCellValue('A' . $i, $i - 3);// index column
        $spreadsheet->getActiveSheet()->setCellValue('B' . $i, 'Tổng');

        $spreadsheet->getActiveSheet()->setCellValue('C' . $i, $total_C);
        $spreadsheet->getActiveSheet()->setCellValue('D' . $i, $total_D);
        $spreadsheet->getActiveSheet()->setCellValue('E' . $i, $total_E);

        $spreadsheet->getActiveSheet()->setCellValue('F' . $i, $total_F);
        $spreadsheet->getActiveSheet()->setCellValue('G' . $i, $total_G);
        $spreadsheet->getActiveSheet()->setCellValue('H' . $i, $total_H);

        return $this->_saveFileExcel($spreadsheet,$fileName);
    }
    //product detail vật chất xe new
    public function exportProductDetailVCX_NEW($dataInput = [], $dataOther = [])
    {
        $data = isset($dataInput['data'])? $dataInput['data']: [];
        $total_staff = count($data);
        $fileName = strtoupper(isset($dataInput['file_name'])? $dataInput['file_name']: 'Danh sách báo cáo ngày '.getCurrentDateDMY());
        if (empty($data))
            return;
        $spreadsheet = new Spreadsheet();

        // Set document properties
        $spreadsheet->getProperties()->setCreator('HDI')
            ->setLastModifiedBy('HDI')
            ->setTitle('Office 2007 XLSX Document')
            ->setSubject('Office 2007 XLSX Document')
            ->setDescription('Export '.$fileName )
            ->setKeywords('office 2007 openxml php');

        $spreadsheet->getActiveSheet()->mergeCells('A1:R2');
        $spreadsheet->getActiveSheet()->setCellValue('A1', $fileName)->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getStyle('A1:R2')->applyFromArray(array(
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
        $spreadsheet->getActiveSheet()->setCellValue('B'.$i, "Số giấy chứng nhận")->getColumnDimension('B')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setCellValue('C'.$i, "Sản phẩm")->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('D'.$i, "Tên khách hàng")->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('E'.$i, "Số điện thoại")->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('F'.$i, "Mail")->getColumnDimension('F')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('G'.$i, "Địa chỉ")->getColumnDimension('G')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setCellValue('H'.$i, "Biển số")->getColumnDimension('H')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('I'.$i, "Số khung")->getColumnDimension('I')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('J'.$i, "Số máy")->getColumnDimension('J')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setCellValue('K'.$i, "Thương hiệu")->getColumnDimension('K')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('L'.$i, "Loại")->getColumnDimension('L')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('M'.$i, "Số ghế")->getColumnDimension('M')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setCellValue('N'.$i, "Ngày hiệu lực")->getColumnDimension('N')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('O'.$i, "Ngày hết hiệu lực")->getColumnDimension('O')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('P'.$i, "Ngày ký")->getColumnDimension('P')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setCellValue('Q'.$i, "Ngày ký")->getColumnDimension('Q')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('R'.$i, "Phí bảo hiểm")->getColumnDimension('R')->setWidth(300);

        //style content
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
                'horizontal' => 'left',
                'vertical' => 'left'
            )
        ));
        foreach ($data as $k => $item) {
            $spreadsheet->getActiveSheet()->setCellValue('A' . $i, $i - 3);// index column
            $spreadsheet->getActiveSheet()->setCellValue('B' . $i, isset($item->CERTIFICATE_NO) ? $item->CERTIFICATE_NO:'');
            $spreadsheet->getActiveSheet()->setCellValue('C' . $i, isset($item->PRODUCT_NAME) ? $item->PRODUCT_NAME:'');

            $spreadsheet->getActiveSheet()->setCellValue('D' . $i, isset($item->NAME) ? $item->NAME:'');
            $spreadsheet->getActiveSheet()->setCellValue('E' . $i, isset($item->PHONE) ? $item->PHONE:'');
            $spreadsheet->getActiveSheet()->setCellValue('F' . $i, isset($item->EMAIL) ? $item->EMAIL:'');
            $spreadsheet->getActiveSheet()->setCellValue('G' . $i, isset($item->FULL_ADDRESS) ? $item->FULL_ADDRESS:'');

            $spreadsheet->getActiveSheet()->setCellValue('H' . $i, isset($item->NUMBER_PLATE) ? $item->NUMBER_PLATE:'');
            $spreadsheet->getActiveSheet()->setCellValue('I' . $i, isset($item->CHASSIS_NO) ? $item->CHASSIS_NO:'');
            $spreadsheet->getActiveSheet()->setCellValue('J' . $i, isset($item->ENGINE_NO) ? $item->ENGINE_NO:'');

            $spreadsheet->getActiveSheet()->setCellValue('K' . $i, isset($item->BRAND) ? $item->BRAND:'');
            $spreadsheet->getActiveSheet()->setCellValue('L' . $i, isset($item->MODEL) ? $item->MODEL:'');
            $spreadsheet->getActiveSheet()->setCellValue('M' . $i, isset($item->SEAT_NO) ? $item->SEAT_NO:'');

            $spreadsheet->getActiveSheet()->setCellValue('N' . $i, isset($item->EFFECTIVE_DATE) ? $item->EFFECTIVE_DATE:'');
            $spreadsheet->getActiveSheet()->setCellValue('O' . $i, isset($item->EXPIRATION_DATE) ? $item->EXPIRATION_DATE:'');
            $spreadsheet->getActiveSheet()->setCellValue('P' . $i, isset($item->DATE_SIGN) ? $item->DATE_SIGN:'');

            $spreadsheet->getActiveSheet()->setCellValue('Q' . $i, isset($item->SELLER_NAME) ? $item->SELLER_NAME:'');
            $spreadsheet->getActiveSheet()->setCellValue('R' . $i, isset($item->TOTAL_AMOUNT) ? $item->TOTAL_AMOUNT:'');
            $i++;
        }

        return $this->_saveFileExcel($spreadsheet,$fileName);
    }

    //product detail bay antoan
    public function exportProductDetailBayAT($dataInput = [], $dataOther = [])
    {
        $data = isset($dataInput['data'])? $dataInput['data']: [];
        $total_staff = count($data);
        $fileName = strtoupper(isset($dataInput['file_name'])? $dataInput['file_name']: 'Danh sách báo cáo ngày '.getCurrentDateDMY());
        if (empty($data))
            return;
        $spreadsheet = new Spreadsheet();

        // Set document properties
        $spreadsheet->getProperties()->setCreator('HDI')
            ->setLastModifiedBy('HDI')
            ->setTitle('Office 2007 XLSX Document')
            ->setSubject('Office 2007 XLSX Document')
            ->setDescription('Export '.$fileName )
            ->setKeywords('office 2007 openxml php');

        $spreadsheet->getActiveSheet()->mergeCells('A1:J2');
        $spreadsheet->getActiveSheet()->setCellValue('A1', $fileName)->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getStyle('A1:J2')->applyFromArray(array(
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
        $spreadsheet->getActiveSheet()->setCellValue('B'.$i, "Tên khách hàng")->getColumnDimension('B')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setCellValue('C'.$i, "Mã đặt chỗ")->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('D'.$i, "Số ghế")->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('E'.$i, "Loại khách hàng")->getColumnDimension('E')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setCellValue('F'.$i, "Loại vé")->getColumnDimension('F')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('G'.$i, "Số hiệu chuyến bay")->getColumnDimension('G')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('H'.$i, "Nơi đi")->getColumnDimension('H')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('I'.$i, "Nơi đến")->getColumnDimension('I')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('J'.$i, "Ngày khởi hành")->getColumnDimension('J')->setAutoSize(true);

        //style content
        $spreadsheet->getActiveSheet()->getStyle('A'.$i.':J'.$i)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('4472C4');
        $spreadsheet->getActiveSheet()->getStyle('A'.$i.':J'.$i)->applyFromArray(array(
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
        $spreadsheet->getActiveSheet()->getStyle('A' . $i . ':J' . $col_next)->applyFromArray(array(
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
        foreach ($data as $k => $item) {
            $spreadsheet->getActiveSheet()->setCellValue('A' . $i, $i - 3);// index column
            $spreadsheet->getActiveSheet()->setCellValue('B' . $i, isset($item->NAME) ? $item->NAME:'');

            $spreadsheet->getActiveSheet()->setCellValue('C' . $i, isset($item->BOOKING_ID) ? $item->BOOKING_ID:'');
            $spreadsheet->getActiveSheet()->setCellValue('D' . $i, isset($item->SEAT) ? $item->SEAT:'');
            $spreadsheet->getActiveSheet()->setCellValue('E' . $i, isset($item->CUS_TYPE) ? $item->CUS_TYPE:'');

            $spreadsheet->getActiveSheet()->setCellValue('F' . $i, isset($item->FARE_CLASS) ? $item->FARE_CLASS:'');
            $spreadsheet->getActiveSheet()->setCellValue('G' . $i, isset($item->FLI_NO) ? $item->FLI_NO:'');
            $spreadsheet->getActiveSheet()->setCellValue('H' . $i, isset($item->DEP) ? $item->DEP:'');

            $spreadsheet->getActiveSheet()->setCellValue('I' . $i, isset($item->ARR) ? $item->ARR:'');
            $spreadsheet->getActiveSheet()->setCellValue('J' . $i, isset($item->FLI_R_DATE) ? $item->FLI_R_DATE:'');
            $i++;
        }

        return $this->_saveFileExcel($spreadsheet,$fileName);
    }

    //product detail bảo hiểm hành lý
    public function exportProductDetailLOST_BAGGAGE($dataInput = [], $dataOther = [])
    {
        $data = isset($dataInput['data'])? $dataInput['data']: [];
        $dataExten = isset($dataInput['dataExten'])? $dataInput['dataExten']: [];
        $total_staff = count($data);
        $fileName = strtoupper(isset($dataInput['file_name'])? $dataInput['file_name']: 'Danh sách báo cáo ngày '.getCurrentDateDMY());
        if (empty($data))
            return;
        $spreadsheet = new Spreadsheet();

        // Set document properties
        $spreadsheet->getProperties()->setCreator('HDI')
            ->setLastModifiedBy('HDI')
            ->setTitle('Office 2007 XLSX Document')
            ->setSubject('Office 2007 XLSX Document')
            ->setDescription('Export '.$fileName )
            ->setKeywords('office 2007 openxml php');

        $spreadsheet->getActiveSheet()->mergeCells('A1:U2');
        $spreadsheet->getActiveSheet()->setCellValue('A1', $fileName)->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getStyle('A1:U2')->applyFromArray(array(
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
        $spreadsheet->getActiveSheet()->setCellValue('B'.$i, "Số giấy chứng nhận")->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('C'.$i, "Tình trạng cấp GCN")->getColumnDimension('C')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setCellValue('D'.$i, "Tên khách hàng")->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('E'.$i, "CMND/CCCD/Hộ chiếu")->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('F'.$i, "Số điện thoại")->getColumnDimension('F')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setCellValue('G'.$i, "Email")->getColumnDimension('G')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('H'.$i, "Số hiệu chuyến bay")->getColumnDimension('H')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('I'.$i, "Mã đặt chỗ")->getColumnDimension('I')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setCellValue('J'.$i, "Số ghế")->getColumnDimension('J')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('K'.$i, "Thời gian cất cánh dự kiến")->getColumnDimension('K')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('L'.$i, "Thời gian hạ cánh dự kiến")->getColumnDimension('L')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setCellValue('M'.$i, "Điểm đi dự kiến")->getColumnDimension('M')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('N'.$i, "Điểm đến dự kiến")->getColumnDimension('N')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('O'.$i, "Ngày mua bảo hiểm")->getColumnDimension('O')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setCellValue('P'.$i, "Sản phẩm bảo hiểm")->getColumnDimension('P')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('Q'.$i, "Mã tag hành lý")->getColumnDimension('Q')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('R'.$i, "Phí bảo hiểm (chưa VAT)")->getColumnDimension('R')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setCellValue('S'.$i, "Thuế GTGT (VAT)")->getColumnDimension('S')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('T'.$i, "Tổng tiền thanh toán")->getColumnDimension('T')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('U'.$i, "Hoa hồng VietJet")->getColumnDimension('U')->setAutoSize(true);

        //style content
        $spreadsheet->getActiveSheet()->getStyle('A'.$i.':U'.$i)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('4472C4');
        $spreadsheet->getActiveSheet()->getStyle('A'.$i.':U'.$i)->applyFromArray(array(
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
        $spreadsheet->getActiveSheet()->getStyle('A' . $i . ':U' . $col_next)->applyFromArray(array(
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
        foreach ($data as $k => $item) {
            $spreadsheet->getActiveSheet()->setCellValue('A' . $i, $i - 3);// index column
            $spreadsheet->getActiveSheet()->setCellValue('B' . $i, isset($item->CERTIFICATE_NO) ? $item->CERTIFICATE_NO:'');
            $spreadsheet->getActiveSheet()->setCellValue('C' . $i, isset($item->CER_STATUS) ? $item->CER_STATUS:'');

            $spreadsheet->getActiveSheet()->setCellValue('D' . $i, isset($item->CUS_NAME) ? $item->CUS_NAME:'');
            $spreadsheet->getActiveSheet()->setCellValue('E' . $i, isset($item->IDCARD) ? $item->IDCARD:'');
            $spreadsheet->getActiveSheet()->setCellValue('F' . $i, isset($item->PHONE) ? $item->PHONE:'');

            $spreadsheet->getActiveSheet()->setCellValue('G' . $i, isset($item->EMAIL) ? $item->EMAIL:'');
            $spreadsheet->getActiveSheet()->setCellValue('H' . $i, isset($item->FLI_NO) ? $item->FLI_NO:'');
            $spreadsheet->getActiveSheet()->setCellValue('I' . $i, isset($item->BOOKING_ID) ? $item->BOOKING_ID:'');

            $spreadsheet->getActiveSheet()->setCellValue('J' . $i, isset($item->SEAT) ? $item->SEAT:'');
            $spreadsheet->getActiveSheet()->setCellValue('K' . $i, isset($item->FLI_DATE) ? $item->FLI_DATE:'');
            $spreadsheet->getActiveSheet()->setCellValue('L' . $i, isset($item->FLI_LAND_DATE) ? $item->FLI_LAND_DATE:'');

            $spreadsheet->getActiveSheet()->setCellValue('M' . $i, isset($item->DEP) ? $item->DEP:'');
            $spreadsheet->getActiveSheet()->setCellValue('N' . $i, isset($item->ARR) ? $item->ARR:'');
            $spreadsheet->getActiveSheet()->setCellValue('O' . $i, isset($item->EFFECTIVE_DATE) ? $item->EFFECTIVE_DATE:'');

            $spreadsheet->getActiveSheet()->setCellValue('P' . $i, isset($item->PACK_NAME) ? $item->PACK_NAME:'');
            $spreadsheet->getActiveSheet()->setCellValue('Q' . $i, isset($item->TAG_CODE_BAG) ? $item->TAG_CODE_BAG:'');
            $spreadsheet->getActiveSheet()->setCellValue('R' . $i, isset($item->AMOUNT) ? $item->AMOUNT:'');

            $spreadsheet->getActiveSheet()->setCellValue('S' . $i, isset($item->VAT) ? $item->VAT:'');
            $spreadsheet->getActiveSheet()->setCellValue('T' . $i, isset($item->TOTAL_AMOUNT) ? $item->TOTAL_AMOUNT:'');
            $spreadsheet->getActiveSheet()->setCellValue('U' . $i, isset($item->COMMISSION) ? $item->COMMISSION:'');
            $i++;
        }

        /*//tổng tiền
        $spreadsheet->getActiveSheet()->getStyle('A' . $i . ':U' . ($col_next+1))->applyFromArray(array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                )
            ),
            'font' => array(
                'size' => 10,
                'bold' => true,
                'name' => 'Calibri',
                'color' => array('rgb' => 'FE2E2E'),
            ),
            'alignment' => array(
                'horizontal' => 'left',
                'vertical' => 'left'
            )
        ));
        $spreadsheet->getActiveSheet()->mergeCells('A' . $i . ':T' . ($col_next+1));
        $spreadsheet->getActiveSheet()->setCellValue('A'.$i, 'Tổng tiền')->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('U' . $i,isset($dataExten->TOTAL_AMOUNT)?$dataExten->TOTAL_AMOUNT:'');*/

        return $this->_saveFileExcel($spreadsheet,$fileName);
    }

    //kế toán: bảo hiểm hành lý
    public function exportAccountantLOST_BAGGAGE($dataInput = [], $dataOther = [])
    {
        $data = isset($dataInput['data'])? $dataInput['data']: [];
        $total_staff = count($data);
        $fileName = strtoupper(isset($dataInput['file_name'])? $dataInput['file_name']: 'Danh sách báo cáo ngày '.getCurrentDateDMY());
        if (empty($data))
            return;
        $spreadsheet = new Spreadsheet();

        // Set document properties
        $spreadsheet->getProperties()->setCreator('HDI')
            ->setLastModifiedBy('HDI')
            ->setTitle('Office 2007 XLSX Document')
            ->setSubject('Office 2007 XLSX Document')
            ->setDescription('Export '.$fileName )
            ->setKeywords('office 2007 openxml php');

        $spreadsheet->getActiveSheet()->mergeCells('A1:U2');
        $spreadsheet->getActiveSheet()->setCellValue('A1', $fileName)->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getStyle('A1:U2')->applyFromArray(array(
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
        $spreadsheet->getActiveSheet()->setCellValue('B'.$i, "Số hợp đồng")->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('C'.$i, "Tên hợp đồng")->getColumnDimension('C')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setCellValue('D'.$i, "Ngày bắt đầu hiệu lực")->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('E'.$i, "Ngày kết thúc hiệu lực")->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('F'.$i, "Tên khách hàng")->getColumnDimension('F')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setCellValue('G'.$i, "Tên khác")->getColumnDimension('G')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('H'.$i, "Email")->getColumnDimension('H')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('I'.$i, "Địa chỉ khách hàng")->getColumnDimension('I')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setCellValue('J'.$i, "Mã số thuế khách hàng")->getColumnDimension('J')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('K'.$i, "Diễn giải")->getColumnDimension('K')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('L'.$i, "Mã ngoại tệ")->getColumnDimension('L')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setCellValue('M'.$i, "Tiền ngoại tệ")->getColumnDimension('M')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('N'.$i, "Phí (-VAT)")->getColumnDimension('N')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('O'.$i, "VAT")->getColumnDimension('O')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setCellValue('P'.$i, "Phí (có VAT)")->getColumnDimension('P')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('Q'.$i, "Nghiệp vụ")->getColumnDimension('Q')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('R'.$i, "Sản phẩm bảo hiểm")->getColumnDimension('R')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setCellValue('S'.$i, "Gói bảo hiểm")->getColumnDimension('S')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('T'.$i, "Bộ phận cấp đơn")->getColumnDimension('T')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('U'.$i, "Nhân viên")->getColumnDimension('U')->setAutoSize(true);

        //style content
        $spreadsheet->getActiveSheet()->getStyle('A'.$i.':U'.$i)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('4472C4');
        $spreadsheet->getActiveSheet()->getStyle('A'.$i.':U'.$i)->applyFromArray(array(
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
        $spreadsheet->getActiveSheet()->getStyle('A' . $i . ':U' . $col_next)->applyFromArray(array(
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
        foreach ($data as $k => $item) {
            $spreadsheet->getActiveSheet()->setCellValue('A' . $i, $i - 3);// index column
            $spreadsheet->getActiveSheet()->setCellValue('B' . $i, isset($item->CERTIFICATE_NO) ? $item->CERTIFICATE_NO:'');
            $spreadsheet->getActiveSheet()->setCellValue('C' . $i, isset($item->CONTRACT_NAME) ? $item->CONTRACT_NAME:'');

            $spreadsheet->getActiveSheet()->setCellValue('D' . $i, isset($item->FLI_DATE) ? $item->FLI_DATE:'');
            $spreadsheet->getActiveSheet()->setCellValue('E' . $i, isset($item->FLI_LAND_DATE) ? $item->FLI_LAND_DATE:'');
            $spreadsheet->getActiveSheet()->setCellValue('F' . $i, isset($item->CUS_NAME) ? $item->CUS_NAME:'');

            $spreadsheet->getActiveSheet()->setCellValue('G' . $i, isset($item->CUS_OTHER_NAME) ? $item->CUS_OTHER_NAME:'');
            $spreadsheet->getActiveSheet()->setCellValue('H' . $i, isset($item->EMAIL) ? $item->EMAIL:'');
            $spreadsheet->getActiveSheet()->setCellValue('I' . $i, isset($item->ADDRESS) ? $item->ADDRESS:'');

            $spreadsheet->getActiveSheet()->setCellValue('J' . $i, isset($item->TAXCODE) ? $item->TAXCODE:'');
            $spreadsheet->getActiveSheet()->setCellValue('K' . $i, isset($item->DESCIRPTION) ? $item->DESCIRPTION:'');
            $spreadsheet->getActiveSheet()->setCellValue('L' . $i, isset($item->CURRENCY_CODE) ? $item->CURRENCY_CODE:'');

            $spreadsheet->getActiveSheet()->setCellValue('M' . $i, isset($item->CURRENCY_NAME) ? $item->CURRENCY_NAME:'');
            $spreadsheet->getActiveSheet()->setCellValue('N' . $i, isset($item->AMOUNT) ? $item->AMOUNT:'');
            $spreadsheet->getActiveSheet()->setCellValue('O' . $i, isset($item->VAT) ? $item->VAT:'');

            $spreadsheet->getActiveSheet()->setCellValue('P' . $i, isset($item->TOTAL_AMOUNT) ? $item->TOTAL_AMOUNT:'');
            $spreadsheet->getActiveSheet()->setCellValue('Q' . $i, isset($item->CATEGORY) ? $item->CATEGORY:'');
            $spreadsheet->getActiveSheet()->setCellValue('R' . $i, isset($item->PRODUCT_NAME) ? $item->PRODUCT_NAME:'');

            $spreadsheet->getActiveSheet()->setCellValue('S' . $i, isset($item->PACK_NAME) ? $item->PACK_NAME:'');
            $spreadsheet->getActiveSheet()->setCellValue('T' . $i, isset($item->DEPARTMENT) ? $item->DEPARTMENT:'');
            $spreadsheet->getActiveSheet()->setCellValue('U' . $i, isset($item->EMPLOYEE_NAME) ? $item->EMPLOYEE_NAME:'');
            $i++;
        }

        return $this->_saveFileExcel($spreadsheet,$fileName);
    }

    //Cấp đơn theo lô
    public function exportOrdersInBatches($dataInput = [], $dataOther = [])
    {
        $data = isset($dataInput['data'])? $dataInput['data']: [];
        $total_staff = count($data);
        $fileName = strtoupper(isset($dataInput['file_name'])? $dataInput['file_name']: 'Danh sách báo cáo ngày '.getCurrentDateDMY());
        if (empty($data))
            return;
        $spreadsheet = new Spreadsheet();

        // Set document properties
        $spreadsheet->getProperties()->setCreator('HDI')
            ->setLastModifiedBy('HDI')
            ->setTitle('Office 2007 XLSX Document')
            ->setSubject('Office 2007 XLSX Document')
            ->setDescription('Export '.$fileName )
            ->setKeywords('office 2007 openxml php');

        $spreadsheet->getActiveSheet()->mergeCells('A1:N2');
        $spreadsheet->getActiveSheet()->setCellValue('A1', $fileName)->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getStyle('A1:N2')->applyFromArray(array(
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
        $spreadsheet->getActiveSheet()->setCellValue('B'.$i, "Số PLHĐ")->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('C'.$i, "Số GCN")->getColumnDimension('C')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setCellValue('D'.$i, "Họ tên khách hàng")->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('E'.$i, "Ngày sinh")->getColumnDimension('E')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setCellValue('F'.$i, "Mã sản phẩm")->getColumnDimension('F')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('G'.$i, "Tên sản phẩm")->getColumnDimension('G')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setCellValue('H'.$i, "Mã gói")->getColumnDimension('H')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('I'.$i, "Tên gói")->getColumnDimension('I')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setCellValue('J'.$i, "Ngày hiệu lực")->getColumnDimension('J')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('K'.$i, "Số tiền")->getColumnDimension('K')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('L'.$i, "Vat")->getColumnDimension('L')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('M'.$i, "Tổng tiền")->getColumnDimension('M')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('N'.$i, "Tên chương trình")->getColumnDimension('N')->setAutoSize(true);

        //style content
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
                'horizontal' => 'left',
                'vertical' => 'left'
            )
        ));
        foreach ($data as $k => $item) {
            $spreadsheet->getActiveSheet()->setCellValue('A' . $i, $i - 3);// index column
            $spreadsheet->getActiveSheet()->setCellValue('B' . $i, isset($item->CONTRACT_NO) ? $item->CONTRACT_NO:'');
            $spreadsheet->getActiveSheet()->setCellValue('C' . $i, isset($item->CERTIFICATE_NO) ? $item->CERTIFICATE_NO:'');

            $spreadsheet->getActiveSheet()->setCellValue('D' . $i, isset($item->NAME) ? $item->NAME:'');
            $spreadsheet->getActiveSheet()->setCellValue('E' . $i, isset($item->DOB) ? $item->DOB:'');

            $spreadsheet->getActiveSheet()->setCellValue('F' . $i, isset($item->PRODUCT_CODE) ? $item->PRODUCT_CODE:'');
            $spreadsheet->getActiveSheet()->setCellValue('G' . $i, isset($item->PRODUCT_NAME) ? $item->PRODUCT_NAME:'');
            $spreadsheet->getActiveSheet()->setCellValue('H' . $i, isset($item->PACK_CODE) ? $item->PACK_CODE:'');
            $spreadsheet->getActiveSheet()->setCellValue('I' . $i, isset($item->PACK_NAME) ? $item->PACK_NAME:'');

            $spreadsheet->getActiveSheet()->setCellValue('J' . $i, isset($item->INSUR_TIME) ? $item->INSUR_TIME:'');
            $spreadsheet->getActiveSheet()->setCellValue('K' . $i, isset($item->AMOUNT) ? $item->AMOUNT:'');
            $spreadsheet->getActiveSheet()->setCellValue('L' . $i, isset($item->VAT) ? $item->VAT:'');

            $spreadsheet->getActiveSheet()->setCellValue('M' . $i, isset($item->TOTAL_AMOUNT) ? $item->TOTAL_AMOUNT:'');
            $spreadsheet->getActiveSheet()->setCellValue('N' . $i, isset($item->PROG_NAME) ? $item->PROG_NAME:'');
            $i++;
        }

        return $this->_saveFileExcel($spreadsheet,$fileName);
    }
    public function exportOrdersInBatchesDetail($dataInput = [], $dataOther = [])
    {
        $data = isset($dataInput['data'])? $dataInput['data']: [];
        $total_staff = count($data);
        $fileName = isset($dataInput['file_name'])? $dataInput['file_name']: 'Danh sách báo cáo ngày '.getCurrentDateDMY();
        if (empty($data))
            return;
        $spreadsheet = new Spreadsheet();

        // Set document properties
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
        // style header cell of table
        $spreadsheet->getActiveSheet()->setCellValue('A'.$i, "#")->getColumnDimension('A')->setWidth(5);
        $spreadsheet->getActiveSheet()->setCellValue('B'.$i, "Số PLHĐ")->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('C'.$i, "Số GCN")->getColumnDimension('C')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setCellValue('D'.$i, "Họ tên khách hàng")->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('E'.$i, "Ngày sinh")->getColumnDimension('E')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setCellValue('F'.$i, "Mã sản phẩm")->getColumnDimension('F')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('G'.$i, "Tên sản phẩm")->getColumnDimension('G')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setCellValue('H'.$i, "Mã gói")->getColumnDimension('H')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('I'.$i, "Tên gói")->getColumnDimension('I')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setCellValue('J'.$i, "Ngày hiệu lực")->getColumnDimension('J')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('K'.$i, "Số tiền")->getColumnDimension('K')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('L'.$i, "Vat")->getColumnDimension('L')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setCellValue('M'.$i, "Tổng tiền")->getColumnDimension('M')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('N'.$i, "Tên chương trình")->getColumnDimension('N')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('O'.$i, "Serial")->getColumnDimension('O')->setAutoSize(true);

        //style content
        $spreadsheet->getActiveSheet()->getStyle('A'.$i.':O'.$i)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('4472C4');
        $spreadsheet->getActiveSheet()->getStyle('A'.$i.':O'.$i)->applyFromArray(array(
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
        $spreadsheet->getActiveSheet()->getStyle('A' . $i . ':O' . $col_next)->applyFromArray(array(
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
        foreach ($data as $k => $item) {
            $spreadsheet->getActiveSheet()->setCellValue('A' . $i, $i - 3);// index column
            $spreadsheet->getActiveSheet()->setCellValue('B' . $i, isset($item->CONTRACT_NO) ? $item->CONTRACT_NO:'');
            $spreadsheet->getActiveSheet()->setCellValue('C' . $i, isset($item->CERTIFICATE_NO) ? $item->CERTIFICATE_NO:'');

            $spreadsheet->getActiveSheet()->setCellValue('D' . $i, isset($item->NAME) ? $item->NAME:'');
            $spreadsheet->getActiveSheet()->setCellValue('E' . $i, isset($item->DOB) ? $item->DOB:'');

            $spreadsheet->getActiveSheet()->setCellValue('F' . $i, isset($item->PRODUCT_CODE) ? $item->PRODUCT_CODE:'');
            $spreadsheet->getActiveSheet()->setCellValue('G' . $i, isset($item->PRODUCT_NAME) ? $item->PRODUCT_NAME:'');
            $spreadsheet->getActiveSheet()->setCellValue('H' . $i, isset($item->PACK_CODE) ? $item->PACK_CODE:'');
            $spreadsheet->getActiveSheet()->setCellValue('I' . $i, isset($item->PACK_NAME) ? $item->PACK_NAME:'');

            $spreadsheet->getActiveSheet()->setCellValue('J' . $i, isset($item->INSUR_TIME) ? $item->INSUR_TIME:'');
            $spreadsheet->getActiveSheet()->setCellValue('K' . $i, isset($item->AMOUNT) ? $item->AMOUNT:'');
            $spreadsheet->getActiveSheet()->setCellValue('L' . $i, isset($item->VAT) ? $item->VAT:'');

            $spreadsheet->getActiveSheet()->setCellValue('M' . $i, isset($item->TOTAL_AMOUNT) ? $item->TOTAL_AMOUNT:'');
            $spreadsheet->getActiveSheet()->setCellValue('N' . $i, isset($item->PROG_NAME) ? $item->PROG_NAME:'');
            $spreadsheet->getActiveSheet()->setCellValue('O' . $i, isset($item->SERIAL) ? $item->SERIAL:'');
            $i++;
        }
        return $this->_saveFileExcel($spreadsheet,$fileName);

    }
    //đối soát
    public function exportReconciliationBayAT($dataInput = [], $dataOther = [])
    {
        $data = isset($dataInput['data'])? $dataInput['data']: [];
        $dataTotal = isset($dataInput['dataTotal'])? $dataInput['dataTotal']: [];
        $total_staff = count($data);
        $fileName = strtoupper(isset($dataInput['file_name'])? $dataInput['file_name']: 'Danh sách báo cáo ngày '.getCurrentDateDMY());
        if (empty($data))
            return;
        $spreadsheet = new Spreadsheet();

        // Set document properties
        $spreadsheet->getProperties()->setCreator('HDI')
            ->setLastModifiedBy('HDI')
            ->setTitle('Office 2007 XLSX Document')
            ->setSubject('Office 2007 XLSX Document')
            ->setDescription('Export '.$fileName )
            ->setKeywords('office 2007 openxml php');

        $spreadsheet->getActiveSheet()->mergeCells('A1:J2');
        $spreadsheet->getActiveSheet()->setCellValue('A1', $fileName)->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getStyle('A1:J2')->applyFromArray(array(
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
        $spreadsheet->getActiveSheet()->setCellValue('B'.$i, "Ngày khởi hành")->getColumnDimension('B')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setCellValue('C'.$i, "Số hiệu chuyến bay")->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('D'.$i, "Số lượng hành khách")->getColumnDimension('D')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setCellValue('E'.$i, "Em bé đi kèm")->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('F'.$i, "Số khách loại vé C")->getColumnDimension('F')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('G'.$i, "Tổng doanh thu")->getColumnDimension('G')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setCellValue('H'.$i, "Phí quyền lợi A")->getColumnDimension('H')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('I'.$i, "Phí quyền lợi B, không VAT")->getColumnDimension('I')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('J'.$i, "Thuế quyền lợi B")->getColumnDimension('J')->setAutoSize(true);

        //style content
        $spreadsheet->getActiveSheet()->getStyle('A'.$i.':J'.$i)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('4472C4');
        $spreadsheet->getActiveSheet()->getStyle('A'.$i.':J'.$i)->applyFromArray(array(
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
        $spreadsheet->getActiveSheet()->getStyle('A' . $i . ':J' . $col_next)->applyFromArray(array(
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
                'horizontal' => 'right',
                'vertical' => 'right'
            )
        ));

        foreach ($data as $k => $item) {

            $spreadsheet->getActiveSheet()->setCellValue('A' . $i, $i - 3);// index column
            $spreadsheet->getActiveSheet()->setCellValue('B' . $i, isset($item->FLI_R_DATE) ? $item->FLI_R_DATE:'');

            $spreadsheet->getActiveSheet()->setCellValue('C' . $i, isset($item->FLI_NO) ? $item->FLI_NO:'');
            $spreadsheet->getActiveSheet()->setCellValue('D' . $i, isset($item->NUM_OF_CUS) ? $item->NUM_OF_CUS:'');

            $spreadsheet->getActiveSheet()->setCellValue('E' . $i, isset($item->NUM_OF_INFANT) ? $item->NUM_OF_INFANT:'');
            $spreadsheet->getActiveSheet()->setCellValue('F' . $i, isset($item->NUM_CLASS_C) ? $item->NUM_CLASS_C:'');
            $spreadsheet->getActiveSheet()->setCellValue('G' . $i, isset($item->TOTAL_AMOUNT) ? $item->TOTAL_AMOUNT:'');

            $spreadsheet->getActiveSheet()->setCellValue('H' . $i, isset($item->FEES_BENEFIT_A) ? $item->FEES_BENEFIT_A:'');
            $spreadsheet->getActiveSheet()->setCellValue('I' . $i, isset($item->FEES_BENEFIT_B) ? $item->FEES_BENEFIT_B:'');
            $spreadsheet->getActiveSheet()->setCellValue('J' . $i, isset($item->VAT_BENEFIT_B) ? $item->VAT_BENEFIT_B:'');
            $i++;
        }

        //tổng tiền
        /*$spreadsheet->getActiveSheet()->getStyle('A' . $i . ':G' . ($col_next+1))->applyFromArray(array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                )
            ),
            'font' => array(
                'size' => 10,
                'bold' => true,
                'name' => 'Calibri',
                'color' => array('rgb' => 'FE2E2E'),
            ),
            'alignment' => array(
                'horizontal' => 'right',
                'vertical' => 'right'
            )
        ));
        $spreadsheet->getActiveSheet()->mergeCells('A' . $i . ':C' . ($col_next+1));
        $spreadsheet->getActiveSheet()->setCellValue('A'.$i, 'Tổng tiền')->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('D' . $i, isset($dataTotal->NUM_OF_CUS) ? $dataTotal->NUM_OF_CUS:'');
        $spreadsheet->getActiveSheet()->setCellValue('E' . $i, isset($dataTotal->NUM_OF_INFANT) ? $dataTotal->NUM_OF_INFANT:'');
        $spreadsheet->getActiveSheet()->setCellValue('F' . $i, isset($dataTotal->NUM_CLASS_C) ? $dataTotal->NUM_CLASS_C:'');
        $spreadsheet->getActiveSheet()->setCellValue('G' . $i, isset($dataTotal->TOTAL_AMOUNT) ? $dataTotal->TOTAL_AMOUNT:'');*/

        return $this->_saveFileExcel($spreadsheet,$fileName);
    }

    private function _saveFileExcel($spreadsheet,$fileName){
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
        $data = isset($dataInput['data'])? $dataInput['data']: [];
        $dataTotal = isset($dataInput['dataTotal'])? $dataInput['dataTotal']: [];
        $total_staff = count($data);
        $fileName = strtoupper(isset($dataInput['file_name'])? $dataInput['file_name']: 'Danh sách báo cáo ngày '.getCurrentDateDMY());
        if (empty($data))
            return;
        $spreadsheet = new Spreadsheet();

        // Set document properties
        $spreadsheet->getProperties()->setCreator('HDI')
            ->setLastModifiedBy('HDI')
            ->setTitle('Office 2007 XLSX Document')
            ->setSubject('Office 2007 XLSX Document')
            ->setDescription('Export '.$fileName )
            ->setKeywords('office 2007 openxml php');

        $spreadsheet->getActiveSheet()->mergeCells('A1:G2');
        $spreadsheet->getActiveSheet()->setCellValue('A1', $fileName)->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getStyle('A1:G2')->applyFromArray(array(
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
        $spreadsheet->getActiveSheet()->setCellValue('B'.$i, "Ngày khởi hành")->getColumnDimension('B')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setCellValue('C'.$i, "Số hiệu chuyến bay")->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('D'.$i, "Số lượng hành khách")->getColumnDimension('D')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setCellValue('E'.$i, "Em bé đi kèm")->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setCellValue('F'.$i, "Số khách loại vé C")->getColumnDimension('F')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setCellValue('G'.$i, "Tổng doanh thu")->getColumnDimension('G')->setAutoSize(true);

        //style content
        $spreadsheet->getActiveSheet()->getStyle('A'.$i.':G'.$i)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('4472C4');
        $spreadsheet->getActiveSheet()->getStyle('A'.$i.':G'.$i)->applyFromArray(array(
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
        $spreadsheet->getActiveSheet()->getStyle('A' . $i . ':G' . $col_next)->applyFromArray(array(
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
                'horizontal' => 'right',
                'vertical' => 'right'
            )
        ));

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
}