<div x-data class="col-md-12 ">
    <div class="row">
        <dev class="col-md-6 " >
            <div class="card">
                <div class="card-header" style="background: #0e8cdb;color: white;font-size: 14pt;">ادخال مدفوعات الايجار والترحيل</div>
                <div class="card-body">
                    @if(!$UpdateMod)
                    <div >
                        @livewire('admin.cus-select')
                    </div>
                    @endif

                    <div class="row mb-3">
                        <label  class="col-sm-2 g-2">الشركة</label>
                        <div  class="col-sm-10 form-group">
                            <input wire:model="CompanyName"  readonly class="form-control" type="text"  >
                            @error('CusNo') <span class="error">{{ $message }}</span> @enderror
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-2 g-2"></div>
                        <div class="col-sm-10 ">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" wire:model="ValType"  name="inlineRadioOptions" id="inlineRadio1" value="1">
                            <label class="form-check-label" for="inlineRadio1">ترحيل أقساط</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" wire:model="ValType" name="inlineRadioOptions" id="inlineRadio2" value="2">
                            <label class="form-check-label" for="inlineRadio2">إيجار سيرفر</label>
                        </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" wire:model="ValType" name="inlineRadioOptions" id="inlineRadio2" value="3">
                                <label class="form-check-label" for="inlineRadio3">منظومة</label>
                            </div>

                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-sm-2 g-2">التاريخ</label>
                        <div  class="col-sm-10 form-group">
                            <input wire:model="TransDate"
                                   wire:keydown.enter="$emit('gotonext','Val')"
                                   class="form-control" type="date" id="TransDate" >
                            @error('TransDate') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-sm-2 g-2">المبلغ</label>
                        <div  class="col-sm-10 form-group">
                            <input wire:model="Val"
                                   wire:keydown.enter="$emit('gotonext','Notes')"
                                   class="form-control" type="number" id="Val" >
                            @error('Val') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="mdar" class="col-sm-2 g-2">ملاحظات</label>
                        <div  class="col-sm-10 form-group">
                            <input wire:model="Notes"
                                   wire:keydown.enter="$emit('gotonext','DateNext')"
                                   class="form-control" type="text" id="Notes" >

                        </div>
                    </div>

                    <div class="row mb-3 g-2">
                        <label for="others" class="col-sm-2">التاريخ القادم</label>
                        <div  class="col-sm-10 form-group">
                            <input wire:model="DateNext"  wire:keydown.enter="$emit('gotonext','ValNext')" class="form-control" type="date" id="DateNext" >
                            @error('DateNext') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-sm-2 g-2">المبلغ القادم</label>
                        <div  class="col-sm-10 form-group">
                            <input wire:model="ValNext"  wire:keydown.enter="$emit('gotonext','save-supp')"
                                   class="form-control" type="number"  id="ValNext">
                            @error('Val') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="col text-center">
                        <input type="button" id="save-supp"
                               class="w-100 btn btn-primary btn-lg"
                               wire:click.prevent="Save"     value="تخزين البيانات"/>

                    </div>
                </div>
            </div>

        </dev> <!-- end col -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header align-content-center">
                    <div class="row">
                        <div class="col-md-6">
                            <input wire:model="search"  type="search"   placeholder="ابحث هنا .......">
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <table class="table table-sm table-bordered table-striped table-light " width="100%"   >
                        <thead class="font-size-12">
                        <tr>
                            <th width="18%" >التاريخ</th>
                            <th width="18%">المبلغ</th>
                            <th width="18%">الييان</th>
                            <th width="18%">المبلغ القادم</th>
                            <th width="18%">تاريخه</th>

                            <th width="5%" style="text-align: center"></th>
                            <th width="5%" style="text-align: center"></th>
                        </tr>
                        </thead>
                        <tbody id="addRow" class="addRow">
                        @foreach($CusTable as  $item)
                            <tr class="font-size-12">
                                <td>{{$item->TransDate}}</td>
                                <td>{{$item->Val}}</td>
                                @if($item->ValType==1) <td>ترحيل أقساط</td>@endif
                                @if($item->ValType==2) <td>إيجار سيرفر</td>@endif
                                @if($item->ValType==3) <td>منظومة</td>@endif
                                <td>{{$item->ValNext}}</td>
                                <td>{{$item->DateNext}}</td>
                                <td  style="padding-top: 2px;padding-bottom: 2px; ">
                                    <i wire:click="selectItem({{ $item->id }},'update')"
                                       class="btn btn-outline-primary btn-sm fa fa-edit editable-input" style="margin-left: 2px;"></i>
                                </td>
                                <td  style="padding-top: 2px;padding-bottom: 2px; ">
                                    <i wire:click="selectItem({{ $item->id }},'delete')"
                                       class="btn btn-outline-danger btn-sm fa fa-times "></i>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $CusTable->links() }}
                    <div class="modal fade" id="ModalMyDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">تأكيد الحذف</h5>
                                    <button wire:click="CloseDeleteDialog" type="button" class="close"  >
                                        <span aria-hidden="true close-btn">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <h5>هل أنت متأكد من الإلغاء ?</h5>
                                </div>
                                <div class="modal-footer">
                                    <button  wire:click="CloseDeleteDialog" type="button" class="btn btn-secondary close-btn" >تراجع</button>
                                    <button type="button" wire:click.prevent="delete()" class="btn btn-danger close-modal" data-dismiss="modal">نعم متأكد</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script type="text/javascript">
        Livewire.on('gotonext',postid=>  {

            if (postid=='Val') {  $("#Val").focus(); $("#Val").select();};
            if (postid=='ValNext') {  $("#ValNext").focus(); $("#ValNext").select();};
            if (postid=='TransDate') {  $("#TransDate").focus(); $("#TransDate").select();};
            if (postid=='DateNext') {  $("#DateNext").focus(); $("#DateNext").select();};
            if (postid=='Notes') {  $("#Notes").focus(); $("#Notes").select();};

            if (postid=='save-supp') {
                setTimeout(function() { document.getElementById('save-supp').focus(); },100);};
        })

        window.addEventListener('mmsg',function(e){
            MyMsg.fire({
                confirmButtonText:  e.detail,
            })
        });

        $(document).ready(function ()
        {
            $('#CusNo_L').select2({
                closeOnSelect: true
            });
            $('#CusNo_L').on('change', function (e) {
                var data = $('#CusNo_L').select2("val");
            @this.set('CusNo', data);
            @this.set('TheCusIsSelectd', 1);

            });
        });
        window.livewire.on('cus-change-event',()=>{
            $('#CusNo_L').select2({
                closeOnSelect: true
            });
        });

        window.addEventListener('OpenMyDelete', event => {
            $("#ModalMyDelete").modal('show');
        })
        window.addEventListener('CloseMyDelete', event => {
            $("#ModalMyDelete").modal('hide');
        })

    </script>
@endpush
