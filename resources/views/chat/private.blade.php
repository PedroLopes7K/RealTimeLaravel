@extends('layouts.app')

@push('styles')
<style type="text/css">
    #users>li {
        cursor: pointer;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Private Chat</div>

                <div class="card-body">
                    <div class="row p-2">
                        <div class="col-10">
                            <div class="row">
                                <div class="col-12 border rounded-lg p-3">
                                    <ul id="messages" class="list-unstyled overflow-auto" style="height: 45vh">
                                    </ul>
                                </div>
                            </div>
                            <form>
                                <div class="row py-3">
                                    <div class="col-10">
                                        <input id="message" class="form-control" type="text">
                                    </div>
                                    <div class="col-2">
                                        <button id="send" type="submit" class="btn btn-primary btn-block">Send</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-2">
                            <p><strong>Online Now</strong></p>
                            <ul id="users" class="list-unstyled overflow-auto text-info" style="height: 45vh">
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')

<script type="module">
    const messageElement = document.getElementById('message');
    const sendElement = document.getElementById('send');
    sendElement.addEventListener('click', (e) => {
        e.preventDefault();
        window.axios.post('/chat/message/private', {
            message: messageElement.value,
        });
        messageElement.value = '';
    });
</script>

<script type="module">
    const messagesElement = document.getElementById('messages');

    window.Echo.private('chat.private.{{ 1 }}')
        .listen('MessagePrivate', (e) => {
            console.log(e)
            let element = document.createElement('li');
            element.innerText =  e.message;
            element.classList.add('text-success');
            messagesElement.appendChild(element);
        });
</script>
@endpush