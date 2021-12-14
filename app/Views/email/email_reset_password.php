<!doctype html>
<html>

<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?php echo trans("reset_password"); ?></title>
    <style>
        /* -------------------------------------
            GLOBAL RESETS
        ------------------------------------- */
        img {
            border: none;
            -ms-interpolation-mode: bicubic;
            max-width: 100%;
        }

        body {
            background-color: #f6f6f6;
            font-family: sans-serif;
            -webkit-font-smoothing: antialiased;
            font-size: 14px;
            line-height: 1.4;
            margin: 0;
            padding: 0;
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        table {
            border-collapse: separate;
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
            width: 100%;
        }

        table td {
            font-family: sans-serif;
            font-size: 14px;
            vertical-align: top;
        }

        /* -------------------------------------
            BODY & CONTAINER
        ------------------------------------- */

        .body {
            background-color: #f6f6f6;
            width: 100%;
        }

        /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
        .container {
            display: block;
            Margin: 0 auto !important;
            /* makes it centered */
            max-width: 640px;
            padding: 10px;
            width: 640px;
        }

        /* This should also be a block element, so that it will fill 100% of the .container */
        .content {
            box-sizing: border-box;
            display: block;
            Margin: 0 auto;
            max-width: 640px;
            padding: 10px;
        }

        /* -------------------------------------
            HEADER, FOOTER, MAIN
        ------------------------------------- */
        .main {
            background: #ffffff;
            border-radius: 3px;
            width: 100%;
        }

        .wrapper {
            box-sizing: border-box;
            padding: 30px 20px;
        }

        .content-block {
            padding-bottom: 10px;
            padding-top: 10px;
        }

        .footer {
            clear: both;
            Margin-top: 10px;
            text-align: center;
            width: 100%;
        }

        .footer td,
        .footer p,
        .footer span,
        .footer a {
            color: #999999;
            font-size: 12px;
            text-align: center;
        }

        /* -------------------------------------
            TYPOGRAPHY
        ------------------------------------- */
        h1,
        h2,
        h3,
        h4 {
            color: #000000;
            font-family: sans-serif;
            font-weight: 400;
            line-height: 1.4;
            margin: 0;
            margin-bottom: 30px;
        }

        h1 {
            font-size: 35px;
            font-weight: 300;
            text-align: center;
            text-transform: capitalize;
        }

        p,
        ul,
        ol {
            font-family: sans-serif;
            font-size: 14px;
            font-weight: normal;
            margin: 0;
            margin-bottom: 15px;
        }

        p li,
        ul li,
        ol li {
            list-style-position: inside;
            margin-left: 5px;
        }

        a {
            color: #1abc9c;
            text-decoration: underline;
        }

        /* -------------------------------------
            BUTTONS
        ------------------------------------- */
        .btn {
            box-sizing: border-box;
            width: 100%;
        }

        .btn>tbody>tr>td {
            padding-bottom: 15px;
        }

        .btn table {
            width: auto;
        }

        .btn table td {
            background-color: #ffffff;
            border-radius: 5px;
            text-align: center;
        }

        .btn a {
            background-color: #ffffff;
            border: solid 1px #1abc9c;
            border-radius: 5px;
            box-sizing: border-box;
            color: #1abc9c;
            cursor: pointer;
            display: inline-block;
            font-size: 14px;
            font-weight: bold;
            margin: 0;
            padding: 12px 25px;
            text-decoration: none;
            text-transform: capitalize;
        }

        .btn-primary table td {
            background-color: #1abc9c;
        }

        .btn-primary a {
            background-color: #1abc9c;
            border-color: #1abc9c;
            color: #ffffff;
        }

        /* -------------------------------------
            OTHER STYLES THAT MIGHT BE USEFUL
        ------------------------------------- */
        .last {
            margin-bottom: 0;
        }

        .first {
            margin-top: 0;
        }

        .align-center {
            text-align: center;
        }

        .align-right {
            text-align: right;
        }

        .align-left {
            text-align: left;
        }

        .clear {
            clear: both;
        }

        .mt0 {
            margin-top: 0;
        }

        .mb0 {
            margin-bottom: 0;
        }

        .preheader {
            color: transparent;
            display: none;
            height: 0;
            max-height: 0;
            max-width: 0;
            opacity: 0;
            overflow: hidden;
            mso-hide: all;
            visibility: hidden;
            width: 0;
        }

        .powered-by a {
            text-decoration: none;
        }

        hr {
            border: 0;
            border-bottom: 1px solid #f6f6f6;
            margin: 20px 0;
        }

        /* -------------------------------------
            RESPONSIVE AND MOBILE FRIENDLY STYLES
        ------------------------------------- */
        @media only screen and (max-width: 620px) {
            table[class=body] h1 {
                font-size: 28px !important;
                margin-bottom: 10px !important;
            }

            table[class=body] p,
            table[class=body] ul,
            table[class=body] ol,
            table[class=body] td,
            table[class=body] span,
            table[class=body] a {
                font-size: 16px !important;
            }

            table[class=body] .wrapper,
            table[class=body] .article {
                padding: 10px !important;
            }

            table[class=body] .content {
                padding: 0 !important;
            }

            table[class=body] .container {
                padding: 0 !important;
                width: 100% !important;
            }

            table[class=body] .main {
                border-left-width: 0 !important;
                border-radius: 0 !important;
                border-right-width: 0 !important;
            }

            table[class=body] .btn table {
                width: 100% !important;
            }

            table[class=body] .btn a {
                width: 100% !important;
            }

            table[class=body] .img-responsive {
                height: auto !important;
                max-width: 100% !important;
                width: auto !important;
            }
        }

        /* -------------------------------------
            PRESERVE THESE STYLES IN THE HEAD
        ------------------------------------- */
        @media all {
            .ExternalClass {
                width: 100%;
            }

            .ExternalClass,
            .ExternalClass p,
            .ExternalClass span,
            .ExternalClass font,
            .ExternalClass td,
            .ExternalClass div {
                line-height: 100%;
            }

            .apple-link a {
                color: inherit !important;
                font-family: inherit !important;
                font-size: inherit !important;
                font-weight: inherit !important;
                line-height: inherit !important;
                text-decoration: none !important;
            }

            .btn-primary table td:hover {
                background-color: #1abc9c !important;
            }

            .btn-primary a:hover {
                background-color: #1abc9c !important;
                border-color: #1abc9c !important;
            }
        }
    </style>
</head>

<body class="">

    <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body">
        <tr>
            <td>&nbsp;</td>
            <td class="container">
                <div class="content">
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body">
                        <tr>
                            <td style="text-align: center;">
                                <div style="height: 70px;width:100%;text-align: center;margin-bottom: 10px;">
                                    <a href="<?php echo base_url(); ?>">
                                        <img src="<?php echo get_logo_email($this->visual_settings); ?>" alt="" style="max-width: 180px;max-height: 70px;">
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <!-- START CENTERED WHITE CONTAINER -->
                    <table role="presentation" class="main">
                        <!-- START MAIN CONTENT AREA -->
                        <tr>
                            <td class="wrapper">
                                <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td>
                                            <h1 style="text-decoration: none; font-size: 24px;line-height: 28px;font-weight: bold"><?php echo trans("reset_password"); ?></h1>
                                            <div class="mailcontent" style="line-height: 26px;font-size: 14px;">
                                                <p style='text-align: center'>
                                                    <?php echo trans("email_reset_password"); ?><br>
                                                </p>
                                                <p style='text-align: center;margin-top: 30px;'>
                                                    <a href="<?php echo generate_url('reset_password'); ?>?token=<?php echo $token; ?>" style='font-size: 14px;text-decoration: none;padding: 14px 40px;background-color: #1abc9c;color: #ffffff !important; border-radius: 3px;'>
                                                        <?php echo trans("reset_password"); ?>
                                                    </a>
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <!-- END MAIN CONTENT AREA -->
                    </table>

                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="margin-top: 10px;">
                        <tr>
                            <td class="content-block" style="text-align: center;width: 100%;">
                                <?php if (!empty($this->settings->facebook_url)) : ?>
                                    <a href="<?php echo html_escape($this->settings->facebook_url); ?>" target="_blank" style="color: transparent;margin-right: 5px;">
                                        <img src="<?php echo base_url(); ?>assets/images/social-icons/facebook.png" alt="" style="width: 28px; height: 28px;" />
                                    </a>
                                <?php endif; ?>
                                <?php if (!empty($this->settings->twitter_url)) : ?>
                                    <a href="<?php echo html_escape($this->settings->twitter_url); ?>" target="_blank" style="color: transparent;margin-right: 5px;">
                                        <img src="<?php echo base_url(); ?>assets/images/social-icons/twitter.png" alt="" style="width: 28px; height: 28px;" />
                                    </a>
                                <?php endif; ?>
                                <?php if (!empty($this->settings->pinterest_url)) : ?>
                                    <a href="<?php echo html_escape($this->settings->pinterest_url); ?>" target="_blank" style="color: transparent;margin-right: 5px;">
                                        <img src="<?php echo base_url(); ?>assets/images/social-icons/pinterest.png" alt="" style="width: 28px; height: 28px;" />
                                    </a>
                                <?php endif; ?>
                                <?php if (!empty($this->settings->instagram_url)) : ?>
                                    <a href="<?php echo html_escape($this->settings->instagram_url); ?>" target="_blank" style="color: transparent;margin-right: 5px;">
                                        <img src="<?php echo base_url(); ?>assets/images/social-icons/instagram.png" alt="" style="width: 28px; height: 28px;" />
                                    </a>
                                <?php endif; ?>
                                <?php if (!empty($this->settings->linkedin_url)) : ?>
                                    <a href="<?php echo html_escape($this->settings->linkedin_url); ?>" target="_blank" style="color: transparent;margin-right: 5px;">
                                        <img src="<?php echo base_url(); ?>assets/images/social-icons/linkedin.png" alt="" style="width: 28px; height: 28px;" />
                                    </a>
                                <?php endif; ?>
                                <?php if (!empty($this->settings->vk_url)) : ?>
                                    <a href="<?php echo html_escape($this->settings->vk_url); ?>" target="_blank" style="color: transparent;margin-right: 5px;">
                                        <img src="<?php echo base_url(); ?>assets/images/social-icons/vk.png" alt="" style="width: 28px; height: 28px;" />
                                    </a>
                                <?php endif; ?>
                                <?php if (!empty($this->settings->youtube_url)) : ?>
                                    <a href="<?php echo html_escape($this->settings->youtube_url); ?>" target="_blank" style="color: transparent;margin-right: 5px;">
                                        <img src="<?php echo base_url(); ?>assets/images/social-icons/youtube.png" alt="" style="width: 28px; height: 28px;" />
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>

                    <!-- START FOOTER -->
                    <div class="footer">
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td class="content-block powered-by">
                                    <span class="apple-link"><?php echo html_escape($this->settings->contact_address); ?></span><br>
                                    <?php echo html_escape($this->settings->copyright); ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <!-- END FOOTER -->

                    <!-- END CENTERED WHITE CONTAINER -->
                </div>
            </td>
            <td>&nbsp;</td>
        </tr>
    </table>

    <style>
        .wrapper table tr td img {
            height: auto !important;
        }
    </style>
</body>

</html>