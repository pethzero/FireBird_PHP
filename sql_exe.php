<?php 


$sqlsreach = array();

// $sqlsreach['0001'] = "SELECT QUOTHD.RECNO,QUOTHD.LASTUPD,QUOTHD.STATUS,QUOTHD.CORP,QUOTHD.QUOTTYPE,QUOTHD.QUOTTITLE,QUOTHD.DOCDATE QDOCDATE,QUOTHD.DOCNO QDOCNO,QUOTHD.REVISE,QUOTHD.DELYDATE,QUOTHD.VALIDUNTIL,QUOTHD.DELYPLACE,QUOTHD.CREDIT,QUOTHD.TOTALAMT,QUOTHD.VATUSE,QUOTHD.NETAMT,QUOTHD.REMARK,QUOTHD.IMAGENO,CUST.CODE,CUST.NAME,CUST.TEL,CUST.CELL,CUST.FAX,CUST.EMAIL,CUSTCONT.CONTNAME,CUSTCONT.JOBPOS,CUSTCONT.CONTTEL,CUSTCONT.CONTCELL,CUSTCONT.CONTFAX,CUSTCONT.CONTEMAIL,EMPL1.EMPNAME EMPNAMESALES,EMPL2.EMPNAME EMPNAMEMAKER,EMPL3.EMPNAME EMPNAMEAPPROVER FROM QUOTHD LEFT JOIN CUST ON (QUOTHD.CUST = CUST.RECNO) LEFT JOIN EMPL EMPL1 ON (QUOTHD.SALES = EMPL1.RECNO)  LEFT JOIN EMPL EMPL2 ON (QUOTHD.MAKER = EMPL2.RECNO) LEFT JOIN EMPL EMPL3 ON (QUOTHD.APPROVER = EMPL3.RECNO) LEFT JOIN CUSTCONT ON (QUOTHD.CONT = CUSTCONT.RECNO) WHERE (QUOTHD.CORP = 1) AND (QUOTHD.STATUS <> 'D')  ORDER BY QUOTHD.DOCNO DESC, QUOTHD.REVISE DESC";
$sqlsreach['0001'] = "SELECT QUOTHD.RECNO,QUOTHD.LASTUPD,QUOTHD.STATUS,QUOTHD.QUOTTYPE,QUOTHD.DOCDATE QDOCDATE,QUOTHD.DOCNO QDOCNO,QUOTHD.REVISE,QUOTHD.DELYDATE,QUOTHD.VALIDUNTIL,QUOTHD.DELYPLACE,QUOTHD.CREDIT,QUOTHD.TOTALAMT,QUOTHD.VATUSE,QUOTHD.NETAMT,QUOTHD.REMARK,CUST.CODE,CUST.NAME,CUST.TEL,CUST.CELL,CUST.FAX,CUST.EMAIL,CUSTCONT.CONTNAME,CUSTCONT.JOBPOS,CUSTCONT.CONTTEL,CUSTCONT.CONTCELL,CUSTCONT.CONTFAX,CUSTCONT.CONTEMAIL,EMPL1.EMPNAME EMPNAMESALES,EMPL2.EMPNAME EMPNAMEMAKER,EMPL3.EMPNAME EMPNAMEAPPROVER FROM QUOTHD LEFT JOIN CUST ON (QUOTHD.CUST = CUST.RECNO) LEFT JOIN EMPL EMPL1 ON (QUOTHD.SALES = EMPL1.RECNO)  LEFT JOIN EMPL EMPL2 ON (QUOTHD.MAKER = EMPL2.RECNO) LEFT JOIN EMPL EMPL3 ON (QUOTHD.APPROVER = EMPL3.RECNO) LEFT JOIN CUSTCONT ON (QUOTHD.CONT = CUSTCONT.RECNO) ORDER BY QUOTHD.DOCNO DESC, QUOTHD.REVISE DESC";
$sqlsreach['0002'] = "SELECT * FROM QUOTHD WHERE QUOTHD.STATUS = ':STATUS' ";
$sqlsreach['UD_QUOTHD'] = "UPDATE QUOTHD SET LASTUPD='NOW',SALES=:SALES,MAKER=:MAKER,APPROVER=:APPROVER WHERE RECNO=:RECNO";

