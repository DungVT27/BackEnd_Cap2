@extends('layouts.master')
@section('tittle')
    {{ $title }}
@endsection

@section('content')
    <main id="main" class="main">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-1"></i>
                {{ session('success') }}
                {{ session()->forget('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-1"></i>
                {{ session('warning') }}
                {{ session()->forget('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="pagetitle">
            <h1>Users</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="\dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active">Rooms</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <section class="section dashboard">
            <div class="col-xxl-4 col-md-12">
                <div class="card info-card revenue-card">
                    {{-- <form action="" method="post">
                    @csrf
                    @method('DELETE') --}}
                    <div class="card-body">
                        <h5 class="card-title">Personal tour <span>|
                                List</span></h5>
                        {{-- <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash"></i>
                        </button> --}}
                        <div class="d-flex align-items-center">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col">#</th>
                                        <th scope="col">Owner</th>
                                        <th scope="col">Tour</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Description</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tours as $key => $tour)
                                        <tr>
                                            <th scope="row">
                                                <div class="form-check">
                                                    <input id="id" class="form-check-input user-check"
                                                        type="checkbox" name="id" id="flexCheckDefault">
                                                </div>
                                            </th>
                                            <th scope="row">{{ ++$key }}</th>
                                            <td>{{ $tour->name }}</td>
                                            <td>{{ $tour->name }}</td>
                                            <td>{{ $tour->price }}</td>
                                            <td style="max-width: 180px;">{{ $tour->description }}</td>
                                            <td style="width: 66px;">
                                                <button type="button" class="btn btn-outline-danger user_list_btn"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal{{ $tour->id }}">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <!-- Modal -->
                                        <form action="{{ route('tst.destroy', ['tour' => $tour->id]) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal fade" id="exampleModal{{ $tour->id }}" tabindex="0"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">
                                                                Remove</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to remove room
                                                            <b> {{ $tour->name }} </b>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit"
                                                                class="btn btn-danger w-100px">Remove</button>
                                                            <button type="button" class="btn btn-secondary w-100px"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div>
                            {{ $tours->links() }}
                        </div>
                    </div>
                    {{-- </form> --}}
                </div>
            </div>
        </section>
    </main>
@endsection
