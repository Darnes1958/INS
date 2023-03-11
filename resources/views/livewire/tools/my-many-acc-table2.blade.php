<div >
  <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
    <thead class="font-size-12">
    <tr>
      <th>رقم العقد</th>
      <th>الاسم</th>
      <th>اجمالي التقسيط</th>
      <th>القسط</th>
      <th>المصرف</th>
      <th></th>
    </tr>
    </thead>
    <tbody id="addRow" class="addRow">
    @foreach($TableList as  $item)
      <tr class="font-size-12">
        <td>{{$item->no}}</td>
        <td>{{$item->name}}</td>
        <td>{{$item->sul}}</td>
        <td>{{$item->kst}}</td>
        <td>{{$item->bank_name}}</td>
        <td  style="padding-top: 2px;padding-bottom: 2px; ">
          <i wire:click="selectItem({{ $item->no }}, 'TheNo')" class="btn btn-outline-primary btn-sm far fa-arrow-alt-circle-down editable-input" style="margin-left: 2px;"></i>
        </td>
      </tr>
    @endforeach
    </tbody>
  </table>
  {{ $TableList->links() }}

</div>

