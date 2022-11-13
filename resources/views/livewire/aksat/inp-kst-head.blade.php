


  <div x-data  class="row gy-1 my-1" style="border:1px solid lightgray;background: white; " >
    <div class="col-md-5">
      <label  for="bank_no" class="form-label-me ">المصرف</label>
      <input wire:model="bankno"  wire:keydown.enter="ChkBankAndGo" type="text" class=" form-control "
             id="bank_no"   autofocus >
      @error('bankno') <span class="error">{{ $message }}</span> @enderror
    </div>
    <div   class="col-md-7" >
      <label  class="form-label-me">.</label>
      @livewire('bank.bank-select')
    </div>

     <div class="col-md-5">
      <label for="no" class="form-label-me">الرقم الألي</label>
      <input  x-bind:disabled="!$wire.BankGet"  wire:model="no" wire:keydown.enter="ChkNoAndGo"
             class="form-control"
             name="no" type="text"  id="no" >
      @error('no') <span class="error">{{ $message }}</span> @enderror
    </div>
     <div   class="col-md-7" >
      <label  class="form-label-me">.</label>
      @livewire('aksat.no-select')
    </div>

     <div class="col-md-5 mb-2" >
      <label  for="acc" class="form-label-me">رقم الحساب</label>
      <input  x-bind:disabled="!$wire.BankGet" wire:model="acc" wire:keydown.enter="ChkAccAndGo"
             class="form-control"  name="acc" type="text"  id="acc" >
    </div>
     <div   class="col-md-7" >
      <label   class="form-label-me">.</label>
       <div>
         @if($errors->has('acc'))
           <span>{{ $errors->first('acc') }}</span>
         @endif
       </div>
    </div>




  </div>

@push('scripts')
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
          $('#Main_L').select2({
              closeOnSelect: true
          });
          $('#Main_L').on('change', function (e) {
              var data = $('#Main_L').select2("val");
          @this.set('no', data);
          @this.set('TheNoListIsSelectd', 1);
          });
      });
      window.livewire.on('main-change-event',()=>{
          $('#Main_L').select2({
              closeOnSelect: true
          });

          Livewire.emit('Go');


      });
  </script>
@endpush
