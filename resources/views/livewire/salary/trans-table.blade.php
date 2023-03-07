<div class="card ">

  <div class="card-body">
    <table class="table table-sm table-bordered table-striped " width="100%"  id="mytable3" >
      <thead class="font-size-12 bg-primary text-white" >
      <tr >
        <th width="10%">الرقم الألي</th>
        <th >الإسم</th>
        <th width="12%">المرتب</th>
        <th width="5%">الحالة</th>
        <th width="12%">خصم</th>
        <th width="12%">إضافة</th>
        <th width="12%">الصافي</th>
        <th width="12%">سحب</th>
        <th width="12%">الرصيد</th>

      </tr>
      </thead>
      <tbody id="addRow" class="addRow">
      @foreach($TableList as  $item)
        <tr class="font-size-12">
          <td ><a wire:click="selectItem({{ $item->id }},{{$item->Sal}},'{{$item->Name}}')" href="#">{{$item->id  }}</a>   </td>
          <td ><a wire:click="selectItem({{ $item->id }},{{$item->Sal}},'{{$item->Name}}')" href="#">{{$item->Name  }}</a>   </td>
          <td ><a wire:click="selectItem({{ $item->id }},{{$item->Sal}},'{{$item->Name}}')" href="#">{{$item->Sal  }}</a>   </td>
          @if($item->SalCase==1)
            <td  style="padding-top: 2px;padding-bottom: 2px; ">
              <i wire:click="selectItem({{ $item->id }},{{$item->Sal}},'{{$item->Name}}')"
                 class="btn btn-outline-success btn-sm  fa fa-check editable-input" style="margin-left: 2px;"></i>
            </td>
          @else
            <td  style="padding-top: 2px;padding-bottom: 2px; ">
              <i wire:click="selectItem({{ $item->id }},{{$item->Sal}},'{{$item->Name}}')"
                 class="btn btn-outline-danger btn-sm  fa fa-ban editable-input" style="margin-left: 2px;"></i>
            </td>

          @endif
          <td ><a wire:click="selectItem({{ $item->id }},{{$item->Sal}},'{{$item->Name}}')" href="#">{{$item->ksm  }}</a>   </td>
          <td ><a wire:click="selectItem({{ $item->id }},{{$item->Sal}},'{{$item->Name}}')" href="#">{{$item->idafa  }}</a>   </td>
          <td ><a wire:click="selectItem({{ $item->id }},{{$item->Sal}},'{{$item->Name}}')" href="#">{{$item->Safi  }}</a>   </td>
          <td ><a wire:click="selectItem({{ $item->id }},{{$item->Sal}},'{{$item->Name}}')" href="#">{{$item->Saheb  }}</a>   </td>
          <td ><a wire:click="selectItem({{ $item->id }},{{$item->Sal}},'{{$item->Name}}')" href="#">{{$item->Raseed  }}</a>   </td>

        </tr>
      @endforeach
      </tbody>
    </table>
    {{ $TableList->links() }}
  </div>

  @push('scripts')
    <script>
        window.addEventListener('mmsg',function(e){
            MyMsg.fire({
                confirmButtonText:  e.detail,
            })
        });



    </script>
@endpush


