@extends('admin.layout.app')

@section('content')

<div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
        <div class="row mt-4">
          <div class="col-8 offset-3 mt-5">
            <div class="col-md-9">
              <div class="card">
                <div class="card-header p-2">
                  <legend class="text-center">Change Password</legend>
                </div>
                <div class="card-body">

                  @if(Session::has('notMatchError'))
                  <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                     {{ Session::get('notMatchError') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                  @endif

                  @if(Session::has('notSameError'))
                  <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                     {{ Session::get('notSameError') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                  @endif

                  @if(Session::has('lengthError'))
                  <div class="alert alert-warning alert-dismissible fade show mt-2" role="alert">
                     {{ Session::get('lengthError') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                  @endif

                  @if(Session::has('success'))
                  <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                     {{ Session::get('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                  @endif

                  <div class="tab-content">
                    <div class="active tab-pane" id="activity">
                      <form class="form-horizontal" method="post" action="{{ route('admin#changePassword',Auth()->user()->id) }}" >
                        @csrf
                        <div class="form-group row">
                          <label for="inputPassword" class="col-sm-4 col-form-label">Old Password</label>
                          <div class="col-sm-8">
                            <input type="Password" name="oldPassword" class="form-control" value="{{ old('oldPassword') }}"  placeholder="Enter Old Password">
                            @if($errors->has('oldPassword'))
                            <p class="text-danger">{{ $errors->first('oldPassword') }}</p>
                            @endif
                           
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputPassword" class="col-sm-4 col-form-label">New Password</label>
                          <div class="col-sm-8">
                            <input type="password" name="newPassword" class="form-control" value="{{ old('newPassword') }}"  placeholder="Enter New Password">
                            @if($errors->has('newPassword'))
                            <p class="text-danger">{{ $errors->first('newPassword') }}</p>
                            @endif
                          
                          </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-4 col-form-label">Confirm Password</label>
                            <div class="col-sm-8">
                              <input type="password" name="confirmPassword" class="form-control" value="{{ old('confirmPassword') }}" placeholder="Enter Confirm Password">
                              @if($errors->has('confirmPassword'))
                              <p class="text-danger">{{ $errors->first('confirmPassword') }}</p>
                              @endif
                            
                            </div>
                          </div>

                        <div class="form-group row">
                          <div class="offset-sm-2 col-sm-10">
                            {{-- <a href=""></a> --}}

                          
                          </div>
                        </div>
                        <div class="form-group row ">
                          <div class="offset-sm-2 col-sm-10 ">
                            <button type="submit" class="btn bg-dark text-white">Changes</button>
                          </div>
                        </div>
                      </form>

                        {{-- <!-- Button trigger modal -->
                        <p type="button" class="text-primary float-end" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                          Change Password
                        </p> --}}
                    </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection

