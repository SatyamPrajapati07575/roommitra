<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Optimize query
        $complaints = Complaint::with('user:user_id,full_name')
            ->select('id', 'user_id', 'subject', 'description', 'status', 'user_type', 'created_at')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        $total = Complaint::count();
        $pending = Complaint::where('status', 'pending')->count();
        $inprogress = Complaint::where('status', 'in_progress')->count();
        $resolved = Complaint::where('status', 'resolved')->count();
        
        return view('admin.complaints', compact('complaints', 'total', 'pending', 'inprogress', 'resolved'));
    }

    public function show(Request $request, $id)
    {
        $complaint = Complaint::findOrFail($id);

        $attachments = [];

        if ($complaint->attachment) {
            $paths = json_decode($complaint->attachment, true); // array ban gaya
            foreach ($paths as $path) {
                $attachments[] = asset('storage/' . $path);
            }
        }

        return response()->json([
            'id' => $complaint->id,
            'subject' => $complaint->subject,
            'description' => $complaint->description,
            'name' => $complaint->name,
            'email' => $complaint->email,
            'user_type' => $complaint->user_type,
            'attachments' => $attachments, 
        ]);
    }

    public function resolve($id)
    {
        $complaint = Complaint::findOrFail($id);
        $complaint->status = 'Resolved';
        $complaint->save();

        return response()->json([
            'message' => 'Complaint marked as resolved.',
            'status' => 'success',
        ]);
    }
    public function destroy($id)
    {
        $complaint = Complaint::findOrFail($id);
        $complaint->delete();
        return response()->json([
            'message' => 'Complaint deleted successfully.',
            'status' => 'success',
        ]);
    }


}
