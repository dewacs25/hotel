<?php 

return [
    'serverKey'=>env('MIDTRANS_SERVERKEY'),
        // Midtrans client Key
    'clientKey'=>env('MIDTRANS_CLIENTKEY'),
        //isi false jika masih dalam tahap dev isi true jika sudah dalam tahap production
    'isProduction'=>env('MIDTRANS_IS_PRODUCTION', false),
];
