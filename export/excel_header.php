<?php
class HeadMake
{
    public function head($queryIdExcel)
    {
        switch ($queryIdExcel) {
            case "EXCEL_CUSTOMERSALE":
                return ['วันที่', 'เลขที่เสนอราคา', 'Rev.', 'รหัสลูกค้า', 'ชื่อเรียก', 'ชื่อลูกค้า', 'ผู้ติดต่อ', 'รายละเอียดสินค้า', 'ชื่อพนักงานขาย', 'เครดิต', 'หมายเหตุ', 'จำนวน', 'หน่วยละ', 'ราคารวม'];
                break;

            case "EXCEL_QOUT_ORDERHD":
                return ['วันที่', 'เลขที่สั่งซื้อ', 'เลขที่ใบสั่งซื้อ', 'รหัสลูกค้า', 'ชื่อเรียก', 'ชื่อลูกค้า', 'ผู้ติดต่อ', 'ชื่อพนักงานขาย', 'รายละเอียดสินค้า', 'จำนวน', 'หน่วยละ', 'ราคารวม'];
                break;

            case "EXCEL_QOUT_INVOICE":
                return ['วันที่', 'เลขที่ใบแจ้งหนี้', 'เลขที่ใบสั่งซื้อ', 'รหัสลูกค้า', 'ชื่อเรียก', 'ชื่อลูกค้า', 'ผู้ติดต่อ', 'ชื่อพนักงานขาย', 'รายละเอียดสินค้า', 'จำนวนแจ้ง', 'จำนวนส่ง', 'หน่วยละ', 'ราคารวม'];
                break;

            case "EXCEL_QOUT_DELYHD":
                return ['วันที่', 'เลขที่ใบส่งสินค้า', 'เลขที่ใบสั่งซื้อ', 'รหัสลูกค้า', 'ชื่อเรียก', 'ชื่อลูกค้า', 'รายละเอียดสินค้า', 'จำนวน', 'หน่วยละ', 'ราคารวม'];
                break;
            case "EXCEL_QOUT_INVOICE_SUMMARY":
                return ['วันที่ที่ระบุในเอกสาร', 'วันที่ครบกำหนด', 'เลขที่ใบแจ้งหนี้', 'ใบสั่งซื้อ', 'รายการ', 'จำนวน', 'หน่วยละ', 'ผลรวมเงิน', 'สกุลเงิน', 'อัตราแลกเปลี่ยน', 'ผลรวมเงินสุทธิ์บาท'];
                break;
            case "PO_REPORT":
                return ['รหัสผู้จำหน่าย', 'ชื่อผู้จำหน่าย', 'ใบแจ้งหนี้', 'ใบเลขที่ใบส่งสินค้าผู้ขาย', 'วันที่', 'รหัส', 'หน่วย', 'จำนวนแจ้งหนี้', 'จำนวนรับเข้า', 'หน่วยละ', 'ผลรวม', 'ใบสั่งซื้อ', 'รายละเอียด', 'จำนวน', 'หน่วยละ', 'หน่วย', 'ผลรวม', 'ผลรวมหน่วยต่าง'];
                break;
            case "SELECT_POQC":
                return ['เลขที่ใบสั่งซื้อ', 'สถานะ', 'จำนวนทั้งหมด', 'Q\'ty NG', 'คะแนนคุณภาพ', 'ประเภทสั่งซื้อ', 'งวดเดือน'];
                break;
            case "EXCEL_SUMMARY_PO_RANK":
                return ['รหัส', 'ชื่อผู้จำหน่าย', 'ราคารวม', 'จำนวนใบแจ้งหนี้'];
                break;
            case "EXCEL_TEST":
                return ['ลำดับ', 'ราคารวม'];
                break;
            case "EXCEL_PRUDUCT_DISCON":
                return ['เลขที่ใบสั่งผลิต', 'วันที่สั่งผลิต', 'กำหนดเสร็จ', 'วันที่ผ่านมา', 'ลูกค้า', 'สินค้าผลิต', 'ยอดสั่งผลิต', 'ราคารวม'];
                break;
            default:
                return ['ไม่มีข้อมูลเลยนะ'];
        }
    }
}