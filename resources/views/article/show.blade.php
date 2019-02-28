@extends('layout.mainlayout')
@section('content')
<h1>{!!$article->title!!}</h1>
<p>{!!$article->content!!}</p>
<p><img src="{!!url($article->image_url.$article->image)!!}" />
@endsection