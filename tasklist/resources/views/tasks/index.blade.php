@extends('layouts.app')

@section('content')

    <div class="prose ml-4">
        <h2 class="text-lg">タスクリスト 一覧</h2>
    </div>

    @if (isset($tasks))
        <table class="table table-zebra w-full my-4">
            <thead>
                <tr>
                    <th>id</th>
                    <th>ステータス</th>
                    <th>タスクリスト</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                <tr>
                    <td><a class="link link-hover text-info" href="{{ route('tasks.show', $task->id) }}">{{ $task->id }}</a></td>
                    <td>{{ $task->status }}</td>
                    <td>{{ $task->content }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    {{-- タスクリスト作成ページへのリンク --}}
    <a class="btn btn-primary" href="{{ route('tasks.create') }}">新規タスクリストの投稿</a>

@endsection