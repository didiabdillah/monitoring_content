@if($missed_upload != NULL)
@foreach($missed_upload as $data)
<tr>
    <td>
        {{$loop->iteration}}
    </td>
    <td>
        {{$data->user_name}}
    </td>
    <td>
        {{$data->total}}
    </td>
</tr>
@endforeach
@else
<tr>
    <td colspan="2">
        Data Empty
    </td>

</tr>
@endif