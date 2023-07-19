<?php 

$sql = array();

// $sql['0001'] = "SELECT QUOTHD.RECNO,QUOTHD.LASTUPD,QUOTHD.STATUS,QUOTHD.CORP,QUOTHD.QUOTTYPE,QUOTHD.QUOTTITLE,QUOTHD.DOCDATE QDOCDATE,QUOTHD.DOCNO QDOCNO,QUOTHD.REVISE,QUOTHD.DELYDATE,QUOTHD.VALIDUNTIL,QUOTHD.DELYPLACE,QUOTHD.CREDIT,QUOTHD.TOTALAMT,QUOTHD.VATUSE,QUOTHD.NETAMT,QUOTHD.REMARK,QUOTHD.IMAGENO,CUST.CODE,CUST.NAME,CUST.TEL,CUST.CELL,CUST.FAX,CUST.EMAIL,CUSTCONT.CONTNAME,CUSTCONT.JOBPOS,CUSTCONT.CONTTEL,CUSTCONT.CONTCELL,CUSTCONT.CONTFAX,CUSTCONT.CONTEMAIL,EMPL1.EMPNAME EMPNAMESALES,EMPL2.EMPNAME EMPNAMEMAKER,EMPL3.EMPNAME EMPNAMEAPPROVER FROM QUOTHD LEFT JOIN CUST ON (QUOTHD.CUST = CUST.RECNO) LEFT JOIN EMPL EMPL1 ON (QUOTHD.SALES = EMPL1.RECNO)  LEFT JOIN EMPL EMPL2 ON (QUOTHD.MAKER = EMPL2.RECNO) LEFT JOIN EMPL EMPL3 ON (QUOTHD.APPROVER = EMPL3.RECNO) LEFT JOIN CUSTCONT ON (QUOTHD.CONT = CUSTCONT.RECNO) WHERE (QUOTHD.CORP = 1) AND (QUOTHD.STATUS <> 'D')  ORDER BY QUOTHD.DOCNO DESC, QUOTHD.REVISE DESC";
$sql['0001'] = "SELECT QUOTHD.RECNO,QUOTHD.LASTUPD,QUOTHD.STATUS,QUOTHD.QUOTTYPE,QUOTHD.DOCDATE QDOCDATE,QUOTHD.DOCNO QDOCNO,QUOTHD.REVISE,QUOTHD.DELYDATE,QUOTHD.VALIDUNTIL,QUOTHD.DELYPLACE,QUOTHD.CREDIT,QUOTHD.TOTALAMT,QUOTHD.VATUSE,QUOTHD.NETAMT,QUOTHD.REMARK,CUST.CODE,CUST.NAME,CUST.TEL,CUST.CELL,CUST.FAX,CUST.EMAIL,CUSTCONT.CONTNAME,CUSTCONT.JOBPOS,CUSTCONT.CONTTEL,CUSTCONT.CONTCELL,CUSTCONT.CONTFAX,CUSTCONT.CONTEMAIL,EMPL1.EMPNAME EMPNAMESALES,EMPL2.EMPNAME EMPNAMEMAKER,EMPL3.EMPNAME EMPNAMEAPPROVER FROM QUOTHD LEFT JOIN CUST ON (QUOTHD.CUST = CUST.RECNO) LEFT JOIN EMPL EMPL1 ON (QUOTHD.SALES = EMPL1.RECNO)  LEFT JOIN EMPL EMPL2 ON (QUOTHD.MAKER = EMPL2.RECNO) LEFT JOIN EMPL EMPL3 ON (QUOTHD.APPROVER = EMPL3.RECNO) LEFT JOIN CUSTCONT ON (QUOTHD.CONT = CUSTCONT.RECNO) ORDER BY QUOTHD.DOCNO DESC, QUOTHD.REVISE DESC";
$sql['0002'] = "SELECT * FROM QUOTHD WHERE QUOTHD.STATUS = ':STATUS' ";

//EMPLOYEE
$sql['EMPL_LIST'] =  "SELECT RECNO,EMPNAME  FROM EMPL";


