<meta charset="utf-8">

<title>@yield("html_title", "Scuti")</title>

<meta name="description" content="">

<meta name="author" content="">

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

<link rel="stylesheet" href="{{url('bower_components/air-datepicker/dist/css/datepicker.min.css')}}">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/themes/smoothness/jquery-ui.css" />

<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css" rel="stylesheet">

<link rel="stylesheet" href="{{ asset('/css/jquery.mloading.css') }}">

<link rel="stylesheet" href="{{url('css/datatable.css')}}">

<link rel="stylesheet" type="text/css" href="{{ asset('css/style.css?t=').time() }}">

@stack("css")
