<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="MPWA V5.0.0 ,Whatsapp gateway Multi device Beta version">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="keywords" content="waapi,wa gateway, whatsapp blast, wamp, mpwa, m pedia wa gateway, wa gateway m pedia, ">
    <meta name="author" content="Ilman Sunanuddin , M pedia">
    <!-- The above 6 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title -->
    <title>{{ $title }} | MPWA MD version</title>

    <!-- Styles -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
    <link href="{{asset('plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('plugins/perfectscroll/perfect-scrollbar.css')}}" rel="stylesheet">
    <link href="{{asset('plugins/pace/pace.css')}}" rel="stylesheet">


    <!-- Theme Styles -->
    <link href="{{asset('css/main.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/custom.css')}}" rel="stylesheet">

    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('')}}images/neptune.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('')}}images/neptune.png" />

  
</head>

<body>
{{$slot}}

</body>

    <script src="{{asset('plugins/jquery/jquery-3.5.1.min.js')}}"></script>
<script src="{{asset('plugins/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('plugins/perfectscroll/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('plugins/pace/pace.min.js')}}"></script>
<script src="{{asset('js/main.min.js')}}"></script>
<script src="{{asset('js/custom.js')}}"></script>
</body>

</html>