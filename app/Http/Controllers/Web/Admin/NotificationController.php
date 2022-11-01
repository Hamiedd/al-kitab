<?php

namespace App\Http\Controllers\Web\Admin;

use App\Contracts\NotificationContract;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * @var NotificationContract
     */
    protected NotificationContract $notification;

    /**
     * @param NotificationContract $notification
     */
    public function __construct(NotificationContract $notification)
    {
        $this->notification = $notification;

        $this->middleware(['permission:create-admin-notification'])->only(['create', 'store','send']);
        $this->middleware(['permission:view-admin-notification'])->only(['index','show']);
        $this->middleware(['permission:edit-admin-notification'])->only(['edit','update']);
        $this->middleware(['permission:delete-admin-notification'])->only(['destroy']);
    }

    public function index(Request $request)
    {
        $notifications = $this->notification->setPerPage($request->input('per_page'))->findByFilter();

        if ($request->wantsJson())
        {
            return response()->json(compact('notifications'));
        }

        return view('admin.notifications.index',compact('notifications'));
    }

    /**
     * @return Renderable
     */
    public function create(): Renderable
    {
        return view('admin.notifications.create');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:240',
            'message' => 'required|string',
            'receivers' => 'required|in:1,2,3,4'
        ]);

        $this->notification->new($data);

        session()->flash('success',__('messages.flash.create'));
        return redirect()->route('admin.notifications.index');
    }

    /**
     * @param $id
     * @return Renderable
     */
    public function show($id): Renderable
    {
        $notification = $this->notification->findOneById($id);
        return view('admin.notifications.index',compact('notification'));
    }

    /**
     * @param $id
     * @return Renderable
     */
    public function edit($id):Renderable
    {
        $notification = $this->notification->findOneById($id);
        return view('admin.notifications.edit',compact('notification'));
    }

    /**
     * @param $id
     * @param Request $request
     * @return RedirectResponse
     */
    public function update($id,Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:240',
            'message' => 'required|string',
            'receivers' => 'required|in:1,2'
        ]);
        $this->notification->update($id,$data);
        session()->flash('success',__('messages.flash.update'));
        return redirect()->route('admin.notifications.index');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        $this->notification->destroy($id);
        session()->flash('success',__('messages.flash.delete'));
        return redirect()->route('admin.notifications.index');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function send($id): RedirectResponse
    {
        try {
            $this->notification->sendAdminNotification($id);
            session()->flash('success',__('messages.flash.success'));
            return redirect()->back();
        }catch (\Exception $exception)
        {
            session()->flash('error',__('messages.flash.failed'));
            return redirect()->back();
        }
    }


}
