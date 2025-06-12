<?php

namespace Modules\Archive\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Modules\Common\Controllers\Controller;
use Modules\Archive\Actions\GetArchiveDataAction;
use Modules\Archive\Actions\UnarchiveItemsAction;
use Modules\Folder\Models\Folder;
use Modules\Item\Models\Item;

class ArchiveController extends Controller
{
    protected GetArchiveDataAction $getArchiveDataAction;
    protected UnarchiveItemsAction $unarchiveItemsAction;

    public function __construct(GetArchiveDataAction $getArchiveDataAction, UnarchiveItemsAction $unarchiveItemsAction)
    {
        $this->getArchiveDataAction = $getArchiveDataAction;
        $this->unarchiveItemsAction = $unarchiveItemsAction;
    }

    public function show(string $folderUuid = null)
    {
        $folder = null;
        if ($folderUuid) {
            $folder = Folder::where('item_id', $folderUuid)->firstOrFail();
        }

        $data = $this->getArchiveDataAction->execute($folder);

        return Inertia::render('Archive', $data);
    }

    public function unarchive(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'string|exists:items,id',
        ]);

        $ids = $request->input('ids');

        $result = $this->unarchiveItemsAction->execute($ids);

        if ($result) {
            return redirect()->back()->with('success', 'Items unarchived successfully.');
        }

        return redirect()->back()->with('error', 'Failed to unarchive items.');
    }
}
