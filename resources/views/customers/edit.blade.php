@extends('layout.app')

@section('content')
    <div class="card" style="max-width: 600px; margin: auto;">
        <div class="card-header bg-primary text-white">Edit Customer</div>
        <div class="card-body">
            <form action="{{ route('customers.update', $customer->id) }}" method="POST">
                @csrf
                @method('PUT')

                <h5 class="text-secondary mb-3">Account Info</h5>

                <div class="mb-3">
                    <label>Full Name</label>
                    <input type="text" name="name" class="form-control" required value="{{ $customer->name }}">
                </div>

                <div class="mb-3">
                    <label>Email Address</label>
                    <input type="email" name="email" class="form-control" required value="{{ $customer->email }}">
                </div>

                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control">
                    <small class="text-muted">Leave blank if you don't want to change password.</small>
                </div>

                <hr>
                <h5 class="text-secondary mb-3">Profile Info</h5>

                <div class="mb-3">
                    <label>Phone Number</label>
                    <input type="text" name="phone" class="form-control" placeholder="+62..."
                           value="{{ $customer->profile->phone ?? '' }}">
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Gender</label>
                        <select name="gender" class="form-select">
                            <option value="">-- Select --</option>
                            <option value="Male" {{ ($customer->profile->gender ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ ($customer->profile->gender ?? '') == 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Birth Date</label>
                        <input type="date" name="birth_date" class="form-control"
                               value="{{ $customer->profile->birth_date ?? '' }}">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100">Update Customer</button>
            </form>
        </div>
    </div>
@endsection
