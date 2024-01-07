<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Translaton\StoreTranslationRequest;
use App\Http\Requests\Translaton\UpdateTranslationRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Translation;
use App\Http\Controllers\Controller;

class TranslationController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Translation::class, 'translation');
    }

    public function index(Request $request): \Inertia\Response
    {
        return Inertia::render('Translation/Index', [
            'translations' => Translation::where('language', $request->get('language', 'en'))->get(),
            'language'     => $request->get('language', 'en'),
        ]);
    }

    public function store(StoreTranslationRequest $request): RedirectResponse
    {
        Translation::create($request->validated());

        $request->session()->flash('message', [
            'type'    => 'success', // error, success, info
            'message' => __('Translation has been created.')
        ]);

        return redirect()->route('translations.index');
    }

    public function update(UpdateTranslationRequest $request, Translation $translation): RedirectResponse
    {
        $translation->key      = $request->input('key');
        $translation->value    = $request->input('value');
        $translation->language = $request->input('language');

        $translation->save();

        $request->session()->flash('message', [
            'type'    => 'success', // error, success, info
            'message' => __('Translation has been updated.')
        ]);

        return redirect()->route('translations.index');
    }

    public function destroy(Request $request, Translation $translation): RedirectResponse
    {
        $translation->delete();

        $request->session()->flash('message', [
            'type'    => 'success', // error, success, info
            'message' => __('Translation has been deleted.')
        ]);

        return redirect()->route('translations.index');
    }

    public function massDestroy(Request $request): RedirectResponse
    {
        $this->authorize('delete', Translation::class);

        Translation::whereIn('id', collect($request->input('translations'))->pluck('id'))->delete();

        $request->session()->flash('message', [
            'type'    => 'success', // error, success, info
            'message' => __('Translation has been deleted.')
        ]);

        return redirect()->route('translations.index');
    }
}
