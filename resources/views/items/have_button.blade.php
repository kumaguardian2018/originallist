@if (Auth::user()->is_having($item->code))
    {!! Form::open(['route' => 'item_user.dont_have', 'method' => 'delete']) !!}
        {!! Form::hidden('itemCode', $item->code) !!}
        {!! Form::submit('購入済みに追加', ['class' => 'btn btn-success']) !!}
    {!! Form::close() !!}
@else
    {!! Form::open(['route' => 'item_user.have']) !!}
        {!! Form::hidden('itemCode', $item->code) !!}
        {!! Form::submit('購入済みに追加', ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
@endif