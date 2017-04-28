<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Calendar - exercise</title>
    <link href="{{app('url')->asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="{{app('url')->asset('js/html5shiv.min.js')}}"></script>
    <script src="{{app('url')->asset('js/respond.min.js')}}"></script>
    <![endif]-->
</head>
<body class="container">
    <div class="row">
        <div class="col-md-12">
            @section('content')
            @show
        </div>
    </div>
<script src="{{ app('url')->asset('js/jquery-3.2.1.min.js')  }}"></script>
<script src="{{ app('url')->asset('js/bootstrap.min.js') }}"></script>
@stack('scripts')
</body>
</html>
