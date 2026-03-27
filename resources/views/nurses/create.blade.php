@extends('layouts.app')

@section('content')
<h3>Add Nurse</h3>

<form method="POST" action="{{ route('nurses.store') }}">
    @csrf

    <div class="row">
        <div class="col-md-6 mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="col-md-6 mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="col-md-6 mb-3">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control">
        </div>

        <div class="col-md-6 mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="col-md-6 mb-3">
            <label>Employee Code</label>
            <input type="text" name="employee_code" class="form-control" required>
        </div>

        <div class="col-md-6 mb-3">
            <label>Department</label>
            <input type="text" name="department" class="form-control">
        </div>

        <div class="col-md-6 mb-3">
            <label>Designation</label>
            <input type="text" name="designation" class="form-control">
        </div>

        <div class="col-md-6 mb-3">
            <label>Join Date</label>
            <input type="date" name="join_date" class="form-control">
        </div>

        <div class="col-md-6 mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="active">active</option>
                <option value="inactive">inactive</option>
            </select>
        </div>
    </div>

    <button class="btn btn-success">Save</button>
</form>
@endsection