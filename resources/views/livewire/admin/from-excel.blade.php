<div x-data x-show="$wire.Show" class="col-md-12">
  <div class="card">
    <div class="card-header">تحميل البانات من اكسل</div>
    <div class="card-body">
      <div class="row my-1">
       <div class="col-md-2">
         <button  wire:click="Take" class="btn btn-outline-success border-0  ">Prepere</button>
       </div>
        <div x-show="$wire.ShowDo" class="col-md-2">
          <a   href="{{ url('/impfromSheet',$filename) }}" class="btn btn-outline-success border-0   ">Do</a>
        </div>

      </div>



    </div>
  </div>
</div>



