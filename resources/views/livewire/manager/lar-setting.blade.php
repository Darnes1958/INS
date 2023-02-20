<div  x-data x-show="$wire.Show" class="row my-4">
  <div class="col-md-4 ">
    <div class="card">
      <div class="card-header bg-soft-primary">اعدادات عامة للمنظومة</div>
      <div class="card-body ">
        <div class="my-3" >
          <input class="form-check-input"  type="checkbox" wire:model="NakInc"  >
          <label class="form-check-label" >ترقيم ألي للمبيعات النقدية</label>
        </div>
        <div  class="my-3">
          <input class="form-check-input"  type="checkbox" wire:model="TakInc"  >
          <label class="form-check-label" >ترقيم ألي للمبيعات بالتقسيط</label>
        </div>
        <div  class="my-3">
          <input class="form-check-input"  type="checkbox" wire:model="ArcBtn"  >
          <label class="form-check-label" >إظهار ايقون النقل من وإلي الارشيف</label>
        </div>


        <button  wire:click="SaveSetting" class="my-3 btn btn-primary" id="btn-save">
              تخزين
        </button>


      </div>
    </div>
  </div>
</div>





