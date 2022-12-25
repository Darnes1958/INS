<div x-data x-show="$wire.Show" class="col-md-8">
  <div class="card">
    <div class="card-header">ادخال مستخدم جديد</div>
    <div class="card-body">
        <div class="row mb-3">
            <label for="company" class="col-md-4 col-form-label text-md-end">Company (DataBase)</label>
            <div class="col-md-3">
                <input wire:model="database" id="company" type="text" class="form-control  "  autofocus>
            </div>
            <div class="col-md-5">
                @livewire('admin.database-select')
            </div>

        </div>
        <div class="row mb-3">
            <label for="empno" class="col-md-4 col-form-label text-md-end">last emp_no </label>
            <div class="col-md-3">
                <input wire:model="empno" id="empno" type="text" class="form-control" name="empno"   >
            </div>
            <div class="col-md-5">
                @livewire('admin.empno-select')
            </div>
        </div>
      <div class="row mb-3">
        <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>
        <div class="col-md-6">
          <input wire:model="name" id="name" type="text" class="form-control"  name="name"  autofocus>
        </div>
      </div>
      <div class="row mb-3">
        <label for="username" class="col-md-4 col-form-label text-md-end">userName</label>
        <div class="col-md-6">
          <input wire:model="username" id="username" type="text" class="form-control  " name="username"  >
        </div>
      </div>


      <div class="row mb-3">
        <label for="email" class="col-md-4 col-form-label text-md-end">Email Address</label>
        <div class="col-md-6">
          <input wire:model="email" id="email" type="email" class="form-control " name="email" >
        </div>
      </div>

      <div class="row mb-3">
        <label for="password" class="col-md-4 col-form-label text-md-end">Password</label>
        <div class="col-md-6">
          <input wire:model="password" id="password" type="password" class="form-control" >
        </div>
      </div>
      <div class="row mb-3">
        <label for="password-confirm" class="col-md-4 col-form-label text-md-end">Is Admin</label>
        <div class="col-md-6">
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" wire:model="IsAdmin"  name="inlineRadioOptions" id="inlineRadio1" value="1">
            <label class="form-check-label" for="inlineRadio1">Yes</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" wire:model="IsAdmin"  name="inlineRadioOptions" id="inlineRadio2" value="0">
            <label class="form-check-label" for="inlineRadio2">No</label>
          </div>
        </div>
      </div>
      <div class="row mb-0">
        <div class="col-md-6 offset-md-4">
          <button  wire:click="SaveUser" class="btn btn-primary">
            Register
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

@push('scripts')

    <script>
        $(document).ready(function ()
        {
            $('#Emp_L').select2({
                closeOnSelect: true
            });
            $('#Emp_L').on('change', function (e) {
                var data = $('#Emp_L').select2("val");
            @this.set('empno', data);
            @this.set('TheEmpListIsSelectd', 1);
            });
        });
        window.livewire.on('empno-change-event',()=>{
            $('#Emp_L').select2({
                closeOnSelect: true
            });
        });
        $(document).ready(function ()
        {
            $('#Database_L').select2({
                closeOnSelect: true
            });
            $('#Database_L').on('change', function (e) {
                var data = $('#Database_L').select2("val");
            @this.set('database', data);
            @this.set('TheDatabaseListIsSelectd', 1);

            });
        });
        window.livewire.on('database-change-event',()=>{
            $('#Database_L').select2({
                closeOnSelect: true
            });

        });
    </script>
@endpush


