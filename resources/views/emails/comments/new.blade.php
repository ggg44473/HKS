<div>Dear {{ $details['name'] }},</div>
<br>
<div>{{ $details['commenter'] }}
    @if (array_key_exists('commentOn', $details))
    commented on {{ $details['commentOn'] }}
    @endif
    @if (array_key_exists('parentComment', $details))
    replied on your comment
    <div>{{ $details['parentComment'] }}</div>
    @endif
</div>
<br>
<div>With</div>
<div>{{ $details['comment'] }}</div>
<br>
<div>You care your goals, we care you.</div>
<br>
<br>
<div>Sincerely,</div>
<br>
<div>Goal Care</div>
<div>www.goalcare.ga</div>
<div>02-222-5252</div>
