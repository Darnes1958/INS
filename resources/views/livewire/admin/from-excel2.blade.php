<div x-data x-show="$wire.Show" class="col-md-12">
  <div class="card">
    <div class="card-header">تحميل البانات من اكسل</div>
    <div class="card-body">
      <div class="row my-1">
          <div class="col-md-4">
              @livewire('admin.taj-select')
          </div>
       <div class="col-md-2">
         <button  wire:click="Take" class="btn btn-outline-success border-0  ">Prepere</button>
       </div>
        <div x-show="$wire.ShowDo" class="col-md-2">
          <a   href="{{route('impfromsheet2',['filename'=>$filename,'TajNo'=>$TajNo])}}"
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





