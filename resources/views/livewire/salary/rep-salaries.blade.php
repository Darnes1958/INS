<div x-data= "{open:  @entangle('PlaceChk')}" class="card ">
  <div class="card-header " style="background: #0e8cdb;color: white;">شاشة عرض المرتبات</div>
  <div class="card-body">
    <div  class="d-inline-flex my-1 " >
      <div style="width: 40%">
        <div class="d-inline-flex  ">

          <label  class="form-label-me mx-1" >السنة</label>
          <input wire:model="Y" class="form-control mx-1 text-center" type="number"    id="year"   >

          <label  class="form-label-me mx-1">الشهر</label>
          <input wire:model="M"
                 class="form-control mx-1 text-center" type="number"    id="month"  autofocus>
        </div>

      </div>
      <div style="width: 16%; margin-right: 10px;" >
                <div class="form-check form-check-inline">
                    <input class="form-check-input"  name="placechk" type="checkbox" wire:model="PlaceChk"  >
                    <label class="form-check-me " style="font-size: 9pt;">مكان العمل</label>

                </div>
      </div>
      <div x-show="open" style="width: 40%">
            @livewire('masr.masr-center-select')
      </div>

    </div >
    <table class="table table-sm table-bordered table-striped " width="100%"  >
      <thead class="font-size-12 bg-primary text-white" >
      <tr >
        <th width="8%">الرقم الألي</th>
        <th >الإسم</th>
        <th width="8%">المرتب</th>
        <th width="8%">اضافة</th>
        <th width="8%">خصم</th>
        <th width="16%">سحب خلال الشهر</th>
        <th width="8%">الرصيد</th>
        <th width="20%">محمل علي</th>
      </tr>
      </thead>
      <tbody id="addRow" class="addRow">
      @foreach($TableList as  $item)
        <tr class="font-size-12">
          <td>{{$item->id}}</td>
          <td>{{$item->Name}}</td>
          <td>{{$item->Sal}}</td>
          <td>{{$item->idafa}}</td>
          <td>{{$item->ksm}}</td>
          <td>{{$item->saheb}}</td>
          <td>{{$item->raseed}}</td>
          <td>{{$item->CenterName}}</td>
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
        $(document).ready(function ()
        {
            $('#Center_L').select2({
                closeOnSelect: true
            });
            $('#Center_L').on('change', function (e) {
                var data = $('#Center_L').select2("val");
            @this.set('CenterNo', data);
            @this.set('TheCenterListIsSelected',1);
            });
        });
        window.livewire.on('center-change-event',()=>{
            $('#Center_L').select2({
                closeOnSelect: true
            });
        });
    </script>
@endpush
