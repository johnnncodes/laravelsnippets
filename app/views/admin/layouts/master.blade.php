<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>LaravelSnippets - Admin</title>

    <!-- Bootstrap Core CSS -->
    {{ HTML::style('//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css') }}

    <!-- MetisMenu CSS -->
    {{ HTML::style('//cdnjs.cloudflare.com/ajax/libs/metisMenu/2.0.0/metisMenu.min.css') }}

    <!-- Timeline CSS -->
    {{ HTML::style('//cdnjs.cloudflare.com/ajax/libs/metisMenu/2.0.0/metisMenu.min.css') }}
    <link href="/administration/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/administration/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    {{ HTML::style('//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css') }}

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<div id="wrapper">

    <!-- Navigation -->
    @include('admin.partials.navbar')

    <div id="page-wrapper">
        @yield('content')
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- jQuery -->
{{ HTML::script( asset('assets/js/vendors/jquery.min.js') ) }}

<!-- Bootstrap Core JavaScript -->
{{ HTML::script('//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js') }}

<!-- Metis Menu Plugin JavaScript -->
{{ HTML::script('//cdnjs.cloudflare.com/ajax/libs/metisMenu/2.0.0/metisMenu.min.js') }}

<!-- Custom Theme JavaScript -->
{{ HTML::script('/administration/js/sb-admin-2.js') }}

</body>

</html>
