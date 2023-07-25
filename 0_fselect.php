<?php

function executeAndDisplayOptions($pdo, $sql,$sysid)
{   
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $fire_database = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Check if any records were returned
    if (count($fire_database) > 0)
    {
        // Display the data
        foreach ($fire_database as $row)
        {   
            if($sysid=='CUST_LIST')
            {
             echo '<option value="' . $row['RECNO'] . '">' . "รหัส ". iconv('TIS-620', 'UTF-8//TRANSLIT//IGNORE',$row['CODE'].":".$row['NAME']) . "</option>";
            }
        }
    }
}
?>
