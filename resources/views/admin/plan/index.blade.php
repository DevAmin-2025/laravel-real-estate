@extends('admin.layouts.master')
@section('content')
    <x-admin_navbar/>
    <x-admin_sidebar/>
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex justify-content-between">
                <h1>Paid Plans</h1>
                <div class="ml-auto">
                    <a href="{{ route('admin.plans.create') }}" class="btn btn-primary"><i class="fas fa-plus m-2"></i>Create</a>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="example1">
                                        <thead>
                                            <tr>
                                                <th>SL</th>
                                                <th>Name</th>
                                                <th>Price</th>
                                                <th>Allowed Days</th>
                                                <th>Allowed Properties</th>
                                                <th>Allowed Featured Properties</th>
                                                <th>Allowed Photos</th>
                                                <th>Allowed Videos</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($plans as $plan)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $plan->name }}</td>
                                                    <td>${{ number_format($plan->price) }}</td>
                                                    <td>{{ displayLimit($plan->allowed_days) }}</td>
                                                    <td>{{ displayLimit($plan->allowed_properties) }}</td>
                                                    <td>{{ displayLimit($plan->allowed_featured_properties) }}</td>
                                                    <td>{{ displayLimit($plan->allowed_photos) }}</td>
                                                    <td>{{ displayLimit($plan->allowed_videos) }}</td>
                                                    <td>
                                                        <a href="{{ route('admin.plans.edit', $plan->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                                        <form action="{{ route('admin.plans.destroy', $plan->id) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
