<div x-data x-show="$wire.Show" class="col-md-12">
  <div class="card">
<<<<<<< HEAD
    <div class="card-header" style="background: lightblue">ملء الحافظة</div>
=======
    <div class="card-header">ملء الحافظة</div>
>>>>>>> 98f7920a652c240252e5ebfe67638204456b6db2
    <div class="card-body">
      <div class="row my-1">
        <div class=" col-md-4">
          <button  wire:click="Do" class="btn btn-outline-success border-0  ">Do</button>
            <div wire:loading wire:target="Do">
                Please Wait...
            </div>
        </div>
          <div class="col-md-4">
              <button  wire:click="Tarheel" class="btn btn-outline-success border-0  ">ترحيل للمنظومة</button>
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




