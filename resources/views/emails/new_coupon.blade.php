<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('New Discount 🎁') }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5253 100%);
            padding: 40px 20px;
            text-align: center;
            color: white;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
        }
        .content {
            padding: 30px;
            text-align: center;
        }
        .coupon-box {
            display: inline-block;
            background: #f8f9fa;
            border: 2px dashed #ee5253;
            padding: 20px 40px;
            margin: 20px 0;
            border-radius: 8px;
        }
        .coupon-code {
            font-size: 32px;
            font-weight: 800;
            color: #ee5253;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        .details {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
        .btn {
            display: inline-block;
            padding: 14px 30px;
            background: #ee5253;
            color: white;
            text-decoration: none;
            border-radius: 30px;
            font-weight: 600;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ __('Special Offer For You! 🎁') }}</h1>
        </div>
        <div class="content">
            <p class="details">
                {{ __('Hello') }},<br>
                {{ __('We are excited to share a new discount coupon with you! You can use it on your next order through our application.') }}
            </p>
            
            <div class="coupon-box">
                <span class="coupon-code">{{ $coupon->code }}</span>
            </div>

            <p class="details">
                <strong>{{ __('Discount') }}:</strong> 
                {{ $coupon->value }}%
                @if($coupon->min_order_value > 0)
                    <br><small>{{ __('Minimum Order') }}: {{ $coupon->min_order_value }}</small>
                @endif
            </p>

            @if($coupon->end_date)
                <p style="color: #999; font-size: 14px;">
                    {{ __('Valid until') }}: {{ $coupon->end_date->format('Y-m-d') }}
                </p>
            @endif

            <a href="#" class="btn">{{ __('Order Now') }}</a>
        </div>
        <div class="footer">
            {{ __('Thank you for being part of our family!') }}<br>
            &copy; {{ date('Y') }} {{ config('app.name') }}. {{ __('All rights reserved.') }}
        </div>
    </div>
</body>
</html>
