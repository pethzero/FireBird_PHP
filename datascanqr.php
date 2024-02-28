<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
    <script src="assets/js/color-modes.js"></script>

    <?php
    session_start();
    if (!isset($_SESSION["RECNO"])) {
        header("Location: index.php"); // ตัวอย่างการเด้งไปยังหน้า login.php
        exit(); // ออกจากสคริปต์เพื่อหยุดการทำงานต่อ
    }
    include("0_headcss.php");
    ?>
    <link rel="preload" href="css/loader.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="preload" href="css/fixedColumns.dataTables.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            width: 100%;
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }

        .btn-bd-primary {
            --bd-violet-bg: #712cf9;
            --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

            --bs-btn-font-weight: 600;
            --bs-btn-color: var(--bs-white);
            --bs-btn-bg: var(--bd-violet-bg);
            --bs-btn-border-color: var(--bd-violet-bg);
            --bs-btn-hover-color: var(--bs-white);
            --bs-btn-hover-bg: #6528e0;
            --bs-btn-hover-border-color: #6528e0;
            --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
            --bs-btn-active-color: var(--bs-btn-hover-color);
            --bs-btn-active-bg: #5a23c8;
            --bs-btn-active-border-color: #5a23c8;
        }

        .bd-mode-toggle {
            z-index: 1500;
        }

        .c_activity {
            width: 100px;
        }

        .h_textarea {
            height: 110px;
        }

        textarea {
            overflow-y: scroll;
        }

        .datepicker td,
        th {
            text-align: center;
            padding: 8px 12px;
            font-size: 14px;
        }

        .datepicker {
            border: 1px solid black;
        }
    </style>
    <link href="layout/bs5/dashboard.css" rel="stylesheet">
</head>

<body>
    <?php
    include("0_dbheader.php");
    ?>
    <div class="container- ">
        <div class="row">
            <?php include("0_sidebar.php"); ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <form id="idForm" method="POST">
                    <section>
                        <div class="row pt-2 mb-2">
                            <div class="col-md-12">
                                <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                                    <div class="col p-4 d-flex flex-column position-static">
                                        <div class="row">
                                            <h2>สแกนรายการ</h2>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </form>
            </main>
        </div>
    </div>
</body>
<div class="loading" style="display: none;"></div>
<?php include("0_footerjs_piority.php"); ?>
<script src="js/qrcode.js"></script>
<script>
    $(document).ready(function() {

        /////////////////////////////////////////////////////////////// INITOPEATION /////////////////////////////////////////////////////////
        $(window).keydown(function(event) {
            if (event.keyCode == 13 && !$(event.target).is('textarea')) {
                event.preventDefault();
                return false;
            }
        });
        $('.loading').show();
        var datasave = '';
        ////////////////////////////////////////////////////
        var ParamHead = [null];
        ////////////////////////////////////////////////////
       
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        class DataFetcher {
            constructor() {

            }
            async AlertSave() {
                try {
              
                } catch (error) {
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
                        body: set_formdata(section),
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
        //////////////////////////////////////////////////////////////// TABLE  ////////////////////////////////////////////////////////////////
      
        // ใช้งาน class
        var max_data;
        const dataFetcher = new DataFetcher();
        dataFetcher.ParamCustomize().then(async (processstatus) => {
            const jsonDataHD = await dataFetcher.fetchData('ajax/new_fecth_oitem_fb.php', 'select', true);
            console.log(jsonDataHD);
        }).catch((error) => {
            console.error(error);
        }).finally(() => {
            $('.loading').hide();
        });

    


        function createNewApidata() {
            return [{
                method: null,
                queryID: null,
                condition: null,
                tbanme: null,
                listdata: null
            }];
        }

        var apidata;

        function set_formdata(conditionsformdata) {
            apidata = createNewApidata();

            var formData = new FormData();
            if (conditionsformdata == "select") {
                apidata[0].method = "GET";
                apidata[0].queryID = "SEL_INVENT_DR";
                apidata[0].condition = "0000";
                apidata[0].tbanme = "0000";
                apidata[0].listdata = [null];
            } else {}
            formData.append('apidata', JSON.stringify(apidata));
            console.log(apidata);
            ////////////////
            return formData;
        }

        ////////////////////////////////////////////////// miscellaneous //////////////////////////////////////////////////
        function search_datalist(data) {
            // console.log(data)
            // const fieldMappings = {
            //     name: 'PRODNAME',
            //     constqaun: 'QUAN',
            //     pcost: 'COSTAMT',
            //     psell: 'SALEAMT'
            // };

            // // ParamHead[1].invent = parseInt(recnoValue);
            // const data_list = data;
            // Object.entries(fieldMappings).forEach(([elementId, fieldName]) => {
            //     const fieldValue = data_list[fieldName] ?? '';
            //     $(`#${elementId}`).val(fieldValue);

            // });

        
        }

    

        /////////////////////////////////////////////////////////////////////////////////////////////////////////////

        /////////////////////////////////////////////////////////////////////////////////////////////////////////
    });
</script>

</html>