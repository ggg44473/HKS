@auth
    @if($model->comments->count() < 1)
        <p class="lead">目前沒有任何回饋</p>
    @endif

    @include('comments::_form')

    <ul class="list-unstyled">
        @foreach($model->comments->where('parent', null) as $comment)
        @include('comments::_comment')
        @endforeach
    </ul>
@else
    @if($model->comments->count() < 1)
        <p class="lead">目前沒有任何回饋</p>
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
