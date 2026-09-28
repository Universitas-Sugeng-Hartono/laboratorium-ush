<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuditLog extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'user_name',
        'user_role',
        'action',
        'module',
        'record_id',
        'record_label',
        'description',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
        'created_at',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'created_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Helper to manually record an audit log entry.
     */
    public static function record(array $data)
    {
        $user = Auth::user();

        return static::create([
            'user_id'      => $data['user_id'] ?? ($user ? $user->id : null),
            'user_name'    => $data['user_name'] ?? ($user ? $user->name : (session('siakad_user_name') ?? 'Sistem / Tamu')),
            'user_role'    => $data['user_role'] ?? ($user ? $user->role : 'guest'),
            'action'       => strtoupper($data['action'] ?? 'ACTIVITY'),
            'module'       => $data['module'] ?? 'Umum',
            'record_id'    => isset($data['record_id']) ? (string)$data['record_id'] : null,
            'record_label' => $data['record_label'] ?? null,
            'description'  => $data['description'] ?? null,
            'old_values'   => $data['old_values'] ?? null,
            'new_values'   => $data['new_values'] ?? null,
            'ip_address'   => $data['ip_address'] ?? Request::ip(),
            'user_agent'   => $data['user_agent'] ?? substr(Request::userAgent() ?? '', 0, 500),
            'created_at'   => $data['created_at'] ?? now(),
        ]);
    }

    /**
     * Scope for comprehensive filtering
     */
    public function scopeFilter($query, $request)
    {
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sq) use ($q) {
                $sq->where('description', 'like', "%{$q}%")
                   ->orWhere('record_label', 'like', "%{$q}%")
                   ->orWhere('user_name', 'like', "%{$q}%")
                   ->orWhere('ip_address', 'like', "%{$q}%");
            });
        }

        if ($request->filled('module')) {
            $query->where('module', $request->module);
        }

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        return $query;
    }
}
