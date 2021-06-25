<?php

namespace Modules\Pengguna\Http\Controllers;

use Modules\Core\Http\Controllers\CoreController as Controller;
use Illuminate\Http\Request;

use Modules\Pengguna\Entities\Operator;

class SSOController extends Controller
{
    protected $title;

    /**
     * Siapkan konstruktor controller
     * 
     * @param Operator $data
     */
    public function __construct(Operator $data) 
    {
        $this->title = __('pengguna::general.sso.title');
        $this->data = $data;

        $this->toIndex = route('epanel.sso.index');
        $this->prefix = 'epanel.sso';
        $this->view = 'pengguna::sso';

        $this->tCreate = __('core::general.created', ['attribute' => $this->title]);
        $this->tUpdate = __('core::general.updated', ['attribute' => $this->title]);
        $this->tDelete = __('core::general.deleted', ['attribute' => $this->title]);

        view()->share([
            'title' => $this->title, 
            'view' => $this->view, 
            'prefix' => $this->prefix
        ]);
    }

    /**
     * Tampilkan halaman utama modul yang dipilih
     * 
     * @param Request $request
     * @return Response|View
     */
    public function index(Request $request) 
    {
        $data = $this->data->where('username', '!=', 'novay@btekno.id')->latest()->get();

        if($request->has('datatable')):
            return $this->datatable($data);
        endif;

        return view("$this->view.index", compact('data'));
    }

    /**
     * Tampilkan halaman untuk menambah data
     * 
     * @return Response|View
     */
    public function create() 
    {
        return view("$this->view.create");
    }

    /**
     * Lakukan penyimpanan data ke database
     * 
     * @param Request $request
     * @return Response|View
     */
    public function store(Request $request) 
    {
        $input = $request->all();

        $explode = explode("|||" , $request->pengguna);
        $input['uuid'] = $explode[0];
        $input['username'] = $explode[1];
        $input['nama'] = $explode[2];

        $random = str_random(10);
        $input['password'] = bcrypt($random);
        $input['plain'] = $random;

        $this->data->create($input);

        notify()->flash($this->tCreate, 'success');
        return redirect($this->toIndex);
    }

    /**
     * Menampilkan detail lengkap
     * 
     * @param Int $id
     * @return Response|View
     */
    public function show($id)
    {
        return abort(404);
    }

    /**
     * Tampilkan halaman perubahan data
     * 
     * @param Int $id
     * @return Response|View
     */
    public function edit(Request $request, $id)
    {
        $edit = $this->data->uuid($id)->firstOrFail();

        return view("$this->view.edit", compact('edit'));
    }

    /**
     * Lakukan perubahan data sesuai dengan data yang diedit
     * 
     * @param Request $request
     * @param Int $id
     * @return Response|View
     */
    public function update(Request $request, $id)
    {    
        $edit = $this->data->uuid($id)->firstOrFail();

        $input = $request->all();
        $edit->update($input);

        notify()->flash($this->tUpdate, 'success');
        return redirect($this->toIndex);
    }

    /**
     * Lakukan penghapusan data yang tidak diinginkan
     * 
     * @param Request $request
     * @param Int $id
     * @return Response|String
     */
    public function destroy(Request $request, $id)
    {
        if($request->has('pilihan')):
            foreach($request->pilihan as $temp):
                $each = $this->data->uuid($temp)->firstOrFail();
                deleteImg($each->avatar);
                $each->delete();
            endforeach;
            notify()->flash($this->tDelete, 'success');
            return redirect()->back();
        endif;
    }

    /**
     * Datatable API
     * 
     * @param  $data
     * @return Datatable
     */
    public function datatable($data) 
    {
        return datatables()->of($data)
            ->editColumn('pilihan', function($data) {
                $return  = '<span>';
                $return .= '    <div class="checkbox checkbox-only">';
                $return .= '        <input type="checkbox" id="pilihan['.$data->id.']" name="pilihan[]" value="'.$data->uuid.'">';
                $return .= '        <label for="pilihan['.$data->id.']"></label>';
                $return .= '    </div>';
                $return .= '</span>';
                return $return;
            })
            ->editColumn('foto', function($data) {
                if(is_null($data->avatar)):
                    return '<img src="'.\Avatar::create($data->nama)->toBase64().'">';
                else:
                    if(config('pengguna.plugin.sso')):
                        return '<img src="'.$data->avatar.'">';
                    else:
                        return '<img src="'.viewImg($data->avatar, 's').'">';
                    endif;
                endif;
            })
            ->editColumn('nama', function($data) {
                $return  = $data->nama;
                $return .= '<div class="font-11 color-blue-grey-lighter">';
                $return .= '    Role: <b>';
                $return .=          optional($data->role)->name;
                $return .= '    </b>';
                $return .= '</div>';
                return $return;
            })
            ->editColumn('username', function($data) {
                $return = "$data->username";
                return $return;
            })
            ->editColumn('last_login', function($data) {
                if(!is_null($data->last_login)):
                    $return = "<small>" . $data->last_login->diffForHumans() . "</small>";
                    $return .= '<div class="font-11 color-blue-grey-lighter">';
                    $return .= '    IP Address: ' . ($data->last_ip_address ?? '-');
                    $return .= '</div>';
                else:
                    $return = '<small>Never Login</small>';
                endif;
                return $return;
            })
            ->editColumn('aksi', function($data)  {
                $return  = '<div class="btn-toolbar">';
                $return .= '    <div class="btn-group btn-group-sm">';
                $return .= '        <a href="'. route("$this->prefix.edit", $data->uuid) . '" role="button" class="btn btn-sm btn-primary-outline">';
                $return .= '            <span class="fa fa-pencil"></span>';
                $return .= '        </a>';
                $return .= '    </div>';
                $return .= '</div>';
                return $return;
            })
            ->rawColumns(['pilihan', 'foto',  'nama', 'username', 'last_login', 'aksi'])->toJson();
    }
}
