    <html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=0.6">
        <link rel="stylesheet" href="css/login.css">
        <title>INDUSTRIAL LOGIC</title>
        <?php
        ?>
        <link rel="stylesheet" href="css/bootstrap-5.3.0.min.css">

    </head>

    <?php
    session_start();
    if (isset($_SESSION["RECNO"])) {
        header("Location: main.php"); // ตัวอย่างการเด้งไปยังหน้า login.php
        exit(); // ออกจากสคริปต์เพื่อหยุดการทำงานต่อ
    }
    ?>

    <body>
        <div class="wrapper">
            <div class="title">
                INDUSTRIAL LOGIC
            </div>

            <!-- <form name="formlogin" action="ajax/db_login.php" method="post" id="login"> -->
            <!-- <form name="formlogin" action="ajax_check.php" method="post" id="login"> -->
            <form name="formlogin" id="idForm">
                <div class="field">
                    <input type="text" id='username' name="username" value="<?php echo isset($_COOKIE['remember_username']) ? $_COOKIE['remember_username'] : ''; ?>" required>
                    <label>Username</label>
                </div>

                <div class="field">
                    <input type="password" id='password' name="password" value="<?php echo isset($_COOKIE['remember_password']) ? $_COOKIE['remember_password'] : ''; ?>" required>
                    <label>Password</label>
                </div>

                <div class="content">
                    <div class="checkbox">
                        <input type="checkbox" id="remember-me" <?php echo isset($_COOKIE['remember_check']) ? 'checked' : ''; ?> name="remember">
                        <label for="remember-me">Remember me</label>
                    </div>

                </div>

                <div class="content">
                    <div class="link">
                        <a id="forgotPasswordLink" href="#">Forgot Password?</a>
                    </div>
                </div>



                <div class="field">
                    <input type="submit" value="Login">
                </div>
            </form>
        </div>
    </body>

    <script src="js/jquery-3.7.0.min.js" rel="preload" as="script"></script>
    <script src="js/bootstrap.bundle.min.js" rel="preload" as="script"></script>
    <script src="js/sweetalert2.all.min.js" rel="preload" as="script"></script>

    <script>
        // Example: Show SweetAlert when Forgot Password link is clicked
        class DataFetcher {
            constructor() {

            }
            async AlertSave() {
                try {} catch (error) {
                    console.error(error);
                    return false;
                }
            }
            async ProcessAlert() {
                try {
                    return true;
                } catch (error) {
                    console.error(error);
                }
            }

            async ParamCustomize() {
                try {
                    return true;
                } catch (error) {
                    console.error(error);
                }
            }
            async fetchData(url, section, status) {
                try {
                    // ดึงข้อมูล  จากเซิร์ฟเวอร์
                    const jsonResponse = await fetch(url, {
                        method: 'POST',
                        body: set_formdata(true),
                    });

                    if (!jsonResponse.ok) {
                        throw new Error('Error sending data to server');
                    }
                    const jsonDataHD = await jsonResponse.json();

                    return jsonDataHD; // เพิ่มบรรทัดนี้เพื่อ return ค่า jsonDataHD
                } catch (error) {
                    console.error(error);
                }
            }
        }

        document.getElementById('forgotPasswordLink').addEventListener('click', function(event) {
            event.preventDefault(); // ป้องกันการเปลี่ยนหน้าเว็บ

            Swal.fire({
                title: 'ลืมรหัสผ่าน',
                html: '<img src="images/main/nopermission.jpg"  width="150" height="150"  alt="รูปภาพ"><br><br><h4>แกไม่มีสิทธ์ลืม</h4>',
                // text: 'ตอนนี้ กดได้ เฉยๆ ยังไม่มีอะไรหลอก',
                icon: 'info',
                confirmButtonText: 'OK'
            });
        });

        const dataFetcher = new DataFetcher();

        $("#idForm").submit(function(e) {
            event.preventDefault();
            var clickedButtonName = e.originalEvent.submitter.name;

            console.log($("input[name='username']"))

            dataFetcher.fetchData('ajax/db_login.php', 'add', true).then(async (data) => {

                console.log(data);
                  //  console.log(data['condition']);
                    
                    switch (data['condition']) {
                        case "T":
                            window.location = 'main.php';
                            break;
                        case "W":
                            Swal.fire({
                                title: 'ใส่รหัสผ่านผิด',
                                html: '<img src="images/main/nopermission.jpg"  width="150" height="150"  alt="รูปภาพ"><br><br><h4>แกไม่มีสิทธ์...</h4>',
                                icon: 'info',
                                confirmButtonText: 'OK'
                            });
                            break;
                        default:
                        Swal.fire({
                                title: 'ไม่เจอ User',
                                html: '<img src="images/main/nopermission.jpg"  width="150" height="150"  alt="รูปภาพ"><br><br><h4>แกไม่มีสิทธ์...</h4>',
                                icon: 'info',
                                confirmButtonText: 'OK'
                            });
                    }

                }).catch((error) => {
                    console.error(error);
                })
                .finally(() => {

                });
        });

        function set_formdata(conditionsformdata) {
            var formData = new FormData();
            console.log($('#remember-me')[0].checked)
            formData.append('username', $('#username').val());
            formData.append('password', $('#password').val());
            formData.append('remember', $('#remember-me')[0].checked );
            
            ////////////////
            return formData;
        }
    </script>

    </html>