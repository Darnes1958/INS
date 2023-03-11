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
       <td> <a wire:click="selectItem({{ $item->no }})" href="#">{{$item->no}}</a></td>

        <td><a wire:click="selectItem({{ $item->no }})" href="#">{{$item->name}}</a></td>
        <td><a wire:click="selectItem({{ $item->no }})" href="#">{{$item->sul}}</a></td>
        <td><a wire:click="selectItem({{ $item->no }})" href="#">{{$item->kst}}</a></td>
        <td><a wire:click="selectItem({{ $item->no }})" href="#">{{$item->bank_name}}</a></td>

      </tr>
    @endforeach
    </tbody>
  </table>
  {{ $TableList->links() }}

</div>

