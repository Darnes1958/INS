<div x-data x-show="$wire.Show" class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Users</div>
            <div class="card-body">
                <div class="container">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>الاسم</th>
                            <th>الحالة</th>
                            <th>بواسطة</th>
                            <th>منذ</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{$user->name}}</td>
                                <td>
                                    @if(Cache::has('user-is-online-' . $user->id))
                                        <span class="text-success">متصل</span>
                                    @else
                                        <span class="text-secondary">غير متصل</span>
                                    @endif
                                </td>
                                <td>{{$user->DevType}}</td>
                                <td>{{ \Carbon\Carbon::parse($user->last_seen)->diffForHumans() }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