// PURCHD
$sqlsreach['PURCHD_LIST'] = "SELECT PURCHD.RECNO, PURCHD.LASTUPD, PURCHD.STATUS, PURCHD.DOCDATE, PURCHD.DOCNO, PURCHD.DELYDATE, PURCHD.DELYDAYS, PURCHD.DELYPLACE, PURCHD.NETAMT, PURCHD.REMARK, SUPP.CODE, SUPP.NAME, SUPP.ADDR, SUPP.TEL, SUPP.CELL, SUPP.FAX, SUPP.EMAIL, SUPPCONT.CONTNAME, SUPPCONT.JOBPOS, SUPPCONT.CONTTEL, SUPPCONT.CONTCELL, SUPPCONT.CONTFAX, SUPPCONT.CONTEMAIL, MAKER.EMPNAME EMPNAMEMAKER, BUYER.EMPNAME EMPNAMEBUYER, APPROVER.EMPNAME EMPNAMEAPPROVER, PRHD.DOCNO PRHD_DOCNO, PRJOBHD.DOCNO PRJOBHD_DOCNO FROM PURCHD LEFT JOIN PRHD ON (PURCHD.PRHD = PRHD.RECNO) LEFT JOIN PRJOBHD ON (PURCHD.PRHD = PRJOBHD.RECNO) LEFT JOIN SUPP ON (PURCHD.SUPP = SUPP.RECNO) LEFT JOIN SUPPCONT ON (PURCHD.CONT = SUPPCONT.RECNO) LEFT JOIN EMPL MAKER ON (PURCHD.MAKER = MAKER.RECNO) LEFT JOIN EMPL BUYER ON (PURCHD.BUYER = BUYER.RECNO) LEFT JOIN EMPL APPROVER ON (PURCHD.APPROVER = APPROVER.RECNO) ORDER BY PURCHD.DOCNO DESC";
$sqlsreach['PURCHD_DT'] = "SELECT PURCDT.RECNO, PURCDT.STATUS, PURCDT.PURCHD, PURCDT.SUPP, PURCDT.LINENO, PURCDT.ITEMNO, PURCDT.INVENT, PURCDT.DETAIL, PURCDT.QUANORD, PURCDT.QUANDLY, PURCDT.QUANCCL, PURCDT.UNITNO, PURCDT.UNITAMT, PURCDT.TOTALAMT, INVENT.CODE, INVENT.PRODNAME, LISTUNIT.UNITNAME, PRJOBHD.DOCNO PRNO FROM PURCDT LEFT JOIN INVENT ON (PURCDT.INVENT = INVENT.RECNO) LEFT JOIN LISTUNIT ON (PURCDT.UNITNO = LISTUNIT.RECNO) LEFT JOIN PRJOBHD ON (PURCDT.PRHD = PRJOBHD.RECNO) WHERE (PURCDT.PURCHD = :RECNO) AND ((PURCDT.DTTYPE <> 'F') OR (PURCDT.DTTYPE IS NULL)) ORDER BY PURCDT.LINENO";
$sqlsreach['UD_PURCHD'] = "UPDATE PURCHD SET LASTUPD='NOW',BUYER=:BUYER,MAKER=:MAKER,APPROVER=:APPROVER WHERE RECNO=:RECNO";
//EMPLOYEE
$sqlsreach['EMPL_LIST'] =  "SELECT RECNO,EMPNAME,EMPNO  FROM EMPL";

//CUSTOMER 
$sqlsreach['CUST_LIST'] =  "SELECT RECNO,NAME,CODE  FROM CUST ORDER BY CODE ASC";
$sqlsreach['CUSTCONT_LIST'] =  "SELECT RECNO,CONTNAME,CONTTEL,CONTEMAIL FROM CUSTCONT WHERE CUST=:CUST AND CONTNAME <> ''";


//INVENT
$sqlsreach['0003'] = "UPDATE INVENT SET CODE = ':CODE' WHERE RECNO = :RECNO";
$sqlsreach['0004'] = "INSERT INTO INVENT (CODE, RECNO) VALUES (':CODE', :RECNO)";




