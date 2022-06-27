<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ConvertPaginationToCamelCase
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $preparedContent = json_decode($response->getContent(), true);

        $keysToReplace = $this->getMetaKeysToReplace();

        foreach ($keysToReplace as $oldKey => $newKey) {
            $itemToReplace = $preparedContent['meta'][$oldKey];
            if (isset($itemToReplace)) {
                $preparedContent['meta'][$newKey] = $itemToReplace;
                unset($preparedContent['meta'][$oldKey]);
            }
        }

        $response->setContent(json_encode($preparedContent));

        return $response;
    }

    private function getMetaKeysToReplace(): array
    {
        return [
            'current_page' => 'currentPage',
            'last_page' => 'lastPage',
            'per_page' => 'perPage',
        ];
    }
}
