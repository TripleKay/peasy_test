@extends('layouts.master')
@section('page', 'Users')
@section('page-info', 'All Users List')

@section('content')
    <div class="card">
        <div class="content d-flex flex-column flex-column-fluid" id="content">
            <div class="post d-flex flex-column-fluid" id="kt_post">
                <div id="kt_content_container" class="container-xxl">
                        <div class="card card-flush">
                            <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                            <div class="card-title">
                                <div class="d-flex align-items-center position-relative my-1">
                                    <span class="svg-icon svg-icon-1 position-absolute ms-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                            <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                                        </svg>
                                    </span>
                                    <input type="text" data-kt-ecommerce-product-filter="search" class="form-control form-control-solid w-250px ps-14" />
                                </div>
                                <div class="d-flex align-items-center gap-2 gap-lg-3 ms-2 my-2">
                                    <a href="" type="button" class="btn btn-sm btn-flex d-block btn-primary text-uppercase py-3">
                                        Search
                                    </a>
                                </div>
                                <!--end::Search-->
                            </div>
                            <!--end::Card title-->
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                                <div class="w-100 mw-250px">
                                    <select class="form-select form-select-solid" id="gender" name="gender">
                                        <option value="all">All</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                            </div>
                            <!--end::Card toolbar-->
                        </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <table class="table align-middle table-row-dashed fs-6 gy-5">
                                    <thead>
                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                            <th>#</th>
                                            <th>UUID</th>
                                            <th>Title</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Gender</th>
                                            <th>Age</th>
                                            <th>Location</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="userTable" class="fw-bold text-gray-600 draggable-zone">
                                        @foreach ($data as $index => $each)
                                            <tr class="draggable w-100">
                                                <td class="">{{ $index+1 }}</td>
                                                <td>{{ $each->uuid }}</td>
                                                <td>{{ $each->name['title'] }}</td>
                                                <td>{{ $each->name['first'] }}</td>
                                                <td>{{ $each->name['last'] }}</td>
                                                <td>{{ $each->gender }}</td>
                                                <td>{{ $each->age }}</td>
                                                <td>{{ $each->location['city'] }}, {{ $each->location['country'] }}</td>
                                                <td>
                                                    <div class="d-flex justify-content-end flex-shrink-0">
                                                        <a href="#" class="btn btn-icon btn-icon-danger btn-sm" data-kt-users-table-filter="delete_row" data-id="{{$each->id}}" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $each->id }}">
                                                            <span class="svg-icon svg-icon-3">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                                                    <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor"></path>
                                                                    <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor"></path>
                                                                    <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor"></path>
                                                                </svg>
                                                            </span>
                                                        </a>
                                                        <div class="modal fade" id="deleteModal{{ $each->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-body border-0 mx-auto text-center">
                                                                        <form action="" method="POST">
                                                                            <input type="hidden" name="delete_id" id="delete_id" value="{{$each->id}}">
                                                                            @csrf @method('delete')
                                                                            <div class="swal2-icon swal2-warning swal2-icon-show mb-7" style="display: flex;">
                                                                                <div class="swal2-icon-content">!</div>
                                                                            </div>
                                                                            <h5 class="mb-4" style="letter-spacing: 1px;">Are you sure you want to delete this？</h5>
                                                                            <p class="text-secondary mb-5">This action cannot be undone.</p>
                                                                            <button type="button" data-bs-dismiss="modal" class="btn btn-sm btn-secondary">
                                                                                <i class="bi bi-x-lg"></i>Cancel</button>
                                                                            <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash text-white"></i>Delete</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!--end::Card body-->
                        </div>
                </div>
            </div>
        </div>
    </div>
{{-- <div class="container mt-5">
    <div class="row mb-3">
        <div class="col-md-4">
            <input type="text" id="search" class="form-control" placeholder="Search">
        </div>
        <div class="col-md-4">
            <select id="gender" class="form-control">
                <option value="all">All</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
        </div>
    </div>
    <table class="table table-striped table-responsive">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Gender</th>
            </tr>
        </thead>
        <tbody id="userTable">
        </tbody>
    </table>
</div> --}}

<script>
    $(document).ready(function() {
        function fetchData() {
            var search = $('#search').val();
            var gender = $('#gender').val();

            $.ajax({
                url: '/users',
                type: 'GET',
                data: {
                    search: search,
                    gender: gender
                },
                success: function(data) {
                    var rows = '';
                    data.forEach(function(user) {
                        rows += `
                            <tr>
                                <td>${user.name}</td>
                                <td>${user.email}</td>
                                <td>${user.gender}</td>
                            </tr>
                        `;
                    });
                    $('#userTable').html(rows);
                }
            });
        }

        fetchData();

        $('#search').on('input', fetchData);
        $('#gender').on('change', fetchData);
    });
</script>
@endsection
