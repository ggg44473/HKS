@auth
    @if($model->comments->count() < 1)
        {{-- <p class="lead">目前沒有任何回饋</p> --}}
        <div class="alert alert-info text-center" role="alert">目前沒有任何回饋</div>
    @endif

    @include('comments::_form')

    <ul class="list-unstyled pr-sm-4">
        @foreach($model->comments->where('parent', null) as $comment)
        <hr class="mb-3 ml-5 mr-5"/>
        @include('comments::_comment')
        @endforeach
    </ul>
@else
    @if($model->comments->count() < 1)
        {{-- <p class="lead">目前沒有任何回饋</p> --}}
        <div class="alert alert-info text-center" role="alert">目前沒有任何回饋</div>
    @endif

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Authentication required</h5>
            <p class="card-text">You must log in to post a comment.</p>
            <a href="{{ route('login') }}" class="btn btn-primary">Log in</a>
        </div>
    </div>

    <ul class="list-unstyled">
        @foreach($model->comments->where('parent', null) as $comment)
        @include('comments::_comment')
        @endforeach
    </ul>
@endauth
