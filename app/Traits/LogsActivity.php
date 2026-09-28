<?php

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

trait LogsActivity
{
    /**
     * Boot the trait and register Eloquent model event listeners.
     */
    public static function bootLogsActivity()
    {
        static::created(function ($model) {
            $model->recordAuditActivity('CREATE');
        });

        static::updated(function ($model) {
            $model->recordAuditActivity('UPDATE');
        });

        static::deleted(function ($model) {
            $model->recordAuditActivity('DELETE');
        });
    }

    /**
     * Record an audit log for this model event.
     */
    protected function recordAuditActivity(string $action)
    {
        // Don't log if explicitly silenced
        if (property_exists($this, 'silenceAudit') && $this->silenceAudit) {
            return;
        }

        $module = class_basename($this);
        $label = $this->getAuditRecordLabel();
        $oldValues = null;
        $newValues = null;

        if ($action === 'CREATE') {
            $newValues = $this->getAuditFilteredAttributes($this->getAttributes());
            $description = "Menambahkan {$module} baru: {$label}";
        } elseif ($action === 'UPDATE') {
            $dirty = $this->getDirty();
            // Remove ignored fields
            unset($dirty['updated_at'], $dirty['remember_token']);

            if (empty($dirty)) {
                return; // Nothing meaningful changed
            }

            $old = [];
            $new = [];
            foreach ($dirty as $key => $val) {
                $old[$key] = $this->getOriginal($key);
                $new[$key] = $val;
            }

            $oldValues = $this->getAuditFilteredAttributes($old);
            $newValues = $this->getAuditFilteredAttributes($new);
            $changedFields = implode(', ', array_keys($dirty));
            $description = "Memperbarui {$module} [{$label}] pada field: {$changedFields}";
        } elseif ($action === 'DELETE') {
            $oldValues = $this->getAuditFilteredAttributes($this->getOriginal());
            $description = "Menghapus {$module}: {$label}";
        } else {
            $description = "Aktivitas {$action} pada {$module}: {$label}";
        }

        try {
            $user = Auth::user();
            AuditLog::create([
                'user_id'      => $user ? $user->id : null,
                'user_name'    => $user ? $user->name : (session('siakad_user_name') ?? 'Sistem / Tamu'),
                'user_role'    => $user ? $user->role : 'guest',
                'action'       => $action,
                'module'       => $module,
                'record_id'    => (string)$this->getKey(),
                'record_label' => $label,
                'description'  => $description,
                'old_values'   => $oldValues,
                'new_values'   => $newValues,
                'ip_address'   => Request::ip() ?? '127.0.0.1',
                'user_agent'   => substr(Request::userAgent() ?? 'System', 0, 500),
                'created_at'   => now(),
            ]);
        } catch (\Throwable $e) {
            // Silently catch to avoid breaking core business logic if logging encounters issues
            report($e);
        }
    }

    /**
     * Filter out sensitive attributes from audit storage.
     */
    protected function getAuditFilteredAttributes(array $attributes): array
    {
        $hidden = array_merge(
            $this->getHidden(),
            ['password', 'remember_token', 'token', 'ttd'] // ttd can be very long base64
        );

        foreach ($hidden as $field) {
            if (isset($attributes[$field])) {
                $attributes[$field] = '[DISIMPAN / TERLINDUNGI]';
            }
        }

        return $attributes;
    }

    /**
     * Get a representative human-readable title for this model record.
     */
    public function getAuditRecordLabel(): string
    {
        if (method_exists($this, 'customAuditLabel')) {
            return $this->customAuditLabel();
        }

        if (!empty($this->alat)) return (string)$this->alat;
        if (!empty($this->bahan)) return (string)$this->bahan;
        if (!empty($this->nama)) return (string)$this->nama;
        if (!empty($this->tamu)) return (string)$this->tamu;
        if (!empty($this->matakuliah)) return (string)$this->matakuliah;
        if (!empty($this->laboratorium)) return (string)$this->laboratorium;
        if (!empty($this->program)) return (string)$this->program;
        if (!empty($this->ta)) return (string)$this->ta;
        if (!empty($this->jadwal)) return 'Jadwal: ' . (string)$this->jadwal;

        return '#' . $this->getKey();
    }
}
