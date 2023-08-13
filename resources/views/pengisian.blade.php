@extends('template')
@section('view')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Pengisian Periode {{ $schedule['date_start'].' - '.$schedule['date_end'] }}</h6>
            </div>
            <div class="card-body">
                @foreach($masterKlaster as $mk)
                <h6>{{ $mk['name'] }}</h6>
                <ul>
                    @foreach(getSubKlasterData($mk['uuid']) as $subK)
                    <li style="display: flex;justify-content:space-between;align-items:center">
                        <span>{{ $subK['name'] }}</span>
                        <button class="btn btn-info submitData {{ countInputData($subK['uuid']) && !countFormInput($subK['uuid'], $schedule['uuid']) ? '' : 'disabled' }}" data-uuid="{{ $subK['uuid'] }}">Lakukan Pengisian</button>
                    </li>
                    @endforeach
                </ul>
                @endforeach
            </div>
            <div class="card-footer">
                <a href="{{ url('') }}" class="btn btn-danger">Back</a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg modalInput" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="myLargeModalLabel">Form Pengisian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="saveInput" method="POST">
                <div class="modal-body input-body"></div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(".submitData").click(function(e) {
        e.preventDefault();
        const uuid = $(this).data('uuid');
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{url('data/getForm')}}/" + uuid,
            beforeSend: function() {
                $(".modalInput").modal('show');
                $(".input-body").html(`
                <div class="d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>`)
            },
            success: function(data) {
                var html = `<input type="hidden" class="form-control" name="sub_klaster_uuid" value="${data[0].sub_klaster_uuid}"/>`;
                $(".input-body").html('');
                html += ``
                for (let input of data) {
                    html += `
                    <div class="form-group mb-3">
                        <label>${input.label}</label>
                        <input type="text" class="form-control" name="${input.name}" placeholder="Silahkan input ${input.label}" required/>
                    </div>
                    `
                }
                $(".input-body").html(html);

            }
        })
    })
    $("#saveInput").submit(function(e) {
        e.preventDefault();
        let tempForm = new FormData(this);
        tempForm.append('_token', token);
        tempForm.append('schedule_input_uuid', "{{ $schedule['uuid'] }}")
        axios.post("{{url('ajax/pengisian')}}", tempForm)
            .then(response => {
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
                        }).then(function(result) {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
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
        $(".modalInput").modal('hide');
    })
</script>
@endsection