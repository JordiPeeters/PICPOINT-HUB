<!-- 
// $output = shell_exec('rundll32    shimgvw.dll    ImageView_PrintTo /pt   C:xampp\htdocs\picpoint\copyhere\init.JPG  "Canon TS8300 series"');
// echo "<pre>$output</pre>";

<html>
    <head>
        <title>Print image</title>
        <style>
            /* override styles when printing */
            @media print {
                html {
                    margin: 0;
                }
                body {
                    margin: 0;
                    color: #000;
                    background-color: #fff;
                }
                .img {
                    height: 550px;
                    width: auto;
                    background-size: cover;
                    background-position: center;
                    background-repeat: no-repeat;
                    -webkit-print-color-adjust: exact;
                }
                @page {
                    margin: 0;
                }
 
                }
            }
        </style>
    <head>
    <body>
        <div class="img" style="
                background-image: url('<?=$_GET['url']?>');
                height: 618px;
                width: auto;
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                border: 20px solid #fcfd86;
                border-bottom-width: 46px;
                filter: saturate(1.2) contrast(1.1);"
        ></div>
        <img src="../logomagic.png" style="
            position: absolute;
            width: 30vw;
            left: 35vw;
            bottom: 2.9vw;
        ">
    </body>
    <script>
        window.addEventListener('afterprint', (event) => {
            console.log('After print');
            window.close();
        });
    </script>
</html> -->

<?php
$imageUrl = $_GET['url'] ?? 'default.jpg'; // fallback to avoid errors
?>
<!DOCTYPE html>
<html>
<head>
    <title>Print Image</title>
</head>
<body onload="window.print();" onafterprint="window.close();">
    <div style="position: relative; width: fit-content;">
        <!-- Main Image -->
        <img src="<?= htmlspecialchars($imageUrl) ?>" style="display: block; width: 100%;">

        <!-- PNG Overlay -->
        <img src="../Printoverlay/Printoverlay.png" style="position: absolute; top: 0; left: 0; width: 100%; pointer-events: none;">
    </div>
</body>
</html>
