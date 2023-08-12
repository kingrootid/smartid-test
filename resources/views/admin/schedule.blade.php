@extends('template')
@section('view')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0" style="display: flex; justify-items:center; justify-content:space-between;">
                <h6>{{ $page }}</h6>
                <div class=" align-self-end">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".modalAdd"><i class="fas fa-plus-square"></i> Add New</button>
                </div>
            </div>
            <div class="card-body">
                <div class="dt-responsive table-responsive">
                    <table id="simpletable" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Akhir</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg modalAdd" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="myLargeModalLabel">Tambah Jadwal Pengisian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="add" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="status" value="add">
                    <div class="form-group">
                        <label>Tanggal Dimulai</label>
                        <input type="date" class="form-control" name="date_start">
                    </div>
                    <div class="form-group">
                        <label>Tanggal Diakhiri</label>
                        <input type="date" class="form-control" name="date_end">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Tambahkan</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg modalEdit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="myLargeModalLabel">Edit Jadwal Pengisian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="edit" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="status" value="edit">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="form-group">
                        <label>Tanggal Dimulai</label>
                        <input type="date" class="form-control" id="edit_date_start" name="date_start">
                    </div>
                    <div class="form-group">
                        <label>Tanggal Diakhiri</label>
                        <input type="date" class="form-control" id="edit_date_end" name="date_end">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Edit</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg modalHapus" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="myLargeModalLabel">Hapus Jadwal Pengisian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="hapus" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="status" value="hapus">
                    <input type="hidden" id="hapus_id" name="id">
                    <div class="form-group">
                        <label>Tanggal Dimulai</label>
                        <input type="date" class="form-control" disabled id="hapus_date_start" name="date_start">
                    </div>
                    <div class="form-group">
                        <label>Tanggal Diakhiri</label>
                        <input type="date" class="form-control" disabled id="hapus_date_end" name="date_end">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Hapus</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    var columns = [{
            data: 'id',
            name: 'id'
        },
        {
            data: 'date_start',
            name: 'date_start'
        },
        {
            data: 'date_end',
            name: 'date_end'
        },
        {
            data: 'action',
            name: 'action',
            orderable: false
        }
    ]
    var url = "{{ url('data/schedule') }}";
    renderDataTable(url, columns);
    $("#add").submit(function(event) {
        event.preventDefault();
        var form = new FormData(this);
        form.append('_token', token);
        axios.post("{{url('ajax/schedule')}}", form)
            .then(response => {
                $(".modalAdd").modal('hide');
                if (response.data.status) {
                    setTimeout(function() {
                        Swal.fire({
                            text: response.data.message,
                            icon: 'success',
                            buttonsStyling: false,
                            confirmButtonText: 'Ok, got it!',
                            customClass: {
                                confirmButton: 'btn font-weight-bold btn-primary',
                            },
                        }).then(function() {
                            $(".modalAdd").modal('hide');
                            table.ajax.reload();
                        });
                    }, 200);
                } else {
                    setTimeout(function() {
                        Swal.fire({
                            text: response.data.message,
                            icon: 'error',
                            buttonsStyling: false,
                            confirmButtonText: 'Ok lets check',
                            customClass: {
                                confirmButton: 'btn font-weight-bold btn-danger',
                            },
                        });
                    }, 200);
                }
            })
            .catch(error => {
                $(".modalAdd").modal('hide')
                setTimeout(function() {
                    Swal.fire({
                        text: error.message,
                        icon: 'error',
                        buttonsStyling: false,
                        confirmButtonText: 'Ok lets check',
                        customClass: {
                            confirmButton: 'btn font-weight-bold btn-danger',
                        },
                    });
                }, 200)
            });
    })

    function edit(id) {
        $(".modalEdit").modal('show');
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{url('data/schedule')}}/" + id,
            success: function(data) {
                $("#edit_id").val(data.id);
                $("#edit_date_start").val(data.date_start);
                $("#edit_date_end").val(data.date_end);
            }
        })
    }
    $("#edit").submit(function(event) {
        event.preventDefault();
        var form = new FormData(this);
        form.append('_token', token);
        axios.post("{{url('ajax/schedule')}}", form)
            .then(response => {
                $(".modalEdit").modal('hide');
                if (response.data.status) {
                    setTimeout(function() {
                        swal.fire({
                            text: response.data.message,
                            icon: 'success',
                            buttonsStyling: false,
                            confirmButtonText: 'Ok, got it!',
                            customClass: {
                                confirmButton: 'btn font-weight-bold btn-primary',
                            },
                        }).then(function() {
                            $(".modalEdit").modal('hide');
                            table.ajax.reload();
                        });
                    }, 200);
                } else {
                    setTimeout(function() {
                        swal.fire({
                            text: response.data.message,
                            icon: 'error',
                            buttonsStyling: false,
                            confirmButtonText: 'Ok lets check',
                            customClass: {
                                confirmButton: 'btn font-weight-bold btn-danger',
                            },
                        });
                    }, 200);
                }
            })
            .catch(error => {
                $(".modalEdit").modal('hide')
                setTimeout(function() {
                    swal.fire({
                        text: error.message,
                        icon: 'error',
                        buttonsStyling: false,
                        confirmButtonText: 'Ok lets check',
                        customClass: {
                            confirmButton: 'btn font-weight-bold btn-danger',
                        },
                    });
                }, 200)
            });
    })

    function hapus(id) {
        $(".modalHapus").modal('show');
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{url('data/schedule')}}/" + id,
            success: function(data) {
                $("#hapus_id").val(data.id);
                $("#hapus_date_start").val(data.date_start);
                $("#hapus_date_end").val(data.date_end);
            }
        })
    }
    $("#hapus").submit(function(event) {
        event.preventDefault();
        var form = new FormData(this);
        form.append('_token', token);
        axios.post("{{url('ajax/schedule')}}", form)
            .then(response => {
                $(".modalHapus").modal('hide');
                if (response.data.status) {
                    setTimeout(function() {
                        swal.fire({
                            text: response.data.message,
                            icon: 'success',
                            buttonsStyling: false,
                            confirmButtonText: 'Ok, got it!',
                            customClass: {
                                confirmButton: 'btn font-weight-bold btn-primary',
                            },
                        }).then(function() {
                            $(".modalHapus").modal('hide');
                            table.ajax.reload();
                        });
                    }, 200);
                } else {
                    setTimeout(function() {
                        swal.fire({
                            text: response.data.message,
                            icon: 'error',
                            buttonsStyling: false,
                            confirmButtonText: 'Ok lets check',
                            customClass: {
                                confirmButton: 'btn font-weight-bold btn-danger',
                            },
                        });
                    }, 200);
                }
            })
            .catch(error => {
                $(".modalHapus").modal('hide')
                setTimeout(function() {
                    swal.fire({
                        text: error.message,
                        icon: 'error',
                        buttonsStyling: false,
                        confirmButtonText: 'Ok lets check',
                        customClass: {
                            confirmButton: 'btn font-weight-bold btn-danger',
                        },
                    });
                }, 200)
            });
    })
</script>
@endsection