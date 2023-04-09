<?php

namespace App\Actions\Admin\CMS;

use App\Models\ContactMessage;
use App\Traits\CustomControllerResponsesTrait;
use App\Traits\ThemesTrait;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class ContactMessagesDelete
{
    use AsAction;
    use ThemesTrait;
    use CustomControllerResponsesTrait;

    public function asController(Request $request, $id)
    {
        $item = ContactMessage::findOrFail($id);
        $resp = $item->delete();

        return $this->respJuicer($resp);
    }
}
