@extends('template')
@section('view')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Pengisian {{ $masterKlaster['name'] }}</h6>
                <p class="text-black">Sub : {{ $subKlaster['name'] }}</p>
            </div>
            <form id="submit" method="POST">
                <div class="card-body">
                    <input type="hidden" name="sub_klaster_uuid" value="{{ $subKlaster['uuid'] }}">
                    @foreach($inputan as $i)
                    <div class="form-group mb-3">
                        <label>{{ $i['label'] }}</label>
                        <input type="text" class="form-control" name="{{ $i['name'] }}">
                    </div>
                    @endforeach
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit Data</button>
                    <a href="{{ url('') }}" class="btn btn-danger">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $("#submit").submit(function(event) {
        event.preventDefault();
        var form = new FormData(this);
        form.append('_token', token);
        axios.post("{{url('ajax/pengisian')}}", form)
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
                                window.location.href = "{{ url('') }}"
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
    })
</script>
@endsection