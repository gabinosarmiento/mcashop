<?php

namespace App\Http\Controllers\Administrative\Administration;

use App\Http\Requests\Administrative\AdministrativeModuleRequest;
use App\Http\Requests\Administrative\AdministrativeRequest;
use App\Http\Requests\ImageRequest;
use App\Models\AdministrativeModel;
use App\Models\AdministrativeModuleModel;
use Illuminate\Http\Request;

class Administrative
{
    /**
     * Number of records displayed per page.
     *
     * @var int
     */
    protected $page = 15;

    /**
     * Display the administrative records page.
     *
     * Retrieves administrative records ordered by ID in descending order,
     * paginates the results, and passes the data to the view.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $data = AdministrativeModel::orderByDesc('id')->paginate($this->page)->toArray();

        return view('administrative.administration.administrative.index', compact('data'));
    }

    /**
     * Display the form for creating a new administrative record.
     *
     * Renders the creation form and returns it as an AJAX response
     * to be displayed in the application overlay.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function add()
    {
        $update = view('administrative.administration.administrative.add');

        return response(['update' => ['overapp' => $update->render()]]);
    }

    /**
     * Store a new administrative record.
     *
     * Creates a new administrative record using the validated request data
     * and returns the updated paginated records list.
     *
     * @param \App\Http\Requests\AdministrativeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(AdministrativeRequest $request)
    {
        $data = $request->only('firstname', 'lastname', 'department', 'email', 'password', 'status');

        AdministrativeModel::create($data);

        return $this->records($request);
    }

    /**
     * Display an administrative record.
     *
     * Retrieves the selected administrative record with its related modules
     * and returns the details view as an AJAX response.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function see(Request $request)
    {
        $data = AdministrativeModel::with('modules')->find($request->id)->toArray();

        $update = view('administrative.administration.administrative.see', compact('data'));

        return response(['update' => ['overapp' => $update->render()]]);
    }

    public function edit(Request $request)
    {
        $data = AdministrativeModel::find($request->id)->toArray();

        $update = view('administrative.administration.administrative.edit', compact('data'));

        return response(['update' => ['overapp' => $update->render()]]);
    }

    /**
     * Display the edit form for an administrative record.
     *
     * Retrieves the selected administrative record and returns
     * the edit form as an AJAX response.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(AdministrativeRequest $request)
    {
        $data = $request->only('firstname', 'lastname', 'department', 'email', 'password', 'status');

        AdministrativeModel::find($request->id)->update($data);

        return $this->records($request);
    }

    /**
     * Delete an administrative record.
     *
     * Removes the selected administrative record and returns
     * the updated paginated records list.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        AdministrativeModel::destroy($request->id);

        return $this->records($request);
    }

    /**
     * Update the profile image of an administrative record.
     *
     * Uploads the selected image, stores its path in the administrative
     * record, and returns the updated image as an AJAX response.
     *
     * @param \App\Http\Requests\ImageRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function imagen(ImageRequest $request)
    {
        $name = file_rename($request->image->extension());

        $data['image'] = "images/users/{$name}";

        $request->image->move(public_path('images/users'), $name);

        AdministrativeModel::find($request->id)->update($data);

        $data['id'] = $request->id;

        $update = view('administrative.image', compact('data'));

        return response(['update' => ['image-html' => $update->render()]]);
    }

    /**
     * Assign a module to an administrative record.
     *
     * Creates a new module assignment for the selected administrative
     * record and returns the updated modules list as an AJAX response.
     *
     * @param \App\Http\Requests\AdministrativeModuleRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function module_save(AdministrativeModuleRequest $request)
    {
        $data = $request->only('administrative_id', 'module');

        AdministrativeModuleModel::create($data);

        $data = AdministrativeModel::with('modules')->find($data['administrative_id'])->toArray();

        $update = view('administrative.administration.administrative.modules', compact('data'));

        return response(['update' => ['modules' => $update->render()]]);
    }

    /**
     * Remove a module from an administrative record.
     *
     * Deletes the selected module assignment from the administrative
     * record and returns the updated modules list as an AJAX response.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function module_delete(Request $request)
    {
        AdministrativeModuleModel::destroy($request->id);

        $data = AdministrativeModel::with('modules')->find($request->administrative_id)->toArray();

        $update = view('administrative.administration.administrative.modules', compact('data'));

        return response(['update' => ['modules' => $update->render()]]);
    }

    /**
     * Retrieve and render paginated administrative records.
     *
     * Retrieves administrative records with optional search filtering,
     * paginates the results, and automatically falls back to the previous
     * page if the requested page contains no records.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function records(Request $request)
    {
        do {
            $query = AdministrativeModel::query()->orderByDesc('id');

            if ($request->search) {
                $query->whereRaw('concat_ws(" ", firstname, lastname) like ?', ["%{$request->search}%"])->orderByRaw('firstname, lastname');
            }

            $records = $query->paginate($this->page, ['*'], 'page', $request->page);
        } while ($records->count() == 0 && --$request->page);

        $data = $records->toArray();

        $update = view('administrative.administration.administrative.records', compact('data'));

        return response(['update' => ['records' => $update->render()]]);
    }
}
