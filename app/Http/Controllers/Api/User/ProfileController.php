<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileEducationRequest;
use App\Http\Requests\ProfileExperienceRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\ProfileContactRequest;
use App\Http\Requests\ProfileAchievementRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function profile()
    {
        $user = User::with(['jobProfile', 'educations'])->find(auth()->id());

        return response()->json($user);
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = auth()->user();

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images', 'public');
        }

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'gender' => $validated['gender'] ?? $user->gender,
            'student_id' => $validated['student_id'] ?? $user->student_id,
            'passing_year' => $validated['passing_year'] ?? $user->passing_year,
            'department' => $validated['department'] ?? $user->department,
            'image' => $validated['image'] ?? $user->image,
            'bio' => $validated['bio'] ?? $user->bio,
        ]);

        $user->jobProfile()->updateOrCreate(
            ['user_id' => $user->id],
            array_filter([
                'job_title' => $validated['job_title'] ?? null,
                'company_name' => $validated['company_name'] ?? null,
                'employment_type' => $validated['employment_type'] ?? null,
                'start_date' => $validated['start_date'] ?? null,
                'currently_working' => $validated['currently_working'] ?? false,
                'job_description' => $validated['job_description'] ?? null,
            ], fn ($v) => ! is_null($v))
        );

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully!',
        ]);
    }

    // Education
    public function education(ProfileEducationRequest $request)
    {
        $user = Auth::user();
        $user->educations()->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Education details updated successfully!',
        ]);
    }

    public function getEducation()
    {
        $user = Auth::user();
        $education = $user->educations()->get();

        return response()->json([
            'success' => true,
            'data' => $education,
        ]);
    }

    public function updateEducation($id, ProfileEducationRequest $request)
    {
        $user = Auth::user();
        $education = $user->educations()->findOrFail($id);
        $education->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Education updated successfully!',
        ]);
    }

    public function deleteEducation($id)
    {
        $user = Auth::user();
        $education = $user->educations()->findOrFail($id);
        $education->delete();

        return response()->json([
            'success' => true,
            'message' => 'Education deleted successfully!',
        ]);
    }

    // Experience
    public function experience(ProfileExperienceRequest $request)
    {
        $user = Auth::user();
        $user->experiences()->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Experience details updated successfully!',
        ]);
    }

    public function getExperience()
    {
        $user = Auth::user();
        $experience = $user->experiences()->get();

        return response()->json([
            'success' => true,
            'data' => $experience,
        ]);
    }

    public function updateExperience($id, ProfileExperienceRequest $request)
    {
        $user = Auth::user();
        $experience = $user->experiences()->findOrFail($id);
        $experience->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Experience updated successfully!',
        ]);
    }

    public function deleteExperience($id)
    {
        $user = Auth::user();
        $experience = $user->experiences()->findOrFail($id);
        $experience->delete();

        return response()->json([
            'success' => true,
            'message' => 'Experience deleted successfully!',
        ]);
    }

    // Achivement
    public function achievements(ProfileAchievementRequest $request)
    {
        $user = Auth::user();
        $user->achievements()->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Achievement details updated successfully!',
        ]);

    }

    public function getAchievements()
    {
        $user = Auth::user();
        $achievements = $user->achievements()->get();

        return response()->json([
            'success' => true,
            'data' => $achievements,
        ]);
    }

    public function updateAchievements($id, ProfileAchievementRequest $request)
    {
        $user = Auth::user();
        $achievement = $user->achievements()->findOrFail($id);
        $achievement->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Achievement updated successfully!',
        ]);
    }

    public function deleteAchievements($id)
    {
        $user = Auth::user();
        $achievement = $user->achievements()->findOrFail($id);
        $achievement->delete();

        return response()->json([
            'success' => true,
            'message' => 'Achievement deleted successfully!',
        ]);
    }

    // Contact
    public function contact(ProfileContactRequest $request)
    {
        $user = Auth::user();
        $user->connect()->updateOrCreate(
            ['user_id' => $user->id],
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' => 'Contact details updated successfully!',
        ]);
    }
    public function getContact()
    {
        $user = Auth::user();
        $contact = $user->connect()->first();

        return response()->json([
            'success' => true,
            'data' => $contact,
        ]);
    }

    public function updateContact(ProfileContactRequest $request,$id)
    {
        $user = Auth::user();
        $contact = $user->connect()->first();
        if ($contact) {
            $contact->update($request->validated());
        } else {
            $user->connect()->create($request->validated());
        }

        return response()->json([
            'success' => true,
            'message' => 'Contact details updated successfully!',
        ]);
    }
    public function deleteContact($id)
    {
        $user = Auth::user();
        $contact = $user->connect()->first();
        if ($contact) {
            $contact->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Contact details deleted successfully!',
        ]);
    }
}
