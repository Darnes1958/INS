<div x-data>
    <div   class="row  " >
        <div class="col-md-12">
            <label  class="form-label-me">الاسم </label>
            <input wire:model="Name" wire:keydown.enter="$emit('gotonext','CenterNo')"
                   class="form-control  "   type="test"  id="Name" autofocus>
        </div>
    </div>
    <div   class="row " >
        <div class="col-md-12">
            <label  class="form-label-me">محملة علي </label>
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
            <label  class="form-label-me">المرتب </label>
            <input wire:model="Sal" wire:keydown.enter="$emit('gotonext','save-btn')"
                   class="form-control  "   type="number"  id="Sal" autofocus>
            @error('Val') <span class="error">{{ $message }}</span> @enderror
        </div>
    </div>


    <div   class="my-4 row justify-content-center ">
      <button  wire:click="Save" class="col-md-4 mx-1 btn btn-primary" id="save-btn">
        تخزين
      </button>
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

          @this.set('IsSave', false);
          if (postid=='Name') {  $("#Name").focus(); $("#Name").select();};
          if (postid=='CenterNo') {  $("#CenterNo").focus(); $("#CenterNo").select();};
          if (postid=='Sal') {  $("#Sal").focus(); $("#Sal").select();};
          if (postid=='save-btn') {
              setTimeout(function() { document.getElementById('save-btn').focus(); },100);};
      })



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
