<table class="table table-responsive">
    <thead>
        <th>Note</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($notes as $notes)
        <tr>
            <td>{!! $notes->note !!}</td>
            <td>
                {!! Form::open(['route' => ['notes.destroy', $notes->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('notes.show', [$notes->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('notes.edit', [$notes->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>