<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNotificationRequest;
use App\Notifications\PushFacadesNotification;
use App\Notifications\PushNotifyNotification;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Notification as FacadesNotification;

class NotificationController extends Controller
{
    public function create(StoreNotificationRequest $request)
    {
        $validated = $request->validated();
        $validated['type'] = '\\App\\Notifications\\CreateNotification';
        $validated['notifiable_type'] = \App\Models\User::class;
        $validated['notifiable_id'] = $validated['id'];
        DatabaseNotification::create($validated);

        return $this->index();
    }

    public function facade(StoreNotificationRequest $request)
    {
        $validated = $request->validated();
        $user = \App\Models\User::find($validated['id']);

        FacadesNotification::send($user, new PushFacadesNotification($validated));

        return $this->index();
    }

    public function notify(StoreNotificationRequest $request)
    {
        $validated = $request->validated();
        $user = \App\Models\User::find($validated['id']);

        $user->notify(new PushNotifyNotification($validated));

        return $this->index();
    }

    public function index()
    {
        return response()->json(DatabaseNotification::all());
    }
}
