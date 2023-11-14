$response = array(
            'message' => 'TEST',
            'sqlQuery' => $sqlQuery,
            'tableData_Json' => $tableData_Json,
            'status' => 'test',
            );


            $response = array(
            'result' => $result,
            'message' => 'TEST',
            'sqlQuery' => $sqlQuery,
            'tableData_Json' => $tableData_Json,
            'status' => 'test',
            );


            CRUDSQL('ajax/fecth_item.php', 'select')
      .then(() => {
           console.log('end')
           $("#myModal").modal("show");
          })
          .catch(error => {
            console.error('เกิดข้อผิดพลาดใน CRUDSQL:', error);
          });