<div x-data x-show="$wire.Show" class="row justify-content-center">
    <div class="col-md-6">

                    <table class="table table-sm table-bordered table-striped  w-100" >
                        <thead>
                        <tr style="background: #1c6ca1;color: white;text-align: center">
                            <th>الاسم</th>
                            <th>الحالة</th>
                            <th>بواسطة</th>
                            <th>اخر ظهور</th>
                            <th></th>
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
                                <td><img class="rounded-circle header-profile-user mt-0 pt-0" src="{{
                                      (!empty($user->profile_image))? url('upload/admin_images/'.$user->profile_image):
                                      url('upload/no_image.jpg')}}" ></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>


                {{ $users->links() }}

    </div>

</div>
