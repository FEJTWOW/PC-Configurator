<?php

namespace App\Http\Controllers;

use App\Models\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ConfigController extends Controller
{
    public function index()
    {
        return view('config.index', ['configs' => Config::all()]);
    }

    public function create()
    {
        $config = Config::getFromSessionOrCreate();

        /*echo "<pre>";
        $compatibleComponents = \app\Models\CPU::compatible($config->compatibleSpec("cpu"));
        print_r($compatibleComponents->get());
        echo "</pre>";*/

        return view('config.create', [
            "config" => $config,
            "compatibilityErrors" => $config->compatibilityErrors()
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'desc' => 'required'
        ]);

        $config = Config::getFromSessionOrCreate();

        $config->title = $request->input("title");
        $config->desc = $request->input("desc");

        if(!$config->isComplete())
            throw ValidationException::withMessages(['Config' => "Config is incomplete"]);

        if(!$config->isCompatible())
            throw ValidationException::withMessages(['Config' => "Config is incompatible"]);

        $config->calcPrice();

        $config->save();

        $request->session()->forget("config");

        return redirect(route("config.show", ['config' => $config]));
    }

    public function show(Config $config)
    {
        $user = Auth::user();
        return view("config.show", ['config' => $config, 'user' => $user, 'owner' => true]);
    }

    public function edit(Config $config)
    {
        $id = Auth::id();
        if ($config->user_id == $id) {
            return view("config.edit", ['config' => $config]);
        }
        else {
            return abort('403');
        }

    }

    public function update(Config $config)
    {
        //TODO: lepsza walidacja
        $config->update(request()->validate([
            'cpu_id' => 'required',
            'gpu_id' => 'required',
            'mb_id' => 'required',
            'ram_id' => 'required'
        ]));

        return redirect("config/".$config->id);
    }

    public function destroy(Config $config)
    {
        $id = Auth::id();
        if ($config->user_id == $id) {
            $config->delete();
            return redirect('/user/'.$id);
        }
        else {
            return abort('403');
        }
    }

    public function verify(Config $config)
    {
        $user = Auth::user();
        if ($user->user_type == 'admin') {
            if ($config->is_verified == true) {
                $config->is_verified = false;
                $config->save();
            }
            else {
                $config->is_verified = true;
                $config->save();
            }


            return redirect()->route('config.show', $config);
        }
        else {
            return abort('403');
        }

    }

    public function publish(Config $config)
    {
        $user = Auth::user();
        if ($config->user_id == $user->id) {
            $config->public = true;
            $config->save();
            return redirect()->route('user.show', $user);
        } else {
            return abort('403');
        }
    }

    public function shareUrl(Config $config, Request $request)
    {
        if ($config->share_url == "")
        {
            $value = md5(mt_rand());
            $config->share_url = $value;
            $config->save();
        }
        return view('config.share_url')->withConfig($config);
    }

    public function sharedConfig(Config $config, string $md5)
    {
        $owner = false;
        if ($md5 != $config->share_url)
        {
            return abort('403');
        }
        $user = Auth::user();
        if(Auth::id() == $config->user_id)
        {
            $owner = true;
        }
        return view("config.show", ['config' => $config, 'user' => $user, 'owner' => $owner]);



    }
}
