<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class StaffRequestController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | STAFF MANAGEMENT
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $search = trim(
            (string) $request->input('search')
        );

        $status = $request->input('status');


        /*
        |--------------------------------------------------------------------------
        | STAFF QUERY
        |--------------------------------------------------------------------------
        */

        $query = User::query()
            ->where('role', 'staff');


        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        if ($search !== '') {
            $query->where(function ($q) use ($search) {

                $q->where(
                    'name',
                    'like',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'email',
                    'like',
                    '%' . $search . '%'
                );
            });
        }


        /*
        |--------------------------------------------------------------------------
        | STATUS FILTER
        |--------------------------------------------------------------------------
        */

        $allowedStatuses = [
            'pending',
            'approved',
            'rejected',
            'suspended',
        ];

        if (
            $status !== null &&
            in_array(
                $status,
                $allowedStatuses,
                true
            )
        ) {
            $query->where(
                'staff_status',
                $status
            );
        }


        /*
        |--------------------------------------------------------------------------
        | STAFF LIST
        |--------------------------------------------------------------------------
        */

        $staff = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | STAFF COUNTS
        |--------------------------------------------------------------------------
        */

        $pendingStaff = User::where(
            'role',
            'staff'
        )
            ->where(
                'staff_status',
                'pending'
            )
            ->count();

        $approvedStaff = User::where(
            'role',
            'staff'
        )
            ->where(
                'staff_status',
                'approved'
            )
            ->count();

        $suspendedStaff = User::where(
            'role',
            'staff'
        )
            ->where(
                'staff_status',
                'suspended'
            )
            ->count();

        $rejectedStaff = User::where(
            'role',
            'staff'
        )
            ->where(
                'staff_status',
                'rejected'
            )
            ->count();


        return view(
            'admin.staff-requests.index',
            compact(
                'staff',
                'pendingStaff',
                'approvedStaff',
                'suspendedStaff',
                'rejectedStaff',
                'search',
                'status'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | APPROVE STAFF
    |--------------------------------------------------------------------------
    */

    public function approve($id)
    {
        $staff = User::where(
            'id',
            $id
        )
            ->where(
                'role',
                'staff'
            )
            ->firstOrFail();


        $staff->update([
            'staff_status' => 'approved',
        ]);


        return back()->with(
            'success',
            $staff->name .
            '\'s staff account has been approved.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | REJECT STAFF
    |--------------------------------------------------------------------------
    */

    public function reject($id)
    {
        $staff = User::where(
            'id',
            $id
        )
            ->where(
                'role',
                'staff'
            )
            ->firstOrFail();


        $staff->update([
            'staff_status' => 'rejected',
        ]);


        return back()->with(
            'success',
            $staff->name .
            '\'s staff application has been rejected.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SUSPEND STAFF
    |--------------------------------------------------------------------------
    */

    public function suspend($id)
    {
        $staff = User::where(
            'id',
            $id
        )
            ->where(
                'role',
                'staff'
            )
            ->firstOrFail();


        $staff->update([
            'staff_status' => 'suspended',
        ]);


        return back()->with(
            'success',
            $staff->name .
            ' has been suspended.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | REACTIVATE STAFF
    |--------------------------------------------------------------------------
    */

    public function reactivate($id)
    {
        $staff = User::where(
            'id',
            $id
        )
            ->where(
                'role',
                'staff'
            )
            ->firstOrFail();


        $staff->update([
            'staff_status' => 'approved',
        ]);


        return back()->with(
            'success',
            $staff->name .
            ' has been reactivated.'
        );
    }
}

