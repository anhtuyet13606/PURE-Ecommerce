<?php
return ['vnpay'=>['tmn_code'=>env('VNPay_TmnCode'),'hash_secret'=>env('VNPay_HashSecret'),'url'=>env('VNPay_Url','https://sandbox.vnpayment.vn/paymentv2/vpcpay.html')],'momo'=>['partner_code'=>env('MOMO_PARTNER_CODE'),'access_key'=>env('MOMO_ACCESS_KEY'),'secret_key'=>env('MOMO_SECRET_KEY'),'endpoint'=>env('MOMO_ENDPOINT','https://test-payment.momo.vn/v2/gateway/api/create')]];
