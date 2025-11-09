@extends('rp::layouts.app')

@section('page-title', 'Role Details')
@section('breadcrumb', 'Role Details')

@section('rp-content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0">Role Details: {{ $role->name }}</h5>
                        <div>
                            <a href="{{ route('rp.roles.edit', $role->id) }}" class="btn btn-warning">
                                <i class="ri-pencil-line align-middle me-1"></i> Edit
                            </a>
                            <a href="{{ route('rp.roles.index') }}" class="btn btn-secondary">
                                <i class="ri-arrow-left-line align-middle me-1"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">ID</th>
                                    <td>{{ $role->id }}</td>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <td><strong>{{ $role->name }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{ $role->created_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <th>Updated At</th>
                                    <td>{{ $role->updated_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6>Permissions</h6>
                            <div>
                                @forelse($role->permissions as $permission)
                                    <span class="badge bg-info me-1 mb-1">{{ $permission->name }}</span>
                                @empty
                                    <span class="text-muted">No permissions assigned</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

