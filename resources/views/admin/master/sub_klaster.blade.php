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
                                <th>Klaster</th>
                                <th>Name</th>
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
                <h5 class="modal-title h4" id="myLargeModalLabel">Tambah Sub Klaster</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="add" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="status" value="add">
                    <div class="form-group">
                        <label>Klaster</label>
                        <select class="form-select" name="master_klaster_uuid">
                            <option value="null">Silahkan Pilih Klaster Dahulu</option>
                            @foreach($klaster as $k)
                            <option value="{{ $k['uuid'] }}">{{ $k['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Mohon Masukan Nama Sub Klaster">
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <td>Nama Field</td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody id="tbody_add">
                                <tr>
                                    <td>
                                        <input class="form-control" name="field[]" placeholder="Masukan Nama Field Inputan">
                                    </td>
                                    <td>
                                        <button class="btn btn-success" type="button" id="add_rows"><i class="fas fa-plus-square"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
                <h5 class="modal-title h4" id="myLargeModalLabel">Edit Sub Klaster</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="edit" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="status" value="edit">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="form-group">
                        <label>Klaster</label>
                        <select class="form-select" id="edit_master_klaster_uuid" name="master_klaster_uuid">
                            <option value="null">Silahkan Pilih Klaster Dahulu</option>
                            @foreach($klaster as $k)
                            <option value="{{ $k['uuid'] }}">{{ $k['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name" placeholder="Mohon Masukan Nama klaster">
                    </div>
                    <div class="table-responsive" id="edit_table"></div>
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
                <h5 class="modal-title h4" id="myLargeModalLabel">Hapus Sub Klaster</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="hapus" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="status" value="hapus">
                    <input type="hidden" id="hapus_id" name="id">
                    <div class="form-group">
                        <label>Klaster</label>
                        <select class="form-select" disabled id="hapus_master_klaster_uuid" name="master_klaster_uuid">
                            <option value="null">Silahkan Pilih Klaster Dahulu</option>
                            @foreach($klaster as $k)
                            <option value="{{ $k['uuid'] }}">{{ $k['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" readonly id="hapus_name" name="name" placeholder="Mohon Masukan Nama klaster">
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
            data: 'master_klaster_uuid',
            name: 'master_klaster_uuid'
        },
        {
            data: 'name',
            name: 'name'
        },
        {
            data: 'action',
            name: 'action',
            orderable: false
        }
    ]
    var url = "{{ url('data/sub-klaster') }}";
    renderDataTable(url, columns);
    let rows = 0;
    $("#add_rows").click(function() {
        $("#tbody_add").append(
            `
            <tr id="add_tr_${rows}">
                <td>
                    <input class="form-control" name="field[]" placeholder="Masukan Nama Field Inputan">
                </td>
                <td>
                    <button class="btn btn-danger" type="button" onclick="deleteRows('add', ${rows})"><i class="fas fa-times"></i></button>
                </td>
            </tr>
            `
        )
        rows++;
    })

    function deleteRows(position, index) {
        $(`#${position}_tr_${index}`).css('display', 'none');
        $(`.${position}_input_${index}`).attr('name', 'old[]')
    }
    $("#add").submit(function(event) {
        event.preventDefault();
        var form = new FormData(this);
        form.append('_token', token);
        axios.post("{{url('ajax/sub-klaster')}}", form)
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


    function addRows(section, rows) {
        $(`#tbody_${section}`).append(`
        <tr id="${section}_tr_${rows}">
                <td>
                    <input class="form-control" name="field[]" placeholder="Masukan Nama Field Inputan">
                </td>
                <td>
                    <button class="btn btn-danger" type="button" onclick="deleteRows('edit', ${rows})"><i class="fas fa-times"></i></button>
                </td>
            </tr>
        `)
    }

    function edit(id) {
        let idInput = 0;
        $(".modalEdit").modal('show');
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{url('data/sub-klaster')}}/" + id,
            success: function(data) {
                $("#edit_id").val(data.subklaster.id);
                $("#edit_name").val(data.subklaster.name);
                $("#edit_master_klaster_uuid").val(data.subklaster.master_klaster_uuid);

                var html = `
                        <table class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <td>Nama Field</td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody id="tbody_edit">
                               
                `;
                if (!data.input.length) {
                    console.log("🚀 ~ file: sub_klaster.blade.php:268 ~ edit ~ data.input:", data.input)
                    html += `
                    <tr id="edit_tr_${idInput}">
                                    <td>
                                        <input class="form-control" name="field[]" placeholder="Masukan Nama Field Inputan">
                                    </td>
                                    <td>
                                    <button class="btn btn-success" type="button" onclick="addRows('edit', ${idInput})"><i class="fas fa-plus-square"></i></button>
                                    </td>
                                </tr>`
                }
                for (let input of data.input) {
                    html += `
                    <tr id="edit_tr_${idInput}">
                                    <td>
                                        <input class="form-control edit_input_${idInput}" name="field[]" value="${input.name}" placeholder="Masukan Nama Field Inputan">
                                    </td>
                                    <td>`
                    if (idInput == 0) {
                        html += `
                                        <button class="btn btn-success" type="button" onclick="addRows('edit', ${data.input.length})"><i class="fas fa-plus-square"></i></button>
`
                    } else {
                        html += `
                    <button class="btn btn-danger" type="button" onclick="deleteRows('edit', ${idInput})"><i class="fas fa-times"></i></button>
`
                    }
                    html += `
                                    </td>
                                </tr>`

                    idInput++;
                }
                console.log("🚀 ~ file: sub_klaster.blade.php:314 ~ edit ~ idInput:", idInput)
                html += `</tbody>
                </table>`
                $("#edit_table").html(html)
            }
        })
    }
    $("#edit").submit(function(event) {
        event.preventDefault();
        var form = new FormData(this);
        form.append('_token', token);
        axios.post("{{url('ajax/sub-klaster')}}", form)
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
            url: "{{url('data/sub-klaster')}}/" + id,
            success: function(data) {
                $("#hapus_id").val(data.subklaster.id);
                $("#hapus_name").val(data.subklaster.name);
                $("#hapus_master_klaster_uuid").val(data.subklaster.master_klaster_uuid);
            }
        })
    }
    $("#hapus").submit(function(event) {
        event.preventDefault();
        var form = new FormData(this);
        form.append('_token', token);
        axios.post("{{url('ajax/sub-klaster')}}", form)
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