<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Create default profile if none exists
        if ($user->profile === null) {
            $user->profile = new Profile();
            $user->profile->user_id = $user->user_id;
            $user->profile->current_address = 'N/A';
            $user->profile->permanent_address = 'N/A';
            $user->profile->save();
        }

        return view('user.profile', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = Auth::user();
        
        // Ensure the user can only edit their own profile
        if ($user->user_id != $id) {
            return redirect()->route('user.profile.index')->with('error', 'Unauthorized action.');
        }
        
        if ($user->profile === null) {
            // Create default profile if none exists
            $user->profile = new Profile();
            $user->profile->user_id = $user->user_id;
            $user->profile->save();
        }

        return view('user.edit-profile', compact('user'));
    }
    
    /**
     * Custom edit profile route
     */
    public function editProfile()
    {
        $user = Auth::user();
        if ($user->profile === null) {
            // Create default profile if none exists
            $user->profile = new Profile();
            $user->profile->user_id = $user->user_id;
            $user->profile->save();
        }

        return view('user.edit-profile', compact('user'));
    }


   

    public function update(Request $request, $id)
    {
        // Get authenticated user
        $user = Auth::user();
        
        // Ensure the user can only update their own profile
        if ($user->user_id != $id) {
            return redirect()->route('user.profile.index')->with('error', 'Unauthorized action.');
        }
    
        // Validate the request
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'id_card' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'address' => 'nullable|string|max:500',
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'nullable|in:Male,Female,Other',
            'aadhar' => 'nullable|string|max:12',
            'social_links' => 'nullable|array',
            'social_links.*' => 'nullable|url',
        ]);
    
        try {
            // Update User basic information
            $user->full_name = $request->full_name;
            $user->phone = $request->phone;
            $user->save();
        
            // Update or Create Profile
            $profile = $user->profile;
            
            if (!$profile) {
                $profile = new Profile();
                $profile->user_id = $user->user_id;
            }
            
            // Update profile fields
            $profile->current_address = $request->address ?? $profile->current_address ?? 'N/A';
            $profile->permanent_address = $request->permanent_address ?? $profile->permanent_address;
            $profile->locality = $request->locality ?? $profile->locality;
            $profile->country = $request->country ?? $profile->country;
            $profile->state = $request->state ?? $profile->state;
            $profile->city = $request->city ?? $profile->city;
            $profile->pincode = $request->pincode ?? $profile->pincode;
            $profile->date_of_birth = $request->date_of_birth ?? $profile->date_of_birth;
            $profile->gender = $request->gender ?? $profile->gender;
            $profile->aadhar = $request->aadhar ?? $profile->aadhar;
            $profile->college_name = $request->college ?? $profile->college_name;
            $profile->course = $request->course ?? $profile->course;
            $profile->study_year = $request->study_year ?? $profile->study_year;
            $profile->bio = $request->bio ?? $profile->bio;
        
            // Store social links as JSON (filter out empty values)
            if ($request->has('social_links')) {
                $socialLinks = array_filter($request->social_links, function($value) {
                    return !empty($value) && filter_var($value, FILTER_VALIDATE_URL);
                });
                $profile->social_links = json_encode($socialLinks);
            }
        
            // Avatar upload
            if ($request->hasFile('avatar')) {
                // Delete old avatar if exists
                if ($profile->avatar && $profile->avatar !== 'N/A') {
                    $oldPath = str_replace('storage/', '', $profile->avatar);
                    if (Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }
                
                $avatar = $request->file('avatar');
                $fileName = 'profile_' . $user->user_id . '_' . time() . '.' . $avatar->getClientOriginalExtension();
                $filePath = 'profile_images/' . $fileName;
                $avatar->storeAs('profile_images', $fileName, 'public');
                $profile->avatar = 'storage/' . $filePath;
            }
        
            // ID card upload
            if ($request->hasFile('id_card')) {
                // Delete old ID card if exists
                if ($profile->id_card_url && $profile->id_card_url !== 'N/A') {
                    $oldPath = str_replace('storage/', '', $profile->id_card_url);
                    if (Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }
                
                $idCard = $request->file('id_card');
                $fileName = 'idcard_' . $user->user_id . '_' . time() . '.' . $idCard->getClientOriginalExtension();
                $filePath = 'id_cards/' . $fileName;
                $idCard->storeAs('id_cards', $fileName, 'public');
                $profile->id_card_url = 'storage/' . $filePath;
            }
        
            $profile->save();
        
            return redirect()->route('user.profile.index')->with('success', 'Profile updated successfully!');
            
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update profile: ' . $e->getMessage());
        }
    }
    


    public function updatePassword(Request $request)
    {


        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
            
        ]); 
        

        $userId = Auth::user()->user_id;
        $user = User::find($userId);

        if (Hash::check($request->current_password, $user->password)) {
            $user->password = Hash::make($request->password);
            $user->save();

            return redirect()->route('user.profile.index')->with('success', 'Password updated successfully.');
        } else {
            return back()->withErrors(['error' => 'The current password is incorrect.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
