
  <div x-data   class="col-md-12 " style="margin-bottom: 20px;margin-top: 16px;">

    <div  x-show="$wire.HeadOpen" class="row g-3 " style="border:1px solid lightgray;background: white;">
            <div class="col-md-6">
                <label  for="order_no" class="form-label-me ">رقم الفاتورة</label>
                <input wire:model="order_no"  wire:keydown.enter="$emit('gotonext','orderno')" type="text" class=" form-control "
                       id="order_no" name="order_no"  autofocus >
                @error('order_no') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-6">
                <label for="date" class="form-label-me">التاريخ</label>
                <input wire:model="order_date" wire:keydown.enter="$emit('gotonext','date')"
                       class="form-control  "
                       name="date" type="date"  id="date" >
                @error('order_date') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="row g-2 ">
              <div class="col-md-4">
                <label  for="jehano" class="form-label-me">المورد</label>
                <input wire:model="jeha" wire:keydown.enter="$emit('gotonext','jehano')"
                       class="form-control  "
                       name="jehano" type="text"  id="jehano" >
                @error('jeha') <span class="error">{{ $message }}</span> @enderror
                @error('jeha_type') <span class="error">{{ $message }}</span> @enderror
              </div>

              <div   class="col-md-7" >
                <label id="jehalabel" for="select2-dropdown" class="form-label-me">{{"$jeha_name"}}</label>
                  @livewire('select2-dropdown')
              </div>
              <div class="col-md-1" >
                  <label  class="form-label-me"> .</label>
                <button wire:click="OpenModal" type="button" class="btn btn-outline-primary btn-sm fa fa-plus" data-bs-toggle="modal"></button>
              </div>
           </div>


            <div class="col-md-4">
                <label  for="storeno" class="form-label-me">المخزن</label>
                <input  wire:model="st_no" wire:keydown.enter="$emit('gotonext','storeno')"
                       class="form-control  "
                       name="storeno" type="text"  id="storeno" >
                @error('st_no') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div  class="col-md-8" >
                <label  class="form-label-me">اختيار من القائمة</label>
                <select  wire:model="store" name="store_id" id="store_id" class="form-control  form-select "
                         style="vertical-align: middle ;font-size: 12px;height: 26px;padding-bottom:0;padding-top: 0;"
                         >
                    <option value="1">المخزن الرئيسي</option>
                    @foreach($stores_names as $s)
                        <option value="{{ $s->st_no }}">{{ $s->st_name }}</option>
                    @endforeach
                </select>
            </div>
           <div  class="col-md-8" >
              @livewire('buy.testselect')
           </div>

          <div class="my-3 align-center justify-content-center "  style="display: flex">

                <i  id="head-btn"
                    class=" btn btn-outline-success  waves-effect waves-light   "
                    wire:click="BtnHeader"> موافق </i>

          </div>
    </div>

    <div  x-show="!$wire.HeadOpen" class="row g-3 " style="border:1px solid lightgray;background: white;">
                <div class="col-md-6">
                    <label   class="form-label-me ">رقم الفاتورة</label>
                    <input wire:model="order_no" type="text" class=" form-control "   readonly  >
                </div>
                <div class="col-md-6">
                    <label  class="form-label-me">التاريخ</label>
                    <input wire:model="order_date" type="text"  class="form-control  "   readonly >
               </div>

                <div class="col-md-12">
                    <label  class="form-label-me">المورد</label>
                    <input wire:model="jeha_name"   class="form-control  " type="text"  readonly >
                </div>
                <div   class="col-md-12" >
                    <label  class="form-label-me">المخزن</label>
                    <input wire:model="st_name"   class="form-control  " type="text"   readonly>
                    <br>
                </div>
        </div>

      <div class="modal fade" id="ModalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                  <div class="modal-header">
                      <button wire:click="CloseModal" type="button" class="btn-close" ></button>
                      <h1 class="modal-title fs-5 mx-6" id="exampleModalLabel">ادخال مورد جديد</h1>
                  </div>
                  <div class="modal-body">
                      @livewire('jeha.add-supp')
                  </div>
              </div>
          </div>
      </div>

  </div>

@push('scripts')
    <script type="text/javascript">
        Livewire.on('jehachange',postid=>{

            $("#jehano").focus();
        })
        Livewire.on('mounthead',postid=>{

            $("#orderno").focus();
            $("#orderno").select();
        })


        Livewire.on('gotonext',postid=>  {

            if (postid=='orderno') {  $("#date").focus(); };
            if (postid=='date') {  $("#jehano").focus(); };
            if (postid=='jehano') {  $("#storeno").focus(); };

            if (postid=='store_id') {  $("#head-btn").active=true};
        })

    </script>
    <script>
        window.addEventListener('CloseModal', event => {
            $("#ModalForm").modal('hide');
        })
        window.addEventListener('OpenModal', event => {
            $("#ModalForm").modal('show');
        })

    </script>
  <script>
      $(document).ready(function ()
      {

          $('#jeha_l').select2({
              closeOnSelect: true
          });
          $('#jeha_l').on('change', function (e) {
              var data = $('#jeha_l').select2("val");

          @this.set('jeha', data);
              alert(data);
          });


      });
      window.livewire.on('data-change-event',()=>{

          $('#jeha_l').select2({
              closeOnSelect: true
          });


      });
  </script>
@endpush
