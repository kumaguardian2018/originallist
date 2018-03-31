@if ($item->alerted)
    <?php $user = \Auth::user(); ?>
    @if ($user && $user->is_admin)
        {!! Form::open(['route' => 'item_user.dont_alert', 'method' => 'delete']) !!}
            {!! Form::hidden('itemCode', $item->code) !!}
            {!! Form::submit('通報解除', ['class' => 'btn btn-success']) !!}
        {!! Form::close() !!}
    @else
        <button class="btn btn-success disabled">通報済み</button>
    @endif
@else
    {!! Form::open(['route' => 'item_user.alert']) !!}
        {!! Form::hidden('itemCode', $item->code) !!}
        {!! Form::submit('通報する', ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
@endif