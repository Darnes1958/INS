<div x-data x-show="$wire.Show" class="row">

<div  class="col-md-2 px-1">
  <div class="card my-0">
    <div class="card-header" style="height: 28px;">منح وحجب الصلاحيات للمستخدمين</div>
    <div class="card-body my-2">
      @livewire('manager.user-select')

        <div class=" my-2 ">
          <label  class=" col-form-label ">اسم المستخدم</label>
          <input wire:model="name"  type="text" class="form-control"   readonly>
        </div>

       @if($stop!='NoThing')
        <div class=" my-2 ">
          @if($stop=='Stop')
            <button  wire:click="StopUser" class="btn btn-primary" id="btn-save">
              تحرير
            </button>
          @else
            <button  wire:click="StopUser" class="btn btn-primary" id="btn-save">
              ايقاف
            </button>

          @endif
        </div>
      @endif



    </div>
  </div>
</div>

  <div class="col-md-4 px-1">

    <div class="card my-0">
      <div class="card-header" style="background: #0e8cdb;color: white">الباقات</div>
      <div class="card-body py-0">

        <div class="row">
          <div class="col-md-6">
            <table class="table table-sm table-bordered table-striped  "  >
              <caption class="caption-top text-center font-weight-bold">منح</caption>
              <thead class="font-size-12 font-weight-bolder " >
              <tr style="background: royalblue; color: white"><th >الباقات الغير ممنوحة</th></tr>
              </thead>
              <tbody >
              @foreach($NotHasRole as $item)
                <tr class="font-size-12">
                  <td ><a wire:click="selectPushRole({{ $item->id}})" href="#">{{ $item->name }}</a>  </td>

                </tr>
              @endforeach
              </tbody> </table>  {{ $NotHasRole->links() }}
          </div>
          <div class="col-md-6">
            <table class="table table-sm table-bordered table-striped  "  >
              <caption class="caption-top text-center">حجب</caption>
              <thead class="font-size-12 font-weight-bolder " >
              <tr style="background: royalblue; color: white"><th >الباقات الممنوحة</th></tr>
              </thead>
              <tbody >
              @foreach($HasRole as $item)
                <tr class="font-size-12">

                  <td ><a wire:click="selectPullRole({{ $item->id }})" href="#">{{ $item->name }}</a>  </td>

                </tr>
              @endforeach
              </tbody> </table>  {{ $HasRole->links() }}
          </div>


        </div>
      </div>
    </div>
  </div>

  <div class="col-md-6 px-1">

    <div class="card">
      <div class="card-header" style="background: #0e8cdb;color: white">صلاحية مفردة</div>
      <div class="card-body py-0">

        <div class="row">
          <div class="col-md-6">
            <table class="table table-sm table-bordered table-striped  "  >
              <caption class="caption-top text-center font-weight-bold">منح</caption>
              <thead class="font-size-12 font-weight-bolder " >
              <tr style="background: royalblue; color: white"><th >الصلاحية</th></tr>
              </thead>
              <tbody >
              @foreach($NotHasPer as $item)
                <tr class="font-size-12">
                  <td ><a wire:click="selectPushPer({{ $item->id}})" href="#">{{ $item->name }}</a>  </td>

                </tr>
              @endforeach
              </tbody> </table>  {{ $NotHasPer->links() }}
          </div>
          <div class="col-md-6">
            <table class="table table-sm table-bordered table-striped  "  >
              <caption class="caption-top text-center">حجب</caption>
              <thead class="font-size-12 font-weight-bolder " >
              <tr style="background: royalblue; color: white"><th >الصلاحية</th></tr>
              </thead>
              <tbody >
              @foreach($HasPer as $item)
                <tr class="font-size-12">

                  <td ><a wire:click="selectPullPer({{ $item->id }})" href="#">{{ $item->name }}</a>  </td>

                </tr>
              @endforeach
              </tbody> </table>  {{ $HasPer->links() }}
          </div>


        </div>
      </div>
    </div>
  </div>

</div>

@push('scripts')
  <script>
      Livewire.on('goto',postid=>  {
          if (postid=='bank_no') {  $("#bank_no").focus();$("#bank_no").select(); }
      })
      window.addEventListener('mmsg',function(e){
          MyMsg.fire({
              confirmButtonText:  e.detail,
          })
      });
      $(document).ready(function ()
      {
          $('#User_L').select2({
              closeOnSelect: true
          });
          $('#User_L').on('change', function (e) {
              var data = $('#User_L').select2("val");
          @this.set('UserNo', data);
          @this.set('TheUserListIsSelectd', 1);
          });
      });
      window.livewire.on('user-change-event',()=>{
          $('#User_L').select2({
              closeOnSelect: true
          });
      });
  </script>
@endpush
