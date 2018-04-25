<?php

namespace App\Http\Controllers;

use App\Task;
use Validator;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        //Obtiene las tareas ordenadas por fecha de creación
        $tasks = Task::orderBy('created_at', 'asc')->get();

        //Devuelve la vista con las tareas
        return view('tasks', [
            'tasks' => $tasks
        ]);
    }

    public function store(Request $request)
    {
        //Valida la petición
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);
    
        //En caso de error, devuelve los errores
        if ($validator->fails()) {
            return redirect('/')
                ->withInput()
                ->withErrors($validator);
        }
    
        //Crea la tarea
        $task = new Task;
        $task->name = $request->name;
        $task->save();
    
        //Redirige a la página principal
        return redirect('/');
    }

    public function destroy($id)
    {
        //Obtiene la tarea y la elimina. Devuelve 404 en caso de no existir
        Task::findOrFail($id)->delete();

        return redirect('/');
    }
}
