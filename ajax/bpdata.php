<?php
class bindParamData
{
    public static function bindParams($stmt, $data, $condition)
    {
        switch ($condition) {
            case 'RECNO000':
                $stmt->bindParam(':recno', $data['recno']);
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
                $stmt->bindParam(':name',$data['name']); 
                $stmt->bindParam(':contname',$data['contname']); 
                $stmt->bindParam(':equipment',$data['equipment']); 
                $stmt->bindParam(':status',$data['status']); 
                $stmt->bindParam(':priority',$data['priority']); 
                $stmt->bindParam(':pricecost',$data['pricecost']); 
                $stmt->bindParam(':pricepwithdraw',$data['pricepwithdraw']); 
                $stmt->bindParam(':warningdate',$data['warningdate']); 
                $stmt->bindParam(':details',$data['details']); 
                $stmt->bindParam(':recorderno',$data['recorderno']); 
                $stmt->bindParam(':recordername',$data['recordername']);
                if ($condition === '003_UPNOTIMATANCE') {
                    $stmt->bindParam(':recno', $data['recno']);
                } else {
                    $stmt->bindParam(':docno',$data['docno']); 
                }
                break;
            case 'DATEBE':
                $stmt->bindParam(':ABEGIN', $data['datebegin']);
                $stmt->bindParam(':AEND', $data['dateend']);
                break;
                // เพิ่มเงื่อนไขเพิ่มเติมตามความต้องการ
            default:
                // ไม่มีเงื่อนไขที่ตรงกัน
                break;
        }
    }
}
