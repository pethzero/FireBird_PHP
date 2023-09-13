<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include("0_headcss.php"); ?>
  </head>
  <body>

  <!-- <form id="myForm"  method="post" action="" enctype="multipart/form-data">
  <h2>อัพโหลดรูปภาพ</h2>
    <div class="mb-3">
        <label for="formFile" class="form-label">Default file input example</label>
        <input class="form-control" type="file" id="formFile">
    </div>
    <button id="submitButton" type="submit">บันทึก</button>
  </form> -->

  <!-- <input id="sortpicture" type="file" name="sortpic" />
  <button id="upload">Upload</button> -->

  <h2>อัพโหลดรูปภาพ</h2>
    <div class="mb-3">
        <label for="formFile" class="form-label">Default file input example</label>
        <input class="form-control" type="file" id="formFile">
    </div>
    <!-- <button id="submitButton" type="submit">บันทึก</button> -->
    <button id="submitButton" type="button">บันทึก</button>

    <?php include("0_footer.php"); ?>
  </body>
  <?php include("0_footerjs.php"); ?>
</html>

<script>
        $(document).ready(function() {
            $("#submitButton").click(function(){
                var formData = new FormData();
                formData.append('image', $('#formFile')[0].files[0]);
                console.log(formData)
                $.ajax({
                    url: "ajax_upload.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        // alert(response);
                        if(response != 0){
                                // $("#img").attr("src",response);
                                alert('File uploaded');
                            }else{
                                alert('File not uploaded');
                            }
                    },
                    error: function(xhr, status, error) {
                        alert("เกิดข้อผิดพลาด: " + error);
                    }
                });
                });
            // $("#myForm").submit(function(e) {
            //     e.preventDefault(); // ป้องกันการรีเฟรชหน้าเว็บ
            //     var formData = new FormData();
            //     formData.append('image', $('#formFile')[0].files[0]);
            //     console.log(formData)
            //     $.ajax({
            //         url: "ajax_upload.php",
            //         type: "POST",
            //         data: formData,
            //         contentType: false,
            //         processData: false,
            //         success: function(response) {
            //             // alert(response);
            //             if(response != 0){
            //                     // $("#img").attr("src",response);
            //                     alert('File uploaded');
            //                 }else{
            //                     alert('File not uploaded');
            //                 }
            //         },
            //         error: function(xhr, status, error) {
            //             alert("เกิดข้อผิดพลาด: " + error);
            //         }
            //     });
            // });
        });

        // $('#upload').on('click', function() {
        //     var file_data = $('#sortpicture').prop('files')[0];   
        //     var form_data = new FormData();                  
        //     form_data.append('file', file_data);
        //     alert(form_data);                             
        //     $.ajax({
        //         url: 'upload.php', // <-- point to server-side PHP script 
        //         dataType: 'text',  // <-- what to expect back from the PHP script, if anything
        //         cache: false,
        //         contentType: false,
        //         processData: false,
        //         data: form_data,                         
        //         type: 'post',
        //         success: function(php_script_response){
        //             alert(php_script_response); // <-- display response from the PHP script, if any
        //         }
        //     });
        // });

    </script>