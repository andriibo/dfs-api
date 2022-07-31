<?php

namespace App\Repositories;

use App\Models\EmailTemplate;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EmailTemplateRepository
{
    /**
     * @throws ModelNotFoundException
     */
    public function getTeamplateByName(string $name): EmailTemplate
    {
        return EmailTemplate::query()
            ->whereName($name)
            ->firstOrFail()
            ;
    }
}
