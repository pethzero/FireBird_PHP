<?php
class bindParamData
{
    public static function bindParams($stmt, $data, $condition)
    {
        switch ($condition) {
            case 'RECNO000':
                $stmt->bindParam(':recno', $data['recno']);
                break;
            case 'RECNO000_STATUS':
                $stmt->bindParam(':recno', $data['recno']);
                $stmt->bindParam(':status', $data['status']);
                break;
            case 'L00001':
                $stmt->bindParam(':login', $data['login']);
                break;
            case 'ID000':
                $stmt->bindParam(':id', $data['id']);
                break;

            case '001':
                $stmt->bindParam(':name', $data['name']);
                $stmt->bindParam(':detail', $data['detail']);
                $stmt->bindParam(':remark', $data['remark']);
                $stmt->bindParam(':startd', $data['dateAct']);
                $stmt->bindParam(':warmd', $data['dateWarn']);
                $stmt->bindParam(':ownername', $data['ownername']);
                break;
            case '001_NEW':
                $stmt->bindParam(':name', $data['name']);
                $stmt->bindParam(':detail', $data['detail']);
                $stmt->bindParam(':remark', $data['remark']);
                $stmt->bindParam(':startd', $data['dateAct']);
                $stmt->bindParam(':warmd', $data['dateWarn']);
                $stmt->bindParam(':ownername', $data['ownername']);
                $stmt->bindParam(':location', $data['location']);
                break;
            case '002':
                $stmt->bindParam(':recno', $data['recno']);
                $stmt->bindParam(':name', $data['name']);
                $stmt->bindParam(':detail', $data['detail']);
                $stmt->bindParam(':remark', $data['remark']);
                $stmt->bindParam(':startd', $data['dateAct']);
                $stmt->bindParam(':warmd', $data['dateWarn']);
                $stmt->bindParam(':ownername', $data['ownername']);
                break;
            case '002_UPAPP':
                $stmt->bindParam(':recno', $data['recno']);
                $stmt->bindParam(':name', $data['name']);
                $stmt->bindParam(':detail', $data['detail']);
                $stmt->bindParam(':remark', $data['remark']);
                $stmt->bindParam(':startd', $data['dateAct']);
                $stmt->bindParam(':warmd', $data['dateWarn']);
                $stmt->bindParam(':ownername', $data['ownername']);
                $stmt->bindParam(':address', $data['address']);
                $stmt->bindParam(':status', $data['status']);
                break;
            case '003_INEEQUIP':
            case '003_UPDEQUIP':
                $stmt->bindParam(':name', $data['name']);
                $stmt->bindParam(':type', $data['type']);
                $stmt->bindParam(':code', $data['code']);
                $stmt->bindParam(':model', $data['model']);
                $stmt->bindParam(':custname', $data['custname']);
                $stmt->bindParam(':contname', $data['contname']);
                $stmt->bindParam(':phone', $data['phone']);
                $stmt->bindParam(':email', $data['email']);
                $stmt->bindParam(':area', $data['area']);
                $stmt->bindParam(':docinfo', $data['docinfo']);
                $stmt->bindParam(':status', $data['status']);
                $stmt->bindParam(':priority', $data['priority']);
                $stmt->bindParam(':warranty', $data['warranty']);
                $stmt->bindParam(':maintenancetimes', $data['maintenancetimes']);
                $stmt->bindParam(':brokentimes', $data['brokentimes']);
                $stmt->bindParam(':details', $data['details']);
                $stmt->bindParam(':purchasedate', $data['purchasedate']);
                $stmt->bindParam(':firstusage', $data['firstusage']);
                $stmt->bindParam(':lastusage', $data['lastusage']);
                $stmt->bindParam(':recorderno', $data['recorderno']);
                $stmt->bindParam(':recordername', $data['recordername']);
                $stmt->bindParam(':upload', $data['upload']);
                if ($condition === '003_UPDEQUIP') {
                    $stmt->bindParam(':recno', $data['recno']);
                } else {
                    $stmt->bindParam(':docno', $data['docno']);
                }
                break;
            case '003_INNOTIMATANCE':
            case '003_UPNOTIMATANCE':
                $stmt->bindParam(':name', $data['name']);
                $stmt->bindParam(':contname', $data['contname']);
                $stmt->bindParam(':equipment', $data['equipment']);
                $stmt->bindParam(':status', $data['status']);
                $stmt->bindParam(':priority', $data['priority']);
                $stmt->bindParam(':pricecost', $data['pricecost']);
                $stmt->bindParam(':pricepwithdraw', $data['pricepwithdraw']);
                $stmt->bindParam(':warningdate', $data['warningdate']);
                $stmt->bindParam(':details', $data['details']);
                $stmt->bindParam(':recorderno', $data['recorderno']);
                $stmt->bindParam(':recordername', $data['recordername']);
                if ($condition === '003_UPNOTIMATANCE') {
                    $stmt->bindParam(':recno', $data['recno']);
                } else {
                    $stmt->bindParam(':docno', $data['docno']);
                }
                break;
            case '003_INDRAWING':
                $stmt->bindParam(':customer', $data['customer']);
                $stmt->bindParam(':drawno', $data['drawno']);
                $stmt->bindParam(':revno', $data['revno']);
                $stmt->bindParam(':partname', $data['partname']);
                $stmt->bindParam(':recdate', $data['recdate']);
                $stmt->bindParam(':remark', $data['remark']);
                $stmt->bindParam(':modifiedby', $data['modifiedby']);
                break;
            case 'DATEBE':
                $stmt->bindParam(':ABEGIN', $data['datebegin']);
                $stmt->bindParam(':AEND', $data['dateend']);
                break;
            case 'DATEPERIOD':
                $stmt->bindParam(':DATEPERIOD', $data['dateperiod']);
                break;
            case 'EMPNOCHECK':
            case 'EMPNOCHECK_UPD':
                $stmt->bindParam(':empno', $data['empno']);
                $stmt->bindParam(':login', $data['login']);
                if ($condition === 'EMPNOCHECK_UPD') {
                    $stmt->bindParam(':id', $data['id']);
                }
                break;
            case 'EMPNOIND':
            case 'EMPNOUPD':
            case 'EMPNOUPD_ID':
                $stmt->bindParam(':empno', $data['empno']);
                $stmt->bindParam(':userlevel', $data['userlevel']);
                $stmt->bindParam(':empname', $data['empname']);
                $stmt->bindParam(':empnick', $data['empnick']);
                $stmt->bindParam(':login', $data['login']);
                $stmt->bindParam(':pass', $data['pass']);
                if ($condition === 'EMPNOUPD') {
                    $stmt->bindParam(':recno', $data['recno']);
                } else if ($condition === 'EMPNOUPD_ID') {
                    $stmt->bindParam(':id', $data['id']);
                }
                break;
            case 'TYPE':
                $stmt->bindParam(':type', $data['type']);
                break;
            case 'ADDAMT':
                $stmt->bindParam(':recno', $data['recno']);
                $stmt->bindParam(':addamt', $data['addamt']);
                break;
            case '001_INVREQHD':
                $stmt->bindParam(':recno', $data['recno']);
                $stmt->bindParam(':reqtype', $data['reqtype']);
                $stmt->bindParam(':status', $data['status']);
                $stmt->bindParam(':io', $data['io']);
                $stmt->bindParam(':docno', $data['docno']);
                $stmt->bindParam(':docdate', $data['docdate']);
                break;
            case '001_INVREQDT':
                $stmt->bindParam(':recno', $data['recno']);
                $stmt->bindParam(':status', $data['status']);
                $stmt->bindParam(':corp', $data['corp']);
                $stmt->bindParam(':invreqhd', $data['invreqhd']);
                $stmt->bindParam(':reqtype', $data['reqtype']);
                $stmt->bindParam(':io', $data['io']);
                $stmt->bindParam(':refdochd', $data['refdochd']);
                $stmt->bindParam(':refdocdt', $data['refdocdt']);
                $stmt->bindParam(':lineno', $data['lineno']);
                $stmt->bindParam(':itemno', $data['itemno']);
                $stmt->bindParam(':invent', $data['invent']);
                $stmt->bindParam(':quanord', $data['quanord']);
                $stmt->bindParam(':quandly', $data['quandly']);
                $stmt->bindParam(':listunit', $data['listunit']);
                break;
            case '001_QUAN':
                $stmt->bindParam(':recno', $data['recno']);
                $stmt->bindParam(':quan', $data['quan']);
                break;
            case '000_NAME':
                $stmt->bindParam(':name', $data['name']);
                break;
            case 'BILLDETAIL':
                $stmt->bindParam(':recno', $data['recno']);
                $stmt->bindParam(':code', $data['code']);
                $stmt->bindParam(':sname', $data['sname']);
                $stmt->bindParam(':name', $data['name']);
                $stmt->bindParam(':year', $data['year']);
                $stmt->bindParam(':detail', $data['detail']);
            case 'BD01745':
                $stmt->bindParam(':recno', $data['recno']);
                $stmt->bindParam(':year', $data['year']);
                $stmt->bindParam(':detail', $data['detail']);
            case '000_RY':
                $stmt->bindParam(':recno', $data['recno']);
                $stmt->bindParam(':year', $data['year']);
                break;
            case 'DEV14893':
                $stmt->bindParam(':id', $data['id']);
                $stmt->bindParam(':pass', $data['pass']);
                break;
                // เพิ่มเงื่อนไขเพิ่มเติมตามความต้องการ
            default:
                // ไม่มีเงื่อนไขที่ตรงกัน
                break;
        }
    }
}

//        $stmt->bindParam(':img', ''); ห้ามว่าง