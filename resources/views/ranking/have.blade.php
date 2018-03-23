@extends('layouts.app')

@section('content')
    <h1>購入済みランキング</h1>
    @include('items.items', ['items' => $items])
@endsection