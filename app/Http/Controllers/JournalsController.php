<?php

namespace App\Http\Controllers;

use App\Client;
use App\Journal;
use App\Http\Requests\StoreJournalRequest;

class JournalsController extends Controller
{

    public function index(Client $client)
    {
        $this->authorize('view', $client);

        $journals = Journal::all();

        return $journals;
    }

    public function store(Client $client, StoreJournalRequest $request)
    {
        $this->authorize('store', $client);

        $newJournal = $client->journals()->create($request->validated());

        return $newJournal;
    }

    public function destroy(Client $client, Journal $journal)
    {
        $this->authorize('delete', $client);

        $journal->delete();

        return 'Deleted';
    }
}
