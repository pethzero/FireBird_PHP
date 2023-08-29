<?php 
// functions.php
function getvalue($queryIdHD, $paramhd)
{
  if ($queryIdHD == 'IND_ACTIVITYHD')
  {
    $custname = $paramhd['CUSTNAME'];
    $contname = $paramhd['CONTNAME'];
    $tel = $paramhd['TEL'];
    $email = $paramhd['EMAIL'];
    $addr = $paramhd['ADDR'];
    $subject = $paramhd['SUBJECT'];
    $detail = $paramhd['DETAIL'];
    $ref = $paramhd['REF'];
    $ownername = $paramhd['OWNERNAME'];

    return array(
      'custname' => $paramhd['CUSTNAME'],
      'contname' => $paramhd['CONTNAME'],
      'tel' =>$paramhd['TEL'],
      'email' =>   $paramhd['EMAIL'],
      'addr' => $paramhd['ADDR'],
      'subject' => $paramhd['SUBJECT'],
      'detail' => $paramhd['DETAIL'],
      'ref' => $paramhd['REF'],
      'ownername' => $paramhd['OWNERNAME']
    );
  }

  else if($queryIdHD == 'UPD_ACTIVITYHD')
  {
    $custname = $paramhd['CUSTNAME'];
    $contname = $paramhd['CONTNAME'];
    $tel = $paramhd['TEL'];
    $email = $paramhd['EMAIL'];
    $addr = $paramhd['ADDR'];
    $subject = $paramhd['SUBJECT'];
    $detail = $paramhd['DETAIL'];
    $ref = $paramhd['REF'];
    $ownername = $paramhd['OWNERNAME'];

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

