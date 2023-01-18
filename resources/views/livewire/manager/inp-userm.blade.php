<div  x-data x-show="$wire.Show" class="row">
<div class="col-md-4">
  <div class="card">
    <div class="card-header">ادخال مستخدم جديد</div>
    <div class="card-body">


      <div class="row mb-3">
        <label for="name" class="col-md-4 col-form-label text-md-end">الاسم</label>
        <div class="col-md-6">
          <input wire:model="name"  wire:keydown.enter="$emit('gotonext','password')" id="name" type="text" class="form-control"  name="name"  autofocus>
        </div>
      </div>


      <div class="row mb-3">
        <label for="password" class="col-md-4 col-form-label text-md-end">الرقم السري</label>
        <div class="col-md-6">
          <input wire:model="password"  wire:keydown.enter="$emit('gotonext','btn-save')" id="password" type="text" class="form-control" autofocus>
        </div>
      </div>

      <div class="row mb-0">
        <div class="col-md-6 offset-md-4">
          <button  wire:click="SaveUser" class="btn btn-primary" id="btn-save">
            تخزين
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

@push('scripts')

  <script>
      Livewire.on('gotonext',postid=>  {
          if (postid=='name') {  $("#name").focus();$("#name").select(); };
          if (postid=='password') {  $("#password").focus();$("#password").select(); };
          if (postid=='btn-save') {
              setTimeout(function() { document.getElementById('btn-save').focus(); },100);};
      })

  </script>
@endpush



