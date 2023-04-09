<?php

namespace App\Actions\Admin\Cms;

use App\Http\Resources\ContactMessageResourceCollection;
use App\Models\ContactMessage;
use App\Traits\CustomControllerResponsesTrait;
use App\Traits\ThemesTrait;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class ContactMessages
{
    use AsAction;
    use ThemesTrait;
    use CustomControllerResponsesTrait;

    public function asController(Request $request)
    {
        $messages = ContactMessage::paginate(pagination('s'));

        ContactMessage::whereIn('id', $messages->whereNull('last_read_at')->pluck('id')->toArray())
            ->update([
                'last_read_at' => now()
            ]);

        $data = new ContactMessageResourceCollection($messages->fresh());

        return $request->wantsJson()
            ? $data
            : $this->generateBackendPage('Cms/ContactMessages', [
                'messages' => $data,
            ]);

    }
}
