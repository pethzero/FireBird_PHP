<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print A4 Size</title>
    <?php
    include("0_headcss.php");
    
    ?>
    <style>
        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            @page {
                size: A4;
                margin: 10;
            }
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">QR Code Generator</h1>

        <div class="row" id="qrRow"></div>
    </div>

    <?php
    include("0_footerjs_piority.php");
    ?>
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
    <!-- <script src="js/qrcode.js"></script> -->
    <script>
        $(document).ready(function() {
            // Mock data (12 variables)
            const data = [
                "Data1",
                "Data2",
                "Data3",
                "Data4",
                "Data5",
                "Data6",
                "Data7",
                "Data8",
                "Data9",
                "Data10",
                "Data11",
                "Data12"
            ];

            // Create QR codes and append to the row
            const qrRow = $("#qrRow");
            data.forEach(function(item, index) {
                const col = $("<div class='col-sm-3 col-md-3 mb-3 pt-3'></div>");
                const qrCodeCanvas = $("<div class='qr-code' id='qr-code-" + index + "'></div>");
                const foot = $("<div'>5555</div>");
                col.append(qrCodeCanvas);
                col.append(foot);
                qrRow.append(col);
             

                var qrcode = new QRCode(document.getElementById("qr-code-" + index), {
                    text: item,
                    width: 180,
                    height: 180
                });
            });
        });
    </script>
</body>

</html>
