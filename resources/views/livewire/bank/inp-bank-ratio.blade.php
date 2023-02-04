<div x-data>
  <div class="col-md-8">
  <div class="row gy-1 my-1" style="border:1px solid lightgray;background: white; " >
    <div class="col-md-12">
      @livewire('aksat.rep.bank-comp',
      ['sender' => 'bank.inp-bank-ratio',])
      @error('bank_no') <span class="error">{{ $message }}</span> @enderror
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
  </script>
@endpush


