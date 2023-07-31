<?php 
// functions.php
function convertToTIS620($data) {
    return iconv("UTF-8", "TIS-620//TRANSLIT//IGNORE", $data);
  }
  
function getvalue($queryIdHD, $paramhd)
{
  if ($queryIdHD == 'IND_ACTIVITYHD')
  {
    $custname = convertToTIS620($paramhd['CUSTNAME']);
    $contname = convertToTIS620($paramhd['CONTNAME']);
    $tel = convertToTIS620($paramhd['TEL']);
    $email = convertToTIS620($paramhd['EMAIL']);
    $addr = convertToTIS620($paramhd['ADDR']);
    $subject = convertToTIS620($paramhd['SUBJECT']);
    $detail = convertToTIS620($paramhd['DETAIL']);
    $ref = convertToTIS620($paramhd['REF']);
    $ownername = convertToTIS620($paramhd['OWNERNAME']);

    return array(
      'custname' => convertToTIS620($paramhd['CUSTNAME']),
      'contname' => convertToTIS620($paramhd['CONTNAME']),
      'tel' =>convertToTIS620($paramhd['TEL']),
      'email' =>   convertToTIS620($paramhd['EMAIL']),
      'addr' => convertToTIS620($paramhd['ADDR']),
      'subject' => convertToTIS620($paramhd['SUBJECT']),
      'detail' => convertToTIS620($paramhd['DETAIL']),
      'ref' => convertToTIS620($paramhd['REF']),
      'ownername' => convertToTIS620($paramhd['OWNERNAME'])
    );
  }

  else if($queryIdHD == 'UPD_ACTIVITYHD')
  {
    $custname = convertToTIS620($paramhd['CUSTNAME']);
    $contname = convertToTIS620($paramhd['CONTNAME']);
    $tel = convertToTIS620($paramhd['TEL']);
    $email = convertToTIS620($paramhd['EMAIL']);
    $addr = convertToTIS620($paramhd['ADDR']);
    $subject = convertToTIS620($paramhd['SUBJECT']);
    $detail = convertToTIS620($paramhd['DETAIL']);
    $ref = convertToTIS620($paramhd['REF']);
    $ownername = convertToTIS620($paramhd['OWNERNAME']);

    return array(
      'custname' => $custname,
      'contname' => $contname,
      'tel' => $tel,
      'email' => $email,
      'addr' => $addr,
      'subject' => $subject,
      'detail' => $detail,
      'ref' => $ref,
      'ownername' => $ownername
    );
  }
}





?>

