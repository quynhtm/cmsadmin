<?php
// Quynhtm
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Library\Funcs;
use App\Models\Evaluation;
use App\Models\Users;
use Faker\Provider\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class BookingController extends Controller
{
    private $dirTemplate = 'booking';

    public function index (Request $request) {
        if($this->user['role_id'] == 1) {
            return redirect()->intended(route('admin'));
        }
        $search = $request->only(['code','name','class','org','position','suppervisor','supervisor_pos','date','date_to','created','created_to']);
        $search['user_c'] = $this->user['id'];
        $evaluation = Evaluation::search($search);

        return view($this->dirTemplate.'.index', [
            'search' => $search,
            'evaluation' => $evaluation
        ]);
    }

    private $resful = [
        'status' => 0
    ];

    public function detail($id, Request $request)
    {
        if( $id > 0 ) {
            $data = [];

            $this->resful['html'] = view("career.ajax.detail",compact('data'))->render();
            $this->resful['status'] = 1;
        }

        return response()->json($this->resful);
    }

}
