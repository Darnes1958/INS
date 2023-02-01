<div x-data="{ 'openacc': false }">
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
    <div  x-show="openacc"  >
        <label   class="form-label  mx-1 ri-search-2-line" style="color: blue">&nbsp;برقم الحساب أو الإسم &nbsp;</label>
        @livewire('haf.search-acc',['sender'=>'haf.haf-mini-rep','bank'=>$bank])
    </div>

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
                    <td ><i @click="openacc = true" class="btn btn-primary btn-sm fa fa-check-circle"
                        wire:click="$emitTo('haf.search-acc','TakeBankAndAcc',{{$bank}},'{{$item->acc}}')"></i></td>
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



@endpush

