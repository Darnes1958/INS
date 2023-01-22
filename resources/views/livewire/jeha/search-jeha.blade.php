<div x-data>
    <!-- CSS -->
    <style type="text/css">
        .search-box .clear{
            clear:both;
            margin-top: 20px;
        }

        .search-box ul{
            list-style: none;
            padding: 0px;
            width: 500px;
            position: absolute;
            margin: 0;
            background: white;
        }

        .search-box ul li{
            background: lavender;
            padding: 4px;
            margin-bottom: 1px;
        }

        .search-box ul li:nth-child(even){
            background: cadetblue;
            color: white;
        }

        .search-box ul li:hover{
            cursor: pointer;
        }

        .search-box input[type=text]{

            padding: 5px;

            letter-spacing: 1px;
        }
    </style>

    <div  class="search-box w-100" >
        <input class="form-control " type='text' ID="search_box"
             wire:model="search"  @keyup.enter="$wire.Goto" wire:keyup="searchResult">

        <!-- Search result list -->
        @if($showdiv)

            <div style="height: 200px" >
            <ul id="el">
                @if(!empty($records))
                    @foreach($records as $record)

                        <li   wire:click="fetchEmployeeDetail({{ $record->jeha_no }})">{{ $record->jeha_name}}</li>

                    @endforeach
                @endif
            </ul>
            </div>
            <div class="clear"></div>
        @endif
    </div>
</div>
@push('scripts')
    <script type="text/javascript">
        Livewire.on('gotonext',postid=> {

            if (postid == 'search') {
                $("#search").focus(); $("#search").select();
            }

        })

    </script>
@endpush

