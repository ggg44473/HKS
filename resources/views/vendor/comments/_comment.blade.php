@inject('markdown', 'Parsedown')

@if(isset($reply) && $reply === true)
  <div id="comment-{{ $comment->id }}" class="media">
@else
  <li id="comment-{{ $comment->id }}" class="media">
@endif
    
    <div class="media-body pl-md-5 pl-3">
        <div class="row">
            <div class="col-auto align-self-baseline pr-0">
                <a href="{{ $comment->commenter->getOKrRoute() }}">
                    <img class="avatar-sm ml-2 mr-2" src="{{ $comment->commenter->getAvatar() }}" alt="{{ $comment->commenter->name }} Avatar">
                </a>
            </div>
            <div class="col-2 align-self-baseline pl-0 pr-0" style="max-width: 100px">
                <h5 class="mt-0 mb-1 text-black-50 pt-2 text-truncate">{{ $comment->commenter->name }} </h5>
            </div>
            <div class="col-md align-self-baseline">
                <div class="pr-2 pl-2 pt-2" style="white-space: pre-wrap;">{!! $markdown->line($comment->comment) !!}</div>
                @can('reply-to-comment', $comment)
                    <button data-toggle="modal" data-target="#reply-modal-{{ $comment->id }}" class="btn btn-sm btn-link text-uppercase">回覆</button>
                @endcan
                @can('edit-comment', $comment)
                    <button data-toggle="modal" data-target="#comment-modal-{{ $comment->id }}" class="btn btn-sm btn-link text-uppercase">編輯</button>
                @endcan
                @can('delete-comment', $comment)
                    <a href="{{ url('comments/' . $comment->id) }}" onclick="event.preventDefault();document.getElementById('comment-delete-form-{{ $comment->id }}').submit();" class="btn btn-sm btn-link text-danger text-uppercase">刪除</a>
                    <form id="comment-delete-form-{{ $comment->id }}" action="{{ url('comments/' . $comment->id) }}" method="POST" style="display: none;">
                        @method('DELETE')
                        @csrf
                    </form>
                @endcan
                <small class="text-muted pl-2">{{ $comment->created_at->diffForHumans() }}</small>
            </div>
        </div>

        @can('edit-comment', $comment)
            <div class="modal fade" id="comment-modal-{{ $comment->id }}" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form method="POST" action="{{ url('comments/' . $comment->id) }}">
                            @method('PUT')
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title">編輯</h5>
                                <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="message">修改文章 :</label>
                                    <textarea required class="form-control" name="message" rows="3">{{ $comment->comment }}</textarea>
                                    <small class="form-text text-muted"><a target="_blank" href="https://help.github.com/articles/basic-writing-and-formatting-syntax">Markdown</a> cheatsheet.</small>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-outline-secondary text-uppercase" data-dismiss="modal">刪除</button>
                                <button type="submit" class="btn btn-sm btn-outline-success text-uppercase">更新</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endcan

        @can('reply-to-comment', $comment)
            <div class="modal fade" id="reply-modal-{{ $comment->id }}" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        @php
                            $replyTo = isset($reply) ? $comment->parent->id : $comment->id;
                        @endphp
                        <form method="POST" action="{{ url('comments/' . $replyTo) }}">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title">回覆</h5>
                                <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="message">在此輸入您的訊息:</label>
                                    <textarea required class="form-control" name="message" rows="3"></textarea>
                                    <small class="form-text text-muted"><a target="_blank" href="https://help.github.com/articles/basic-writing-and-formatting-syntax">Markdown</a> cheatsheet.</small>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-outline-secondary text-uppercase" data-dismiss="modal">取消</button>
                                <button type="submit" class="btn btn-sm btn-outline-success text-uppercase">回覆</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endcan
        <div class="mb-2"></div>
        @foreach($comment->children as $child)
            @include('comments::_comment', [
                'comment' => $child,
                'reply' => true
            ])
        @endforeach
    </div>
@if(isset($reply) && $reply === true)
  </div>
@else
  </li>
@endif
