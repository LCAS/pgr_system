<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\AbsenceType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Requests\AbsenceTypeRequest;

class AbsenceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorise('view', AbsenceType::class);

        if ($request->ajax())
        {

        $absencetypes = AbsenceType::select('absence_types.*')->withCount([
            'absence',
            'absence AS currentabsence' => function ($query) {
                $query->where('from', '<=', Carbon::now())
                      ->where('to', '>=', Carbon::now());
            }]);

          return Datatables::eloquent($absencetypes)
              ->editColumn('interuption', '{{$interuption ? "Yes" : "No" }}')
              ->addColumn('editaction', function (AbsenceType $at) {
                return '<form method="GET" action="' . route('admin.settings.absence-type.edit', $at->id) . '"
                  accept-charset="UTF-8" class="delete-form">
                  <button class="btn btn-warning">
                  <i class="fa fa-pencil"></i></button> </form>';
                })
                ->addColumn('deleteaction', function (AbsenceType $at) {
                  return '<form method="POST" action="' . route('admin.settings.absence-type.destroy', $at->id) . '"
                  accept-charset="UTF-8" class="delete-form">
                  <input type="hidden" name="_method" value="DELETE">' . 
                  csrf_field() . '<button class="btn btn-danger">
                  <i class="fa fa-trash"></i></button> </form>';
              })
                ->rawColumns(['editaction', 'deleteaction'])
              ->make(true);
        }

        $deletedAbsenceType = AbsenceType::onlyTrashed()->get();
        return view('admin.settings.absencetype.index', compact('deletedAbsenceType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AbsenceTypeRequest $request)
    {
        $this->authorise('create', AbsenceType::class);

        $abs = AbsenceType::create($request->only([ 'name', 'interuption' ]));
        return redirect()
            ->route('admin.settings.absence-type.index')
            ->with('flash', [
                'message' => 'Successfully added "' . $abs->name . '"',
                'type' => 'success'
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AbsenceTypeRequest $request, AbsenceType $absence_type)
    {
        $this->authorise('update', $absence_type);

        $absence_type->update($request->only( ['name', 'interuption'] ));
        $absence_type->save();
        return redirect()
            ->route('admin.settings.absence-type.index')
            ->with('flash', [
                'message' => 'Successfully updated "' . $absence_type->name . '"',
                'type' => 'success'
            ]);
    }

    public function edit(AbsenceType $absence_type)
    {
        $this->authorise('update', $absence_type);

        return view('admin.settings.absencetype.edit', compact('absence_type'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(AbsenceType $absence_type)
    {
        $this->authorise('delete', $absence_type);

        // We are using soft delete so this item will remain in the database
        $absence_type->delete();
        return redirect()
            ->route('admin.settings.absence-type.index')
            ->with('flash', [
                'message' => 'Successfully deleted "' . $absence_type->name . '"',
                'type' => 'success'
            ]);
    }

    public function restore($id)
    {
        $abs = AbsenceType::withTrashed()->findOrFail($id);

        $this->authorise('delete', $abs);
        
        if($abs->trashed())
        {
            $abs->restore();
            return redirect()
              ->route('admin.settings.absence-type.index')
              ->with('flash', [
                  'message' => 'Successfully restored "' . $abs->name . '"',
                  'type' => 'success'
              ]);
        }
        return redirect()
            ->route('admin.settings.absence-type.index')
            ->with('flash', [
                'message' => 'Error: Absence Type is not deleted: "' . $abs->name . '"',
                'type' => 'danger'
            ]);
    }
}
