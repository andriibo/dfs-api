<?php

namespace App\Repositories;

use App\Models\StaticPage;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class StaticPageRepository
{
    /**
     * @throws ModelNotFoundException
     */
    public function getStaticPageByName(string $name): StaticPage
    {
        return StaticPage::query()
            ->whereName($name)
            ->firstOrFail()
            ;
    }
}
