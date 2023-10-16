<?php
class SQLQueries
{
    private $sqlsreach = array();
    public function __construct()
    {
        // กำหนดคำสั่ง SQL สำหรับแต่ละค่า $queryIdHD ที่คุณต้องการ


        //APPPOINTMENT
        $this->sqlsreach['IND_APPPOINTMENT'] = "INSERT INTO appointment (CREATED,LASTUPD,CUSTNAME,STATUS,DETAIL,REMARK,STARTD,WARND,OWNERNAME) VALUES (NOW(),NOW(),:name,'A',:detail,:remark,:startd,:warmd,:ownername,)";
        $this->sqlsreach['IND_APPPOINTMENT_NEW'] = "INSERT INTO appointment (CREATED,LASTUPD,CUSTNAME,STATUS,DETAIL,REMARK,STARTD,WARND,OWNERNAME,ADDR) VALUES (NOW(),NOW(),:name,'A',:detail,:remark,:startd,:warmd,:ownername,:location)";
        $this->sqlsreach['UPD_APPPOINTMENT'] = " UPDATE appointment SET CUSTNAME = :name, DETAIL = :detail, REMARK = :remark, STARTD = :startd, WARND = :warmd , OWNERNAME = :ownername WHERE RECNO = :recno";
        $this->sqlsreach['UPD_APPPOINTMENT_NEW'] = " UPDATE appointment SET CUSTNAME = :name, DETAIL = :detail, REMARK = :remark, STARTD = :startd, WARND = :warmd , OWNERNAME = :ownername ,ADDR = :address ,STATUS = :status WHERE RECNO = :recno";
        $this->sqlsreach['DLT_APPPOINTMENT'] = "DELETE FROM appointment WHERE RECNO= :recno ";
        $this->sqlsreach['CHK_APPPOINTMENT'] = " SELECT COUNT(*) as count FROM appointment WHERE RECNO = :recno";
        $this->sqlsreach['SELECT_APPPOINTMENT'] = "SELECT * FROM appointment ORDER BY RECNO DESC";
        $this->sqlsreach['001'] = "INSERT INTO appointment (CUSTNAME) VALUES (:name)";
        $this->sqlsreach['SELECT_CUST'] = "SELECT RECNO,NAME FROM cust ORDER BY RECNO DESC";

        //QOUT
        $this->sqlsreach['COUNT_QUOTHD0'] = "SELECT QUOTHD.CUST, CUST.NAME AS CustomerName, CUST.CODE  AS CODE, CUST.CORP  AS CORPNAME, COUNT(QUOTHD.CUST) AS QUAN FROM QUOTHD LEFT JOIN CUST ON QUOTHD.CUST = CUST.RECNO GROUP BY QUOTHD.CUST, CUST.NAME, CUST.CODE, CUST.CORP ORDER BY QUAN DESC";
        $this->sqlsreach['QOUT_INVOICE_0'] = "SELECT INVCHD.RECNO, INVCHD.DOCDATE, INVCHD.DUEDATE, INVCHD.DOCNO, INVCHD.SALES, INVCHD.ORDERNO, INVCDT.DETAIL, INVCDT.QUAN, INVCDT.UNITAMT, INVCDT.TOTALAMT, INVCHD.CURCODE, INVCHD.EXCHGRATE, CUST.CODE, CUST.NAME, EMPL.EMPNO, EMPL.EMPNAME FROM INVCHD LEFT JOIN CUST ON (INVCHD.CUST = CUST.RECNO) LEFT JOIN EMPL ON (INVCHD.SALES = EMPL.RECNO) LEFT JOIN INVCDT ON (INVCHD.RECNO = INVCDT.INVCHD) WHERE (INVCHD.DOCDATE BETWEEN :ABEGIN AND :AEND) AND (INVCHD.STATUS <> 'C') ORDER BY INVCHD.RECNO";
        $this->sqlsreach['EXCEL_CUSTOMERSALE'] = "SELECT QUOTHD.RECNO, QUOTHD.DOCDATE, QUOTHD.DOCNO, QUOTHD.REVISE, CUST.CODE, CUST.SNAME, CUST.NAME, CUSTCONT.CONTNAME, QUOTDT.DETAIL, EMPL.EMPNAME, QUOTHD.CREDIT, QUOTHD.REMARK, QUOTDT.QUAN, QUOTDT.UNITAMT, QUOTDT.TOTALAMT FROM QUOTHD LEFT JOIN CUST ON (QUOTHD.CUST = CUST.RECNO) LEFT JOIN CUSTCONT ON (QUOTHD.CONT = CUSTCONT.RECNO) LEFT JOIN EMPL ON (QUOTHD.SALES = EMPL.RECNO) LEFT JOIN quotdt ON (QUOTHD.RECNO = quotdt.QUOTHD) WHERE  (QUOTHD.STATUS <> 'C') AND  (QUOTDT.DETAIL <> '')  AND (QUOTHD.DOCDATE BETWEEN :ABEGIN AND :AEND) ORDER BY QUOTHD.RECNO";
        $this->sqlsreach['EXCEL_QOUT_INVOICE'] = "SELECT INVCHD.RECNO, INVCHD.DOCDATE, INVCHD.DOCNO, INVCHD.ORDERNO, CUST.CODE, CUST.SNAME, CUST.NAME, CUSTCONT.CONTNAME, EMPL.EMPNAME, INVCDT.DETAIL, INVCDT.QUAN, INVCDT.UNITAMT, INVCDT.TOTALAMT FROM INVCHD LEFT JOIN CUST ON (INVCHD.CUST = CUST.RECNO) LEFT JOIN CUSTCONT ON (INVCHD.CONT = CUSTCONT.RECNO) LEFT JOIN EMPL ON (INVCHD.SALES = EMPL.RECNO) LEFT JOIN INVCDT ON (INVCHD.RECNO = INVCDT.INVCHD) WHERE (INVCHD.DOCDATE BETWEEN :ABEGIN AND :AEND) AND (INVCDT.DETAIL <> '')  AND (INVCHD.STATUS <> 'C') ORDER BY INVCHD.RECNO";
        $this->sqlsreach['EXCEL_QOUT_ORDERHD'] = "SELECT ORDERHD.RECNO, ORDERHD.DOCDATE, ORDERHD.DOCNO, ORDERHD.CUSTORDERNO, CUST.CODE, CUST.SNAME, CUST.NAME, CUSTCONT.CONTNAME, EMPL.EMPNAME, ORDERDT.DETAIL, ORDERDT.QUANDLY, ORDERDT.UNITAMT, ORDERDT.TOTALAMT FROM ORDERHD LEFT JOIN CUST ON (ORDERHD.CUST = CUST.RECNO) LEFT JOIN CUSTCONT ON (ORDERHD.CONT = CUSTCONT.RECNO) LEFT JOIN EMPL ON (ORDERHD.SALES = EMPL.RECNO) LEFT JOIN ORDERDT ON (ORDERHD.RECNO = ORDERDT. ORDERHD) WHERE (ORDERHD.DOCDATE BETWEEN :ABEGIN AND :AEND)  AND  (ORDERDT.DETAIL <> '')  AND (ORDERHD.STATUS <> 'C') ORDER BY ORDERHD.RECNO";
        $this->sqlsreach['EXCEL_QOUT_DELYHD'] = "SELECT DELYHD.RECNO, DELYHD.DOCDATE, DELYHD.DOCNO, DELYHD.ORDERHD, CUST.CODE, CUST.SNAME, CUST.NAME, EMPL.EMPNAME, DELYDT.DETAIL, DELYDT.QUAN, DELYDT.UNITAMT, DELYDT.TOTALAMT FROM DELYHD LEFT JOIN CUST ON (DELYHD.CUST = CUST.RECNO) LEFT JOIN EMPL ON (DELYHD.SALES = EMPL.RECNO) LEFT JOIN DELYDT ON (DELYHD.RECNO = DELYDT.DELYHD) WHERE (DELYHD.DOCDATE BETWEEN :ABEGIN AND :AEND)  AND  (DELYDT.DETAIL <> '')  AND (DELYHD.STATUS <> 'C') ORDER BY DELYHD.RECNO";

        //PO
        $this->sqlsreach['PO_REPORT'] = "SELECT 
        SUPP.CODE SUPPCODE,
                 SUPP.NAME SUPPNAME,
                SUPPINVHD.RECNO RECNOSUP,
                SUPPINVHD.DOCNO,
                SUPPINVHD.SUPPINVNO,
                SUPPINVHD.DOCDATE,
                SUPPINVDT.RECNO, 
                SUPPINVDT.STATUS, 
                SUPPINVDT.DETAIL, 
                SUPPINVDT.UNITNO,
                SUPPINVDT.QUAN, 
                SUPPINVDT.QUANDLY, 
                SUPPINVDT.UNITAMT, 
                SUPPINVDT.TOTALAMT,
                PURCHD.DOCNO PURCHDDOCNO,
                PURCDT.DETAIL PURCDETAIL,
                PURCDT.QUANORD PURCQUANORD,
                PURCDT.UNITNO PURCUNITNO,
                PURCDT.UNITAMT PURCUNITAMT,
                PURCDT.TOTALAMT PURCTOTALAMT
            FROM SUPPINVDT 
            LEFT JOIN PURCDT ON (SUPPINVDT.PURCDT= PURCDT.RECNO)
            LEFT JOIN SUPPINVHD ON (SUPPINVHD.RECNO = SUPPINVDT.SUPPINVHD)
            LEFT JOIN PURCHD ON (PURCHD.RECNO = SUPPINVHD.PURCHD)
            LEFT JOIN SUPP ON (SUPP.RECNO = SUPPINVDT.SUPP)
            WHERE (SUPPINVHD.DOCDATE BETWEEN :ABEGIN AND :AEND)
            ORDER BY  SUPPINVHD.RECNO,SUPPINVDT.LINENO";

        $this->sqlsreach['PO_REPORT_ALL'] = "SELECT 
        SUPP.CODE SUPPCODE,
                 SUPP.NAME SUPPNAME,
                SUPPINVHD.RECNO RECNOSUP,
                SUPPINVHD.DOCNO,
                SUPPINVHD.SUPPINVNO,
                SUPPINVHD.DOCDATE,
                SUPPINVDT.RECNO, 
                SUPPINVDT.STATUS, 
                SUPPINVDT.DETAIL, 
                SUPPINVDT.UNITNO,
                SUPPINVDT.QUAN, 
                SUPPINVDT.QUANDLY, 
                SUPPINVDT.UNITAMT, 
                SUPPINVDT.TOTALAMT,
                PURCHD.DOCNO PURCHDDOCNO,
                PURCDT.DETAIL PURCDETAIL,
                PURCDT.QUANORD PURCQUANORD,
                PURCDT.UNITNO PURCUNITNO,
                PURCDT.UNITAMT PURCUNITAMT,
                PURCDT.TOTALAMT PURCTOTALAMT
            FROM SUPPINVDT 
            LEFT JOIN PURCDT ON (SUPPINVDT.PURCDT= PURCDT.RECNO)
            LEFT JOIN SUPPINVHD ON (SUPPINVHD.RECNO = SUPPINVDT.SUPPINVHD)
            LEFT JOIN PURCHD ON (PURCHD.RECNO = SUPPINVHD.PURCHD)
            LEFT JOIN SUPP ON (SUPP.RECNO = SUPPINVDT.SUPP)
            ORDER BY  SUPPINVHD.RECNO,SUPPINVDT.LINENO";



        // LISTUNIT
        $this->sqlsreach['LISTUNIT'] = "SELECT LISTUNIT.RECNO,LISTUNIT.UNITNAME FROM LISTUNIT";
    }
    public function scanSQL($queryId)
    {
        if (array_key_exists($queryId, $this->sqlsreach)) {
            return $this->sqlsreach[$queryId];
        } else {
            return null;
        }
    }
}
