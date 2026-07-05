<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    public function index(Request $request)
    {
        $query = User::role('Alumni')
            ->whereDoesntHave('roles', function ($q) {
                $q->where('name', 'Super Admin');
            })
            ->with([
            'jobProfile',
            'educations',
            'experiences',
            'achievements',
            'connect',
        ]);

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhereHas('jobProfile', function ($q) use ($search) {
                        $q->where('job_title', 'like', "%{$search}%")
                          ->orWhere('company_name', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->has('year_from') && $request->has('year_to')) {
            $query->whereBetween('passing_year', [(int) $request->year_from, (int) $request->year_to]);
        }

        $perPage = $request->per_page ?? 8;
        $users = $query->orderBy('name')->paginate($perPage);

        $data = collect($users->items())->map(fn ($user) => $this->mapAlumni($user));

        return response()->json([
            'success' => true,
            'data' => $data,
            'meta' => [
                'current_page' => $users->currentPage(),
                'last_page' => $users->lastPage(),
                'per_page' => $users->perPage(),
                'total' => $users->total(),
            ],
        ]);
    }

    public function stats()
    {
        $users = User::role('Alumni')
            ->whereDoesntHave('roles', function ($q) {
                $q->where('name', 'Super Admin');
            })
            ->with('jobProfile', 'connect')->get();

        $companies = collect($users->filter(fn ($u) => $u->jobProfile && $u->jobProfile->company_name))
            ->pluck('jobProfile.company_name')
            ->unique()
            ->count();

        return response()->json([
            'success' => true,
            'data' => [
                'total' => $users->count(),
                'companies' => $companies,
            ],
        ]);
    }

    public function show($id)
    {
        $user = User::role('Alumni')
            ->whereDoesntHave('roles', function ($q) {
                $q->where('name', 'Super Admin');
            })
            ->with([
            'jobProfile',
            'educations',
            'experiences',
            'achievements',
            'connect',
        ])->find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Alumni not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $this->mapAlumni($user),
        ]);
    }

    private function mapAlumni($user)
    {
        $jobProfile = $user->jobProfile;

        $experiences = $user->experiences->map(function ($exp) {
            $period = $exp->start_year;
            if ($exp->currently_working) {
                $period .= ' – Present';
            } elseif ($exp->end_year) {
                $period .= " – {$exp->end_year}";
            }
            return [
                'role' => $exp->job_title,
                'company' => $exp->company,
                'period' => $period,
                'description' => $exp->description ?? '',
            ];
        });

        $educations = $user->educations->map(function ($edu) {
            $year = $edu->end_year ?? $edu->start_year;
            return [
                'degree' => $edu->degree,
                'institution' => $edu->institution,
                'year' => (string) $year,
            ];
        });

        $achievements = $user->achievements->pluck('title');

        $connect = $user->connect;

        $avatar = '';
        if ($user->image) {
            $avatar = url('storage/' . $user->image);
        }

        return [
            'id' => $user->id,
            'name' => $user->name,
            'year' => (string) $user->passing_year,
            'role' => $jobProfile->job_title ?? '',
            'company' => $jobProfile->company_name ?? $user->organization ?? '',
            'location' => '',
            'avatar' => $avatar,
            'bio' => $user->bio ?? '',
            'education' => $educations,
            'experience' => $experiences,
            'achievements' => $achievements,
            'social' => [
                'linkedin' => '',
                'twitter' => '',
                'email' => $connect->email ?? $user->email,
                'phone' => $connect->phone ?? '',
                'instagram' => $connect->instagram ?? '',
                'facebook' => $connect->facebook ?? '',
            ],
        ];
    }
}
