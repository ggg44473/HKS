@extends('layouts.master')
@section('title', '全部通知')
@section('content')
<div class="container">
    <table class="rwd-table table table-hover">
        <thead>
            <tr class="bg-primary text-light text-center">
                <th>
                    圖片
                </th>
                <th>
                    訊息
                </th>
                <th>
                    時間
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($notifications as $n)
            <tr class="text-center">
                <td data-th="圖片" class="align-middle">
                    <img src="{{ $n->data['data']['icon'] }}" alt="" class="avatar-sm">
                </td>
                <td data-th="訊息" class="align-middle">
                    <a href={{ $n->data['data']['link'] }}>{{ $n->data['data']['message'] }}</a>
                </td>
                <td data-th="時間" class="align-middle">
                    {{ $n->created_at }}
                </td>
                @endforeach
        </tbody>
    </table>
</div>
@endsection
