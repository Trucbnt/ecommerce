<?php

namespace App\Services\Interfaces\Attribute;

interface AttributeCatalogueServiceInterface
{
    public function paginate();
    public function create();
    public function update($id);
    public function destroy($id);
    public function updateStatus();
    public function updateStatusMultiple();
}
