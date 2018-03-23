@extends('layouts.app')

@section('content')
    <h1>ほしい物ランキング</h1>
    @include('items.items', ['items' => $items])
@endsection