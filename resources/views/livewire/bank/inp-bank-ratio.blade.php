<div x-data>

        <div  class="modal fade" id="TajEditModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" wire:click.prevent="CloseTajModal" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <h3 class="modal-title fs-5" id="exampleModalToggleLabel2">ادخال مكان العمل الجديد ثم اضغط ENTER</h3>
                    </div>
                    <div class="modal-body">

                        @livewire('bank.edit-ratio')

                    </div>
                </div>
            </div>
        </div>



  <div class="col-md-8">
  <div class="row gy-1 my-1" style="border:1px solid lightgray;background: white; " >
    <div class="col-md-11 ">
      @livewire('aksat.rep.bank-comp',
      ['sender' => 'bank.inp-bank-ratio',])


      @error('bank_no') <span class="error">{{ $message }}</span> @enderror
    </div>
    <div x-show="$wire.BankGeted" class="col-md-1 my-3">
          <button wire:click="OpenTajModal"
                  type="button" class="btn btn-outline-primary btn-sm fa fa-edit border-0" ></button>
    </div>

    <div  class="col-md-6  d-inline-flex my-2 " >
      <label  class="form-label-me mx-1">السنة</label>
      <select x-bind:disabled="$wire.bank_no==null" wire:model="year"  name="year_id" id="year_id" class="form-control  form-select mx-1 text-center"
               style="vertical-align: middle ;font-size: 12px;height: 26px;padding-bottom:0;padding-top: 0;"
      >
          <option value=""> اختيار </option>
        @foreach($years as $key=>$s)
          <option value="{{ $s->year }}">{{ $s->year }}</option>
        @endforeach
      </select>

      <input wire:model="year" class="form-control mx-1 text-center" type="number"  min="2006" max="2050"  id="year" style="width: 50%; " readonly>
      @error('year') <span class="error">{{ $message }}</span> @enderror
    </div>
    <div  class="col-md-6  d-inline-flex my-2 " >
      <label  class="form-label-me mx-1">الشهر</label>
      <select x-bind:disabled="$wire.year==null"
              wire:model="month"  name="month_id" id="month_id" class="form-control  form-select mx-1 text-center"
               style="vertical-align: middle ;font-size: 12px;height: 26px;padding-bottom:0;padding-top: 0;"
      >
          <option value=""> اختيار </option>
        @foreach($months as $key=>$s)
          <option value="{{ $s->month }}">{{ $s->month }}</option>
        @endforeach
      </select>

      <input wire:model="month" class="form-control mx-1 text-center" type="number"    id="month" style="width: 50%; " readonly>
      @error('month') <span class="error">{{ $message }}</span> @enderror
    </div >
    <div class="col-md-4 my-4" style="margin-right: 40%">
      <button type="submit" wire:click.prevent="Do" class="btn btn-primary" id="btn-save">
        احتساب
      </button>
      <div wire:loading wire:target="Do">
        يرجي الانتظار...
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
      window.addEventListener('CloseTajEdit', event => {
          $("#TajEditModal").modal('hide');
      })
      window.addEventListener('OpenTajEdit', event => {
          $("#TajEditModal").modal('show');
      })
      window.addEventListener('ExistRatio',function(e){
          MyConfirm.fire({
              title: 'سبق ادراج هذا الشهر من هذذه السنة .. هل ترغب في الاستمرار ؟',
          }).then((result) => {
              /* Read more about isConfirmed, isDenied below */
              if (result.isConfirmed) {
                  Livewire.emit('DoRatio');
              }
          })
      });

  </script>
@endpush


