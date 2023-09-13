<?php 
  function tranexe($queryIdHD,$paramhd,$result_hd,$stmt,$nextValueHD)
  {
    if ($queryIdHD == 'IND_ACTIVITYHD'){
      $docno = "66" . "/" . sprintf("%04d", $nextValueHD);
      $stmt->bindParam(':RECNO', $nextValueHD);
      $stmt->bindParam(':STATUS', $paramhd['STATUS']);
      $stmt->bindParam(':DOCNO', $docno);
      $stmt->bindParam(':CUST', $paramhd['CUST']);
      $stmt->bindParam(':CONT', $paramhd['CONT']);
      $stmt->bindParam(':CUSTNAME', $result_hd['custname']);
      $stmt->bindParam(':CONTNAME', $result_hd['contname']);
      $stmt->bindParam(':TEL', $result_hd['tel']);
      $stmt->bindParam(':EMAIL', $result_hd['email']);
      $stmt->bindParam(':ADDR', $result_hd['addr']);
      $stmt->bindParam(':LOCATION', $paramhd['LOCATION']);
      $stmt->bindParam(':SUBJECT', $result_hd['subject']);
      $stmt->bindParam(':DETAIL', $result_hd['detail']);
      $stmt->bindParam(':REF', $result_hd['ref']);
      $stmt->bindParam(':PRIORITY', $paramhd['PRIORITY']);
      $stmt->bindParam(':TIMED', $paramhd['TIMED']);
      $stmt->bindParam(':TIMEH', $paramhd['TIMEH']);
      $stmt->bindParam(':TIMEM', $paramhd['TIMEM']);
      $stmt->bindParam(':STARTD', $paramhd['STARTD']);
      $stmt->bindParam(':PRICECOST', $paramhd['PRICECOST']);
      $stmt->bindParam(':PRICEPWITHDRAW', $paramhd['PRICEPWITHDRAW']);
      $stmt->bindParam(':OWNER', $paramhd['OWNER']);
      $stmt->bindParam(':OWNERNAME', $result_hd['ownername']);
    }else if ($queryIdHD == 'UPD_ACTIVITYHD'){
      $stmt->bindParam(':RECNO', $paramhd['RECNO']);
      $stmt->bindParam(':STATUS', $paramhd['STATUS']);
      $stmt->bindParam(':CUST', $paramhd['CUST']);
      $stmt->bindParam(':CONT', $paramhd['CONT']);
      $stmt->bindParam(':CUSTNAME', $result_hd['custname']);
      $stmt->bindParam(':CONTNAME', $result_hd['contname']);
      $stmt->bindParam(':TEL', $result_hd['tel']);
      $stmt->bindParam(':EMAIL', $result_hd['email']);
      $stmt->bindParam(':ADDR', $result_hd['addr']);
      $stmt->bindParam(':LOCATION', $paramhd['LOCATION']);
      $stmt->bindParam(':SUBJECT', $result_hd['subject']);
      $stmt->bindParam(':DETAIL', $result_hd['detail']);
      $stmt->bindParam(':REF', $result_hd['ref']);
      $stmt->bindParam(':PRIORITY', $paramhd['PRIORITY']);
      $stmt->bindParam(':TIMED', $paramhd['TIMED']);
      $stmt->bindParam(':TIMEH', $paramhd['TIMEH']);
      $stmt->bindParam(':TIMEM', $paramhd['TIMEM']);
      $stmt->bindParam(':STARTD', $paramhd['STARTD']);
      $stmt->bindParam(':PRICECOST', $paramhd['PRICECOST']);
      $stmt->bindParam(':PRICEPWITHDRAW', $paramhd['PRICEPWITHDRAW']);
      $stmt->bindParam(':OWNER', $paramhd['OWNER']);
      $stmt->bindParam(':OWNERNAME', $result_hd['ownername']);
    }
  }
?>