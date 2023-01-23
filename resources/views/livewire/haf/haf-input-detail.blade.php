


<div x-data class="row gy-1 my-1" style="border:1px solid lightgray;background: white;">


    <div   class="d-flex  " >
        <label   class="form-label  mx-1 ri-search-2-line" style="color: blue">&nbsp;برقم الحساب أو الإسم &nbsp;</label>
        @livewire('haf.search-acc',['sender'=>'haf.haf-input-detail','bank'=>$bank])
    </div>

    <div class="d-inline-flex align-items-center">

        <label  for="acc" class="form-label" style="width: 20%">رقم الحساب</label>
        <input  wire:model="acc" wire:keydown.enter="ChkAccAndGo"  x-bind:disabled="!$wire.BankGeted"
                class="form-control"  name="acc" type="text"  id="acc" style="width: 30%">

        <label  for="no" class="form-label" style="width: 20%">&nbsp;رقم العقد</label>
        <input  wire:model="no" wire:keydown.enter="ChkNoAndGo"  x-bind:disabled="!$wire.BankGeted"
                class="form-control"  name="no" type="number"  id="no" style="width: 30%">

    </div>
    <div class="modal fade" id="ModalKstMany" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button wire:click="CloseMany" type="button" class="btn-close" ></button>
                    <h1 class="modal-title fs-5 mx-6" id="exampleModalLabel">اضغظ علي اختيار</h1>
                </div>
                <div class="modal-body">
                    @livewire('aksat.many-acc')
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="ModalWrong" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button wire:click="CloseWrong" type="button" class="btn-close" ></button>
                    <h1 class="modal-title fs-5 mx-6" id="exampleModalLabel">ادخل الاسم وقيمة القسط</h1>
                </div>
                <div class="modal-body">
                    @livewire('haf.wrong-acc')
                </div>
            </div>
        </div>
    </div>
        @if (session()->has('message'))
        <div class="d-inline-flex align-items-center mt-2 mb-0" style="height: 20px;">
            <div style="height: 20px; width: 50%">
            </div>
            <div class="alert alert-danger text-center p-0 " style="height: 20px; width: 50%">
                {{ session('message') }}
            </div>
        </div>
        @endif

    <div class="d-inline-flex align-items-center">
        <label for="name" class="form-label align-right" style="width: 20% ">اســــــم الزبون</label>
        <input  wire:model="name" type="text" class="form-control" id="name" readonly style="width: 80%" >
    </div>
    <div class="d-inline-flex align-items-center">
        <label for="sul_tot" class="form-label" style="width: 25%; ">إجمالي الفاتورة</label>
        <input wire:model="sul_tot" type="text" class="form-control" name="sul_tot" style="width: 25%" readonly>
        <label for="sul" class="form-label" style="width: 25% ">&nbsp;&nbsp;اجمالي التقسيط</label>
        <input  wire:model="sul" type="text" class="form-control" id="sul" style="width: 25%" readonly>
    </div>
    <div class="d-inline-flex align-items-center">
        <label for="sul_pay" class="form-label" style="width: 20% ">المسدد</label>
        <input  wire:model="sul_pay" type="text" class="form-control" id="sul_pay" style="width: 30%" readonly>
        <label for="raseed" class="form-label" style="width: 20% ">&nbsp;&nbsp;المطلوب</label>
        <input  wire:model="raseed" type="text" class="form-control" id="raseed" style="width: 30%" readonly>
    </div>
    <div class="d-inline-flex align-items-center">
        <label for="kst_count" class="form-label" style="width: 20% ">عدد الأقساط</label>
        <input wire:model="kst_count" type="text" class="form-control" id="kst_count" style="width: 30%" readonly>
        <label for="kst" class="form-label" style="width: 20% ">&nbsp;&nbsp;القسط</label>
        <input wire:model="kst"  type="text" class="form-control" id="kst" style="width: 30%" readonly>
    </div>



    <div class="col-md-6 mb-2">
        <label for="ksm_date" class="form-label-me">التاريخ</label>
        <input wire:model="ksm_date" wire:keydown.enter="$emit('kstdetail_goto','ksm')"
               x-bind:disabled="!$wire.NoGeted" class="form-control  "
               type="date"  id="ksm_date" >
        @error('ksm_date') <span class="error">{{ $message }}</span> @enderror
    </div>
    <div class="col-md-6 mb-2">
        <label  for="ksm" class="form-label-me">القسط</label>
        <input wire:model="ksm" wire:keydown.enter="ChkKsm"
               x-bind:disabled="!$wire.NoGeted" class="form-control  "
               type="number"  id="ksm" >
        @error('ksm') <span class="error">{{ $message }}</span> @enderror

    </div>
    <br>

</div>

@push('scripts')
    <script type="text/javascript">
        window.addEventListener('kstwrong',function(e){
            KstWrong.fire({
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    Livewire.emit('OpenWrong');
                }
            })
        });
        window.addEventListener('mmsg',function(e){
            MyMsg.fire({
                confirmButtonText:  e.detail,
            })
        });
    </script>

    <script>
        window.addEventListener('CloseKstManyModal', event => {
            $("#ModalKstMany").modal('hide');
        })
        window.addEventListener('OpenKstManyModal', event => {
            $("#ModalKstMany").modal('show');
        })
        window.addEventListener('CloseWrongModal', event => {
            $("#ModalWrong").modal('hide');
        })
        window.addEventListener('OpenWrongModal', event => {
            $("#ModalWrong").modal('show');
        })
    </script>
    <script type="text/javascript">
        Livewire.on('kstdetail_goto',postid=>  {


            if (postid=='ksm_date') {  $("#ksm_date").focus();$("#ksm_date").select(); }
            if (postid=='ksm') {  $("#ksm").focus(); $("#ksm").select();}
            if (postid=='no') {  $("#no").focus(); $("#no").select();}
            if (postid=='acc') {  $("#acc").focus(); $("#acc").select();}


        })

        $(document).ready(function ()
        {
            $('#Main_L').select2({
                closeOnSelect: true
            });
            $('#Main_L').on('change', function (e) {
                var data = $('#Main_L').select2("val");
            @this.set('no', data);
            @this.set('TheNoListIsSelectd', 1);
            });
        });
        window.livewire.on('main-change-event',()=>{
            $('#Main_L').select2({
                closeOnSelect: true
            });

        });


    </script>
@endpush