//INVENT
$sql['0003'] = "UPDATE INVENT SET CODE = ':CODE' WHERE RECNO = :RECNO";
$sql['0004'] = "INSERT INTO INVENT (CODE, RECNO) VALUES (':CODE', :RECNO)";

$sql['UD_QUOTHD'] = "UPDATE QUOTHD SET LASTUPD='NOW',SALES=:SALES,MAKER=:MAKER,APPROVER=:APPROVER WHERE RECNO=:RECNO";

// $sql['InsertINVREQHD'] = "INSERT INTO INVREQHD (RECNO,LASTUPD,DOCDATE) VALUES (:RECNO, 'NOW', 'NOW')";
$sql['InsertINVREQHD'] = "INSERT INTO INVREQHD (RECNO, LASTUPD, STATUS, CORP, REQTYPE, IO, DOCDATE, DOCNO) VALUES (:RECNO, 'NOW', ':STATUS', :CORP, :REQTYPE, ':IO', ':DOCDATE', ':DOCNO')";
// $sql['InsertINVREQDT'] = "INSERT INTO INVREQDT (RECNO, LASTUPD, STATUS, CORP,INVREQHD,IO, CUST, SUPP, REFDOCHD, REFDOCDT, LINENO, ITEMNO) VALUES (:RECNO, 'NOW', ':STATUS', :CORP, :INVREQHD, ':IO', NULL, NULL, :REFDOCHD, :REFDOCDT, :LINENO, :ITEMNO)";
$sql['InsertINVREQDT'] = "INSERT INTO INVREQDT (RECNO, LASTUPD, STATUS, CORP,INVREQHD,IO, CUST, SUPP, REFDOCHD, REFDOCDT, LINENO, ITEMNO, INVENT, QUANORD, QUANDLY, LISTUNIT, PURPOSE) VALUES (:RECNO, 'NOW', ':STATUS', :CORP, :INVREQHD, ':IO', NULL, NULL, :REFDOCHD, :REFDOCDT, :LINENO, :ITEMNO, :INVENT, :QUANORD, :QUANDLY, :LISTUNIT, NULL)";
// $sql['0005'] = "SELECT * FROM INVENT";
// $sql['0005'] = "SELECT INVENT.RECNO, INVENT.INVTYPE, INVENT.CODE, INVENT.PRODNAME, INVENT.LISTUNIT, INVENT.QUAN, INVENT.COSTAMT, INVENT.SALEAMT, INVENT.LASTIN, INVENT.LASTOUT, INVENT.IMAGE, INVTYPE.TYPENAME, LISTUNIT.UNITNAME FROM INVENT LEFT JOIN INVTYPE ON (INVENT.INVTYPE = INVTYPE.RECNO) LEFT JOIN LISTUNIT ON (INVENT.LISTUNIT = LISTUNIT.RECNO) ORDER BY INVENT.CODE";
$sql['0005'] = "SELECT INVENT.RECNO, INVENT.INVTYPE, INVENT.CODE, INVENT.PRODNAME, INVENT.LISTUNIT, INVENT.QUAN, INVENT.COSTAMT, INVENT.SALEAMT, INVENT.LASTIN, INVENT.LASTOUT, INVENT.IMAGE, INVTYPE.TYPENAME, LISTUNIT.UNITNAME FROM INVENT LEFT JOIN INVTYPE ON (INVENT.INVTYPE = INVTYPE.RECNO) LEFT JOIN LISTUNIT ON (INVENT.LISTUNIT = LISTUNIT.RECNO)";
$sql['0006'] = "SELECT QUOTDT.RECNO, QUOTDT.LASTUPD, QUOTDT.QUOTHD, QUOTDT.CORP, QUOTDT.CUST,QUOTDT.LINENO, QUOTDT.ITEMNO, QUOTDT.DETAIL, QUOTDT.DETAIL1, QUOTDT.DETAIL2,QUOTDT.DETAIL3, QUOTDT.DETAIL4, QUOTDT.DETAIL5, QUOTDT.QUAN, QUOTDT.UNITNO,QUOTDT.UNITAMT, QUOTDT.TOTALAMT, INVENT.CODE, INVENT.CALLNAME, LISTUNIT.UNITNAME FROM QUOTDT LEFT JOIN INVENT ON (QUOTDT.INVENT = INVENT.RECNO) LEFT JOIN LISTUNIT ON (QUOTDT.UNITNO = LISTUNIT.RECNO)  WHERE QUOTDT.QUOTHD = :RECNO ORDER BY QUOTDT.LINENO";

