<div x-data class="col-md-12 " style="margin-bottom: 20px;margin-top: 16px;" xmlns="http://www.w3.org/1999/html">

  <div   class="row g-3 " style="border:1px solid lightgray;background: white;">
    <div class="col-md-6">
      <label   class="form-label-me ">الرقم الالي</label>
      <input wire:model="TranNo" type="text" class=" form-control "   readonly  >
    </div>
    <div class="col-md-12">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" wire:model="JehaRadio" wire:click="ChangeJeha"  value="Cust">
        <label class="form-check-label" >زبائن</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" wire:model="JehaRadio" wire:click="ChangeJeha"  value="Supp">
        <label class="form-check-label" >موردين</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" wire:model="JehaRadio" wire:click="ChangeJeha"  value="Others">
        <label class="form-check-label" >أخرون</label>
      </div>
    </div>
    <div class="col-md-5">
      <label  for="tran_type" class="form-label-me ">طريقة الدفع</label>
      <input  wire:model="tran_type" min="1" max="999" wire:keydown.enter="ChkTypeAndGo" type="number" class=" form-control "
             id="tran_type"   autofocus >
      @error('tran_type') <span class="error">{{ $message }}</span> @enderror
    </div>
    <div  class="col-md-7" >
      <label  class="form-label-me">.</label>
      @livewire('tools.pay-select')
    </div>

    <div class="row g-3 ">
      <div class="col-md-4">
        <label  for="jeha" class="form-label-me">رقم الزبون</label>
        <input wire:model="jeha" wire:keydown.enter="ChkJehaAndGo"
               class="form-control  "
               name="jeha" type="number"  id="jeha" autofocus>
        @error('jeha') <span class="error">{{ $message }}</span> @enderror
        @error('jeha_type') <span class="error">{{ $message }}</span> @enderror
      </div>

      <div class="col-md-2">
        <label class="form-label-me">&nbsp</label>
        <div class="row g-2 ">
          <div class="col-md-6" >
            <button wire:click="OpenJehaSerachModal" type="button" class="btn btn-outline-primary btn-sm fa fa-arrow-alt-circle-down" data-bs-toggle="modal"></button>
          </div>
          <div class="col-md-6" >
            <button wire:click="OpenModal" type="button" class="btn btn-outline-primary btn-sm fa fa-plus" data-bs-toggle="modal"></button>
          </div>
        </div>
      </div>

      <input wire:model="jeha_name"  class="form-control  "   type="text"  id="jehaname" readonly>
    </div>

    <div class="col-md-6">
      <label for="date" class="form-label-me">التاريخ</label>
      <input wire:model="tran_date" wire:keydown.enter="$emit('gotonext','val')"
             class="form-control  "
             name="tran_date" type="date"  id="tran_date" >
      @error('tran_date') <span class="error">{{ $message }}</span> @enderror
    </div>
    <div class="col-md-6">
      <label for="date" class="form-label-me">المبلغ</label>
      <input wire:model="val" wire:keydown.enter="$emit('gotonext','notes')"
             class="form-control  "
             name="val" type="number"  id="val" >
      @error('val') <span class="error">{{ $message }}</span> @enderror
    </div>
    <div class="col-md-12">
      <label for="notes" class="form-label-me">ملاحظات</label>
      <input x-bind:disabled="!$wire.OrderGet" wire:model="notes" wire:keydown.enter="$emit('gotonext','savebtn')"
             class="form-control  "
             type="text"  id="notes" >
    </div>

    <div class="my-3 align-center justify-content-center "  style="display: flex">
      <input type="button"  id="savebtn"
             class=" btn btn-outline-success  waves-effect waves-light"
             wire:click.prevent="DoSave"   value="تخزين" />
    </div>
  </div>

  <div class="modal fade" id="ModalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <button wire:click="CloseModal" type="button" class="btn-close" ></button>
          <h1 class="modal-title fs-5 mx-6" id="exampleModalLabel">ادخال مورد جديد</h1>
        </div>
        <div class="modal-body">

          @livewire('jeha.add-supp')
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="ModalSelljeha" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <button wire:click="CloseJehaSerachModal" type="button" class="btn-close" ></button>
        </div>
        <div class="modal-body">
          @livewire('jeha.cust-search')
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
  </script>

  <script type="text/javascript">
      Livewire.on('jehachange',postid=>{

          $("#jehano").focus();
      })
      Livewire.on('mounthead',postid=>{

          $("#orderno").focus();
          $("#orderno").select();
      })


      Livewire.on('gotonext',postid=>  {

          if (postid=='tran_type') {  $("#tran_type").focus();$("#tran_type").select(); };
          if (postid=='jeha') {  $("#jeha").focus();$("#jeha").select(); };
          if (postid=='tran_date') {  $("#tran_date").focus(); $("#tran_date").select();};
          if (postid=='val') {  $("#val").focus(); $("#val").select();};
          if (postid=='notes') {  $("#notes").focus(); $("#notes").select();};
          if (postid=='savebtn') {
              setTimeout(function() { document.getElementById('savebtn').focus(); },100);};
      })

  </script>
  <script>
      window.addEventListener('CloseModal', event => {
          $("#ModalForm").modal('hide');
      })
      window.addEventListener('OpenModal', event => {
          $("#ModalForm").modal('show');
      })


  </script>
  <script>
      window.addEventListener('CloseTransjehaModal', event => {
          $("#ModalSelljeha").modal('hide');
      })
      window.addEventListener('OpenTransjehaModal', event => {
          $("#ModalSelljeha").modal('show');
      })
  </script>
  <script>

      $(document).ready(function ()
      {
          $('#Cust_L').select2({
              closeOnSelect: true
          });
          $('#Cust_L').on('change', function (e) {
              var data = $('#Cust_L').select2("val");
          @this.set('jeha', data);
          });
      });
      window.livewire.on('data-change-event',()=>{
          $('#Cust_L').select2({
              closeOnSelect: true
          });
          Livewire.emit('gotonext', 'jehano');
      });
      $(document).ready(function ()
      {
          $('#Pay_L').select2({
              closeOnSelect: true
          });
          $('#Pay_L').on('change', function (e) {
              var data = $('#Pay_L').select2("val");
          @this.set('tran_type', data);
          @this.set('ThePayNoListIsSelectd', 1);
          });
      });
      window.livewire.on('Pay-change-event',()=>{
          $('#Pay_L').select2({
              closeOnSelect: true
          });

      });
  </script>

@endpush
