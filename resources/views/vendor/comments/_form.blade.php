<div class="card-body col-12 pt-0">
    <form method="POST" action="{{ url('comments') }}">
        @csrf
        <input type="hidden" name="commentable_type" value="\{{ get_class($model) }}" />
        <input type="hidden" name="commentable_id" value="{{ $model->id }}" />
        <div class="form-group">
            <label for="message">請留下您的寶貴建議:</label>
            <textarea class="form-control @if($errors->has('message')) is-invalid @endif" name="message" rows="3"></textarea>
            <div class="invalid-feedback ml-4">
                Your message is required.
            </div>
            <small class="form-text text-muted"><a target="_blank" href="https://help.github.com/articles/basic-writing-and-formatting-syntax">Markdown</a> cheatsheet.</small>
        </div>
        <button type="submit" class="btn btn-sm btn-outline-success text-uppercase u-mt-16">Submit</button>
    </form>
</div>
<br />