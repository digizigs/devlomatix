@extends('layouts.admin')

@section('title','Role')

@section('role','active')

@section('style')
@endsection


@section('content')

    <div class="wrapper card p-2">
        <div class="">
            <h4><b>Roles</b> <div class="float-right"><a href="{{route('role.create')}}" class="btn btn-primary btn-sm">Add Role</a></div></h4>
        </div>
        <div data-label="Example" class="mt-2">
            <table id="datatable" class="table table-color-primary">
                <thead>
                <tr style="">
                    <th style="" class=""><b>Name</b></th>
                    <th style="" class=""><b>Description</b></th>
                    <th style="" class=""><b>Permissions</b></th>
                    <th style="" class=""><b>Created</b></th>
                    <th style="" class=""><b>Actions</b></th>
                </tr>
                </thead>

                <tbody>
                </tbody>

            </table>
        </div>
    </div>

@endsection


@section('modal')



@endsection


@section('scripts')
    <script src="{{asset('public/assets/plugins/datatables.net/js/jquery.dataTables.min.js')}}"></script>

    <script>
        $(function(){
        'use strict'


        //Datatable
        $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('role.index') !!}',
            columns:[
                { data: 'name', name: 'name'},
                { data: 'description', name: 'description'},
                { data: 'permission', name: 'permission'},
                { data: 'created_at', name: 'created_at' },
                { data: 'action', name: 'action' },
            ]
        });


        //Action Delete function
        $(document).on('click','.delete',function(){
            var id =  $(this).attr('id');
            swalWithBootstrapButtons({
                title: "Delete Selected Role?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Delete",
                cancelButtonText: "Cancel",
                reverseButtons: true
            }).then(result => {
                if (result.value) {
                $.ajax({
                    url: "role/"+id,
                    type:"post",
                    data: {_method: 'delete', _token: "{{ csrf_token() }}"},
                    success: function(result){
                        location.reload();
                        toast({
                            type: "success",
                            title: "Role Deleted Successfully"
                        });
                    }
                });
                }
            });
        });


        });
    </script>

@endsection
