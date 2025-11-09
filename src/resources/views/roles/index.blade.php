@extends('rp::layouts.app')

@section('page-title', 'Roles Management')
@section('breadcrumb', 'Roles')

@section('rp-content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0">Roles</h5>
                        <a href="{{ route('rp.roles.create') }}" class="btn btn-primary">
                            <i class="ri-add-line align-middle me-1"></i> Add New Role
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('rp.roles.index') }}" class="mb-3">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="Search roles..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">Search</button>
                            </div>
                            @if(request('search'))
                            <div class="col-md-2">
                                <a href="{{ route('rp.roles.index') }}" class="btn btn-secondary w-100">Clear</a>
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
                                    <th>Permissions</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($roles as $role)
                                    <tr>
                                        <td>{{ $role->id }}</td>
                                        <td><strong>{{ $role->name }}</strong></td>
                                        <td>
                                            @foreach($role->permissions as $permission)
                                                <span class="badge bg-info">{{ $permission->name }}</span>
                                            @endforeach
                                            @if($role->permissions->isEmpty())
                                                <span class="text-muted">No permissions</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('rp.roles.show', $role->id) }}" class="btn btn-sm btn-info">
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                                <a href="{{ route('rp.roles.edit', $role->id) }}" class="btn btn-sm btn-warning">
                                                    <i class="ri-pencil-line"></i>
                                                </a>
                                                <form action="{{ route('rp.roles.destroy', $role->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this role?');">
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
                                        <td colspan="4" class="text-center">No roles found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $roles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

