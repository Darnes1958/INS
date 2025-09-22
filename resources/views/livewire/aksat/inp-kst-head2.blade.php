


  <div x-data  class="row gy-1 my-1" style="border:1px solid lightgray;background: white; " >
    <div class="col-md-5">
      <label  for="bank_no" class="form-label-me ">المصرف</label>
      <input wire:model="bankno"   type="text" class=" form-control "
             id="bank_no"   readonly >

    </div>
    <div   class="col-md-7" >
      <label  class="form-label-me">&nbsp;</label>
        <input wire:model="bankname"   type="text" class=" form-control "
               id="bank_no"   readonly >
    </div>

     <div class="col-md-5">
      <label for="no" class="form-label-me">الرقم الألي</label>
      <input    wire:model="no" wire:keydown.enter="ChkNoAndGo"
             class="form-control"
             name="no" type="text"  id="no" >
      @error('no') <span class="error">{{ $message }}</span> @enderror
    </div>
     <div   class="col-md-7" >

      <label  class="form-label-me">&nbsp;</label>

      @livewire('aksat.no-select-all')


    </div>

     <div class="col-md-5 mb-2" >
      <label  for="acc" class="form-label-me">رقم الحساب</label>
      <input   wire:model="acc" wire:keydown.enter="ChkAccAndGo"
             class="form-control"  name="acc" type="text"  id="acc" autofocus>
       @error('acc') <span class="error">{{ $message }}</span> @enderror
    </div>
    <div class="col-md-7 mb-2">
      <div>
        <label   class="form-label-me">&nbsp;</label>
      </div>

      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" wire:model="Ksm_type" wire:click="ChangeKsm" name="inlineRadioOptions" id="inlineRadio2" value="2">
        <label class="form-check-label" for="inlineRadio2">مصرفي</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" wire:model="Ksm_type" wire:click="ChangeKsm" name="inlineRadioOptions" id="inlineRadio1" value="1">
        <label class="form-check-label" for="inlineRadio1">نقدا</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" wire:model="Ksm_type" wire:click="ChangeKsm" name="inlineRadioOptions" id="inlineRadio2" value="3">
        <label class="form-check-label" for="inlineRadio2">صك</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" wire:model="Ksm_type" wire:click="ChangeKsm" name="inlineRadioOptions" id="inlineRadio2" value="4">
        <label class="form-check-label" for="inlineRadio2">الكتروني</label>
      </div>

    </div>

    <div>
      @livewire('aksat.name-select')
    </div>

     <div   class="col-md-7" >
      <label   class="form-label-me">.</label>
       <div>
         @if($errors->has('acc'))
           <span>{{ $errors->first('acc') }}</span>
         @endif
       </div>
       <div class="modal fade" id="ModalKstMany" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered modal-lg">
           <div class="modal-content">
             <div class="modal-header">
               <button wire:click="CloseMany" type="button" class="btn-close" ></button>
               <h1 class="modal-title fs-5 mx-6" id="exampleModalLabel">اضغظ علي اختيار</h1>
             </div>
             <div class="modal-body">
               @livewire('aksat.many-acc2')
             </div>
           </div>
         </div>
       </div>
     </div>
  </div>

@push('scripts')
  <script>
      window.addEventListener('CloseKstManyModal', event => {
          $("#ModalKstMany").modal('hide');
      })
      window.addEventListener('OpenKstManyModal', event => {
          $("#ModalKstMany").modal('show');
      })
  </script>
  <script type="text/javascript">
      Livewire.on('ksthead_goto',postid=>  {
          if (postid=='bankno') {  $("#bank_no").focus();$("#bank_no").select(); }
          if (postid=='no') {  $("#no").focus();$("#no").select(); }
          if (postid=='acc') {  $("#acc").focus();$("#acc").select(); }
      })
  </script>

  <script>
      $(document).ready(function ()
      {
          $('#Bank_L').select2({
              closeOnSelect: true
          });
          $('#Bank_L').on('change', function (e) {
              var data = $('#Bank_L').select2("val");
              @this.set('bankno', data);
              @this.set('TheBankListIsSelectd', 1);
          });
      });
      window.livewire.on('bank-change-event',()=>{
          $('#Bank_L').select2({
              closeOnSelect: true
          });
      });
      $(document).ready(function ()
      {
          $('#Acc_L').select2({
              closeOnSelect: true
          });
          $('#Acc_L').on('change', function (e) {
              var data = $('#Acc_L').select2("val");
          @this.set('acc', data);
          @this.set('TheAccListIsSelectd', 1);
          });
      });
      window.livewire.on('bank-change-event',()=>{
          $('#Bank_L').select2({
              closeOnSelect: true
          });
      });
      $(document).ready(function ()
      {
          $('#Main_L_All').select2({
              closeOnSelect: true
          });
          $('#Main_L_All').on('change', function (e) {
              var data = $('#Main_L_All').select2("val");

          @this.set('no', data);
          @this.set('TheNoListIsSelectd', 1);
          });
      });
      window.livewire.on('main-change-event',()=>{

          $('#Main_L_All').select2({
              closeOnSelect: true
          });
          Livewire.emit('Go');
      });
  </script>
  <script type="text/javascript">

      window.addEventListener('mmsg',function(e){
          MyMsg.fire({
              confirmButtonText:  e.detail,
          })
      });
  </script>
@endpush
