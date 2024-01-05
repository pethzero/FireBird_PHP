<?php
class TBname
{
    private $tbname = array();
    public function __construct()
    {
        $this->tbname['0000'] = ["tablename" => "", "aid" => ""];
        $this->tbname['0088'] = ["id" => "0088","tablename" => "SAN", "aid" => "GEN_INVREQHD","spcondition" => "-"];
        $this->tbname['0089'] = ["id" => "0089","tablename" => "SAN", "aid" => "GEN_INVREQDT","spcondition" => "-"];
    }

    public function getTBName($tbanme)
    {
        // ตรวจสอบว่า $tbanme มีอยู่ใน $tbname หรือไม่
        if (isset($this->tbname[$tbanme])) {
            return $this->tbname[$tbanme];
        } else {
            return null; // หรือค่าเริ่มต้นที่คุณต้องการ
        }
    }
}





function uniquecondition($condition_unique, $result_unique, $result_data)
{
    $condition_data = ['' => '', 'condition' => false];

    if ($condition_unique == "IND_EMPL") {
        if ($result_unique['result']['count_empno'] > 0 || $result_unique['result']['count_login'] > 0) {
            $condition_data['condition'] = true;

            if ($result_unique['result']['count_empno'] > 0) {
                $condition_data['message']  = "รหัสประจำตัวซ้ำ";
            } else if ($result_unique['result']['count_login'] > 0) {
                $condition_data['message']  = "รหัสผู้ใช้งานซ้ำ";
            }
        }
    } else if ($condition_unique == "UPD_EMPL") {
        if ($result_unique['result']['count_empno'] > 0 || $result_unique['result']['count_login'] > 0) {

            if ($result_unique['result']['count_empno'] > 0) {
                if ($result_data['empno'] !== $result_data['old_empno']) {
                    $condition_data['condition'] = true;
                    $condition_data['message']  = "รหัสประจำตัวซ้ำ";
                }
            }
            if ($result_unique['result']['count_login'] > 0) {
                if ($result_data['login'] !== $result_data['old_login']) {
                    $condition_data['condition'] = true;
                    $condition_data['message']  = "รหัสผู้ใช้งานซ้ำ";
                }
            }
        }
    }
    return $condition_data;
}

function DataMapping($data,$condition,$replace)
{
    foreach ($data as &$item) {
        if($condition == '0089'){
            $item['invreqhd'] = $replace;
        }
    }

    return $data;
}