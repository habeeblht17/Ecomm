<?php

namespace App\Filament\Resources\ChildCategoryResource\Pages;

use App\Filament\Resources\ChildCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateChildCategory extends CreateRecord
{
    protected static string $resource = ChildCategoryResource::class;

    /**
     * getRedirectUrl
     *
     * @return string
     *
     * Redirect from create page to list or index page.
     */
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}


