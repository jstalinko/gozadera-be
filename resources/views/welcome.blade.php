<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gozadera Indonesia</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background:url('{{ asset('bg.png') }}') repeat center center fixed;
            background-size: cover;
            

        }
        h1 {
            text-align: center;
            padding: 20px;
            color: #fff;
            font-size: 50px;
        }
        </style>
</head>
<body>
    <img src="{{ asset('logo.png') }}" alt="Gozadera Indonesia" style="display: block; margin: 0 auto; padding: 20px;">
    <h1>Welcome to Gozadera Indonesia</h1>

    <!-- button menu & login -->
    <div style="text-align: center;">
        <a href="https://gozadera.id" style="padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; margin: 10px;">Menu</a>
        <a href="/admin/login" style="padding: 10px 20px; background-color: #f44336; color: white; text-decoration: none; margin: 10px;">Login</a>
    </div>

   <div style="text-align: center; padding: 20px;">
    <a  href='https://play.google.com/store/apps/details?id=app.gozadera.id&pcampaignid=pcampaignidMKT-Other-global-all-co-prtnr-py-PartBadge-Mar2515-1'><img alt='Get it on Google Play' src='https://play.google.com/intl/en_us/badges/static/images/badges/en_badge_web_generic.png' style="max-width: 200px"/></a><br>
    <a href="#"><img src="{{ asset('appstore.png') }}" alt="Download on the App Store" style="max-width: 180px"></a>
   </div>
</body>
</html>