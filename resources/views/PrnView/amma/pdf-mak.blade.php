@extends('PrnView.PrnMaster')

@section('mainrep')
  <div  >
    @foreach($item_type as $key=> $item)
    @php
      $type_name=$item->type_name;
      $filter = $res->filter(function ($items) use ($type_name) {
      return $items->type_name==$type_name;
      });
    @endphp
    <table style="border-collapse:collapse;"  >

      <caption>{{$type_name}}</caption>
      <thead>
      <tr style="background:lightgray">

        <th style="width: 12%">الرصيد</th>
        <th style="width: 30%">رصيد {{$item->place_name}}</th>
        <th style="width: 14%">سعر البيع</th>
        <th >اسم الصنف</th>
        <th style="width: 12%">رقم الصنف</th>
      </tr>
      </thead>
      <tbody style="margin-bottom: 40px; ">
      @foreach($filter as $key => $item)
        <tr class="font-size-12">
            <td>  {{ $item->raseed }}</td>
          <td>  {{ $item->place_ras }}</td>
          <td> {{ $item->price_sell }} </td>
          <td> {{ $item->item_name }} </td>
          <td> {{ $item->item_no }} </td>
        </tr>

      @endforeach
      </tbody>
    </table>

    @endforeach
  </div>
@endsection

