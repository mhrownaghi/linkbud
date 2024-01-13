<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;

class LinkListsController extends Controller
{
    public function store()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        /** @var \App\Models\LinkList $linkList */
        $linkList = $user->addLinkList($this->requestValidate());

        foreach (request('links') as $link) {
            $linkList->addLink($link);
        }

        return redirect("/{$user->username}/".request('slug'));
    }

    public function create()
    {
        return inertia('LinkLists/Create');
    }

    private function requestValidate()
    {
        return request()->validate([
            'name' => 'required',
            'description' => 'nullable|min:3',
            'slug' => [
                'required',
                'alpha_dash',
                Rule::unique('link_lists')
                    ->where('owner_id', auth()->id()),
            ],
            'links.*.name' => 'required',
            'links.*.url' => 'required|url',
            'links.*.order' => 'required|between:1,10',
        ]);
    }
}
