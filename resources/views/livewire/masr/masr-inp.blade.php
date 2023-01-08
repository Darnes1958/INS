<div x-data>
    <div  class="row " >
      <div class="col-md-12">
        <label  class="form-label-me">نوع المصروف</label>
      </div>
        <div class="col-md-3">
            <input wire:model="MasTypeNo" wire:keydown.enter="ChkMasType"
                   class="form-control  "   type="text"  id="MasTypeNo" autofocus>
            @error('MasTypeNo') <span class="error">{{ $message }}</span> @enderror
        </div>
      <div class="col-md-1 p-0">

        <button wire:click="OpenAddType" type="button" class="btn btn-outline-primary btn-sm fa fa-plus" data-bs-toggle="modal"></button>
      </div>
      <div class="col-md-8">
          @livewire('masr.masr-type-select')
      </div>
   </div>
    <div class="row  " >
        <div class="col-md-12">
            <label  class="form-label-me">تفاصيل المصروفات</label>
        </div>
        <div class="col-md-3">

            <input wire:model="DetailNo" wire:keydown.enter="ChkDetail"
                   x-bind:disabled="!$wire.MasTypeGeted" class="form-control  "   type="text"  id="DetailNo" autofocus>
            @error('DetailNo') <span class="error">{{ $message }}</span> @enderror
        </div>
        <div class="col-md-1 p-0">

            <button  x-bind:disabled="!$wire.MasTypeGeted" wire:click="OpenAddDetail" type="button" class="btn btn-outline-primary btn-sm fa fa-plus" data-bs-toggle="modal"></button>
        </div>
        <div x-bind:disabled="!$wire.MasTypeGeted" class="col-md-8">

            @livewire('masr.masr-detail-select')
        </div>
    </div>
    <div   class="row " >
        <div class="col-md-12">
            <label  class="form-label-me">مصروفة علي </label>
        </div>
        <div class="col-md-3">

            <input wire:model="CenterNo" wire:keydown.enter="ChkCenter"
                   class="form-control  "   type="text"  id="CenterNo" autofocus>
            @error('CenterNo') <span class="error">{{ $message }}</span> @enderror
        </div>
        <div class="col-md-1 p-0">


        </div>
        <div class="col-md-8">

            @livewire('masr.masr-center-select')

        </div>
    </div>
    <div   class="row  " >
        <div class="col-md-5">
            <label  class="form-label-me">المبلغ </label>
            <input wire:model="Val" wire:keydown.enter="$emit('gotonext','MasDate')"
                   class="form-control  "   type="number"  id="Val" autofocus>
            @error('MasDate') <span class="error">{{ $message }}</span> @enderror
        </div>
    </div>
    <div   class="row  " >
        <div class="col-md-5">
            <label  class="form-label-me">التاريخ </label>
            <input wire:model="MasDate" wire:keydown.enter="$emit('gotonext','Notes')"
                   class="form-control font-size-12 "   type="date"  id="MasDate" autofocus>
            @error('MasDate') <span class="error">{{ $message }}</span> @enderror
        </div>
    </div>
    <div   class="row  " >
        <div class="col-md-12">
            <label  class="form-label-me">ملاحظات </label>
            <input wire:model="Notes" wire:keydown.enter="$emit('gotonext','save-btn')"
                   class="form-control  "   type="test"  id="Notes" autofocus>
        </div>
    </div>
    <div   class="my-4 row justify-content-center ">
      <button  wire:click="Save" class="col-md-4 mx-1 btn btn-primary" id="save-btn">
        تخزين
      </button>
    </div>
    <div class="modal fade" id="ModalAddType" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button wire:click="CloseAddType" type="button" class="btn-close" ></button>
                    <h1 class="modal-title fs-5 mx-6" id="exampleModalLabel">ادخال انواع مصروفات</h1>
                </div>
                <div class="modal-body">
                    @livewire('masr.add-mas-type')
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="ModalAddDetail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button wire:click="CloseAddDetail" type="button" class="btn-close" ></button>
                    <h1 class="modal-title fs-5 mx-6" id="exampleModalLabel">ادخال تفاصيل مصروفات</h1>
                </div>
                <div class="modal-body">
                    @livewire('masr.add-mas-detail')
                </div>
            </div>
        </div>
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

          if (postid=='MasTypeNo') {  $("#MasTypeNo").focus();$("#MasTypeNo").select(); };
          if (postid=='DetailNo') {  $("#DetailNo").focus();$("#DetailNo").select(); };
          if (postid=='CenterNo') {  $("#CenterNo").focus(); $("#CenterNo").select();};
          if (postid=='Val') {  $("#Val").focus(); $("#Val").select();};
          if (postid=='MasDate') {  $("#MasDate").focus(); $("#MasDate").select();};
          if (postid=='Notes') {  $("#Notes").focus(); $("#Notes").select();};
          if (postid=='save-btn') {
              setTimeout(function() { document.getElementById('save-btn').focus(); },100);};
      })

      window.addEventListener('CloseModal', event => {
          $("#ModalForm").modal('hide');
      })
      window.addEventListener('OpenModal', event => {
          $("#ModalForm").modal('show');
      })


      $(document).ready(function ()
      {
          $('#MasType_L').select2({
              closeOnSelect: true
          });
          $('#MasType_L').on('change', function (e) {
              var data = $('#MasType_L').select2("val");
          @this.set('MasTypeNo', data);
          @this.set('TheMasTypeListIsSelected',1);
          });
      });
      window.livewire.on('mastype-change-event',()=>{
          $('#MasType_L').select2({
              closeOnSelect: true
          });

      });
      $(document).ready(function ()
      {
          $('#Detail_L').select2({
              closeOnSelect: true
          });
          $('#Detail_L').on('change', function (e) {
              var data = $('#Detail_L').select2("val");
          @this.set('DetailNo', data);
          @this.set('TheDetailListIsSelected',1);
          });
      });
      window.livewire.on('detail-change-event',()=>{
          $('#Detail_L').select2({
              closeOnSelect: true
          });
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

      window.addEventListener('OpenAddType', event => {
          $("#ModalAddType").modal('show');
      })
      window.addEventListener('CloseAddType', event => {
          $("#ModalAddType").modal('hide');
      })
      window.addEventListener('OpenAddDetail', event => {
          $("#ModalAddDetail").modal('show');
      })
      window.addEventListener('CloseAddDetail', event => {
          $("#ModalAddDetail").modal('hide');
      })
  </script>

@endpush
