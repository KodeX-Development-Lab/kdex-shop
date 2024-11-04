@extends('ecommerce.layout.master')
@section('content')
    <div class="container-fluid">
        <form action="{{ route('employee.update',$employee->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method("PUT")
            <div class="row">
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">Image</label>
                                <div class="prevImg">
                                    <img src="{{ asset('storage/'.$employee->image) }}" class=" img-thumbnail pp">
                                </div>
                                <input type="file" name="image" id="image" class=" form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Name</label>
                                <input type="text" name="name" value="{{ $employee->name }}" class=" form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="email" name="email" value="{{ $employee->email }}" class=" form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Phone</label>
                                <input type="number" name="phone" value="{{ $employee->phone }}" class=" form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Address</label>
                                <input type="text" name="address" value="{{ $employee->address }}" class=" form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Password</label>
                                <input type="password" name="password" class=" form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Employee Id</label>
                                <input type="text" name="employee_id" value="{{ $employee->employee_id }}" class=" form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Nrc Number</label>
                                <input type="text" name="nrc_number" value="{{ $employee->nrc_number }}" class=" form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">Pin Code</label>
                                <input type="text" name="pin_code" value="{{ $employee->pin_code }}" class=" form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Role</label>
                                <select name="role[]" id="" class=" form-control">
                                    @foreach ($role as $d)
                                        <option value="{{ $d->name }}" @if  (in_array($d->name,$oldRole)) selected @endif>{{ $d->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Department</label>
                                <select name="department_id" id="" class=" form-control">
                                    @foreach ($department as $d)
                                        <option value="{{ $d->id }}" @if ($d->id == $employee->department_id) selected @endif>{{ $d->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Gender</label>
                                <select name="gender" id="" class=" form-control">
                                    <option value="female" @if ($employee->gender == 'female') selected @endif>Female</option>
                                    <option value="male" @if ($employee->gender == 'male') selected @endif>Male</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Birthday</label>
                                <input type="date" class=" form-control" value="{{ $employee->birthday }}" name="birthday">
                            </div>
                            <div class="form-group">
                                <label for="">Join Date</label>
                                <input type="date" value="{{ $employee->join_date }}" class=" form-control" name="join_date">
                            </div>
                            <div class="form-group">
                                <label for="">Is present</label>
                                <select name="is_present" id="" class=" form-control">
                                    <option value="1" @if ($employee->is_present == 1) selected @endif>Is present</option>
                                    <option value="0" @if ($employee->is_present == 0) selected @endif>Leave</option>
                                </select>
                            </div>
                            <button class=" btn btn-primary w-100">Comfirm</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('script')
    {!! JsValidator::formRequest('App\Http\Requests\updateEmployee') !!}
    <script>
        $(document).ready(function() {
            $('#image').on('change', function() {
                let imgLength = document.getElementById('image').files.length
                $('.prevImg').html('')
                for (var i = 0; i < imgLength; i++) {
                    $('.prevImg').append(
                        `<img class=" img-thumbnail" src="${URL.createObjectURL(event.target.files[i])}">`
                    )
                }
            })
        })
    </script>
@endsection
