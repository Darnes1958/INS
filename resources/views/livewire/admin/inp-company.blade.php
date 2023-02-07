<div x-data x-show="$wire.Show" class="col-md-4">
  <div class="card">
    <div class="card-header">ادخال بيانات شركة</div>
    <div class="card-body">
      <div class="row mb-3">
        <label for="DataBase" class="col-md-4 col-form-label text-md-end">Database</label>
        <div class="col-md-6">
          <input wire:model="database" id="dataBase" type="text" class="form-control"    autofocus>
        </div>
      </div>
      <div class="row mb-3">
        <label for="CompanyName" class="col-md-4 col-form-label text-md-end">Company Name</label>
        <div class="col-md-6">
          <input wire:model="CompanyName" id="CompanyName" type="text" class="form-control  "  >
        </div>
      </div>
      <div class="row mb-3">
        <label for="CompanyNameSuffix" class="col-md-4 col-form-label text-md-end">Company Name Suffix</label>
        <div class="col-md-6">
          <input wire:model="CompanyNameSuffix" id="CompanyNameSuffix" type="text" class="form-control"  autofocus>
        </div>
      </div>
      <div class="row mb-3">
        <label for="CompCode" class="col-md-4 col-form-label text-md-end">Company Code</label>
        <div class="col-md-6">
          <input wire:model="CompCode" id="CompCode" type="text" class="form-control"  autofocus>
        </div>
      </div>

      <div class="row mb-0">
        <div class="col-md-6 offset-md-4">
          <button  wire:click="SaveCompany" class="btn btn-primary">
            Register The Company
          </button>
        </div>
      </div>
    </div>
  </div>
</div>