$sqlsreach['InsertINVREQHD'] = "INSERT INTO INVREQHD (RECNO, LASTUPD, STATUS, CORP, REQTYPE, IO, DOCDATE, DOCNO) VALUES (:RECNO, 'NOW', ':STATUS', :CORP, :REQTYPE, ':IO', ':DOCDATE', ':DOCNO')";
// $sqlsreach['InsertINVREQDT'] = "INSERT INTO INVREQDT (RECNO, LASTUPD, STATUS, CORP,INVREQHD,IO, CUST, SUPP, REFDOCHD, REFDOCDT, LINENO, ITEMNO) VALUES (:RECNO, 'NOW', ':STATUS', :CORP, :INVREQHD, ':IO', NULL, NULL, :REFDOCHD, :REFDOCDT, :LINENO, :ITEMNO)";
$sqlsreach['InsertINVREQDT'] = "INSERT INTO INVREQDT (RECNO, LASTUPD, STATUS, CORP,INVREQHD,IO, CUST, SUPP, REFDOCHD, REFDOCDT, LINENO, ITEMNO, INVENT, QUANORD, QUANDLY, LISTUNIT, PURPOSE) VALUES (:RECNO, 'NOW', ':STATUS', :CORP, :INVREQHD, ':IO', NULL, NULL, :REFDOCHD, :REFDOCDT, :LINENO, :ITEMNO, :INVENT, :QUANORD, :QUANDLY, :LISTUNIT, NULL)";
$sqlsreach['0005'] = "SELECT INVENT.RECNO, INVENT.INVTYPE, INVENT.CODE, INVENT.PRODNAME, INVENT.LISTUNIT, INVENT.QUAN, INVENT.COSTAMT, INVENT.SALEAMT, INVENT.LASTIN, INVENT.LASTOUT, INVENT.IMAGE, INVTYPE.TYPENAME, LISTUNIT.UNITNAME FROM INVENT LEFT JOIN INVTYPE ON (INVENT.INVTYPE = INVTYPE.RECNO) LEFT JOIN LISTUNIT ON (INVENT.LISTUNIT = LISTUNIT.RECNO)";
$sqlsreach['0006'] = "SELECT QUOTDT.RECNO, QUOTDT.LASTUPD, QUOTDT.QUOTHD, QUOTDT.CORP, QUOTDT.CUST,QUOTDT.LINENO, QUOTDT.ITEMNO, QUOTDT.DETAIL, QUOTDT.DETAIL1, QUOTDT.DETAIL2,QUOTDT.DETAIL3, QUOTDT.DETAIL4, QUOTDT.DETAIL5, QUOTDT.QUAN, QUOTDT.UNITNO,QUOTDT.UNITAMT, QUOTDT.TOTALAMT, INVENT.CODE, INVENT.CALLNAME, LISTUNIT.UNITNAME FROM QUOTDT LEFT JOIN INVENT ON (QUOTDT.INVENT = INVENT.RECNO) LEFT JOIN LISTUNIT ON (QUOTDT.UNITNO = LISTUNIT.RECNO)  WHERE QUOTDT.QUOTHD = :RECNO ORDER BY QUOTDT.LINENO";

$sqlsreach['machine'] = "SELECT * FROM MACHINE ORDER BY MCCODE";
$sqlsreach['yearperoid'] = "SELECT MAX(EXTRACT(YEAR FROM DOCDATE)) AYEAR FROM INVCHD";
$sqlsreach['allyear'] = "SELECT DISTINCT(EXTRACT(YEAR FROM DOCDATE)) AYEAR FROM INVCHD ORDER BY AYEAR DESC";
$sqlsreach['selectyear'] = "SELECT EXTRACT(YEAR FROM DOCDATE) AS AYEAR FROM INVCHD WHERE (STATUS <> 'C') AND (EXTRACT(YEAR FROM DOCDATE) BETWEEN :ABEGIN AND :END) GROUP BY AYEAR ORDER BY AYEAR ROWS 3";
$sqlsreach['total'] ="SELECT SUM(DEPTOTAL) AS TOTALAMT FROM INVCHD WHERE (STATUS <> 'C') AND (EXTRACT(MONTH FROM DOCDATE) = :MONTHSPAN) AND (EXTRACT(YEAR FROM DOCDATE) = :YEARSPAN)";


// STOCK
$sqlsreach['scanbarcode'] = "SELECT * FROM INVENT WHERE INVENT.BARCODE = ':BARCODE' ";
$sqlsreach['withdrawstock'] = "UPDATE INVENT SET LASTUPD='NOW', QUAN=QUAN - :QUAN,LASTOUT='NOW' WHERE RECNO=:RECNO";
// $sqlsreach['withdrawstock'] = "SELECT * FROM INVENT WHERE INVENT.BARCODE = ':BARCODE' ";
$sqlsreach['lastdocnowithdrawstock'] = "SELECT MAX(DOCNO) AS DOCNO FROM INVREQHD";


