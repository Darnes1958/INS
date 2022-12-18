<div >
  <div class="d-flex justify-content-sm-between  my-1"> <input wire:model="search"   type="search"  style="width: 100%" placeholder="ابحث هنا ......."> </div>
  <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
    <thead class="font-size-12">
    <tr>
      <th width="12%">الرقم الألي</th>
      <th width="12%">رقم العقد</th>
      <th width="14%">رقم الحساب</th>
      <th width="24%">الاسم</th>
      <th width="12%">المبلغ</th>
      <th width="5%"></th>
    </tr>
    </thead>
    <tbody id="addRow" class="addRow">
    @foreach($TableList as  $item)
      <tr class="font-size-12">
        <td>{{$item->wrec_no}}</td>
        <td>{{$item->no}}</td>
        <td>{{$item->acc}}</td>
        <td>{{$item->name}}</td>
        <td>{{$item->kst}}</td>

        <td><input class="form-check-input" type="checkbox" wire:model="mychecked.{{$item->wrec_no}}"
                   value="1" id="flexCheckDefault"></td>
      </tr>
    @endforeach
    </tbody>
  </table>
  {{ $TableList->links() }}



</div>


