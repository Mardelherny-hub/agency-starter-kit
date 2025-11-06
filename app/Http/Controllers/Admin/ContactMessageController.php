<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Contact\Services\ContactMessageCrudService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function __construct(
        protected ContactMessageCrudService $messageCrudService
    ) {
        $this->middleware('permission:messages.view')->only(['index', 'show']);
        $this->middleware('permission:messages.delete')->only('destroy');
    }

    public function index(Request $request)
    {
        $messages = $this->messageCrudService->paginate();
        return view('admin.messages.index', compact('messages'));
    }

    public function show(int $id)
    {
        $message = $this->messageCrudService->findOrFail($id);
        $this->messageCrudService->markAsRead($id);
        return view('admin.messages.show', compact('message'));
    }

    public function destroy(int $id)
    {
        $message = $this->messageCrudService->findOrFail($id);
        $this->messageCrudService->delete($message);
        return redirect()->route('admin.messages.index')->with('success', 'Message deleted successfully.');
    }
}