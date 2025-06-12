<?php

namespace Modules\NumberingScheme\Controllers;

use Modules\Common\Controllers\Controller;
use Modules\NumberingScheme\Actions\CreateNumberingSchemeAction;
use Modules\NumberingScheme\Actions\DeleteNumberingSchemeAction;
use Modules\NumberingScheme\Actions\UpdateNumberingSchemeAction;
use Modules\NumberingScheme\Data\CreateNumberingSchemeData;
use Modules\NumberingScheme\Data\NumberingSchemeResourceData;
use Modules\NumberingScheme\Data\UpdateNumberingSchemeData;
use Modules\NumberingScheme\Models\NumberingScheme;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Modules\NumberingScheme\Authorization\NumberingSchemeAuthorization;

class NumberingSchemeController extends Controller
{
    protected NumberingSchemeAuthorization $numberingSchemeAuthorization;

    protected CreateNumberingSchemeAction $createNumberingSchemeAction;

    protected UpdateNumberingSchemeAction $updateNumberingSchemeAction;

    protected DeleteNumberingSchemeAction $deleteNumberingSchemeAction;

    public function __construct(
        CreateNumberingSchemeAction $createNumberingSchemeAction,
        UpdateNumberingSchemeAction $updateNumberingSchemeAction,
        DeleteNumberingSchemeAction $deleteNumberingSchemeAction,
        NumberingSchemeAuthorization $numberingSchemeAuthorization
    ) {
        $this->createNumberingSchemeAction = $createNumberingSchemeAction;
        $this->updateNumberingSchemeAction = $updateNumberingSchemeAction;
        $this->deleteNumberingSchemeAction = $deleteNumberingSchemeAction;
        $this->numberingSchemeAuthorization = $numberingSchemeAuthorization;
    }

    public function index(Request $request)
    {
        $this->numberingSchemeAuthorization->canView($request->user());

        $search = $request->input('search');

        $numberingSchemes = NumberingScheme::query()
            ->when($search, function ($query, $search) {
                $searchableColumns = ['name'];

                $query->where(function ($query) use ($search, $searchableColumns) {
                    foreach ($searchableColumns as $column) {
                        $query->orWhere($column, 'like', "%{$search}%");
                    }
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('NumberingScheme', [
            'numberingSchemes' => NumberingSchemeResourceData::collect($numberingSchemes),
            'filters' => $request->only(['search']),
        ]);
    }

    public function store(CreateNumberingSchemeData $data): RedirectResponse
    {
        $this->numberingSchemeAuthorization->canCreate(Auth::user());

        $this->createNumberingSchemeAction->execute($data);

        return redirect()->back();
    }

    public function update(UpdateNumberingSchemeData $data, NumberingScheme $numberingScheme): RedirectResponse
    {
        $this->numberingSchemeAuthorization->canUpdate(Auth::user(), $numberingScheme);

        $this->updateNumberingSchemeAction->execute($numberingScheme, $data);

        return redirect()->back();
    }

    public function destroy(NumberingScheme $numberingScheme): RedirectResponse
    {
        $this->numberingSchemeAuthorization->canDelete(Auth::user(), $numberingScheme);

        $this->deleteNumberingSchemeAction->execute($numberingScheme);

        return redirect()->back();
    }


    public function getNumberingSchemeOfFolder(NumberingScheme $numberingScheme): JsonResponse
    {
        return response()->json($numberingScheme);
    }
}
