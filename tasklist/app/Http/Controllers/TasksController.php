<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Task;    // 追加

class TasksController extends Controller
{
    // getでtasks/にアクセスされた場合の「一覧表示処理」
    public function index()
    {
        // タスクリスト一覧を取得
        $tasks = Task::all();         /* 追加 */

        // タスクリスト一覧ビューでそれを表示
        return view('tasks.index', [     /* 追加 */
            'tasks' => $tasks,        /* 追加 */
        ]);                                 /* 追加 */
    }

    // getでtasks/createにアクセスされた場合の「新規登録画面表示処理」
    public function create()
    {
        $task = new Task;

        // タスクリスト作成ビューを表示
        return view('tasks.create', [
            'task' => $task,
        ]);
    }

    // postでtasks/にアクセスされた場合の「新規登録処理」
    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'status' => 'required|max:10',
            'content' => 'required|max:255',
        ]);
        
        // タスクリストを作成
        $task = new Task; 
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();

        // トップページへリダイレクトさせる
        return redirect('/');
    }

    // getでtasks/（任意のid）にアクセスされた場合の「取得表示処理」
    public function show(string $id)
    {
        // idの値でタスクリストを検索して取得
        $task = Task::findOrFail($id);

        // タスクリスト詳細ビューでそれを表示
        return view('tasks.show', [
            'task' => $task,
        ]);
    }

    // getでtasks/（任意のid）/editにアクセスされた場合の「更新画面表示処理」
    public function edit(string $id)
    {
        // idの値でタスクリストを検索して取得
        $task = Task::findOrFail($id);

        // タスクリスト編集ビューでそれを表示
        return view('tasks.edit', [
            'task' => $task,
        ]);
    }

    // putまたはpatchでtasks/（任意のid）にアクセスされた場合の「更新処理」
    public function update(Request $request, string $id)
    {
        // バリデーション
        $request->validate([
            'status' => 'required|max:10',
            'content' => 'required|max:255',
        ]);
        
        // idの値でタスクリストを検索して取得
        $task = Task::findOrFail($id);
        // タスクリストを更新
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();

        // トップページへリダイレクトさせる
        return redirect('/');
    }

    // deleteでtasks/（任意のid）にアクセスされた場合の「削除処理」
    public function destroy(string $id)
    {
        // idの値でタスクリストを検索して取得
        $task = Task::findOrFail($id);
        // タスクリストを削除
        $task->delete();

        // トップページへリダイレクトさせる
        return redirect('/');
    }
}