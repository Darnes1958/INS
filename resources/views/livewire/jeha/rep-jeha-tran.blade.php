
<div  >
    <div class="row mb-1">
        <div class="col-md-1">
            <label  for="jehano" class="form-label-me">رقم الزبون</label>
        </div>
        <div class="col-md-1">
            <input wire:model="jeha_no" wire:keydown.enter="JehaKeyDown"
                   class="form-control"  type="number"  id="jehano" autofocus>
            @error('jeha_no') <span class="error">{{ $message }}</span> @enderror
        </div>
        <div class="col-md-1" >
            <button wire:click="OpenJehaSerachModal" type="button" class="btn btn-outline-primary btn-sm fa fa-arrow-alt-circle-down" data-bs-toggle="modal"></button>
        </div>
        <div class="col-md-4">
           <input wire:model="jeha_name"  class="form-control  "   type="text"  id="jehaname" readonly>
        </div>
        <div class="col-md-3 " >
            <div class="row">
                <div class="col-md-3 ">
                    <label class="form-check-label " >من تاريخ </label>
                </div>
                <div class="col-md-8">
                    <input wire:model="tran_date" wire:keydown.enter="DateKeyDown" class="form-control "   type="date"  id="tran_date">
                    @error('tran_date') <span class="error">{{ $message }}</span> @enderror

                </div>


            </div>
        </div>
        <div  class="col-md-2 ">
            <a  href="{{route('pdfjehatran',['jeha_no'=>$jeha_no,'Mden'=>$Mden,'MdenBefore'=>$MdenBefore,'Daen'=>$Daen,'DaenBefore'=>$DaenBefore,'tran_date'=>$tran_date])}}"
                class="btn btn-success waves-effect waves-light"><i class="fa fa-print"> &nbsp;&nbsp;طباعة&nbsp;&nbsp;</i></a>
        </div>
    </div>

    <div class="modal fade" id="ModalRepjeha" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button wire:click="CloseJehaSerachModal" type="button" class="btn-close" ></button>
                </div>
                <div class="modal-body">
                    @can('تقارير الموردين')
                     @livewire('jeha.cust-search',['jeha_type'=>123])
                    @else
                     @livewire('jeha.cust-search',['jeha_type'=>13])
                    @endcan
                </div>
            </div>
        </div>
    </div>
    <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
        <thead class="font-size-12">
        <tr>
            <th >البيان</th>
            <th style="width: 14%">التاريخ</th>
            <th style="width: 14%">مدين</th>
            <th style="width: 14%">دائن</th>
            <th style="width: 20%">رقم المستند</th>
            <th style="width: 20%">طريقة الدفع</th>
        </tr>
        </thead>
        <tbody id="addRow" class="addRow">
        <tr class="font-size-12" style="font-weight: bold">
            <td>  </td>
            <td>  رصيد سابق</td>
            <td style="color: blue"> {{ number_format($MdenBefore,2, '.', ',') }} </td>
            <td style="color: red"> {{ number_format($DaenBefore,2, '.', ',') }} </td>
            <td>  </td>
            <td>  </td>
        </tr>

        @foreach($RepTable as $key=> $item)
            <tr class="font-size-12">
                <td> {{ $item->data }} </td>
                <td> {{ $item->order_date }} </td>
                <td> {{ $item->mden }} </td>
                <td> {{ $item->daen }} </td>
                <td> {{ $item->order_no }} </td>
                <td> {{ $item->type_name }} </td>
            </tr>
        @endforeach
        <tr class="font-size-12" style="font-weight: bold">
            <td>  </td>
            <td>  الإجمالي</td>
            <td style="color: blue"> {{ number_format($Mden,2, '.', ',') }} </td>
            <td style="color: red"> {{ number_format($Daen,2, '.', ',') }} </td>
            <td> {{ number_format($Mden-$Daen,2, '.', ',') }} </td>
            <td>  </td>
        </tr>
        </tbody>
    </table>
    {{ $RepTable->links('custom-pagination-links-view') }}

</div>

@push('scripts')


    <script type="text/javascript">
        window.addEventListener('mmsg',function(e){
            MyMsg.fire({
                confirmButtonText:  e.detail,
            })
        });
        Livewire.on('gotonext',postid=>  {
            if (postid=='tran_date') {  $("#tran_date").focus();$("#tran_date").select(); };
            if (postid=='jehano') {  $("#jehano").focus(); $("#jehano").select();};
        })

        window.addEventListener('ClosejehaModal', event => {
            $("#ModalRepjeha").modal('hide');
        })
        window.addEventListener('OpenjehaModal', event => {
            $("#ModalRepjeha").modal('show');
        })
    </script>


@endpush

