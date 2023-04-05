<div class="card ">
  <div class="card-header " style="background: #0e8cdb;color: white;">شاشة عرض المرتبات</div>
  <div class="card-body">
    <div  class="d-inline-flex my-2 " >
      <label  class="form-label-me mx-1" >السنة</label>
      <input wire:model="Y" class="form-control mx-1 text-center" type="number"    id="year"   >

      <label  class="form-label-me mx-1">الشهر</label>
      <input wire:model="M" 
             class="form-control mx-1 text-center" type="number"    id="month"  autofocus>
      @error('month') <span class="error">{{ $message }}</span> @enderror
    </div >
    <table class="table table-sm table-bordered table-striped " width="100%"  >
      <thead class="font-size-12 bg-primary text-white" >
      <tr >
        <th width="18%">الرقم الألي</th>
        <th >الإسم</th>
        <th width="16%">المرتب</th>
        <th width="20%">محمل علي</th>
      </tr>
      </thead>
      <tbody id="addRow" class="addRow">
      @foreach($TableList as  $item)
        <tr class="font-size-12">
          <td>{{$item->id}}</td>
          <td>{{$item->Name}}</td>
          <td>{{$item->Sal}}</td>
          <td>{{$item->CenterName}}}</td>
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
