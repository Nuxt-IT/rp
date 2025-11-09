@extends('rp::layouts.app')

@section('page-title', 'Permissions Management')
@section('breadcrumb', 'Permissions')

@section('rp-content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0">Permissions</h5>
                        <a href="{{ route('rp.permissions.create') }}" class="btn btn-primary">
                            <i class="ri-add-line align-middle me-1"></i> Add New Permission
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('rp.permissions.index') }}" class="mb-3">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="Search permissions..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">Search</button>
                            </div>
                            @if(request('search'))
                            <div class="col-md-2">
                                <a href="{{ route('rp.permissions.index') }}" class="btn btn-secondary w-100">Clear</a>
                            </div>
                            @endif
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Roles</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($permissions as $permission)
                                    <tr>
                                        <td>{{ $permission->id }}</td>
                                        <td><strong>{{ $permission->name }}</strong></td>
                                        <td>
                                            @foreach($permission->roles as $role)
                                                <span class="badge bg-primary">{{ $role->name }}</span>
                                            @endforeach
                                            @if($permission->roles->isEmpty())
                                                <span class="text-muted">No roles</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('rp.permissions.show', $permission->id) }}" class="btn btn-sm btn-info">
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                                <a href="{{ route('rp.permissions.edit', $permission->id) }}" class="btn btn-sm btn-warning">
                                                    <i class="ri-pencil-line"></i>
                                                </a>
                                                <form action="{{ route('rp.permissions.destroy', $permission->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this permission?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No permissions found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $permissions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

