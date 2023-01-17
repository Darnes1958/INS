<div x-data x-show="$wire.Show" class="col-md-12">
  <div class="card">

    <div class="card-header" style="background: lightblue">ملء الحافظة</div>

    <div class="card-header">ملء الحافظة</div>

    <div class="card-body">
      <div class="row my-1">
          <div class=" col-md-4">
              <select  wire:model="bankl" wire:click="fillOne" name="bank_id" id="bank_id" class="form-control  form-select "
                       style="vertical-align: middle ;font-size: 12px;height: 26px;padding-bottom:0;padding-top: 0;"   >
                  @foreach($form_bank as $key=>$s)
                      <option value="{{ $s->bank }}">{{ $s->bank }}</option>
                  @endforeach
              </select>

          </div>
          <div class="col-md-2">
              <input  wire:model="theone" wire:keydown.enter="DoOne"
                      class="form-control  "
                      type="text"  id="theone" >
              <div wire:loading wire:target="DoOne">
                  Please Wait...
              </div>

          </div>
        <div class=" col-md-1">
          <button  wire:click="Do" class="btn btn-outline-success border-0  ">Do</button>
            <div wire:loading wire:target="Do">
                Please Wait...
            </div>
        </div>
          <div class=" col-md-1">
              <button  wire:click="Do2" class="btn btn-outline-success border-0  ">Do 2</button>
              <div wire:loading wire:target="Do2">
                  Please Wait...
              </div>
          </div>
          <div class=" col-md-1">
              <button  wire:click="Do21" class="btn btn-outline-success border-0  ">Do 21</button>
              <div wire:loading wire:target="Do21">
                  Please Wait...
              </div>
          </div>
          <div class=" col-md-2">
              <button  wire:click="DoWrong" class="btn btn-outline-success border-0  ">Do Wrong</button>
              <div wire:loading wire:target="DoWrong">
                  Please Wait...
              </div>
          </div>
          <div class="col-md-1">
              <button  wire:click="Tarheel" class="btn btn-outline-success border-0  ">ترحيل للمنظومة 1</button>
              <div wire:loading wire:target="Tarheel">
                  Please Wait...
              </div>
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

    </script>
@endpush




