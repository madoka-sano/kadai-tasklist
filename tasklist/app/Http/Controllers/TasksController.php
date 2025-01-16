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
        
        //dd(\Auth::check());
        
        //micropostcopy
        $data = [];
        if (\Auth::check()) { // 認証済みの場合
        
            // 認証済みユーザーを取得
            $user = \Auth::user();
            // ユーザーの投稿の一覧を作成日時の降順で取得
            // （後のChapterで他ユーザーの投稿も取得するように変更しますが、現時点ではこのユーザーの投稿のみ取得します）
            $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);
            $data = [
                'user' => $user,
                'tasks' => $tasks,
            ];
            
            // タスクリスト一覧ビューでそれを表示
            return view('tasks.index', $data);                                 /* 追加 */
        
        }
        
        // dashboardビューでそれらを表示
        return view('welcom', $data);
        
        
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
        $task->user_id = \Auth::id();
        $task->save();

        // タスクリスト一覧へリダイレクトさせる
        return redirect('/dashboard');
    }

    // getでtasks/（任意のid）にアクセスされた場合の「取得表示処理」
    public function show(string $id)
    {
        // idの値でタスクリストを検索して取得
        $task = Task::findOrFail($id);
        
        // 認証済みユーザー（閲覧者）がその投稿の所有者でない場合はトップページへ
        if (\Auth::id() != $task->user_id) {
            // トップページへリダイレクトさせる
            return redirect('/');
        }
        
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
        
        // 認証済みユーザー（閲覧者）がその投稿の所有者でない場合はトップページへ
        if (\Auth::id() != $task->user_id) {
            // トップページへリダイレクトさせる
            return redirect('/');
        }

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
        
        // 認証済みユーザー（閲覧者）がその投稿の所有者でない場合はトップページへ
        if (\Auth::id() != $task->user_id) {
            // トップページへリダイレクトさせる
            return redirect('/');
        }
        
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
        
        // 認証済みユーザー（閲覧者）がその投稿の所有者である場合は投稿を削除
        if (\Auth::id() === $task->user_id) {
            // タスクリストを削除
            $task->delete();
        }
        

        // トップページへリダイレクトさせる
        return redirect('/');
    }
}