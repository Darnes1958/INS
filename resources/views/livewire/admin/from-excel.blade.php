<div x-data x-show="$wire.Show" class="col-md-12">
  <div class="card">
    <div class="card-header">تحميل البانات من اكسل</div>
    <div class="card-body">
      <div class="row my-1">
          <div class="col-md-4">
              @livewire('admin.taj-select')
          </div>
          <div class="col-md-3">
              <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" wire:model="BankRadio"  name="inlineRadioOptions" id="inlineRadio1" value="wahda">
                  <label class="form-check-label" for="inlineRadio1">الوجدة</label>
              </div>
              <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" wire:model="BankRadio" name="inlineRadioOptions" id="inlineRadio2" value="tejary">
                  <label class="form-check-label" for="inlineRadio2">التجاري</label>
              </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" wire:model="BankRadio" name="inlineRadioOptions" id="inlineRadio3" value="sahary">
              <label class="form-check-label" for="inlineRadio2">الصحاري</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" wire:model="BankRadio" name="inlineRadioOptions" id="inlineRadio4" value="jomhoria">
              <label class="form-check-label" for="inlineRadio2">الجمهورية</label>
            </div>
          </div>
       <div class="col-md-2">
         <button  wire:click="Take" class="btn btn-outline-success border-0  ">Prepere</button>
       </div>
        <div x-show="$wire.ShowDo" class="col-md-2">
          <a   href="{{route('impfromsheet',['filename'=>$filename,'TajNo'=>$TajNo,'BankRadio'=>$BankRadio])}}"
               class="btn btn-outline-success border-0   ">Do</a>

        </div>

      </div>



    </div>
  </div>
</div>
@push('scripts')
    <script>

        window.addEventListener('mmsg',function(e){
            MyMsg.fire({
                confirmButtonText:  e.detail,
            })
        });
        $(document).ready(function ()
        {
            $('#TajNo_L').select2({
                closeOnSelect: true
            });
            $('#TajNo_L').on('change', function (e) {
                var data = $('#TajNo_L').select2("val");
            @this.set('TajNo', data);

            });
        });
        window.livewire.on('taj-change-event',()=>{
            $('#TajNo_L').select2({
                closeOnSelect: true
            });
        });
    </script>
@endpush





