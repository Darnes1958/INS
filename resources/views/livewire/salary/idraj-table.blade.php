<div class="card ">

  <div class="card-body">
    <table class="table table-sm table-bordered table-striped " width="100%"  id="mytable3" >
      <thead class="font-size-12 bg-primary text-white" >
      <tr >
        <th width="12%">الرقم الألي</th>
        <th >الإسم</th>
        <th width="12%">المرتب</th>
        <th width="25%">الحالة</th>

      </tr>
      </thead>
      <tbody id="addRow" class="addRow">
      @foreach($TableList as  $item)
        <tr class="font-size-12">

          <td>{{$item->id}}</td>
          <td>{{$item->Name}}</td>
          <td>{{$item->Sal}}</td>

          @if($item->SalCase==1)
            <td  style="padding-top: 2px;padding-bottom: 2px; ">
              <i wire:click="ChangeCase({{ $item->id }},0)"
                 class="btn btn-outline-success btn-sm  fa fa-check editable-input" style="margin-left: 2px;"></i>
            </td>
          @else
            <td  style="padding-top: 2px;padding-bottom: 2px; ">
              <i wire:click="ChangeCase({{ $item->id }},1)"
                 class="btn btn-outline-danger btn-sm  fa fa-ban editable-input" style="margin-left: 2px;"></i>
            </td>
          @endif
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


