<?php

namespace Modules\Pengguna\Http\Controllers;

use Modules\Core\Http\Controllers\CoreController as Controller;
use Illuminate\Http\Request;

use Modules\Pengguna\Entities\Role;
use Modules\Pengguna\Http\Requests\RoleRequest;

class RoleController extends Controller
{
    protected $title;

    /**
     * Siapkan konstruktor controller
     * 
     * @param Role $data
     */
    public function __construct(Role $data) 
    {
        $this->title = __('pengguna::general.roles.title');
        $this->data = $data;

        $this->toIndex = route('epanel.roles.index');
        $this->prefix = 'epanel.roles';
        $this->view = 'pengguna::roles';

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
        $data = $this->data->latest()->get();

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
    public function store(RoleRequest $request) 
    {
        $input = $request->all();
        $input['id_admin'] = optional(auth()->user())->id;

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
        $edit = $this->data->uuid($id)->firstOrFail();

        return view("$this->view.permissions", compact('edit'));
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
    public function update(RoleRequest $request, $id)
    {    
        $edit = $this->data->uuid($id)->firstOrFail();

        if($request->has('purpose')):
            if($request->purpose == 'permissions'):
                if($request->has('permissions')):
                    $edit->permissions = json_encode($request->permissions);
                    $edit->save();

                    return redirect($this->toIndex);
                endif;
            endif;
        endif;

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
                if(!in_array($data->id, [1, 2])):
                    $return .= '    <div class="checkbox checkbox-only">';
                    $return .= '        <input type="checkbox" id="pilihan['.$data->id.']" name="pilihan[]" value="'.$data->uuid.'">';
                    $return .= '        <label for="pilihan['.$data->id.']"></label>';
                    $return .= '    </div>';
                endif;
                $return .= '</span>';
                return $return;
            })
            ->editColumn('name', function($data) {
                $return  = $data->name;
                return $return;
            })
            ->editColumn('slug', function($data) {
                $return  = $data;
                return $return;
            })
            ->editColumn('users', function($data) {
                $return  = $data->name;
                return $return;
            })
            ->editColumn('permissions', function($data) {
                $return  = '<div class="btn-toolbar">';
                $return .= '    <div class="btn-group btn-group-sm">';
                $return .= '        <a href="'. route("$this->prefix.show", $data->uuid) .'" class="btn btn-sm btn-success-outline">';
                $return .= '            <span class="fa fa-cogs"></span> ' . strtoupper(__('pengguna::general.manage'));
                $return .= '        </a>';
                $return .= '    </div>';
                $return .= '</div>';
                return $return;
            })
            ->editColumn('aksi', function($data) {
                $return  = '<div class="btn-toolbar">';
                $return .= '    <div class="btn-group btn-group-sm">';
                $return .= '        <a href="'. route("$this->prefix.edit", $data->uuid) .'" class="btn btn-sm btn-primary-outline">';
                $return .= '            <span class="fa fa-pencil"></span>';
                $return .= '        </a>';
                $return .= '    </div>';
                $return .= '</div>';
                return $return;
            })
            ->rawColumns(['pilihan', 'name', 'slug', 'users', 'permissions', 'aksi'])->toJson();
    }
}