$sql['machine'] = "SELECT * FROM MACHINE ORDER BY MCCODE";
$sql['yearperoid'] = "SELECT MAX(EXTRACT(YEAR FROM DOCDATE)) AYEAR FROM INVCHD";
$sql['allyear'] = "SELECT DISTINCT(EXTRACT(YEAR FROM DOCDATE)) AYEAR FROM INVCHD ORDER BY AYEAR DESC";
$sql['selectyear'] = "SELECT EXTRACT(YEAR FROM DOCDATE) AS AYEAR FROM INVCHD WHERE (STATUS <> 'C') AND (EXTRACT(YEAR FROM DOCDATE) BETWEEN :ABEGIN AND :END) GROUP BY AYEAR ORDER BY AYEAR ROWS 3";
$sql['total'] ="SELECT SUM(DEPTOTAL) AS TOTALAMT FROM INVCHD WHERE (STATUS <> 'C') AND (EXTRACT(MONTH FROM DOCDATE) = :MONTHSPAN) AND (EXTRACT(YEAR FROM DOCDATE) = :YEARSPAN)";


$sql['scanbarcode'] = "SELECT * FROM INVENT WHERE INVENT.BARCODE = ':BARCODE' ";
$sql['withdrawstock'] = "UPDATE INVENT SET LASTUPD='NOW', QUAN=QUAN - :QUAN,LASTOUT='NOW' WHERE RECNO=:RECNO";
// $sql['withdrawstock'] = "SELECT * FROM INVENT WHERE INVENT.BARCODE = ':BARCODE' ";
$sql['lastdocnowithdrawstock'] = "SELECT MAX(DOCNO) AS DOCNO FROM INVREQHD";

function sqlexec($queryId, $params) 
{
  global $sql;
  // ตรวจสอบว่ามีคำสั่ง SQL ตามหมายเลขที่กำหนดหรือไม่
  if (array_key_exists($queryId, $sql)) {
    $sqlQuery = $sql[$queryId];
    // ตรวจสอบว่า params มีค่าหรือไม่
    if (!empty($params))
    {
      // เติมค่าพารามิเตอร์ในคำสั่ง SQL
      foreach ($params as $key => $value) {
        if ($value === null || $value === '') {
          $value = 'NULL';
        }
        $sqlQuery = str_replace(":$key", $value, $sqlQuery);
      }
    }
    return $sqlQuery;
  } else {
    return null;
  }
}
// function sqlexec($queryId, $params) {
//   global $sql;

//   // ตรวจสอบว่ามีคำสั่ง SQL ตามหมายเลขที่กำหนดหรือไม่
//   if (array_key_exists($queryId, $sql)) {
//     $sqlQuery = $sql[$queryId];

//     // ตรวจสอบว่า params มีค่าหรือไม่
//     if (!empty($params)){
//       // เติมค่าพารามิเตอร์ในคำสั่ง SQL
//       foreach ($params as $key => $value) {
//         // ตรวจสอบว่า value เป็นอาร์เรย์หรือไม่
//         if (is_array($value)) {
//           // สร้างสตริงเปลี่ยนแปลงให้เหมาะสมสำหรับ SQL IN clause
//           $inClause = implode(',', array_fill(0, count($value), '?'));
//           $sqlQuery = str_replace(":$key", $inClause, $sqlQuery);
//         } else {
//           $sqlQuery = str_replace(":$key", $value, $sqlQuery);
//         }
//       }
//     }

//     return $sqlQuery;
//   } else {
//     return null;
//   }
// }

// กรณี SELECT * FROM table WHERE column = :MONTHSPAN
// ELECT * FROM table WHERE column IN (?, ?, ?) หลังจากการแปลงที่ได้จาก SQL
?>

