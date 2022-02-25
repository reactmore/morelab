<!DOCTYPE HTML>
<html lang="en">

<head>
    <title><?php echo get_general_settings()->maintenance_mode_title; ?> - <?php echo get_general_settings()->application_name; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400&display=swap" rel="stylesheet">

    <style>
        html {
            height: 100%;
            width: 100%;
            overflow-x: hidden;
        }

        body {
            width: 100%;
            height: 100%;
            overflow-x: hidden;
            font-family: 'Open Sans', sans-serif;
            font-size: 14px;
            font-weight: 300;
            word-wrap: break-word;
            color: #fff;
            margin: 0;
            padding: 0;
        }

        .site-title {
            position: absolute;
            top: 100px;
            left: 0;
            right: 0;
            font-size: 56px;
            font-weight: 300;
        }

        .title {
            font-size: 52px;
            line-height: 52px;
        }

        .description {
            max-width: 700px;
            margin: 0 auto;
            font-size: 20px;
            line-height: 28px;
        }

        .maintenance {
            position: relative;
            width: 100%;
            height: 100%;
            text-align: center;
            background-size: cover;
            background-image: url('/assets/img/maintenance_bg.jpg');
            z-index: 1;
        }

        .maintenance:after {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            content: '';
            z-index: -1;
            background-color: rgba(0, 0, 0, .4);
        }

        .maintenance-inner {
            display: table;
            height: 100%;
            width: 100%;
        }

        .maintenance-inner .content {
            display: table-cell;
            vertical-align: middle;
            padding: 20px;
        }

        @media (max-width: 991px) {
            .site-title {
                font-size: 64px;
                position: relative;
                top: -60px;
            }
        }
    </style>

</head>

<body>

    <div class="maintenance">
        <div class="maintenance-inner">
            <div class="content">
                <h1 class="site-title"><?php echo get_general_settings()->application_name; ?></h1>
                <h2 class="title"><?php echo get_general_settings()->maintenance_mode_title; ?></h2>
                <p class="description"><?php echo get_general_settings()->maintenance_mode_description; ?></p>
            </div>
        </div>
    </div>

</body>

</html>

<?php exit(); ?>