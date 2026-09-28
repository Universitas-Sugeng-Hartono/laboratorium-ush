<?php

namespace App\Traits;

use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;

trait RejectsDeleteWhenUsed
{
    /**
     * @param  array<string, int>  $usages
     */
    protected function rejectDeleteIfUsed(string $route, array $usages): ?RedirectResponse
    {
        $parts = [];
        foreach ($usages as $label => $count) {
            $count = (int) $count;
            if ($count > 0) {
                $parts[] = $count . ' ' . $label;
            }
        }

        if ($parts === []) {
            return null;
        }

        return redirect()->route($route)->with(
            'error',
            'Data tidak bisa dihapus karena masih dipakai pada ' . implode(', ', $parts) . '.'
        );
    }

    protected function deleteOrReject($model, string $route, string $success): RedirectResponse
    {
        try {
            $model->delete();
        } catch (QueryException $e) {
            return redirect()->route($route)->with(
                'error',
                'Data tidak bisa dihapus karena masih terkait dengan data lain.'
            );
        }

        return redirect()->route($route)->with('success', $success);
    }
}
