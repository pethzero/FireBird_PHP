<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
  <?php
             $crumbs = explode("/",$_SERVER["REQUEST_URI"]);
             $datalink = array();
             foreach($crumbs as $index => $crumb)
             {
                 $link = ucfirst(str_replace(array(".php","_"),array("",""),$crumb)); //ucfirst Convert the first character of "hello" to uppercase:
                 if($index == 1)
                 {   
                     $datalink[$index] = '<li class="breadcrumb-item"><a href="index.php">Home</a></li>';
                 }    
                 elseif($index == 2 && $link == '')
                 {   
                    $datalink[1] = '<li class="breadcrumb-item active" aria-current="page">Home</li>';
                    break;
                 }
                 elseif($index == 2 && $link == 'Main')
                 {
                    $datalink[1] = '<li class="breadcrumb-item active" aria-current="page">Home</li>'; 
                    break; 
                 }
                 elseif ($index > 1) 
                 {  
                    if ($index == count($crumbs) - 1) {
                        // โค้ดที่ต้องการในกรณีที่ $index เป็นตัวสุดท้าย
                        $datalink[$index] = '<li class="breadcrumb-item active" aria-current="page">'.$link.'</li>';
                    } else {
                        // โค้ดที่ต้องการในกรณีที่ $index ไม่ใช่ตัวสุดท้าย
                        $datalink[$index] = '   <li class="breadcrumb-item"><a href="'.$link.'php">Library</a></li>';
                    }
                 } 
             }
             foreach ($datalink as $item) {
                echo $item;
            }
         ?>
  </ol>
</nav>

<div>

<div>