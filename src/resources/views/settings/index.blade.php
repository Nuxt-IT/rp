@extends('rp::layouts.app')

@section('page-title', 'RP Settings')
@section('breadcrumb', 'Settings')

@section('rp-content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Role & Permissions Settings</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('rp.settings.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Settings</label>
                                    <p class="text-muted">Configure your role and permissions settings here.</p>
                                    <p class="text-muted">This section can be extended with custom settings as needed.</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Save Settings</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

