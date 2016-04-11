<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateNotesRequest;
use App\Http\Requests\UpdateNotesRequest;
use App\Repositories\NotesRepository;
use Illuminate\Http\Request;
use Flash;
use InfyOm\Generator\Controller\AppBaseController;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class NotesController extends AppBaseController
{
    /** @var  NotesRepository */
    private $notesRepository;

    public function __construct(NotesRepository $notesRepo)
    {
        $this->middleware('auth');
        $this->notesRepository = $notesRepo;
    }

    /**
     * Display a listing of the Notes.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->notesRepository->pushCriteria(new RequestCriteria($request));
        $notes = $this->notesRepository->all();

        return view('notes.index')
            ->with('notes', $notes);
    }

    /**
     * Show the form for creating a new Notes.
     *
     * @return Response
     */
    public function create()
    {
        return view('notes.create');
    }

    /**
     * Store a newly created Notes in storage.
     *
     * @param CreateNotesRequest $request
     *
     * @return Response
     */
    public function store(CreateNotesRequest $request)
    {
        $input = $request->all();

        $notes = $this->notesRepository->create($input);

        Flash::success('Notes saved successfully.');

        return redirect(route('notes.index'));
    }

    /**
     * Display the specified Notes.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $notes = $this->notesRepository->findWithoutFail($id);

        if (empty($notes)) {
            Flash::error('Notes not found');

            return redirect(route('notes.index'));
        }

        return view('notes.show')->with('notes', $notes);
    }

    /**
     * Show the form for editing the specified Notes.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $notes = $this->notesRepository->findWithoutFail($id);

        if (empty($notes)) {
            Flash::error('Notes not found');

            return redirect(route('notes.index'));
        }

        return view('notes.edit')->with('notes', $notes);
    }

    /**
     * Update the specified Notes in storage.
     *
     * @param  int              $id
     * @param UpdateNotesRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateNotesRequest $request)
    {
        $notes = $this->notesRepository->findWithoutFail($id);

        if (empty($notes)) {
            Flash::error('Notes not found');

            return redirect(route('notes.index'));
        }

        $notes = $this->notesRepository->update($request->all(), $id);

        Flash::success('Notes updated successfully.');

        return redirect(route('notes.index'));
    }

    /**
     * Remove the specified Notes from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $notes = $this->notesRepository->findWithoutFail($id);

        if (empty($notes)) {
            Flash::error('Notes not found');

            return redirect(route('notes.index'));
        }

        $this->notesRepository->delete($id);

        Flash::success('Notes deleted successfully.');

        return redirect(route('notes.index'));
    }
}
