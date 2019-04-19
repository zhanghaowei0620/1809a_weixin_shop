@foreach($data as $k=>$v)
    <tr>
        <td>{{$v->id}}</td>
        <td>{{$v->goods_name}}</td>
        <td>{{$v->goods_price}}</td>
    </tr>
@endforeach