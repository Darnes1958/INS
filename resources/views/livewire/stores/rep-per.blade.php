<div class="row">
  <div x-data class="col-md-6 my-2"  >
    <div   class="row g-3 " style="border:1px solid lightgray;background: white;">
      <div class="col-md-12" >
        @livewire('stores.per-select')
      </div>
      <div class="col-md-6">
        <div class="row">
          <div class="col-md-4">
            <label  class="form-label ">رقم اذن الصرف</label>
          </div>
          <div class="col-md-8">
            <input wire:model="per_no"  wire:keydown.enter="ChkPerNoAndGo" type="number" class=" form-control "
                   id="per_no"    >
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="row">
          <div class="col-md-4">
            <label  class="form-label">التاريخ</label>
          </div>
          <div class="col-md-8">
            <input wire:model="exp_date"
                   class="form-control  "   type="date"  id="exp_date" readonly>
          </div>
        </div>
      </div>

      <div class="col-md-12">
        <div class="row">
          <div class="col-md-2">
            <label   class="form-label" >نوع الاذن</label>
          </div>
          <div class="col-md-10">
            <input wire:model="per_type_name"   type="text" class=" form-control "     readonly >
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-2">
            <label   class="form-label ">مــــــــن</label>
          </div>
          <div class="col-md-2">
            <input wire:model="st_no"   class="form-control" readonly    type="text"   >
          </div>
          <div class="col-md-8">
            <input wire:model="st_name"   class="form-control" readonly    type="text"   >
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-2">
            <label   class="form-label ">إلــــــي</label>
          </div>
          <div class="col-md-2">
            <input wire:model="place_no"   class="form-control" readonly    type="text"   >
          </div>
          <div class="col-md-8">
            <input wire:model="place_name"   class="form-control" readonly    type="text"   >
          </div>
        </div>
      </div>

      <div class="col-md-12 my-3">
        <div class="row">
          <div class="col-md-2">
            <label   class="form-label ">رقم الفاتورة </label>
          </div>
          <div class="col-md-4">
            <input wire:model="order_no"   class="form-control" readonly    type="text"   >
          </div>
          <div class="col-md-6">
            <a  href="{{route('repperpdf',['per_no'=>$per_no])}}"
                class="btn btn-outline-success waves-effect waves-light border-0 mx-2"><i class="fas fa-print"> &nbsp;&nbsp;طباعة&nbsp;&nbsp;</i></a>
          </div>
        </div>
      </div>

    </div>
  </div>


  <div class=" col-md-6" style="border:1px solid lightgray;background: white;">
    <table class="table-sm table-bordered table-bordered " style="width: 100%;">
      <thead>
      <tr style="background: #9dc1d3">
        <th >رقم الصنف</th>
        <th>اسم الصنف </th>
        <th >الكمية</th>
      </tr>
      </thead>
      <tbody >
      @foreach($perdetail as $key => $item)

        <tr >
          <td style="color: #0c63e4; text-align: center"> {{ $item->item_no }} </td>
          <td > {{ $item->item_name }} </td>
          <td style=" text-align: center"> {{ $item->quant }} </td>
        </tr>
      @endforeach
      </tbody>
      <tbody>
    </table><br>
    {{ $perdetail->links() }}
  </div>
</div>

@push('scripts')
  <script type="text/javascript">
      window.addEventListener('mmsg',function(e){
          MyMsg.fire({
              confirmButtonText:  e.detail,
          })
      });
      Livewire.on('gotonext',postid=>  {
          if (postid=='per_no') {  $("#per_no").focus();$("#per_no").select(); };
      })
      $(document).ready(function ()
      {
          $('#Per_L').select2({
              closeOnSelect: true
          });
          $('#Per_L').on('change', function (e) {
              var data = $('#Per_L').select2("val");
          @this.set('per_no', data);
          @this.set('ThePerListSelected',1);
          });
      });
      window.livewire.on('per-change-event',()=>{
          $('#Per_L').select2({
              closeOnSelect: true
          });
      });

  </script>

@endpush
