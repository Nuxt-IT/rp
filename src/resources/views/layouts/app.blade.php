@extends('layouts.app')

@section('title', 'Role & Permissions Management')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">@yield('page-title', 'RP Management')</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item active">@yield('breadcrumb', 'RP')</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Minimalistic Navigation -->
    <div class="row mb-4">
        <div class="col-12">
            <nav class="d-flex gap-4">
                <a class="text-decoration-none text-dark @if(str_contains(Route::current()->getName(), 'rp.users')) border-bottom border-2 border-primary @endif" href="{{ route('rp.users.index') }}">
                    Users
                </a>
                <a class="text-decoration-none text-dark @if(str_contains(Route::current()->getName(), 'rp.roles')) border-bottom border-2 border-primary @endif" href="{{ route('rp.roles.index') }}">
                    Roles
                </a>
                <a class="text-decoration-none text-dark @if(str_contains(Route::current()->getName(), 'rp.permissions')) border-bottom border-2 border-primary @endif" href="{{ route('rp.permissions.index') }}">
                    Permissions
                </a>
            </nav>
        </div>
    </div>

    @yield('rp-content')
@endsection

