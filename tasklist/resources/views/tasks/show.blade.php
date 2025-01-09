@extends('layouts.app')

@section('content')

    <div class="prose ml-4">
        <h2  class="text-lg">id = {{ $task->id }} のタスクリスト詳細ページ</h2>
    </div>

    <table class="table w-full my-4">
        <tr>
            <th>id</th>
            <td>{{ $task->id }}</td>
        </tr>
        
        <tr>
            <th>ステータス</th>
            <td>{{ $task->status }}</td>
        </tr>

        <tr>
            <th>タスクリスト</th>
            <td>{{ $task->content }}</td>
        </tr>
    </table>
    
    {{-- タスクリスト編集ページへのリンク --}}
    <a class="btn btn-outline" href="{{ route('tasks.edit', $task->id) }}">このタスクリストを編集</a>
    
    {{-- タスクリスト削除フォーム --}}
    <form method="POST" action="{{ route('tasks.destroy', $task->id) }}" class="my-2">
        @csrf
        @method('DELETE')
        
        <button type="submit" class="btn btn-error btn-outline" 
            onclick="return confirm('id = {{ $task->id }} のタスクリストを削除します。よろしいですか？')">削除</button>
    </form>
    
@endsection