<div x-data>




    <div class="row">

    <div class="col-6">

        <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >

        <caption class="caption-top">إضفط علي <span class="btn btn-outline-primary btn-sm fa fa-info"></span> لعرض الازداوجية</caption>
        <thead class="font-size-12">
        <tr>
            <th width="14%">رقم العقد</th>
            <th width="20%">رقم الحساب</th>
            <th >الاسم</th>
            <th width="10%">القسط</th>
            <th></th>
        </tr>
        </thead>
        <tbody id="addRow" class="addRow">
        @foreach($ManyNo as $item)
            <tr class="font-size-12">
                <td> {{ $item->no }} </td>
                <td> {{ $item->acc }} </td>
                <td> {{ $item->name }} </td>
                <td> {{ $item->kst }} </td>
                <td class="text-center">
                    <i  class="btn btn-outline-primary btn-sm fa fa-info"
                        wire:click="TakeNoAcc({{$item->no}},'{{$item->acc}}')" ></i>
                </td>
            </tr>

        @endforeach
        </tbody>
    </table>
    {{ $ManyNo->links() }}
    </div >
        <div class="col-6">

            <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
          @if(count($Mains)>0)  <caption
                class="caption-top text-center"> العقود القائمة للحساب  <span class="text-primary">{{$Mains[0]->acc}}</span></caption>@endif
            <thead class="font-size-12">
            <tr>
                <th width="12%">رقم العقد</th>
                <th >الاسم</th>
                <th width="12%">القسط</th>
                <th width="35%"></th>
            </tr>
            </thead>
            <tbody id="addRow" class="addRow">
            @foreach($Mains as $item)
                <tr class="font-size-12">
                    <td > {{ $item->no }} </td>

                    <td> {{ $item->name }} </td>
                    <td> {{ $item->kst }} </td>
                    <td>
                        <i  class="btn btn-outline-primary btn-sm border-0"
                            wire:click="TakeTheNo({{$no}},{{$item->no}})" >تغيير رقم العقد إلي : <span class="text-success">{{$no}}</span></i>
                    </td>
                </tr>

            @endforeach
            </tbody>
        </table>
        </div>

    </div>
</div>

@push('scripts')
    <script type="text/javascript">
        window.addEventListener('mmsg',function(e){
            MyMsg.fire({
                confirmButtonText:  e.detail,
            })
        });
    </script>
@endpush

