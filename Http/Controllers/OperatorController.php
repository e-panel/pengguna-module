<?php

namespace Modules\Pengguna\Http\Controllers;

use Modules\Core\Http\Controllers\CoreController as Controller;
use Illuminate\Http\Request;

use Modules\Pengguna\Entities\Operator;
use Modules\Pengguna\Http\Requests\OperatorRequest;

class OperatorController extends Controller
{
    protected $title;

    /**
     * Siapkan konstruktor controller
     * 
     * @param Operator $data
     */
    public function __construct(Operator $data) 
    {
        $this->title = __('pengguna::general.operator.title');
        $this->data = $data;

        $this->toIndex = route('epanel.operator.index');
        $this->prefix = 'epanel.operator';
        $this->view = 'pengguna::operator';

        $this->tCreate = __('core::general.created', ['attribute' => strtolower($this->title)]);
        $this->tUpdate = __('core::general.updated', ['attribute' => strtolower($this->title)]);
        $this->tDelete = __('core::general.deleted', ['attribute' => strtolower($this->title)]);

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
    public function store(OperatorRequest $request) 
    {
        $input = $request->all();

        $input['uuid'] = uuid();

        $input['password'] = bcrypt($request->password);
        $input['plain'] = $request->password;

        if($request->hasFile('avatar')):
            $input['avatar'] = $this->upload($request->file('avatar'), $input['uuid']);
        endif;

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
    public function update(OperatorRequest $request, $id)
    {    
        $edit = $this->data->uuid($id)->firstOrFail();

        $input = $request->all();

        $input['password'] = !is_null($request->password) ? bcrypt($request->password) : $edit->password;
        $input['plain'] = !is_null($request->password) ? $request->password : $edit->plain;

        if($request->hasFile('avatar')):          
            deleteImg($edit->avatar);
            $input['avatar'] = $this->upload($request->file('avatar'), $edit->uuid);
        else:
            $input['avatar'] = $edit->avatar;
        endif;

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
     * Function for Upload File
     * 
     * @param  $file, $filename
     * @return URI
     */
    public function upload($file, $filename) 
    {
        $tmpFilePath = 'app/public/Pengguna/';
        $tmpFileDate =  date('Y-m') .'/'.date('d').'/';
        $tmpFileName = $filename;
        $tmpFileExt = $file->getClientOriginalExtension();

        makeImgDirectory($tmpFilePath . $tmpFileDate);
        
        $nama_file = $tmpFilePath . $tmpFileDate . $tmpFileName;
        
        \Image::make($file->getRealPath())->resize(500, null, function($constraint) {
            $constraint->aspectRatio();
        })->save(storage_path() . "/$nama_file.$tmpFileExt");
        
        \Image::make($file->getRealPath())->fit(100, 100)->save(storage_path() . "/{$nama_file}_s.$tmpFileExt");

        return "storage/Pengguna/{$tmpFileDate}{$tmpFileName}.{$tmpFileExt}";
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
                    return '<img src="'.viewImg($data->avatar, 's').'">';
                endif;
            })
            ->editColumn('nama', function($data) {
                $return  = $data->nama;
                $return .= '<div class="font-11 color-blue-grey-lighter">';
                $return .= '    Role : <b>';
                $return .=          optional($data->role)->name;
                $return .= '    </b>';
                $return .= '</div>';
                return $return;
            })
            ->editColumn('username', function($data) {
                $return = "<code>$data->username</code>";
                return $return;
            })
            ->editColumn('password', function($data) {
                $return  = '<span data-toggle="tooltip" data-placement="top" data-original-title="">';
                $return .= '    <i class="fa fa-lock"></i> &bullet;&bullet;&bullet;&bullet;&bullet;';
                $return .= '</span>';
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
            ->rawColumns(['pilihan', 'foto',  'nama', 'username', 'password', 'last_login', 'aksi'])->toJson();
    }
}
