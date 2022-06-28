<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;

class ConvertPaginationToCamelCase
{
    /**
     * @throws Exception
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $response = $next($request);

        $preparedContent = json_decode($response->getContent(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Can\'t parse json - ' . json_last_error_msg());
        }

        $keysToReplace = $this->getMetaKeysToReplace();

        foreach ($keysToReplace as $oldKey => $newKey) {
            if (isset($preparedContent['meta'][$oldKey])) {
                $preparedContent['meta'][$newKey] = $preparedContent['meta'][$oldKey];
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
