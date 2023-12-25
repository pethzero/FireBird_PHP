<?php

function database_config($key)
{
    $configurations = [
        'fbserver' => ['firebird', '192.168.1.28', 'SAN', 'SYSDBA', 'masterkey'],
        'fbtest' => ['firebird', 'localhost', 'SAN', 'SYSDBA', 'masterkey'],
        'sanserver' => ['mysql', 'localhost', 'SAN', 'root', '1234'],
        // เพิ่มค่าอื่นๆ ตามต้องการ
    ];

    return $configurations[$key] ?? null;
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
