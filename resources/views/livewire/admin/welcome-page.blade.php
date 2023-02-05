<div>
  <div class="row my-4 mx-4">
    <h1 style="color: #0a53be">مرحبا بكم</h1>
    <br>
    <br>
    <br>
    <h1 style="color: #7a5a21">{{$CompanyName}}</h1>
    <h3>{{$CompanyNameSuffix}}</h3>
      @role('admin')
      <div class="row justify-content-center">
          <div class="col-md-8">
              <div class="card">
                  <div class="card-header">Users</div>
                  <div class="card-body">
                      <div class="container">
                          <table class="table table-sm table-bordered table-striped  ">
                              <thead>
                              <tr >
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
                      </div>
                  </div>
              </div>
          </div>
      </div>
      @endrole

  </div>
</div>
