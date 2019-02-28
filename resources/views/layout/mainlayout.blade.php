<!DOCTYPE html>
<html lang="en">
 <head>
   @include('layout.partials.head')
 </head>
 <body>
@include('layout.partials.nav')
@include('layout.partials.header')
<div class="col-xs-4 col-sm-4 col-md-6 col-lg-12">
<div class="container text-center margin-auto">
@yield('content')
</div>
</div>
<div class="col-xs-4 col-sm-4 col-md-6 col-lg-6">
<div class="container text-center margin-auto">
</div>
</div>
<div class="col-xs-4 col-sm-4 col-md-6 col-lg-6">
</div>
@include('layout.partials.footer')
@include('layout.partials.footer-scripts')
 </body>
</html>