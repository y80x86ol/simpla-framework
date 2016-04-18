<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Simpla Error</title>
        <style>
            body {
                width: 1000px;
                margin: 0 auto;
                font-weight: 100;
                font-family: 'Microsoft YaHei';
            }
            .container {
                margin-top: 50px;
            }
            .content{
                padding: 10px;
                border: 2px solid #eee;
                border-radius: 10px;
            }
            .title {
                font-size: 20px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title"><?php echo $msg; ?></div>
            </div>
        </div>
    </body>
</html>