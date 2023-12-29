<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{\App\CPU\translate('Email Verification')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">
        /**
         * Google webfonts. Recommended to include the .woff version for cross-client compatibility.
         */
        @media screen {
            @font-face {
                font-family: 'Source Sans Pro';
                font-style: normal;
                font-weight: 400;
                src: local('Source Sans Pro Regular'), local('SourceSansPro-Regular'), url(https://fonts.gstatic.com/s/sourcesanspro/v10/ODelI1aHBYDBqgeIAH2zlBM0YzuT7MdOe03otPbuUS0.woff) format('woff');
            }

            @font-face {
                font-family: 'Source Sans Pro';
                font-style: normal;
                font-weight: 700;
                src: local('Source Sans Pro Bold'), local('SourceSansPro-Bold'), url(https://fonts.gstatic.com/s/sourcesanspro/v10/toadOcfmlt9b38dHJxOBGFkQc6VGVFSmCnC_l7QZG60.woff) format('woff');
            }
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
        }

        p {
            color: #666;
        }

        .verification-code {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            text-align: center;
            font-size: 18px;
            margin-top: 20px;
            border-radius: 4px;
        }



        .footer {
            margin-top: 20px;
            text-align: center;
            color: #999;
        }


    </style>
</head>
<body style="background-color: #e9ecef;">

<div class="container">
    <h1>{{\App\CPU\translate('Verify your email')}}</h1>
    <p>Dear Customer,</p>
    <p>Thank you for choosing {{config('app.name')}} platform. To complete your registration, please use the following verification code:</p>
    <div class="verification-code">{{\App\CPU\translate('Token')}} : {{$token}}</div>
    <p>Enter this code on our website to verify your email address and access your account.</p>
    <p class="footer">If you did not register on our platform, please ignore this email.</p>
</div>

</body>
</html>