// ACTIVITY
$sqlsreach['IND_ACTIVITYHD'] = "INSERT INTO ACTIVITYHD (RECNO, CREATED,LASTUPD,STATUS,DOCNO,CUST,CONT,CUSTNAME,CONTNAME,TEL,EMAIL,ADDR,LOCATION,SUBJECT,DETAIL,REF,PRIORITY,TIMED,TIMEH,TIMEM,STARTD,PRICECOST,PRICEPWITHDRAW,OWNER,OWNERNAME) VALUES (:RECNO,'NOW', 'NOW',:STATUS,:DOCNO,:CUST,:CONT,:CUSTNAME,:CONTNAME,:TEL,:EMAIL,:ADDR,:LOCATION,:SUBJECT,:DETAIL,:REF,:PRIORITY,:TIMED,:TIMEH,:TIMEM,:STARTD,:PRICECOST,:PRICEPWITHDRAW,:OWNER,:OWNERNAME)";
// $sqlsreach['IND_ACTIVITYHD'] = "UPDATE ACTIVITYHD SET LASTUPD = 'NOW', STATUS = :STATUS, CUST = :CUST, CONT = :CONT, CUSTNAME = :CUSTNAME, CONTNAME = :CONTNAME, TEL = :TEL, EMAIL = :EMAIL, ADDR = :ADDR, LOCATION = :LOCATION, SUBJECT = :SUBJECT, DETAIL = :DETAIL, REF = :REF, PRIORITY = :PRIORITY, TIMED = :TIMED, TIMEH = :TIMEH, TIMEM = :TIMEM, STARTD = :STARTD, PRICECOST = :PRICECOST, PRICEPWITHDRAW = :PRICEPWITHDRAW, OWNER = :OWNER, OWNERNAME = :OWNERNAME WHERE RECNO = :RECNO";
$sqlsreach['SEL_ACTIVITYHD'] ="SELECT * FROM ACTIVITYHD";
$sqlsreach['EDSEL_ACTIVITYHD'] ="SELECT * FROM ACTIVITYHD WHERE RECNO = :RECNO";
$sqlsreach['DATESEL_ACTIVITYHD'] ="SELECT * FROM ACTIVITYHD WHERE  STARTD = :STARTD ";
// $sqlsreach['DATESEL_ACTIVITYHD'] ="SELECT * FROM ACTIVITYHD WHERE STARTD = :STARTD ";
$sqlsreach['UPD_ACTIVITYHD'] = "UPDATE ACTIVITYHD SET LASTUPD = 'NOW', STATUS = :STATUS, CUST = :CUST, CONT = :CONT, CUSTNAME = :CUSTNAME, CONTNAME = :CONTNAME, TEL = :TEL, EMAIL = :EMAIL, ADDR = :ADDR, LOCATION = :LOCATION, SUBJECT = :SUBJECT, DETAIL = :DETAIL, REF = :REF, PRIORITY = :PRIORITY, TIMED = :TIMED, TIMEH = :TIMEH, TIMEM = :TIMEM, STARTD = :STARTD, PRICECOST = :PRICECOST, PRICEPWITHDRAW = :PRICEPWITHDRAW, OWNER = :OWNER, OWNERNAME = :OWNERNAME WHERE RECNO = :RECNO";
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function sqlexec($queryId) 
{
  global $sqlsreach;
  if (array_key_exists($queryId, $sqlsreach))
  {
    $sqlQuery = $sqlsreach[$queryId];
    return $sqlQuery;
  } else {
    return null;
  }
}

function sqlmixexe($queryId, $params) 
{
  global $sqlsreach;
  // ตรวจสอบว่ามีคำสั่ง SQL ตามหมายเลขที่กำหนดหรือไม่
  if (array_key_exists($queryId, $sqlsreach)) {
    $sqlQuery = $sqlsreach[$queryId];
    // ตรวจสอบว่า params มีค่าหรือไม่
    if (!empty($params)) {
      // เติมค่าพารามิเตอร์ในคำสั่ง SQL
      foreach ($params as $key => $value) {
        if (isset($value) && !is_array($value)) 
        { // ตรวจสอบว่ามีคีย์ใน $params และไม่ใช่ array
          if ($value === null || $value === '')
          {
            $value = '';
          }else {
            $value = is_numeric($value) ? strval($value) : "'".$value."'"; // เปลี่ยนเป็น string number ถ้าเป็นตัวเลข หรือแปลงเป็นสตริงและเพิ่มเครื่องหมาย ' (single quotes) ถ้าไม่ใช่ตัวเลข
          }
          $sqlQuery = str_replace(":$key", $value, $sqlQuery);
        } 
        // else {
        //   // สามารถใส่การจัดการข้อผิดพลาดที่ควรจะเกิดขึ้นที่นี่
        //   // เช่น ให้คืนค่า null, ให้ล็อกข้อความแจ้งเตือน หรือทำอย่างอื่นตามความเหมาะสมกับแอปพลิเคชันของคุณ
        // }
      }
    }
    return $sqlQuery;
  } else {
    return null;
  }
}


?>

