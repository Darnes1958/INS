<div x-data>
    <div class="form-check form-check-inline">
        <input wire:model="search"  type="search"  style="margin: 5px;" placeholder="ابحث هنا .......">
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" wire:model="DisRadio"
               name="inlineRadioOptions" id="inlineRadio1" value="DisAll">
        <label class="form-check-label" for="inlineRadio1">عرض الكل</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" wire:model="DisRadio"
               name="inlineRadioOptions" id="inlineRadio2" value="DisMe">
        <label class="form-check-label" for="inlineRadio2">عرض ادخالاتي فقط</label>
    </div>
    <div  class="form-check form-check-inline">
        <a  href="{{route('pdfhafmini',['hafitha'=>$hafitha,'rep_type'=>$rep_type,'DisRadio'=>$DisRadio])}}"
            class="btn btn-outline-primary btn-sm fas fa-print"></a>
    </div>
    @if($openacc)
        <div   class="my-2" style="border: solid 1px;">
            <div class="row px-2">
                <div class="col-md-6">
                    <label   class="form-label   " style="color: blue">&nbsp;ادخل رقم العقد &nbsp;</label>
                    <input wire:model="NoToEdit"  wire:keydown.Enter="ChkNoToEdit" type="number" class=" form-control "
                           id="bank_no"   autofocus >
                </div>
                <div class="col-md-6 ">
                    <label   class="form-label   " style="color: blue">&nbsp;رقم الحساب &nbsp;</label>
                    <input wire:model="OldAcc"   class=" form-control " readonly >
                </div>
                <div class="col-md-6 my-2">
                    <label   class="form-label  " style="color: blue">&nbsp;الاسم &nbsp;</label>
                    <input wire:model="name"   class=" form-control " readonly >
                </div>
                @if($showbtn)
                    <div  class="col-md-6 my-2 py-3" >

                        <input type="button"  id="SaveAccBtn"

                               class=" btn btn-outline-success  waves-effect waves-light "
                               wire:click.prevent="SaveNewAcc"  value="تعديل رقم الحساب" />
                    </div>
                @endif

            </div>



        </div>
    @endif


    <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
        <thead class="font-size-12">
        <tr>
            <th width="6%">ت</th>
            <th width="14%">رقم العقد</th>
            <th width="18%">رقم الحساب</th>
            @if ($rep_type==4)
            <th width="4%"></th>
            @endif
            <th >الاسم</th>
            <th width="10%">القسط</th>
            <th width="10%">الباقي</th>
        </tr>
        </thead>
        <tbody id="addRow" class="addRow">
        @foreach($HafithaTable as $item)
            <tr class="font-size-12">
                <td > {{ $item->ser_in_hafitha }} </td>
                <td > {{ $item->no }} </td>
                <td> {{ $item->acc }} </td>
                @if ($rep_type==4)
                    <td ><i  class="btn btn-primary btn-sm fa fa-check-circle"
                        wire:click="selectItem('{{$item->acc}}')"></i></td>
                @endif
                <td> {{ $item->name }} </td>
                <td> {{ $item->kst }} </td>
                <td> {{ $item->baky }} </td>
            </tr>

        @endforeach
        </tbody>
    </table>
    {{ $HafithaTable->links() }}
</div>

@push('scripts')
    <script type="text/javascript">
        window.addEventListener('mmsg',function(e){
            MyMsg.fire({
                confirmButtonText:  e.detail,
            })
        });
        Livewire.on('hafmini_goto',postid=>  {
            if (postid=='SaveAccBtn') {
                setTimeout(function() { document.getElementById('SaveAccBtn').focus(); },100);}
        })
    </script>
@endpush

